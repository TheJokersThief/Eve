<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Controllers\MediaController;

use App\Location;
use App\Setting;
use Redirect;
use Auth;
use Validator;
use Crypt;

class LocationController extends Controller
{
	public function index(){
		$locations = Location::orderBy('id', 'ASC')->paginate(15);
		return view('locations.index', ['locations' => $locations]);
	}

	public function create(){
		if(! Auth::check() || ! Auth::user()->is_admin ){
			return response(view('errors.403', ['error' => 'You do not have permission to edit locations.']), 403);
		}

		return view('locations.create');
	}

	/**
	 * Create a news item
	 * @param  Request $request
	 * @return REDIRECT         A view of the post
	 */
	public function store( Request $request ){
		if(! Auth::check() || ! Auth::user()->is_admin ){
			return response(view('errors.403', ['error' => 'You do not have permission to edit locations.']), 403);
		}

		$data = $request->only( [
					'name',
					'coordinates',
					'capacity',
					'featured_image'
				]);

		// Validate all input
		$validator = Validator::make( $data, [
					'name' => 'required',
					'coordinates' => 'required',
					'capacity' => 'required|numeric',
					'featured_image' => 'image|sometimes'
				]);

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
											$directory = "location_images",
											$bestFit = true,
											$fitDimensions = [1920, 1080]
										);
		} else {
			unset($data['featured_image']);
		}

		$location = Location::create($data);

		return Redirect::route('locations.edit', ['id' => $location->id]);
	}

	public function edit( $locationID ){
		if(! Auth::check() || ! Auth::user()->is_admin ){
			return response(view('errors.403', ['error' => 'You do not have permission to edit news.']), 403);
		}
		$item = Location::find($locationID);

		// If no featured image, put in our default image
		$item->featured_image = ($item->featured_image == '')
									? Setting::where('name', 'default_profile_picture')->first()->setting
									: $item->featured_image;

		return view('locations.edit')->with( 'item', $item );
	}

	public function update( Request $request, $locationID ){
		if(! Auth::check() || ! Auth::user()->is_admin ){
			return response(view('errors.403', ['error' => 'You do not have permission to edit locations.']), 403);
		}

		$data = $request->only( [
					'name',
					'coordinates',
					'capacity',
					'featured_image'
				]);

		// Validate all input
		$validator = Validator::make( $data, [
					'name' => 'required',
					'coordinates' => 'required',
					'capacity' => 'required',
					'featured_image' => 'image|sometimes'
				]);

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
											$directory = "news_images",
											$bestFit = true,
											$fitDimensions = [1920, 1080]
										);
		} else{
			unset( $data['featured_image'] );
		}

		$location = Location::find($locationID);
		$location->update( $data );

		return Redirect::route('locations.edit', [$location->id]);
	}

	public function destroy( $encryptedLocationID ){
		if(! Auth::check() || ! Auth::user()->is_admin ){
			return response(view('errors.403', ['error' => 'You do not have permission to edit locations.']), 403);
		}
		$locationID = Crypt::decrypt($encryptedLocationID);
		Location::destroy($locationID);
		return Redirect::back();
	}
}
