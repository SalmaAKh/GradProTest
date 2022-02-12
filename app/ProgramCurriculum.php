<?php

/**
 * Created by Reliese Model.
 * Date: Wed, 27 Mar 2019 17:36:36 +0000.
 */

namespace App;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class ProgramCurriculum
 *
 * @property int $id
 * @property int $department_id
 * @property int $course_code
 * @property string $course_name
 * @property string $year
 * @property string $semester
 * @property int $credit
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 *
 * @property \App\Department $department
 * @property \Illuminate\Database\Eloquent\Collection $offered_courses
 *
 * @package App
 */
class ProgramCurriculum extends Eloquent
{
	protected $table = 'program_curriculum';

	protected $casts = [
		'department_id' => 'int',
 		'credit' => 'int'
	];

	protected $fillable = [
		'department_id',
		'course_code',
		'course_name',
		'year',
		'semester',
		'credit'
	];


	public function department()
	{
		return $this->belongsTo(\App\Department::class);
	}

	public function offered_courses()
	{
		return $this->hasMany(\App\OfferedCourse::class);
	}
	public function OtherDepartmentOfferedCourse()
	{
		return $this->hasMany(\App\OtherDepartmentOfferedCourse::class);
	}



}
