<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TaxSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('taxes')->delete();

        $tax = array(

            array(
                'uuid'          =>  Str::uuid('uuid'),      
                'user_id'       =>  1,
                'name'          =>  'VAT',
                'percentage'    =>  7.5,
                'description'   =>  'A value-added tax (VAT) is a consumption tax placed on a product whenever value is added at each stage of the supply chain, from production to the point of sale.',
            ),
        );

        DB::table('taxes')->insert($tax);
    }
}
