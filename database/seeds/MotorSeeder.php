<?php

use Illuminate\Database\Seeder;

class MotorSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {

        $motor_disabilities = [
            [
                "name" => "00",
                "abbreviation" => "00"
            ],
            [
                "name" => "01",
                "abbreviation" => "01"
            ],
            [
                "name" => "02",
                "abbreviation" => "02"
            ],
            [
                "name" => "10",
                "abbreviation" => "10"
            ],
            [
                "name" => "11",
                "abbreviation" => "11"
            ],
            [
                "name" => "12",
                "abbreviation" => "12"
            ],
            [
                "name" => "20",
                "abbreviation" => "20"
            ],
            [
                "name" => "21",
                "abbreviation" => "21"
            ],
            [
                "name" => "22",
                "abbreviation" => "22"
            ],
        ];

        DB::table('motor_disabilities')->insert($motor_disabilities);
    }

}