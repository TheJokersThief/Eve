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
        'picture',
        'type',
		'price',
		'description',
		'location_id',
		'distance',
		'email'
    ];


    public function location(){
        return $this->hasOne('App\Location', 'location_id', 'id');
    }

    public function events(){
        return $this->belongsToMany('App\Event', 'event_partners');
    }
}
