<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class ServiceRequestPaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('service_request_payments')->delete();
        // DB::table('service_request_progresses')->delete();

        $serviceRequestPayments = array(

            array(
                'user_id'               =>  5,
                'payment_id'            =>  1,
                'service_request_id'    =>  1,
                'amount'                =>  1000,
                'unique_id'             =>  'REF-79A722D6',
                'payment_type'          =>  'booking-fee',
                'status'                => 'success',
            ),
            array(
                'user_id'               =>  5,
                'payment_id'            =>  1,
                'service_request_id'    =>  2,
                'amount'                =>  2000,
                'unique_id'             =>  'REF-79A722D6',
                'payment_type'          =>  'booking-fee',
                'status'                => 'success',
            ),
            array(
                'user_id'               =>  6,
                'payment_id'            =>  1,
                'service_request_id'    =>  4,
                'amount'                =>  2000,
                'unique_id'             =>  'REF-27D2F0BE',
                'payment_type'          =>  'booking-fee',
                'status'                => 'success',
            ),
            
        );

        // $serviceRequestProgress = array(

        //     array(
        //         'user_id'               =>  1,
        //         'service_request_id'    =>  2,
        //         'status_id'             =>  1,
        //         'sub_status_id'         =>  1,
        //         'created_at'            =>  '2021-03-26 02:21:38'
        //     ),
        //     array(
        //         'user_id'               =>  2,
        //         'service_request_id'    =>  2,
        //         'status_id'             =>  1,
        //         'sub_status_id'         =>  2,
        //         'created_at'            =>  '2021-03-26 02:21:38'
        //     ),
        //     array(
        //         'user_id'               =>  2,
        //         'service_request_id'    =>  2,
        //         'status_id'             =>  2,
        //         'sub_status_id'         =>  8,
        //         'created_at'            =>  '2021-03-26 08:05:13'
        //     ),
        //     array(
        //         'user_id'               =>  2,
        //         'service_request_id'    =>  2,
        //         'status_id'             =>  2,
        //         'sub_status_id'         =>  11,
        //         'created_at'            =>  '2021-03-26 10:30:46'
        //     ),
        //     array(
        //         'user_id'               =>  2,
        //         'service_request_id'    =>  2,
        //         'status_id'             =>  2,
        //         'sub_status_id'         =>  12,
        //         'created_at'            =>  '2021-03-26 10:45:19'
        //     ),
        //     array(
        //         'user_id'               =>  2,
        //         'service_request_id'    =>  2,
        //         'status_id'             =>  2,
        //         'sub_status_id'         =>  1,
        //         'sub_status_id'         =>  13,
        //         'created_at'            =>  '2021-03-26 11:33:51'
        //     ),
            
        // );

        DB::table('service_request_payments')->insert($serviceRequestPayments);
        // DB::table('service_request_progresses')->insert($serviceRequestProgress);

        // 
    }
}
