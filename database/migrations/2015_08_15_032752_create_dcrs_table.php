<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDcrsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('dcrs', function(Blueprint $table)
		{
            $table->increments('id');
            $table->unsignedInteger('project_id');
            $table->unsignedInteger('company_id');
            $table->date('date');
            $table->string('weather');
            $table->integer('temperature');
            $table->string('temperature_type');
            $table->text('comments')->nullable();
            $table->text('correspondence')->nullable();
            $table->text('issues')->nullable();
            $table->text('safety')->nullable();
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
        Schema::drop('dcrs');
	}

}
