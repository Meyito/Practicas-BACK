<?php

use Illuminate\Database\Seeder;

class AdminUnitTypeSeeder
        extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {

        $administrative_unit_types = [
            [
                "name" => "Barrio",
                "id" => 1,                
            ],
            [
                "name" => "Vereda",
                "id" => 2,                
            ],
            [
                "name" => "Centro Poblado",
                "id" => 3,                
            ],
            [
                "name" => "Area Reserva",
                "id" => 4,                
            ],
            [
                "name" => "Cabecera Municipal",
                "id" => 5,                
            ],
            [
                "name" => "Corregimiento",
                "id" => 6,                
            ],
            [
                "name" => "Diferendo",
                "id" => 7,                
            ],
            [
                "name" => "Resguardo",
                "id" => 8,                
            ],
        ];

        DB::table('administrative_unit_types')->insert($administrative_unit_types);
    }

}
