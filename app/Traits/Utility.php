<?php

namespace App\Traits;


use DB;
use Session;
use Auth;
use App\Models\User;
use App\Models\Client;
use App\Models\Cse;
use App\Models\Account;
use App\Models\Referral;
use App\Models\ServiceRequest;
use Illuminate\Support\Facades\Mail;
use App\Mail\MailNotify;
use App\Mail\WarrantyNotify;
use App\Traits\GenerateUniqueIdentity as Generator;
use App\Models\Warranty;
use Carbon\Carbon;
use App\Jobs\PushEmails;
use Illuminate\Support\Str;
use App\Http\Controllers\Messaging\MessageController;

trait Utility
{
  use Generator;

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

  public function markCompletedRequestTrait($user, $id){

    $admin = User::where('id', 1)->with('account')->first();
    $requestExists = ServiceRequest::where('uuid', $id)->with('service_request_assignees')->firstOrFail();
    $ifWarrantyExists =  \App\Models\ServiceRequestWarranty::where(['service_request_id'=> $requestExists->id, 'client_id'=> Auth::user()->id])
     ->first();
     $cse = [];

     if(!$ifWarrantyExists){
       return false;
     }
     
     $newDateTime = Carbon::now()->addDay((int)$ifWarrantyExists->warranty->duration);
    //ask for how warranties are assigned to client

       $updateServiceRequestWarranty = \App\Models\ServiceRequestWarranty::where(['client_id'=> $requestExists->client_id, 'service_request_id'=> $requestExists->id])
       ->update([
            'start_date'                    =>  Carbon::now()->toDateTimeString(),
            'expiration_date'               => $newDateTime->toDateTimeString(),
             'amount'                      =>   $requestExists->total_amount
          
         ]);

  
        $updateRequest = ServiceRequest::where('uuid', $id)->update([
             'status_id' =>  '4',
        ]);

        $recordServiceProgress = \App\Models\ServiceRequestProgress::create([
          'user_id'                       =>  $requestExists->client_id, 
          'service_request_id'            =>  $requestExists->id, 
          'status_id'                     => '4',
          'sub_status_id'                 =>  Auth::user()->type == 'admin'? '36':'35'
      ]);
      

      if($requestExists->service_request_assignees){
        foreach($requestExists->service_request_assignees as $item){
          if($item->user->roles[0]->url == 'cse'){
            $cse[] = [
              'email'=>$item->user->email,
               'first_name'=>$item->user->account->first_name,
               'last_name'=>$item->user->account->last_name
            ];
           
          }
        }
      
      }

   

        if($updateRequest AND $recordServiceProgress AND $updateServiceRequestWarranty){

           //send mails to 1.admin, 2.client, 3.cse for mark as completed;

             //email for admin
            $mail_data_admin = collect([
              'email' =>  $admin->email,
              'template_feature' => 'ADMIN_CSE_JOB_COMPLETED_NOTIFICATION',
              'firstname' =>  $admin->account->first_name,
              'lastname' =>  $admin->account->last_name,
              'job_ref' =>  $requestExists->unique_id,
              'url'   => url(app()->getLocale().'/admin/requests/'),
            ]);
            $mail1 = $this->mailAction($mail_data_admin);
      
            if($mail1 == '0')
            {

             $mail_data_client = collect([
                'email' =>  Auth::user()->email,
                'template_feature' => 'CUSTOMER_JOB_COMPLETED_NOTIFICATION',
                'firstname' =>   Auth::user()->account->first_name,
                'lastname' =>  Auth::user()->account->last_name,
                'url'   => url(app()->getLocale().'/client/requests/'),
              ]);
            $mail2 = $this->mailAction($mail_data_client);
            }
          
        
            if($mail2 == '0')
            {
            foreach ($cse as $value) {
            $mail_data_cse = collect([
              'email' =>  $value['email'],
              'template_feature' => 'ADMIN_CSE_JOB_COMPLETED_NOTIFICATION',
              'firstname' =>   $value['first_name'],
              'lastname' =>   $value['last_name'],
              'job_ref' =>  $requestExists->unique_id,
              'url'   => url(app()->getLocale().'/cse/requests/'),
            ]);
            $mail3 = $this->mailAction($mail_data_cse);

            }

            }
            return '1';
         }else{
           return false;
         }

   
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
     return  $jsonResponse = $messanger->sendNewMessage('', 'dev@fix-master.com', $data['email'], $data, $data['template_feature']);


  }

}