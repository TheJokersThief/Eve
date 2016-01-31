<?php

namespace App\Http\Controllers;

use Validator;
use Redirect;
use Auth;
use Image;
use Hash;
use View;
use Response;
use App\User;
use App\Media;
use App\Ticket;
use App\Setting;

use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class MediaController extends Controller
{

    public function viewUnprocessedMedia( ){
        if(! Auth::check() || ! Auth::user()->is_admin ){
            return Redirect::back( )->withErrors(
                [
                    'message' => 'You do not have permission to edit media.' 
                ] );
        }
 
        $media = Media::where('processed', false)->get()->chunk(6);
        return View::make('media.unprocessed')->with('media', $media);
    }

    public function viewUnprocessedMediaForEvent( $eventID ){
        if(! Auth::check() || ! Auth::user()->is_admin ){
            return Redirect::back( )->withErrors(
                [
                    'message' => 'You do not have permission to edit media.' 
                ] );
        }

        $media = Media::where('event_id', $eventID)->where('processed', false)->get()->chunk(6);
        return View::make('media.unprocessed')->with('media', $media);
    }

    public static function approveMedia( $mediaID, $isApproved ){
        if(! Auth::check() || ! Auth::user()->is_admin ){
            return Redirect::back( )->withErrors(
                [
                    'message' => 'You do not have permission to edit media.' 
                ] );
        }

        $media = Media::find( $mediaID );
        $media->approved = $isApproved;
        $media->processed = true;
        $media->save();
    }

    public static function uploadImage( $image, $hashSeed, $directory = "uploads", $bestFit = false, $fitDimensions = false ){
        // Get the file from the request
        $file = $image;

        $destination_path = storage_path() . '/'. $directory .'/';
        // Create a filename by hashing the user's username. This
        // will mean each user only has one profile picture residing
        // on our filesystem
        $file_name = hash('ripemd160', $hashSeed ) .'_picture.'. $file->getClientOriginalExtension();
        // Move the file to our server
        $movement = $image->move($destination_path, $file_name);

        // Perform an image intervention, getting best fit from image
        // and saving it again
        $image = Image::make( storage_path(). '/'. $directory .'/' . $file_name);
        if( $bestFit ){
        	$image->fit( $fitDimensions[0], $fitDimensions[1] );
        }
        $image->save(storage_path(). '/'. $directory .'/' . $file_name);

        return (string) '/'. $directory .'/'. $file_name;
    }

    public static function uploadLogo( $image ){
        // Get the file from the request
        $file = $image;
        $folder = '/company/';

        $destination_path = storage_path() . $folder;

        $file_name = 'company_logo.'. $file->getClientOriginalExtension();
        $file_name_white = 'company_logo_white.'. $file->getClientOriginalExtension();
        // Move the file to our server
        $movement = $image->move($destination_path, $file_name);

        MediaController::whiteOverlay( $destination_path . $file_name, $destination_path . $file_name_white );

        return [ "normal" => (string) $folder. $file_name, "white" => (string) $folder. $file_name_white ];
    }

    public static function whiteOverlay( $source, $destination ){
        $image = Image::make( $source );
        $image->colorize( 100, 100, 100 );
        $image->save( $destination );
    }
}
