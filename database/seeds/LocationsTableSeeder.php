<?php

use Illuminate\Database\Seeder;
use App\Location;

class LocationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Location::firstOrCreate([
         	'name' => "The 3 Arena",
            'coordinates' => '12122132121789',
            'capacity' => 30000,
        ]);

        Location::firstOrCreate([
         	'name' => "Lansdowne Road",
            'coordinates' => '343449',
            'capacity' => 400000,
        ]);

        Location::firstOrCreate([
         	'name' => "Musgrave Park",
            'coordinates' => '3400000',
            'capacity' => 12000,
        ]);
    }
}
