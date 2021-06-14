<?php

namespace App\Traits;

use App\Models\Referral;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

trait RegisterClient
{
    use RegisterUser, SendVerificationMail;
    /**
     * Handle registration of a Client request for the application.
     *
     * @param  array $valid
     * @return bool 
     */
    public function register(array $valid)
    {
        (bool) $registred = false;

        DB::transaction(function () use ($valid, &$registred) {
            // store in users Table
            $user = $this->createUser($valid);

            // find client role using slug of client-user
            $role = \App\Models\Role::where('slug', 'client-user')->first();

            // Attach to User
            $user->roles()->attach($role);

            // store User Type
            \App\Models\UserType::store($user->id, $role->id, $role->url);

            // store in accounts table
            $account = $user->account()->create([
                'state_id'          =>  $valid['state_id'],
                'lga_id'            =>  $valid['lga_id'],
                'town_id'           =>  $valid['town_id'] ?? '0',
                'first_name'        => $valid['first_name'],
                'middle_name'       => $valid['middle_name'] ?: "",
                'last_name'         => $valid['last_name'],
                'gender'            => $valid['gender'],
            ]);

            // Store in clients table
            \App\Models\Client::create([
                'user_id' => $user->id,
                'account_id' => $account->id,
                'estate_id' => $valid['estate_id'] ?? "0",
                'profession_id' => $valid['profession_id'] ?? "0",
            ]);

            // Store in referrals table
            if (isset($valid['ref'])) {
                $code = $valid['ref'];
                if ($code) {
                    Referral::where('referral_code', $code)->increment('referral_count', 1);
                    Referral::create(['user_id' => $user->id, 'referral' => $code, 'referral_count' => 0]);
                }
            }

            // Store in Contact Address Details
            $user->contact()->create([
                'user_id'               => $user->id,
                'account_id'            => $account->id,
                'country_id'            =>  156,
                'state_id'              =>  $valid['state_id'],
                'lga_id'                =>  $valid['lga_id'],
                'town_id'               =>  $valid['town_id'],
                'name'                  =>  $account->first_name . ' ' . $account->last_name,
                'phone_number'          =>  $valid['phone_number'],
                'address'               =>  $valid['full_address'],
                'address_longitude'     =>  $valid['address_longitude'],
                'address_latitude'      =>  $valid['address_latitude'],
            ]);

            // register new client event
            //  event(new Registered($user));

            // Send Notification  Instance
            $this->sendVerificationEmail($account);

            // Log the User into the Application as Basic User
            $this->guard()->login($user);

            // update registered to be true
            $registred = true;
        });

        return $registred;
    }

    /**
     * Get the guard to be used during registration.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard();
    }
    
}
