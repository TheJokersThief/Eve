<?php

use Illuminate\Database\Seeder;
use App\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

    	$defaultProfileImage = "/images/default_profile_image.png";

	    //////////////////////
    	// FOUR STAFF USERS //
	    //////////////////////
        User::firstOrCreate([
        	'name' 				=> "Douglas Adams",
        	'email' 			=> "doug@hitchhikersguide.galaxy",
        	'password' 			=> Hash::make('TheAnswerIs42'),
        	'is_admin' 			=> 0,
        	'is_staff' 			=> 1,
        	'profile_picture' 	=> $defaultProfileImage,
        	'bio' 				=> 'I wrote a book',
        	'language' 			=> 'EN'
        ]);

        User::firstOrCreate([
        	'name' 				=> "William E. Henley",
        	'email' 			=> "willy@invictus.net",
        	'password' 			=> Hash::make('unconquerable'),
        	'is_admin' 			=> 0,
        	'is_staff' 			=> 1,
        	'profile_picture' 	=> $defaultProfileImage,
        	'bio' 				=> "I wrote a poem",
        	'language' 			=> "EN"
        ]);

        User::firstOrCreate([
        	'name' 				=> "Kanye West",
        	'email' 			=> "kanye@thecentreofthe.world",
        	'password' 			=> Hash::make('IAmGod'),
        	'is_admin' 			=> 0,
        	'is_staff' 			=> 1,
        	'profile_picture' 	=> $defaultProfileImage,
        	'bio' 				=> "I wrote a song",
        	'language' 			=> "EN"
        ]);

        User::firstOrCreate([
        	'name' 				=> "Jaden Smith",
        	'email' 			=> "whatIs@an.email",
        	'password' 			=> Hash::make('hashtagyeezys'),
        	'is_admin' 			=> 0,
        	'is_staff' 			=> 1,
        	'profile_picture' 	=> $defaultProfileImage,
        	'bio' 				=> "Wassup With Oregon Right Now?",
        	'language' 			=> "EN"
        ]);
    }
}
