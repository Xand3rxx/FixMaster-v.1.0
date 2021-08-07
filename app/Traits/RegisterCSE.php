<?php

namespace App\Traits;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Traits\GenerateUniqueIdentity as Generator;
use App\Http\Controllers\Messaging\MessageController;


trait RegisterCSE
{
    use RegisterUser, Generator;

    protected $registred;

    /**
     * Handle registration of a CSE request for the application.
     *
     * @param  array $valid
     * @return bool 
     */
    public function register(array $valid)
    {
        return $this->attemptRegisteringCSE($valid);
    }

    /**
     * Handle registration of a CSE
     *
     * @param  array $valid
     * 
     * @throws Illuminate\Database\Eloquent\ModelNotFoundException
     * @return bool
     */
    protected function attemptRegisteringCSE(array $valid)
    {
        (bool) $registred = false;

        DB::transaction(function () use ($valid, &$registred) {
            // Register the User
            $user = $this->createUser($valid);
            // find client role using slug of client-user
            $role = \App\Models\Role::where('slug', 'cse-user')->firstOrFail();
            $user->roles()->attach($role);
            // Register CSE Permissions
            $cse_permission = \App\Models\Permission::where('slug', 'view-cse')->firstOrFail();
            $user->permissions()->attach($cse_permission);
            // CSE User Type
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
                'last_name'         => $valid['last_name'],
                'gender'            => $valid['gender'],
                'bank_id'           => $valid['bank_id'],
                'account_number'    => $valid['account_number'],
                'avatar'            => !empty($valid['avatar']) ? $valid['avatar']->store('user-avatar') : $valid['gender'] = 'male' ? 'default-male-avatar.png' : 'default-female-avatar.png',
            ]);

            // Register the CSE Account
            $user->cse()->create([
                'account_id' => $account->id,
                // 'referral_id' => 0,
                'franchisee_id' => $valid['franchisee_id'],
            ]);
            // Register CSE Contact Details
            \App\Models\Contact::attemptToStore($user->id, $account->id, 156, $valid['phone_number'], $valid['full_address'], $valid['address_longitude'] ?? "3.4393863", $valid['address_latitude'] ?? "6.425007");

            // Notify CSE User of Account Creation
            $this->sendAccountCreationNotification($valid);
            // update registered to be true
            $registred = true;
        });
        return $registred;
    }

    protected function sendAccountCreationNotification($valid)
    {
        $template_feature = 'TECHNICIAN_ACCOUNT_CREATION_NOTIFICATION';
        if (!empty((string)$template_feature)) {
            $messanger = new MessageController();
            $mail_data = collect([
                'lastname' => $valid['last_name'],
                'firstname' => $valid['first_name'],
                'email' => $valid['email'],
                'password' => $valid['password'],
                'url'   =>  route('technician.edit_profile', ['locale' => app()->getLocale()])
            ]);
            $messanger->sendNewMessage('', 'info@fixmaster.com.ng', $mail_data['email'], $mail_data, $template_feature);
        }
    }
}
