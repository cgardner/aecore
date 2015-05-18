<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTaskrefreshdatesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('taskrefreshdates', function(Blueprint $table)
		{
      $table->increments('id');
      $table->integer('user_id');
      $table->datetime('date_refresh');
			$table->timestamps();
      $table->dropPrimary('taskrefreshdates_pkey');
      $table->primary('user_id');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('taskrefreshdates');
	}

}
