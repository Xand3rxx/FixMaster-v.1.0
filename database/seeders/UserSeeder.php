<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $developer = \App\Models\Role::where('slug','super-admin')->first();
        $manageUsers = \App\Models\Permission::where('slug','create-admin')->first();

        $user1 = new User();
        $user1->email = 'dev@fix-master.com';
        $user1->password = bcrypt('admin12345');
        $user1->email_verified_at = now();
        $user1->save();
        $user1->roles()->attach($developer);
        $user1->permissions()->attach($manageUsers);

        $userType = new \App\Models\UserType();
        $userType->user_id = $user1->id;
        $userType->role_id = $developer->id;
        $userType->url = $developer->url;
        $userType->save();

        // Super Admin Account
        $superAdminAccount = \App\Models\Account::create([
            'user_id'       =>  1,
            'first_name'    => "FixMaster",
            'middle_name'   => "",
            'last_name'     => "Administrator",
            'gender'        => 'male',
            'avatar'        => 'default-male-avatar.png'
        ]);

    }
}
