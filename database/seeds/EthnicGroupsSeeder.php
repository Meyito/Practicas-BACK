<?php

use Illuminate\Database\Seeder;

class EthnicGroupsSeeder
        extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {

        $ethnic_groups = [
            [
                "name" => "Indígena",
                "abbreviation" => "I"
            ],
            [
                "name" => "Afrodescendiente",
                "abbreviation" => "A"
            ],
            [
                "name" => "Rom",
                "abbreviation" => "R"
            ],
            [
                "name" => "No Aplica",
                "abbreviation" => "NA"
            ],
        ];

        DB::table('ethnic_groups')->insert($ethnic_groups);
    }

}
