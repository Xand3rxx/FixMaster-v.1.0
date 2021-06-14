<?php

namespace App\Traits;

use Illuminate\Support\Facades\DB;


trait RegisterFranchisee
{
    use RegisterUser;

    protected $registred;
    protected $valid;

    /**
     * Handle registration of a Franchisee request for the application.
     *
     * @param  array $valid
     * @return bool 
     */
    public function register(array $valid)
    {
        return $this->attemptRegisteringFranchisee($valid);
    }

    /**
     * Handle registration of a Franchisee
     *
     * @param  array $valid
     * 
     * @throws Illuminate\Database\Eloquent\ModelNotFoundException
     * @return bool
     */
    protected function attemptRegisteringFranchisee(array $valid)
    {
        (bool) $registred = false;

        DB::transaction(function () use ($valid, &$registred) {
            // Register the User
            $user = $this->createUser($valid);
            // find Franchisee role using slug of franchisee-user
            $role = \App\Models\Role::where('slug', 'franchisee-user')->firstOrFail();
            $user->roles()->attach($role);
            // Register Franchisee Permissions
            $franchisee_permission = \App\Models\Permission::where('slug', 'view-franchisees')->firstOrFail();
            $user->permissions()->attach($franchisee_permission);
            // Franchisee User Type
            \App\Models\UserType::store($user->id, $role->id, $role->url);
            // Register Town details
            $town =  \App\Models\Town::saveTown($valid['town']);
            // Register the User Account
            $account = $user->account()->create([
                'state_id'          => $valid['state_id'],
                'lga_id'            => $valid['lga_id'],
                'town_id'           => $town->id,
                'first_name'        => $valid['first_name'],
                'middle_name'       => $valid['middle_name'] ?: "",
                'last_name'         => $valid['last_name'] ?: "",
                'gender'            => 'others',
                'bank_id'           => (int)$valid['bank_id'],
                'account_number'    => $valid['account_number'],
                'avatar'            => !empty($valid['avatar']) ? $valid['avatar']->store('user-avatar') : $valid['gender'] = 'male' ? 'default-male-avatar.png' : 'default-female-avatar.png',
            ]);

            // Register the Franchisee Account
            $user->franchisee()->create([
                'account_id' => $account->id,
                'cac_number' => $valid['cac_number'],
                'name' => $valid['franchisee_name'],
                'franchise_description' => $valid['franchisee_description'],
                'established_on' => $valid['established_on'],
            ]);
            // Register Franchisee Contact Details
            \App\Models\Contact::attemptToStore($user->id, $account->id, 156, $valid['phone_number'], $valid['full_address'], $valid['address_longitude'], $valid['address_latitude']);
            // update registered to be true
            $registred = true;
        });
        return $registred;
    }
}
