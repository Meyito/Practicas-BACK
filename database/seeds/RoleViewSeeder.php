<?php

use Illuminate\Database\Seeder;

class RoleViewSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {

        $role_views = [
            [
                "role_id" => 1,
                "view_id" => 1,
            ],
            [
                "role_id" => 1,
                "view_id" => 2,
            ],
            [
                "role_id" => 1,
                "view_id" => 3,
            ],
            [
                "role_id" => 1,
                "view_id" => 4,
            ],
            [
                "role_id" => 1,
                "view_id" => 5,
            ],
            [
                "role_id" => 1,
                "view_id" => 17,
            ],
            [
                "role_id" => 2,
                "view_id" => 1,
            ],
            [
                "role_id" => 2,
                "view_id" => 3,
            ],
            [
                "role_id" => 2,
                "view_id" => 7,
            ],
            [
                "role_id" => 2,
                "view_id" => 9,
            ],
            [
                "role_id" => 2,
                "view_id" => 11,
            ],
            [
                "role_id" => 2,
                "view_id" => 12,
            ],
            [
                "role_id" => 2,
                "view_id" => 14,
            ],
            [
                "role_id" => 2,
                "view_id" => 16,
            ],
            [
                "role_id" => 2,
                "view_id" => 17,
            ],
            [
                "role_id" => 3,
                "view_id" => 17,
            ],
            [
                "role_id" => 3,
                "view_id" => 16,
            ],
            [
                "role_id" => 3,
                "view_id" => 1,
            ],
            [
                "role_id" => 3,
                "view_id" => 3,
            ],
            [
                "role_id" => 3,
                "view_id" => 6,
            ],
            [
                "role_id" => 3,
                "view_id" => 8,
            ],
            [
                "role_id" => 3,
                "view_id" => 10,
            ],
            [
                "role_id" => 3,
                "view_id" => 12,
            ],
            [
                "role_id" => 3,
                "view_id" => 13,
            ],
            [
                "role_id" => 3,
                "view_id" => 15,
            ],
        ];

        DB::table('role_views')->insert($role_views);
    }

}