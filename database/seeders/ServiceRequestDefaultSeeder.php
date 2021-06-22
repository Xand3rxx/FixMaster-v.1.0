<?php

namespace Database\Seeders;

use App\Models\Payment;
use App\Models\PaymentDisbursed;
use App\Models\Rating;
use App\Models\Referral;
use App\Models\Rfq;
use App\Models\RfqBatch;
use App\Models\ServiceRequest;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\ServiceRequestReport;
use App\Models\ServiceRequestAssigned;
use App\Models\ServiceRequestProgress;
use App\Models\ServiceRequestWarranty;
use App\Models\ServiceRequestCancellation;
use App\Models\ServiceRequestMedia;
use App\Models\ServiceRequestPayment;
use App\Models\ToolRequest;
use App\Models\WalletTransaction;
use App\Models\Warranty;

class ServiceRequestDefaultSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // ServiceRequest::truncate();
        ServiceRequestProgress::truncate();
        ServiceRequestAssigned::truncate();
        ServiceRequestWarranty::truncate();
        ServiceRequestReport::truncate();
        ServiceRequestCancellation::truncate();
        ServiceRequestMedia::truncate();
        ServiceRequestPayment::truncate();
        ToolRequest::truncate();
        Rating::truncate();
        Referral::truncate();
        Rfq::truncate();
        RfqBatch::truncate();
        Payment::truncate();
        PaymentDisbursed::truncate();
        WalletTransaction::truncate();
        Warranty::truncate();
        DB::table('service_requests')->delete();

    }
}
