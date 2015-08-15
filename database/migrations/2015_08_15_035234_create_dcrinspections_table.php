<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDcrinspectionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('dcrinspections', function(Blueprint $table)
		{
            $table->increments('id');
            $table->integer('dcr_id');
            $table->string('inspection_agency');
            $table->string('inspection_type');
            $table->string('inspection_status');
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
        Schema::drop('dcrinspections');
	}

}
