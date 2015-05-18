<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTasksTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tasks', function(Blueprint $table)
		{
      $table->increments('id');
      $table->integer('user_id'); //assigned to
      $table->integer('assigned_by');
      $table->integer('tasklist_id')->default('0');
      $table->string('taskcode', 10)->unique();
      $table->string('task');
			$table->string('status')->default('open'); //open, complete, disabled
      $table->string('priority')->default('1'); //1=low, 2=medium, 3=high
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
		Schema::drop('tasks');
	}

}
