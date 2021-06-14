<?php

namespace Database\Seeders;
use DB;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ServiceRequestSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('service_request_settings')->insert([
        [
            'uuid'=> Str::uuid('uuid'),
            'radius'=> 4,
            'max_ongoing_jobs'=> 6,
            'created_at'=> date('Y-m-d h:i:s'),
            'updated_at' => date('Y-m-d h:i:s')
        ],
      ]);
    }
}
