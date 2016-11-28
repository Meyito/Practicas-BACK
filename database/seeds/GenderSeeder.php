<?php

use Illuminate\Database\Seeder;

class GenderSeeder
        extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {

        $genders = [
            [
                "name" => "Femenino",
                "abbreviation" => "F"
            ],
            [
                "name" => "Masculino",
                "abbreviation" => "M"
            ],
            [
                "name" => "LGBT",
                "abbreviation" => "L"
            ]
        ];

        DB::table('genders')->insert($genders);
    }

}
