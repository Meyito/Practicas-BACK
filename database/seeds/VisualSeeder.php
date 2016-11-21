<?php

use Illuminate\Database\Seeder;

class VisualSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {

        $visual_impairments = [
            [
                "name" => "Discapacidad Visual Parcial",
                "abbreviation" => "1"
            ],
            [
                "name" => "Discapacidad Visual Total",
                "abbreviation" => "2"
            ],
            [
                "name" => "No Aplica",
                "abbreviation" => "0"
            ]
        ];

        DB::table('visual_impairments')->insert($visual_impairments);
    }

}