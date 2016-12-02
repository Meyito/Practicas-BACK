<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContractorContractsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contractor_contracts', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('contractor_id')->unsigned();
            $table->integer('contract_id')->unsigned();

            $table->foreign('contractor_id')
            ->references('id')
            ->on('contractors');

            $table->foreign('contract_id')
            ->references('id')
            ->on('contracts');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Schema::dropIfExists('contractor_contracts');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
