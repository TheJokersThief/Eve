<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'title',
		'featured_image',
		'content',
		'tags',
		'updated_at',
		'created_at'
	];

}
