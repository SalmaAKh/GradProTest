<?php

/**
 * Created by Reliese Model.
 * Date: Wed, 27 Mar 2019 17:36:36 +0000.
 */

namespace App;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Department
 * 
 * @property int $id
 * @property string $name
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * 
 * @property \Illuminate\Database\Eloquent\Collection $program_curriculums
 *
 * @package App
 */
class Department extends Eloquent
{
	protected $fillable = [
		'name'
	];

	public function program_curriculums()
	{
		return $this->hasMany(\App\ProgramCurriculum::class);
	}
}
