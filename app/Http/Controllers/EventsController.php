<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class EventsController extends Controller
{
    public function index(){
    	return view('events.index');
    }

    public function show(){
    	return view('events.show');
    }

    public function create(){
    	return view('events.create');
    }

    public function store(){
    	return view('events.store');
    }

    public function edit(){
    	return view('events.edit');
    }

    public function update(){
    	return view('events.update');
    }
}
