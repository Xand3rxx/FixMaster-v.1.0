<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ServiceRequestPayment;

class ServiceRequestPaymentController extends Controller
{

    /**
     * Display all payments made by clients.
     *
     * @return \Illuminate\Http\Response
     */
    public function getReceivedPayments(){
        return view('admin.payments.received',[
            'receivedPayments' => ServiceRequestPayment::with('clients', 'service_request')
            ->where('status','success')
            ->orderBy('created_at', 'DESC')
            ->get()
        ]);
    }

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
        //
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

    public function sortReceivedPayments(Request $request){
        if($request->ajax()){


            $level =  $request->get('sort_level');
            $type =  $request->get('type');
            $specificDate =  $request->get('date');
            $specificYear =  $request->get('year');
            $specificMonth =  $request->get('month');
            //Get activity log for a date range
            $dateFrom =  $request->get('date_from');
            $dateTo =  $request->get('date_to');

            if($level === 'Level Five'){

                if(!empty($dateFrom) && !empty($dateTo)){
                    $receivedPayments = ServiceRequestPayment::whereBetween('created_at', [$dateFrom, $dateTo])
                    ->orderBy('created_at', 'DESC')->get();

                    $message = 'Showing Received Payments from "'.\Carbon\Carbon::parse($dateFrom, 'UTC')->isoFormat('LL').'" to "'.\Carbon\Carbon::parse($dateTo, 'UTC')->isoFormat('LL').'"';
                }

                 return view('admin.payments._received_table', compact('receivedPayments','message'));
            }

        }
    }
}
