<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    /**
    *	Mass assignable attributes
    */
    protected $fillable = [
    	'name','coordinates','capacity'
    ];

    public function Event(){
    	return $this->hasOne('App/Location');
    }
}
