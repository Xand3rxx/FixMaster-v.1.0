<?php

namespace Database\Seeders;

use App\Models\Discount;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DiscountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        $parameterArray = [
            'field' => '' , 
            'users' =>  '',
            'category' =>'' ,
            'services' => '',
            'estate' =>  ''
           ];

        $discount = new Discount();
        $discount->uuid = Str::uuid('uuid');
        $discount->name = 'Client Registration Discount';
        $discount->entity = 'client';
        $discount->notify = '1';
        $discount->rate = 5;
        $discount->apply_discount = 'Total bill';
        $discount->duration_start =  '2021-04-01 00:00:00';
        $discount->duration_end =  '2022-04-01 00:00:00';
        $discount->description =  'This is a discount which entitles all clients to 5% off their first job booking upon email verification.';
        $discount->parameter = json_encode($parameterArray);
        $discount->created_by= 'info@fixmaster.com.ng';
        $discount->status= 'activate';
        $discount->save();
    }
}
