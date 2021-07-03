<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class InsertSQLSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $banks = file_get_contents(database_path() . '/insert_sql/banks.sql');
        $paymentGateways = file_get_contents(database_path() . '/insert_sql/payment_gateways.sql');
        $professions = file_get_contents(database_path() . '/insert_sql/professions.sql');
        // $toolRequests = file_get_contents(database_path() . '/insert_sql/tool_requests.sql');
        // $toolRequestBatches = file_get_contents(database_path() . '/insert_sql/tool_request_batches.sql');
        // $rfqs = file_get_contents(database_path() . '/insert_sql/rfqs.sql');
        // $rfqBatches = file_get_contents(database_path() . '/insert_sql/rfq_batches.sql');
        // $rfqSuppliers = file_get_contents(database_path() . '/insert_sql/rfq_suppliers.sql');
        // $serviceRequestWarranties = file_get_contents(database_path() . '/insert_sql/service_request_warranties.sql');
        $messageTemplates = file_get_contents(database_path() . '/insert_sql/message_templates.sql');

        DB::statement($banks);
        DB::statement($paymentGateways);
        DB::statement($professions);
        // DB::statement($toolRequests);
        // DB::statement($toolRequestBatches);
        // DB::statement($rfqs);
        // DB::statement($rfqBatches);
        // DB::statement($rfqSuppliers);
        // DB::statement($serviceRequestWarranties);
        DB::statement($messageTemplates);
        
    }
}


