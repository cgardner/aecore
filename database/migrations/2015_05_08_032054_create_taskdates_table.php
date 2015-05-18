<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTaskdatesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('taskdates', function(Blueprint $table)
		{
      $table->increments('id');
      $table->integer('task_id');
      $table->datetime('date_due')->nullable();
      $table->datetime('date_complete')->nullable();
			$table->timestamps();
      $table->dropPrimary('taskdates_pkey');
      $table->primary('task_id');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('taskdates');
	}

}
