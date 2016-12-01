<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSecretaryProgramsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('secretary_programs', function (Blueprint $table) {
            $table->integer('program_id')->unsigned();
            $table->integer('secretary_id')->unsigned();

            $table->foreign('program_id')
            ->references('id')
            ->on('programs');

            $table->foreign('secretary_id')
            ->references('id')
            ->on('secretaries');

            $table->primary(array('program_id', 'secretary_id'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('secretary_programs');
    }
}
