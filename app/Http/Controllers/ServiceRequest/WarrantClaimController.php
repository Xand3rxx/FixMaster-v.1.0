<?php

namespace App\Http\Controllers\ServiceRequest;

use Image;
use App\Models\Rfq;
use App\Traits\Utility;
use App\Models\RfqBatch;
use App\Models\Supplier;
use App\Traits\Loggable;
use App\Traits\ImageUpload;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\RfqSupplierInvoice;
use App\Traits\findRecordWithUUID;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\CollaboratorsPayment;
use App\Models\ServiceRequestReport;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Models\ServiceRequestAssigned;
use App\Models\RfqDispatchNotification;
use App\Models\ServiceRequestWarrantyImage;
use App\Models\ServiceRequestWarrantyIssued;
use App\Models\ServiceRequestWarrantyReport;


class WarrantClaimController extends Controller
{
    use findRecordWithUUID, Loggable, Utility, ImageUpload;
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    
    public function store(Request $request){


        $this->validate(
            $request, 
            ['preferred_time' => 'required_if:service_request_warrant_issued_schedule_date,==,null'],
            ['required_if' => 'This scheduled fix date is required'],
        );

       
        

         if($request->intiate_rfq == 'yes' && $request->new_supplier_id ){
           
            $this->validate($request, [
                "new_manufacturer_name"    => "required|array",
                "new_manufacturer_name.*"    => "required|string|min:2",
                "new_component_name"    => "required|array",
                "new_component_name.*"    => "required|string|min:2",
                "new_quantity"    => "required|array",
                "new_quantity.*"    => "required|integer",
            ]);
          }
    

        $service_request_warranty_id = $request['service_request_warranty_id'];
        $serviceRequest = \App\Models\ServiceRequestWarrantyIssued::where('service_request_warranty_id', $request['service_request_warranty_id'])->first();
        $preferredTime = $saveTechnician= $uploadReportImage= $serviceRequestReport = $causalWarrantReport=$saveRfq = $deliveryStatus = $acceptMaterial=  $saveRfqSupplierInoviceStatus='';
     
        if($request->preferred_time)
        {
         $preferredTime = $this->preferredTime($serviceRequest, $service_request_warranty_id,$request);
        }

        if($request['technician_user_uuid'] )
        {
            $saveTechnician = $this->saveTechnician($serviceRequest, $service_request_warranty_id,$request);
           }

        if($request->hasFile('upload_image'))
        {
         $uploadReportImage = $this->uploadReportImage($request,$serviceRequest);  
        } 

        if($request->causal_reason || $request->causal_agent_id)
        {
        $causalWarrantReport =  $this->causalWarrantReport($request,$serviceRequest);
        }

        if($request->cse_comment) 
        {
        $serviceRequestReport =  $this->serviceRequestReport($request,$serviceRequest);
       }

       if($request->intiate_rfq == 'yes')
       {
        $saveRfq = $this->saveRfq($request);
       }
       if($request->approve_invoice)
       {
        $saveRfqSupplierInoviceStatus = $this->saveRfqSupplierInoviceStatus($request);
   
       }

     if($request->delivery_status){
        $deliveryStatus = $this->deliveryStatus($request);

     }

     if($request->accept_materials){
        $acceptMaterial= $this->acceptMaterial($request);

     }
   
 

        if ($saveRfq || $preferredTime || $saveTechnician || $uploadReportImage || $serviceRequestReport ||  $causalWarrantReport || 
         $saveRfq || $deliveryStatus || $acceptMaterial ||  $saveRfqSupplierInoviceStatus)
        {
            $type = 'Others';
            $severity = 'Informational';
            $actionUrl = Route::currentRouteAction();
            $message = Auth::user()->email.' Warranty Claim Updated successfully ';
            $this->log($type, $severity, $actionUrl, $message);
            return back()->with('success','Warranty Claim Updated successfully');

        }
        else {
            $type = 'Errors';
            $severity = 'Error';
            $actionUrl = Route::currentRouteAction();
            $message = 'An Error Occured while '. Auth::user()->email. 'was trying to update warranty claim ';
            $this->log($type, $severity, $actionUrl, $message);
            return back()->with('error', 'An error occurred while trying to update warranty claim ');
        }
    

   
    }


    protected function preferredTime($serviceRequest, $service_request_warranty_id,$request ){

        if($serviceRequest){
            $updateWarranty = \App\Models\ServiceRequestWarrantyIssued::where('service_request_warranty_id', $service_request_warranty_id)->update([
                    'service_request_warranty_id'     =>   $request['service_request_warranty_id'],
                  'scheduled_datetime' => $request->preferred_time,  
                ]);
        }
    
     return  $updateWarranty;

    }


    protected function saveTechnician($serviceRequest, $service_request_warranty_id,$request ){
        $updateWarranty= '';
        $checkOldTechnician = \App\Models\ServiceRequestAssigned::where(['service_request_id'=>  $request->serviceRequestId, 'user_id'=> $request['technician_user_uuid']])->first();

        if($serviceRequest){
            $updateWarranty = \App\Models\ServiceRequestWarrantyIssued::where('service_request_warranty_id', $service_request_warranty_id)->update([
                    'service_request_warranty_id'     =>   $request['service_request_warranty_id'],
                    'technician_id'     =>   $checkOldTechnician ? NULL : $request['technician_user_uuid'],
                ]);   
        }
       return $updateWarranty;
    }


    protected function uploadReportImage($request,$serviceRequesIssued){
        foreach ($request->file('upload_image') as $file) {
            $image = $file;
            $imageName = (string) Str::uuid() .'.'.$file->getClientOriginalExtension();
            $imageDirectory = public_path('assets/warranty-claim-images').'/';
            $width = 350; $height = 259;
            Image::make($image->getRealPath())->resize($width, $height)->save($imageDirectory.$imageName);

            $createWarranty = \App\Models\ServiceRequestWarrantyImage::create([
                'user_id'                                         =>  Auth::id(),
                'service_request_warranties_issued_id'             =>  $serviceRequesIssued->id,
                'name'                                             =>   $imageName,
                
            ]);
    
        }
        return  $createWarranty ;
    }


    protected function causalWarrantReport($request,$serviceRequesIssued){
           
        $createWarranty="";
        if($request->causal_agent_id){
        foreach ($request->causal_agent_id as $value) {
        $createWarranty = \App\Models\ServiceRequestWarrantyReport::create([
            'user_id'                                         =>  Auth::id(),
            'service_request_warranties_issued_id'             =>  $serviceRequesIssued->id,
            'report'                                           =>  $request->cse_comment?? 'none',
            'causal_agent_id'                                  =>   $value,
            'causal_reason'                                    =>   $request->causal_reason??'None',
            
        ]);

      }
    }else{
        $createWarranty = \App\Models\ServiceRequestWarrantyReport::create([
            'user_id'                                         =>  Auth::id(),
            'service_request_warranties_issued_id'             =>  $serviceRequesIssued->id,
            'report'                                           =>   $request->cse_comment?? 'none',
            'causal_agent_id'                                  =>   '0',
            'causal_reason'                                    =>   $request->causal_reason??'None',
            
        ]);
    }
    
        return  $createWarranty ;
    }


    protected function serviceRequestReport($request,$serviceRequesIssued){
        $createReport = \App\Models\ServiceRequestReport::create([
            'user_id'                                         =>  Auth::id(),
            'service_request_id'             =>  $request->service_request_id,
            'report'                                   =>   $request->cse_comment,
            'stage'                                  =>   'Warranty-Claim',
            'type '                                    =>   'Root-Cause',
            
        ]);

        return  $createReport ;
    }


    public function uploadImage($file)
    {
        
            $image = $file;
            $imageName = (string) Str::uuid() .'.'.$file->getClientOriginalExtension();
            $imageDirectory = public_path('assets/rfq-images').'/';
            $width = 350; $height = 259;
            Image::make($image->getRealPath())->resize($width, $height)->save($imageDirectory.$imageName);


        return  $imageName ;
    }


    public function saveRfq($request){
        $component_name = []; $mail1 =""; 
        $imageDirectory = public_path('assets/warranty-claim-images').'/';
        $width = 350; $height = 259;

        //send rfqbatch
     
         //old supplier flow
          if(!$request->new_supplier_id)
          {
          
            if($request->supplier_id)
            {
                for ($i=0; $i < count($request->manufacturer_name) ; $i++) { 
                    $component_name [] = [
                      'manufacturer_name' => $request->manufacturer_name[$i],
                      'model_number'  => $request->model_number[$i],
                      'component_name'  => $request->component_name[$i],
                        'quantity'  => $request->quantity[$i],
                        'size' => $request->size[$i],
                        'unit_of_measurement' => $request->unit_of_measurement[$i],
                        'image' =>  $request->file('image')? $this->uploadImage($request->file('image')[$i]): 'UNAVAILABLE',
                    ];
                  }

           
            
                (bool) $updateRfq = false;

                DB::transaction(function () use ($request, $component_name, &$updateRfq) {

              
                    $rfq = \App\Models\Rfq::create([
                        'issued_by' => auth()->user()->id,
                        'type' =>   'Warranty',
                        'service_request_id'=> $request->service_request_id, 
                        'status'=>  'Awaiting',
                        'accepted' => 'No'
                    ]);
                 
                // // save each of the component name on the rfqbatch table
                foreach ($component_name as $key => $value) {
                    \App\Models\RfqBatch::create([
                'rfq_id'           =>  $rfq->id,
                'component_name'    => $value['component_name']??'UNAVAILABLE',
                'model_number'      => $value['model_number']??'UNAVAILABLE',
                'quantity'          => $value['quantity']??'UNAVAILABLE',
                'amount'            => 0.00,
                'manufacturer_name' => $value['manufacturer_name']??'UNAVAILABLE',
                'size'              => $value['size']?? '0',
                'unit_of_measurement' => $value['unit_of_measurement']??'0',
                'image'              => 'assets/rfq-images/'.$value['image']
                
                ]);
                }
               
                foreach ( $request->supplier_id as $supply) {
                    $ifSupplier =    \App\Models\RfqDispatchNotification::where(['rfq_id' => $request->rfq_id])->first();    
                if(!$ifSupplier)
                    {

                        $creatteSupplierRfqDispatch = \App\Models\RfqDispatchNotification::create([
                            'rfq_id' =>  $request->rfq_id,
                            'supplier_id' => $supply,
                            'service_request_id' => $request->service_request_id,
                        ]);
        
                        if($creatteSupplierRfqDispatch){
                            $user =   \App\Models\Supplier::where('user_id', $supply)->with('user')->first();
                              $mail_data_supplier = collect([
                                  'email' =>  $user->user->email,
                                  'template_feature' => 'SUPPLIER_NEW_RFQ_NOTIFICATION',
                                  'customer_name' => $user->business_name,
                                  'job_ref' =>  $rfq->unique_id,
                                   'url'   =>   url(app()->getLocale().'/client/requests/'),
                                 
                              ]);
                            $mail1 = $this->mailAction($mail_data_supplier);
                         
                            }
                    }


                }

                $updateRfq = true;
            }); 
            }
            
            return '1';

          }

          if($request->new_supplier_id)
          {
          return  $this->newSupplier($request, $component_name);

          }


     }

  protected function newSupplier($request, $component_name){

    for ($i=0; $i < count($request->new_manufacturer_name) ; $i++) { 
        $component_name [] = [
          'manufacturer_name' => $request->new_manufacturer_name[$i]??'None',
          'model_number'  => $request->new_model_number[$i]??'None',
          'component_name'  => $request->new_component_name[$i]??'None',
            'quantity'  => $request->new_quantity[$i]??'0',
            'size' => $request->new_size[$i]??'0',
            'unit_of_measurement' => $request->new_unit_of_measurement[$i]??'None',
            'image' =>  $request->file('new_image')? $this->uploadImage($request->file('new_image')[$i]): 'UNAVAILABLE',
        ];
      }


    

    // $retentionFee  =  \App\Models\CollaboratorsPayment::select('retention_fee', 'amount_after_retention')
    // ->where(['service_request_id'=> $request->service_request_id, 'service_type'=> 'Regular'])
    // ->whereIn('user_id', '=', $request->initial_supplier)
    // ->first();
    // dd($request,$retentionFee);
    // if(collect($retentionFee)->count() > 0){
    //     $update   =  \App\Models\CollaboratorsPayment::where(['service_request_id'=> $value->service_request_id, 'user_id'=>$value->id, 'service_type'=> 'Regular', 'retention_cronjob_update'=>'Pending'])
    //     ->update([
    //         'amount_after_retention'=> (int)$retentionFee->amount_after_retention + (int)$retentionFee->retention_fee,
    //         'retention_fee'=> 0,
    //         'retention_cronjob_update' => 'Update'
    //     ]);
    // }

         $users = \App\Models\Supplier::where('user_id' ,'<>', $request->initial_supplier)->with('user')->get();
        
         (bool) $createRfq = false;

         DB::transaction(function () use ($users, $request, $component_name, &$createRfq) {

         $updateOldSupplierRfqDispatch = \App\Models\RfqDispatchNotification::create([
            'rfq_id' => $request->rfq_id,
            'service_request_id' => $request->service_request_id,
            'supplier_id' => 0
        ]);


        $rfq = \App\Models\Rfq::create([
            'issued_by' => auth()->user()->id,
            'type' =>   'Warranty',
            'service_request_id'=> $request->service_request_id, 
        ]);


        // save each of the component name on the rfqbatch table
        foreach ($component_name as $key => $value) {
          $createRfqBatch =  \App\Models\RfqBatch::create([
          'rfq_id'           =>  $rfq->id,
          'component_name'    => $value['component_name'],
          'model_number'      => $value['model_number'],
          'quantity'          => $value['quantity'],
          'amount'            => 0.00,
          'manufacturer_name' => $value['manufacturer_name'],
          'size'              => $value['size'],
          'unit_of_measurement' => $value['unit_of_measurement'],
          'image'              => $value['image']
        
          ]);
        }

       
    
       

       if( $updateOldSupplierRfqDispatch AND $createRfqBatch){
        foreach($users as $supplier){
            $mail_data_supplier = collect([
                'email' =>  $supplier['user']['email'],
                'template_feature' => 'SUPPLIER_NEW_RFQ_NOTIFICATION',
                'customer_name' => $supplier['business_name'],
                'job_ref' =>  $rfq->unique_id,
                'url'   =>   url(app()->getLocale().'/client/requests/'),
            ]);
                $mail1 = $this->mailAction($mail_data_supplier);
                
            }  
        }
        $createRfq = true;
    }); 
        return '1';
            
        }
    
   
        protected function saveRfqSupplierInoviceStatus($request){
          
            $rfqInvoice =  \App\Models\RfqSupplierInvoice::where(['rfq_id'=> $request->rfqWarranty_id ])->first();
            $supplier =  \App\Models\User::where('id',   $rfqInvoice->supplier_id)->with('account')->first();
          
            if($request->approve_invoice == 'Approved'){

           $updateInvoiceStatus ='';
            (bool) $approveInvoice = false;

            DB::transaction(function () use ($request, $updateInvoiceStatus ,$supplier, &$approveInvoice) {
            $updateInvoiceStatus   =  \App\Models\RfqSupplierInvoice::where(['rfq_id'=> $request->rfqWarranty_id])
            ->update([
                'accepted'=> 'Yes'
            ]);

            $updateRfqStatus   =  \App\Models\Rfq::where(['id'=> $request->rfqWarranty_id])
            ->update([
                 'status'=> 'Awaiting'
            ]);

            $mail_data_supplier = collect([

                'template_feature' => 'SUPPLIER_ACCEPTED_INVOICE_NOTIFICATION',
                'email' =>  $supplier->email,
                'firstname' =>  $supplier->account->first_name,
                'lastname' =>  $supplier->account->last_name,
                'job_ref' =>  $request->service_request_unique_id,
                
              ]);
        
            $this->mailAction($mail_data_supplier);
            $approveInvoice = true;
            }); 
          }

          if($request->approve_invoice == 'Declined'){
            $updateInvoiceStatus ='';
            (bool) $approveInvoice = false;

            DB::transaction(function () use ($request, $updateInvoiceStatus ,$supplier, &$approveInvoice) {

            $updateInvoiceStatus   =  \App\Models\RfqSupplierInvoice::where(['rfq_id'=> $request->rfqWarranty_id])
            ->update([
                'accepted'=> 'No'
            ]);

            
            $updateRfqStatus   =  \App\Models\Rfq::where(['id'=> $request->rfqWarranty_id])
            ->update([
                'status'=> 'Rejected'
            ]);

            $creatteSupplierRfqDispatch = \App\Models\RfqDispatchNotification::where(['service_request_id'=> $request->service_request_id])
            ->delete();


            $mail_data_supplier = collect([

                'template_feature' => 'SUPPLIER_DECLINED_INVOICE_NOTIFICATION',
                'email' =>  $supplier->email,
                'firstname' =>  $supplier->account->first_name,
                'lastname' =>  $supplier->account->last_name,
                'job_ref' =>  $request->service_request_unique_id,
                
              ]);
        
            $this->mailAction($mail_data_supplier);

            $approveInvoice = true;
         }); 

          }

     
        return  '1';

        }

        protected function deliveryStatus($request){
              
            $rfqId  =  \App\Models\RfqSupplierInvoice::where(['rfq_id'=> $request->rfqWarranty_id])->first()->rfq_id;

                $updateInvoiceStatus   =  \App\Models\Rfq::where(['id'=> $rfqId ])
                ->update([
                    'status'=> $request->delivery_status
                ]);

            return  $updateInvoiceStatus;

        }
   
        protected function acceptMaterial($request)
        {

            $rfqInvoice =  \App\Models\RfqSupplierInvoice::where(['rfq_id'=> $request->rfqWarranty_id ])->first();
            $supplier =  \App\Models\User::where('id',   $rfqInvoice->supplier_id)->with('account')->first();
         
            if($request->accept_materials == 'Yes'){
            $rfqId  =  \App\Models\RfqSupplierInvoice::where(['rfq_id'=> $request->rfqWarranty_id])->first();
         
            (bool) $createRfq = false;

            DB::transaction(function () use ($request,  $rfqId, $supplier, &$createRfq) {

            $updateInvoiceStatus   =  \App\Models\Rfq::where(['id'=> $request->rfqWarranty_id ])
            ->update([
                'accepted'=> $request->accept_materials,
                'total_amount' =>    $rfqId->total_amount,
                'status' => 'Delivered'
            ]);

            $updateDispatch   =  \App\Models\RfqSupplierDispatch::where(['rfq_supplier_invoice'=> $rfqId->id  ])
            ->update([
                'cse_status'=> 'Delivered',
                'cse_comment' =>  $request->accept_reason,
                'cse_material_acceptance'=> $request->accept_materials,
            ]);

            $mail_data_supplier = collect([

                'template_feature' => 'SUPPLIER_DISPATCHED_ACCEPTED_INVOICE_NOTIFICATION',
                'email' =>  $supplier->email,
                'firstname' =>  $supplier->account->first_name,
                'job_ref' =>  $request->service_request_unique_id,
                
              ]);
        
            $this->mailAction($mail_data_supplier);

            $$createRfq = true;
        }); 
        return '1';

        }


            if($request->accept_materials == 'No'){
              
                $rfqId  =  \App\Models\RfqSupplierInvoice::where(['rfq_id'=> $request->rfqWarranty_id])->first();
         
            (bool) $createRfq = false;

            DB::transaction(function () use ($request,  $rfqId,  $supplier,&$createRfq) {
            
                $updateInvoiceStatus   =  \App\Models\Rfq::where(['id'=> $request->rfqWarranty_id ])
                ->update([
                    'accepted'=> $request->accept_materials,
                    'total_amount' =>    $rfqId->total_amount,
                    'status' => 'Rejected'
                    
                ]);
    
                $updateDispatch   =  \App\Models\RfqSupplierDispatch::where(['rfq_supplier_invoice'=> $rfqId->id  ])
                ->update([
                    'cse_status'=> 'Pending',
                'cse_comment' =>  $request->accept_reason,
                'cse_material_acceptance'=> $request->accept_materials,
                ]);

                $updateInvoiceStatus   =  \App\Models\RfqSupplierInvoice::where(['rfq_id'=> $request->rfqWarranty_id])
                ->update([
                    'accepted'=> 'No'
                ]);

               $creatteSupplierRfqDispatch = \App\Models\RfqDispatchNotification::where(['service_request_id'=> $request->service_request_id])
               ->delete();

               $mail_data_supplier = collect([

                'template_feature' => 'SUPPLIER_DISPATCHED_REJECTED_INVOICE_NOTIFICATION',
                'email' =>  $supplier->email,
                'firstname' =>  $supplier->account->first_name,
                'job_ref' =>  $request->service_request_unique_id,
                
              ]);
        
            $this->mailAction($mail_data_supplier);

               $$createRfq = true;
            });
                    return '1';

               }
               

        }


     
        public function rfqDetailsImage($language, $id){
            return view('supplier.rfq._details_image', [
                'rfqDetails'    =>  \App\Models\RfqBatch::select('image')->where('id', $id)->first(),
            ]);
        }
    

}