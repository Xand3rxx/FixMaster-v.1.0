<?php

namespace Database\Seeders;

use App\Models\Rfq;
use App\Models\Media;
use App\Models\Rating;
use App\Models\Payment;
use App\Models\Referral;
use App\Models\RfqBatch;
use App\Models\ToolRequest;
use Illuminate\Database\Seeder;
use App\Models\PaymentDisbursed;
use App\Models\WalletTransaction;
use Illuminate\Support\Facades\DB;
use App\Models\ServiceRequestMedia;
use App\Models\ServiceRequestReport;
use App\Models\ServiceRequestPayment;
use App\Models\ServiceRequestAssigned;
use App\Models\ServiceRequestProgress;
use App\Models\ServiceRequestWarranty;
use App\Models\ServiceRequestCancellation;

class ServiceRequestDefaultSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ServiceRequestProgress::truncate();
        ServiceRequestAssigned::truncate();
        ServiceRequestWarranty::truncate();
        ServiceRequestReport::truncate();
        ServiceRequestCancellation::truncate();
        // ServiceRequestMedia::truncate(); //For demo for fixmaster
        // Media::truncate(); //For demo for fixmaster
        ServiceRequestPayment::truncate();
        ToolRequest::truncate();
        Rating::truncate();
        Referral::truncate();
        Rfq::truncate();
        RfqBatch::truncate();
        Payment::truncate();
        PaymentDisbursed::truncate();
        WalletTransaction::truncate();
        DB::table('service_requests')->delete();

    }
}
