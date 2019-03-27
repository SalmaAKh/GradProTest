<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToProgramCurriculumTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('program_curriculum', function(Blueprint $table)
		{
			$table->foreign('department_id', 'program_curriculum_fk0')->references('id')->on('departments')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('program_curriculum', function(Blueprint $table)
		{
			$table->dropForeign('program_curriculum_fk0');
		});
	}

}
