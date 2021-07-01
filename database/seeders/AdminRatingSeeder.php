<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Rating;

class AdminRatingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
<<<<<<< HEAD
        //cse rating
        $rate = new Rating();
        $rate->rater_id = 6;
        $rate->ratee_id = 2;
        $rate->service_request_id = 3;
        $rate->service_id = 2;
        $rate->star = 4;
        $rate->created_at = '2021-01-17 21:08:55';
        $rate->save();

        //service rating
        $rate1 = new Rating();
        $rate1->rater_id = 6;
        $rate1->ratee_id = 10;
        $rate1->service_request_id = 3;
        $rate1->service_id = 2;
        $rate1->star = 5;
        $rate1->created_at = '2021-01-27 16:36:58';
        $rate1->save();

        //service rating
        $rate6 = new Rating();
        $rate6->rater_id = 6;
        $rate6->ratee_id = 13;
        $rate6->service_request_id = 3;
        $rate6->service_id = 2;
        $rate6->star = 4;
        $rate6->created_at = '2021-01-27 16:36:58';
        $rate6->save();

=======
>>>>>>> 740a0f0aae1b6c6dc1ad8c990caf413b1d5597b6
        //cse Diagnosis rating
        $rate2 = new Rating();
        $rate2->rater_id = 5;
        $rate2->ratee_id = 2;
        $rate2->service_request_id = 5;
        $rate2->service_id = 10;
        $rate2->star = 3;
        $rate2->service_diagnosis_by = 2;
        $rate2->created_at = '2021-02-19 13:39:55';
        $rate2->save();

        $rate3 = new Rating();
        $rate3->rater_id = 2;
        $rate3->ratee_id = 19;
        $rate3->service_request_id = 5;
        $rate3->service_id = 10;
        $rate3->star = 4;
        $rate3->created_at = '2021-03-09 21:09:18';
        $rate3->save();

        $rate4 = new Rating();
        $rate4->rater_id = 2;
        $rate4->ratee_id = 10;
        $rate4->service_request_id = 5;
        $rate4->service_id = 10;
        $rate4->star = 3;
        $rate4->created_at = '2021-03-09 12:26:09';
        $rate4->save();

        $rate5 = new Rating();
        $rate5->rater_id = 2;
        $rate5->ratee_id = 13;
        $rate5->service_request_id = 5;
        $rate5->service_id = 10;
        $rate5->star = 4;
        $rate5->created_at = '2021-03-10 10:11:52';
        $rate5->save();
    }
}
