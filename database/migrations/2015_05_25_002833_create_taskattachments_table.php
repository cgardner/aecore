<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTaskattachmentsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('taskattachments', function(Blueprint $table)
		{
      $table->increments('id');
      $table->integer('task_id');
      $table->integer('file_id');
      $table->integer('user_id');
      $table->string('status')->default('active'); //active, disabled
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
		Schema::drop('taskattachments');
	}

}
