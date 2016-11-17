<?php

namespace App\Repositories;

/**
 * Description of DevelopmentPlanRepository
 *
 * @author Francisco Bastos
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

        $response = [
            "dimention_id" => $this->getResult($row['cod_d'], $row['dimension'], $id,
                     \App\Models\Dimention::class, 'dimension', 'development_plan_id') -> id
            /*"name" => $row['dimension'],
            "brand" => $row['marca'],
            "distribution" => $row['distribucion'],
            "tax_type_id" => $this->getResult($row['grupo_contable'],
                    \App\Models\TaxType::class, 'grupo contable')->id,
            "invima" => $row['invima'],
            "product_type_id" => $this->getResult($row['tipo_producto'],
                    \App\Models\ProductType::class, 'tipo de producto')->id,
            "specialties" => $this->getResults($row['especialidades'],
                    \App\Models\Specialty::class, 'especialidad'),
            "lines" => $this->getResults($row['lineas'],
                    \App\Models\Line::class, 'linea'),
            "systems" => $this->getResults($row['sistemas'],
                    \App\Models\System::class, 'sistema'),
            "min_stock" => $row['stock_minimo']*/
        ];

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
        if (!$code) {
            $this->errors[] = "No se suministró el código de {$string}";
            return;
        }

        if (!$name) {
            $this->errors[] = "No se suministró {$string}";
            return;
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
                return;
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
