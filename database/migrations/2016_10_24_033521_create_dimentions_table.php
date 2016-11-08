<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDimentionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dimentions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code', 5);
            $table->string('name');
            $table->integer('development_plan_id')->unsigned();
            $table->timestamps();

            $table->foreign('development_plan_id')
            ->references('id')
            ->on('development_plans');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dimentions');
    }
}
