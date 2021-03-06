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
            [
                "view_name" => "actual-development-plan",
                "id" => "7"
            ],
            [
                "view_name" => "activities",
                "id" => "8"
            ],
            [
                "view_name" => "secretary-activities",
                "id" => "9"
            ],
            [
                "view_name" => "statistics",
                "id" => "10"
            ],
            [
                "view_name" => "secretary-statistics",
                "id" => "11"
            ],
            [
                "view_name" => "activity-statistics",
                "id" => "12"
            ],
            [
                "view_name" => "projects",
                "id" => "13"
            ],
            [
                "view_name" => "secretary-projects",
                "id" => "14"
            ],
            [
                "view_name" => "programs",
                "id" => "15"
            ],
            [
                "view_name" => "territorial-list",
                "id" => "16"
            ],
            [
                "view_name" => "password",
                "id" => "17"
            ],
        ];

        DB::table('views')->insert($views);
    }

}