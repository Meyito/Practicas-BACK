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
                "id" => 1,
                "sisben_zone_id" => 2                
            ],
            [
                "name" => "Unidad Funcional",
                "id" => 2, 
                "sisben_zone_id" => 2               
            ],
            [
                "name" => "Resguardo",
                "id" => 3,
                "sisben_zone_id" => 2                
            ],
            [
                "name" => "Zona",
                "id" => 4, 
                "sisben_zone_id" => 2               
            ],
            [
                "name" => "Rural Disperso",
                "id" => 5, 
                "sisben_zone_id" => 2               
            ],
            [
                "name" => "Comuna",
                "id" => 6, 
                "sisben_zone_id" => 12              
            ],
            [
                "name" => "Cabecera Municipal",
                "id" => 7, 
                "sisben_zone_id" => 12              
            ],

        ];

        DB::table('area_types')->insert($area_types);
    }

}
