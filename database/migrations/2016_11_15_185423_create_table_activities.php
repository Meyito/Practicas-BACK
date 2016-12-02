<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableActivities extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activities', function (Blueprint $table) {
            $table->increments('id');
            $table->date('date');
            $table->integer('code');
            $table->string('description');
            $table->string('rubro');
            $table->string('registro_pptal');
            $table->integer('project_id')->unsigned();
            $table->integer('goal_id')->unsigned();
            $table->integer('administrative_unit_id')->unsigned();
            $table->timestamps();

            $table->foreign('project_id')
            ->references('id')
            ->on('projects');

            $table->foreign('goal_id')
            ->references('id')
            ->on('goals');

            $table->foreign('administrative_unit_id')
            ->references('id')
            ->on('administrative_units');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('activities');
    }
}
