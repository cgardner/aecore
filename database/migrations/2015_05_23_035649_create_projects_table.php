<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class CreateProjectsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
    Schema::create('projects', function(Blueprint $table) {
        $table->unsignedBigInteger('id', true);
        $table->string('projectcode');
        $table->unsignedInteger('company_id');
        $table->unsignedInteger('user_id');
        $table->string('status');
        $table->string('name');
        $table->string('type');
        $table->date('start');
        $table->date('finish');
        $table->double('value');
        $table->string('number');
        $table->unsignedInteger('size');
        $table->string('size_unit');
        $table->text('description');
        $table->string('street');
        $table->string('city');
        $table->string('state');
        $table->string('zip_code');
        $table->string('submittal_code');
        $table->timestamps();
        $table->softDeletes();

        $table->foreign('user_id')
            ->references('id')
            ->on('users');

        $table->foreign('company_id')
            ->references('id')
            ->on('companys');
      });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
    Schema::drop('projects');
	}

}
