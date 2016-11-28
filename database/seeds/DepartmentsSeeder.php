<?php

use Illuminate\Database\Seeder;

class DepartmentsSeeder
        extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {

        $departments = [
            [
                "name" => "Norte de Santander",
                "code" => 54
            ]
        ];

        DB::table('departments')->insert($departments);
    }

}
