<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;
use Illuminate\Support\Str;

class ToolInventorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tool_inventories')->delete();

        $toolInventories = array(

            array(
                'uuid'      =>  Str::uuid('uuid'),      
                'user_id'   =>  1,
                'name'      =>  'Ladder',
                'quantity'  =>  4,
                'available' =>  3,
            ),
            array(
                'uuid'      =>  Str::uuid('uuid'),      
                'user_id'   =>  1,
                'name'      =>  'Star Screw Driver',
                'quantity'  =>  7,
                'available' =>  5,
            ),
            array(
                'uuid'      =>  Str::uuid('uuid'),      
                'user_id'   =>  1,
                'name'      =>  'Water Hose',
                'quantity'  =>  2,
                'available' =>  2,
            ),
        );

        DB::table('tool_inventories')->insert($toolInventories);
    }
}
