<?php
namespace App\PaymentProcessor;


use App\Models\Payment;

class FlutterwavePayment
{
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
        dd($this->secretKey, $this->baseUrl, $payment, 'flutterwave');
    }


}
