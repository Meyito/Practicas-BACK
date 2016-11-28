<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCounterFiltersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('counter_filters', function (Blueprint $table) {
            
            $table->increments('id');
            $table->integer('filter_id')->unsigned();
            $table->integer('counter_id')->unsigned();
            
            $table->foreign('filter_id')
            ->references('id')
            ->on('filters');
            $table->foreign('counter_id')
            ->references('id')
            ->on('counters');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('counter_filters');
    }
}
