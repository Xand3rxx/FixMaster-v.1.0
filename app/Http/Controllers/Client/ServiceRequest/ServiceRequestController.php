<?php

namespace App\Http\Controllers\Client\ServiceRequest;

use App\Traits\Services;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ServiceRequestController extends Controller
{
    use Services;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

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

        return $request->all();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
    public function verifyServiceArea($language, Request $request){
           if ($request->ajax()) {
            //Get request via ajax
            (array) $filter = $request->only('town_id', 'booking_fee');

            //Check if town ID exists on `serviced_areas` table
            $isServiced = \App\Models\ServicedAreas::where('town_id', $filter['town_id'])->exists();

            $walletBalance = \App\Models\WalletTransaction::where('user_id', auth()->user()->id)->orderBy('id', 'DESC')->first()->closing_balance;

            //Return to partial view with response
            return view('client.services.includes._service_quote_description_body', 
            [
                'displayDescription'    => !empty($isServiced) ? 'serviced' : 'not-serviced' ,
                'discounts'             => $this->clientDiscounts(),
                'canPayWithWallet'      => !empty($walletBalance >= $filter['booking_fee']) ? 'can-pay' : 'cannot-pay',
            ]);
            
        }
    }
}
