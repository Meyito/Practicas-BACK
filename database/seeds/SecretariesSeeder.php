<?php

use Illuminate\Database\Seeder;

class SecretariesSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {

        $secretaries = [
            [
                "name" => "Secretaría de Atención Integral a Victimas",
                "id" => 1
            ],[
                "name" => "Secretaría de Planeación y Desarrollo Territorial",
                "id" => 2
            ],[
                "name" => "Secretaría de Tecnologías de la Información y Comunicaciones",
                "id" => 3
            ],[
                "name" => "Secretaría General",
                "id" => 4
            ],[
                "name" => "Secretaría Privada",
                "id" => 5
            ],[
                "name" => "Secretaría de Agua Potable y Saneamiento Básico",
                "id" => 6
            ],[
                "name" => "Secretaría de Cultura",
                "id" => 7
            ],[
                "name" => "Secretaría de Desarollo Económico",
                "id" => 8
            ],[
                "name" => "Secretaría de Desarrollo Social",
                "id" => 9
            ],[
                "name" => "Secretaría de Educación",
                "id" => 10
            ],[
                "name" => "Secretaría de Fronteras y Cooperación Internacional",
                "id" => 11
            ],[
                "name" => "Secretaría de Gobierno",
                "id" => 12
            ],[
                "name" => "Secretaría de Hacienda",
                "id" => 13
            ],[
                "name" => "Secretaría de Infraestructura",
                "id" => 14
            ],[
                "name" => "Secretaría de la Mujer",
                "id" => 15
            ],[
                "name" => "Secretaría de Minas y Energía",
                "id" => 16
            ],[
                "name" => "Secretaría de Tránsito",
                "id" => 17
            ],[
                "name" => "Secretaría de Vivienda y Medio Ambiente",
                "id" => 18
            ],[
                "name" => "Secretaría Jurídica",
                "id" => 19
            ]
        ];

        DB::table('secretaries')->insert($secretaries);
    }

}
