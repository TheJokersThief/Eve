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
    		'coordinates' => "1,1",
    		'capacity' => "200",
    		'featured_image' => '/images/sample_images/venues/1.jpg'
    	]);
    	Location::firstOrCreate([
    		'name' => "2 Yellow Brick Road, Cork City, Cork",
    		'coordinates' => "2,1",
    		'capacity' => "200",
    		'featured_image' => '/images/sample_images/venues/1.jpg'
    	]);
    	Location::firstOrCreate([
    		'name' => "3 Yellow Brick Road, Cork City, Cork",
    		'coordinates' => "3,1",
    		'capacity' => "200",
    		'featured_image' => '/images/sample_images/venues/1.jpg'
    	]);
    	Location::firstOrCreate([
    		'name' => "4 Yellow Brick Road, Cork City, Cork",
    		'coordinates' => "4,1",
    		'capacity' => "200",
    		'featured_image' => '/images/sample_images/venues/1.jpg'
    	]);
    	Location::firstOrCreate([
    		'name' => "5 Yellow Brick Road, Cork City, Cork",
    		'coordinates' => "5,1",
    		'capacity' => "200",
    		'featured_image' => '/images/sample_images/venues/1.jpg'
    	]);
    }
}
