<?php

namespace App\Repositories;
use DB;
use App\Exceptions\TransactionException;
use App\Models\AdministrativeUnit;
use App\Models\AdministrativeUnitType;
use App\Models\Municipality;
use App\Models\Area;
use Exception;

/**
 * Description of AdministrativeUnitRepository
 *
 * @author Melissa Delgado
 */
class AdministrativeUnitRepository extends EloquentRepository {

    protected $model = "App\Models\AdministrativeUnit";

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
            "name" => $row['nombre'],
            "sisben_code" => $row['codigo_sisben'],
            "area_id" => $this->parseArea( $row['cod_municipio'], $row['cod_zona'], \App\Models\Area::class),
            "administrative_unit_type_id" => $this->parseData( $row['tipo'], \App\Models\AdministrativeUnitType::class,'id', 'Tipo de Unidad Administrativa' )
        ];

        if (!empty($this->errors)) {
            throw new TransactionException($this->errors,
            "Se encontraron errores en la linea");
        }

        return $response;
    }

    private function parseArea($code, $code2, $modelClass){
        if( is_null($code) ){
            $this->errors[] = "No se suministró el código del Municipio";
            return null;
        }

        if( is_null($code2) ){
            $this->errors[] = "No se suministró el código del Area";
            return null;
        }

        $municipality_id = $this -> parseData($code, \App\Models\Municipality::class, 'code', 'municipio');

        if(!is_null($municipality_id)){
            $m = $modelClass::where([
                    ['municipality_id', '=', $municipality_id],
                    ['code', '=', $code2]
                ])->first();

            if( !$m ){
                $this->errors[] = "No se encontró un Area con el código y municipio suministrados.";
                return null;
            }
                    
            return $m->id;

        }

        return null;
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
        $administrative_unit = new AdministrativeUnit($data);
        
        if (!$administrative_unit->save()) {
            throw new TransactionException($administrative_unit->getErrors(),
            "Ocurrió un error en la creación de Area Administrativa");
        }
    }

}