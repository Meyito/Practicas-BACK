<?php

use Illuminate\Database\Seeder;

class SpecialConditionSeeder
        extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {

        $special_conditions = [
            [
                "name" => "Indigente",
                "abbreviation" => "I"
            ],
            [
                "name" => "Reintegrado",
                "abbreviation" => "R"
            ],
            [
                "name" => "Otro",
                "abbreviation" => "O"
            ],
            [
                "name" => "Sin condición especial",
                "abbreviation" => "NA"
            ],
        ];

        DB::table('special_conditions')->insert($special_conditions);
    }

}
