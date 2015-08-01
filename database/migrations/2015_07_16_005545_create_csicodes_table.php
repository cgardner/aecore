<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCsicodesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('csicodes', function(Blueprint $table)
		{
            $table->increments('id');
            $table->string('code');
            $table->string('description');
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
		Schema::drop('csicodes');
	}

}