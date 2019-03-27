<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProgramCurriculumTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('program_curriculum', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('department_id')->index('program_curriculum_fk0');
			$table->integer('course_code')->unique('course_code');
			$table->string('course_name', 50)->unique('course_name');
			$table->string('year', 10);
			$table->string('semester', 10);
			$table->integer('credit');
            $table->timestamps();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('program_curriculum');
	}

}
