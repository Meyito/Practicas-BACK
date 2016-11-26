<?php

namespace App\Repositories;
use DB;

/**
 * Description of ContractorRepository
 *
 * @author Melissa Delgado
 */
class ContractorRepository extends EloquentRepository {

    protected $model = "App\Models\Contractor";

    public function addContract($contractor, $data){
        $errorsArray = [];
        $connection = DB::connection();
        $connection->beginTransaction();

        try{
            $contract = $this->parseContract($data, \App\Models\Contract::class);
            $contractor->contracts()->attach($contract);
        }catch (TransactionException $exc) {
            $errorsArray["Error"] = $exc->getErrorsArray();
        }

        $errorsCount = count($errorsArray);

        if ($errorsCount) {
            $connection->rollBack();
            return $errorsArray;
        }

        $connection->commit();
        return true;
    }

    private function parseContract($data, $modelClass){
        $this->errors = [];

        if( is_null($data['code']) || is_null($data['init_date']) || is_null($data['end_date']) ){
            $this->errors[] = "No se suministraron los datos completos del contrato";
            throw new TransactionException($this->errors,
                "Ocurrió un error en la asignación del contrato.");
        }

        $model = $modelClass::where([
                    ['code', '=', $data['code']]
                ])->first();

        if (!$model) {
            $model = $modelClass::create($data);

            if(!$model){
                $this->errors[] = "Ocurrió un error al guardar el contrato";
                throw new TransactionException($this->errors,
                "Ocurrió un error en la asignación del contrato.");
            }
        }

        return $model->id;
    }

}