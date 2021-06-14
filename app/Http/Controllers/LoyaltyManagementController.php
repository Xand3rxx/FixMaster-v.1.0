<?php
namespace App\Http\Controllers;

use Auth;
use Route;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Traits\Utility;
use App\Traits\Loggable;
use App\Models\LoyaltyManagement;
use App\Models\LoyaltyManagementHistory;
use App\Models\ServiceRequest;
use App\Models\Rating;
use Carbon\Carbon;
use App\Models\Client;
use App\Models\User;
use App\Models\UserType;
use App\Models\ClientLoyaltyWithdrawal;




class LoyaltyManagementController extends Controller
{
    use Utility, Loggable;
    //
    public function index()
    {
        $loyalty = LoyaltyManagement::select('accounts.first_name', 'accounts.last_name', 'accounts.user_id', 'loyalty_managements.*')
        ->orderBy('accounts.user_id', 'DESC')
        ->join('accounts', 'accounts.user_id', '=', 'loyalty_managements.client_id')
        ->get();
        return response()->view('admin.loyalty.list', compact('loyalty'));
    }

    public function create()
    {
        $data['clients']=  Client::select('accounts.first_name', 'accounts.last_name', 'accounts.user_id')->orderBy('clients.user_id', 'DESC')
        ->join('accounts', 'accounts.user_id', '=', 'clients.user_id')
        ->get();

        return response()->view('admin.loyalty.add', $data);
    }

    public function store(Request $request){
        $this->validateRequest($request);
        $wallet_value = (float)$request->input('points')/100 * (float)$request->input('specified_request_amount');

   foreach ($request->input('users') as $value) {

        $loyalty = LoyaltyManagement::create([
            'client_id' => $value ,
             'points' => $request->input('points'),
             'type' => 'credited',
             'amount'=> $request->input('specified_request_amount')

            ]);

            $loyalty_history = LoyaltyManagementHistory::create([
                'loyalty_mgt_id'=> $loyalty->id,
                'client_id' => $value ,
                'points' => $request->input('points'),
                'type' => 'credited',
                'amount'=> $request->input('specified_request_amount')

               ]);

               //if clientloyalty wallet exist
           $ifClientLoyalty =  ClientLoyaltyWithdrawal::where('client_id', $value)->first();
           if($ifClientLoyalty){
            ClientLoyaltyWithdrawal::where(['client_id'=> $value])->increment(
                'wallet',(float) $wallet_value);
           }else{
            ClientLoyaltyWithdrawal::create([
                'loyalty_mgt_id'=> $loyalty->id,
                'client_id' => $value,
                'wallet' => $wallet_value
            ]);

           }


        }

            if( $loyalty_history  &&   $loyalty ){

                $type = 'Request';
                $severity = 'Informational';
                $actionUrl = Route::currentRouteAction();
                $message = Auth::user()->email . ' Created loyalty for' . json_encode($request->input('users'));
                $this->log($type, $severity, $actionUrl, $message);
                return redirect()->route('admin.loyalty_list', app()
                    ->getLocale())
                    ->with('success', 'Loyalty created successfully');
            }
            else
            {
                $type = 'Errors';
                $severity = 'Error';
                $actionUrl = Route::currentRouteAction();
                $message = 'An Error Occured while ' . Auth::user()->email . ' was trying to create ' . json_encode($request->input('users'));
                $this->log($type, $severity, $actionUrl, $message);
                return redirect()->route('admin.add_loyalty', app()->getLocale())
                    ->with('error', 'An error occurred');

            }

    }

    public function loyaltyUsers(Request $request)
    {
        if ($request->ajax())
        {
            $name = $optionValue = '';
           $amount = $request->amount;
           if($amount != ''){

           $dataArry = ServiceRequest::select('client_id','first_name', 'last_name')
           ->where(['total_amount'=> $amount, 'status_id'=> '4'])
           ->leftJoin('accounts', 'accounts.user_id', '=', 'service_requests.client_id')
           ->leftJoin('ratings','ratings.user_id', '=', 'service_requests.client_id')
           ->groupBy('client_id')
                ->get();

            $optionValue .= "<option value='' class='select-all'>All Users </option>";
            foreach ($dataArry as $row)
            {
                $name = $row->first_name . ' ' . $row->last_name;
                $optionValue .= "<option value='$row->client_id' {{ old('users') == $row->client_id ? '' : ''}}>$name</option>";
            }
        }else{

            $dataArry = ServiceRequest::select('client_id','first_name', 'last_name')
            ->leftJoin('accounts', 'accounts.user_id', '=', 'service_requests.client_id')
            ->leftJoin('ratings','ratings.user_id', '=', 'service_requests.client_id')
            ->where(['status_id'=> '4'])
            ->groupBy('client_id')
                 ->get();

             $optionValue .= "<option value='' class='select-all'>All Users </option>";
             foreach ($dataArry as $row)
             {
                 $name = $row->first_name . ' ' . $row->last_name;
                 $optionValue .= "<option value='$row->client_id' {{ old('users') == $row->client_id ? '' : ''}}>$name</option>";
             }

        }

            $data = array(
                'options' => $optionValue,
                'count'=> count($dataArry)
            );

        }

        return response()->json($data);

    }




    public function show($language, $loyalty)
    {

            $status =  LoyaltyManagement::select('accounts.first_name', 'accounts.last_name', 'accounts.user_id','loyalty_managements.*', 'client_loyalty_withdrawals.wallet as wallets')
            ->orderBy('accounts.user_id', 'DESC')
            ->where('loyalty_managements.uuid', $loyalty)
            ->join('accounts', 'accounts.user_id', '=', 'loyalty_managements.client_id')
            ->join('client_loyalty_withdrawals', 'client_loyalty_withdrawals.client_id', '=', 'loyalty_managements.client_id')
            ->first();
            $data = ['loyalty' => $status ];
            $data['client-loyalty']   = ClientLoyaltyWithdrawal::select('wallet', 'withdrawal')->where('client_id', $status->client_id)->first();

            $json = $data['client-loyalty']->withdrawal != NULL? json_decode($data['client-loyalty']->withdrawal): [];
            $ifwithdraw = isset($json->withdraw)? $json->withdraw: '';
            $ifwithdraw_date = isset($json->date)? $json->date: '';
            $data['withdraws']=  empty($json) ? [] : (is_array($ifwithdraw) ? $ifwithdraw : [ 0 => $ifwithdraw]);
            $data['withdraw_date']= empty($json)? [] : ( is_array( $ifwithdraw_date) ?  $ifwithdraw_date: [ 0 =>  $ifwithdraw_date]);

            return response()->view('admin.loyalty.summary', $data);
    }




    public function edit($language, $loyalty)
    {
        $status = LoyaltyManagement::select('*')->where('uuid', $loyalty)->first();
        $wallet = ClientLoyaltyWithdrawal::select('wallet')->where('client_id', $status->client_id)->first();
        $data = ['status' => $status, 'wallet'=> $wallet->wallet];
        return response()->view('admin.loyalty.edit', $data);
    }



    public function store_edit(Request $request)
    {
        $this->validateRequest($request);

        $oldLoyalty = LoyaltyManagement::where(['uuid'=>$request->loyalty_uuid, 'client_id' => $request->edit_client])->first();
        $old_amount =  (float)$oldLoyalty->points/100 * (float)$oldLoyalty->amount;
        $wallet_value = (float)$request->input('points')/100 * (float)$request->input('specified_request_amount');
        $edit_wallet_old_client = ((float)$request->wallet - (float)$old_amount) + (float)  $wallet_value;


    foreach ($request->input('users') as $value) {

        $loyalty = LoyaltyManagement::create([
            'client_id' => $value ,
             'points' => $request->input('points'),
             'type' => 'credited',
             'amount'=> $request->input('specified_request_amount')

            ]);

            $loyalty_history = LoyaltyManagementHistory::create([
            'client_id' => $value ,
             'points' => $request->input('points'),
             'type' => 'credited',
             'amount'=> $request->input('specified_request_amount')

                ]);

                       //if clientloyalty wallet exist
               $ifClientLoyalty =  ClientLoyaltyWithdrawal::where('client_id', $value)->first();
               if($ifClientLoyalty && $request->edit_client == $value){
                $oldLoyalty = ClientLoyaltyWithdrawal::where(['client_id' => $request->edit_client])->first();
                ClientLoyaltyWithdrawal::where(['client_id'=> $value])->update([
                    'wallet'=> $edit_wallet_old_client ]);
               }

                  //if clientloyalty wallet exist but client is just added
               if($ifClientLoyalty && $request->edit_client != $value){
                $oldLoyalty = ClientLoyaltyWithdrawal::where(['client_id' => $request->edit_client])->first();
                ClientLoyaltyWithdrawal::where(['client_id'=> $value])->increment(
                    'wallet', $wallet_value);
               }
               if(!$ifClientLoyalty){
                ClientLoyaltyWithdrawal::create([
                    'loyalty_mgt_id'=> $loyalty->id,
                    'client_id' => $value,
                    'wallet' => $wallet_value
                ]);

               }



        }

            if( $loyalty_history  && $loyalty){
                LoyaltyManagement::where(['uuid'=>$request->loyalty_uuid, 'client_id' => $request->edit_client])->delete();
                LoyaltyManagementHistory::where(['loyalty_mgt_id'=>$request->loyalty_id,'client_id' => $request->edit_client])->delete();

                $type = 'Request';
                $severity = 'Informational';
                $actionUrl = Route::currentRouteAction();
                $message = Auth::user()->email . ' Edited loyalty for' . json_encode($request->input('users'));
                $this->log($type, $severity, $actionUrl, $message);
                return redirect()->route('admin.loyalty_list', app()
                    ->getLocale())
                    ->with('success', 'Loyalty edited successfully');
            }
            else
            {
                $type = 'Errors';
                $severity = 'Error';
                $actionUrl = Route::currentRouteAction();
                $message = 'An Error Occured while ' . Auth::user()->email . ' was trying to edit ' . json_encode($request->input('users'));
                $this->log($type, $severity, $actionUrl, $message);
                return redirect()->route('admin.add_loyalty', app()
                    ->getLocale())
                    ->with('error', 'An error occurred');

            }
    }



    private function validateRequest($request)
    {
         return request()->validate([
            'users' => 'required|array|min:1',
             'points' => 'required',
             'specified_request_amount'=> 'required'
              ]);


    }

    public function loyaltyUsersEdit(Request $request)
    {
        if ($request->ajax())
        {

            parse_str($request->data, $fields);
            $name = $optionValue = '';
           $amount = $request->amount;
           $edit_amount =  isset($fields['edit_amount'])? $fields['edit_amount']: '';
           $client = isset($fields['edit_client'])? $fields['edit_client']: '';

           if($amount != ''){

           $dataArry = ServiceRequest::select('client_id','first_name', 'last_name')->where(['total_amount'=> $amount, 'status_id'=> '4'])
           ->join('accounts', 'accounts.user_id', '=', 'service_requests.client_id')
           ->join('ratings','ratings.user_id', '=', 'service_requests.client_id')
           ->where(['status_id'=> '4'])
                ->get();

            $optionValue .= "<option value='' class='select-all'>All Users </option>";
            foreach ($dataArry as $row)
            {
                $name = $row->first_name . ' ' . $row->last_name;
                $optionValue .= "<option value='$row->client_id' {{ old('users') == $row->client_id ? '' : ''}}>$name</option>";
            }
        }else{

            $dataArry = ServiceRequest::select('client_id','first_name', 'last_name')
            ->join('accounts', 'accounts.user_id', '=', 'service_requests.client_id')
            ->join('ratings','ratings.user_id', '=', 'service_requests.client_id')
            ->where(['total_amount'=> $edit_amount, 'status_id'=> '4'])
            ->groupBy('client_id')
                 ->get();

             $optionValue .= "<option value='' class='select-all'>All Users </option>";
             foreach ($dataArry as $row)
             {
                 $name = $row->first_name . ' ' . $row->last_name;
                 $selected = $client == $row->client_id ? 'selected': '';
                 $optionValue .= "<option value='$row->client_id' $selected >$name</option>";
             }

        }

            $data = array(
                'options' => $optionValue,
                'count'=> count($dataArry)
            );

        }

        return response()->json($data);

    }


    public function delete($language, $loyalty, $client)
    {


       $loyaltyExists =  LoyaltyManagement::where(['uuid'=>$loyalty, 'client_id'=> $client])->first();
       $old_amount =  (float)$loyaltyExists->points/100 * (float) $loyaltyExists->amount;

       $oldLoyalty = ClientLoyaltyWithdrawal::where(['client_id' => $client])->first();

       if((float) $oldLoyalty->wallet > (float)$old_amount){
       $wallet_new_client = ((float) $oldLoyalty->wallet - (float)$old_amount);
       ClientLoyaltyWithdrawal::where(['client_id'=> $client])->update(['wallet'=>  $wallet_new_client ]);
       }
       if((float) $oldLoyalty->wallet == (float)$old_amount){
        ClientLoyaltyWithdrawal::where(['client_id'=> $client])->delete();
        }


        //Casted to SoftDelete
        $softDeleteloyalty =  $loyaltyExists->delete();
        if ($softDeleteloyalty)
        {
            $type = 'Request';
            $severity = 'Informational';
            $actionUrl = Route::currentRouteAction();
            $message = Auth::user()->email . ' deleted loyalty' .$loyalty;
            $this->log($type, $severity, $actionUrl, $message);
            return redirect()->route('admin.loyalty_list', app()
                ->getLocale())
                ->with('success', 'Loyalty has been deleted');
        }
        else
        {
            $type = 'Errors';
            $severity = 'Error';
            $actionUrl = Route::currentRouteAction();
            $message = 'An Error Occured while ' . Auth::user()->email . ' was trying to delete ' . $loyalty;
            $this->log($type, $severity, $actionUrl, $message);
            return back()->with('error', 'An error occurred');

        }
    }

    public function history()
    {
        $loyalty = LoyaltyManagementHistory::select('accounts.first_name', 'accounts.last_name', 'accounts.user_id', 'loyalty_management_histories.*')
        ->orderBy('accounts.user_id', 'DESC')
        ->join('accounts', 'accounts.user_id', '=', 'loyalty_management_histories.client_id')
        ->get();
        return response()->view('admin.loyalty.history', compact('loyalty'));
    }



}

