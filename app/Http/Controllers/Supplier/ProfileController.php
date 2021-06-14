<?php

namespace App\Http\Controllers\Supplier;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Auth;
use Route;
use DB;
use App\Traits\Loggable;
use App\Traits\PasswordUpdator;
use App\Traits\ImageUpload;

class ProfileController extends Controller
{
    use Loggable, PasswordUpdator, ImageUpload;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function dashboard()
    {
        // return  \App\Models\User::with('account', 'supplier', 'contact', 'ratings', 'supplierSentInvoices')->findOrFail(Auth::id());
        $causalAgent  =  \App\Models\ServiceRequestWarrantyReport::where('causal_agent_id', Auth::id())->with('rfqInvoices')->get();
     
        return view('supplier.index', [
            'profile'   =>  \App\Models\User::with('account', 'contact', 'ratings')->findOrFail(Auth::id()),
            'rfqs'  =>  \App\Models\Rfq::where('status', 'Pending')->orderBy('created_at', 'DESC')->get(),
            'causalAgentAmt'  => !empty($causalAgent)? $causalAgent: '0',
      ]);

     

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       
        return view('supplier.view_profile', [
            'profile'   =>  \App\Models\User::with('supplier', 'account', 'contact', 'ratings')->findOrFail(Auth::id())
        ]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        return view('supplier.edit_profile', [
            'profile'   =>  \App\Models\User::with('account', 'contact')->findOrFail(Auth::id()),
            'banks'     =>  \App\Models\Bank::get(['id', 'name'])
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($language, Request $request, $uuid)
    {
        //Get authenticated user object
        $user = Auth::user();

        //Validate user input fields
        $this->validateUpdateProfileRequest($user->id);

        //Determine gender of authenticated user
        if($request->gender == 'male' || $request->gender == 'others'){
            (string) $genderPreposition = 'his';
        }else{
            (string) $genderPreposition = 'her';
        }

        //Set `updateAccount` to false before Db transaction and pass by reference
        (bool) $updateAccount  = false;
        
        // Set DB to rollback DB transacations if error occurs
        DB::transaction(function () use ($request, $user, &$updateAccount, &$updateContact) {

            //Image storage directory
            $imageDirectory = public_path('assets/user-avatars').'/';

            //Old avatar
            $oldAvatarName = $user->account->avatar;

            //Validate if an image file was selected
            if($request->hasFile('image')){

                //Validate and update image with ImageUpload Trait
                $avatarName = $this->verifyAndStoreImage($request, $imageDirectory, $width = 500, $height = 500);

                //Delete old service image if new image name is given
                if(!empty($avatarName) && ($avatarName != $oldAvatarName)){

                    if(\File::exists($imageDirectory.$oldAvatarName)){

                        \File::delete($imageDirectory.$oldAvatarName);
                    }
                }

            }else{
                $avatarName = $oldAvatarName;
            }
            
            //Update authenticated user Account record
            $user->account->update([
                'first_name'        =>  $request->first_name,
                'middle_name'       =>  $request->middle_name,
                'last_name'         =>  $request->last_name,
                'gender'            =>  $request->gender,
                'avatar'            =>  $avatarName,
                'bank_id'           =>  $request->bank_id,
                'account_number'    =>  $request->account_number
            ]);
        
            //Update authenticated user Contact record
            $user->contact->update([
                'phone_number'      =>  $request->phone_number,
                'address'           =>  $request->address,
                'address_longitude' =>  $request->address_longitude,
                'address_latitude'  =>  $request->address_longitude
            ]);

            //Set variables as true to be validated outside the DB transaction
            $updateAccount  = true;
        });

        if($updateAccount){

            //Record crurrenlty logged in user activity
            $type = 'Profile';
            $severity = 'Informational';
            $actionUrl = Route::currentRouteAction();
            $message = Auth::user()->email.' updated '.$genderPreposition.' profile.';
            $this->log($type, $severity, $actionUrl, $message);
 
            return back()->with('success', 'Your profile was successfully updated.');
 
        }else{
 
            //Record Unauthorized user activity
            $type = 'Errors';
            $severity = 'Error';
            $actionUrl = Route::currentRouteAction();
            $message = 'An error occurred while '.Auth::user()->email.' was trying to update '.$genderPreposition.' profile.';
            $this->log($type, $severity, $actionUrl, $message);
 
            return back()->with('error', 'An error occurred while trying to update your profile.');
        }
 
        return back()->withInput();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Validate user input fields
     */
    private function validateUpdateProfileRequest($id){
        return request()->validate([
            'first_name'        =>   'required',
            'middle_name'       =>   'sometimes',
            'last_name'         =>   'required',
            'gender'            =>   'required|in:male,female,others',
            'phone_number'      =>   'required|numeric|unique:contacts,phone_number,'.$id.',user_id|bail',
            'image'             =>   'sometimes|mimes:jpg,png,jpeg,gif,svg|max:512',
            'bank_id'           =>   'sometimes',
            'account_number'    =>   'sometimes|numeric|unique:accounts,account_number,'.$id.',user_id|bail',
            'address'           =>   'required', 
            'address_longitude' =>   'required',
            'address_latitude'  =>   'required',
        ]);
    }

    public function updatePassword(Request $request){

        //Change authenticated user password with passwordUpdator trait
        return $this->passwordUpdator($request);
    }
}
