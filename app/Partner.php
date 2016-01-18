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
        'type',
		'price',
		'description',
		'location_id',
		'distance',
		'email'
    ];


    public function location(){
        $this->hasOne('App\Location');
    }

    public function events(){
        $this->belongsToMany('App\Event', 'event_partners');
    }
}
