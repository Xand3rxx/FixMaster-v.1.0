<?php

namespace App\PaymentProcessor;


use App\Models\Payment;
use Illuminate\Support\Facades\Http;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class FlutterwavePayment
{
    const STATUS = 'success';
    /**
     * Flutterwave API base Url
     * @var string
     */
    protected $baseUrl;

    /**
     * Secret Key for Flutterwave Request
     * @var string
     */
    protected $secretKey;

    /**
     * Public Key for Flutterwave Request
     * @var string
     */
    public $publicKey;


    /**
     * Handle Job Acceptance from a Service Request Assignee
     *
     * @return void
     */
    public function __construct()
    {
        $this->setKey();
        $this->setBaseUrl();
    }

    /**
     * Get secret key from PaymentGateway for Flutterwave
     */
    protected function setKey()
    {
        $paymentGateway = \App\Models\PaymentGateway::where('name', 'flutter')->first();
        $this->secretKey = $paymentGateway['information']['private_key'];
        $this->publicKey = $paymentGateway['information']['public_key'];
    }

    /**
     * Get Base Url from Flutterwave config file
     */
    public function setBaseUrl()
    {
        $this->baseUrl = 'https://api.flutterwave.com/v3/';
    }

    /**
     * Initiate a payment request to Flutterwave
     * @return Flutterwave
     */
    public function makePaymentRequest(Payment $payment)
    {
        $payment->loadMissing('user', 'user.account');

        $url = $this->initPaymentRequest($payment);

        if (!is_null($url)) {
            return redirect($url, 302, [], true);
        }
        return abort('403', 'Error Processing Payment');
    }

    /**
     * True or false condition whether the transaction is verified
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponsew
     */
    public function isTransactionVerificationValid()
    {
        try {
            $verified = $this->verifyTransactionAtGateway();
            if (is_null($verified['verified'])) {
                return back()->with('error', 'User Cancelled Transaction');
            }
            return redirect()->route($verified['payment']['return_route_name'], ['locale' => app()->getLocale(), 'payment' => $verified['payment']]);
        } catch (ModelNotFoundException $th) {
            return back()->with('error', 'Error Finding Payment Reference Record');
        }
    }

    /**
     * Initialize Payment to Flutterwave
     * @params \App\Models\Payment $payment
     * 
     * @return string|null
     */
    protected function initPaymentRequest(Payment $payment)
    {
        $response = Http::withToken($this->secretKey)->retry(2, 100)->post($this->baseUrl . 'payments', [
            'customer' => [
                'name' => $payment['user']['account']['last_name'] . ' ' . $payment['user']['account']['first_name'],
                'email' => $payment['user']['email'],
            ],
            'amount' => $payment->amount,
            'tx_ref' => $payment->reference_id,
            'payment_options' => 'card',
            'currency' => 'NGN',
            'redirect_url' => route('payment.verify.flutterwave', app()->getLocale()),
            'customizations' => [
                'title' => 'Paying for ' . str_replace('_', ' ', $payment['payment_for']),
                'description' => 'FixMaster Payment',
                'logo' => public_path('assets/images/home-fix-logo-new.png')
            ]
        ])->throw()->json();

        if ($response['status'] == self::STATUS) {
            return $response['data']['link'];
        }
        \Illuminate\Support\Facades\Log::alert(request()->user()->id . 'attempted payment using flutterwave got error', [
            'id' => request()->user()->id,
            'ip_address' => request()->ip(),
            'url' => request()->fullUrl(),
            'error' => $response['status']
        ]);
        return null;
    }

    /**
     * Hit Flutterwave Gateway to Verify that the transaction is valid
     */
    protected function verifyTransactionAtGateway()
    {
        $response = Http::withToken($this->secretKey)->retry(2, 100)->get($this->baseUrl . 'transactions/' . request()->get('transaction_id') . '/verify', [])->throw()->json();
        if (is_null($response)) {
            return  ['verified' => null];
        }
        if ($response['message'] == "Transaction fetched successfully") {
            $payment = Payment::where('reference_id', $response['data']['tx_ref'])->firstOrFail();
            $payment->status = $response['data']['status'] == 'successful' ? Payment::STATUS['success'] : Payment::STATUS['failed'];
            $payment->transaction_id = $response['data']['flw_ref'];
            $payment->amount =  $response['data']['amount'];
            $payment->save();
            $response = array_merge($response, ['verified' => true], ['payment' => $payment]);
            return $response;
        }
        return array_merge($response, ['verified' => false]);
    }
}
