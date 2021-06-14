<?php

namespace App\Traits;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

trait RegisterTechnicianArtisan
{
    use RegisterUser;

    protected $registred;
    protected $valid;
    /**
     * Handle registration of an Administartor request for the application.
     *
     * @param  array $valid
     * @return bool 
     */
    public function register(array $valid)
    {
        (bool) $registred = false;

        DB::transaction(function () use ($valid, &$registred) {
            // Register the User
            $user = $this->createUser($valid);
            // find the Role of a Technicain
            $role = \App\Models\Role::where('slug', 'technician-artisans')->firstOrFail();
            $user->roles()->attach($role);
            // Register Supplier Permissions
            $technicianArtisan = \App\Models\Permission::where('slug', 'view-technicians')->firstOrFail();
            $user->permissions()->attach($technicianArtisan);

            // Attach the User Type for url path
            \App\Models\UserType::store($user->id, $role->id, $role->url);
            // Register Town details
            $town =  \App\Models\Town::saveTown($valid['town']);
            // Register the User Account
            $account = $user->account()->create([
                'state_id'          => $valid['state_id'],
                'lga_id '           => $valid['lga_id'],
                'town_id '          => $town->id,
                'first_name'        => $valid['first_name'],
                'middle_name'       => $valid['middle_name'] ?: "",
                'last_name'         => $valid['last_name'] ?: "",
                'gender'            => $valid['gender'],
                'bank_id'           => (int)$valid['bank_id'],
                'account_number' => $valid['account_number'],
                'avatar'            => !empty($valid['avatar']) ? $valid['avatar']->store('user-avatar') : $valid['gender'] = 'male' ? 'default-male-avatar.png' : 'default-female-avatar.png',
            ]);
            // Register the TechnicianArtisan Account
            $user->technician()->create([
                'account_id' => $account->id,
            ]);
            // Register TechnicianArtisan Contact Details
            \App\Models\Contact::attemptToStore($user->id, $account->id, 156, $valid['phone_number'], $valid['full_address'], $valid['address_longitude'], $valid['address_latitude']);
            // Store each Service in a loop
            foreach ($valid['technician_category'] as $serviceID) {
                \App\Models\UserService::storeUserService($user->id, $serviceID, $role->id);
            }
            // update registered to be true
            $registred = true;
        });
        return $registred;
    }
}
