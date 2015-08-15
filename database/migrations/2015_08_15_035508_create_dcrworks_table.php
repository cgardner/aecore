<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDcrworksTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('dcrworks', function(Blueprint $table)
		{
            $table->increments('id');
            $table->integer('dcr_id');
            $table->string('crew_company');
            $table->integer('crew_size');
            $table->decimal('crew_hours');
            $table->string('crew_work');
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
        Schema::drop('dcrworks');
	}

}
