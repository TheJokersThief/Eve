<?php

use Illuminate\Database\Seeder;

class EventsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('events')->insert([
            'description' => 'Our very first event. Everyone is welcome to come along. Except Eimear. Eimear smells.',
            'location_id' => 1,
            'start_datetime' => '2016:01:01 09:00:00',
            'end_datetime' => '2016:01:03 22:00:00',
            'title' => 'Event Number 1',
        ]);

        DB::table('events')->insert([
            'description' => 'Our second event. Be sure to bring your friends.',
            'location_id' => 5,
            'start_datetime' => '2016:02:21 09:30:00',
            'end_datetime' => '2016:02:25 15:45:00',
            'title' => 'Event the Second',
        ]);

        DB::table('events')->insert([
            'description' => 'Our third and final event. Please arrive on time.',
            'location_id' => 2,
            'start_datetime' => '2016:03:20 12:35:14',
            'end_datetime' => '2016:03:21 15:45:00',
            'title' => 'The Final Event',
        ]);
    }
}
