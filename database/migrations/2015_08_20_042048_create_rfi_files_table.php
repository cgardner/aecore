<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRfiFilesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('rfi_files', function(Blueprint $table)
		{
			$table->bigInteger('id', true, true);
			$table->bigInteger('rfi_id', false, true);
			$table->integer('file_id', false, true);
			$table->timestamps();
			$table->softDeletes();

			$table->foreign('rfi_id')
				->references('id')
				->on('rfis')
				->onDelete('cascade');

			$table->foreign('file_id')
				->references('id')
				->on('s3files')
				->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('rfi_files');
	}

}
