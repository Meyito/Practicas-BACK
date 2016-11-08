<?php

use Illuminate\Database\Seeder;

class GenderSeeder
        extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {

        $genders = [
            [
                "name" => "Femenino",
            ],
            [
                "name" => "Masculino",
            ],
            [
                "name" => "LGBT",
            ]
        ];

        DB::table('genders')->insert($genders);
    }

}
