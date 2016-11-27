<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPivotColumnToActivities extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('activities', function (Blueprint $table) {
            $table->dropForeign('activities_contract_id_foreign');
            $table->dropColumn('contract_id');
            $table->dropForeign('activities_contractor_id_foreign');
            $table->dropColumn('contractor_id');

            $table->integer('contractor_contract_id')->unsigned();

            $table->foreign('contractor_contract_id')
            ->references('id')
            ->on('contractor_contracts');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('activities', function (Blueprint $table) {
            //
        });
    }
}
