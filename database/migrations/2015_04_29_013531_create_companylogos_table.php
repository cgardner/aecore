<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompanylogosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('companylogos', function(Blueprint $table)
		{
            $table->increments('id');
            $table->integer('company_id');
			$table->integer('file_id_logo')->nullable();
			$table->integer('file_id_sq_lg')->nullable();
			$table->integer('file_id_sq_sm')->nullable();
			$table->timestamps();
            $table->dropPrimary('companylogos_pkey');
            $table->primary('company_id');    
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('companylogos');
	}

}
