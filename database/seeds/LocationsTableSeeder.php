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
            'latitude' => 53.347503,
            'longitude' => 6.228647,
            'capacity' => 30000,
        ]);

        Location::firstOrCreate([
         	'name' => "Lansdowne Road",
            'latitude' => 53.335105,
            'longitude' => 6.228423,
            'capacity' => 400000,
        ]);

        Location::firstOrCreate([
         	'name' => "Musgrave Park",
            'latitude' => 51.881045,
            'longitude' => 8.470948,
            'capacity' => 12000,
        ]);
    }
}
