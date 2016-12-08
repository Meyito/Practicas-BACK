<?php

use Illuminate\Database\Seeder;

class ViewsSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {

        $views = [
            [
                "view_name" => "dashboard",
                "id" => "1"
            ],
            [
                "view_name" => "users",
                "id" => "2"
            ],
            [
                "view_name" => "contracts",
                "id" => "3"
            ],
            [
                "view_name" => "territorial-entities",
                "id" => "4"
            ],
            [
                "view_name" => "secretaries",
                "id" => "5"
            ],
            [
                "view_name" => "development-plan",
                "id" => "6"
            ],
        ];

        DB::table('views')->insert($views);
    }

}