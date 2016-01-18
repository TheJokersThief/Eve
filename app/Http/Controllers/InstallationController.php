<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;

class InstallationController extends Controller
{

    public function index()
    {
        return view('install.index');
    }
}
