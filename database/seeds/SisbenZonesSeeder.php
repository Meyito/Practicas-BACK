<?php

use Illuminate\Database\Seeder;

class SisbenZonesSeeder
        extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {

        $sisben_zones = [
            [
                "name" => "Rural",
                "code" => 2,                
            ],
            [
                "name" => "Urbana",
                "code" => 1,                
            ],

        ];

        DB::table('sisben_zones')->insert($sisben_zones);
    }

}
