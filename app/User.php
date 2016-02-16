<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use SammyK\LaravelFacebookSdk\SyncableGraphNodeTrait;

class User extends Authenticatable
{
	use SyncableGraphNodeTrait;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'name', 'email', 'password', 'is_admin', 'username',
		'is_staff', 'profile_picture', 'bio', 'language', 'country', 'city',
		'facebook_id'
	];

	/**
	 * Fields that can be edited by the Open Graph sync.
	 *
	 * @var array
	 */
	protected static $graph_node_fillable_fields = [
		'name', 'email', 'username', 'profile_picture', 'bio', 'language',
		'country', 'city', 'facebook_id'
	];

	/**
	 * How those fields map to Facebook response objects.
	 *
	 * @var array
	 */
	protected static $graph_node_field_aliases = [
		'id' => 'facebook_id'
	];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = [
		'password', 'remember_token',
	];

	public function tickets(){
		return $this->hasMany('App\Ticket');
	}
}
