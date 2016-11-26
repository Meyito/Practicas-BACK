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
                "label" => "Personas",
                "column" => "ch.person_id"
            ],
            [
                "label" => "Corregimiento",
                "column" => "ch.algo"
            ],
            [
                "label" => "Proyecto",
                "column" => "p.id"
            ]
        ];

        DB::table('counters')->insert($counters);
    }

}
