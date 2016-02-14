<?php

namespace App\Http\Controllers;

use Auth;
use View;
use App\Ticket;

use App\Http\Controllers\MediaController;

use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class StaffController extends Controller
{
	/**
	 * Require authentication
	 */
	public function __construct(){
		$this->middleware('auth');
		$this->middleware('staff');
	}

	public function index( ){
		$tickets = Ticket::where('scanned_by', Auth::user()->id)
						 ->where('printed', false)
						 ->get();

		return View::make('staff.index', compact('tickets'));
	}
}
