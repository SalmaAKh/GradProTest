<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateConstrainHoursTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('constrain_hours', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('instructor_id')->index('constrain_hours_fk0');
			$table->integer('hour_id')->index('constrain_hours_fk1');
			$table->integer('day_id')->index('constrain_hours_fk2');
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
		Schema::drop('constrain_hours');
	}

}
