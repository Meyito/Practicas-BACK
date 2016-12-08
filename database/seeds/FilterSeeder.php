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
                "column" => "ch.gender_id",
                "endpoint" => "genders"
            ],
            [
                "id" => 2,
                "label" => "Rango Edad",
                "column" => "ch.age_range_id",
                "endpoint" => "age-range"
            ],
            [
                "id" => 3,
                "label" => "Condición Especial",
                "column" => "ch.special_condition_id",
                "endpoint" => "special-conditions"
            ],
            [
                "id" => 4,
                "label" => "Discapacidad Auditiva",
                "column" => "ch.hearing_impairment_id",
                "endpoint" => "hearing-impairments"
            ],
            [
                "id" => 5,
                "label" => "Discapacidad Visual",
                "column" => "ch.visual_impairment_id",
                "endpoint" => "visual-impairments"
            ],
            [
                "id" => 6,
                "label" => "Discapacidad Motriz",
                "column" => "ch.motor_disability_id",
                "endpoint" => "motor-disabilities"
            ],
            [
                "id" => 7,
                "label" => "Tipo Víctima",
                "column" => "ch.victim_type_id",
                "endpoint" => "victim-types"
            ],
            [
                "id" => 8,
                "label" => "Grupo Etnico",
                "column" => "ch.ethnic_group_id",
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
            [
                "id" => 11,
                "label" => "Número Identificación",
                "column" => "p.identification_number",
                "endpoint" => "NA"
            ],
            [
                "id" => 12,
                "label" => "Zona Sisben",
                "column" => "sz.id",
                "endpoint" => "sisben-zones"
            ],
            [
                "id" => 13,
                "label" => "Municipio",
                "column" => "m.id",
                "endpoint" => "municipalities"
            ],
        ];

        DB::table('filters')->insert($filters);
    }

}
