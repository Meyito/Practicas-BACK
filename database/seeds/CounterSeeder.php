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
                "id" => 1,
                "label" => "Total Personas",
                "column" => "COUNT( DISTINCT(p.id) ) AS total",
                "response" => "El total de personas atendidas "
            ],
            [
                "id" => 2,
                "label" => "Total Municipios",
                "column" => "COUNT( DISTINCT(m.id) ) AS total",
                "response" => "El total de municipios donde se atendieron personas" 
            ],
            [
                "id" => 3,
                "label" => "Cuales Municipios",
                "column" => "DISTINCT(m.name) AS municipios",
                "response" => "Los municipios en los que se atendieron personas "
            ],
            [
                "id" => 4,
                "label" => "Cuales Proyectos",
                "column" => "DISTINCT(pj.name) AS proyectos",
                "response" => "Los proyectos en los que se atendieron personas "
            ]
        ];

        DB::table('counters')->insert($counters);
    }

}
