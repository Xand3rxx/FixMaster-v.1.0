<?php

namespace App\Traits;


use Session;
use Carbon\Carbon;
use App\Models\Cse;
use App\Models\User;
use App\Models\Client;
use App\Models\Account;
use App\Jobs\PushEmails;
use App\Mail\MailNotify;
use App\Models\Referral;
use App\Models\Warranty;
use App\Traits\Loggable;
use Illuminate\Support\Str;
use App\Mail\WarrantyNotify;
use App\Models\ServiceRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use App\Traits\GenerateUniqueIdentity as Generator;
use App\Http\Controllers\Messaging\MessageController;

trait Utility
{
  use Generator, Loggable;

  public function entityArray()
  {
    $objects = [];
    $names = ['Client', 'Service', 'Estate'];
    for ($i = 0; $i < Count($names); $i++) {
      $objects[] = (object)["id" => $i + 1, "name" => $names[$i],];
    }

    return $objects;
  }

  public function filterEntity($request)
  {
    $user = '';
    if ($request->entity != 'service') {
      $user = array_filter($request->users);
    }
    if ($request->entity == 'service') {
      if (isset($request->services)) {
        $user = array_filter($request->services);
      }
      if (isset($request->category) && !isset($request->services)) {
        $user = array_filter($request->category);
      }
    }
    return $user;
  }

  public function updateVerifiedUsers($user, $user_type = '')
  {

    if ($user->email_verified_at == NULL) {
       return false;
    }

    $type = $user_type != '' ? $user_type : $user->type->url;
    $created_by = $user_type != '' ? Auth::user()->email : $user->email;
    $mail = '';
  
   
    //updates firsttime  on users table to if user is not firsttime login
    switch ($type) {
      case 'client':


        $referral = '';
        $client = Client::select('firsttime')->where('account_id', $user->id)
          ->first();

          if ($user->email_verified_at != NULL && $client->firsttime == 1) {
            return false;
           }

        if ($user->email_verified_at != NULL && $client->firsttime == 0) {

          $code = $this->generate('referrals', 'ClI-', 'referral_code'); // Create a Unique referral code
          $ifReferrals = Referral::select('id')->where('user_id', $user->id)
            ->first();

          //check if user already has referral code
          if ($ifReferrals) {
            Referral::where('user_id', $user->id)
              ->update(['referral_code' => $code, 'created_by' => $created_by]);
            $referral = $ifReferrals->id;
          } else {
            $_referral = Referral::create(['user_id' => $user->id, 'referral_code' => $code, 'created_by' => $created_by]);
            $referral = $_referral->id;
          }

          $account = Account::where('user_id', $user->id)
            ->first();

          if ($account) {

            Client::where('account_id', $user->id)
              ->update(['referral_id' => $referral, 'firsttime' => 1,]);
            $data = (object)['firstname' => $account->first_name, 'code' => $code, 'email' => $user->email, 'type' => 'client'];
        
            $mail = $this->sendRefferalMail($data, $user_type, $type);
            return $mail;
          }
        }

        if ($user_type != '' && $user->email_verified_at == NULL) {

          $code = $this->generate('referrals', 'ClI-', 'referral_code'); // Create a Unique referral code
          $ifReferrals = Referral::select('id')->where('user_id', $user->id)
            ->first();

          //check if user already has referral code
          if ($ifReferrals) {
            Referral::where('user_id', $user->id)
              ->update(['referral_code' => $code, 'created_by' => $created_by]);
            $referral = $ifReferrals->id;
          } else {
            $_referral = Referral::create(['user_id' => $user->id, 'referral_code' => $code, 'created_by' => $created_by]);
            $referral = $_referral->id;
          }

          $client = Client::where('account_id', $user->id)
            ->update(['referral_id' => $referral,]);
          $account = Account::where('user_id', $user->id)
            ->first();

          if ($account) {
            Client::where('account_id', $user->id)
              ->update(['referral_id' => $referral, 'firsttime' => 1,]);

            User::where('email', $user->email)
              ->update(['email_verified_at' => date("Y-m-d H:i:s"),]);
            $data = (object)['firstname' => $account->first_name, 'code' => $code, 'email' => $user->email, 'type' => 'client'];
            $mail = $this->sendRefferalMail($data, $user_type, $type);
            return $mail;
          }
        }


        break;
      case 'cse':
        $referral = '';

        $cse = Cse::select('firsttime')->where('account_id', $user->id)
          ->first();
          if ($user->email_verified_at != NULL && $cse->firsttime == 1) {
            return false;
           }

        if ($user->email_verified_at != NULL && $cse->firsttime == 0) {
          $unique_id = Cse::where('user_id', $user->id)
            ->first();
          if ($unique_id) {
            $ifReferrals = Referral::select('id')->where('user_id', $user->id)
              ->first();

            //check if user already has referral code
            if ($ifReferrals) {
              Referral::where('user_id', $user->id)
                ->update(['referral_code' => $unique_id->unique_id, 'created_by' => $created_by]);
              $referral = $ifReferrals->id;
            } else {
              $_referral = Referral::create(['user_id' => $user->id, 'referral_code' => $unique_id->unique_id, 'created_by' => $created_by]);
              $referral = $_referral->id;
            }
          }

          $client = Client::where('account_id', $user->id)
            ->update(['referral_id' => $referral,]);
          $account = Account::where('user_id', $user->id)
            ->first();
          if ($account) {
            Cse::where('user_id', $user->id)
              ->update(['referral_id' => $referral, 'firsttime' => 1]);
            $data = (object)['firstname' => $account->first_name, 'code' => $unique_id->unique_id, 'email' => $user->email, 'type' => 'cse'];
            $mail = $this->sendRefferalMail($data, $user_type, $type);
            return $mail;
          }
        }

        if ($user_type != '' && $user->email_verified_at == NULL) {
          $unique_id = Cse::where('user_id', $user->id)->first();
          if ($unique_id) {
            $ifReferrals = Referral::select('id')->where('user_id', $user->id)->first();
            //check if user already has referral code 
            if ($ifReferrals) {
              Referral::where('user_id', $user->id)->update([
                'referral_code' => $unique_id->unique_id,
                'created_by' => $created_by
              ]);
              $referral = $ifReferrals->id;
            } else {
              $_referral = Referral::create(['user_id' => $user->id, 'referral_code' => $unique_id->unique_id, 'created_by' => $created_by]);
              $referral = $_referral->id;
            }
          }
          Cse::where('user_id', $user->id)->update([
            'referral_id' =>  $referral,
          ]);
          $client = Client::where('account_id', $user->id)->update([
            'referral_id' => $referral,
          ]);
          $account = Account::where('user_id', $user->id)->first();
             //check if account already has referral code 
          if ($account) {
            User::where('email', $user->email)
              ->update(['email_verified_at' => date("Y-m-d H:i:s"),]);

            Cse::where('user_id', $user->id)
              ->update(['referral_id' => $referral, 'firsttime' => 1]);
            $data = (object)[
              'firstname' => $account->first_name,
              'code' => $unique_id->unique_id,
              'email' => $user->email,
              'type' => 'cse'
            ];
            $mail = $this->sendRefferalMail($data, $user_type, $type);
            return $mail;
          }
        }

        break;
      default:
        # code...
        break;
    }
    if ($mail == '1') {
      return $mail;
    }
  }

  public function sendRefferalMail($user, $user_type, $type)
  {
    
    $name = ucfirst($user->firstname);
    if ($user_type == '' && $type == 'client') {
      $url =  app()->getLocale().'/verify/?code='.$user->code;
       $mail_data = collect([
        'email' =>  $user->email,
        'template_feature' => 'CLIENT_REFERRAL_NOTIFICATION',
        'url' =>  url($url),
        'firstname' =>  $name,
     ]);

       $mail = $this->mailAction( $mail_data);
       return '1';
  
    }
    if ($user_type == '' && $type == 'cse') {

      $url =  $user->code;
       $mail_data = collect([
        'email' =>  $user->email,
        'template_feature' => 'CSE_REFERRAL_NOTIFICATION',
        'url' => $url ,
        'firstname' =>  $name,
     ]);
     
       $mail = $this->mailAction($mail_data);
       return '1';
    } 


  }

  public function authenticateRefferralLink($link)
  {
    $check = Referral::where(['referral_code' => $link, 'status' => 'activate'])->first();
    if ($check == null) {
      return false;
    }
    return $check;
  }

  public function cse_referral()
  {
    $results = $ref = [];
    $cse = Cse::select('accounts.first_name', 'accounts.last_name', 'cses.account_id', 'unique_id')->join('accounts', 'accounts.user_id', '=', 'cses.account_id')
      ->orderBy('accounts.first_name', 'ASC')
      ->get();
    $referral = Referral::select('user_id')->get()
      ->toArray();
    foreach ($referral as $value) {
      $ref[] = $value['user_id'];
    }
    foreach ($cse as $value) {
      if (!in_array($value->account_id, $ref)) {
        $results[] = $value;
      }
    }

    return $results;
  }

  public function client_referral()
  {
    $results = $ref = [];
    $clients = Client::select('accounts.first_name', 'accounts.last_name', 'clients.account_id')->join('accounts', 'accounts.user_id', '=', 'clients.account_id')
      ->orderBy('accounts.first_name', 'ASC')
      ->get();
    $referral = Referral::select('user_id')->get()
      ->toArray();
    foreach ($referral as $value) {
      $ref[] = $value['user_id'];
    }
    foreach ($clients as $value) {
      if (!in_array($value->account_id, $ref)) {
        $results[] = $value;
      }
    }

    return $results;
  }

  /* Return distinct year from a particular table's created at
  *  string  $tableName
  *  return array
  */
  public function getDistinctYears($tableName){
        //Array to
        $yearList = array();

        //Get a collection of `created_at` from $tableName
        $years = DB::table($tableName)->orderBy('created_at', 'ASC')->pluck('created_at');

        $years = json_decode($years);

        if(!empty($years)){
            foreach($years as $year){
                $date = new \DateTime($year);

                $yearNumber = $date->format('y');

                $yearName = $date->format('Y');

                array_push($yearList, $yearName);
            }
        }

        return array_unique($yearList);
  }


  public function sendWarrantyInitiationMail($user, $type)
  {
    $name = ucfirst($user->name);
    Mail::to($user->email)->send(new WarrantyNotify($user));
    if ($type == 'client') {
      Session::flash('success', "Welcome $name, your refferal link has been sent to your mail");
    }
    if ($type == 'cse') {
      Session::flash('success', "Welcome $name, your refferal code has been sent to your mail");
    } else {
      return '1';
    }
  }

  public function markCompletedRequestTrait($serviceRequest){

    //Check if the service was paid for successfully.
    if($serviceRequest['payment']['status'] == \App\Models\Payment::STATUS['success']){

      //Validate if warranty already exist on `service_request_warranties` table for this service request.
      $requestWarranty = \App\Models\ServiceRequestWarranty::where(['client_id'  => $serviceRequest['client_id'], 'service_request_id' => $serviceRequest['id']])->with('warranty')->first();

      //Status UUID for marking a job as completed
      $statusUUID = (auth()->user()->roles[0]->slug == 'super-admin' || auth()->user()->roles[0]->slug == 'admin-user') ? 'ce316687-62d8-45a9-a1b9-f75da104fc18' : 'fca5a961-39d4-42e5-be9d-20e4b579d4b1';

      $actionUrl = Route::currentRouteAction();

      //Check if the request is an Ongoing request
      if($serviceRequest['status_id'] == ServiceRequest::SERVICE_REQUEST_STATUSES['Ongoing']){

        //Set `markAsCompleted` to false before Db transaction
        (bool) $markAsCompleted  = false;

        //Create new record for CSE on `service_request_cancellations` table.
        DB::transaction(function () use ($serviceRequest, $statusUUID, $actionUrl, $requestWarranty, &$markAsCompleted) {

            //Update record on `service_requests` table.
            \App\Models\ServiceRequest::where('uuid', $serviceRequest['uuid'])->update([
                'status_id'       => ServiceRequest::SERVICE_REQUEST_STATUSES['Completed'],
                'date_completed'  =>  now(), 
            ]);

            //Validate if client paid for Final Invoice and Update warranty record 
            if(\App\Models\ServiceRequestPayment::where(['user_id'  => $serviceRequest['client_id'], 'service_request_id' => $serviceRequest['id'], 'payment_type' =>  'final-invoice-fee'])->exists()){
                $this->issuedWarranty($requestWarranty);
            }
            
            //Record service request progress of `Admin marked job as completed`
            \App\Models\ServiceRequestProgress::storeProgress(auth()->user()->id, $serviceRequest['id'], 4, \App\Models\SubStatus::where('uuid', $statusUUID)->firstOrFail()->id);

            //Log this action
            (auth()->user()->roles[0]->slug == 'client-user') ? 
              $this->log('Request', 'Informational', $actionUrl, $serviceRequest['client']['account']['first_name'].' '.$serviceRequest['client']['account']['last_name'].' marked '.$serviceRequest['unique_id'].' job request as completed.') 
            : 
              $this->log('Request', 'Informational', $actionUrl, auth()->user()->email.' marked '.$serviceRequest['client']['account']['first_name'].' '.$serviceRequest['client']['account']['last_name'].' '.$serviceRequest['unique_id'].' service request as completed.');

            $markAsCompleted = true;

        }, 3);

        if(empty($requestWarranty)){

          $warrantyDetails = '';
          $warrantyDays = '0';
        }else{

          $warrantyDetails = '<p style="margin-bottom: 0.28cm; line-height: 108%"><span style="background-color: transparent;"><b><u>WARRANTY DETAILS</u></b></span></p><p style="margin-bottom: 1rem;"><span style="font-weight: bolder;">Warranty Name:&nbsp;</span>'.$requestWarranty['warranty']['name'].'</p><p style="margin-bottom: 1rem;"><span style="font-weight: bolder;">Start Date:&nbsp;</span>'.$requestWarranty['start_date'].'</p><p style="margin-bottom: 1rem;"><span style="font-weight: bolder;">Expiry Date:&nbsp;</span>'.$requestWarranty['expiration_date'].'</p>';

          $warrantyDays = $requestWarranty['warranty']['duration'];
        }
        

        //Send mails to Client, CSE, and FixMaster
        $adminEmailData = collect([
          'email'                 =>  'info@fixmaster.com.ng',
          'template_feature'      =>  'ADMIN_CUSTOMER_JOB_COMPLETED_NOTIFICATION',
          'firstname'             =>  'FixMaster',
          'lastname'              =>  'Administrator',
          'job_ref'               =>  $serviceRequest['unique_id'],
          'warranty_days'         =>  $warrantyDays,
          'warranty_details'      =>  $warrantyDetails,
          'client_name'           => ucfirst($serviceRequest['client']['client']['account']['first_name'].' '.$serviceRequest['client']['client']['account']['last_name']),
          'url'                   =>  url(app()->getLocale().'/admin/requests-completed/'),
        ]);

        $clientEmailData = collect([
          'email'                 =>  $serviceRequest['client']['email'],
          'template_feature'      =>  'CUSTOMER_JOB_COMPLETED_NOTIFICATION',
          'firstname'             =>  $serviceRequest['client']['client']['account']['first_name'],
          'lastname'              =>  $serviceRequest['client']['client']['account']['last_name'],
          'job_ref'               =>  $serviceRequest['unique_id'],
          'warranty_days'         =>  $warrantyDays,
          'warranty_details'      =>  $warrantyDetails,
          'url'                   =>  url(app()->getLocale().'/client/requests/'),
        ]);

        //Send mail to Admin
        $this->mailAction($adminEmailData);
        //Send mail to Client
        $this->mailAction($clientEmailData);
        //Send mail to CSE
        if(collect($serviceRequest['service_request_assignees'])->isNotEmpty()){
          foreach($serviceRequest['service_request_assignees'] as $item){
            if($item['user']['roles'][0]['slug'] == 'cse-user'){
              $cseEmailData = collect([
                'email'             =>  $item['user']['email'],
                'template_feature'  =>  'ADMIN_CSE_JOB_COMPLETED_NOTIFICATION',
                'first_name'        =>  ucfirst($item['user']['account']['first_name']),
                'last_name'         =>  ucfirst($item['user']['account']['last_name']),
                'job_ref'           =>  $serviceRequest['unique_id'],
                'url'               =>  url(app()->getLocale().'/cse/requests/status?status=Completed'),
              ]);

              $this->mailAction($cseEmailData);
            }
          }
        }

        return $markAsCompleted;

      }else{

          return response()->json(['error' => 'Sorry! This request must have an Ongoing status.']);
      }
      
    }else{
      return back()->with('error', 'Sorry! Please confirm payment for this request.');
    }

  }

  public function issuedWarranty($requestWarranty){
  
    //Update record on `service_request_warranties` table
    $requestWarranty->update([
        'start_date'            =>  now(),
        'expiration_date'       =>  Carbon::now()->addDay((int)$requestWarranty['warranty']['duration'])->toDateTimeString(),
        'status'                => 'unused',
        'initiated'             => 'No',
        'has_been_attended_to'  => 'No',
    ]);
  }

  public function addDiscountToFirstTimeUserTrait($user){

    $userDetails =  $user->account;
    $discountDetails =  \App\Models\Discount::where(['id'=> '1'])->first();
 
  $client =  \App\Models\ClientDiscount::create([
                'discount_id' => '1',
                'client_id' => $userDetails->user_id,
                    ]);
            

   $discountHistory = \App\Models\DiscountHistory::create([
            'discount_id' => '1',
            'client_name' =>   $userDetails->first_name.' '.  $userDetails->last_name,
            'client_id' => $userDetails->user_id,
         ]);
      if($client AND $discountHistory){
           $mail_data = collect([
            'email' =>  $user->email,
            'template_feature' => 'CUSTOMER_WELCOME_DISCOUNT',
            'discount' => $discountDetails->rate,
            'firstname' =>  $userDetails->first_name,
         ]);
      
     
       $mail = $this->mailAction($mail_data);
       return '1';
      }

      

  }

  public function mailAction($data){
      $messanger = new MessageController();
     return  $jsonResponse = $messanger->sendNewMessage('', 'info@fixmaster.com.ng', $data['email'], $data, $data['template_feature']);


  }

}