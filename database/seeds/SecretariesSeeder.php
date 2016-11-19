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
                "name" => "Secretaría de Atención Integral a Victimas"
            ],[
                "name" => "Secretaría de Planeación y Desarrollo Territorial"
            ],[
                "name" => "Secretaría de Tecnologías de la Información y Comunicaciones"
            ],[
                "name" => "Secretaría General"
            ],[
                "name" => "Secretaría Privada"
            ],[
                "name" => "Secretaría de Agua Potable y Saneamiento Básico"
            ],[
                "name" => "Secretaría de Cultura"
            ],[
                "name" => "Secretaría de Desarollo Económico"
            ],[
                "name" => "Secretaría de Desarrollo Social"
            ],[
                "name" => "Secretaría de Educación"
            ],[
                "name" => "Secretaría de Fronteras y Cooperación Internacional"
            ],[
                "name" => "Secretaría de Gobierno"
            ],[
                "name" => "Secretaría de Hacienda"
            ],[
                "name" => "Secretaría de Infraestructura"
            ],[
                "name" => "Secretaría de la Mujer"
            ],[
                "name" => "Secretaría de Minas y Energía"
            ],[
                "name" => "Secretaría de Tránsito"
            ],[
                "name" => "Secretaría de Vivienda y Medio Ambiente"
            ],[
                "name" => "Secretaría Jurídica"
            ]
        ];

        DB::table('secretaries')->insert($secretaries);
    }

}
