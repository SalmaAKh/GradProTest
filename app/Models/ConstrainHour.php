<?php

/**
 * Created by Reliese Model.
 * Date: Wed, 27 Mar 2019 17:36:36 +0000.
 */

namespace App;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class ConstrainHour
 * 
 * @property int $id
 * @property int $instructor_id
 * @property int $hour_id
 * @property int $day_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * 
 * @property \App\Instructor $instructor
 * @property \App\Hour $hour
 * @property \App\Day $day
 *
 * @package App
 */
class ConstrainHour extends Eloquent
{
	protected $casts = [
		'instructor_id' => 'int',
		'hour_id' => 'int',
		'day_id' => 'int'
	];

	protected $fillable = [
		'instructor_id',
		'hour_id',
		'day_id'
	];

	public function instructor()
	{
		return $this->belongsTo(\App\Instructor::class);
	}

	public function hour()
	{
		return $this->belongsTo(\App\Hour::class);
	}

	public function day()
	{
		return $this->belongsTo(\App\Day::class);
	}
}
