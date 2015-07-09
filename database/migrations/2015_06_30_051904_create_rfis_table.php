<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateRfisTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \Schema::create(
            'rfis',
            function (Blueprint $table) {
                $table->bigIncrements('id')
                    ->unsigned();
                $table->bigInteger('project_id')
                    ->unsigned();
                $table->integer('created_by');
                $table->string('subject');
                $table->text('question');
                $table->tinyInteger('priority');
                $table->string('originated_from');
                $table->boolean('schedule_impact_flag');
                $table->integer('schedule_impact')
                    ->nullable();
                $table->boolean('cost_impact_flag');
                $table->integer('cost_impact')
                    ->nullable();
                $table->date('due_date');
                $table->timestamps();
                $table->softDeletes();


                $table->foreign('project_id')
                    ->references('id')
                    ->on('projects')
                    ->onDelete('restrict');

                $table->foreign('user_id')
                    ->references('id')
                    ->on('users')
                    ->onDelete('restrict');
            }
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \Schema::drop('rfis');
    }
}
