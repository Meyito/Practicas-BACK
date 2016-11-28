<?php

use Illuminate\Database\Seeder;

class HearingSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {

        $hearing_impairments = [
            [
                "name" => "Discapacidad Auditiva Parcial",
                "abbreviation" => "1"
            ],
            [
                "name" => "Discapacidad Auditiva Total",
                "abbreviation" => "2"
            ],
            [
                "name" => "No Aplica",
                "abbreviation" => "0"
            ]
        ];

        DB::table('hearing_impairments')->insert($hearing_impairments);
    }

}