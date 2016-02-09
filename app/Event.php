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
		'description', 'location_id', 'start_datetime', 'end_datetime', 'title', 'featured_image', 'price'
	];

	public function location(){
		return $this->belongsTo('App\Location');
	}

	public function partners(){
		return $this->belongsToMany('App\Partner', 'event_partners', 'event_id', 'partner_id');
	}

	public function tickets(){
		return $this->hasMany('App\Ticket');
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
