<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateAxesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('axes', function (Blueprint $table) {
            $table->dropForeign('axes_created_by_foreign');
            $table->dropColumn('created_by');
            $table->dropForeign('axes_dimension_id_foreign');
            $table->dropColumn('dimension_id');
            $table->integer('dimention_id')->unsigned();

            $table->foreign('dimention_id')->references('id')->on('dimentions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('axes', function (Blueprint $table) {
            //
        });
    }
}
