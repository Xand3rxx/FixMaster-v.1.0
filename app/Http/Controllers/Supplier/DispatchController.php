<?php

namespace App\Http\Controllers\Supplier;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Auth;
use Route;
use DB;
use App\Traits\Loggable;
use App\Traits\GenerateUniqueIdentity;
use App\Models\RfqSupplierDispatch;

class DispatchController extends Controller
{
    use Loggable, GenerateUniqueIdentity;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // return RfqSupplierDispatch::where('supplier_id', Auth::id())->with('rfq', 'supplierInvoice')->get();

        return view('supplier.materials.index', [
            'dispatches'    =>  RfqSupplierDispatch::where('supplier_id', Auth::id())->with('rfq')->orderBy('created_at', 'DESC')->get()
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function dispatchReturned()
    {
        
        return view('supplier.materials.returned', [
            'dispatches'    =>  RfqSupplierDispatch::where('supplier_id', Auth::id())->where('cse_status', 'No')->with('rfq')->get()
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function dispatchDelivered()
    {

        return view('supplier.materials.delivered', [
            'dispatches'    =>  RfqSupplierDispatch::where('supplier_id', Auth::id())->where('cse_status', 'Yes')->with('rfq')->get()
        ]);
    }

    

    
    /**
     * Show the form for generating a new unique string.
     * 
     * @return \Illuminate\Http\Response
     */
    public function generateDeliveryCode()
    {
        return static::generate('rfq_supplier_dispatches', 'DEV-');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Validate if RFQ ID exists
        $rfq = \App\Models\Rfq::where('id', $request->rfq_id)->firstOrFail();

        //Label and dispacth materials for a RFQ issued
        //Validate user input fields
        $request->validate([
            'rfq'                   =>  'required',
            'rfq_id'                =>  'required',
            'rfq_supplier_invoice'  =>  'required',
            'unique_id'             =>  'required|unique:rfq_supplier_dispatches,unique_id',
            'courier_name'          =>  'required',
            'courier_phone_number'  =>  'required',
            'delivery_medium'       =>  'required',
            'comment'               =>  'sometimes',
        ]);


        //Set `createDispatch` to false before Db transaction and pass by reference
        (bool) $createDispatch  = false;

        // Set DB to rollback DB transacations if error occurs
        DB::transaction(function () use ($request, &$createDispatch) {
             RfqSupplierDispatch::create([
                'rfq_id'                =>  $request->rfq_id,
                'rfq_supplier_invoice'  =>  $request->rfq_supplier_invoice,
                'supplier_id'           =>  $request->user()->id,
                'unique_id'             =>  $request->unique_id,
                'courier_name'          =>  $request->courier_name,
                'courier_phone_number'  =>  $request->courier_phone_number,
                'delivery_medium'       =>  $request->delivery_medium,
                'comment'               =>  $request->comment,
            ]);
            
            //Record service request progress of `A supplier sent an invoice`
            \App\Models\ServiceRequestProgress::storeProgress(auth()->user()->id, \App\Models\Rfq::where('id', $request->rfq_id)->firstOrFail()->service_request_id, 2, \App\Models\SubStatus::where('uuid', 'ef8c69e8-5634-4bd0-a7e6-b73a89ae034f')->firstOrFail()->id);

            //Set variables as true to be validated outside the DB transaction
            $createDispatch =  true;
        });

        if($rfq['type'] == 'Warranty'){
            $this->updateRfqDispatchNotify($request,$rfq->service_request_id);
        }
        // $serviceRquest = \App\Models\Rfq::where(['id'=>$request->rfq_id, 'type'=> 'Warranty' ])->first()->service_request_id;
        //  if($serviceRquest)
        //  {
        // $updateWArrantyDispatch = $this->updateRfqDispatchNotify($request,$serviceRquest);
        //  }

        if($createDispatch){

            //Code to send mail to FixMaster, CSE and Supplier who sent the quote

            //Record crurrenlty logged in user activity
            $type = 'Request';
            $severity = 'Informational';
            $actionUrl = Route::currentRouteAction();
            $message = Auth::user()->email.' created '.$request->unique_id.' dispatch code for '.$request->rfq.' RFQ.';
            $this->log($type, $severity, $actionUrl, $message);
 
            return redirect()->route('supplier.dispatches', app()->getLocale())->with('success', 'Your '.$request->rfq.' RFQ has been labelled.');
 
        }else{
 
            //Record Unauthorized user activity
            $type = 'Errors';
            $severity = 'Error';
            $actionUrl = Route::currentRouteAction();
            $message = 'An error occurred while '.Auth::user()->email.' was trying to create '.$request->unique_id.' dispatch code for '.$request->rfq.' RFQ.';
            $this->log($type, $severity, $actionUrl, $message);
 
            return back()->with('error', 'An error occurred while trying to create dispatch code for '.$request->rfq.' RFQ.');
        }
 
        return back()->withInput();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function dispatchDetails($language, $id){

        // dd (RfqSupplierDispatch::with('rfq', 'supplierInvoice')->findOrFail($id));

        return view('supplier.materials._details', [
            'dispatch'    =>  RfqSupplierDispatch::with('rfq', 'supplierInvoice')->findOrFail($id),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateDispatchStatus($language, $id, Request $request){

        if($request->ajax()){

            $serviceRequestId =  RfqSupplierDispatch::where('id', $id)->with('supplierInvoice.rfq')->firstOrFail();

            //Validate user input fields
            $request->validate([
                'supplier_status'   =>  'required',
            ]);

            if($request->supplier_status == 'In-Transit'){
                $progressUUID = '6e266cf8-7eeb-49be-86ad-375c7c7416fa';
            }elseif($request->supplier_status == 'Processing'){
                $progressUUID = 'ee55201e-75a3-461a-b174-3a0537ee8e0c';
            }else{
                $progressUUID = '3ec28d52-2bd3-446a-985c-3bf622f9f445';
            }

            //Set `updateDispatchStatus` to false before Db transaction and pass by reference
            (bool) $updateDispatchStatus  = false;
            
            // Set DB to rollback DB transacations if error occurs
            DB::transaction(function () use ($id, $request, $serviceRequestId,  $progressUUID, &$updateDispatchStatus) {

                RfqSupplierDispatch::where('id', $id)->update([
                    'supplier_status'   =>  $request->supplier_status
                ]);
                
                \App\Models\ServiceRequestProgress::storeProgress(auth()->user()->id, $serviceRequestId['supplierInvoice']['rfq']['service_request_id'], 2, \App\Models\SubStatus::where('uuid', $progressUUID)->firstOrFail()->id);
                
                $updateDispatchStatus  = true;
            });

            if($updateDispatchStatus){

                //Code to send mail to FixMaster, CSE and Supplier who sent the quote

                //Record crurrenlty logged in user activity
                $type = 'Request';
                $severity = 'Informational';
                $actionUrl = Route::currentRouteAction();
                $message = Auth::user()->email.' updated the status of '.$request->dispatch_code.' dispatch code to '.$request->supplier_status;
                $this->log($type, $severity, $actionUrl, $message);
     
                return redirect()->route('supplier.dispatches', app()->getLocale())->with('success', 'Your '.$request->dispatch_code.' dispatch status was updated'.$request->supplier_status);
     
            }else{
     
                //Record Unauthorized user activity
                $type = 'Errors';
                $severity = 'Error';
                $actionUrl = Route::currentRouteAction();
                $message = 'An error occurred while '.Auth::user()->email.' was trying to update '.$request->dispatch_code.' dispatch status.';
                $this->log($type, $severity, $actionUrl, $message);
     
                return back()->with('error', 'An error occurred while trying to update dispatch code for '.$request->dispatch_code);
            }
        }
    }

    public function updateRfqDispatchNotify($request,$serviceRquest){
    
        $updateOldSupplierRfqDispatch = \App\Models\RfqDispatchNotification::where(['service_request_id'=>$serviceRquest ,  'supplier_id' => Auth::user()->id ])->update([
             'notification' => 'Off',
            'dispatch' => 'Yes',
        ]);

        return $updateOldSupplierRfqDispatch ;
    }
}
