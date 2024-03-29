<?php

/**
 * Created by Reliese Model.
 * Date: Wed, 27 Mar 2019 17:36:36 +0000.
 */

namespace App;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class OfferedCourse
 * 
 * @property int $id
 * @property int $course_id
 * @property int $day_id
 * @property int $hour_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * 

 * @package App
 */
class OtherDepartmentOfferedCourse extends Eloquent
{
	protected $casts = [
		'program_curriculum_id' => 'int',
		'day_id' => 'int',
		'hour_id' => 'int',
	];

	protected $fillable = [
		'program_curriculum_id',
		'day_id',
		'hour_id',
	];

	protected $appends = ['semester','department_id'];



	public function getSemesterAttribute(){
	    return $this->program_curriculum()->first()->semester;
    }


    public function getDepartmentIdAttribute(){
	    return $this->program_curriculum()->first()->department_id;
    }

	public function program_curriculum()
	{
		return $this->belongsTo(\App\ProgramCurriculum::class);
	}

	public function department()
	{
		return $this->belongsTo(\App\Department::class);
	}


	public function day()
	{
		return $this->belongsTo(\App\Day::class);
	}

	public function hour()
	{
		return $this->belongsTo(\App\Hour::class);
	}

}
