<?php

/**
 * Created by Reliese Model.
 * Date: Wed, 27 Mar 2019 17:36:36 +0000.
 */

namespace App;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Room
 * 
 * @property int $id
 * @property int $room_type
 * @property string $room_id
 * @property int $capacity
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * 
 * @property \Illuminate\Database\Eloquent\Collection $offered_courses
 *
 * @package App
 */
class Room extends Eloquent
{
	protected $casts = [
		'room_type' => 'int',
		'capacity' => 'int'
	];

	protected $fillable = [
		'room_type',
		'room_id',
		'capacity'
	];

	public function offered_courses()
	{
		return $this->hasMany(\App\OfferedCourse::class);
	}
}
