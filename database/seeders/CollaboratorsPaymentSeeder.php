<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\CollaboratorsPayment;

class CollaboratorsPaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        CollaboratorsPayment::truncate();

        $collab_payment1 = new CollaboratorsPayment();
        $collab_payment1->service_request_id = 1;
        $collab_payment1->user_id = 2;
        $collab_payment1->service_type = 'Regular';
        $collab_payment1->flat_rate = 1000;
        $collab_payment1->amount_to_be_paid = 1000;
        $collab_payment1->save();

        $collab_payment2 = new CollaboratorsPayment();
        $collab_payment2->service_request_id = 1;
        $collab_payment2->user_id = 13;
        $collab_payment2->service_type = 'Regular';
        $collab_payment2->actual_labour_cost = 1000;
        $collab_payment2->amount_to_be_paid = 950;
        $collab_payment2->amount_after_retention = 950;
        $collab_payment2->retention_fee = 50;
        $collab_payment2->labour_markup_cost = 100;
        $collab_payment2->save();


        DB::table('users')->update(['email_verified_at' => now()]);

    }
}
