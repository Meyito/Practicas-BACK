<?php

namespace App\Repositories;
use DB;
use App\Exceptions\TransactionException;
use App\Models\Zone;
use App\Models\Municipality;
use Exception;

/**
 * Description of MunicipalityRepository
 *
 * @author Melissa Delgado
 */
class MunicipalityRepository extends EloquentRepository {

    protected $model = "App\Models\Municipality";

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
            "code" => $row['codigo_municipio'],
            "name" => $row['nombre_municipio'],
            "zone_id" => $this->parseZone( $row['zona'] )            
        ];

        if (!empty($this->errors)) {
            throw new TransactionException($this->errors,
            "Se encontraron errores en la linea");
        }

        return $response;
    }

    private function parseZone($zone_id){
        if( is_null($zone_id) ){
            $this->errors[] = "No se suministró el código de la zona";
            return null;
        }

        $zone = Zone::where([
                    ['code', '=', $zone_id]
                ])->first();

        if( !$zone ){
            $this->errors[] = "No se encontró una zona con el código " . $zone_id;
            return null;
        }
                
        return $zone->id;
    }

    public function create($data) {
        $municipality = new Municipality($data);
        
        if (!$municipality->save()) {
            throw new TransactionException($municipality->getErrors(),
            "Ocurrió un error en la creación del Municipio");
        }
    }

}
