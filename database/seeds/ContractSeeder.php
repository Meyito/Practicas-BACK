<?php

use Illuminate\Database\Seeder;

class ContractSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {

        $contracts = [
            [
                "code" => "12",
                "init_date" => "2016-01-01",
                "end_date" => "2016-12-31",                
            ]
        ];

        DB::table('contracts')->insert($contracts);
    }

}
