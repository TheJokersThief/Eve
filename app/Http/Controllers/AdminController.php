<?php

namespace App\Http\Controllers;

use Validator;
use Redirect;
use Auth;
use Image;
use Hash;
use Response;
use View;
use App\User;
use App\Ticket;
use App\Setting;
use App\Event;
use App\Partner;

use App\Http\Controllers\MediaController;

use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class AdminController extends Controller
{
	/**
	 * Require authentication
	 */
	public function __construct(){
	    $this->middleware('auth');
	}

	public static function checkPrivilege( ){
		if( Auth::user()->is_admin ){
			return;
		} else{
			Redirect::back();
		}
	}

	public function index( ){

		$data = [];

		$data["events"] = Event::where('end_datetime', '>', date(time()) )->get()->take(5);

		$data["partners"] = Partner::all()->take(5);


		return View::make('admin.index')->with($data);
	}
}
