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
            ]
        ];

        DB::table('users')->insert($users);
    }

}