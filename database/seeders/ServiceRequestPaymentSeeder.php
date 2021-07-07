<?php

namespace Database\Seeders;

use App\Models\ServiceRequestPayment;
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
            $requestPayment = new ServiceRequestPayment();
            $requestPayment->user_id =  5;
            $requestPayment->payment_id =  1;
            $requestPayment->service_request_id =  1;
            $requestPayment->amount = 1000;
            $requestPayment->unique_id = 'REF-79A722D6';
            $requestPayment->payment_type = 'booking-fee';
            $requestPayment->status = 'success';
            $requestPayment->save();

            $requestPayment1 = new ServiceRequestPayment();
            $requestPayment1->user_id = 5;
            $requestPayment1->payment_id = 1;
            $requestPayment1->service_request_id = 2;
            $requestPayment1->amount = 1000;
            $requestPayment1->unique_id = 'REF-79A722D6';
            $requestPayment1->payment_type = 'rfq';
            $requestPayment1->status = 'success';
            $requestPayment1->save();

            $requestPayment2 = new ServiceRequestPayment();
            $requestPayment2->user_id = 5;
            $requestPayment2->payment_id = 1;
            $requestPayment2->service_request_id = 2;
            $requestPayment2->amount = 2000;
            $requestPayment2->unique_id = 'REF-79A722D6';
            $requestPayment2->payment_type = 'booking-fee';
            $requestPayment2->status = 'success';
            $requestPayment2->save();

            $requestPayment3 = new ServiceRequestPayment();
            $requestPayment3->user_id = 6;
            $requestPayment3->payment_id = 1;
            $requestPayment3->service_request_id = 4;
            $requestPayment3->amount = 2000;
            $requestPayment3->unique_id = 'REF-27D2F0BE';
            $requestPayment3->payment_type = 'booking-fee';
            $requestPayment3->status = 'success';
            $requestPayment3->save();
         
    }
}
