<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectusersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('projectusers', function(Blueprint $table)
		{
      $table->increments('id');
      $table->integer('project_id');
      $table->integer('user_id');
      $table->string('access'); // read, write, admin
      $table->string('role'); // architect, owner, general contractor, etc..
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
		Schema::drop('projectusers');
	}

}
