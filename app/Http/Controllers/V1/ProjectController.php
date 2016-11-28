<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\UserHelper;
use App\Models\Project;
use App\Repositories\ProjectRepository as ProjectRepo;
use Illuminate\Http\Response as IlluminateResponse;
use Excel;

class ProjectController extends Controller {

    private $project;

    function __construct(ProjectRepo $projectRepo) {
        $this->project = $projectRepo;
    }

    public function show(Request $request, $id) {
        $relationships = $request->get('relationships', null);
        $project = $this->project->find($id, $relationships);
        return response()->json($project);
    }

    public function index(Request $request) {
        $options = $request->all() ?: [];
        return response()->json($this->project->get($options));
    }

    public function store(Request $request) {
        $data = $request->all();

        $project = new Project($data);

        if ( $this->project->create($project) ) {
            return response()->json($project);
        }

        return response()->json($project->getErrors(),
            IlluminateResponse::HTTP_BAD_REQUEST);
    }

    public function update(Request $request, $id) {
        $data = $request->get('project');
        $project = $this->project->find($id);

        if (!$project) {
            return response()->json(["error" => "No existe el proyecto suministrado"],
                            IlluminateResponse::HTTP_BAD_REQUEST);
        }

        try {
            $this->project->update($project, $data);
            return response()->json($project);
        } catch (TransactionException $exc) {
            return response()->json($exc->getErrorsArray(),
                            IlluminateResponse::HTTP_BAD_REQUEST);
        }
    }

    public  function uploadProjects(Request $request){

        $file = $this->getFile($request);

        try {
            $reader = Excel::selectSheetsByIndex(0)->load($file->getRealPath(),
                        null, null, true);

            $results = $this->project->bulkStore( $reader->toArray() );

            if ($results === true) {
                return response()->json(['msg' => 'Se cargaron los proyectos exitosamente.']);
            } else {
                return response()->json($results, IlluminateResponse::HTTP_BAD_REQUEST);
            }
        } catch (Exception $e) {
            return response()->json(["error" => "Ocurrió un error inesperado en la carga del archivo."],
                                IlluminateResponse::HTTP_BAD_REQUEST);
        }
    }

    private function getFile($request) {
        if (!$request->hasFile('file')) {
            return response()->json("Debe suministrar un archivo de proyectos.",
                IlluminateResponse::HTTP_BAD_REQUEST);
        }

        $file = $request->file('file');

        if (!$this->isValid($file)) {
            return response()->json(["error" => "No se cargó un archivo de excel válido."],
                IlluminateResponse::HTTP_BAD_REQUEST);
        }

        return $file;
    }

    private function isValid($file) {
        $validFileTypes = [
            'application/vnd.ms-excel',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
        ];

        if (!in_array($file->getMimeType(), $validFileTypes)) {
            return false;
        }

        return true;
    }

}
