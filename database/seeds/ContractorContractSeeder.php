<?php

use Illuminate\Database\Seeder;

class ContractorContractSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {

        $contractor_contracts = [
            [
                "contractor_id" => 1,
                "contract_id" => 1,               
            ]
        ];

        DB::table('contractor_contracts')->insert($contractor_contracts);
    }

}
