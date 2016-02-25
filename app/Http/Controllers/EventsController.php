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
use Crypt;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Validator;
use App\Http\Controllers\MediaController;
use Illuminate\Http\Request;
use DB;

class EventsController extends Controller
{
	private $errorMessages =[
		'incorrect_permissions' => 'You do not have permission to edit events.',
		'event_creation_failed' => 'We\'re sorry but event creation failed, please try again later.',
		'event_not_found' => 'The event you tried to edit could not be found.'
	];


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
		$data['event'] = Event::findOrFail($id);

		// Retrieve various attributes of the location
		$location = $data['event']->location;
		$data['location_name'] = $location->name;
		$data['partners'] = $data['event']->partners;

		// If the user is authorised, get the ticket
		// for the event
		if( Auth::check() ){
			try{
				$data['ticket'] = Ticket::where('user_id', Auth::user()->id)
								->where('event_id', $id)
								->firstOrFail();
			}catch (ModelNotFoundException $e){
				$data['ticket'] = false;
			}
		} else {
			$data['ticket'] = false;
		}

        $userIds = DB::table('tickets')
                     ->where('event_id', $data['event']->id)
                     ->take(10)
                     ->pluck('user_id');

        $data['users'] = DB::table('users')
                   ->whereIn('id', $userIds)
                   ->get();

        $data = array_merge( $data, MediaController::uploadFiles( Crypt::encrypt($data['event']->id) ) );

        // Return a view of the event
		return view('events.show')->with($data);
	}

	// Return a view for creating an event
	public function create(){
		return view('events.create', ['locations' => Location::all(), 'partners' => Partner::all()]);
	}

	public function infoPack(Ticket $ticket){
		return view('events.infopack', ['ticket' => $ticket]);
	}

	// Store a new event
	public function store(Request $request){
		// Ensure the user is an admin
		if(! Auth::check() || ! Auth::user()->is_admin ){
			return response(view('errors.403', ['error' => $this->errorMessages['incorrect_permissions']]), 403);
		}

		// Get the required fields from the form
		$data = $request->only( [
					'title',
					'tagline',
					'description',
					'partner_id',
					'start_date',
					'end_date',
					'price',
					'featured_image',
					'start_time',
					'end_time',
					'location_id'
				]);

		// Validate all input
		$validator = Validator::make( $data, [
					'title'  => 'required',
					'tagline'  => 'required',
					'description'  => 'required',
					'partner_id' => 'required',
					'start_date'  => 'required',
					'end_date'  => 'required',
					'featured_image' => 'image',
					'start_time'  => 'required',
					'end_time' => 'required',
					'location_id'  => 'required',
					'price'        => 'required|numeric'
				]);

		// If validation fails;
		if( $validator->fails( ) ){
			// Redirect back to registration form with errors
			return Redirect::to( 'events/create' )
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
				"tagline" => $data["tagline"],
				"description" => $data["description"],
				"start_datetime" => $start_datetime,
				"end_datetime" => $end_datetime,
				"location_id" => $data["location_id"],
				"featured_image" => $data["featured_image"],
				"price" => $data["price"]
			);

		// Create the new event
		$newEvent = Event::create( $newData );

		// If successful, redirect to events
		if( $newEvent ){
			// Attach partners to model
			$distance;
			foreach($data['partner_id'] as $partner_id){
				$distance = getDistance(Partner::find($partner_id)->location, $newEvent->location);
				$newEvent->partners()->attach($partner_id, ['distance' => $distance]);
			}
			return Redirect::to( 'events' );
		}


		// If unsuccessful, return with errors
		return Redirect::back( )
					->withErrors( [
						'message' => $this->errorMessages['event_creation_failed']
					] )
					->withInput( );
	}

	// Return a view for editing the selected event
	public function edit($id){
		//Ensure the user is an admin
		if(! Auth::check() || ! Auth::user()->is_admin ){
			return response(view('errors.403', ['error' => $this->errorMessages['incorrect_permissions']]), 403);
		}
		// Find the event, or fail
		$event = Event::findOrFail($id);

		// Retrieve attributes of the selected event
		$locations = Location::all();
		$location = $event->location;
		$startDateTime = $event->start_datetime;
		$endDateTime = $event->end_datetime;
		$allPartners = Partner::all();
		$eventPartners = $event->partners;
		$eventPartnersId = [];
		$i = 0;
		foreach($eventPartners as $partner){
			$eventPartnersId[$i++] = $partner->id;
		}


		// Format the start and end datetime for presentation
		$startDate = substr($startDateTime, 0, 10);
		$endDate = substr($endDateTime, 0, 10);
		$startTime = substr($startDateTime, 11, 5);
		$endTime = substr($endDateTime, 11, 5);

		// Return a view of the event for editing
		return view('events.edit', compact('event', 'locations', 'location', 'allPartners', 'eventPartnersId', 'startDate',
			 'endDate', 'startTime', 'endTime'));
	}

	public function update($id, Request $request){
		// Ensure the user is logged in as an admin
		if(! Auth::check() || ! Auth::user()->is_admin ){
			return response(view('errors.403', ['error' => $this->errorMessages['incorrect_permissions']]), 403);
		}

		// Try to retrieve the model for updating from the database
		try{
		   $event = Event::findOrFail($id);
		} catch (ModelNotFoundException $e) {
			return Redirect::back( )->withErrors(
				[
					'message' => $this->errorMessages['event_not_found']
				] );
		}

		// Get the required fields from the form
		$data = $request->only( [
					'title',
					'tagline',
					'description',
					'partner_id',
					'featured_image',
					'start_date',
					'end_date',
					'start_time',
					'end_time',
					'location_id',
					'price'
				]);

		// Validate the data
		$validator = Validator::make( $data, [
					'title'  => 'required',
					'tagline' => 'required',
					'description'  => 'required',
					'partner_id' => 'required',
					'start_date'  => 'required',
					'end_date'  => 'required',
					'start_time'  => 'required',
					'end_time' => 'required',
					'location_id'  => 'required',
					'price' => 'required|numeric'
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
				"tagline" => $data["tagline"],
				"description" => $data["description"],
				"start_datetime" => $start_datetime,
				"end_datetime" => $end_datetime,
				"location_id" => $data["location_id"],
				"price" => $data["price"]
			);

		// Only if the user updated the photo;
		if($request->hasFile('featured_image')){
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
		$event->update( $newData );

		// Detach all partners and attach new partners to event
		$event->partners()->detach();

		$distance;
		foreach($data['partner_id'] as $partner_id){
			$distance = getDistance(Partner::find($partner_id)->location, $event->location);
			$event->partners()->attach($partner_id, ['distance' => $distance]);
		}


		// Save the event to the database
		$event->save();

		// Return to the events index
		return Redirect::route('events.show', $event->id);
	}
}
