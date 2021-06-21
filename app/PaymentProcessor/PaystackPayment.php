<?php

namespace App\PaymentProcessor;

use App\Models\Payment;
use Illuminate\Support\Facades\Http;
use Illuminate\Database\Eloquent\ModelNotFoundException;



class PaystackPayment
{
    /**
     * Paystack API base Url
     * @var string
     */
    protected $baseUrl;

    /**
     * Secret Key for Paystack Request
     * @var string
     */
    protected $secretKey;

    /**
     * Public Key for Paystack Request
     * @var string
     */
    public $publicKey;


    /**
     * Handle Paystack Request
     *
     * @return void
     */
    public function __construct()
    {
        $this->setKey();
        $this->setBaseUrl();
    }

    /**
     * Initiate a payment request to Paystack
     * @params \App\Models\Payment $payment
     * 
     * @return Paystack
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
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function isTransactionVerificationValid()
    {
        try {
            $verified = $this->verifyTransactionAtGateway();
            return redirect()->route($verified['payment']['return_route_name'], ['locale' => app()->getLocale(), 'payment' => $verified['payment']]);
        } catch (ModelNotFoundException $th) {
            return back()->with('error', 'Error Finding Payment Reference Record');
        }
    }


    /**
     * Initialize Payment to paystack
     * @params \App\Models\Payment $payment
     * 
     * @return string|null
     */
    protected function initPaymentRequest(Payment $payment)
    {
        $response = Http::withToken($this->secretKey)->retry(2, 100)->post($this->baseUrl . '/transaction/initialize', [
            'email' => $payment['user']['email'],
            'first_name' => $payment['user']['account']['first_name'] ?? "UNAVAILABLE",
            'last_name' => $payment['user']['account']['last_name'],
            'amount' => $this->calculate($payment->amount),
            'reference' => $payment->reference_id,
            'channels' => ['card'],
            'currency' => 'NGN',
            'key'   => $this->publicKey,
            'label' => $payment['user']['account']['last_name'] . ' ' . $payment['user']['account']['first_name'],
            'callback_url' => route('payment.verify.paystack', app()->getLocale()),
        ])->throw()->json();

        if ($response['status']) {
            return $response['data']['authorization_url'];
        }
        \Illuminate\Support\Facades\Log::alert(request()->user()->id . 'attempted payment using paystack got error', [
            'id' => request()->user()->id,
            'ip_address' => request()->ip(),
            'url' => request()->fullUrl(),
            'error' => $response['status']
        ]);
        return null;
    }

    /**
     * Hit Paystack Gateway to Verify that the transaction is valid
     */
    protected function verifyTransactionAtGateway()
    {
        $response = Http::withToken($this->secretKey)->retry(2, 100)->get($this->baseUrl . '/transaction/verify/' . request()->query('reference'), [])->throw()->json();
        if ($response['message'] == "Verification successful") {
            $payment = Payment::where('reference_id', $response['data']['reference'])->firstOrFail();
            $payment->status = $response['data']['status'];
            $payment->transaction_id = $response['data']['id'];
            $payment->amount =  $response['data']['amount'] / 100;
            $payment->save();
            $response = array_merge($response, ['verified' => true], ['payment' => $payment]);
            return $response;
        }
        return array_merge($response, ['verified' => false]);
    }

    /**
     * Calculate Paystack payment fee to kobo
     * @params int $amount
     * 
     * @return string
     */
    protected function calculate(int $amount)
    {
        return $amount * 100;
    }

    /**
     * Get secret key from PaymentGateway for Paystack
     */
    protected function setKey()
    {
        $paymentGateway = \App\Models\PaymentGateway::where('name', 'paystack')->first();
        $this->secretKey = $paymentGateway['information']['private_key'];
        $this->publicKey = $paymentGateway['information']['public_key'];
    }

    /**
     * Get Base Url from Paystack config file
     */
    protected function setBaseUrl()
    {
        $this->baseUrl = 'https://api.paystack.co';
    }
}
