<?php

use Illuminate\Database\Seeder;

class AreaTypesSeeder
        extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {

        $area_types = [
            [
                "name" => "Corregimiento",
                "code" => 1,
                "sisben_zone_id" => 2                
            ],
            [
                "name" => "Unidad Funcional",
                "code" => 2, 
                "sisben_zone_id" => 2               
            ],
            [
                "name" => "Resguardo",
                "code" => 3,
                "sisben_zone_id" => 2                
            ],
            [
                "name" => "Zona",
                "code" => 4, 
                "sisben_zone_id" => 2               
            ],
            [
                "name" => "Rural Disperso",
                "code" => 5, 
                "sisben_zone_id" => 2               
            ],
            [
                "name" => "Comuna",
                "code" => 6, 
                "sisben_zone_id" => 1               
            ],
            [
                "name" => "Cabecera Municipal",
                "code" => 7, 
                "sisben_zone_id" => 1               
            ],

        ];

        DB::table('area_types')->insert($area_types);
    }

}
