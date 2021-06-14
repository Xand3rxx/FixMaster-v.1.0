<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;
use App\Models\Lga;

class LgaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // truncate `lgas` table
        DB::table('lgas')->delete();

        DB::table('lgas')->insert([
            'name' => 'Aba North',
            'state_id' => '1'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Aba South ',
            'state_id' => '1'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Arochukwu',
            'state_id' => '1'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Bende',
            'state_id' => '1'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Ikwuano',
            'state_id' => '1'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Isiala-Ngwa North',
            'state_id' => '1'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Isiala-Ngwa South',
            'state_id' => '1'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Isuikwato',
            'state_id' => '1'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Ngwa',
            'state_id' => '1'
        ]);

        DB::table('lgas')->insert([
            'name' => ' Obi Nwa',
            'state_id' => '1'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Ohafia',
            'state_id' => '1'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Osisioma',
            'state_id' => '1'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Ugwunagbo',
            'state_id' => '1'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Ukwa East',
            'state_id' => '1'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Ukwa West',
            'state_id' => '1'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Umuahia North',
            'state_id' => '1'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Umuahia South',
            'state_id' => '1'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Umu-Neochi',
            'state_id' => '1'
        ]);

        //Adamawa

         DB::table('lgas')->insert([
            'name' => 'Demsa',
            'state_id' => '2'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Fufore',
            'state_id' => '2'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Ganaye',
            'state_id' => '2'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Gireri',
            'state_id' => '2'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Gombi',
            'state_id' => '2'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Guyuk',
            'state_id' => '2'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Hong',
            'state_id' => '2'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Jada',
            'state_id' => '2'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Lamurde',
            'state_id' => '2'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Madagali',
            'state_id' => '2'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Maiha',
            'state_id' => '2'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Mayo-Belwa',
            'state_id' => '2'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Michika',
            'state_id' => '2'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Mubi North',
            'state_id' => '2'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Mubi South',
            'state_id' => '2'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Numan',
            'state_id' => '2'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Shelleng',
            'state_id' => '2'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Song',
            'state_id' => '2'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Toungo',
            'state_id' => '2'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Yola North',
            'state_id' => '2'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Yola South',
            'state_id' => '2'
        ]);

        // Akwa-Ibom
        DB::table('lgas')->insert([
            'name' => 'Abak',
            'state_id' => '3'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Eastern Obolo',
            'state_id' => '3'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Eket',
            'state_id' => '3'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Esit Eket',
            'state_id' => '3'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Essien Udim',
            'state_id' => '3'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Etim Ekpo',
            'state_id' => '3'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Etinan',
            'state_id' => '3'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Ibeno',
            'state_id' => '3'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Ibesikpo Asutan',
            'state_id' => '3'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Ibiono Ibom',
            'state_id' => '3'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Ika',
            'state_id' => '3'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Ikono',
            'state_id' => '3'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Ikot Abasi',
            'state_id' => '3'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Ikot Ekpene',
            'state_id' => '3'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Ini',
            'state_id' => '3'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Itu',
            'state_id' => '3'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Mbo',
            'state_id' => '3'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Mkpat Enin',
            'state_id' => '3'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Nsit Atai',
            'state_id' => '3'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Nsit Ibom',
            'state_id' => '3'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Nsit Ubium',
            'state_id' => '3'
        ]);
        DB::table('lgas')->insert([
            'name' => 'Obot Akara',
            'state_id' => '3'
        ]);
        DB::table('lgas')->insert([
            'name' => 'Okobo',
            'state_id' => '3'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Onna',
            'state_id' => '3'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Oron',
            'state_id' => '3'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Orok Anam',
            'state_id' => '3'
        ]);
        DB::table('lgas')->insert([
            'name' => 'Udung Uko',
            'state_id' => '3'
        ]);
        DB::table('lgas')->insert([
            'name' => 'Ukanafun',
            'state_id' => '3'
        ]);
        DB::table('lgas')->insert([
            'name' => 'Uruan',
            'state_id' => '3'
        ]);
        DB::table('lgas')->insert([
            'name' => 'Urue-Offong/Oruko',
            'state_id' => '3'
        ]);
        DB::table('lgas')->insert([
            'name' => 'Uyo',
            'state_id' => '3'
        ]);


        // Anambra
        DB::table('lgas')->insert([
            'name' => 'Aguata',
            'state_id' => '4'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Anambra East',
            'state_id' => '4'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Anambra West',
            'state_id' => '4'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Anaocha',
            'state_id' => '4'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Awka North',
            'state_id' => '4'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Awka South',
            'state_id' => '4'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Ayamelum',
            'state_id' => '4'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Dunukofia',
            'state_id' => '4'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Ekwusigo',
            'state_id' => '4'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Idemili North',
            'state_id' => '4'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Idemili South',
            'state_id' => '4'
        ]);

        DB::table('lgas')->insert([
            'name' => 'ihiala',
            'state_id' => '4'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Njikoka',
            'state_id' => '4'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Nnewi North',
            'state_id' => '4'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Nnewi South',
            'state_id' => '4'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Ogbaru',
            'state_id' => '4'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Onitsha North',
            'state_id' => '4'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Onitsha South',
            'state_id' => '4'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Onumba N',
            'state_id' => '4'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Onumba South',
            'state_id' => '4'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Oyi',
            'state_id' => '4'
        ]);

        //  Bauchi
        DB::table('lgas')->insert([
            'name' => 'Alkaleri',
            'state_id' => '5'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Bauchi',
            'state_id' => '5'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Bogoro',
            'state_id' => '5'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Damban',
            'state_id' => '5'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Darazo',
            'state_id' => '5'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Dass',
            'state_id' => '5'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Ganjuwa',
            'state_id' => '5'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Giade',
            'state_id' => '5'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Itas/Gadau',
            'state_id' => '5'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Jama"are',
            'state_id' => '5'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Katagum',
            'state_id' => '5'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Kirfi',
            'state_id' => '5'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Misau',
            'state_id' => '5'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Ningi',
            'state_id' => '5'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Shira',
            'state_id' => '5'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Tafawa-Balewa',
            'state_id' => '5'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Toro',
            'state_id' => '5'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Warji',
            'state_id' => '5'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Zaki',
            'state_id' => '5'
        ]);

        // Bayelsa
        DB::table('lgas')->insert([
            'name' => 'Brass',
            'state_id' => '6'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Ekeremor',
            'state_id' => '6'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Kolokuma/Opokuma',
            'state_id' => '6'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Nembe',
            'state_id' => '6'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Ogbia',
            'state_id' => '6'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Sagbama',
            'state_id' => '6'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Southern Jaw',
            'state_id' => '6'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Yenegoa',
            'state_id' => '6'
        ]);

        // Benue
        DB::table('lgas')->insert([
            'name' => 'Ado',
            'state_id' => '7'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Agatu',
            'state_id' => '7'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Apa',
            'state_id' => '7'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Buruku',
            'state_id' => '7'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Gboko',
            'state_id' => '7'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Guma',
            'state_id' => '7'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Gwer East',
            'state_id' => '7'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Gwer West',
            'state_id' => '7'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Katsina-Ala',
            'state_id' => '7'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Konshisha',
            'state_id' => '7'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Kwande',
            'state_id' => '7'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Logo',
            'state_id' => '7'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Markurdi',
            'state_id' => '7'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Obi',
            'state_id' => '7'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Ogbadipo',
            'state_id' => '7'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Oju',
            'state_id' => '7'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Okpokwu',
            'state_id' => '7'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Ohimini',
            'state_id' => '7'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Oturkpo',
            'state_id' => '7'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Tarka',
            'state_id' => '7'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Ukum',
            'state_id' => '7'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Ushongo',
            'state_id' => '7'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Vandeikya',
            'state_id' => '7'
        ]);

        //  Bornu
        DB::table('lgas')->insert([
            'name' => 'Abadam',
            'state_id' => '8'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Askira/Uba',
            'state_id' => '8'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Bama',
            'state_id' => '8'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Bayo',
            'state_id' => '8'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Biu',
            'state_id' => '8'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Chibok',
            'state_id' => '8'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Damboa',
            'state_id' => '8'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Dikwa',
            'state_id' => '8'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Gubio',
            'state_id' => '8'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Guzamala',
            'state_id' => '8'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Gwoza',
            'state_id' => '8'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Hawul',
            'state_id' => '8'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Jere',
            'state_id' => '8'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Kaga',
            'state_id' => '8'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Kala/Balge',
            'state_id' => '8'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Konduga',
            'state_id' => '8'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Kukawa',
            'state_id' => '8'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Kwaya Kusar',
            'state_id' => '8'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Mafa',
            'state_id' => '8'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Magumeri',
            'state_id' => '8'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Maiduguri',
            'state_id' => '8'
        ]);
		DB::table('lgas')->insert([
            'name' => 'Marte',
            'state_id' => '8'
        ]);
		DB::table('lgas')->insert([
            'name' => 'Mobbar',
            'state_id' => '8'
        ]);
		DB::table('lgas')->insert([
            'name' => 'Monguno',
            'state_id' => '8'
        ]);
		DB::table('lgas')->insert([
            'name' => 'Ngala',
            'state_id' => '8'
        ]);
		DB::table('lgas')->insert([
            'name' => 'Nganzai',
            'state_id' => '8'
        ]);
		DB::table('lgas')->insert([
            'name' => 'Shani',
            'state_id' => '8'
        ]);

        // Cross-River
        DB::table('lgas')->insert([
            'name' => 'Akpabuyo',
            'state_id' => '9'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Odukpani',
            'state_id' => '9'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Akamkpa',
            'state_id' => '9'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Biase',
            'state_id' => '9'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Abi',
            'state_id' => '9'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Ikom',
            'state_id' => '9'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Yarkur',
            'state_id' => '9'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Odubra',
            'state_id' => '9'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Boki',
            'state_id' => '9'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Ogoja',
            'state_id' => '9'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Yala',
            'state_id' => '9'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Obanliku',
            'state_id' => '9'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Obudu',
            'state_id' => '9'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Calabar South',
            'state_id' => '9'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Etung',
            'state_id' => '9'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Bekwara',
            'state_id' => '9'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Bakasi',
            'state_id' => '9'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Calabar Municipality',
            'state_id' => '9'
        ]);

        // Delta
        DB::table('lgas')->insert([
            'name' => 'Oshimili',
            'state_id' => '10'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Aniocha',
            'state_id' => '10'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Aniocha-South',
            'state_id' => '10'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Ika South',
            'state_id' => '10'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Ika North-East',
            'state_id' => '10'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Ndokwa West',
            'state_id' => '10'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Ndokwa East',
            'state_id' => '10'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Isoko South',
            'state_id' => '10'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Isoko North',
            'state_id' => '10'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Bomadi',
            'state_id' => '10'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Burutu',
            'state_id' => '10'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Ughelli South',
            'state_id' => '10'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Ughelli North',
            'state_id' => '10'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Ethiope West',
            'state_id' => '10'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Ethiope East',
            'state_id' => '10'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Sapele',
            'state_id' => '10'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Okpe',
            'state_id' => '10'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Warri North',
            'state_id' => '10'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Warri South',
            'state_id' => '10'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Uvwie',
            'state_id' => '10'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Udu',
            'state_id' => '10'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Warri Central',
            'state_id' => '10'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Ukwani',
            'state_id' => '10'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Oshimili North',
            'state_id' => '10'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Patani',
            'state_id' => '10'
        ]);

        // Ebonyi
        DB::table('lgas')->insert([
            'name' => 'Afikpo South',
            'state_id' => '11'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Afikpo North',
            'state_id' => '11'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Onicha',
            'state_id' => '11'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Ohaozara',
            'state_id' => '11'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Abakaliki',
            'state_id' => '11'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Ishielu',
            'state_id' => '11'
        ]);

         DB::table('lgas')->insert([
            'name' => 'lkwo',
            'state_id' => '11'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Ezza',
            'state_id' => '11'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Ezza South',
            'state_id' => '11'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Ohaukwu',
            'state_id' => '11'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Ebonyi',
            'state_id' => '11'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Ivo',
            'state_id' => '11'
        ]);

        // Edo
        DB::table('lgas')->insert([
            'name' => 'Akoko Edo',
            'state_id' => '12'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Egor',
            'state_id' => '12'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Esan Central',
            'state_id' => '12'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Esan North-East',
            'state_id' => '12'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Esan South-East',
            'state_id' => '12'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Esan West',
            'state_id' => '12'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Etsako Central',
            'state_id' => '12'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Etsako East',
            'state_id' => '12'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Etsako West',
            'state_id' => '12'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Igueben',
            'state_id' => '12'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Ikpoba Okha',
            'state_id' => '12'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Oredo',
            'state_id' => '12'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Orhiomwon',
            'state_id' => '12'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Ovia North East',
            'state_id' => '12'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Ovia SouthWest',
            'state_id' => '12'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Owan East',
            'state_id' => '12'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Owan West',
            'state_id' => '12'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Uhunmwonde',
            'state_id' => '12'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Ukpoba',
            'state_id' => '12'
        ]);

        // Ekiti
        DB::table('lgas')->insert([
            'name' => 'Ado',
            'state_id' => '13'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Ekiti-East',
            'state_id' => '13'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Ekiti-West',
            'state_id' => '13'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Emure/Ise/Orun',
            'state_id' => '13'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Ekiti South-West',
            'state_id' => '13'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Ikare',
            'state_id' => '13'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Irepodun',
            'state_id' => '13'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Ijero',
            'state_id' => '13'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Ido/Osi',
            'state_id' => '13'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Oye',
            'state_id' => '13'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Ikole',
            'state_id' => '13'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Moba',
            'state_id' => '13'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Gbonyin',
            'state_id' => '13'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Efon',
            'state_id' => '13'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Ise/Orun',
            'state_id' => '13'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Ilejemeje',
            'state_id' => '13'
        ]);

        // Enugu
        DB::table('lgas')->insert([
            'name' => 'Agwu',
            'state_id' => '14'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Enugu South',
            'state_id' => '14'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Igbo-Eze South',
            'state_id' => '14'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Enugu North',
            'state_id' => '14'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Nkanu',
            'state_id' => '14'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Udi',
            'state_id' => '14'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Oji-River',
            'state_id' => '14'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Ezeagu',
            'state_id' => '14'
        ]);

         DB::table('lgas')->insert([
            'name' => 'IgboEze North',
            'state_id' => '14'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Isi-Uzo',
            'state_id' => '14'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Nsukka',
            'state_id' => '14'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Igbo-Ekiti',
            'state_id' => '14'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Uzo-Uwani',
            'state_id' => '14'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Enugu East',
            'state_id' => '14'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Aninri',
            'state_id' => '14'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Nkanu South',
            'state_id' => '14'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Udenu',
            'state_id' => '14'
        ]);

        // Gombe
        DB::table('lgas')->insert([
            'name' => 'Akko',
            'state_id' => '15'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Balanga',
            'state_id' => '15'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Billiri',
            'state_id' => '15'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Dukku',
            'state_id' => '15'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Kaltungo',
            'state_id' => '15'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Kwami',
            'state_id' => '15'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Shomgom',
            'state_id' => '15'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Funakaye',
            'state_id' => '15'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Gombe',
            'state_id' => '15'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Nafada/Bajoga',
            'state_id' => '15'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Yamaltu/Delta',
            'state_id' => '15'
        ]);

        // Imo
        DB::table('lgas')->insert([
            'name' => 'Aboh-Mbaise',
            'state_id' => '16'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Ahiazu-Mbaise',
            'state_id' => '16'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Ehime-Mbano',
            'state_id' => '16'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Ezinihitte',
            'state_id' => '16'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Ideato North',
            'state_id' => '16'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Ideato South',
            'state_id' => '16'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Ihitte/Uboma',
            'state_id' => '16'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Ikeduru',
            'state_id' => '16'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Isiala Mbano',
            'state_id' => '16'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Isu',
            'state_id' => '16'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Mbaitoli',
            'state_id' => '16'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Ngor-Okpala',
            'state_id' => '16'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Njaba',
            'state_id' => '16'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Nwangele',
            'state_id' => '16'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Nkwerre',
            'state_id' => '16'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Obowo',
            'state_id' => '16'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Oguta',
            'state_id' => '16'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Ohaji/Egbeme',
            'state_id' => '16'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Okigwe',
            'state_id' => '16'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Orlu',
            'state_id' => '16'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Orsu',
            'state_id' => '16'
        ]);
        DB::table('lgas')->insert([
            'name' => 'Oru East',
            'state_id' => '16'
        ]);
        DB::table('lgas')->insert([
            'name' => 'Oru West',
            'state_id' => '16'
        ]);
        DB::table('lgas')->insert([
            'name' => 'Owerri-Municipal',
            'state_id' => '16'
        ]);
        DB::table('lgas')->insert([
            'name' => 'Owerri North',
            'state_id' => '16'
        ]);
        DB::table('lgas')->insert([
            'name' => 'Owerri West',
            'state_id' => '16'
        ]);

        // Jigawa
       DB::table('lgas')->insert([
            'name' =>  'Auyo',
            'state_id' => '17'
        ]);

         DB::table('lgas')->insert([
            'name' =>  'Babura',
            'state_id' => '17'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Birni kudu',
            'state_id' => '17'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Birniwa',
            'state_id' => '17'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Buji',
            'state_id' => '17'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Dutse',
            'state_id' => '17'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Gagarawa',
            'state_id' => '17'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Garki',
            'state_id' => '17'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Gumel',
            'state_id' => '17'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Guri',
            'state_id' => '17'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Gwaram',
            'state_id' => '17'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Gwiwa',
            'state_id' => '17'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Hadejia',
            'state_id' => '17'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Jahun',
            'state_id' => '17'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Kafin Hausa',
            'state_id' => '17'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Kaugama Kazaure',
            'state_id' => '17'
        ]);


        DB::table('lgas')->insert([
            'name' => 'kiri kasamma',
            'state_id' => '17'
        ]);

         DB::table('lgas')->insert([
            'name' => 'kiyawa',
            'state_id' => '17'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Maigatari',
            'state_id' => '17'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Malam Madori',
            'state_id' => '17'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Miga',
            'state_id' => '17'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Ringim',
            'state_id' => '17'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Roni',
            'state_id' => '17'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Sule-Tankarkar',
            'state_id' => '17'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Taura',
            'state_id' => '17'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Yankwashi',
            'state_id' => '17'
        ]);

        // Kaduna
        DB::table('lgas')->insert([
            'name' => 'Birni-Gwari',
            'state_id' => '18'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Chikun',
            'state_id' => '18'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Giwa',
            'state_id' => '18'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Igabi',
            'state_id' => '18'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Ikara',
            'state_id' => '18'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Jaba',
            'state_id' => '18'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Jema"a',
            'state_id' => '18'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Kachia',
            'state_id' => '18'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Kaduna North',
            'state_id' => '18'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Kaduna South',
            'state_id' => '18'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Kagarko',
            'state_id' => '18'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Kajuru',
            'state_id' => '18'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Kaura',
            'state_id' => '18'
        ]);

         DB::table('lgas')->insert([
            'name' =>  'Kauru',
            'state_id' => '18'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Kubua',
            'state_id' => '18'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Kudan',
            'state_id' => '18'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Lere',
            'state_id' => '18'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Makarfi',
            'state_id' => '18'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Sabon-gari',
            'state_id' => '18'
        ]);

          DB::table('lgas')->insert([
            'name' => 'Sanga',
            'state_id' => '18'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Soba',
            'state_id' => '18'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Zango-kataf',
            'state_id' => '18'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Zaria',
            'state_id' => '18'
        ]);

        // Kano
        DB::table('lgas')->insert([
            'name' => 'Ajingi',
            'state_id' => '19'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Albasu',
            'state_id' => '19'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Bagwai',
            'state_id' => '19'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Bebeji',
            'state_id' => '19'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Bichi',
            'state_id' => '19'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Bunkure',
            'state_id' => '19'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Dala',
            'state_id' => '19'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Dambatta',
            'state_id' => '19'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Dawakin kudu',
            'state_id' => '19'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Dawakin tofa',
            'state_id' => '19'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Doguwa',
            'state_id' => '19'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Fagge',
            'state_id' => '19'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Gabasawa',
            'state_id' => '19'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Garko',
            'state_id' => '19'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Garum',
            'state_id' => '19'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Mallam',
            'state_id' => '19'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Gaya',
            'state_id' => '19'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Gezawa',
            'state_id' => '19'
        ]);

          DB::table('lgas')->insert([
            'name' => 'Gwale',
            'state_id' => '19'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Gwarzo',
            'state_id' => '19'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Kabo',
            'state_id' => '19'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Kano Municipal',
            'state_id' => '19'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Karaye',
            'state_id' => '19'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Kibiya',
            'state_id' => '19'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Kiru',
            'state_id' => '19'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Kumbutso',
            'state_id' => '19'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Kunchi',
            'state_id' => '19'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Kura',
            'state_id' => '19'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Madobi',
            'state_id' => '19'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Makoda',
            'state_id' => '19'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Minjibir',
            'state_id' => '19'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Nasarawa',
            'state_id' => '19'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Rano',
            'state_id' => '19'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Rimin Gado',
            'state_id' => '19'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Rogo',
            'state_id' => '19'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Shano',
            'state_id' => '19'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Sumaila',
            'state_id' => '19'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Takali',
            'state_id' => '19'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Tarauni',
            'state_id' => '19'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Tofa',
            'state_id' => '19'
        ]);

          DB::table('lgas')->insert([
            'name' => 'Tsanyawa',
            'state_id' => '19'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Tudun wada',
            'state_id' => '19'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Ungogo',
            'state_id' => '19'
        ]);

          DB::table('lgas')->insert([
            'name' => 'Warawa',
            'state_id' => '19'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Wudil',
            'state_id' => '19'
        ]);

        // Katsina
        DB::table('lgas')->insert([
            'name' => 'Bakori',
            'state_id' => '20'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Batagarawa',
            'state_id' => '20'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Batsari',
            'state_id' => '20'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Baure',
            'state_id' => '20'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Bindawa',
            'state_id' => '20'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Charanchi',
            'state_id' => '20'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Dandume',
            'state_id' => '20'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Danja',
            'state_id' => '20'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Dan Musa',
            'state_id' => '20'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Daura',
            'state_id' => '20'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Dutsi',
            'state_id' => '20'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Dutsin-Ma',
            'state_id' => '20'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Faskari',
            'state_id' => '20'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Funtua',
            'state_id' => '20'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Ingawa',
            'state_id' => '20'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Jibia',
            'state_id' => '20'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Kafur',
            'state_id' => '20'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Kaita',
            'state_id' => '20'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Kankara',
            'state_id' => '20'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Kankia',
            'state_id' => '20'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Katsina',
            'state_id' => '20'
        ]);

		DB::table('lgas')->insert([
            'name' => 'Kurfi',
            'state_id' => '20'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Kusada',
            'state_id' => '20'
        ]);

		DB::table('lgas')->insert([
            'name' => 'Mai Adua',
            'state_id' => '20'
        ]);

		DB::table('lgas')->insert([
            'name' => 'Malumfashi',
            'state_id' => '20'
        ]);

		DB::table('lgas')->insert([
            'name' => 'Mani',
            'state_id' => '20'
        ]);

		DB::table('lgas')->insert([
            'name' => 'Mashi',
            'state_id' => '20'
        ]);

		DB::table('lgas')->insert([
            'name' => 'Matazuu',
            'state_id' => '20'
        ]);
		DB::table('lgas')->insert([
            'name' => 'Musawa',
            'state_id' => '20'
        ]);
		DB::table('lgas')->insert([
            'name' => 'Rimi',
            'state_id' => '20'
        ]);
		DB::table('lgas')->insert([
            'name' => 'Sabuwa',
            'state_id' => '20'
        ]);
		DB::table('lgas')->insert([
            'name' => 'Safana',
            'state_id' => '20'
        ]);
		DB::table('lgas')->insert([
            'name' => 'Sandamu',
            'state_id' => '20'
        ]);
		DB::table('lgas')->insert([
            'name' => 'Zango',
            'state_id' => '20'
        ]);

        // Kebbi
        DB::table('lgas')->insert([
            'name' => 'Aleiro',
            'state_id' => '21'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Arewa-Dandi',
            'state_id' => '21'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Argungu',
            'state_id' => '21'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Augie',
            'state_id' => '21'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Bagudo',
            'state_id' => '21'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Birnin Kebbi',
            'state_id' => '21'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Bunza',
            'state_id' => '21'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Dandi',
            'state_id' => '21'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Fakai',
            'state_id' => '21'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Gwandu',
            'state_id' => '21'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Jega',
            'state_id' => '21'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Kalgo',
            'state_id' => '21'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Koko/Besse',
            'state_id' => '21'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Maiyama',
            'state_id' => '21'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Ngaski',
            'state_id' => '21'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Sakaba',
            'state_id' => '21'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Shanga',
            'state_id' => '21'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Suru',
            'state_id' => '21'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Wasagu/Danko',
            'state_id' => '21'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Yauri',
            'state_id' => '21'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Zuru',
            'state_id' => '21'
        ]);

        // Kogi
        DB::table('lgas')->insert([
            'name' => 'Adavi',
            'state_id' => '22'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Ajaokuta',
            'state_id' => '22'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Ankpa',
            'state_id' => '22'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Bassa',
            'state_id' => '22'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Dekina',
            'state_id' => '22'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Ibaji',
            'state_id' => '22'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Idah',
            'state_id' => '22'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Igalamela-Odolu',
            'state_id' => '22'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Ijumu',
            'state_id' => '22'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Kabba/Bunu',
            'state_id' => '22'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Kogi',
            'state_id' => '22'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Lokoja',
            'state_id' => '22'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Mopa-Muro',
            'state_id' => '22'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Ofu',
            'state_id' => '22'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Ogori/Mangongo',
            'state_id' => '22'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Okehi',
            'state_id' => '22'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Okene',
            'state_id' => '22'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Olamabolo',
            'state_id' => '22'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Omala',
            'state_id' => '22'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Yagba East',
            'state_id' => '22'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Yagba West',
            'state_id' => '22'
        ]);

        // Kwara
        DB::table('lgas')->insert([
            'name' => 'Asa',
            'state_id' => '23'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Baruten',
            'state_id' => '23'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Edu',
            'state_id' => '23'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Ekiti',
            'state_id' => '23'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Ifelodun',
            'state_id' => '23'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Ilorin East',
            'state_id' => '23'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Ilorin West',
            'state_id' => '23'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Irepodun',
            'state_id' => '23'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Isin',
            'state_id' => '23'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Kaiama',
            'state_id' => '23'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Moro',
            'state_id' => '23'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Offa',
            'state_id' => '23'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Oke-Ero',
            'state_id' => '23'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Oyun',
            'state_id' => '23'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Pategi',
            'state_id' => '23'
        ]);

        // Lagos
        DB::table('lgas')->insert([
            'name' => 'Agege',
            'state_id' => '24'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Ajeromi-Ifelodun',
            'state_id' => '24'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Alimosho',
            'state_id' => '24'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Amuwo-Odofin',
            'state_id' => '24'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Apapa',
            'state_id' => '24'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Badagry',
            'state_id' => '24'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Epe',
            'state_id' => '24'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Eti-Osa',
            'state_id' => '24'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Ibeju/Lekki',
            'state_id' => '24'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Ifako-Ijaye',
            'state_id' => '24'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Ikeja',
            'state_id' => '24'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Ikorodu',
            'state_id' => '24'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Kosofe',
            'state_id' => '24'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Lagos Island',
            'state_id' => '24'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Lagos Mainland',
            'state_id' => '24'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Mushin',
            'state_id' => '24'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Ojo',
            'state_id' => '24'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Oshodi-Isolo',
            'state_id' => '24'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Shomolu',
            'state_id' => '24'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Surulere',
            'state_id' => '24'
        ]);

        // Nasarawa
        DB::table('lgas')->insert([
            'name' => 'Akwanga',
            'state_id' => '25'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Awe',
            'state_id' => '25'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Doma',
            'state_id' => '25'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Karu',
            'state_id' => '25'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Keana',
            'state_id' => '25'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Keffi',
            'state_id' => '25'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Kokona',
            'state_id' => '25'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Lafia',
            'state_id' => '25'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Nasarawa',
            'state_id' => '25'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Nasarawa-Eggon',
            'state_id' => '25'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Obi',
            'state_id' => '25'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Toto',
            'state_id' => '25'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Wamba',
            'state_id' => '25'
        ]);

        // Niger
        DB::table('lgas')->insert([
            'name' => 'Agaie',
            'state_id' => '26'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Agwara ',
            'state_id' => '26'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Bida',
            'state_id' => '26'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Borgu',
            'state_id' => '26'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Bosso',
            'state_id' => '26'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Chanchaga',
            'state_id' => '26'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Edati',
            'state_id' => '26'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Gbako',
            'state_id' => '26'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Gurara ',
            'state_id' => '26'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Katcha',
            'state_id' => '26'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Kontagora',
            'state_id' => '26'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Lapai',
            'state_id' => '26'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Lavun',
            'state_id' => '26'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Magama',
            'state_id' => '26'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Mariga',
            'state_id' => '26'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Mashegu',
            'state_id' => '26'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Mokwa',
            'state_id' => '26'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Muya',
            'state_id' => '26'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Pailoro',
            'state_id' => '26'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Rafi',
            'state_id' => '26'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Rijau ',
            'state_id' => '26'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Shiroro',
            'state_id' => '26'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Suleja ',
            'state_id' => '26'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Tafa',
            'state_id' => '26'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Wushishi',
            'state_id' => '26'
        ]);

        //Ogun
        DB::table('lgas')->insert([
            'name' => 'Abeokuta North',
            'state_id' => '27'
        ]);

		DB::table('lgas')->insert([
            'name' => 'Abeokuta South',
            'state_id' => '27'
        ]);

		DB::table('lgas')->insert([
            'name' => 'Ado-Odo/Ota',
            'state_id' => '27'
        ]);

		DB::table('lgas')->insert([
            'name' => 'Egbado North',
            'state_id' => '27'
        ]);

		DB::table('lgas')->insert([
            'name' => 'Egbado South',
            'state_id' => '27'
        ]);

		DB::table('lgas')->insert([
            'name' => 'Ewekoro',
            'state_id' => '27'
        ]);

		DB::table('lgas')->insert([
            'name' => 'Ifo',
            'state_id' => '27'
        ]);

		DB::table('lgas')->insert([
            'name' => 'Ijebu East',
            'state_id' => '27'
        ]);

		DB::table('lgas')->insert([
            'name' => 'Ijebu North',
            'state_id' => '27'
        ]);

		DB::table('lgas')->insert([
            'name' => 'Ijebu North East',
            'state_id' => '27'
        ]);

		DB::table('lgas')->insert([
            'name' => 'Ijebu Ode',
            'state_id' => '27'
        ]);

		DB::table('lgas')->insert([
            'name' => 'Ikenne',
            'state_id' => '27'
        ]);

		DB::table('lgas')->insert([
            'name' => 'Imeko-Afon',
            'state_id' => '27'
        ]);

		DB::table('lgas')->insert([
            'name' => 'Ipokia',
            'state_id' => '27'
        ]);

		DB::table('lgas')->insert([
            'name' => 'Obafemi-Owode',
            'state_id' => '27'
        ]);

		DB::table('lgas')->insert([
            'name' => 'Ogun Watrside',
            'state_id' => '27'
        ]);

		DB::table('lgas')->insert([
            'name' => 'Odeda',
            'state_id' => '27'
        ]);

		DB::table('lgas')->insert([
            'name' => 'Odogbolu',
            'state_id' => '27'
        ]);

		DB::table('lgas')->insert([
            'name' => 'Remo North',
            'state_id' => '27'
        ]);

		DB::table('lgas')->insert([
            'name' => 'Shagamu',
            'state_id' => '27'
        ]);


        // Ondo
        DB::table('lgas')->insert([
            'name' => 'Akoko North East',
            'state_id' => '28'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Akoko North West ',
            'state_id' => '28'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Akoko South Akure East',
            'state_id' => '28'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Akoko South West',
            'state_id' => '28'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Akure North ',
            'state_id' => '28'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Akure South',
            'state_id' => '28'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Ese-Odo ',
            'state_id' => '28'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Idanre',
            'state_id' => '28'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Ifedore ',
            'state_id' => '28'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Ilaje ',
            'state_id' => '28'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Ile-Oluji ',
            'state_id' => '28'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Okeigbo ',
            'state_id' => '28'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Irele ',
            'state_id' => '28'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Odigbo ',
            'state_id' => '28'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Okitipupa ',
            'state_id' => '28'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Ondo East  ',
            'state_id' => '28'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Ondo West',
            'state_id' => '28'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Ose',
            'state_id' => '28'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Owo',
            'state_id' => '28'
        ]);

        //osun
        DB::table('lgas')->insert([
            'name' => 'Aiyedade',
            'state_id' => '29'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Aiyedire',
            'state_id' => '29'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Atakumosa East',
            'state_id' => '29'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Atakumosa West',
            'state_id' => '29'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Boluwaduro',
            'state_id' => '29'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Boripe',
            'state_id' => '29'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Ede North',
            'state_id' => '29'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Ede South',
            'state_id' => '29'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Egbedore',
            'state_id' => '29'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Ejigbo',
            'state_id' => '29'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Ife Central',
            'state_id' => '29'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Ife East',
            'state_id' => '29'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Ife North',
            'state_id' => '29'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Ife South',
            'state_id' => '29'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Ifedayo',
            'state_id' => '29'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Ifelodun',
            'state_id' => '29'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Ila',
            'state_id' => '29'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Ilesha East',
            'state_id' => '29'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Ilesha West',
            'state_id' => '29'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Irepodun',
            'state_id' => '29'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Irewole',
            'state_id' => '29'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Isokan',
            'state_id' => '29'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Iwo',
            'state_id' => '29'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Obokun',
            'state_id' => '29'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Odo-Otin',
            'state_id' => '29'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Ola-Oluwa',
            'state_id' => '29'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Olorunda',
            'state_id' => '29'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Oriade',
            'state_id' => '29'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Oriade',
            'state_id' => '29'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Oriade',
            'state_id' => '29'
        ]);

        //Oyo
        DB::table('lgas')->insert([
            'name' => 'Afijio',
            'state_id' => '30'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Akinyele',
            'state_id' => '30'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Atiba',
            'state_id' => '30'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Atigbo',
            'state_id' => '30'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Egbeda',
            'state_id' => '30'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Ibadan Central',
            'state_id' => '30'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Ibadan North',
            'state_id' => '30'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Ibadan North West',
            'state_id' => '30'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Ibadan South East',
            'state_id' => '30'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Ibadan South West',
            'state_id' => '30'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Ibarapa Central ',
            'state_id' => '30'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Ibarapa East',
            'state_id' => '30'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Ibarapa North',
            'state_id' => '30'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Ido',
            'state_id' => '30'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Irepo',
            'state_id' => '30'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Iseyin',
            'state_id' => '30'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Itesiwaju',
            'state_id' => '30'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Iwajowa',
            'state_id' => '30'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Kajola',
            'state_id' => '30'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Lagelu Ogbomosho North',
            'state_id' => '30'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Ogbmosho South',
            'state_id' => '30'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Ogo Oluwa',
            'state_id' => '30'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Olorunsogo',
            'state_id' => '30'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Oluyole',
            'state_id' => '30'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Ona-Ara',
            'state_id' => '30'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Orelope',
            'state_id' => '30'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Ori Ire',
            'state_id' => '30'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Oyo East',
            'state_id' => '30'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Oyo West',
            'state_id' => '30'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Saki East',
            'state_id' => '30'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Saki West',
            'state_id' => '30'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Surulere',
            'state_id' => '30'
        ]);

        //Plateau
         DB::table('lgas')->insert([
            'name' => 'Barikin Ladi',
            'state_id' => '31'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Bassa',
            'state_id' => '31'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Bokkos',
            'state_id' => '31'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Jos East',
            'state_id' => '2'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Jos North',
            'state_id' => '31'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Jos South',
            'state_id' => '31'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Kanam',
            'state_id' => '31'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Kanke',
            'state_id' => '31'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Langtang North',
            'state_id' => '31'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Langtang South',
            'state_id' => '31'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Mangu',
            'state_id' => '31'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Mikang',
            'state_id' => '31'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Pankshin',
            'state_id' => '31'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Qua an Pan',
            'state_id' => '31'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Riyom',
            'state_id' => '31'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Shendam',
            'state_id' => '31'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Wase',
            'state_id' => '31'
        ]);

        // Rivers
        DB::table('lgas')->insert([
            'name' => 'Abua/Odual',
            'state_id' => '32'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Ahoada East',
            'state_id' => '32'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Ahoada West',
            'state_id' => '32'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Akuku Toru',
            'state_id' => '32'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Adoni',
            'state_id' => '32'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Bonny',
            'state_id' => '32'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Degema',
            'state_id' => '32'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Emohua',
            'state_id' => '32'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Eleme',
            'state_id' => '32'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Etche',
            'state_id' => '32'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Gokana',
            'state_id' => '32'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Ikwerre',
            'state_id' => '32'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Khana',
            'state_id' => '32'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Mubi South',
            'state_id' => '32'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Obia/Akpor',
            'state_id' => '32'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Ogba/Egbema/Ndoni',
            'state_id' => '32'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Ogu/Bolo',
            'state_id' => '32'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Okrika',
            'state_id' => '32'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Omumma',
            'state_id' => '32'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Opobo/Nkoro',
            'state_id' => '32'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Oyigbo',
            'state_id' => '32'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Port-Harcourt',
            'state_id' => '32'
        ]);
          DB::table('lgas')->insert([
            'name' => 'Tai',
            'state_id' => '32'
        ]);

        // Sokoto
        DB::table('lgas')->insert([
            'name' => 'Binji',
            'state_id' => '33'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Bodinga',
            'state_id' => '33'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Dange-shnsi',
            'state_id' => '33'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Gada',
            'state_id' => '33'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Goronyo',
            'state_id' => '33'
        ]);

		DB::table('lgas')->insert([
            'name' => 'Gudu',
            'state_id' => '33'
        ]);

		DB::table('lgas')->insert([
            'name' => 'Gawabawa',
            'state_id' => '33'
        ]);

		DB::table('lgas')->insert([
            'name' => 'Illela',
            'state_id' => '33'
        ]);

		DB::table('lgas')->insert([
            'name' => 'Isa',
            'state_id' => '33'
        ]);

		DB::table('lgas')->insert([
            'name' => 'Kware',
            'state_id' => '33'
        ]);

		DB::table('lgas')->insert([
            'name' => 'Kebba',
            'state_id' => '33'
        ]);

		DB::table('lgas')->insert([
            'name' => 'Rabah',
            'state_id' => '33'
        ]);

		DB::table('lgas')->insert([
            'name' => 'Sabon birni',
            'state_id' => '33'
        ]);

		DB::table('lgas')->insert([
            'name' => 'Shagari',
            'state_id' => '33'
        ]);

		DB::table('lgas')->insert([
            'name' => 'Silame',
            'state_id' => '33'
        ]);

		DB::table('lgas')->insert([
            'name' => 'Sokoto North',
            'state_id' => '33'
        ]);

		DB::table('lgas')->insert([
            'name' => 'Sokoto South',
            'state_id' => '33'
        ]);

		DB::table('lgas')->insert([
            'name' => 'Tambuwal',
            'state_id' => '33'
        ]);

		DB::table('lgas')->insert([
            'name' => 'Tqngaza',
            'state_id' => '33'
        ]);

		DB::table('lgas')->insert([
            'name' => 'Tureta',
            'state_id' => '33'
        ]);

		DB::table('lgas')->insert([
            'name' => 'Wamako',
            'state_id' => '33'
        ]);

		DB::table('lgas')->insert([
            'name' => 'Wurno',
            'state_id' => '33'
        ]);

		DB::table('lgas')->insert([
            'name' => 'Yabo',
            'state_id' => '33'
        ]);

        // Taraba
        DB::table('lgas')->insert([
            'name' => 'Ardo-kola',
            'state_id' => '34'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Bali',
            'state_id' => '34'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Donga',
            'state_id' => '34'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Gashaka',
            'state_id' => '34'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Cassol',
            'state_id' => '34'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Ibi',
            'state_id' => '34'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Jalingo',
            'state_id' => '34'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Karin-Lamido',
            'state_id' => '34'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Kurmi',
            'state_id' => '34'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Lau',
            'state_id' => '34'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Sardauna',
            'state_id' => '34'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Takum',
            'state_id' => '34'
        ]);

        DB::table('lgas')->insert([
            'name' => 'ussa',
            'state_id' => '34'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Wukari',
            'state_id' => '34'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Yorro',
            'state_id' => '34'
        ]);

        DB::table('lgas')->insert([
            'name' => 'zing',
            'state_id' => '34'
        ]);

        // Yobe
        DB::table('lgas')->insert([
            'name' => 'Bade',
            'state_id' => '35'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Bursari',
            'state_id' => '35'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Damaturu',
            'state_id' => '35'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Fika',
            'state_id' => '35'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Fune',
            'state_id' => '35'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Geidam',
            'state_id' => '35'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Gujba',
            'state_id' => '35'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Gulani',
            'state_id' => '35'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Jakusko',
            'state_id' => '35'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Karasuwa',
            'state_id' => '35'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Karawa',
            'state_id' => '35'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Machina',
            'state_id' => '35'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Nangere',
            'state_id' => '35'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Nguru Potiskum',
            'state_id' => '35'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Tarmua',
            'state_id' => '35'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Yunusari ',
            'state_id' => '35'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Yusufari',
            'state_id' => '35'
        ]);

        //Zamfara
        DB::table('lgas')->insert([
            'name' => 'Anka',
            'state_id' => '36'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Bakura',
            'state_id' => '36'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Birnin Magaji',
            'state_id' => '36'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Bukkuyum',
            'state_id' => '36'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Bungudu',
            'state_id' => '36'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Gummi',
            'state_id' => '36'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Gusau',
            'state_id' => '36'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Kaura',
            'state_id' => '36'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Namoda',
            'state_id' => '36'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Maradun',
            'state_id' => '36'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Maru',
            'state_id' => '36'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Shinkafi',
            'state_id' => '36'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Talata Mafara',
            'state_id' => '36'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Tsafe',
            'state_id' => '36'
        ]);

        DB::table('lgas')->insert([
            'name' => 'Zurmi',
            'state_id' => '36'
        ]);

        //FCT
        DB::table('lgas')->insert([
            'name' => 'Gwagwalada ',
            'state_id' => '37'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Kuje',
            'state_id' => '37'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Abaji',
            'state_id' => '37'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Abuja Municipal',
            'state_id' => '37'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Bwari',
            'state_id' => '37'
        ]);

         DB::table('lgas')->insert([
            'name' => 'Kwali',
            'state_id' => '37'
        ]);
    }
}
