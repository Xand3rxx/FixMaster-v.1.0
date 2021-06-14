<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;
use App\Models\PaymentMode;

class PaymentModeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('payment_modes')->delete();

        $paymentsDisbursed = array(

            array(
                'name' => 'ATM Transfer',
            ),
            array(
                'name' => 'Bank Transfer',
            ),
            array(
                'name' => 'Internet Banking',
            ),
            array(
                'name' => 'USSD Transfer',
            ),
        );

        DB::table('payment_modes')->insert($paymentsDisbursed);

    }
}
