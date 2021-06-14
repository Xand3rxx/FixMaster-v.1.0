<?php

namespace Database\Seeders;

use App\Models\Town;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class TownSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Town::truncate();

        $json = File::get("database/json/towns.json");
        $data = json_decode($json);
        foreach ($data as $obj) {
            Town::create([
                'state_id'  => $obj->state_id,
                'name' => $obj->name,
                'lga_id' => $obj->lga_id,
            ]);
        }

        // Using Eloquent ORM, this updates created at and updated at
        // Town::create(['name' => Str::random(10)]);
        // Using Fluent Query Builder this doesn't update created_at and updated_at
        // DB::table('towns')->insert(['name' => Str::random(10)]);
    }
}
