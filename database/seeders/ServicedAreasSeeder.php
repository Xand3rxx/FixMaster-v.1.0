<?php

namespace Database\Seeders;

use App\Models\ServicedAreas;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class ServicedAreasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ServicedAreas::truncate();

        $json = File::get("database/json/servicedAreas.json");
        $data = json_decode($json);
        foreach ($data as $obj) {
            ServicedAreas::create([
                'state_id'  => $obj->state_id,
                'lga_id'    => $obj->lga_id,
                'town_id'   => $obj->town_id,
            ]);
        }




    }
}
