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
                "name" => "Urbana",
                "id" => 1,     
                "code" => 1,                
            ],
            [
                "name" => "Rural",
                "id" => 2,  
                "code" => 2,                
            ],
        ];

        DB::table('sisben_zones')->insert($sisben_zones);
    }

}
