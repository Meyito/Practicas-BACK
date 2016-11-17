<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAreasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('areas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('code')->unique();
            $table->string('name');
            $table->integer('municipality_id')->unsigned();
            $table->integer('area_type_id')->unsigned();
            $table->timestamps();

            $table->foreign('municipality_id')
            ->references('id')
            ->on('municipalities');

            $table->foreign('area_type_id')
            ->references('id')
            ->on('area_types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('areas');
    }
}
