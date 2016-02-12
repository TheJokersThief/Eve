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
         	'file_location' => '/images/sample_images/hotels/1.jpg',
         	'event_id' => 1,
         	'description' => 'A photo description',
         	'name' => 'Photo 1',
         	'view_count' => 20,
         	'approved' => false,
            'processed' => false,
            'user_id' => 5
        ]);

        Media::firstOrCreate([
         	'file_location' => '/images/sample_images/hotels/2.jpg',
         	'event_id' => 2,
         	'description' => 'A photo description',
         	'name' => 'Photo 2',
         	'view_count' => 5,
         	'approved' => false,
            'processed' => false,
            'user_id' => 5
        ]);

        Media::firstOrCreate([
         	'file_location' => '/images/sample_images/hotels/3.jpg',
         	'event_id' => 3,
         	'description' => 'A photo description',
         	'name' => 'Photo 3',
         	'view_count' => 570,
         	'approved' => false,
            'processed' => false,
            'user_id' => 5
        ]);

        ///////////////////////
        // UNPROCESSED MEDIA //
        ///////////////////////

        for ($i=1; $i <= 12; $i++) {
            Media::firstOrCreate([
                'file_location' => '/images/sample_images/event_photos/'.$i.'.jpg',
                'event_id' => 3,
                'description' => 'A photo description',
                'name' => 'Event Photo '.$i,
                'view_count' => 0,
                'approved' => true,
                'processed' => true,
                'user_id' => 5
            ]);
        }

        for ($i=1; $i <= 12; $i++) {
            Media::firstOrCreate([
                'file_location' => '/images/sample_images/event_photos/'.$i.'.jpg',
                'event_id' => 3,
                'description' => 'A photo description',
                'name' => 'Event Photo '.$i,
                'view_count' => 0,
                'approved' => false,
                'processed' => false,
                'user_id' => 5
            ]);
        }
    }
}
