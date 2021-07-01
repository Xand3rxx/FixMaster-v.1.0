<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class AdministratorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Administrator User
        $admin = new \App\Models\User;
        $admin->email = 'admin@fix-master.com';
        $admin->password = bcrypt('admin12345');
        $admin->email_verified_at = now();
        $admin->save();

        $admin1 = new \App\Models\User;
        $admin1->email = 'david.akinsola@gmail.com';
        $admin1->password = bcrypt('admin12345');
        $admin1->email_verified_at = now();
        $admin1->save();

        $admin2 = new \App\Models\User;
        $admin2->email = 'obuchi.omotosho@gmail.com';
        $admin2->password = bcrypt('admin12345');
        $admin2->email_verified_at = now();
        $admin2->save();


        // Administrator Roles and Permissions
        $adminRole = \App\Models\Role::where('slug', 'admin-user')->first();
        $admin->roles()->attach($adminRole);
        $admin1->roles()->attach($adminRole);
        $admin2->roles()->attach($adminRole);

        $adminPermission = \App\Models\Permission::where('slug', 'view-administrators')->first();
        $admin->permissions()->attach($adminPermission);
        $admin1->permissions()->attach($adminPermission);
        $admin2->permissions()->attach($adminPermission);

        // Administrator User Type
        $adminType = new \App\Models\UserType();
        $adminType->user_id    = $admin->id;
        $adminType->role_id    = $adminRole->id;
        $adminType->url        = $adminRole->url;
        $adminType->save();

        $adminType = new \App\Models\UserType();
        $adminType->user_id    = $admin1->id;
        $adminType->role_id    = $adminRole->id;
        $adminType->url        = $adminRole->url;
        $adminType->save();

        $adminType = new \App\Models\UserType();
        $adminType->user_id    = $admin2->id;
        $adminType->role_id    = $adminRole->id;
        $adminType->url        = $adminRole->url;
        $adminType->save();

        // Administrator Account
        $adminAccount = \App\Models\Account::create([
            'user_id'       =>  $admin->id,
            'state_id'      =>  24,
            'lga_id'        =>  505,
            'first_name'    => "Charles",
            'middle_name'   => "",
            'last_name'     => "Famoriyo",
            'gender'        => 'male',
            'avatar'        => 'home-fix-logo-coloredd.png',
        ]);

        $adminAccount1 = \App\Models\Account::create([
            'user_id'       =>  $admin1->id,
            'state_id'      =>  24,
            'lga_id'        =>  514,
            'first_name'    => "David ",
            'middle_name'   => "",
            'last_name'     => "Akinsola",
            'gender'        => 'male',
            'avatar'        => 'home-fix-logo-coloredd.png',
        ]);

        $adminAccount2 = \App\Models\Account::create([
            'user_id'       =>  $admin2->id,
            'state_id'      =>  24,
            'lga_id'        =>  500,
            'first_name'    => "Obuchi",
            'middle_name'   => "",
            'last_name'     => "Omotosho",
            'gender'        => 'female',
            'avatar'        => 'home-fix-logo-coloredd.png',
        ]);

        // Tehnician details Table
        $adminTable = new \App\Models\Administrator();
        $adminTable->user_id = $admin->id;
        $adminTable->account_id = $adminAccount->id;
        $adminTable->save();

        $adminTable = new \App\Models\Administrator();
        $adminTable->user_id = $admin1->id;
        $adminTable->account_id = $adminAccount1->id;
        $adminTable->save();

        $adminTable = new \App\Models\Administrator();
        $adminTable->user_id = $admin2->id;
        $adminTable->account_id = $adminAccount2->id;
        $adminTable->save();

        // Sample Implementation for storing Contact Details of a user
        \App\Models\Contact::attemptToStore($admin->id, $adminAccount->id, 156, '08063508280', "Camp 1 block1 flat 6, Nigeria Army cantonment ojo, 300001, Lagos", "3.223188", "6.4683588");
        \App\Models\Contact::attemptToStore($admin1->id, $adminAccount1->id, 156, '08124300984', "Omole Phase 2, Isheri, Lagos", "3.3730327", "6.6304984");
        \App\Models\Contact::attemptToStore($admin2->id, $adminAccount2->id, 156, '07064894565', "1-11 Ernest Orachiri Cl, Araromi, Lagos", "3.3858776", "6.5499573");
    }
}
