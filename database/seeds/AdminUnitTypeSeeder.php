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

        ];

        DB::table('administrative_unit_types')->insert($administrative_unit_types);
    }

}
