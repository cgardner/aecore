<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateRfiTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'rfis',
            function (Blueprint $table) {
                $table->bigInteger('id', true, true);
                $table->bigInteger('project_id', false, true);
                $table->bigInteger('assigned_user_id', false, true);
                $table->string('subject');
                $table->date('due_date');
                $table->enum('priority', ['HIGH', 'MEDIUM', 'LOW']);
                $table->enum('cost_impact', ['YES', 'NO', 'TBD']);
                $table->float('cost_impact_amount')
                    ->nullable();
                $table->enum('schedule_impact', ['YES', 'NO', 'TBD']);
                $table->integer('schedule_impact_days')
                    ->nullable();
                $table->string('references');
                $table->string('origin');
                $table->string('question');
                $table->boolean('draft');
                $table->bigInteger('created_by', false, true);
                $table->bigInteger('updated_by', false, true);
                $table->bigInteger('deleted_by', false, true)
                    ->nullable();
                $table->timestamps();
                $table->softDeletes();

                $table->foreign('project_id')
                    ->references('id')
                    ->on('projects')
                    ->onDelete('cascade');

                $table->foreign('assigned_user_id')
                    ->references('id')
                    ->on('users')
                    ->onDelete('cascade');
                $table->foreign('created_by')
                    ->references('id')
                    ->on('users')
                    ->onDelete('cascade');
                $table->foreign('updated_by')
                    ->references('id')
                    ->on('users')
                    ->onDelete('cascade');
                $table->foreign('deleted_by')
                    ->references('id')
                    ->on('users')
                    ->onDelete('cascade');
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
        Schema::drop('rfis');
    }

}
