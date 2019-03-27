<?php

/**
 * Created by Reliese Model.
 * Date: Wed, 27 Mar 2019 17:36:36 +0000.
 */

namespace App;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class User
 * 
 * @property int $id
 * @property string $email
 * @property string $name
 * @property string $surname
 * @property string $password
 * @property string $remember_token
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * 
 * @property \Illuminate\Database\Eloquent\Collection $administrators
 * @property \Illuminate\Database\Eloquent\Collection $instructors
 *
 * @package App
 */
class User extends Eloquent
{
	protected $hidden = [
		'password',
		'remember_token'
	];

	protected $fillable = [
		'email',
		'name',
		'surname',
		'password',
		'remember_token'
	];

	public function administrators()
	{
		return $this->hasMany(\App\Administrator::class);
	}

	public function instructors()
	{
		return $this->hasMany(\App\Instructor::class);
	}
}
