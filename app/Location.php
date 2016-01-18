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

    public function event(){
    	return $this->hasMany('App/Event');
    }
}
