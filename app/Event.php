<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'description', 'location_id', 'start_datetime', 'end_datetime', 'title',
    ];

    public function location(){
    	return $this->belongsTo('App\Location');
    }

    public function partners(){
        return $this->belongsToMany('App\Partner', 'event_partners');
    }

    public function tickets(){
        $this->hasMany('App\Ticket');
    }
}
