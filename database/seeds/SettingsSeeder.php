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
		Setting::firstOrCreate(['name' => 'company_name', 'setting' => 'Project Eve' ] );
		Setting::firstOrCreate(['name' => 'description', 'setting' => 'We are an awesome company' ] );
		Setting::firstOrCreate(['name' => 'company_logo', 'setting' => '/images/default_profile_image.png' ] );
		Setting::firstOrCreate(['name' => 'company_logo_white', 'setting' => '/images/default_profile_image.png' ] );
	}
}
