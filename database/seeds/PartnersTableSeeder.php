<?php

use Illuminate\Database\Seeder;
use App\Partner;

class PartnersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Partner::firstOrCreate([
         	'name' => "McDonald's",
            'featured_image' => 'images/sample_images/hotels/1.jpg',
            'type' => 'Food',
            'price' => 5.99,
            'description' => 'A lovely restaurant for family meals.',
            'location_id' => 2,
            'distance' => 20.5,
            'email' => 'mcd@gmail.com',
        ]);

        Partner::firstOrCreate([
         	'name' => "Bewley's",
            'featured_image' => 'images/sample_images/hotels/2.jpg',
            'type' => 'Hotel',
            'price' => 64.99,
            'description' => 'A fancy-schmancy hotel',
            'location_id' => 2,
            'distance' => 5.65,
            'email' => 'mr.bewley@gmail.com',
        ]);

        Partner::firstOrCreate([
         	'name' => "Ramen",
            'featured_image' => 'images/sample_images/hotels/3.jpg',
            'type' => 'Food',
            'price' => 6.00,
            'description' => 'Asian street food',
            'location_id' => 4,
            'distance' => 89,
            'email' => 'ramen@gmail.com',
        ]);

        Partner::firstOrCreate([
            'name' => "Rament",
            'featured_image' => 'images/sample_images/hotels/3.jpg',
            'type' => 'Food',
            'price' => 6.00,
            'description' => 'Asian street food better than Ramen',
            'location_id' => 4,
            'distance' => 89,
            'email' => 'rament@gmail.com',
        ]);
    }
}
