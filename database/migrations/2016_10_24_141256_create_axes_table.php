<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAxesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('axes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code', 5);
            $table->string('name');
            $table->integer('dimention_id')->unsigned();
            $table->timestamps();

            $table->foreign('dimention_id')
                ->references('id')
                ->on('dimentions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('axes');
    }
}
