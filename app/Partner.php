<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Partner extends Model
{
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'name',
		'featured_image',
		'type',
		'price',
		'description',
		'location_id',
		'distance',
		'email'
	];


	public function location(){
		return $this->belongsTo('App\Location');
	}

	public function events(){
		return $this->belongsToMany('App\Event', 'event_partners')->withPivot('distance');
	}

	//public function media(){
	//	return $this->hasOne('App\Media', 'id', 'picture');
	//}
}
