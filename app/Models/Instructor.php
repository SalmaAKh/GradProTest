<?php

/**
 * Created by Reliese Model.
 * Date: Wed, 27 Mar 2019 17:36:36 +0000.
 */

namespace App;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Instructor
 * 
 * @property int $id
 * @property int $user_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * 
 * @property \App\User $user
 * @property \Illuminate\Database\Eloquent\Collection $constrain_hours
 * @property \Illuminate\Database\Eloquent\Collection $offered_courses
 *
 * @package App
 */
class Instructor extends Eloquent
{
	protected $casts = [
		'user_id' => 'int'
	];

	protected $fillable = [
		'user_id'
	];

	public function user()
	{
		return $this->belongsTo(\App\User::class);
	}

	public function constrain_hours()
	{
		return $this->hasMany(\App\ConstrainHour::class);
	}

	public function offered_courses()
	{
		return $this->hasMany(\App\OfferedCourse::class);
	}
}
