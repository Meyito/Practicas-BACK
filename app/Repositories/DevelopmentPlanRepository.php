<?php

namespace App\Repositories;
use DB;
use App\Exceptions\TransactionException;
use Exception;


/**
 * Description of DevelopmentPlanRepository
 *
 * @author Melissa Delgado
 */
class DevelopmentPlanRepository extends EloquentRepository {

    protected $model = "App\Models\DevelopmentPlan";

    public function bulkStore($data, $id) {

        $errorsArray = [];
        $connection = DB::connection();

        $connection->beginTransaction();

        foreach ($data as $key => $row) {

            try {
                $parsedRow = $this->parseRow($row, $id);
                
                //$this->create($parsedRow);
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

    private function parseRow($row, $id) {
        $this->errors = [];

        $dimention; $axe; $program; $subprogram; $goal;

        $dimention = $this->getResult($row['cod_d'], $row['dimension'], $id,
                     \App\Models\Dimention::class, 'dimension', 'development_plan_id');
        
        if( !is_null($dimention) ){
            $axe = $this->getResult($row['cod_e'], $row['eje'], $dimention -> id,
                     \App\Models\Axe::class, 'eje', 'dimension_id');
        }

        if( !is_null($axe) ){
            $program = $this->getResult($row['cod_p'], $row['programa'], $axe -> id,
                     \App\Models\Program::class, 'programa', 'axe_id');
        }

        if( !is_null($program) ){
            $subprogram = $this->getResult($row['cod_s'], $row['subprograma'], $program -> id,
                     \App\Models\Subprogram::class, 'subprograma', 'program_id');
        }

        if( !is_null($subprogram) ){
            $goal = $this->getResult($row['cod_m'], $row['meta'], $subprogram -> id,
                     \App\Models\Goal::class, 'meta', 'subprogram_id');
        }
        

        $response = [];

        if (!empty($this->errors)) {
            throw new TransactionException($this->errors,
            "Se encontraron errores en la linea");
        }

        /*if (empty($response['specialties']) && empty($response['lines']) && empty($response['systems'])) {
            throw new Exception("No se han agregado sistemas al producto");
        }*/

        return $response;
    }

    private function getResult($code, $name, $foreign, $modelClass, $string, $foreignColumn, $column = 'code' ){
        if( is_null($foreign) ){
            $this->errors[] = "No se suministró el {$foreignColumn}";
            return null;
        }
        
        if (!$code) {
            $this->errors[] = "No se suministró el código de {$string}";
            return null;
        }

        if (!$name) {
            $this->errors[] = "No se suministró {$string}";
            return null;
        }

        $model = $modelClass::where([
                    ['code', '=', $code],
                    [$foreignColumn, '=', $foreign]
                ])->first();

        if (!$model) {
            $data = ["code" => $code, "name" => $name, $foreignColumn => $foreign];

            $model = $modelClass::create($data);

            if(!$model){
                $this->errors[] = "Ocurrió un error al guardar " . "{$string}";
                return null;
            }
        }

        return $model;
    }

    /*public function create($data) {
        DB::connection('central')->beginTransaction();
        $product = new Product($data);
        if (!$product->save()) {
            throw new TransactionException($product->getErrors(),
            "Ocurrió un error en la creación del Producto");
        }

        if (!isset($data['product_systems'])) {
            DB::connection('central')->commit();
            return $product;
        }

        try {
            $product->product_systems()->attach($data['product_systems']);
            DB::connection('central')->commit();
            return $product;
        } catch (Exception $exc) {
            DB::connection('central')->rollBack();
            throw new TransactionException($exc->getMessage(),
            "Ocurrió un error en la creación del Producto");
        }
    }*/



}
