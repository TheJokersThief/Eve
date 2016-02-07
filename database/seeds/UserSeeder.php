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

	    //////////////////////////
    	// MAIN ADMIN TEST USER //
	    //////////////////////////
    	User::firstOrCreate([
    		'id'				=> 1,
        	'name' 				=> "DEECM",
        	'email' 			=> "auditor@netsoc.co",
        	'password' 			=> Hash::make('password'),
        	'is_admin' 			=> 1,
        	'is_staff' 			=> 1,
        	'profile_picture' 	=> '/images/sample_images/event_photos/11.jpg',
        	'bio' 				=> 'Lorem ipsum Nostrud ea laboris sunt dolor velit id Ut id qui qui officia consectetur Ut deserunt minim ut laborum proident sunt laborum in consectetur ullamco ullamco cupidatat do in exercitation occaecat non laboris nisi sint Duis officia aliqua dolor id.',
        	'language' 			=> 'EN',
            'country'           => 'Ireland',
            'city'              => 'Ballyvolane'
        ]);

	    //////////////////////
    	// FOUR STAFF USERS //
	    //////////////////////
        User::firstOrCreate([
        	'id'				=> 2,
        	'name' 				=> "Douglas Adams",
        	'email' 			=> "doug@hitchhikersguide.galaxy",
        	'password' 			=> Hash::make('TheAnswerIs42'),
        	'is_admin' 			=> 0,
        	'is_staff' 			=> 1,
        	'profile_picture' 	=> $defaultProfileImage,
        	'bio' 				=> 'I wrote a book',
        	'language' 			=> 'EN',
            'country'           => 'England',
            'city'              => 'Essex'
        ]);

        User::firstOrCreate([
        	'id'				=> 3,
        	'name' 				=> "William E. Henley",
        	'email' 			=> "willy@invictus.net",
        	'password' 			=> Hash::make('unconquerable'),
        	'is_admin' 			=> 0,
        	'is_staff' 			=> 1,
        	'profile_picture' 	=> $defaultProfileImage,
        	'bio' 				=> "I wrote a poem",
        	'language' 			=> "EN",
            'country'           => 'USA',
            'city'              => 'New York'

        ]);

        User::firstOrCreate([
        	'id'				=> 4,
        	'name' 				=> "Kanye West",
        	'email' 			=> "kanye@thecentreofthe.world",
        	'password' 			=> Hash::make('IAmGod'),
        	'is_admin' 			=> 0,
        	'is_staff' 			=> 1,
        	'profile_picture' 	=> $defaultProfileImage,
        	'bio' 				=> "I wrote a song",
        	'language' 			=> "EN",
            'country'           => 'USA',
            'city'              => 'New York'
        ]);

        User::firstOrCreate([
        	'id'				=> 5,
        	'name' 				=> "Jaden Smith",
        	'email' 			=> "whatIs@an.email",
        	'password' 			=> Hash::make('hashtagyeezys'),
        	'is_admin' 			=> 0,
        	'is_staff' 			=> 1,
        	'profile_picture' 	=> $defaultProfileImage,
        	'bio' 				=> "Wassup With Oregon Right Now?",
        	'language' 			=> "EN",
            'country'           => 'WonderLand',
            'city'              => 'Emerald City'
        ]);
    }
}
