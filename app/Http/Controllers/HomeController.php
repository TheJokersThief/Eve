<?php

namespace App\Http\Controllers;


use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use Redirect;
use App\Setting;
use App\Event;
use App\News;
use App\Media;

class HomeController extends Controller
{

	/**
	 * Show the application dashboard.
	 *
	 * @return Response
	 */
	public function index()
	{
		dd( getTranslationLocales( ) );
		try {
			$isInstalled = Setting::where('name', 'is_installed')->firstOrFail();
		} catch (ModelNotFoundException $e) {
			$isInstalled = Setting::create(['name' => 'is_installed', 'setting' => 'no']);
		}

		if( $isInstalled->setting != 'yes' ){
			return Redirect::route('install');
		}

		$data = [
			"event" => Event::first(),
			"upcomingEvents" => Event::take(3)->get(),
			"news" => News::take(6)->get(),
			"media" => Media::where('processed', true)->orderBy('id', 'DESC')->take(12)->get()
		];

		return view('home')->with($data);
	}
}
