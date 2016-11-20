<?php

use Illuminate\Database\Seeder;

class IdentificationTypeSeeder
        extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {

        $identificationTypes = [
            [
                "name" => "Cédula de Ciudadanía",
                "abbreviation" => "CC"
            ],
            [
                "name" => "Cédula de Extranjería",
                "abbreviation" => "CE"
            ],
            [
                "name" => "PA",
                "abbreviation" => "PA"
            ],
            [
                "name" => "Número Único de Identificación",
                "abbreviation" => "NUI"
            ],
            [
                "name" => "Registro Civil",
                "abbreviation" => "RC"
            ],
            [
                "name" => "Tarjeta de Identidad",
                "abbreviation" => "TI"
            ],
            [
                "name" => "SD",
                "abbreviation" => "SD"
            ],
        ];

        DB::table('identification_types')->insert($identificationTypes);
    }

}
