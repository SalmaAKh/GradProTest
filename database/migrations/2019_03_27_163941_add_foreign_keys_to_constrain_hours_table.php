<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToConstrainHoursTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('constrain_hours', function(Blueprint $table)
		{
			$table->foreign('instructor_id', 'constrain_hours_fk0')->references('id')->on('instructors')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('hour_id', 'constrain_hours_fk1')->references('id')->on('hours')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('day_id', 'constrain_hours_fk2')->references('id')->on('days')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('constrain_hours', function(Blueprint $table)
		{
			$table->dropForeign('constrain_hours_fk0');
			$table->dropForeign('constrain_hours_fk1');
			$table->dropForeign('constrain_hours_fk2');
		});
	}

}
