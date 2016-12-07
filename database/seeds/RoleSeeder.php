<?php

use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {

        $roles = [
            [
                "label" => "Administrador",
                "role_name" => "admin",
                "id" => "1"
            ],
            [
                "label" => "Usuario Secretaría",
                "role_name" => "secretaria",
                "id" => "2"
            ],
            [
                "label" => "Usuario Secretaría Planeación",
                "role_name" => "planeacion",
                "id" => "3"
            ],
        ];

        DB::table('roles')->insert($roles);
    }

}