<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    //
    protected $fillable = [
    	'file_location',
		'event_id',
		'description',
		'name',
		'view_count'
    ]

    public function event(){
    	$this->hasOne('App\Event');
    }
}
