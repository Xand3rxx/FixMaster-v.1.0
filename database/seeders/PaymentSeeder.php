<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class PaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('payments')->delete();

        $payments = array(

            array(
                'user_id'           =>  5,      
                'amount'            =>  1000,
                'payment_channel'   =>  'paystack',
                'payment_for'       =>  'service-request',
                'unique_id'         =>  'REF-79A722D6',
                'reference_id'      =>  'dm3pokb1uigf2ha',
                'transaction_id'    =>  'cb374ny0feiamds',
                'status'            =>  'success',
                'created_at'        =>  \Carbon\Carbon::now('UTC')
            ),
            array(
                'user_id'           =>  5,      
                'amount'            =>  2000,
                'payment_channel'   =>  'wallet',
                'payment_for'       =>  'service-request',
                'unique_id'         =>  'REF-66EB5A26',
                'reference_id'      =>  'lpgwn3as2uh8bz0',
                'transaction_id'    =>  NULL,
                'status'            =>  'success',
                'created_at'        =>  \Carbon\Carbon::now('UTC')
            ),
            array(
                'user_id'           =>  5,      
                'amount'            =>  1000,
                'payment_channel'   =>  'offline',
                'payment_for'       =>  'service-request',
                'unique_id'         =>  'REF-330CB862',
                'reference_id'      =>  'a7hbxopi4g8d130',
                'transaction_id'    =>  NULL,
                'status'            =>  'pending',
                'created_at'        =>  \Carbon\Carbon::now('UTC')
            ),
            array(
                'user_id'           =>  6,      
                'amount'            =>  2000,
                'payment_channel'   =>  'flutterwave',
                'payment_for'       =>  'service-request',
                'unique_id'         =>  'REF-27D2F0BE',
                'reference_id'      =>  'p2setnv6uaybmfz',
                'transaction_id'    =>  'rsx2zyk75t60umf',
                'status'            =>  'success',
                'created_at'        =>  \Carbon\Carbon::now('UTC')
            ),
            array(
                'user_id'           =>  6,      
                'amount'            =>  2000,
                'payment_channel'   =>  'paystack',
                'payment_for'       =>  'service-request',
                'unique_id'         =>  'REF-EEE7FD14',
                'reference_id'      =>  'yq4tikfm5x8hpjd',
                'transaction_id'    =>  NULL,
                'status'            =>  'pending',
                'created_at'        =>  \Carbon\Carbon::now('UTC')
            ),
            array(
                'user_id'           =>  7,      
                'amount'            =>  2000,
                'payment_channel'   =>  'paystack',
                'payment_for'       =>  'service-request',
                'unique_id'         =>  'REF-1FC50FCC',
                'reference_id'      =>  '7nfd6brlgumj9p2',
                'transaction_id'    =>  NULL,
                'status'            =>  'failed',
                'created_at'        =>  \Carbon\Carbon::now('UTC')
            ),
            array(
                'user_id'           =>  8,      
                'amount'            =>  1500,
                'payment_channel'   =>  'paystack',
                'payment_for'       =>  'service-request',
                'unique_id'         =>  'REF-131D985E',
                'reference_id'      =>  'usz08vfqlcj1doy',
                'transaction_id'    =>  NULL,
                'status'            =>  'timeout',
                'created_at'        =>  \Carbon\Carbon::now('UTC')
            ),
            array(
                'user_id'           =>  5,      
                'amount'            =>  3000,
                'payment_channel'   =>  'paystack',
                'payment_for'       =>  'e-wallet',
                'unique_id'         =>  'WAL-760BCC86',
                'reference_id'      =>  'osl3jru8g9qcznp',
                'transaction_id'    =>  '6vp7h24kefdmyts',
                'status'            =>  'success',
                'created_at'        =>  \Carbon\Carbon::now('UTC')
            ),
            array(
                'user_id'           =>  5,      
                'amount'            =>  1300,
                'payment_channel'   =>  'flutterwave',
                'payment_for'       =>  'e-wallet',
                'unique_id'         =>  'WAL-760BCC86',
                'reference_id'      =>  'wtyev38xz2c5fjh',
                'transaction_id'    =>  NULL,
                'status'            =>  'pending',
                'created_at'        =>  \Carbon\Carbon::now('UTC')
            ),
            array(
                'user_id'           =>  5,      
                'amount'            =>  2800,
                'payment_channel'   =>  'flutterwave',
                'payment_for'       =>  'e-wallet',
                'unique_id'         =>  'WAL-760BCC86',
                'reference_id'      =>  'r1d4yjwqo36fi2g',
                'transaction_id'    =>  NULL,
                'status'            =>  'failed',
                'created_at'        =>  \Carbon\Carbon::now('UTC')
            ),
            array(
                'user_id'           =>  6,      
                'amount'            =>  1200,
                'payment_channel'   =>  'flutterwave',
                'payment_for'       =>  'e-wallet',
                'unique_id'         =>  'WAL-A3C9FAC4',
                'reference_id'      =>  'vdp0s7qy1afubex',
                'transaction_id'    =>  'oyekfl1hngr80qu',
                'status'            =>  'success',
                'created_at'        =>  \Carbon\Carbon::now('UTC')
            ),
            array(
                'user_id'           =>  7,      
                'amount'            =>  3500,
                'payment_channel'   =>  'flutterwave',
                'payment_for'       =>  'e-wallet',
                'unique_id'         =>  'WAL-1D61A777',
                'reference_id'      =>  'bh7ot39i80km64s',
                'transaction_id'    =>  NULL,
                'status'            =>  'failed',
                'created_at'        =>  \Carbon\Carbon::now('UTC')
            ),
            array(
                'user_id'           =>  8,      
                'amount'            =>  1450,
                'payment_channel'   =>  'flutterwave',
                'payment_for'       =>  'e-wallet',
                'unique_id'         =>  'WAL-DCE47AD1',
                'reference_id'      =>  'ryaxpmovkz6bth3',
                'transaction_id'    =>  NULL,
                'status'            =>  'pending',
                'created_at'        =>  \Carbon\Carbon::now('UTC')
            ),
            array(
                'user_id'           =>  6,      
                'amount'            =>  2000,
                'payment_channel'   =>  'wallet',
                'payment_for'       =>  'e-wallet',
                'unique_id'         =>  'WAL-DCE47AD1',
                'reference_id'      =>  '2r1gfyujsqbowp6',
                'transaction_id'    =>  NULL,
                'status'            =>  'success',
                'created_at'        =>  \Carbon\Carbon::now('UTC')
            ),
            
        );

        DB::table('payments')->insert($payments);
    }
}
