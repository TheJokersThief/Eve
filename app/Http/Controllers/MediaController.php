<?php

namespace App\Http\Controllers;

use Validator;
use Redirect;
use Auth;
use Image;
use Hash;
use Response;
use App\User;
use App\Ticket;
use App\Setting;

use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class MediaController extends Controller
{
    public static function uploadImage( $image, $hashSeed, $directory = "uploads", $bestFit = false, $fitDimensions = false ){
        // Get the file from the request
        $file = $image;

        $destination_path = storage_path() .'/uploads/';
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
}
