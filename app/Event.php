<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Event extends Model
{
	 /**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'description', 'tagline', 'location_id', 'start_datetime', 'end_datetime', 'title', 'featured_image', 'price'
	];

	/**
	 * Returns the location the event is in
	 */
	public function location(){
		return $this->belongsTo('App\Location');
	}

	/**
	 * Returns the partners associated with the event
	 */
	public function partners(){
		return $this->belongsToMany('App\Partner', 'event_partners', 'event_id', 'partner_id')->withPivot('distance');
	}

	/**
	 * Returns the ticket for this event
	 */
	public function tickets(){
		return $this->hasMany('App\Ticket');
	}

	/**
	 * Returns the media associated with this event
	 */
	public function media(){
		return $this->hasMany('App\Media');
	}

	/**
	 * Start time string for humans.
	 */
	public function hrStartTime(){
		$carbon = new Carbon($this->start_datetime);
		return $carbon->toDayDateTimeString();
	}

	/**
	 * End time string for humans.
	 */
	public function hrEndTime(){
		$carbon = new Carbon($this->end_datetime);
		return $carbon->toDayDateTimeString();
	}
}
