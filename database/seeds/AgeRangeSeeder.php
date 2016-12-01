<?php

use Illuminate\Database\Seeder;

class AgeRangeSeeder
        extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {

        $age_range = [
            [
                "id" => 1,
                "name" => "Primera Infancia",
                "min_age" => 0,
                "max_age" => 5
            ],
            [
                "id" => 2,
                "name" => "Segunda Infancia",
                "min_age" => 6,
                "max_age" => 12
            ],
            [
                "id" => 3,
                "name" => "Adolescencia",
                "min_age" => 13,
                "max_age" => 17
            ],
            [
                "id" => 4,
                "name" => "Juventud",
                "min_age" => 18,
                "max_age" => 24
            ],
            [
                "id" => 5,
                "name" => "Adulto Mayor",
                "min_age" => 60,
                "max_age" => 150
            ],
            [
                "id" => 6,
                "name" => "Adulto",
                "min_age" => 25,
                "max_age" => 59
            ],
        ];

        DB::table('age_range')->insert($age_range);
    }

}
