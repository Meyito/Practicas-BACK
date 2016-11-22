<?php

namespace App\Repositories;
use DB;
use App\Exceptions\TransactionException;
use App\Models\Area;
use App\Models\AreaType;
use App\Models\Municipality;
use Exception;

/**
 * Description of AreaRepository
 *
 * @author Melissa Delgado
 */
class AreaRepository extends EloquentRepository {

    protected $model = "App\Models\Area";

    public function bulkStore($data) {
        $errorsArray = [];
        $connection = DB::connection();

        $connection->beginTransaction();

        foreach ($data as $key => $row) {

            try {
                $parsedRow = $this->parseRow($row);
                $this->create($parsedRow);
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
            "code" => $row['cod_area'],
            "name" => $row['nombre_area'],
            "municipality_id" => $this->parseData( $row['cod_municipio'], \App\Models\Municipality::class, 'code','municipio' ),
            "area_type_id" => $this->parseData( $row['tipo_area'], \App\Models\AreaType::class,'code', 'Tipo de Area' )
        ];

        if (!empty($this->errors)) {
            throw new TransactionException($this->errors,
            "Se encontraron errores en la linea");
        }

        return $response;
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

    public function create($data) {
        $area = new Area($data);
        
        if (!$area->save()) {
            throw new TransactionException($area->getErrors(),
            "Ocurrió un error en la creación del Municipio");
        }
    }

}