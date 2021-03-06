<?php

use Illuminate\Database\Seeder;

class ZoneSeeder
        extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {

        $zones = [
            [
                "name" => "Oriental",
                "code" => 1,
                "department_id" => 54
            ],
            [
                "name" => "Norte",
                "code" => 2,
                "department_id" => 54
            ],
            [
                "name" => "Occidental",
                "code" => 3,
                "department_id" => 54
            ],
            [
                "name" => "Centro",
                "code" => 4,
                "department_id" => 54
            ],
            [
                "name" => "Sur-Occidental",
                "code" => 5,
                "department_id" => 54
            ],
            [
                "name" => "Sur-Oriental",
                "code" => 6,
                "department_id" => 54
            ],
        ];

        DB::table('zones')->insert($zones);
    }

}
