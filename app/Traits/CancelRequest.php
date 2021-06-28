<?php

namespace App\Traits;

use App\Models\SubStatus;
use App\Models\ServiceRequest;
use App\Models\WalletTransaction;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use App\Models\ServiceRequestProgress;

trait CancelRequest
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  object  $serviceRequest
     * @return bool 
     * 
     */
    public function initiateCancellation($request, $serviceRequest){
        //Set `cancelRequest` to false before Db transaction
        (bool) $cancelRequest  = false;

        //Create new record for CSE on `service_request_cancellations` table.
        DB::transaction(function () use ($request, $serviceRequest, &$cancelRequest) {
            \App\Models\ServiceRequestCancellation::create([
                'user_id'               => $request->user()->id,
                'service_request_id'    => $serviceRequest->id, 
                'reason'                => $request->reason
            ]);

            ServiceRequest::where('uuid', $serviceRequest['uuid'])->update(['status_id' => ServiceRequest::SERVICE_REQUEST_STATUSES['Canceled']]);

            //Create a record on `service_request_progresses`, `activity_logs` tables and send mail to either Admin or Client  
            $this->createRecordsAndSendMail($request, $serviceRequest);

            $cancelRequest = true;

        }, 3);

        //Send mail to recipient
        $this->sendCancellationMail($request, $serviceRequest);

        return $cancelRequest;
    }

    protected function createRecordsAndSendMail($request, $serviceRequest){

        $actionUrl = Route::currentRouteAction();

        //If request is still pending and payment was successful, credit client's wallet with booking fee.
        if(($serviceRequest['status_id'] == ServiceRequest::SERVICE_REQUEST_STATUSES['Pending']) && ($serviceRequest['payment']['status'] == \App\Models\Payment::STATUS['success'])){

            //Check if this request has been refunded already.
            if(!WalletTransaction::where('payment_id', $serviceRequest['payment']['id'])->exists()){
                //Credit client wallet account with booking fee.
                $this->creditClientWalletOnPendingRequest($request, $serviceRequest, $actionUrl);
            }
            
        }else{

            if($request->user()->type->role->slug == 'client-user'){

                //Record service request progress of `Client cancelled job request`
                ServiceRequestProgress::storeProgress($serviceRequest->client_id, $serviceRequest->id, 3, SubStatus::where('uuid', '06dda2af-3831-41af-854d-595e4f6f6b77')->firstOrFail()->id);

                $this->log('Request', 'Informational', $actionUrl, $serviceRequest['client']['account']['first_name'].' '.$serviceRequest['client']['account']['last_name'].' cancelled '.$serviceRequest['unique_id'].' job request.');

            }else{
                //Record service request progress of `Admin cancelled job request`
                ServiceRequestProgress::storeProgress(1, $serviceRequest->id, 3, SubStatus::where('uuid', '8aebf411-23ba-4ad0-8890-0918ac239376')->firstOrFail()->id);

                $this->log('Request', 'Informational', $actionUrl, $request->user()->email.' cancelled '.$serviceRequest['client']['account']['first_name'].' '.$serviceRequest['client']['account']['last_name'].' '.$serviceRequest['unique_id'].' service request.');
            }
        }

    }

    protected function creditClientWalletOnPendingRequest($request, $serviceRequest, $actionUrl){

        //Create record on `wallet_transactions` table
        $creditWallet = new WalletTransaction;
        $creditWallet['user_id']          = $serviceRequest->client_id;
        $creditWallet['payment_id']       = $serviceRequest['payment']['id'];
        $creditWallet['amount']           = $serviceRequest['price']['amount'];
        $creditWallet['payment_type']     = 'refund';
        $creditWallet['unique_id']        = $serviceRequest['client']['client']['unique_id'];
        $creditWallet['transaction_type'] = 'credit';

        //Check if client has at least a record on the `wallet_transactions` table
        if (!WalletTransaction::where('unique_id', $serviceRequest['client']['client']['unique_id'])->exists()) {
            $creditWallet['opening_balance'] = 0;
            $creditWallet['closing_balance'] = (float)$serviceRequest['price']['amount'];
        }else{
            $previousWallet = WalletTransaction::where('user_id', $serviceRequest->client_id)->latest('created_at')->first();
            $creditWallet['opening_balance'] = (float)$previousWallet->closing_balance;
            $creditWallet['closing_balance'] = (float)$previousWallet->closing_balance + (float)$serviceRequest['price']['amount'];
        }

        // save record
        $creditWallet->save();

        if($creditWallet){
            if($request->user()->type->role->slug == 'client-user'){

                //Record service request progress of `Client cancelled job request`
                ServiceRequestProgress::storeProgress($serviceRequest->client_id, $serviceRequest->id, 3, SubStatus::where('uuid', '06dda2af-3831-41af-854d-595e4f6f6b77')->firstOrFail()->id);
    
                $this->log('Request', 'Informational', $actionUrl, $serviceRequest['client']['account']['first_name'].' '.$serviceRequest['client']['account']['last_name'].' cancelled '.$serviceRequest['unique_id'].' job and the wallet account is credited with ₦'. $serviceRequest['price']['amount'].' as refund on pending service request cancellation.');
    
            }else{
                //Record service request progress of `Admin cancelled job request`
                ServiceRequestProgress::storeProgress(1, $serviceRequest->id, 3, SubStatus::where('uuid', '8aebf411-23ba-4ad0-8890-0918ac239376')->firstOrFail()->id);
    
                $this->log('Request', 'Informational', $actionUrl, $request->user()->email.' credited '.$serviceRequest['client']['account']['first_name'].' '.$serviceRequest['client']['account']['last_name'].' wallet account with ₦'. $serviceRequest['price']['amount'].' as refund on pending service request cancellation.');
            }
        }
        
    }

    protected function sendCancellationMail($request, $serviceRequest){

        //Mail object instance
        $sendMail = new \App\Http\Controllers\Messaging\MessageController();

        //Client mail data
        $clientMessageBody = collect([
            'firstname' => $serviceRequest['client']['account']['first_name'],
            'lastname'  => $serviceRequest['client']['account']['last_name'],
            'job_ref'   => $serviceRequest['unique_id'], 
            'reason'    => $request->reason, 
        ]);

        //Admin mail data
        $adminMessageBody = collect([
            'client_name' => $serviceRequest['client']['account']['first_name'].' '.$serviceRequest['client']['account']['last_name'],
            'job_ref'   => $serviceRequest['unique_id'], 
            'reason'    => $request->reason, 
        ]);

        if($request->user()->type->role->slug == 'client-user'){

            //Send mail to client
            $sendMail->sendNewMessage('', 'info@fixmaster.com.ng', $serviceRequest['client']['email'], $clientMessageBody, 'CUSTOMER_JOB_CANCELLATION_NOTIFICATION');

            //Send mail to Admin
            $sendMail->sendNewMessage('', 'info@fixmaster.com.ng', 'info@fixmaster.com.ng', $adminMessageBody, 'ADMIN_JOB_CANCELLATION_NOTIFICATION');

        }else{
             //Send mail to client
            $sendMail->sendNewMessage('', 'info@fixmaster.com.ng', $serviceRequest['client']['email'], $clientMessageBody, 'CUSTOMER_JOB_CANCELLATION_NOTIFICATION');
        }
    }
}