<?php

/**
 * Created by Reliese Model.
 * Date: Wed, 27 Mar 2019 17:36:36 +0000.
 */

namespace App;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Day
 * 
 * @property int $id
 * @property string $name
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * 
 * @property \Illuminate\Database\Eloquent\Collection $constrain_hours
 * @property \Illuminate\Database\Eloquent\Collection $offered_courses
 *
 * @package App
 */
class Day extends Eloquent
{
	protected $fillable = [
		'name'
	];

	public function constrain_hours()
	{
		return $this->hasMany(\App\ConstrainHour::class);
	}

	public function offered_courses()
	{
		return $this->hasMany(\App\OfferedCourse::class);
	}
}
