<?php

namespace App\Http\Controllers;

// use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Event;
use App\Ticket;
use App\Location;
use Auth;
use Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Validator;
// use Illuminate\Http\Request;


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

        if( Auth::check() ){
            try{
                $ticket = Ticket::where('user_id', Auth::user()->id)
                                ->where('event_id', $id)
                                ->firstOrFail();
            }catch (ModelNotFoundException $e){
                $ticket = false;
            }
        } else {
            $ticket = false;   
        }


        return view('events.show', compact('event', 'location_name', 'partners', 'ticket'));
    }

    public function create(){
    	return view('events.create', ['locations' => Location::all()]);
    }

    public function store(){
        if(! Auth::check() || ! Auth::user()->is_admin ){
            return Redirect::back( )->withErrors(
                [
                    'message' => 'You do not have permission to edit events.' 
                ] );
        }

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

    public function edit($id){
        if(! Auth::check() || ! Auth::user()->is_admin ){
            return Redirect::back( )->withErrors(
                [
                    'message' => 'You do not have permission to edit events.' 
                ] );
        }

        $event = Event::findOrFail($id);
        $locations = Location::all();
        $location = $event->location;
        $startDateTime = $event->start_datetime;
        $endDateTime = $event->end_datetime;
        $startDate = substr($startDateTime, 0, 10);
        $endDate = substr($endDateTime, 0, 10);
        $startTime = substr($startDateTime, 11, 5);
        $endTime = substr($endDateTime, 11, 5);
    	return view('events.edit', compact('event', 'locations', 'location', 'startDate',
             'endDate', 'startTime', 'endTime'));
    }

    public function update($id){
        if(! Auth::check() || ! Auth::user()->is_admin ){
            return Redirect::back( )->withErrors(
                [
                    'message' => 'You do not have permission to edit events.' 
                ] );
        }

    	$event = Event::findOrFail($id);

        $data = Request::only( [
                    'title',
                    'description',
                    'start_date',
                    'end_date',
                    'start_time',
                    'end_time',
                    'location_id'
                ]);

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

        $event->title = ($newData["title"]);
        $event->description = ($newData["description"]);
        $event->start_datetime = ($newData["start_datetime"]);
        $event->end_datetime = ($newData["end_datetime"]);
        $event->location_id = ($newData["location_id"]);

        $event->save();

        return redirect('events');
    }
}
