<?php

use Illuminate\Database\Seeder;

use App\User;
use App\Ticket;

class TicketSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Add Admin ticket
    	Ticket::firstOrCreate(['user_id' => '1', 'event_id' => '1']);

		// Add staff user ticket
		Ticket::firstOrCreate(['user_id' => '3', 'event_id' => '1']);

		// Add normal user ticket
		Ticket::firstOrCreate(['user_id' => '5', 'event_id' => '1']);
    }
}
