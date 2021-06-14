<?php

namespace App\Http\Controllers\QualityAssurance;

use App\Http\Controllers\Controller;
use App\Traits\Loggable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Route;
use Redirect;
use Illuminate\Support\Facades\Auth;
use Session;
use App\Models\User;
use App\Models\QA;
use App\Rules\MatchOldPassword;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Traits\PasswordUpdator;

class QualityAssuranceProfileController extends Controller
{
    use Loggable, PasswordUpdator;

    /**
     * This method will redirect users back to the login page if not properly authenticated
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:web');
    }

    public function view_profile(Request $request){
        $user = User::where('id', Auth::id())->first();
        return view('quality-assurance.view_profile', compact('user'));
    }

    public function edit(Request $request){

        $result = User::findOrFail(Auth::id());

        $banks = \App\Models\Bank::get(['id', 'name']);

        return view('quality-assurance.edit_profile', compact('result', 'banks'));
    }

    public function update(Request $request){
    $user = User::where('id', Auth::id())->first();
    if($user->account->gender == "male"){
        $res = "his";
    }else{
        $res ="her";
    }

    $type = "Profile";
    $severity = "Informational";
    $actionUrl = Route::currentRouteAction();
    $message = $user->email.' profile successfully updated ';
        $rules = [
            'first_name' => 'required|max:255',
            'middle_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'gender' => 'required|max:255',
            'phone_number' => 'required',
            'profile_avater' => 'mimes:jpeg,jpg,png,gif',
            'full_address' => 'required',
            'address_longitude'=> 'sometimes|string',
            'address_latitude'=> 'sometimes|string',
            'account_number' => 'required|string',
            'bank_id' => 'required|numeric'
          ];

          $messages = [
             'first_name.required' => 'First Name field can not be empty',
             'middle_name.required' => 'Middle Name field can not be empty',
             'last_name.required' => 'Last Name field can not be empty',
             'gender.required' => 'Please select gender',
             'phone_number.required' => 'Please select phone number',
             'profile_avater.mimes'    => 'Unsupported Image Format',
             'address_latitude.float' => 'Unsupported Address Latitude Format',
             'address_longitude.float' => 'Unsupported Address Longitude Format'
          ];

          $validator = Validator::make($request->all(), $rules, $messages);
        if($validator->fails()){
            return redirect()->back()->withErrors($validator->errors());
        }else{

        if($request->hasFile('profile_avater')){
            $filename = $request->profile_avater->getClientOriginalName();
            $request->profile_avater->move('assets/user-avatars', $filename);
        }else{
            $filename = $user->account->avatar;
        }

        //dd($request->address_longitude);

    $user->account->update([
        'user_id'=>$user->id,
        'first_name' =>$request->first_name,
        'middle_name'=>$request->middle_name,
        'last_name'=>$request->last_name,
        'gender'=>$request->gender,
        'avatar'=>$filename,
        'bank_id' => $request->bank_id,
        'account_number' =>$request->account_number
    ]);

    $user->contact->update([
        'user_id'=>$user->id,
        'phone_number'=>$request->phone_number,
        'address'=>$request->full_address,
        'address_longitude' => !empty($request->address_longitude) ? $request->address_longitude : $user->contact->address_longitude,
        'address_latitude' => !empty($request->address_latitude) ? $request->address_latitude : $user->contact->address_latitude
    // 'address_longitude' => $request->address_longitude,
    // 'address_latitude' => $request->address_latitude

    ]);

    $this->log($type, $severity, $actionUrl, $message);

    return redirect()->back()->with('success', 'Your profile has been updated successfully');

}
    }


    public function update_password(Request $request){

        return $this->passwordUpdator($request);

    }
}
