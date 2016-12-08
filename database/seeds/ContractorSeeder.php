<?php

use Illuminate\Database\Seeder;

class ContractorSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {

        $contractors = [
            [
                "first_name" => "Gabriel",
                "last_name" => "Rojas",
                "identification_number" => 123456789,
                "identification_type_id" => 1,                
            ]
        ];

        DB::table('contractors')->insert($contractors);
    }

}
