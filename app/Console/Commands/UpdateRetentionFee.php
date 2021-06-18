<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;

class UpdateRetentionFee extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'retentionFee:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update all retention fee if warranty is not used before expration date';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
       
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
      
        $this->info('Colaborators retension fee updated successfully');
    }
}
