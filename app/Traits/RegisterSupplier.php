<?php

namespace App\Traits;

use Illuminate\Support\Facades\DB;

trait RegisterSupplier
{
    use RegisterUser;

    protected $registred;
    protected $valid;

    /**
     * Handle registration of a Supplier request for the application.
     *
     * @param  array $valid
     * @return bool 
     */
    public function register(array $valid)
    {
        return $this->attemptRegisteringSupplier($valid);
    }

    /**
     * Handle registration of a Supplier
     *
     * @param  array $valid
     * 
     * @throws Illuminate\Database\Eloquent\ModelNotFoundException
     * @return bool
     */
    protected function attemptRegisteringSupplier(array $valid)
    {
        (bool) $registred = false;

        DB::transaction(function () use ($valid, &$registred) {
            // Register the User
            $user = $this->createUser($valid);
            // find Supplier role using slug of supplier-user
            $role = \App\Models\Role::where('slug', 'supplier-user')->firstOrFail();
            $user->roles()->attach($role);
            // Register Supplier Permissions
            $supplier_permission = \App\Models\Permission::where('slug', 'view-suppliers')->firstOrFail();
            $user->permissions()->attach($supplier_permission);
            // Supplier User Type
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

            // Register the Supplier Account
            $user->supplier()->create([
                'account_id' => $account->id,
                'cac_number' => $valid['cac_number'],
                'business_name' => $valid['supplier_name'],
                'business_description' => $valid['supplier_description'],
                'established_on' => $valid['established_on'],
                'education_level' => $valid['education_level'],
            ]);
            // Register Supplier Contact Details
            \App\Models\Contact::attemptToStore($user->id, $account->id, 156, $valid['phone_number'], $valid['full_address'], $valid['address_longitude'], $valid['address_latitude']);
            // Store each Service in a loop
            foreach ($valid['supplier_category'] as $serviceID) {
                \App\Models\UserService::storeUserService($user->id, $serviceID, $role->id);
            }
            // update registered to be true
            $registred = true;
        });
        return $registred;
    }
}
