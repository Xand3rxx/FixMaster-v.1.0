<?php

namespace App\Http\Controllers\Supplier;

use App\Models\Rfq;
use App\Traits\Loggable;
use Illuminate\Http\Request;
use App\Models\RfqSupplierInvoice;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use App\Models\RfqSupplierInvoiceBatch;

class RfqController extends Controller
{
    use Loggable; 

    /**
     * This method will redirect users back to the login page if not properly authenticated
     * @return void
     */  
    public function __construct() {
        $this->middleware('auth:web');
    }

    public function index(){

        return view('supplier.rfq.index', [
            'rfqs'   =>  Rfq::orderBy('created_at', 'DESC')->get(),
        ])->with('i');
    }

    /**
     * Display the specified resource.
     *
     * 
     * 
     * @param  string  $uuid
     * @return \Illuminate\Http\Response
     */
    public function rfqDetails($language, $uuid){

        return view('supplier.rfq._details', [
            'rfqDetails'    =>  Rfq::where('uuid', $uuid)->with('rfqSupplier','rfqBatches')->firstOrFail(),
        ]);
    }

    /**
     * Display the specified resource.
     *
     * 
     * @param  string  $uuid
     * @return \Illuminate\Http\Response
     */
    public function linkRfqDetails($language, $uuid){

        return view('supplier.rfq.show', [
            'rfqDetails'    =>  Rfq::where('uuid', $uuid)->firstOrFail(),
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $uuid
     * @return \Illuminate\Http\Response
     */
    public function sendInvoice($language, $uuid){

        return view('supplier.rfq.send_supplier_invoice', [
            'rfqDetails'    =>  Rfq::where('uuid', $uuid)->firstOrFail(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
        //Send Quote for a specific RFQ
        //Validate user input fields
        $this->validateRequest();

        $supplierInvoiceExists = RfqSupplierInvoice::where('rfq_id', $request->rfq_id)->where('supplier_id', auth()->user()->id)->count();

        if($supplierInvoiceExists > 0){
            return redirect()->route('supplier.rfq', app()->getLocale())->with('error', 'Sorry, you already sent an invoice for this RFQ');
        }

        $rfqUniqueId = Rfq::where('id', $request->rfq_id)->firstOrFail()->unique_id;

        (bool) $supplierinvoiceBatch = false;

        DB::transaction(function () use ($request, &$supplierinvoiceBatch) {

            $supplierinvoice = RfqSupplierInvoice::create([
                'rfq_id'        =>  $request->rfq_id,
                'supplier_id'   =>  auth()->user()->id,
                'delivery_fee'  =>  $request->delivery_fee,  
                'delivery_time' =>  $request->delivery_time,
                'total_amount'  =>  $request->total_amount,
            ]);


            foreach ($request->rfq_batch_id as $item => $value){

                $totalAmount = ($request->unit_price[$item] * $request->quantity[$item]);

                RfqSupplierInvoiceBatch::create([
                    'rfq_supplier_invoice_id'   =>  $supplierinvoice->id,
                    'rfq_batch_id'              =>  $request->rfq_batch_id[$item],
                    'quantity'                  =>  $request->quantity[$item],  
                    'unit_price'                =>  $request->unit_price[$item],
                    'total_amount'              =>  $totalAmount,
                ]);
            }

            //Record service request progress of `A supplier sent an invoice`
            \App\Models\ServiceRequestProgress::storeProgress($request->user()->id, Rfq::where('id', $request->rfq_id)->firstOrFail()->service_request_id, 2, \App\Models\SubStatus::where('uuid', 'c615f5ce-fe3b-43f7-9125-d6568eddf1c5')->firstOrFail()->id);

            //Set variables as true to be validated outside the DB transaction
            $supplierinvoiceBatch = true;

        }, 3);

        $actionUrl = Route::currentRouteAction();

        if($supplierinvoiceBatch){

            $supplierMailData = [];
            $adminMailData = [];

            //Supplier mail data
            $supplierMailData = [
                'firstname'         =>  $request->user()->account->first_name,
                'lastname'          =>  $request->user()->account->last_name,
                'recipient_email'   =>  $request->user()->email,
                'rfq_ref'           =>  $rfqUniqueId,
            ];

            //Admin mail data
            $adminMailData = [
                'firstname'         =>  'FixMaster',
                'lastname'          =>  'Administrator',
                'recipient_email'   =>  'info@fixmaster.com.ng',
                'supplier_name'     => $request->user()->account->first_name .' '.$request->user()->account->last_name,
                'rfq_ref'           =>  $rfqUniqueId,
            ];

            \App\Traits\UserNotification::send($supplierMailData, 'SUPPLIER_SENT_INVOICE_NOTIFICATION');
            \App\Traits\UserNotification::send($adminMailData, 'ADMIN_SENT_SUPPLIER_INVOICE_NOTIFICATION');
            
            //Record crurrenlty logged in user activity
            $this->log('Others', 'Informational', $actionUrl, auth()->user()->email.' sent an invoice for '.$rfqUniqueId.' RFQ');

            return redirect()->route('supplier.rfq_sent_invoices', app()->getLocale())->with('success', 'Your invoice for '.$rfqUniqueId.' RFQ has been sent.');

        }else{

            //Record Unauthorized user activity
            $this->log('Errors', 'Error', $actionUrl, 'An error occurred while '.auth()->user()->email.' was trying to sent an invoice for '.$rfqUniqueId.' RFQ');

            return back()->with('error', 'An error occurred while trying to send your invoice for '.$rfqUniqueId.' RFQ.');
        }
    }

    /**
     * Validate user input fields
     */
    private function validateRequest(){
        return request()->validate([
            'rfq_id'        =>   'bail|required|numeric',
            'rfq_batch_id'  =>   'required|array',
            'rfq_batch_id*' =>   'required|numeric',
            'quantity'      =>   'bail|required|array',
            'quantity.*'    =>   'bail|required|numeric|min:1',
            'unit_price'    =>   'bail|required|array',
            'unit_price.*'  =>   'bail|required|numeric|min:1',
            'delivery_fee'  =>   'bail|required|numeric',
            'delivery_time' =>   'bail|required',
            'total_amount'  =>   'bail|required|numeric'
        ]);

        // return $validator->errors()->keys();
    }

    public function sentInvoices(){

        return view('supplier.rfq.sent_invoices', [
            'rfqs'  =>  auth()->user()->supplierSentInvoices()->get(),
        ]);
       
    }

    public function sentInvoiceDetails($language, $id){

        return view('supplier.rfq._sent_invoice_details', [
            'rfqDetails'    =>  RfqSupplierInvoice::where('id', $id)->firstOrFail(),
        ]);
    }

    public function approvedInvoices(){

        return view('supplier.rfq.approved_invoices', [
            'rfqs'  =>  auth()->user()->supplierSentInvoices()->where('accepted', 'Yes')->get(),
        ]);
    }

    public function declinedInvoices(){

        return view('supplier.rfq.declined_invoices', [
            'rfqs'  =>  auth()->user()->supplierSentInvoices()->where('accepted', 'No')->get(),
        ]);
    }

    
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function rfqDetailsImage($language, $id){

        return view('supplier.rfq._details_image', [
            'rfqDetails'    =>  \App\Models\RfqBatch::select('image')->where('id', $id)->firstOrFail(),
        ]);
    }

    public function warrantyReplacementNotify($language, $id){
     
    }
}
