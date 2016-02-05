<?php

namespace App\Http\Controllers;


use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use Redirect;
use App\Setting;
use App\Event;

class HomeController extends Controller
{

	/**
	 * Show the application dashboard.
	 *
	 * @return Response
	 */
	public function index()
	{
		try {
			$isInstalled = Setting::where('name', 'is_installed')->firstOrFail();
		} catch (ModelNotFoundException $e) {
			$isInstalled = Setting::create(['name' => 'is_installed', 'setting' => 'no']);
		}

		if( $isInstalled->setting != 'yes' ){
			return Redirect::route('install');
		}

		$event = Event::first();
		return view('home')->with('event', $event);
	}
}
