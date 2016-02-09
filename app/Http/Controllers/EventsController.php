<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Event;
use App\Ticket;
use App\Location;
use App\Partner;
use Auth;
use Redirect;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Validator;
use App\Http\Controllers\MediaController;
use Illuminate\Http\Request;
use DB;

class EventsController extends Controller
{
	// Show a view of all events
	public function index(){
		// Retrieve all events from the database
		// and order by earliest starting first
		$events = Event::orderBy('start_datetime', 'ASC')->get();
		//return the view of all events
		return view('events.index', ['events' => $events]);
	}

	// Show a single event
	public function show($id){
		// Find the event, or fail
		$event = Event::findOrFail($id);

		// Retrieve various attributes of the location
		$location = $event->location;
		$location_name = $location->name;
		$partners = $event->partners;

		// If the user is authorised, get the ticket
		// for the event
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

        $userIds = DB::table('tickets')
                     ->where('event_id', $event->id)
                     ->take(48)
                     ->pluck('user_id');

        $users = DB::table('users')
                   ->whereIn('id', $userIds)
                   ->get();

        // Return a view of the event
		return view('events.show', compact('event', 'location_name', 'partners', 'ticket', 'users'));
	}

	// Return a view for creating an event
	public function create(){
		return view('events.create', ['locations' => Location::all(), 'partners' => Partner::all()]);
	}

	// Store a new event
	public function store(Request $request){
		// Ensure the user is an admin
		if(! Auth::check() || ! Auth::user()->is_admin ){
			return response(view('errors.403', ['error' => 'You do not have permission to edit events.']), 403);
		}

		// Get the required fields from the form
		$data = $request->only( [
					'title',
					'description',
					'partner_id',
					'start_date',
					'end_date',
					'featured_image',
					'start_time',
					'end_time',
					'location_id'
				]);

		// Validate all input
		$validator = Validator::make( $data, [
					'title'  => 'required',
					'description'  => 'required',
					'partner_id' => 'required',
					'start_date'  => 'required',
					'end_date'  => 'required',
					'featured_image' => 'image',
					'start_time'  => 'required',
					'end_time' => 'required',
					'location_id'  => 'required',
				]);

		// If validation fails;
		if( $validator->fails( ) ){
			// Redirect back to registration form with errors
			return Redirect::to( 'events' )
					->withErrors( $validator )
					->withInput( );
		}

		// If the request has a file inputed for featured image
		if( $request->hasFile('featured_image' ) ){
			// Upload the new image
			$data['featured_image'] = MediaController::uploadImage(
											$request->file('featured_image'),
											time(),
											$directory = "event_photos",
											$bestFit = true,
											$fitDimensions = [1920, 1080]
										);
		}

		// Format the start and end datetime properly
		// for storage in the database
		$start_datetime = $data['start_date'] . ' ' . $data['start_time'] . ':' . '00';
		$end_datetime = $data['end_date'] . ' ' . $data['end_time'] . ':' . '00';

		$newData = array(
				"title" => $data["title"],
				"description" => $data["description"],
				"start_datetime" => $start_datetime,
				"end_datetime" => $end_datetime,
				"location_id" => $data["location_id"],
				"featured_image" => $data["featured_image"]
			);

		// Create the new event
		$newEvent = Event::create( $newData );

		// If successful, redirect to events
		if( $newEvent ){
			// Attach partners to model
			foreach($data['partner_id'] as $partner_id){
				$newEvent->partners()->attach($partner_id);
			}
			return Redirect::to( 'events' );
		}


		// If unsuccessful, return with errors
		return Redirect::back( )
					->withErrors( [
						'message' => 'We\'re sorry but event creation failed, please try again later.'
					] )
					->withInput( );
	}

	// Return a view for editing the selected event
	public function edit($id){
		//Ensure the user is an admin
		if(! Auth::check() || ! Auth::user()->is_admin ){
			return response(view('errors.403', ['error' => 'You do not have permission to edit events.']), 403);
		}
		// Find the event, or fail
		$event = Event::findOrFail($id);

		// Retrieve attributes of the selected event
		$locations = Location::all();
		$location = $event->location;
		$startDateTime = $event->start_datetime;
		$endDateTime = $event->end_datetime;

		// Format the start and end datetime for presentation
		$startDate = substr($startDateTime, 0, 10);
		$endDate = substr($endDateTime, 0, 10);
		$startTime = substr($startDateTime, 11, 5);
		$endTime = substr($endDateTime, 11, 5);

		// Return a view of the event for editing
		return view('events.edit', compact('event', 'locations', 'location', 'startDate',
			 'endDate', 'startTime', 'endTime'));
	}

	public function update($id, Request $request){

		// Ensure the user is logged in as an admin
		if(! Auth::check() || ! Auth::user()->is_admin ){
			return response(view('errors.403', ['error' => 'You do not have permission to edit events.']), 403);
		}

		// Try to retrieve the model for updating from the database
		try{
		   $event = Event::findOrFail($id);
		} catch (ModelNotFoundException $e) {
			return Redirect::back( )->withErrors(
				[
					'message' => 'The event you tried to edit could not be found.'
				] );
		}

		// Get the required fields from the form
		$data = $request->only( [
					'title',
					'description',
					'featured_image',
					'start_date',
					'end_date',
					'start_time',
					'end_time',
					'location_id'
				]);

		// Validate the data
		$validator = Validator::make( $data, [
					'title'  => 'required',
					'description'  => 'required',
					'start_date'  => 'required',
					'end_date'  => 'required',
					'start_time'  => 'required',
					'end_time' => 'required',
					'location_id'  => 'required',
				]);

		// If validation fails;
		if( $validator->fails( ) ){
			// Redirect back to registration form with errors
			return Redirect::back()
					->withErrors( $validator )
					->withInput( );
		}

		// Format the start and end datetime properly
		// for storage in the database
		$start_datetime = $data['start_date'] . ' ' . $data['start_time'] . ':' . '00';
		$end_datetime = $data['end_date'] . ' ' . $data['end_time'] . ':' . '00';

		$newData = array(
				"title" => $data["title"],
				"description" => $data["description"],
				"start_datetime" => $start_datetime,
				"end_datetime" => $end_datetime,
				"location_id" => $data["location_id"]
			);

		// Only if the user updated the photo;
		if($request->hasFile('featured_image')){

			// Validate the image
			$validator = Validator::make( $data, [
					'featured_image' => 'image'
				]);

			if( $validator->fails( ) ){
				// If validation fails, redirect back to
				// registration form with errors
				return Redirect::back()
						->withErrors( $validator )
						->withInput( );
			}

			// Upload the image
			$data['featured_image'] = MediaController::uploadImage(
										$request->file('featured_image'),
										time(),
										$directory = "event_photos",
										$bestFit = true,
										$fitDimensions = [1920, 1080]
									);

			// Store the new image
			$event->featured_image = $data['featured_image'];

		} else {
			unset($data['featured_image']);
		}

		// Store the values from the form in event
		$event->title = ($newData["title"]);
		$event->description = ($newData["description"]);
		$event->start_datetime = ($newData["start_datetime"]);
		$event->end_datetime = ($newData["end_datetime"]);
		$event->location_id = ($newData["location_id"]);

		// Save the event to the database
		$event->save();

		// Return to the events index
		return redirect('events');
	}
}
