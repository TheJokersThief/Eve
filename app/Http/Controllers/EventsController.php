<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Event;

class EventsController extends Controller
{
    public function index(){
        $events = Event::orderBy('start_datetime', 'ASC')->get();
    	return view('events.index', ['events' => $events]);
    }

    public function show($id){
        $event = Event::findOrFail($id);
        return view('events.show', compact('event'));
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
