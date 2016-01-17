<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;

use Redirect;
use App\Setting;

class HomeController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return Response
     */
    public function index()
    {
        if( Setting::where('name', 'is_installed')->first()->setting != 'yes' ){
            return Redirect::route('install');
        }
        return view('home');
    }
}
