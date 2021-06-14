<?php
namespace App\Http\Controllers;

use Auth;
use Route;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Traits\Utility;
use App\Traits\Loggable;
use App\Models\Referral;
use Carbon\Carbon;
use App\Models\Cse;
use App\Models\Client;
use App\Models\User;
use App\Models\UserType;




class ReferralController extends Controller
{
    use Utility, Loggable;
    //
    public function index()
    {
        $referrals = Referral::select('accounts.first_name', 'url', 'accounts.last_name', 'referrals.*')->orderBy('referrals.id', 'DESC')
        ->join('accounts', 'accounts.user_id', '=', 'referrals.user_id')
        ->join('user_types', 'user_types.user_id', '=', 'referrals.user_id')
        ->where('referral_code', '!=' ,NULL)
        ->get();
    
        return response()->view('admin.referral.list', compact('referrals'));
    }

    public function create()
    {
    
        $data['entities'] = ['Client', 'Cse'];
        $data['cses'] = $this->cse_referral();
        $data['clients'] = $this->client_referral();
        return response()->view('admin.referral.add', $data);
    }

    public function store(Request $request){
        $this->validateRequest($request);
  
        if($request->entity == 'cse'){
       $user = User::select('*')->where('id', $request->cses)->first();
        }
        if($request->entity == 'client'){
        $user = User::select('*')->where('id', $request->users)->first();
     }

    if($user){
       $ifreferral = $this->updateVerifiedUsers($user, $request->entity);
     
       if($ifreferral){
            $msg = $request->entity == 'client'? 'Referral Link created successfully': 'Referral Code created successfully';
            $type = 'Request';
            $severity = 'Informational';
            $actionUrl = Route::currentRouteAction();
            $message = Auth::user()->email . ' Created Referrals for '. $user->id;
            $this->log($type, $severity, $actionUrl, $message);
            return redirect()->route('admin.referral_list', app()
                ->getLocale())->with('success',  $msg );

        }
        else
        {
            $type = 'Errors';
            $severity = 'Error';
            $actionUrl = Route::currentRouteAction();
            $message = 'An Error Occured while ' . Auth::user()->email . ' was trying to create referral for' .$user->id ;
            $this->log($type, $severity, $actionUrl, $message);
            return redirect()->route('admin.add_referral', app()
                ->getLocale())
                ->with('error', 'An error occurred 102');
       }

       
    }
 
    }
       
    
 
    private function validateRequest($request)
    {
        if($request->entity == 'cse'){
           
            return request()->validate([
             'entity' => 'required', 
             'cses' => 'required',
              ]);
        }
        if($request->entity == 'client'){
           
            return request()->validate([
             'entity' => 'required', 
             'users' => 'required',
              ]);
        }
    }


    public function delete($language, $referral)
    {

        $referralExists = Referral::where('uuid', $referral)->first();
        $referralEntity = Referral::select('referral_code', 'user_id')->where('uuid', $referral)
        ->join('users', 'users.id', '=' ,'referrals.user_id')
        ->first();
        //get usertype
        $first = strtok($referralEntity->referral_code, '-');
       
        if( $first== 'CLI'){
            Client::where('user_id',$referralEntity->user_id)->update([
            'referral_id' => NULL,
        ]);
        }
        if($first== 'CSE'){
            Cse::where('account_id', $referralEntity->user_id)->update([
                'referral_id' => 0,
            ]);
        }
        //Casted to SoftDelete
        $softDeleteUser =  $referralExists->delete();
        if ($softDeleteUser)
        {
            $type = 'Request';
            $severity = 'Informational';
            $actionUrl = Route::currentRouteAction();
            $message = Auth::user()->email . ' deleted referral code for ' . $referralEntity->email;
            $this->log($type, $severity, $actionUrl, $message);
            return redirect()->route('admin.referral_list', app()
                ->getLocale())
                ->with('success', 'Referral code has been deleted');
        }
        else
        {
            $type = 'Errors';
            $severity = 'Error';
            $actionUrl = Route::currentRouteAction();
            $message = 'An Error Occured while ' . Auth::user()->email . ' was trying to delete referral ' ;
            $this->log($type, $severity, $actionUrl, $message);
            return back()->with('error', 'An error occurred');

        }
    }


    public function deactivate($language, $referral)
    {
        $referralEntity = Referral::select('referral_code', 'user_id', 'users.email')->where('referrals.uuid', $referral)
        ->join('users', 'users.id', '=' ,'referrals.user_id')
        ->first();
    
        $deactivateReferral =  Referral::where('uuid', $referral)->update(['status' => 'deactivate' ]);

        if ($deactivateReferral)
        {
            $type = 'Request';
            $severity = 'Informational';
            $actionUrl = Route::currentRouteAction();
            $message = Auth::user()->email . ' deactivated referral for ' .   $referralEntity->email;
            $this->log($type, $severity, $actionUrl, $message);
            return redirect()->route('admin.referral_list', app()
                ->getLocale())
                ->with('success', 'Referral has been deactivated');
        }
        else
        {
            $type = 'Errors';
            $severity = 'Error';
            $actionUrl = Route::currentRouteAction();
            $message = 'An Error Occured while ' . Auth::user()->email . ' was trying to deactivate referral for ' .   $referralEntity->email;
            $this->log($type, $severity, $actionUrl, $message);
            return back()->with('error', 'An error occurred');
        }
    }

    public function reinstate($language, $referral)
    {
        $referralEntity = Referral::select('referral_code', 'user_id', 'users.email')->where('referrals.uuid', $referral)
        ->join('users', 'users.id', '=' ,'referrals.user_id')
        ->first();
    
        $activateReferral =  Referral::where('uuid', $referral)->update(['status' => 'activate' ]);
  
        if ($activateReferral )
        {
            $type = 'Request';
            $severity = 'Informational';
            $actionUrl = Route::currentRouteAction();
            $message = Auth::user()->email . ' activated referral for ' . $referralEntity->email;
            $this->log($type, $severity, $actionUrl, $message);
            return redirect()->route('admin.referral_list', app()
                ->getLocale())
                ->with('success', 'Referral has been activated');
        }
        else
        {
            $type = 'Errors';
            $severity = 'Error';
            $actionUrl = Route::currentRouteAction();
            $message = 'An Error Occured while ' . Auth::user()->email . ' was trying to activate referral for ' .   $referralEntity->email;            $this->log($type, $severity, $actionUrl, $message);
            return back()->with('error', 'An error occurred');
        }
    }

}

