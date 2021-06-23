<?php

namespace Database\Seeders;

use App\Models\Cse;
use App\Models\UserType;
use Illuminate\Database\Seeder;

class CSESeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        // CSE User
        $cse = new \App\Models\User;
        $cse->email = 'cse@9thtest.com.ng';
        $cse->password = bcrypt('admin12345');
        $cse->save();

        $cse1 = new \App\Models\User;
        $cse1->email = 'susan.simpson@gmail.com';
        $cse1->password = bcrypt('admin12345');
        $cse1->save();

        $cse2 = new \App\Models\User;
        $cse2->email = 'jackson.okoye@gmail.com';
        $cse2->password = bcrypt('admin12345');
        $cse2->save();

        // CSE Roles and Permissions
        $cseRole = \App\Models\Role::where('slug', 'cse-user')->first();
        $cse->roles()->attach($cseRole);
        $cse1->roles()->attach($cseRole);
        $cse2->roles()->attach($cseRole);

        $cse_permission = \App\Models\Permission::where('slug', 'view-cse')->first();
        $cse->permissions()->attach($cse_permission);
        $cse1->permissions()->attach($cse_permission);
        $cse2->permissions()->attach($cse_permission);

        // CSE User Type
        $cseType = new UserType();
        $cseType->user_id = $cse->id;
        $cseType->role_id = $cseRole->id;
        $cseType->url = $cseRole->url;
        $cseType->save();

        $cseType = new UserType();
        $cseType->user_id = $cse1->id;
        $cseType->role_id = $cseRole->id;
        $cseType->url = $cseRole->url;
        $cseType->save();

        $cseType = new UserType();
        $cseType->user_id = $cse2->id;
        $cseType->role_id = $cseRole->id;
        $cseType->url = $cseRole->url;
        $cseType->save();

        // CSE Account
        $cseAccount = \App\Models\Account::create([
            'user_id'           =>  $cse->id,
            'first_name'        => "Benedict",
            'middle_name'       => "Mayowa",
            'last_name'         => "Olaoye",
            'gender'            => 'male',
            'bank_id'           =>  9,
            'account_number'    =>  '0927628912',
            'avatar'            => '446bac7e-ab48-46af-91ff-c55961214fe2.jpeg'
        ]);

        $cseAccount1 = \App\Models\Account::create([
            'user_id'           =>  $cse1->id,
            'first_name'        => "Susan",
            'middle_name'       => "Ngozi",
            'last_name'         => "Simpson",
            'gender'            => 'female',
            'bank_id'           =>  3,
            'account_number'    =>  '1092732912',
            'avatar'            => '60137e90-2d10-447f-857f-9368e2d61cf2.jpg'
        ]);

        $cseAccount2 = \App\Models\Account::create([
            'user_id'           =>  $cse2->id,
            'first_name'        => "Jackson",
            'middle_name'       => "Chisom",
            'last_name'         => "Okoye",
            'gender'            => 'male',
            'bank_id'           =>  3,
            'account_number'    =>  '8921220232',
            'avatar'            => 'default-male-avatar.png'
        ]);

        // CSE Table
        $cseTable = new Cse();
        $cseTable->user_id = $cse->id;
        $cseTable->account_id = $cseAccount->id;
        $cseTable->referral_id = '1';
        $cseTable->save();

        $cseTable = new Cse();
        $cseTable->user_id = $cse1->id;
        $cseTable->account_id = $cseAccount1->id;
        $cseTable->referral_id = '2';
        $cseTable->save();

        $cseTable = new Cse();
        $cseTable->user_id = $cse2->id;
        $cseTable->account_id = $cseAccount2->id;
        $cseTable->referral_id = '3';
        $cseTable->save();

        // Sample Implementation for storing Contact Details of a user
        \App\Models\Contact::attemptToStore($cse->id, $cseAccount->id, 156, '09082354909', "22c Senrolu street, Off Ligali Ayorinde St, Victoria Island, Lagos", "3.4393863", "6.425007");
        \App\Models\Contact::attemptToStore($cse1->id, $cseAccount1->id, 156, '07063498499', "139 Adeniji Adele St, Lagos Island, Lagos", "3.3867822", "6.4651394");
        \App\Models\Contact::attemptToStore($cse2->id, $cseAccount2->id, 156, '08129444994', "14 421 Rd, Festac Town, Lagos", "3.2809022", "6.4785962");
    }   
}

