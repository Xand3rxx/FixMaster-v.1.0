<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;
use App\Models\PaymentDisbursed;

class PaymentDisbursedSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('payments_disbursed')->delete();

        PaymentDisbursed::create(
        [
            'user_id'               =>  1,
            'recipient_id'          =>  2,
            'service_request_id'    =>  1,
            'payment_mode_id'          =>  1,
            'payment_reference'     =>  'ebicab1rp0ylc5j',
            'amount'                =>  3500,
            'payment_date'          =>  '2020-12-31',
            'comment'               =>  'No comment',
        ]);

        PaymentDisbursed::create(
        [
            'user_id'               =>  1,
            'recipient_id'          =>  10,
            'service_request_id'    =>  3,
            'payment_mode_id'       =>  3,
            'payment_reference'     =>  'ewiblpq1tslb71m',
            'amount'                =>  2500,
            'payment_date'          =>  '2021-01-09',
            'comment'               =>  'Payment for additional supervison',
        ]);

        PaymentDisbursed::create(
        [
            'user_id'               =>  1,
            'recipient_id'          =>  13,
            'service_request_id'    =>  2,
            'payment_mode_id'          =>  2,
            'payment_reference'     =>  'b6okvlkyjxkbgqf',
            'amount'                =>  2000,
            'payment_date'          =>  '2021-02-31',
            'comment'               =>  'No comment',
        ]);

        PaymentDisbursed::create(
        [
            'user_id'               =>  1,
            'recipient_id'          =>  3,
            'service_request_id'    =>  3,
            'payment_mode_id'       =>  2,
            'payment_reference'     =>  'o4zydovezhjv0d3',
            'amount'                =>  10000,
            'payment_date'          =>  '2021-02-31',
            'comment'               =>  'No comment',
        ]);

        PaymentDisbursed::create(
        [
            'user_id'               =>  1,
            'recipient_id'          =>  10,
            'service_request_id'    =>  3,
            'payment_mode_id'       =>  2,
            'payment_reference'     =>  '0iye1ttve9cyod7',
            'amount'                =>  7500,
            'payment_date'          =>  '2021-02-31',
            'comment'               =>  'No comment',
        ]);

        PaymentDisbursed::create(
        [
            'user_id'               =>  1,
            'recipient_id'          =>  13,
            'service_request_id'    =>  1,
            'payment_mode_id'       =>  2,
            'payment_reference'     =>  'hdtm8dsqc7a4h9z',
            'amount'                =>  5000,
            'payment_date'          =>  '2021-02-31',
            'comment'               =>  'No comment',
        ]);
       
   }
}
