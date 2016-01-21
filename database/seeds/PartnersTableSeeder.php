<?php

use Illuminate\Database\Seeder;

class PartnersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('partners')->insert([
         	'name' => "McDonald's",
            'type' => 'Food',
            'price' => 5.99,
            'description' => 'A lovely restaurant for family meals.',
            'location_id' => 2,
            'distance' => 20.5,
            'email' => 'mcd@gmail.com',   
        ]);

        DB::table('partners')->insert([
         	'name' => "Bewley's",
            'type' => 'Hotel',
            'price' => 64.99,
            'description' => 'A fancy-schmancy hotel',
            'location_id' => 2,
            'distance' => 5.65,
            'email' => 'mr.bewley@gmail.com',   
        ]);

        DB::table('partners')->insert([
         	'name' => "Ramen",
            'type' => 'Food',
            'price' => 6.00,
            'description' => 'Asian street food',
            'location_id' => 4,
            'distance' => 89,
            'email' => 'ramen@gmail.com',   
        ]);
    }
}
