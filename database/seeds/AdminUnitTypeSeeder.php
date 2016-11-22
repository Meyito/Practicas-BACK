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
                "code" => 1,                
            ],
            [
                "name" => "Vereda",
                "code" => 2,                
            ],
            [
                "name" => "Centro Poblado",
                "code" => 3,                
            ],
            [
                "name" => "Area Reserva",
                "code" => 4,                
            ],
            [
                "name" => "Cabecera Municipal",
                "code" => 5,                
            ],
            [
                "name" => "Centro Poblado",
                "code" => 6,                
            ],
            [
                "name" => "Corregimiento",
                "code" => 7,                
            ],
            [
                "name" => "Diferendo",
                "code" => 8,                
            ],
            [
                "name" => "Resguardo",
                "code" => 9,                
            ],
        ];

        DB::table('administrative_unit_types')->insert($administrative_unit_types);
    }

}
