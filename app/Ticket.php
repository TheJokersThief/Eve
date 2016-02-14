<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use QrCode;
use Crypt;
use Cache;


class Ticket extends Model
{
	protected $fillable = [
		'user_id',
		'event_id',
		'used',
		'scanned_by',
		'price',
		'charge_id'
	];

	/**
	 * Generates a code to be used in a QR code representation
	 * of the ticket, containing the ticket ID, user id and event id.
	 *
	 * @return string Ticket Code
	 */
	public function code(){
		$cacheKey = "ticket:{$this->id}";

		$code = Cache::get($cacheKey);

		if($code == null){
			$arr = [  "id" => $this->id,
				"user_id"  => $this->user_id,
				"event_id" => $this->event_id ];

			$code = Crypt::encrypt( json_encode($arr) );

			// Cache the given code for 180 minutes
			Cache::put($cacheKey, $code, 180);
		}

		return $code;

	}

	/**
	 * Returns a code for an SVG QR code pointing to
	 * the ticket's validate page.
	 *
	 * @param   int $size   Integer value of number of pixels that represent the code's side length
	 *
	 * @return string As above
	 */
	public function qr($size = 225){
		QrCode::size($size);
		return QrCode::generate( "http://" . $_SERVER["HTTP_HOST"] . "/tickets/verify/" . $this->code() );
	}

	/**
	 * Creates the Ticket::hasCode($code) scope for locating tickets in the db
	 * using their QR codes. Just use Ticket::hasCode($code)->first() to get the
	 * ticket object in question!
	 *
	 * @param  Query  $query  The Laravel Query object that we operate here.
	 * @param  String $code   Encoded, encrypted code string.
	 *
	 * @return Query          Query focued on the ticket referenced in the string.
	 */
	public function scopeHasCode($query, $code){
		// Get the ticket details from our code
		$decoded = json_decode( Crypt::decrypt($code) );

		// Search for them in the database.
		return $query->where('id',     $decoded->id)
					 ->where("user_id", $decoded->user_id)
					 ->where("event_id", $decoded->event_id);
	}


	public function user(){
		return $this->belongsTo('App\User');
	}

	public function event(){
		return $this->belongsTo('App\Event');
	}
}
