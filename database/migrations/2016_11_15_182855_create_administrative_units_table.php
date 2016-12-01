<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdministrativeUnitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('administrative_units', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('code');
            $table->string('name');
            $table->integer('sisben_code');
            $table->integer('area_id')->unsigned();
            $table->integer('administrative_unit_type_id')->unsigned();
            $table->timestamps();

            $table->foreign('area_id')
            ->references('id')
            ->on('areas');

            $table->foreign('administrative_unit_type_id')
            ->references('id')
            ->on('administrative_unit_types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('administrative_units');
    }
}
