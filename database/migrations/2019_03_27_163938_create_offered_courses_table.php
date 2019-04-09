<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOfferedCoursesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('offered_courses', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('program_curriculum_id')->index('offered_courses_fk0');
			$table->integer('instructor_id')->index('offered_courses_fk1');
			$table->integer('day_id')->nullable()->index('offered_courses_fk2');
			$table->integer('hour_id')->nullable()->index('offered_courses_fk3');
			$table->integer('room_id')->nullable()->index('offered_courses_fk4');
			$table->integer('event_type')->nullable();
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
		Schema::drop('offered_courses');
	}

}
