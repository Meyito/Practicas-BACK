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
        ];

        DB::table('views')->insert($views);
    }

}