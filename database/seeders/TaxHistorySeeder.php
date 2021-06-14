<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class TaxHistorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tax_histories')->delete();

        $tax = array(

            array(
                'user_id'       =>  1,
                'tax_id'        =>  1,
                'percentage'    =>  5,
                'created_at'    =>  '2021-01-01 6:28:38'
            ),
            array(
                'user_id'       =>  1,
                'tax_id'        =>  1,
                'percentage'    =>  7.5,
                'created_at'    =>  '2021-03-12 6:28:38'
            ),
        );

        DB::table('tax_histories')->insert($tax);
    }
}
