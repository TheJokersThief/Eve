<?php

use Illuminate\Database\Seeder;
use App\Location;


class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){
    	Location::firstOrCreate([
    		'name' => "1 Yellow Brick Road, Cork City, Cork",
    		'latitude' => 51.898202,
            'longitude' => -8.479321,
    		'capacity' => "200",
    		'featured_image' => '/images/sample_images/venues/1.jpg'
    	]);
    	Location::firstOrCreate([
    		'name' => "2 Yellow Brick Road, Cork City, Cork",
    		'latitude' => 51.898202,
            'longitude' => -8.479321,
    		'capacity' => "200",
    		'featured_image' => '/images/sample_images/venues/1.jpg'
    	]);
    	Location::firstOrCreate([
    		'name' => "3 Yellow Brick Road, Cork City, Cork",
    		'latitude' => 51.898202,
            'longitude' => -8.479321,
    		'capacity' => "200",
    		'featured_image' => '/images/sample_images/venues/1.jpg'
    	]);
    	Location::firstOrCreate([
    		'name' => "4 Yellow Brick Road, Cork City, Cork",
    		'latitude' => 51.898202,
            'longitude' => -8.479321,
    		'capacity' => "200",
    		'featured_image' => '/images/sample_images/venues/1.jpg'
    	]);
    	Location::firstOrCreate([
    		'name' => "5 Yellow Brick Road, Cork City, Cork",
    		'latitude' => 51.898202,
            'longitude' => -8.479321,
    		'capacity' => "200",
    		'featured_image' => '/images/sample_images/venues/1.jpg'
    	]);
    }
}
