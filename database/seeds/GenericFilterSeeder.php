<?php

use Illuminate\Database\Seeder;

class GenericFilterSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {

        $generic_filters = [
            [
                "label" => "Plan de Desarrollo",
                "column" => "dp.id"
            ],
            [
                "label" => "Dimensión",
                "column" => "dm.id"
            ],
            [
                "label" => "Eje",
                "column" => "ax.id"
            ],
            [
                "label" => "Secretaria",
                "column" => "se.id"
            ],
            [
                "label" => "Programa",
                "column" => "pg.id"
            ],
            [
                "label" => "Subprograma",
                "column" => "sp.id"
            ]
        ];

        DB::table('generic_filters')->insert($generic_filters);
    }

}
