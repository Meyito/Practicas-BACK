<?php

use Illuminate\Database\Seeder;

class FilterSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {

        $filters = [
            [
                "id" => 1,
                "label" => "Género",
                "column" => "g.id",
                "endpoint" => "genders"
            ],
            [
                "id" => 2,
                "label" => "Rango Edad",
                "column" => "ar.id",
                "endpoint" => "age-range"
            ],
            [
                "id" => 3,
                "label" => "Condición Especial",
                "column" => "sc.id",
                "endpoint" => "special-conditions"
            ],
            [
                "id" => 4,
                "label" => "Discapacidad Auditiva",
                "column" => "hi.id",
                "endpoint" => "hearing-impairments"
            ],
            [
                "id" => 5,
                "label" => "Discapacidad Visual",
                "column" => "vi.id",
                "endpoint" => "visual-impairments"
            ],
            [
                "id" => 6,
                "label" => "Discapacidad Motriz",
                "column" => "md.id",
                "endpoint" => "motor-disabilities"
            ],
            [
                "id" => 7,
                "label" => "Tipo Víctima",
                "column" => "vt.id",
                "endpoint" => "victim-types"
            ],
            [
                "id" => 8,
                "label" => "Grupo Etnico",
                "column" => "eg.id",
                "endpoint" => "ethnic-groups"
            ],
            [
                "id" => 9,
                "label" => "Madre Cabeza de Hogar",
                "column" => "ch.is_mother_head",
                "endpoint" => "NA"
            ],
            [
                "id" => 10,
                "label" => "Discapacidad Mental",
                "column" => "ch.is_mentally_disabled",
                "endpoint" => "NA"
            ],
        ];

        DB::table('filters')->insert($filters);
    }

}
