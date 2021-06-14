<?php

namespace Database\Seeders;

use App\Models\ServiceRequest;
use App\Models\ServiceRequestAssigned;
use App\Models\ServiceRequestCancellation;
use App\Models\ServiceRequestProgress;
use App\Models\ServiceRequestReport;
use App\Models\ServiceRequestWarranty;
use Illuminate\Database\Seeder;

class ServiceRequestDefaultSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        ServiceRequestProgress::truncate();
        ServiceRequestAssigned::truncate();
        ServiceRequestWarranty::truncate();
        ServiceRequestReport::truncate();
        ServiceRequestCancellation::truncate();
    }
}
