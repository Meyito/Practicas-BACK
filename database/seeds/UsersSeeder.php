<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {

        $users = [
            [
                "username" => "admin",
                "password" => Hash::make("12345"),
                "secretary_id" => 1,
                "name" => "Administrador",
                "role_id" => 1
            ],
            [
                "username" => "planeacion",
                "password" => Hash::make("12345"),
                "secretary_id" => 1,
                "name" => "Alejandro Rendon",
                "role_id" => 3
            ],
            [
                "username" => "secretaria",
                "password" => Hash::make("12345"),
                "secretary_id" => 1,
                "name" => "Will Carstairs",
                "role_id" => 2
            ]
        ];

        DB::table('users')->insert($users);
    }

}