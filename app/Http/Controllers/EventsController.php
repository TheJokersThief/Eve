<?php

namespace App\Http\Controllers;

// use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Event;
use App\Location;
use Redirect;
use Illuminate\Support\Facades\Request;
use Validator;


class EventsController extends Controller
{
    public function index(){
        $events = Event::orderBy('start_datetime', 'ASC')->get();
    	return view('events.index', ['events' => $events]);
    }

    public function show($id){
        $event = Event::findOrFail($id);
        $location = $event->location;
        $location_name = $location->name;
        $partners = $event->partners;
        $locationName = Location::findOrFail($event->id);
        return view('events.show', compact('event', 'location_name', 'partners'));
    }

    public function create(){
    	return view('events.create', ['locations' => Location::all()]);
    }

    public function store(){

        $data = Request::only( [
                    'title',
                    'description',
                    'start_date',
                    'end_date',
                    'start_time',
                    'end_time',
                    'location_id'
                ]);

        // Validate all input
        $validator = Validator::make( $data, [
                    'title'  => 'required',
                    'description'  => 'required',
                    'start_date'  => 'required',
                    'end_date'  => 'required',
                    'start_time'  => 'required',
                    'end_time' => 'required',
                    'location_id'  => 'required',
                ]);

        if( $validator->fails( ) ){
            // If validation fails, redirect back to 
            // registration form with errors
            return Redirect::to( 'events' )
                    ->withErrors( $validator )
                    ->withInput( );
        }

        $start_datetime = $data['start_date'] . ' ' . $data['start_time'] . ':' . '00';
        $end_datetime = $data['end_date'] . ' ' . $data['end_time'] . ':' . '00';

        $newData = array(
                "title" => $data["title"],
                "description" => $data["description"],
                "start_datetime" => $start_datetime,
                "end_datetime" => $end_datetime,
                "location_id" => $data["location_id"]
            );
        
        // Create the new event
        $newEvent = Event::create( $newData );

        return Redirect::to( 'events' );
        
        // If unsuccessful, return with errors
        return Redirect::back( )
                    ->withErrors( [
                        'message' => 'We\'re sorry but event creation failed, please try again later.' 
                    ] )
                    ->withInput( );
    }

    public function edit(){
    	return view('events.edit');
    }

    public function update(){
    	return view('events.update');
    }
}
