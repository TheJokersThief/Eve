<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Controllers\LocationController;
use App\Partner;
use App\Location;
use App\Event;
use Redirect;
use DB;

use Crypt;
use Validator;
use Auth;

class PartnersController extends Controller
{
	private $errorMessages = [
		'incorrect_permissions' => 'You do not have permission to edit partners.',
		'partner_creation_failed' => 'We\'re sorry but partner creation failed, please try again later.',
		'incorrect_permissions_partners' => 'You do not have permission to edit partners',
	];

	public function index(){
		$partners = Partner::orderBy('id', 'ASC')->get();
		return view('partners.index', ['partners' => $partners]);
	}

	public function show($id){
		$partner = Partner::findOrFail($id);
		return view('partners.show', compact('partner'));
	}

	public function create(){
		if(! Auth::check() || ! Auth::user()->is_admin ){
			return response(view('errors.403', ['error' => $this->errorMessages['incorrect_permissions']]), 403);
		}

		return view('partners.create', ['locations' => Location::all(), 'events' => Event::all()]);
	}

	public function store(Request $request){
		if(! Auth::check() || ! Auth::user()->is_admin ){
			return response(view('errors.403', ['error' => $this->errorMessages['incorrect_permissions']]), 403);
		}

		$data = $request->only( [
					'name',
					'picture',
					'type',
					'price',
					'description',
					'location_id',
					'event_id',
					'email',
					'logo',
					'url'
				]);

		// Validate all input
		$validator = Validator::make( $data, [
					'name' => 'required',
					'picture' => 'required|image',
					'type' => 'required',
					'price' => 'required',
					'description' => 'required',
					'location_id' => 'required',
					'event_id'	=> 'required',
					'email' => 'required',
					'logo' => 'required|image',
					'url' => 'required'
				]);

		if( $validator->fails( ) ){
			// If validation fails, redirect back to
			// registration form with errors
			return Redirect::to( 'partners/create' )
					->withErrors( $validator )
					->withInput( );
		}

		if( $request->hasFile('picture' ) ){
			$data['picture'] = MediaController::uploadImage(
											$request->file('picture'),
											time(),
											$directory = "partner_photos",
											$bestFit = true,
											$fitDimensions = [1920, 1080]
										);
		}


		if( $request->hasFile('logo' ) ){
			$data['logo'] = MediaController::uploadImage(
											$request->file('logo'),
											time(),
											$directory = "partner_logos"
										);
		}

		$newData = array(
				"name" => $data["name"],
				"description" => $data["description"],
				"type" => $data["type"],
				"price" => $data["price"],
				"location_id" => $data["location_id"],
				"email" => $data["email"],
				"featured_image" => $data["picture"],
				"url" => $data["url"],
				"logo" => $data["logo"]
			);

		// Create the new partner
		$newPartner = Partner::create( $newData );

		if( $newPartner ){
			// Attach events to model
			$distance;
			foreach($data['event_id'] as $event_id){
				$distance = getMapsMatrixDistance(Event::find($event_id)->location, $newPartner->location);
				$newPartner->events()->attach($event_id, ['distance' => $distance]);
			}
			return Redirect::to( 'partners' );
		}

		// If unsuccessful, return with errors
		return Redirect::back( )
					->withErrors( [
						'message' => $this->errorMessages['partner_creation_failed']
					] )
					->withInput( );
	}

	public function edit($partnerID){
		if(! Auth::check() || ! Auth::user()->is_admin ){
			return response(view('errors.403', ['error' => $this->errorMessages['incorrect_permissions']]), 403);
		}

		$partner = Partner::where('id', $partnerID)
						->firstOrFail();
		return view('partners.edit', ['partner'=>$partner], ['locations' => Location::all()] );
		//return view('partners.edit')->with(['partner'=>$partner]);
	}

	public function update( $partnerID, Request $request){
		if(! Auth::check() || ! Auth::user()->is_admin ){
			return response(view('errors.403', ['error' => $this->errorMessages['incorrect_permissions']]), 403);
		}

		$data = $request->only([
				'name',
				'type',
				'price',
				'location_id',
				'description',
				'email',
				'featured_image'
			]);

		// Validate all input
		$validator = Validator::make( $data, ['featured_image' => 'image|sometimes']);

		if( $validator->fails( ) ){
			// If validation fails, redirect back to
			// registration form with errors
			return Redirect::back( )
					->withErrors( $validator )
					->withInput( );
		}

		if( $request->hasFile('featured_image') ){
			$data['featured_image'] = MediaController::uploadImage(
											$request->file('featured_image'),
											time(),
											$directory = "partner_images",
											$bestFit = true,
											$fitDimensions = [1920, 1080]
										);
		} else{
			unset( $data['featured_image'] );
		}

		$partner = Partner::find($partnerID);
		$partner->update( $data );

		$partner->events()->detach();

		$distance;
		foreach($data['event_id'] as $event_id){
			$distance = getMapsMatrixDistance(Event::find($event_id)->location, $partner->location);
			$partner->events()->attach($event_id, ['distance' => $distance]);
		}

		return Redirect::route('partners.edit', [$partner->id]);
	}

	/**
	 * @param  int 		$encryptedPartnerId	The encrypted value of the Partner ID to be destroyed
	 * @return Redirect 	Back to the previous page
	 */
	public function destroy( $encryptedPartnerID ){
		if(! Auth::check() || ! Auth::user()->is_admin ){
			return response( view('errors.403', ['error' => $this->errorMessages['incorrect_permissions_partners']]), 403 );
		}
		$partnerID = Crypt::decrypt($encryptedPartnerID);
		DB::delete('delete from event_partners where partner_id = ?', [$partnerID]);
		Partner::destroy($partnerID);
		return Redirect::back();
	}

	/**
	 * This function returns up to 20 nearby locations in a 2-dimensional array in the format
	 * [index_of_location_in_array][name,address,unique_id]
	 * The unique ID can be used to query the Google Places API for further information on the location
	 * @param  Location $location A location model, as described in the project
	 * @return array[][]             A 2-dimensional array containing up to 20 results, the first
	 *                               dimension being the index (0-19), the second being the details
	 */
	public function getSuggestedPartners( Location $location ){
		$longitude = $location->longitude;
		$latitude = $location->latitude;
		//Make API Request

		//we need to return the name, approx location and unique ID
		$result = json_decode( file_get_contents('https://maps.googleapis.com/maps/api/place/nearbysearch/output?json&location='
									. $latitude . ','
									. $longitude
									. '&radius=500&key='
									. env('GOOGLE_API_KEY') ), true );

		$returnResult = [];

		$result = $result['results'];

		$i = 0;

		//name, vicinity, id
		foreach( $result as $value ){
			$tempArray = array( $value['name'], $value['vicinity'], $value['id'] );
			$returnResult[$i] = $tempArray;
			$i++;
		}

		return $returnResult;
	}

	/**
	 * Adds the suggested partner to the database using the details
	 * returned from the Google Places API
	 * @param $encryptedPlaceID The encrypted place ID, of the place to be added to the database
	 */
	public function addSuggestedPartner( $encryptedPlaceID ){
		//decrypt place id
		$placeID = Crypt::decrypt($encryptedPlaceID);

		//Find from google places
		$result = file_get_contents('https://maps.googleapis.com/maps/api/place/details/json?placeid='
									. $placeID
									. '&key='
									. env('GOOGLE_API_KEY') );

		//store the location (call location.createLocationForPlace( $longitude, $latitude, $title ))

		$result = json_decode($result, true);
		$longitude = $result['result']['geometry']['location']['lng'];
		$latitude = $result['result']['geometry']['location']['lat'];
		$title = $result['result']['name'];

		$locationID = LocationController::createLocationForPlace( $longitude, $latitude, $title );

		//Create new partner in db
		$price = 0;
		if( isset($result['result']['price_level']) ){
			$price = 5 * $result['result']['price_level'];
		}

		$url = isset($result['result']['website']) ? $result['result']['website'] : "";
		$type = isset($result['result']['types'][0]) ? $result['result']['types'][0] : "";

		$newData = array(
				"name" => $title,
				"description" => $title,
				"type" => $type,
				"price" => $price,
				"location_id" => $locationID,
				"email" => "",
				"featured_image" => "/images/red-geometric-background.png",
				"url" => $url,
				"logo" => "/images/default_profile_image.png"
			);

		// Create the new partner
		$newPartner = Partner::create( $newData );

		//associate partner with event //TODO
	}

}
