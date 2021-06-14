<?php

namespace App\Http\Controllers\CSE;

use App\Traits\Loggable;
use Illuminate\Http\Request;
use App\Traits\PasswordUpdator;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;

class ProfileController extends Controller
{
    use Loggable, PasswordUpdator;

    /**
     * Display a listing of the resource.
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return $request->user() ? view('cse.profile.index', [
            'user' => $request->user()->loadMissing('cse', 'cse.referral', 'franchisee', 'account', 'account.bank',  'contact', 'ratings'),
        ]) : redirect()->route('login');
    }

    /**
     * Show the form for editing the specified resource.
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function edit(Request $request)
    {
        return $request->user() ?  view('cse.profile.edit', [
            'user' =>  $request->user()->loadMissing('cse', 'cse.referral', 'franchisee', 'account', 'account.bank',  'contact', 'ratings'),
            'banks' => \App\Models\Bank::all()
        ]) : redirect()->route('login');
    }

    /**
     * Update the specified resource in storage.
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $cse)
    {
        (array)$valid = $this->validateUpdateRequest($request);
        (bool)$updated = false;

        \Illuminate\Support\Facades\DB::transaction(function () use ($request, $valid, &$updated) {
            // Update CSE Accounts Records table
            $request->user()->account()->update([
                'first_name'        => $valid['first_name'],
                'middle_name'       => $valid['middle_name'],
                'last_name'         => $valid['last_name'],
                'gender'            => $valid['gender'],
                'bank_id'           => $valid['bank_id'],
                'account_number'    => $valid['account_number'],
                'avatar'            => !empty($valid['profile_avatar']) ?  $valid['profile_avatar']->store('assets/user-avatars', 'public') : $request->user()->account->avatar
            ]);

            $request->user()->contact()->update([
                'phone_number'          =>  $valid['phone_number'],
                'address'               =>  $valid['full_address'],
                'address_longitude'     =>  !empty($valid['address_longitude']) ? $valid['address_longitude'] : $request->user()->contact->address_longitude,
                'address_latitude'      =>  !empty($valid['address_latitude']) ? $valid['address_latitude'] : $request->user()->contact->address_latitude,
            ]);

            $this->log('profile', 'Informational', Route::currentRouteAction(), $request->user()->account->last_name . ' ' . $request->user()->account->first_name  . ' updated their profile information.');
            // update updated to be true
            $updated = true;
        });
        return ($updated == true)
            ? redirect()->route('cse.profile.index', app()->getLocale())->with('success', 'Profile Infomation Updated Successfully')
            : back()->with('error', 'Error updating profile information');
    }

    /**
     * Change the password of the current authenticated User
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function change_password(Request $request)
    {
        return $this->passwordUpdator($request);
    }

    /**
     * Validate the create customer service executive user request.
     * @param  \Illuminate\Http\Request  $request
     *
     * @return array
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function validateUpdateRequest(Request $request)
    {
        return $request->validate([
            'first_name'         =>     'required|string|max:180',
            'middle_name'        =>     'sometimes|max:180',
            'last_name'          =>     'required|string|max:180',
            'gender'             =>     'required|in:male,female,others',
            'phone_number'       =>     ['required', 'numeric', \Illuminate\Validation\Rule::unique('contacts', 'phone_number')->ignore($request->user()->id, 'user_id')],
            'profile_avatar'     =>     'sometimes|image',
            'bank_id'            =>     'required|numeric',
            'account_number'     =>     'required|numeric',
            'full_address'       =>     'required|string',
            'address_latitude'          =>   'sometimes|string',
            'address_longitude'         =>   'sometimes|string',
        ]);
    }
}
