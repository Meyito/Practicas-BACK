<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCharacterizationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('characterizations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('person_id')->unsigned();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('second_last_name');
            $table->integer('age')->unsigned();
            $table->boolean('is_mentally_disabled');
            $table->integer('age_range_id')->unsigned();
            $table->integer('gender_id')->unsigned();
            $table->integer('special_condition_id')->unsigned();
            $table->integer('hearing_impairment_id')->unsigned();
            $table->integer('visual_impairment_id')->unsigned();
            $table->integer('motor_disability_id')->unsigned();
            $table->integer('victim_type_id')->unsigned();
            $table->integer('ethnic_group_id')->unsigned();
            $table->boolean('is_mother_head')->default(false);
            $table->timestamps();

            $table->foreign('person_id')
            ->references('id')
            ->on('people');

            $table->foreign('age_range_id')
            ->references('id')
            ->on('age_range');

            $table->foreign('gender_id')
            ->references('id')
            ->on('genders');

            $table->foreign('special_condition_id')
            ->references('id')
            ->on('special_conditions');

            $table->foreign('hearing_impairment_id')
            ->references('id')
            ->on('hearing_impairments');

            $table->foreign('visual_impairment_id')
            ->references('id')
            ->on('visual_impairments');

            $table->foreign('motor_disability_id')
            ->references('id')
            ->on('motor_disabilities');

            $table->foreign('victim_type_id')
            ->references('id')
            ->on('victim_types');

            $table->foreign('ethnic_group_id')
            ->references('id')
            ->on('ethnic_groups');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('characterizations');
    }
}
