<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Review;

class AdminReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $review = new Review();
        $review->client_id = 5;
        $review->service_id = 1;
        $review->reviews = 'Hi, I am Derrick Nnamdi from Aba. My employers used FixMaster for the companys outdoor advertising project based on my recommendation and they more than delivered. They handled the metal fabrication, hoisting and went on to offer a discount on the banner itself. Now that is what i call service delivery. I would not hesitate to recommend FixMaster.';
        $review->save();

        $review1 = new Review();
        $review1->client_id = 7;
        $review1->service_id = 2;
        $review1->reviews ="The service is top class. I recommend them if you want to beef up your home, office or company security with top class surveillance systems, electric gates etc. They are the solution to your security problems.";
        $review1->save();
    }
}
