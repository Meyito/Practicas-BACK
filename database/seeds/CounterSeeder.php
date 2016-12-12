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
                "response" => "El total de personas atendidas ",
                "group_by" => ""
            ],
            [
                "id" => 2,
                "label" => "Total Municipios",
                "column" => "COUNT( DISTINCT(m.id) ) AS total",
                "response" => "El total de municipios donde se atendieron personas",
                "group_by" => ""
            ],
            [
                "id" => 3,
                "label" => "Cuales Municipios",
                "column" => "DISTINCT(m.name) AS municipios",
                "response" => "Los municipios en los que se atendieron personas ",
                "group_by" => ""
            ],
            [
                "id" => 4,
                "label" => "Cuales Proyectos",
                "column" => "DISTINCT(pj.name) AS proyectos",
                "response" => "Los proyectos en los que se atendieron personas ",
                "group_by" => ""
            ],
            [
                "id" => 5,
                "label" => "Total Personas por Secretaria",
                "column" => "COUNT( DISTINCT(p.id) ) AS total, se.id, se.name",
                "response" => "El total de personas atendidas por secretaria ",
                "group_by" => "GROUP BY se.id",
            ],
            [
                "id" => 6,
                "label" => "Total Personas por Municipio",
                "column" => "COUNT( DISTINCT(p.id) ) AS total, m.id, m.name",
                "response" => "El total de personas atendidas por municipio",
                "group_by" => "GROUP BY m.id",
            ],
        ];

        DB::table('counters')->insert($counters);
    }

}
