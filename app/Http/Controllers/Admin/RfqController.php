<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\URL;
use App\Traits\Loggable;
use Illuminate\Http\Request;
use Auth;
use Route;
use App\Models\Rfq;
use App\Models\RfqBatch;
use App\Models\RfqSupplier;
use App\Models\RfqSupplierInvoice;
use App\Models\RfqSupplierInvoiceBatch;
use DB;
use App\Traits\Invoices;

class RfqController extends Controller
{
    use Invoices;

    /**
     * This method will redirect users back to the login page if not properly authenticated
     * @return void
     */
    public function __construct() {
        $this->middleware('auth:web');
    }

    public function index(){

        return view('admin.rfq.index', [
            'rfqs'   =>  Rfq::orderBy('created_at', 'DESC')->get(),
        ]);
    }

    public function rfqDetails($language, $uuid){

        return view('admin.rfq._details', [
            'rfqDetails'    =>  Rfq::where('uuid', $uuid)->with('rfqBatches.supplierInvoiceBatches', 'rfqSupplierInvoice.supplierDispatch')->first(),
        ]);
    }

    public function supplierInvoices(){

        return view('admin.rfq.supplier_invoices', [
            'rfqs'   =>  RfqSupplierInvoice::with('rfq', 'supplier', 'selectedSupplier')
            ->orderBy('total_amount', 'ASC')
            ->orderBy('delivery_time', 'ASC')
            ->orderBy('created_at', 'DESC')
            ->get()
            ->groupBy(function($query) {
                return $query->rfq_id;
            }),


        ]);
    }

    public function supplierInvoiceDetails($language, $uuid){

        $supplierInvoice = RfqSupplierInvoice::where('uuid', $uuid)->firstOrFail();

        return view('admin.rfq._supplier_invoice_details', [
            'supplierInvoice'   =>  $supplierInvoice,
            'supplierInvoiceBatches'    =>  RfqSupplierInvoiceBatch::where('rfq_supplier_invoice_id', $supplierInvoice->id)->get(),

        ])->with('i');
    }

    public function acceptSupplierInvoice($language, $uuid){

        //Get supplier object with uuid
        $supplier = RfqSupplierInvoice::where('uuid', $uuid)->firstOrFail();

        //Assign selected supplier ID to `supplierId`
        $supplierId = $supplier->supplier_id;

        //Assign selected supplier rfq ID to `supplierRfqId`
        $supplierRfqId = $supplier->rfq_id;

        //Assign selected supplier invoice ID to `supplierRfqId`
        $supplierInvoiceId = $supplier->id;

        //Check if the selcted supplier has already been chosen
        $supplierAcceptanceExists = RfqSupplier::where('rfq_id', $supplierRfqId)->where('supplier_id', Auth::id())->count();

        $otherSuppliers = RfqSupplierInvoice::where('rfq_id', $supplierRfqId)->where('uuid', '!=', $uuid)->get();

        if($supplierAcceptanceExists > 0){
            return back()->with('error', 'Sorry, you already accepted '.$supplier['supplier']['account']['first_name'] ." ". $supplier['supplier']['account']['last_name'].' invoice for this '.$supplier->rfq->unique_id);
        }

        //Get selected supplier rfq batches
        $supplierInvoiceBatches =  RfqSupplierInvoiceBatch::where('rfq_supplier_invoice_id', $supplierInvoiceId)->get();

        (bool) $supplierUpdate = false;
        $grandTotalAmount = 0;

        DB::transaction(function () use ($uuid, $supplier, $supplierId, $supplierInvoiceBatches, $supplierRfqId, $grandTotalAmount, $otherSuppliers, &$supplierUpdate) {

            RfqSupplier::create([
                'rfq_id'        =>  $supplierRfqId,
                'supplier_id'   =>  $supplierId,
                'devlivery_fee' =>  $supplier->delivery_fee,
                'delivery_time' =>  $supplier->delivery_time,
            ]);

            foreach ($supplierInvoiceBatches as $item => $value){

                RfqBatch::where('id', $value->rfq_batch_id)->update([
                    'amount'    => $value->total_amount,
                ]);

                $grandTotalAmount += $value->total_amount;
            }

            Rfq::where('id', $supplier->rfq_id)->update([
                'status'        =>   'Awaiting',
                'accepted'      =>   'No',
                'total_amount'  =>   $grandTotalAmount + $supplier->delivery_fee,
            ]);

            // Approve the Supplier invoice
            RfqSupplierInvoice::where('uuid', $uuid)->update([
                'accepted'  => 'Yes'
            ]);

            // Decline other supplier invoices
            foreach($otherSuppliers as $item){
                RfqSupplierInvoice::where('rfq_id', $supplierRfqId)->where('uuid', '!=', $uuid)->update([
                    'accepted'  => 'No'
                ]);
            }
            
            //Record service request progress of `A supplier sent an invoice`
            \App\Models\ServiceRequestProgress::storeProgress(auth()->user()->id, $supplier['rfq']['service_request_id'], 2, \App\Models\SubStatus::where('uuid', '124d3a2d-6efc-4279-a156-438080c33374')->firstOrFail()->id);

            $supplierUpdate = true;

        }, 3);

        if($supplierUpdate){
            //Notification code goes here...

            // $this->supplierInvoice($supplier->rfq->service_request_id, $supplier->rfq_id);
            return back()->with('success', $supplier['supplier']['account']['first_name'] ." ". $supplier['supplier']['account']['last_name'].' invoice has been selected for '.$supplier->rfq->unique_id.' RFQ');
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function rfqDetailsImage($language, $id){
        return view('admin.rfq._details_image', [
            'rfqDetails'    =>  \App\Models\RfqBatch::select('image')->where('id', $id)->firstOrFail(),
        ]);
    }


    /**
     * Calculates the distance between two points, given their 
     * latitude and longitude, and returns an array of values 
     * of the most common distance units
     *
     * @param  {coord} $lat1 Latitude of the first point
     * @param  {coord} $lon1 Longitude of the first point
     * @param  {coord} $lat2 Latitude of the second point
     * @param  {coord} $lon2 Longitude of the second point
     * @return {array}       Array of values in many distance units
     */
    public  static function getDistanceBetweenPoints($lat1, $lon1, $lat2, $lon2) {
        $theta = $lon1 - $lon2;
        $miles = (sin(deg2rad($lat1)) * sin(deg2rad($lat2))) + (cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta)));
        $miles = acos($miles);
        $miles = rad2deg($miles);
        $miles = $miles * 60 * 1.1515;
        $feet = $miles * 5280;
        $yards = $feet / 3;
        $kilometers = $miles * 1.609344;
        $meters = $kilometers * 1000;

        // return compact('miles','feet','yards','kilometers','meters'); 
        return round($kilometers, 2)??0; 
    }

}
