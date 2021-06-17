<?php

namespace App\Http\Controllers\Messaging;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\EnumHelper;
use App\Models\MessageTemplate;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;


class Template extends Controller
{ 
    public function getMessageModules()
    {
        $enumHelper = new EnumHelper();
         return $enumHelper->getPossibleEnumValues('feature', 'message_templates');

    }

    public function getAllTemplates()
    {
        //return MessageTemplate::select('id', 'uuid','title',  'feature')->paginate(10);
        $messageTemplates = MessageTemplate::select(['id', 'title', 'uuid', 'feature'])->get();
        return view('admin.messaging.template.template', ['templates'=>$messageTemplates]);
    }

    public function getTemplate($uuid)
    {
         $template = MessageTemplate::where('uuid', $uuid)->first();
        if(!empty($template)){
           return response()->json(["data" => $template], 200);
        }
        return response()->json(["message" => "Template not found!"], 404);

    }

    public function saveMessageTemplate(Request $request)
    {
        try{
            $feature = $request->input('feature');
            $title = $request->input('title');
            $content = $request->input('content');
            $sms = $request->input('sms');
            $template = MessageTemplate::select('*')
                        ->where('feature', $feature)
                        ->first();
            if(!empty($template)){
                return response()->json(["message" => "There is already a template for this feature!"], 400);
            }

            MessageTemplate::create(['title'=>$title, 'content'=>$content, 'sms'=>$sms, 'feature'=>$feature]);
            return response()->json([
            "message" => "Template created successfully!", "data"=>$template
        ], 201);
        }catch(Throwable $e){
          return response()->json([
        "message" => "Internal server error!"
    ], 500);
        }

    }

    public function updateMessageTemplate(Request $request)
    {
        try{
        $feature = $request->input('feature');
        $title = $request->input('title');
        $content = $request->input('content');
        $sms = $request->input('sms');

        $template = MessageTemplate::updateOrCreate(
            ['feature'=> $feature],
            ['title' => $title, 'content' => $content, 'sms' => $sms]
        );
        return response()->json([
        "message" => "Template updated successfully!", "data"=>$template
        ], 201);
        }catch(Throwable $e){
          return response()->json([
        "message" => "Internal server error!"
    ], 500);
        }
    }

    public function deleteMessageTemplate($uuid)
    {
        $template = MessageTemplate::where('uuid', $uuid)->first();
        if(!empty($template)){
           $template->delete();
           return response()->json(["message" => "Template deleted successfully!", "data"=>[]], 200);
        }
        return response()->json(["message" => "Template not found!"], 404);

    }

    public function colabo(){
        //$service_request = \App\Models\ServiceRequest::has('service_request_warranty')->with('service_request_assignees')->get();
      
        $suppliers = $technicians= [];
        $service_request = \App\Models\ServiceRequest::with('service_request_assignees', 'supplier')->whereHas('service_request_warranty', function (Builder $query) {
            $query->where('initiated', '=', 'No')->where('expiration_date', '>', Carbon::now() );
        })->get();
        if(collect($service_request)->count() > 0){
        foreach ( $service_request as  $value) {
        if($value->service_request_assignees){
                foreach($value->service_request_assignees as $item){
                if($item->user->roles[0]->url == 'technician'){
                    $technicians[] = (object)[
                    'id'=>$item->user->id,
                    'service_request_id' => $value->id
                    ];
                }
              }
            
                }

                if(!is_null($value->supplier)){
                    if($value->supplier->type == 'Request' && $value->supplier->status == 'Delivered' && $value->supplier->accepted == 'Yes'){
                        $suppliers[] = (object)[
                            'id'=>$value->supplier->RfqSupplierInvoice->supplier_id,
                            'service_request_id' => $value->id
                            ];
                    }

                }
                
            }
        }

        $supplierTechnicians = array_merge($technicians, $suppliers );
        foreach ($supplierTechnicians as $value) {
        
            $retentionFee  =  \App\Models\CollaboratorsPayment::select('retention_fee', 'amount_after_retention')
            ->where(['service_request_id'=> $value->service_request_id, 'user_id'=>$value->id, 'service_type'=> 'Regular'])
            ->first();
        
            if(collect($retentionFee)->count() > 0){
            $update   =  \App\Models\CollaboratorsPayment::where(['service_request_id'=> $value->service_request_id, 'user_id'=>$value->id, 'service_type'=> 'Regular', 'retention_cronjob_update'=>'Pending'])
            ->update([
                'amount_after_retention'=> (int)$retentionFee->amount_after_retention + (int)$retentionFee->retention_fee,
                'retention_fee'=> 0,
                'retention_cronjob_update' => 'Update'
            ]);
        }

    
    }
      
      
        }  

}
