<?php

use Illuminate\Database\Seeder;

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
                "password" => "12345",
                "secretary_id" => 1
            ]
        ];

        DB::table('users')->insert($users);
    }

}
