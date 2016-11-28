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
                "label" => "Género",
                "column" => "g.id",
                "endpoint" => "genders"
            ],
            [
                "label" => "Rango Edad",
                "column" => "ar.id",
                "endpoint" => "age-range"
            ],
            [
                "label" => "Condición Especial",
                "column" => "sc.id",
                "endpoint" => "special-conditions"
            ],
            [
                "label" => "Discapacidad Auditiva",
                "column" => "hi.id",
                "endpoint" => "hearing-impairments"
            ],
            [
                "label" => "Discapacidad Visual",
                "column" => "vi.id",
                "endpoint" => "visual-impairments"
            ],
            [
                "label" => "Discapacidad Motriz",
                "column" => "md.id",
                "endpoint" => "motor-disabilities"
            ],
            [
                "label" => "Tipo Víctima",
                "column" => "vt.id",
                "endpoint" => "victim-types"
            ],
            [
                "label" => "Grupo Etnico",
                "column" => "eg.id",
                "endpoint" => "ethnic-groups"
            ],
            [
                "label" => "Madre Cabeza de Hogar",
                "column" => "ch.is_mother_head",
                "endpoint" => "NA"
            ],
            [
                "label" => "Discapacidad Mental",
                "column" => "ch.is_mentally_disabled",
                "endpoint" => "NA"
            ],
        ];

        DB::table('filters')->insert($filters);
    }

}
