<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateRfiAuditsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'rfi_audits',
            function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->bigInteger('rfi_id')
                    ->unsigned();
                $table->integer('user_id')
                    ->unsigned();
                $table->string('state');

                /* Same Columns as rfis */
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


                $table->foreign('rfi_id')
                    ->references('id')
                    ->on('rfis')
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
        Schema::drop('rfi_audits');
    }

}
