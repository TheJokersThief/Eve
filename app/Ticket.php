<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $fillable = [
    	'user_id',
    	'event_id',
    	'used'
    ];

    /**
     * Generates a code to be used in a QR code representation
     * of the ticket, containing the ticket ID, user id and event id.
     * 
     * @return string Ticket Code
     */
    public function code(){
    	$arr = [  "id"     => $this->id,
    			"user_id"  => $this->userId,
    			"event_id" => $this->eventId ];

    	return Crypt::encrypt( json_encode($arr) ); 
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
