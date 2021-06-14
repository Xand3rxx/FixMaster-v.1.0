<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class TechnicianSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Technician User
        $technician = new \App\Models\User;
        $technician->email = 'technician@fix-master.com';
        $technician->password = bcrypt('admin12345');
        $technician->save();

        $technician1 = new \App\Models\User;
        $technician1->email = 'andrew.nwankwo@gmail.com';
        $technician1->password = bcrypt('admin12345');
        $technician1->save();

        $technician2 = new \App\Models\User;
        $technician2->email = 'taofeek.adedokun@gmail.com';
        $technician2->password = bcrypt('admin12345');
        $technician2->save();

        // Technician Roles and Permissions
        $techniciainRole = \App\Models\Role::where('slug', 'technician-artisans')->first();
        $technician->roles()->attach($techniciainRole);
        $technician1->roles()->attach($techniciainRole);
        $technician2->roles()->attach($techniciainRole);

        $technicianPermission = \App\Models\Permission::where('slug', 'view-technicians')->first();
        $technician->permissions()->attach($technicianPermission);
        $technician1->permissions()->attach($technicianPermission);
        $technician2->permissions()->attach($technicianPermission);

        // Technician User Type
        $technicianType = new \App\Models\UserType();
        $technicianType->user_id    = $technician->id;
        $technicianType->role_id    = $techniciainRole->id;
        $technicianType->url        = $techniciainRole->url;
        $technicianType->save();

        $technicianType = new \App\Models\UserType();
        $technicianType->user_id    = $technician1->id;
        $technicianType->role_id    = $techniciainRole->id;
        $technicianType->url        = $techniciainRole->url;
        $technicianType->save();

        $technicianType = new \App\Models\UserType();
        $technicianType->user_id    = $technician2->id;
        $technicianType->role_id    = $techniciainRole->id;
        $technicianType->url        = $techniciainRole->url;
        $technicianType->save();

        // QA Account
        $technicianAccount = \App\Models\Account::create([
            'user_id'       =>  $technician->id,
            'first_name'    => "Jamal",
            'middle_name'   => "Sule",
            'last_name'     => "Diwa",
            'gender'        => 'male',
            'bank_id'           =>  6,
            'account_number'    =>  '8197952999',
            'avatar'        => '42543275-530e-4f22-8a53-07bc7be8214d.jpeg',
        ]);

        $technicianAccount1 = \App\Models\Account::create([
            'user_id'       =>  $technician1->id,
            'first_name'    => "Andrew",
            'middle_name'   => "Nkem",
            'last_name'     => "Nwankwo",
            'gender'        => 'male',
            'bank_id'           =>  14,
            'account_number'    =>  '803541339',
            'avatar'        => 'default-male-avatar.png',
        ]);

        $technicianAccount2 = \App\Models\Account::create([
            'user_id'       =>  $technician2->id,
            'first_name'    => "Taofeek",
            'middle_name'   => "Idris",
            'last_name'     => "Adedokun",
            'gender'        => 'male',
            'bank_id'           =>  11,
            'account_number'    =>  '7052222678',
            'avatar'        => 'default-male-avatar.png',
        ]);

        // Tehnician details Table
        $technicianTable = new \App\Models\Technician();
        $technicianTable->user_id = $technician->id;
        $technicianTable->account_id = $technicianAccount->id;
        $technicianTable->save();

        $technicianTable = new \App\Models\Technician();
        $technicianTable->user_id = $technician1->id;
        $technicianTable->account_id = $technicianAccount1->id;
        $technicianTable->save();

        $technicianTable = new \App\Models\Technician();
        $technicianTable->user_id = $technician2->id;
        $technicianTable->account_id = $technicianAccount2->id;
        $technicianTable->save();

        // Sample Implementation for storing Contact Details of a user
        \App\Models\Contact::attemptToStore($technician->id, $technicianAccount->id, 156, '08175122879', "21 Olugborogan Olusesi Rd, Eti-Osa 100242, Lagos", "3.5372016", "6.4416878");
        \App\Models\Contact::attemptToStore($technician1->id, $technicianAccount1->id, 156, '07052222678', "2 Bello St, Volkswagen, Lagos", "3.2198137", "6.4563318");
        \App\Models\Contact::attemptToStore($technician2->id, $technicianAccount2->id, 156, '08035413397', "21-13 Ayo Adeife St, Idimu, Lagos", "3.286114654549155", "6.59493974136504");

        // DB::table('users_services')->delete();

        $technicianServices = array(
            array(
                'user_id'       =>  13,
                'service_id'    =>  1,
                'role_id'       =>  5,
            ),
            array(
                'user_id'       =>  13,
                'service_id'    =>  22,
                'role_id'       =>  5,
            ),
            array(
                'user_id'       =>  13,
                'service_id'    =>  24,
                'role_id'       =>  5,
            ),
            array(
                'user_id'       =>  14,
                'service_id'    =>  1,
                'role_id'       =>  5,
            ),
            array(
                'user_id'       =>  14,
                'service_id'    =>  6,
                'role_id'       =>  5,
            ),
            array(
                'user_id'       =>  14,
                'service_id'    =>  11,
                'role_id'       =>  5,
            ),
            array(
                'user_id'       =>  15,
                'service_id'    =>  1,
                'role_id'       =>  5,
            ),
            array(
                'user_id'       =>  15,
                'service_id'    =>  10,
                'role_id'       =>  5,
            ),
            array(
                'user_id'       =>  15,
                'service_id'    =>  2,
                'role_id'       =>  5,
            ),
            
        );

        DB::table('users_services')->insert($technicianServices);
    }
}

