<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;
use App\Models\State;

class StateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // truncate `states` table
        DB::table('states')->delete();

        // associative array of Nigerian states and codes
        $states = [
            'AB' => 'Abia',
            'AD' => 'Adamawa',
            'AK' => 'Akwa Ibom',
            'AN' => 'Anambra',
            'BA' => 'Bauchi',
            'BY' => 'Bayelsa',
            'BE' => 'Benue',
            'BO' => 'Borno',
            'CR' => 'Cross River',
            'DE' => 'Delta',
            'EB' => 'Ebonyi',
            'ED' => 'Edo',
            'EK' => 'Ekiti',
            'EN' => 'Enugu',
            'GO' => 'Gombe',
            'IM' => 'Imo',
            'JI' => 'Jigawa',
            'KD' => 'Kaduna',
            'KN' => 'Kano',
            'KT' => 'Katsina',
            'KE' => 'Kebbi',
            'KO' => 'Kogi',
            'KW' => 'Kwara',
            'LA' => 'Lagos',
            'NA' => 'Nassarawa',
            'NI' => 'Niger',
            'OG' => 'Ogun',
            'ON' => 'Ondo',
            'OS' => 'Osun',
            'OY' => 'Oyo',
            'PL' => 'Plateau',
            'RI' => 'Rivers',
            'SO' => 'Sokoto',
            'TA' => 'Taraba',
            'YO' => 'Yobe',
            'ZA' => 'Zamfara',
            'FC' => 'Abuja Federal Capital Territory',
        ];

        // put each item in associative array into new array that can be inserted by query builder
        // $data = [];
        // foreach ($states as $code => $name) {
        //     $data[] = [
        //         'code' => $code,
        //         'name' => $name
        //     ];
        // }
        // DB::table('states')->insert($data);

        /*
        * To get timestamps (created_at, updated_at) automatically added, you can use Eloquent to create instead:
        */

        foreach ($states as $code => $name) {
          State::create([
            'code' => $code,
            'name' => $name
          ]);
        } 
    }
}
