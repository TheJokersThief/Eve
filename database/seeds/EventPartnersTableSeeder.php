<?php

use Illuminate\Database\Seeder;

class EventPartnersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('event_partners')->insert([
         	'event_id' => 1,
            'partner_id' => 3,
        ]);

        DB::table('event_partners')->insert([
         	'event_id' => 1,
            'partner_id' => 4,
        ]);

        DB::table('event_partners')->insert([
         	'event_id' => 2,
            'partner_id' => 5,
        ]);
    }
}
