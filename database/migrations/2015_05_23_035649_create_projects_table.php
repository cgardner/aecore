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
            $table->unsignedInteger('company_id')
                ->nullable();
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
            $table->unsignedInteger('user_id');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')
                ->references('id')
                ->on('users');
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::drop('taskfollowers');
	}

}
