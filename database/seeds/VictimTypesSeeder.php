<?php

use Illuminate\Database\Seeder;

class VictimTypesSeeder
        extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {

        $victim_types = [
            [
                "name" => "Tipo 1",
                "abbreviation" => "1"
            ],
            [
                "name" => "Tipo 2",
                "abbreviation" => "2"
            ],
            [
                "name" => "Tipo 3",
                "abbreviation" => "3"
            ],
            [
                "name" => "Tipo 4",
                "abbreviation" => "4"
            ],
            [
                "name" => "Tipo 5",
                "abbreviation" => "5"
            ],
            [
                "name" => "Tipo 6",
                "abbreviation" => "6"
            ],
            [
                "name" => "Tipo 7",
                "abbreviation" => "7"
            ],
        ];

        DB::table('victim_types')->insert($victim_types);
    }

}
