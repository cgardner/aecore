<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateRfiCommentsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'rfi_comments',
            function (Blueprint $table) {
                $table->increments('id');
                $table->bigInteger('rfi_id', false, true);
                $table->integer('created_by', false, true);
                $table->text('comment');
                $table->timestamps();
                $table->softDeletes();

                $table->foreign('rfi_id')
                    ->references('id')
                    ->on('rfis')
                    ->onDelete('cascade');

                $table->foreign('created_by')
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
        Schema::drop('rfi_comments');
    }

}
