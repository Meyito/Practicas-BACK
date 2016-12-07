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
                "role_id" => 2,
                "view_id" => 1,
            ],
            [
                "role_id" => 3,
                "view_id" => 1,
            ],
            [
                "role_id" => 1,
                "view_id" => 2,
            ],
        ];

        DB::table('role_views')->insert($role_views);
    }

}