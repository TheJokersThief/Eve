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
		'view_count',
        'approved'      // Whether a piece of media should be publicly viewable
    ]

    public function event(){
    	return $this->hasOne('App\Event');
    }
}
