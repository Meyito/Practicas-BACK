<?php

namespace App\Repositories;
use DB;
use App\Exceptions\TransactionException;
use App\Models\DevelopmentPlan;
use App\Models\Activity;
use App\Models\Characterization;
use Exception;

/**
 * Description of ActivityRepository
 *
 * @author Melissa Delgado
 */
class ActivityRepository extends EloquentRepository {

    protected $model = "App\Models\Activity";

    public function bulkStore($data, $secretary) {
        $errorsArray = [];
        $response = [];
        $response["success"] = true;
        $connection = DB::connection();

        $connection->beginTransaction();

        foreach ($data as $key => $row) {

            try {
                $parsedRow = $this->parseRow($row);
                $parsedRow["secretary_id"] = $secretary;
                $response["id"] = $this->saveActivity($parsedRow);
            } catch (TransactionException $exc) {
                $row = $key + 1;
                $errorsArray["Fila {$row}"] = $exc->getErrorsArray();
            }
        }

        $errorsCount = count($errorsArray);

        if ($errorsCount) {
            $connection->rollBack();
            $errorsArray["success"] = false;
            return $errorsArray;
        }

        $connection->commit();
        return $response;
    }

    private function parseRow($row) {
        $this->errors = [];

        $contract_id = $this->parseData( $row['contrato'], \App\Models\Contract::class, 'code', 'Contrato' );
        $contractor_id = $this->parseData( $row['contratista'], \App\Models\Contractor::class, 'identification_number', 'Contratista' );

        if (!empty($this->errors)) {
            throw new TransactionException($this->errors,
            "Se encontraron errores en la linea");
        }
        
        $response = [
            "description" => $row['nombre_actividad'],
            "code" => $row['cod_actividad'],
            "date" => $row['fecha'],
            "rubro" => $row['rubro'],
            "registro_pptal" => $row['registro_pptal'],
            "project_id" => $this->parseData( $row['cod_proyecto'], \App\Models\Project::class,'code', 'Proyecto' ),
            "goal_id" => $this->parseGoal( $row['cod_meta'], \App\Models\Goal::class),
            "contractor_contract_id" => $this->parseContract($contract_id, $contractor_id),
            "administrative_unit_id" => $this->parseLocation($row['localizacion'])
        ];

        if (!empty($this->errors)) {
            throw new TransactionException($this->errors,
            "Se encontraron errores en la linea");
        }

        return $response;
    }

    private function parseLocation($code){
        if( is_null($code) ){
            $this->errors[] = "No se suministró el código de la Localización";
            return null;
        }

        $codes = explode(".", $code);

        if(count($codes) != 4){
            $this->errors[] = "El código de la Localización es inválido";
            return null;
        }

        $result = DB::select("SELECT au.id from administrative_units au
            LEFT JOIN areas a ON a.id=au.area_id
            LEFT JOIN area_types aty ON a.area_type_id=aty.id
            LEFT JOIN municipalities m ON m.id=a.municipality_id
            LEFT JOIN zones z ON z.id=m.zone_id
            LEFT JOIN departments d ON d.id=z.department_id
            LEFT JOIN sisben_zones sz ON sz.id= aty.sisben_zone_id
            WHERE d.id = {$codes[0]}
            AND m.code = {$codes[1]}
            AND sz.code = {$codes[2]}
            AND au.sisben_code={$codes[3]}");

        if( !count($result) ){
            $this->errors[] = "No se encontró ningúna localización con el código suministrado";
            return null;
        }


        return $result[0]->id;
    }

    private function parseContract($contract_id, $contractor_id){
        $result = DB::select("SELECT id FROM contractor_contracts 
                WHERE contractor_id = {$contractor_id}
                AND contract_id = {$contract_id}");

        if( !count($result) ){
            $this->errors[] = "El contratista asignado no tiene el contrato registrado";
            return null;   
        }

        return $result[0]->id;
    }

    private function parseGoal($code, $modelClass){
        if(is_null($code)){
            $this->errors[] = "No se suministró el código de la Meta";
            return null;
        }

        $codes = explode(".", $code);

        if(count($codes) != 5){
            $this->errors[] = "El código de la meta es inválida";
            return null;
        }

        $development_plan = DevelopmentPlan::orderBy('id', 'desc')->first()->id;

        $dimention = $this->parseDataGoal( $development_plan, \App\Models\Dimention::class, 'development_plan_id', 'Plan de Desarrollo', 'code', $codes[0]);

        if(is_null($dimention)){
            return null;
        }

        $axe = $this->parseDataGoal( $dimention, \App\Models\Axe::class, 'dimention_id', 'dimensión', 'code', $codes[1]);

        if(is_null($axe)){
            return null;
        }

        $program = $this->parseDataGoal( $axe, \App\Models\Program::class, 'axe_id', 'eje', 'code', $codes[2]);

        if(is_null($program)){
            return null;
        }

        $subprogram = $this->parseDataGoal( $program, \App\Models\Subprogram::class, 'program_id', 'progama', 'code', $codes[3]);

        if(is_null($subprogram)){
            return null;
        }

        $goal = $this->parseDataGoal( $subprogram, \App\Models\Goal::class, 'subprogram_id', 'subprograma', 'code', $codes[4]);

        return $goal;
    }

    private function parseData($code, $modelClass, $column, $string){
        if( is_null($code) ){
            $this->errors[] = "No se suministró el " . $string;
            return null;
        }

        $m = $modelClass::where([
                    [$column, '=', $code]
                ])->first();

        if( !$m ){
            $this->errors[] = "No se encontró un " . $string ." con el código " . $code;
            return null;
        }
                
        return $m->id;
    }

    private function parseDataGoal($code, $modelClass, $column, $string, $column2, $code2){
        if( is_null($code) ){
            $this->errors[] = "No se suministró el " . $string;
            return null;
        }

        $m = $modelClass::where([
                    [$column, '=', $code],
                    [$column2, '=', $code2],
                ])->first();

        if( !$m ){
            $this->errors[] = "No se encontró un " . $string ." con el código " . $code2;
            return null;
        }
                
        return $m->id;
    }

    public function saveActivity($data) {
        $activity = new Activity($data);
        
        if (!$activity->save()) {
            throw new TransactionException($activity->getErrors(),
            "Ocurrió un error en la creación de la actividad");
        }

        return $activity->id;
    }

    public function bulkAssistants($data, $idActivity) {
        $errorsArray = [];
        $assistants = [];
        $activity = Activity::find($idActivity);

        $connection = DB::connection();
        $connection->beginTransaction();

        foreach ($data as $key => $row){
            try{
                $parsedRow = $this->parseAssistant($row);
                array_push($assistants, $parsedRow);
            }catch (TransactionException $exc) {
                $row = $key + 1;
                $errorsArray["Fila {$row}"] = $exc->getErrorsArray();
            }
        }

        try{
            $activity->assistants()->attach($assistants);
        }catch (TransactionException $exc) {
            $errorsArray["Error"] = $exc->getErrorsArray();
        }
        

        $errorsCount = count($errorsArray);

        if ($errorsCount) {
            $connection->rollBack();
        
            $activity->delete();
            return $errorsArray;
        }

        $connection->commit();
        return true;
    }

    private function parseAssistant($row){
        $this->errors = [];
        
        $person_data = [
            "identification_type_id" => $this->parseData($row["tipo_identificacion"], \App\Models\IdentificationType::class, "abbreviation", "Tipo de identificación"),
            "identification_number" => $row["numero_documento"]
        ];

        $person_id = $this->savePerson($person_data, \App\Models\Person::class);

        if( is_null($person_id) ){
            throw new TransactionException($this->errors,
            "Se encontraron errores en la linea");
        }

        if( is_null($row["madre_cabeza_hogar"]) ){
            $this->errors[] = "No se especifico la condición de madre cabeza de Hogar";
            throw new TransactionException($this->errors,
            "Se encontraron errores en la linea");
        }

        if( is_null($row["discapacidad_mental"]) ){
            $this->errors[] = "No se especifico la condición de madre discapacidad mental";
            throw new TransactionException($this->errors,
            "Se encontraron errores en la linea");
        }

        $characterization_data = [
            "person_id" => $person_id,
            "first_name" => $row["nombres"],
            "last_name" => $row["primer_apellido"],
            "second_last_name" => $row["segundo_apellido"],
            "age" => $row["edad"],
            "is_mentally_disabled" => $row["discapacidad_mental"],
            "age_range_id" => $this->parseAgeRange($row["edad"], \App\Models\AgeRange::class),
            "gender_id" => $this->parseData($row["genero"], \App\Models\Gender::class, "abbreviation", "Genero"),
            "special_condition_id" => $this->parseData($row["condicion_especial"], \App\Models\SpecialCondition::class, "abbreviation", "Condición Especial"),
            "hearing_impairment_id" => $this->parseData($row["discapacidad_auditiva"], \App\Models\HearingImpairment::class, "abbreviation", "Discapacidad Auditiva"),
            "visual_impairment_id" => $this->parseData($row["discapacidad_visual"], \App\Models\VisualImpairment::class, "abbreviation", "Discapacidad Visual"),
            "motor_disability_id" => $this->parseData($row["discapacidad_motriz"], \App\Models\MotorDisability::class, "abbreviation", "Discapacidad Motriz"),
            "victim_type_id" => $this->parseData($row["tipo_victima"], \App\Models\VictimType::class, "abbreviation", "Tipo de Victima"),
            "ethnic_group_id" => $this->parseData($row["grupo_etnico"], \App\Models\EthnicGroup::class, "abbreviation", "Grupo Etnico"),
            "is_mother_head" => $row["madre_cabeza_hogar"]
        ];

        $characterization_id = $this->saveCharacterization($characterization_data, \App\Models\Characterization::class );

        if (!empty($this->errors)) {
            throw new TransactionException($this->errors,
            "Se encontraron errores en la linea");
        }

        return $characterization_id;
    }

    private function parseAgeRange($age, $modelClass){
        if( is_null($age) ){
            $this->errors[] = "No se suministró la edad de la persona";
            return null;
        }

        $model = $modelClass::where([
                    ['max_age', '>=', $age],
                    ['min_age', '<=', $age]
                ])->first();

        if (!$model) {
            $model = $modelClass::create($data);

            if(!$model){
                $this->errors[] = "Ocurrió un error al guardar la persona";
                return null;
            }
        }

        return $model->id;
    }

    private function saveCharacterization($data, $modelClass ){
        if( is_null($data["person_id"]) || is_null($data["first_name"]) || is_null($data["last_name"]) || is_null($data["second_last_name"]) || is_null($data["age"]) || is_null($data["is_mentally_disabled"]) || is_null($data["age_range_id"]) || is_null($data["gender_id"]) || is_null($data["special_condition_id"]) || is_null($data["hearing_impairment_id"]) || is_null($data["visual_impairment_id"]) || is_null($data["motor_disability_id"]) || is_null($data["victim_type_id"]) || is_null($data["ethnic_group_id"]) || is_null($data["is_mother_head"]) ){
            $this->errors[] = "No se suministró la información completa de la caracterización";
            return null;
        }

        $data["is_mother_head"] = $data["is_mother_head"] == 0 ? 0 : 1;
        $data["is_mentally_disabled"] = $data["is_mentally_disabled"] == 0 ? 0 : 1;

        $model = $modelClass::where([
                    ['person_id', '=', $data["person_id"] ],
                    ['age_range_id', '=', $data["age_range_id"] ],
                    ['gender_id', '=', $data["gender_id"] ],
                    ['special_condition_id', '=', $data["special_condition_id"] ],
                    ['hearing_impairment_id', '=', $data["hearing_impairment_id"] ],
                    ['visual_impairment_id', '=', $data["visual_impairment_id"] ],
                    ['motor_disability_id', '=', $data["motor_disability_id"] ],
                    ['victim_type_id', '=', $data["victim_type_id"] ],
                    ['ethnic_group_id', '=', $data["ethnic_group_id"] ],
                    ['first_name', '=', $data["first_name"] ],
                    ['last_name', '=', $data["last_name"] ],
                    ['second_last_name', '=', $data["second_last_name"] ],
                    ['age', '=', $data["age"] ],
                    ['is_mentally_disabled', '=', $data["is_mentally_disabled"] ],
                    ['is_mother_head', '=', $data["is_mother_head"] ]
                ])->first();

        if (!$model) {
            $model = new Characterization($data);

            if ( !$model->save() ) {
                throw new TransactionException($model->getErrors(),
                "Ocurrió un error en la creación de la caracterización");
            }
        }

        return $model->id;
    }

    private function savePerson($data, $modelClass){
        if( is_null($data["identification_type_id"]) ){
            return null;
        }

        if( is_null($data["identification_number"]) ){
            $this->errors[] = "No se suministró el número de identificación";
            return null;
        }

        $model = $modelClass::where([
                    ['identification_type_id', '=', $data["identification_type_id"]],
                    ['identification_number', '=', $data["identification_number"]]
                ])->first();

        if (!$model) {
            $model = $modelClass::create($data);

            if(!$model){
                $this->errors[] = "Ocurrió un error al guardar la persona";
                return null;
            }
        }

        return $model->id;
    }
}