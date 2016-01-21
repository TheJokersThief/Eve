<?php

use Illuminate\Database\Seeder;
use App\Setting;

class SettingsSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run(){

		Setting::firstOrCreate(['name' => 'is_installed', 'setting' => 'no']);
		Setting::firstOrCreate(['name' => 'default_profile_picture', 'setting' => '/images/default_profile_image.png' ] );
	}
}
