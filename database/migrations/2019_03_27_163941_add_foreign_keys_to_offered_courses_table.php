<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToOfferedCoursesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('offered_courses', function(Blueprint $table)
		{
			$table->foreign('program_curriculum_id', 'offered_courses_fk0')->references('id')->on('program_curriculum')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('instructor_id', 'offered_courses_fk1')->references('id')->on('instructors')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('day_id', 'offered_courses_fk2')->references('id')->on('days')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('hour_id', 'offered_courses_fk3')->references('id')->on('hours')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('room_id', 'offered_courses_fk4')->references('id')->on('rooms')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('offered_courses', function(Blueprint $table)
		{
			$table->dropForeign('offered_courses_fk0');
			$table->dropForeign('offered_courses_fk1');
			$table->dropForeign('offered_courses_fk2');
			$table->dropForeign('offered_courses_fk3');
			$table->dropForeign('offered_courses_fk4');
		});
	}

}
