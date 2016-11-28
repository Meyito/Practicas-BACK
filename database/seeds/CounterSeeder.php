<?php

use Illuminate\Database\Seeder;

class CounterSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {

        $counters = [
            [
                "label" => "Total Personas",
                "column" => "COUNT( DISTINCT(p.id) )"
            ],
            [
                "label" => "Total Municipios",
                "column" => "COUNT( DISTINCT(m.id) )"
            ],
            [
                "label" => "Cuales Municipios",
                "column" => "DISTINCT(m.name)"
            ],
            [
                "label" => "Cuales Proyectos",
                "column" => "DISTINCT(pj.name)"
            ]
        ];

        DB::table('counters')->insert($counters);
    }

}
