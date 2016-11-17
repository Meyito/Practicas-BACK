<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActivityCharacterizationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activity_characterizations', function (Blueprint $table) {
            $table->integer('activity_id')->unsigned();
            $table->integer('characterization_id')->unsigned();

            $table->foreign('activity_id')
            ->references('id')
            ->on('activities');

            $table->foreign('characterization_id')
            ->references('id')
            ->on('characterizations');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('activity_characterizations');
    }
}
