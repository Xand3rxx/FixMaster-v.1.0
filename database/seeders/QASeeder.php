<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class QASeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // QA User
        $qa = new \App\Models\User;
        $qa->email = 'qa@9thtest.com.ng ';
        $qa->password = bcrypt('admin12345');
        $qa->save();

        $qa1 = new \App\Models\User;
        $qa1->email = 'desmond.john@yahoo.com';
        $qa1->password = bcrypt('admin12345');
        $qa1->save();

        $qa2 = new \App\Models\User;
        $qa2->email = 'bidemi.johson@outlook.co.uk';
        $qa2->password = bcrypt('admin12345');
        $qa2->save();

        // AQ Roles and Permissions
        $qaRole = \App\Models\Role::where('slug', 'quality-assurance-user')->first();
        $qa->roles()->attach($qaRole);
        $qa1->roles()->attach($qaRole);
        $qa2->roles()->attach($qaRole);

        $qa_permission = \App\Models\Permission::where('slug', 'view-qa')->first();
        $qa->permissions()->attach($qa_permission);
        $qa1->permissions()->attach($qa_permission);
        $qa2->permissions()->attach($qa_permission);

        // QA User Type
        $qaType = new \App\Models\UserType();
        $qaType->user_id = $qa->id;
        $qaType->role_id = $qaRole->id;
        $qaType->url = $qaRole->url;
        $qaType->save();

        $qaType = new \App\Models\UserType();
        $qaType->user_id = $qa1->id;
        $qaType->role_id = $qaRole->id;
        $qaType->url = $qaRole->url;
        $qaType->save();

        $qaType = new \App\Models\UserType();
        $qaType->user_id = $qa2->id;
        $qaType->role_id = $qaRole->id;
        $qaType->url = $qaRole->url;
        $qaType->save();

        // QA Account
        $qaAccount = \App\Models\Account::create([
            'user_id'           =>  $qa->id,
            'first_name'        =>  "Yvonne",
            'middle_name'       =>  "Obuchi",
            'last_name'         =>  "Okoye",
            'gender'            =>  'female',
            'bank_id'           =>  3,
            'account_number'    =>  '3082632813',
            'avatar'            =>  'default-female-avatar.png',
        ]);

        $qaAccount1 = \App\Models\Account::create([
            'user_id'           =>  $qa1->id,
            'first_name'        => "Desmond",
            'middle_name'       => "",
            'last_name'         => "John",
            'gender'            => 'male',
            'bank_id'           =>  5,
            'account_number'    =>  '1236322078',
            'avatar'            => 'default-male-avatar.png',
        ]);

        $qaAccount2 = \App\Models\Account::create([
            'user_id'           =>  $qa2->id,
            'first_name'        => "Bidemi",
            'middle_name'       => "Damian",
            'last_name'         => "Johnson",
            'gender'            => 'male',
            'bank_id'           =>  23,
            'account_number'    =>  '7112572853',
            'avatar'            => 'default-male-avatar.png',
        ]);

        // QA Table
        $qaTable = new \App\Models\QA();
        $qaTable->user_id = $qa->id;
        $qaTable->account_id = $qaAccount->id;
        // $qaTable->unique_id = 'QA-19807654';
        $qaTable->save();

        $qaTable = new \App\Models\QA();
        $qaTable->user_id = $qa1->id;
        $qaTable->account_id = $qaAccount1->id;
        // $qaTable->unique_id = 'QA-19807654';
        $qaTable->save();

        $qaTable = new \App\Models\QA();
        $qaTable->user_id = $qa2->id;
        $qaTable->account_id = $qaAccount2->id;
        // $qaTable->unique_id = 'QA-19807654';
        $qaTable->save();

    
        // Sample Implementation for storing Contact Details of a user
        \App\Models\Contact::attemptToStore($qa->id, $qaAccount->id, 156, '08153782719', "1 Bankole Oki St, Ikoyi 101233, Lagos", "3.424338", "6.454340");
        \App\Models\Contact::attemptToStore($qa1->id, $qaAccount1->id, 156, '09086279121', "Adeniran/Ogunsanya, Surulere, Lagos", "3.35686779761115", "6.49797144337352");
        \App\Models\Contact::attemptToStore($qa2->id, $qaAccount2->id, 156, '09033319908', "10 Blueroof Avenue idowu-egba bus/stop along lasu-, Isheri Rd, Lagos", "3.2607962300662363", "6.577210941382072");

        
        // DB::table('users_services')->delete();

        $qaServices = array(
            array(
                'user_id'       =>  10,
                'service_id'    =>  1,
                'role_id'       =>  8,
            ),
            array(
                'user_id'       =>  10,
                'service_id'    =>  22,
                'role_id'       =>  8,
            ),
            array(
                'user_id'       =>  10,
                'service_id'    =>  24,
                'role_id'       =>  8,
            ),
            array(
                'user_id'       =>  11,
                'service_id'    =>  1,
                'role_id'       =>  8,
            ),
            array(
                'user_id'       =>  11,
                'service_id'    =>  6,
                'role_id'       =>  8,
            ),
            array(
                'user_id'       =>  11,
                'service_id'    =>  11,
                'role_id'       =>  8,
            ),
            array(
                'user_id'       =>  12,
                'service_id'    =>  1,
                'role_id'       =>  8,
            ),
            array(
                'user_id'       =>  12,
                'service_id'    =>  10,
                'role_id'       =>  8,
            ),
            array(
                'user_id'       =>  12,
                'service_id'    =>  2,
                'role_id'       =>  8,
            ),
        );

        DB::table('users_services')->insert($qaServices);

    }
}