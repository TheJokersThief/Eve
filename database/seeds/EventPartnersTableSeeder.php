<?php

use Illuminate\Database\Seeder;

use App\Event;
use App\Partner;
use App\Http\Controllers\LocationController;

class EventPartnersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i=1; $i <= 3; $i++) {
        	$partner = Partner::find( $i );
        	$event = Event::find(1);
            $distance = LocationController::getMapsMatrixDistance($event->location, $partner->location);
        	$event->partners()->save($partner, ['distance'=>$distance]);
        }
    }
}
