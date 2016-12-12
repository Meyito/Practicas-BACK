<?php

namespace App\Repositories;
use DB;
use App\Exceptions\TransactionException;
use App\Models\Project;
use App\Models\DevelopmentPlan;
use App\Models\Dimention;
use App\Models\Axe;
use App\Models\Program;
use App\Models\Subprogram;
use Exception;

/**
 * Description of ProjectRepository
 *
 * @author Melissa Delgado
 */
class ProjectRepository extends EloquentRepository {

    protected $model = "App\Models\Project";
    protected $filterColumns = [
        "status",
        "development_plan_id"
    ];

    protected $leftJoins = [
        [
            "table" => "subprograms",
            "localColumn" => "subprogram_id",
            "foreignColumn" => "subprograms.id"
        ],
        [
            "table" => "programs",
            "localColumn" => "program_id",
            "foreignColumn" => "programs.id"
        ],
        [
            "table" => "axes",
            "localColumn" => "axe_id",
            "foreignColumn" => "axes.id"
        ],
        [
            "table" => "dimentions",
            "localColumn" => "dimention_id",
            "foreignColumn" => "dimentions.id"
        ],
        [
            "table" => "development_plans",
            "localColumn" => "development_plan_id",
            "foreignColumn" => "development_plans.id"
        ],
    ];

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
            "code" => $row['codigo_seppi'],
            "name" => $row['nombre_proyecto'],
            "description" => $row['descripcion'],
            "subprogram_id" => $this->parseSubprogram( $row['codigo_subprograma'] ),
            "status" => "Activo",
        ];

        if (!empty($this->errors)) {
            throw new TransactionException($this->errors,
            "Se encontraron errores en la linea");
        }

        return $response;
    }

    private function parseSubprogram($code){
        if( is_null($code) ){
            $this->errors[] = "No se suministró el código del subprograma";
            return null;
        }

        $codes = explode(".", $code);

        if(count($codes) != 4){
            $this->errors[] = "El código del subprograma es inválido";
            return null;
        }

        $development_plan = DevelopmentPlan::all()->last()->id;

        $dimention = Dimention::where([
                    ['development_plan_id', '=', $development_plan],
                    ['code', '=', $codes[0] ]
                ])->first();

        if( !$dimention ){
            $this->errors[] = "No se encontró una dimensión con el código " . $codes[0];
            return null;
        }
        
        $axe = Axe::where([
                    ['dimention_id', '=', $dimention->id],
                    ['code', '=', $codes[1] ]
                ])->first();

        if( !$axe ){
            $this->errors[] = "No se encontró un eje con el código " . $codes[1];
            return null;
        }

        $program = Program::where([
                    ['axe_id', '=', $axe->id],
                    ['code', '=', $codes[2] ]
                ])->first();

        if( !$program ){
            $this->errors[] = "No se encontró un programa con el código " . $codes[2];
            return null;
        }

        $subprogram = Subprogram::where([
                    ['program_id', '=', $program->id],
                    ['code', '=', $codes[3] ]
                ])->first();

        if( !$subprogram ){
            $this->errors[] = "No se encontró un subprograma con el código " . $codes[3];
            return null;
        }

        return $subprogram->id;
    }

    public function save($data) {
        $project = new Project($data);
        
        if (!$project->save()) {
            throw new TransactionException($project->getErrors(),
            "Ocurrió un error en la creación del Proyecto");
        }
    }

}
