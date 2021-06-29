<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ServiceRequestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('service_requests')->delete();
        DB::table('service_request_cancellations')->delete();
        DB::table('service_request_assigned')->delete();

        //Admin ID's 22, 23, 24
        //Client ID's 5, 6, 7, 8, 9
        //CSE ID's 2, 3, 4
        //QA ID's 10, 11, 12
        //Technician ID's 13, 14, 15

        $serviceRequests = array(

            array(
                'uuid'                  => Str::uuid('uuid'),      
                'client_id'             => 5, 
                'service_id'            => 1, 
                'unique_id'             => 'REF-79A722D6', 
                'contactme_status'     => 0,
                'price_id'              => 1, 
                'contact_id'              => 4, 
                'client_discount_id'    => 1, 
                'client_security_code'  => 'SEC-02E65DEF',
                'status_id'             => 1, 
                'contactme_status'      => 0,
                'description'           => 'My PC no longer comes on even when plugged into a power source.', 
                'total_amount'          => 1500, 
                'preferred_time'        => NULL,
                'has_client_rated'      => 'No',
                'has_cse_rated'         => 'No',
                'date_completed'        =>  NULL,
                'created_at'            => '2020-12-14 13:39:55',
            ),
            array(
                'uuid'                  => Str::uuid('uuid'),      
                'client_id'             => 5, 
                'service_id'            => 25, 
                'unique_id'             => 'REF-66EB5A26', 
                'contactme_status'     => 1,
                'price_id'              => 2, 
                'contact_id'              => 9, 
                'client_discount_id'    => NULL, 
                'client_security_code'  => 'SEC-27AEC73E', 
                'status_id'             => 2, 
                'contactme_status'      => 1,
                'description'           => 'Hello FixMaster, my dish washer pipe broke an hour ago, now water is spilling profusely, please send help quickly. Thanks', 
                'total_amount'          => 2000, 
                'preferred_time'        => \Carbon\Carbon::now('UTC'),
                'has_client_rated'      => 'No',
                'has_cse_rated'         => 'No',
                'date_completed'        =>  NULL,
                'created_at'            => '2020-12-15 10:51:29',
            ),
            array(
                'uuid'                  => Str::uuid('uuid'),      
                'client_id'             => 5, 
                'service_id'            => 13, 
                'unique_id'             => 'REF-330CB862', 
                'contactme_status'     => 1,
                'price_id'              => 3, 
                'contact_id'              => 10, 
                'client_discount_id'    => NULL, 
                'client_security_code'  => 'SEC-88AC1B19', 
                'status_id'             => 2, 
                'contactme_status'      => 1,
                'description'           => 'Washing machine plug is sparking, the cable appears melted. Thermocool washing machine.', 
                'total_amount'          => 1000, 
                'preferred_time'        => \Carbon\Carbon::now('UTC'),
                'has_client_rated'      => 'No',
                'has_cse_rated'         => 'No',
                'date_completed'        =>  NULL,
                'created_at'            =>  '2021-01-05 15:04:48',
            ),
            array(
                'uuid'                  => Str::uuid('uuid'),      
                'client_id'             => 6, 
                'service_id'            => 1, 
                'unique_id'             => 'REF-27D2F0BE', 
                'contactme_status'     => 0,
                'price_id'              => 2, 
                'contact_id'              => 5, 
                'client_discount_id'    => 1, 
                'client_security_code'  => 'SEC-35FA9E28', 
                'status_id'             => 3, 
                'contactme_status'      => 0,
                'description'           => 'Please I urgently need a repair for my computer, It goes off saying overheating. I think the fan is faulty. You know it\'s New Year, so I\'ll need as swift response, thanks.', 
                'total_amount'          => 2000, 
                'preferred_time'        => \Carbon\Carbon::now('UTC'),
                'has_client_rated'      => 'No',
                'has_cse_rated'         => 'No',
                'date_completed'        =>  NULL,
                'created_at'            =>  '2021-01-14 15:53:45',
            ),
            array(
                'uuid'                  => Str::uuid('uuid'),      
                'client_id'             => 6, 
                'service_id'            => 10, 
                'unique_id'             => 'REF-EEE7FD14', 
                'contactme_status'     => 1,
                'price_id'              => 2, 
                'contact_id'              => 5, 
                'client_discount_id'    => NULL, 
                'client_security_code'  => 'SEC-92F0978A', 
                'status_id'             => 4, 
                'contactme_status'      => 1,
                'description'           => 'System crash error message displayed on screen.', 
                'total_amount'          => 2000, 
                'preferred_time'        => \Carbon\Carbon::now('UTC'),
                'has_client_rated'      => 'Yes',
                'has_cse_rated'         => 'Yes',
                'date_completed'        => '2020-01-07 13:12:43',
                'created_at'            =>  '2020-01-05 18:53:37',
            ),
            array(
                'uuid'                  => Str::uuid('uuid'),      
                'client_id'             => 7, 
                'service_id'            => NULL, 
                'unique_id'             => 'REF-1FC50FCC', 
                'contactme_status'     => 1,
                'price_id'              => 2, 
                'contact_id'              => 6, 
                'client_discount_id'    => 1, 
                'client_security_code'  => 'SEC-EBC1D654', 
                'status_id'             => 1, 
                'contactme_status'      => 1,
                'description'           => 'I cannot really explain what my dilemma is at the moment, just send someone over.', 
                'total_amount'          => 2000, 
                'preferred_time'        =>  '2021-01-06 18:19:11',
                'has_client_rated'      => 'No',
                'has_cse_rated'         => 'No',
                'date_completed'        =>  NULL,
                'created_at'            =>  '2021-01-05 15:53:37',
            ),
            array(
                'uuid'                  => Str::uuid('uuid'),      
                'client_id'             => 8, 
                'service_id'            => 22, 
                'unique_id'             => 'REF-131D985E', 
                'contactme_status'     => 1,
                'price_id'              => 1, 
                'contact_id'              => 7, 
                'client_discount_id'    => 1, 
                'client_security_code'  => 'SEC-A62C515E', 
                'status_id'             => 1, 
                'contactme_status'      => 1,
                'description'           => 'My generator refuses to come on after several attempts.', 
                'total_amount'          => 1500, 
                'preferred_time'        => '2021-01-08 17:05:43',
                'has_client_rated'      => 'No',
                'has_cse_rated'         => 'No',
                'date_completed'        =>  NULL,
                'created_at'            =>  '2021-01-05 16:54:18',
            ),

        );

        $serviceRequestCancelled = array(
            array(
                'user_id'               =>  6, 
                'service_request_id'    =>  4, 
                'reason'                =>  'Performed a hard restart on the computer. So it works fine now. Thanks.',
            ),
        );

        $serviceRequestAssignee = array(
            array(
                'user_id'               => '22', 
                'service_request_id'    => '2',
                'job_accepted'          =>  NULL, 
                'job_acceptance_time'   => NULL,
                'job_diagnostic_date'   =>  NULL,
                'job_declined_time'     =>  NULL,
                'job_completed_date'    =>  NULL,
                'status'                =>  NULL,
                'assistive_role'        =>  NULL,
                'created_at'            => NULL, 
            ),
            array(
                'user_id'               => '2', 
                'service_request_id'    => '2',
                'job_accepted'          =>  'Yes', 
                'job_acceptance_time'   => '2020-12-16 15:08:52',
                'job_diagnostic_date'   =>  '2020-12-16 15:56:17',
                'job_declined_time'     =>  NULL,
                'job_completed_date'    =>  NULL,
                'status'                =>  'Active',
                'assistive_role'        =>  NULL,
                'created_at'            => '2020-12-15 10:51:29',
            ),
            array(
                'user_id'               => '10', 
                'service_request_id'    => '2',
                'job_acceptance_time'   => NULL,
                'job_accepted'          =>  NULL,
                'job_diagnostic_date'   =>  NULL,
                'job_declined_time'     =>  NULL, 
                'job_completed_date'    =>  NULL,
                'status'                =>  NULL,
                'assistive_role'        =>  'Consultant',
                'created_at'            => NULL, 
            ),
            array(
                'user_id'               => '13', 
                'service_request_id'    => '2',
                'job_acceptance_time'   => NULL,
                'job_accepted'          =>  NULL,
                'job_diagnostic_date'   =>  NULL,
                'job_declined_time'     =>  NULL, 
                'job_completed_date'    =>  NULL,
                'status'                =>  NULL,
                'assistive_role'        =>  'Technician',
                'created_at'            => NULL, 
            ),

            array(
                'user_id'               => '22', 
                'service_request_id'    => '3',
                'job_acceptance_time'   => NULL,
                'job_accepted'          =>  NULL,
                'job_diagnostic_date'   =>  NULL,
                'job_declined_time'     =>  NULL, 
                'job_completed_date'    =>  NULL,
                'status'                =>  NULL,
                'assistive_role'        =>  NULL,
                'created_at'            => NULL, 
            ),
            array(
                'user_id'               => '3', 
                'service_request_id'    => '3',
                'job_accepted'          =>  'Yes', 
                'job_acceptance_time'   => '2020-01-07 10:11:52',
                'job_diagnostic_date'   =>  '2020-01-07 11:19:02',
                'job_declined_time'     =>  NULL,
                'job_completed_date'    =>  NULL,
                'status'                =>  'Active',
                'assistive_role'        =>  NULL,
                'created_at'            => '2021-01-05 15:04:48',
            ),
            array(
                'user_id'               => '10', 
                'service_request_id'    => '3',
                'job_acceptance_time'   => NULL,
                'job_accepted'          =>  NULL,
                'job_diagnostic_date'   =>  NULL,
                'job_declined_time'     =>  NULL, 
                'job_completed_date'    =>  NULL,
                'status'                =>  NULL,
                'assistive_role'        =>  'Technician',
                'created_at'            => NULL, 
            ),
            array(
                'user_id'               => '13', 
                'service_request_id'    => '3',
                'job_acceptance_time'   => NULL,
                'job_accepted'          =>  NULL,
                'job_diagnostic_date'   =>  NULL,
                'job_declined_time'     =>  NULL, 
                'job_completed_date'    =>  NULL,
                'status'                =>  NULL,
                'assistive_role'        =>  'Technician',
                'created_at'            => NULL, 
            ),

            array(
                'user_id'               => '22', 
                'service_request_id'    => '5',
                'job_acceptance_time'   => NULL,
                'job_accepted'          =>  NULL,
                'job_diagnostic_date'   =>  NULL,
                'job_declined_time'     =>  NULL, 
                'job_completed_date'    =>  NULL,
                'status'                =>  NULL,
                'assistive_role'        =>  NULL,
                'created_at'            => NULL, 
            ),
            array(
                'user_id'               => '2', 
                'service_request_id'    => '5',
                'job_accepted'          =>  'Yes', 
                'job_acceptance_time'   => '2020-01-07 09:23:44',
                'job_diagnostic_date'   =>  '2020-01-07 12:26:09',
                'job_declined_time'     =>  NULL,
                'status'                =>  'Active',
                'assistive_role'        =>  NULL,
                'job_completed_date'    =>  '2020-01-08 10:34:45',
                'created_at'            => '2021-01-05 15:04:48',
            ),
            array(
                'user_id'               => '10', 
                'service_request_id'    => '5',
                'job_acceptance_time'   => NULL,
                'job_accepted'          =>  NULL,
                'job_diagnostic_date'   =>  NULL,
                'job_declined_time'     =>  NULL,
                'job_completed_date'    =>  NULL, 
                'status'                =>  NULL,
                'assistive_role'        =>  'Consultant',
                'created_at'            => NULL, 
            ),
            array(
                'user_id'               => '13', 
                'service_request_id'    => '5',
                'job_acceptance_time'   => NULL,
                'job_accepted'          =>  NULL,
                'job_diagnostic_date'   =>  NULL,
                'job_declined_time'     =>  NULL, 
                'job_completed_date'    =>  NULL,
                'status'                =>  NULL,
                'assistive_role'        =>  'Technician',
                'created_at'            => NULL, 
            ),


        );


        DB::table('service_requests')->insert($serviceRequests);
        DB::table('service_request_cancellations')->insert($serviceRequestCancelled);
        DB::table('service_request_assigned')->insert($serviceRequestAssignee);


    }
}