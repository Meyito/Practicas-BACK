<?php

use Illuminate\Database\Seeder;

class SecretariesSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {

        $secretaries = [
            [
                "name" => "Secretaría de Tic",
            ]
        ];

        DB::table('secretaries')->insert($secretaries);
    }

}
