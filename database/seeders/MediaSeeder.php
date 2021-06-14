<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class MediaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('medias')->delete();
        DB::table('service_request_medias')->delete();
        
        $medias = array(

            array(
                'client_id'     =>  5,
                'original_name' =>  'maxresdefault.jpeg',
                'unique_name'   =>  'd1d256a2-08f3-4788-a1cc-16e83fcef660.jpeg',
                'created_at'    =>  '2020-12-14 13:39:55',
            ),
            array(
                'client_id'     =>  5,
                'original_name' =>  '20190919_122724.jpeg',
                'unique_name'   =>  'ab9eac54-1da0-4104-9104-fe7f43e2b833.jpeg',
                'created_at'    =>  '2020-12-15 09:11:14',
            ),
            array(
                'client_id'     =>  5,
                'original_name' =>  'CZEuI.jpeg',
                'unique_name'   =>  'f66653c3-bcea-4e38-bd58-44db5c6d4145.jpeg',
                'created_at'    =>  '2020-12-15 10:51:29',
            ),
            array(
                'client_id'     =>  5,
                'original_name' =>  'IMG_00210.jpeg',
                'unique_name'   =>  '689c2ab1-391f-4875-ac72-1fffb9224390.jpeg',
                'created_at'    =>  '2020-12-16 10:51:29',
            ),
            array(
                'client_id'     =>  5,
                'original_name' =>  '012505114021_install.pdf',
                'unique_name'   =>  '20b3e1e2-9e76-4a37-9268-06433ad3ea00.pdf',
                'created_at'    =>  '2020-12-17 14:22:50',
            )
        );

        $serviceRequestMedias = array(
            array(
                'media_id'              => 1,
                'service_request_id'    => 1,
                'created_at'    =>  '2020-12-14 13:39:55',
            ),
            array(
                'media_id'              => 2,
                'service_request_id'    => 1,
                'created_at'    =>  '2020-12-15 09:11:14',
            ),
            array(
                'media_id'              => 3,
                'service_request_id'    => 2,
                'created_at'    =>  '2020-12-15 10:51:29',
            ),
            array(
                'media_id'              => 4,
                'service_request_id'    => 2,
                'created_at'    =>  '2020-12-16 10:51:29',
            ),
            array(
                'media_id'              => 5,
                'service_request_id'    => 2,
                'created_at'    =>  '2020-12-17 14:22:50',
            )
        );

        DB::table('medias')->insert($medias);
        DB::table('service_request_medias')->insert($serviceRequestMedias);
    }
}
