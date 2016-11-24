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

    public function bulkStore($data) {
        $errorsArray = [];
        $response = [];
        $response["success"] = true;
        $connection = DB::connection();

        $connection->beginTransaction();

        foreach ($data as $key => $row) {

            try {
                $parsedRow = $this->parseRow($row);
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

        $response = [
            "description" => $row['nombre_actividad'],
            "code" => $row['cod_actividad'],
            "date" => $row['fecha'],
            "rubro" => $row['rubro'],
            "registro_pptal" => $row['registro_pptal'],
            "project_id" => $this->parseData( $row['cod_proyecto'], \App\Models\Project::class,'code', 'Proyecto' ),
            "goal_id" => $this->parseGoal( $row['cod_meta'], \App\Models\Goal::class),

        ];

        if (!empty($this->errors)) {
            throw new TransactionException($this->errors,
            "Se encontraron errores en la linea");
        }

        return $response;
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

        $development_plan = DevelopmentPlan::all()->last()->id;

        $dimention = $this->parseData( $development_plan, \App\Models\Dimention::class, 'development_plan_id', 'Plan de Desarrollo');

        if(is_null($dimention)){
            return null;
        }

        $axe = $this->parseData( $dimention, \App\Models\Axe::class, 'dimention_id', 'dimensión');

        if(is_null($axe)){
            return null;
        }

        $program = $this->parseData( $axe, \App\Models\Program::class, 'axe_id', 'eje');

        if(is_null($program)){
            return null;
        }

        $subprogram = $this->parseData( $program, \App\Models\Subprogram::class, 'program_id', 'progama');

        if(is_null($subprogram)){
            return null;
        }

        $goal = $this->parseData( $subprogram, \App\Models\Goal::class, 'subprogram_id', 'subprograma');

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
        $person_data = [
            "identification_type_id" => $this->parseData($row["tipo_identificacion"], \App\Models\IdentificationType::class, "abbreviation", "Tipo de identificación"),
            "identification_number" => $row["numero_documento"]
        ];

        $person_id = $this->savePerson($person_data, \App\Models\Person::class);

        if( is_null($person_id) ){
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
            $this->errors[] = "No se suministró el tipo de identificación";
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