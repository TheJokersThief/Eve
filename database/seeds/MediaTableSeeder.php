<?php

use Illuminate\Database\Seeder;
use App\Media;

class MediaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Media::firstOrCreate([
         	'file_location' => 'images/sample_images/hotels/1.jpg',
         	'event_id' => 1,
         	'description' => 'A photo description',
         	'name' => 'Photo 1',
         	'view_count' => 20,
         	'approved' => true,
        ]);

        Media::firstOrCreate([
         	'file_location' => 'images/sample_images/hotels/2.jpg',
         	'event_id' => 2,
         	'description' => 'A photo description',
         	'name' => 'Photo 2',
         	'view_count' => 5,
         	'approved' => true,
        ]);

        Media::firstOrCreate([
         	'file_location' => 'images/sample_images/hotels/3.jpg',
         	'event_id' => 3,
         	'description' => 'A photo description',
         	'name' => 'Photo 3',
         	'view_count' => 570,
         	'approved' => true,
        ]);
    }
}
