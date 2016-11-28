<?php

use Illuminate\Database\Seeder;

class CounterFilterSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {

        $counter_filter = [
            [
                "counter_id" => "1",
                "filter_id" => "1"
            ],
            [
                "counter_id" => "1",
                "filter_id" => "2"
            ],
            [
                "counter_id" => "1",
                "filter_id" => "3"
            ],
            [
                "counter_id" => "1",
                "filter_id" => "4"
            ],
            [
                "counter_id" => "1",
                "filter_id" => "5"
            ],
            [
                "counter_id" => "1",
                "filter_id" => "6"
            ],
            [
                "counter_id" => "1",
                "filter_id" => "7"
            ],
            [
                "counter_id" => "1",
                "filter_id" => "8"
            ],
            [
                "counter_id" => "1",
                "filter_id" => "9"
            ],
            [
                "counter_id" => "1",
                "filter_id" => "10"
            ],

        ];

        DB::table('counter_filters')->insert($counter_filter);
    }

}
