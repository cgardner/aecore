<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSlackIntegrationsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('slackintegrations', function(Blueprint $table)
		{
            $table->increments('id');
            $table->integer('project_id');
            $table->integer('company_id');
            $table->string('webhook');
            $table->string('channel')->nullable();
            $table->string('username');
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
		Schema::drop('slackintegrations');
	}

}
