<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;
use Illuminate\Support\Str;

class PriceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('prices')->delete();

        $prices = array(

            array(
                'uuid'          =>  Str::uuid('uuid'),      
                'user_id'       =>  1,
                'name'          =>  'Standard',
                'description'   =>  'Your job will be evaluated by a CSE and technician within a maximum period of 8 hours.',
                'amount'        =>  1500,
            ),
            array(
                'uuid'          =>  Str::uuid('uuid'),      
                'user_id'       =>  1,
                'name'          =>  'Urgent',
                'description'   =>  'Your job will be evaluated by a CSE and technician within a maximum period of 2 hours.',
                'amount'        =>  2000,
            ),
            array(
                'uuid'          =>  Str::uuid('uuid'),      
                'user_id'       =>  1,
                'name'          =>  'Out of Hours',
                'description'   =>  'Our normal working Hours is 7AM to 7PM. A CSE and technician will evaluate your job within a maximum period of 2 hours.',
                'amount'        =>  3000,
            ),
            
        );

        DB::table('prices')->insert($prices);
    }
}
