<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Client User
        $client = new \App\Models\User;
        $client->email = 'client@fix-master.com';
        $client->password = bcrypt('admin12345');
        $client->save();

        $client1 = new \App\Models\User;
        $client1->email = 'wisdom.amana@gmail.com';
        $client1->password = bcrypt('admin12345');
        $client1->save();

        $client2 = new \App\Models\User;
        $client2->email = 'debo.williams@gmail.com';
        $client2->password = bcrypt('admin12345');
        $client2->save();

        $client3 = new \App\Models\User;
        $client3->email = 'jennifer.isaac@outlook.co.uk';
        $client3->password = bcrypt('admin12345');
        $client3->save();

        $client4 = new \App\Models\User;
        $client4->email = 'favour.chidera@yahoo.com';
        $client4->password = bcrypt('admin12345');
        $client4->save();

        // Client Roles and Permissions
        $clientRole = \App\Models\Role::where('slug', 'client-user')->first();
        $client->roles()->attach($clientRole);
        $client1->roles()->attach($clientRole);
        $client2->roles()->attach($clientRole);
        $client3->roles()->attach($clientRole);
        $client4->roles()->attach($clientRole);

        $client_permission = \App\Models\Permission::where('slug', 'view-clients')->first();
        $client->permissions()->attach($client_permission);
        $client1->permissions()->attach($client_permission);
        $client2->permissions()->attach($client_permission);
        $client3->permissions()->attach($client_permission);
        $client4->permissions()->attach($client_permission);

        // Client User Type
        $clientType = new \App\Models\UserType();
        $clientType->user_id = $client->id;
        $clientType->role_id = $clientRole->id;
        $clientType->url = $clientRole->url;
        $clientType->save();

        $clientType = new \App\Models\UserType();
        $clientType->user_id = $client1->id;
        $clientType->role_id = $clientRole->id;
        $clientType->url = $clientRole->url;
        $clientType->save();

        $clientType = new \App\Models\UserType();
        $clientType->user_id = $client2->id;
        $clientType->role_id = $clientRole->id;
        $clientType->url = $clientRole->url;
        $clientType->save();

        $clientType = new \App\Models\UserType();
        $clientType->user_id = $client3->id;
        $clientType->role_id = $clientRole->id;
        $clientType->url = $clientRole->url;
        $clientType->save();

        $clientType = new \App\Models\UserType();
        $clientType->user_id = $client4->id;
        $clientType->role_id = $clientRole->id;
        $clientType->url = $clientRole->url;
        $clientType->save();

        // Client Account
        $clientAccount = \App\Models\Account::create([
            'user_id'       =>  $client->id,
            'state_id'         =>  24,
            'lga_id'           =>  505,
            'town_id'           =>  80,
            'first_name'    => "Kelvin",
            'middle_name'   => "Israel",
            'last_name'     => "Adesanya",
            'gender'        => 'male',
            'avatar'        => '0c9ac4cada39ba68e97fc6c0a0807458d1385048.jpg'
        ]);

        $clientAccount1 = \App\Models\Account::create([
            'user_id'       =>  $client1->id,
            'state_id'         =>  24,
            'lga_id'           =>  508,
            'town_id'           =>  117,
            'first_name'    => "Wisdom",
            'middle_name'   => "Basil",
            'last_name'     => "Amana",
            'gender'        => 'male',
            'avatar'        => 'default-male-avatar.png'
        ]);

        $clientAccount2 = \App\Models\Account::create([
            'user_id'       =>  $client2->id,
            'state_id'         =>  24,
            'lga_id'           =>  514,
            'town_id'           =>  201,
            'first_name'    => "Adebola",
            'middle_name'   => "Julius",
            'last_name'     => "Williams",
            'gender'        => 'male',
            'avatar'        => 'default-male-avatar.png'
        ]);

        $clientAccount3 = \App\Models\Account::create([
            'user_id'       =>  $client3->id,
            'state_id'         =>  24,
            'lga_id'           =>  505,
            'town_id'           =>  80,
            'first_name'    => "Jennifer",
            'middle_name'   => "Ifeyinwa",
            'last_name'     => "Isaac",
            'gender'        => 'male',
            'avatar'        => 'default-female-avatar.png'
        ]);

        $clientAccount4 = \App\Models\Account::create([
            'user_id'       =>  $client4->id,
            'state_id'         =>  24,
            'lga_id'           =>  503,
            'town_id'           =>  55,
            'first_name'    => "Favour",
            'middle_name'   => "Chidera",
            'last_name'     => "Onuoha",
            'gender'        => 'male',
            'avatar'        => 'default-female-avatar.png'
        ]);

        // Client Table
        $clientTable = new \App\Models\Client();
        $clientTable->user_id = $client->id;
        $clientTable->unique_id = 'WAL-760BCC86';
        $clientTable->account_id = $clientAccount->id;
        $clientTable->estate_id = '1';
        // $clientTable->profession_id = '18';
        $clientTable->save();

        $clientTable = new \App\Models\Client();
        $clientTable->user_id = $client1->id;
        $clientTable->unique_id = 'WAL-A3C9FAC4';
        $clientTable->account_id = $clientAccount1->id;
        $clientTable->estate_id = '1';
        // $clientTable->profession_id = '12';
        $clientTable->save();

        $clientTable = new \App\Models\Client();
        $clientTable->user_id = $client2->id;
        $clientTable->unique_id = 'WAL-1D61A777';
        $clientTable->account_id = $clientAccount2->id;
        $clientTable->estate_id = '2';
        // $clientTable->profession_id = '3';
        $clientTable->save();

        $clientTable = new \App\Models\Client();
        $clientTable->user_id = $client3->id;
        $clientTable->unique_id = 'WAL-DCE47AD1';
        $clientTable->account_id = $clientAccount3->id;
        $clientTable->estate_id = '3';
        // $clientTable->profession_id = '14';
        $clientTable->save();

        $clientTable = new \App\Models\Client();
        $clientTable->user_id = $client4->id;
        $clientTable->unique_id = 'WAL-19362ADF';
        $clientTable->account_id = $clientAccount4->id;
        $clientTable->estate_id = '3';
        // $clientTable->profession_id = '22';
        $clientTable->save();

        // Sample Implementation for storing Contact Details of a user
        \App\Models\Contact::attemptToStore($client->id, $clientAccount->id, 156, '07069836642', "14 Idowu Martins St, Victoria Island, Lagos", "3.420010", "6.432820");
        \App\Models\Contact::attemptToStore($client1->id, $clientAccount1->id, 156, '08069386642', "1-9 Reeve Rd, Ikoyi, Lagos", "3.441440", "6.453120");
        \App\Models\Contact::attemptToStore($client2->id, $clientAccount2->id, 156, '08069386641', "Bisola Durosinmi Etti Drive, The Rock Dr, Lekki Phase 1, Lagos", "3.464150", "6.437240");
        \App\Models\Contact::attemptToStore($client3->id, $clientAccount3->id, 156, '07036722889', "8 Oba Akinjobi Way, Ikeja GRA, Ikeja", "3.346660", "6.586420");
        \App\Models\Contact::attemptToStore($client4->id, $clientAccount4->id, 156, '09082354911', "8 Oremeji St, Oke Odo, Lagos", "3.299630", "6.618710");

        $clientDiscount = \App\Models\ClientDiscount::create([
            'discount_id'      =>  1, 
            'client_id'        =>  $client->id, 
            'estate_id'        =>  NULL,
            'service_id'       =>  NULL, 
            'availability'     =>  'unused', 
        ]);

        $clientDiscount = \App\Models\ClientDiscount::create([
            'discount_id'      =>  1, 
            'client_id'        =>  $client1->id, 
            'estate_id'        =>  NULL,
            'service_id'       =>  NULL, 
            'availability'     =>  'unused', 
        ]);

        $clientDiscount = \App\Models\ClientDiscount::create([
            'discount_id'      =>  1, 
            'client_id'        =>  $client2->id, 
            'estate_id'        =>  NULL,
            'service_id'       =>  NULL, 
            'availability'     =>  'unused', 
        ]);

        $clientDiscount = \App\Models\ClientDiscount::create([
            'discount_id'      =>  1, 
            'client_id'        =>  $client3->id, 
            'estate_id'        =>  NULL,
            'service_id'       =>  NULL, 
            'availability'     =>  'unused', 
        ]);

        $clientDiscount = \App\Models\ClientDiscount::create([
            'discount_id'       =>  1, 
            'client_id'         =>  $client4->id, 
            'estate_id'         =>  NULL,
            'service_id'        =>  NULL, 
            'availability'      =>  'unused', 
        ]);

        //3 more contacts for client@fix-master.com
        // DB::table('contacts')->delete();

        $contacts = array(

            array(
                // 'id'                =>  1,
                'user_id'           =>  $client->id,
                'account_id'        =>  $clientAccount->id,
                'country_id'        =>  156,
                'state_id'          =>  24,
                'lga_id'            =>  498,
                'town_id'           =>  3,
                'name'              =>  'Yinka Odumosu',
                'phone_number'      =>  '08086717489',
                'address'           => 'C99 Rd 27, Victoria Garden City, Lekki',
                'address_longitude' =>  '3.5375363',
                'address_latitude'  =>  '6.4658893',
            ),
            array(
                // 'id'                =>  2,
                'user_id'           =>  $client->id,
                'account_id'        =>  $clientAccount->id,
                'country_id'        =>  156,
                'state_id'          =>  24,
                'lga_id'            =>  517,
                'town_id'           =>  237,
                'name'              =>  'Adewale Daniel',
                'phone_number'      =>  '08085517815',
                'address'           => 'Holly Ave, Eti-Osa, Lekki',
                'address_longitude' =>  '3.6066907',
                'address_latitude'  =>  '6.4941095',
            ),
            array(
                // 'id'                =>  3,
                'user_id'           =>  $client->id,
                'account_id'        =>  $clientAccount->id,
                'country_id'        =>  156,
                'state_id'          =>  24,
                'lga_id'            =>  508,
                'town_id'           =>  116,
                'name'              =>  'Folarin Funsho',
                'phone_number'      =>  '08035957862',
                'address'           => '7 Unity Road, Omole Phase 1, Ikeja, Lagos',
                'address_longitude' =>  '3.3582073',
                'address_latitude'  =>  '6.4941095',
            )
           
        );

        DB::table('contacts')->insert($contacts);
    }
}