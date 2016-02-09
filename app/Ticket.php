<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use QrCode;
use Crypt;
use App\User;

class Ticket extends Model
{
	protected $fillable = [
		'user_id',
		'event_id',
		'used',
		'scanned_by',
		'price'
	];

	/**
	 * Generates a code to be used in a QR code representation
	 * of the ticket, containing the ticket ID, user id and event id.
	 *
	 * @return string Ticket Code
	 */
	public function code(){
		$arr = [  "id"     => $this->id,
				"user_id"  => $this->user_id,
				"event_id" => $this->event_id ];

		return Crypt::encrypt( json_encode($arr) );
	}

	/**
	 * Returns a code for an SVG QR code pointing to
	 * the ticket's validate page.
	 * @return string As above
	 */
	public function qr(){
		QrCode::size(225);
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

	public function getScannedByAttribute($value){
		return User::firstOrFail($value);
	}


	public function event(){
		return $this->belongsTo('App\Event');
	}
}
