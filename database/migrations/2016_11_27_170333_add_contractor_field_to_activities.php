<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddContractorFieldToActivities extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(){
        Schema::table('activities', function (Blueprint $table) {
            $table->integer('contract_id')->unsigned();
            $table->integer('contractor_id')->unsigned();

            $table->foreign('contract_id')
            ->references('id')
            ->on('contracts');
            $table->foreign('contractor_id')
            ->references('id')
            ->on('contractors');
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
