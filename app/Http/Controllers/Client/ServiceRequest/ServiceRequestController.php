<?php

namespace App\Http\Controllers\Client\ServiceRequest;

use Carbon\Carbon;
use App\Models\Payment;
use App\Models\Service;
use App\Traits\Services;
use Illuminate\Http\Request;
use App\Models\PaymentGateway;
use App\Models\ServiceRequest;
use App\Http\Controllers\Controller;

class ServiceRequestController extends Controller
{
    use Services;
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        /**
         * fields to be validated.
         *
         * booking fee, required
         * scheduled date, [optional, cannot be less than today's date]
         * media files, optional
         * contact id, required
         * description, required
         * contact me, required
         * payment for, required
         * payment option, [required, In: ewallet, payment gateway]
         * payment gateway, [required, In: flutterwave, paystack]
         * discount, optional
         */

        //  Validate Request
        (array) $valid = $request->validate([
            'service_uuid'              => 'bail|sometimes|uuid|exists:services,uuid', // Handle service of custom to 
            'payment_for'               => ['bail', 'required', 'string', \Illuminate\Validation\Rule::in(Payment::PAYMENT_FOR)],
            'price_id'                  => 'bail|required|integer',
            'description'               => 'bail|required|string',
            'preferred_time'            => 'bail|sometimes',
            'payment_channel'           => ['bail', 'required', 'string', \Illuminate\Validation\Rule::in(Payment::PAYMENT_CHANNEL)],
            'contactme_status'          => 'bail|required|boolean',
            'client_discount_id'        => 'bail|sometimes|integer',
            'media_file'                => 'bail|sometimes|array',
            'media_file.*'              => 'bail|sometimes|file',
            'contact_id'                => 'bail|required|integer|exists:contacts,id'
        ]);
        // Check for media files
        if (!empty($valid['media_file'])) {
            (array) $files = $this->handle_media_files($valid['media_file']);
            $valid['media_file'] = $files;
        }
        $payment = [
            'amount' => \App\Models\Price::where('id', $valid['price_id'])->first()->amount,
            'payment_channel' => $valid['payment_channel'],
            'payment_for' => $valid['payment_for'],
            'unique_id' => \App\Traits\GenerateUniqueIdentity::generate('service_requests', 'REF-'),
            'return_route_name' => 'client.service_request.init',
            'meta_data' => $valid
        ];
        // Transfer to Concerns
        return \App\PaymentProcessor\Concerns\PaymentHandler::redirectToGateway($payment);
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $locale
     * @param  \App\Models\Payment  $payment
     * 
     * @return \Illuminate\Http\Response
     */
    public function init($locale, Payment $payment)
    {
        // Verify Payment status
        if ($payment['status'] = Payment::STATUS['success']) {

            //Check if the request is custom
            if(!empty($payment['meta_data']['service_uuid'])){
                $service = \App\Models\Service::where('uuid', $payment['meta_data']['service_uuid'])->first();
            }else{
                $service = \App\Models\Service::where('id', '28')->withTrashed()->first();
            }

            $service_request = ServiceRequest::create([
                'unique_id' => $payment['unique_id'],
                'service_id' => $service['id'],
                'client_id' => request()->user()->id,
                'client_discount_id' => $payment['meta_data']['client_discount_id'] ?? NULL,  //To be Confirmed from Rade and Joyboy
                'preferred_time' => $payment['meta_data']['preferred_time'] ?? NULL,
                'contactme_status' => $payment['meta_data']['contactme_status'],
                'contact_id' => $payment['meta_data']['contact_id'],
                'description' => $payment['meta_data']['description'],
                'price_id' => $payment['meta_data']['price_id'],
                'total_amount' => $payment['amount'],
            ]);
            if (!empty($payment['meta_data']['media_file'])) {
                foreach ($payment['meta_data']['media_file'] as $key => $file) {
                    $media = \App\Models\Media::create([
                        'client_id' =>  $service_request['client_id'],
                        'original_name' => $file['original_name'],
                        'unique_name' => $file['unique_name'],
                    ]);
                    $service_request->medias()->attach($media);
                }
            }

            //Mark discount selected as used
            if(!empty($payment['meta_data']['client_discount_id'])){
                \App\Models\ClientDiscount::where('id', $payment['meta_data']['client_discount_id'])->update(['availability' =>  'used']);
            }
            //Create record for on `service_request_payments` table
            \App\Models\ServiceRequestPayment::create([
                'user_id'               => request()->user()->id, 
                'payment_id'            => $payment['id'], 
                'service_request_id'    => $service_request['id'], 
                'amount'                => $payment['amount'], 
                'unique_id'             => $service_request['unique_id'], 
                'payment_type'          => 'booking-fee', 
                'status'                => $payment['status']
            ]);

            $bookingFeeName = \App\Models\Price::where('id', $payment['meta_data']['price_id'])->first()->name;

            (array) $clientMailData = [
                'firstname'         =>  request()->user()->account->first_name,
                'lastname'          =>  request()->user()->account->last_name,
                'recipient_email'   =>  request()->user()->email,
                'job_ref'           =>  $payment['unique_id'],
                'amount'            =>  number_format($payment['amount']),
                'service_name'      =>  $service['name'],
                'booking_name'      =>  $bookingFeeName,
                'date'              =>  Carbon::parse($service_request['created_at'], 'UTC')->isoFormat('MMMM Do YYYY, h:mm:ssa')
            ];

            //Admin mail data
            (array) $adminMailData = [
                'firstname'         =>  'FixMaster',
                'lastname'          =>  'Administrator',
                'recipient_email'   =>  'info@fixmaster.com.ng',
                'client_name'       =>  request()->user()->account->first_name .' '.request()->user()->account->last_name,
                'job_ref'           =>  $payment['unique_id'],
                'amount'            =>  number_format($payment['amount']),  
                'service_name'      =>  $service['name'],
                'booking_name'      =>  $bookingFeeName
            ];

            //Send mail notification confirmation to ClientDiscount
            \App\Traits\UserNotification::send($clientMailData, 'CUSTOMER_SUCCESSFUL_JOB_BOOKING_NOTIFICATION');

            //Send notification to FixMaster
            \App\Traits\UserNotification::send($adminMailData, 'ADMIN_NEW_JOB_NOTIFICATION');

            // Use created service request to trigger notification to CSE's
            \App\Jobs\ServiceRequest\NotifyCse::dispatch($service_request);

            return redirect()->route('client.service.all', app()->getLocale())->with('success', 'Service request was successful');
        }
        return back()->with('error', 'Payment for Service Failed!!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $locale, Service $service)
    {
        $user = $request->user()->loadMissing('contacts', 'account');
        return view('client.services.quote', [
            'service'               => $service,
            'discounts'             => \App\Models\ClientDiscount::ClientServiceRequestsDiscounts()->get(),
            'bookingFees'           => \App\Models\Price::bookingFees()->get(),
            'states'                => \App\Models\State::select('id', 'name')->orderBy('name', 'ASC')->get(),
            'gateways'              => PaymentGateway::where('status', PaymentGateway::STATUS['active'])->orderBy('id', 'DESC')->get(),
            'displayDescription'    => 'blank',
            'myContacts'            => $user['contacts'],
            'registeredAccount'     => $user['account']
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  array  $files
     * @return \Illuminate\Http\Response
     */
    protected function handle_media_files(array $files)
    {
        (array) $uploadedFiles = [];
        foreach ($files as $key => $file) {
            $original = $file->getClientOriginalName();
            $fileName = sha1($original . time()) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('assets/service-request-media-files'), $fileName);
            array_push($uploadedFiles, [
                'original_name' => $original,
                'unique_name' => $fileName
            ]);
        }
        return $uploadedFiles;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     *
     * This is an ajax call to check if client contact town is an available service area.
     * Present on change of contact list radio button selection
     */
    public function verifyServiceArea($language, Request $request)
    {
        if ($request->ajax()) {
            //Get request via ajax
            (array) $filter = $request->only('town_id', 'booking_fee');

            //Check if town ID exists on `serviced_areas` table
            $isServiced = \App\Models\ServicedAreas::where('town_id', $filter['town_id'])->exists();

            $closingBalance = !empty(request()->user()->clientWalletBalance->closing_balance) ? request()->user()->clientWalletBalance->closing_balance : 0;

            //Return to partial view with response
            return view(
                'client.services.includes._service_quote_description_body',
                [
                    'displayDescription'    => !empty($isServiced) ? 'serviced' : 'not-serviced',
                    'discounts'             => $this->clientDiscounts(),
                    'canPayWithWallet'      => !empty($closingBalance >= $filter['booking_fee']) ? 'can-pay' : 'cannot-pay',
                ]
            );
        }
    }
}
