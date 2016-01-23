<?php

use Illuminate\Database\Seeder;

class LocationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('locations')->insert([
         	'name' => "The 3 Arena",
            'coordinates' => '12122132121789',
            'capacity' => 30000,
        ]);

        DB::table('locations')->insert([
         	'name' => "Lansdowne Road",
            'coordinates' => '343449',
            'capacity' => 400000,
        ]);

        DB::table('locations')->insert([
         	'name' => "Musgrave Park",
            'coordinates' => '3400000',
            'capacity' => 12000,
        ]);
    }
}
