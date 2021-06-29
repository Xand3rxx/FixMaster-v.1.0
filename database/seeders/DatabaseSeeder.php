<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            RoleSeeder::class,
            PermissionSeeder::class,
            TownSeeder::class,
            UserSeeder::class,
            CSESeeder::class,
            ClientSeeder::class,
            EstateSeeder::class,
            CategorySeeder::class,
            ServiceSeeder::class,
            StateSeeder::class,
            LgaSeeder::class,
            CountrySeeder::class,
            PaymentModeSeeder::class,
            // PaymentDisbursedSeeder::class,
            ToolInventorySeeder::class,
            TaxSeeder::class,
            TaxHistorySeeder::class,
            QASeeder::class,
            DiscountSeeder::class,
            TechnicianSeeder::class,
            PriceSeeder::class,
            PriceHistorySeeder::class,
            InsertSQLSeeder::class,
            FranchiseeSeeder::class,
            SupplierSeeder::class,
            StatusSeeder::class,
            AdministratorSeeder::class,
            // ServiceRequestSeeder::class,
            EarningsSeeder::class,
            IncomeSeeder::class,
            // PaymentSeeder::class,
            // WalletTransactionSeeder::class,
            WarrantySeeder::class,
            // ServiceRequestPaymentSeeder::class,
            // AdminRatingSeeder::class,
            // AdminReviewSeeder::class,
            ServiceRequestSettingSeeder::class,
            // MediaSeeder::class,
            ServicedAreasSeeder::class,
            // CollaboratorsPaymentSeeder::class,
        ]);
    }
}
