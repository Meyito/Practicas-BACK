<?php

use Illuminate\Database\Seeder;

class FilterSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {

        $counters = [
            [
                "label" => "Personas",
                "column" => "ch.person_id",
                "endpoint" => "projects"
            ],
            [
                "label" => "Corregimiento",
                "column" => "ch.algo",
                "endpoint" => ""
            ],
            [
                "label" => "Proyecto",
                "column" => "p.id",
                "endpoint" => ""
            ]
        ];

        DB::table('counters')->insert($counters);
    }

}
