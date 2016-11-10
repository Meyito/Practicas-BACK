<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContractorXPeriodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contractor_periods', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('contractor_id')->unsigned();
            $table->integer('contract_code')->unsigned();
            $table->date('init_date');
            $table->date('end_date');
            $table->timestamps();

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
        Schema::dropIfExists('contractor_periods');
    }
}
