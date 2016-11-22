<?php

namespace App\Repositories;
use DB;
use App\Exceptions\TransactionException;
use App\Models\DevelopmentPlan;
use App\Models\Activity;
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
        $connection = DB::connection();

        $connection->beginTransaction();

        foreach ($data as $key => $row) {

            try {
                $parsedRow = $this->parseRow($row);
                $this->save($parsedRow);
            } catch (TransactionException $exc) {
                $row = $key + 1;
                $errorsArray["Fila {$row}"] = $exc->getErrorsArray();
            }
        }

        $errorsCount = count($errorsArray);

        if ($errorsCount) {
            $connection->rollBack();
            return $errorsArray;
        }

        $connection->commit();
        return true;
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

    public function save($data) {
        $activity = new Activity($data);
        
        if (!$activity->save()) {
            throw new TransactionException($activity->getErrors(),
            "Ocurrió un error en la creación del Municipio");
        }
    }
}