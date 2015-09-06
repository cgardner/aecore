<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddCompanyToRfi extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(
            'rfis',
            function (Blueprint $table) {
                $addCompanyId = $table->integer('company_id', false, true)
                    ->after('project_id');


                $company = DB::table('companys')->select('id')
                    ->first();
                if (isset($company->id)) {
                    $addCompanyId->default($company->id);
                }

                $table->foreign('company_id')
                    ->references('id')
                    ->on('companys')
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
        Schema::table(
            'rfis',
            function (Blueprint $table) {
                $table->dropForeign('rfis_company_id_foreign');

                $table->dropColumn('company_id');
            }
        );
    }

}
