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
                "name" => "Nit",
                "abbreviation" => "NIT"
            ]
        ];

        DB::table('identification_types')->insert($identificationTypes);
    }

}
