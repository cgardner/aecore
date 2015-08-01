<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCostcodesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('costcodes', function(Blueprint $table)
		{
            $table->increments('id');
            $table->integer('company_id');
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
		Schema::drop('costcodes');
	}

}