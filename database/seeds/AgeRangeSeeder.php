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
                "name" => "Primera Infancia",
                "min_age" => 0,
                "max_age" => 5
            ],
            [
                "name" => "Segunda Infancia",
                "min_age" => 6,
                "max_age" => 12
            ],
            [
                "name" => "Adolescencia",
                "min_age" => 13,
                "max_age" => 17
            ],
            [
                "name" => "Juventud",
                "min_age" => 18,
                "max_age" => 24
            ],
            [
                "name" => "Adulto Mayor",
                "min_age" => 60,
                "max_age" => 150
            ],
            [
                "name" => "Adulto",
                "min_age" => 25,
                "max_age" => 59
            ],
        ];

        DB::table('age_range')->insert($age_range);
    }

}
