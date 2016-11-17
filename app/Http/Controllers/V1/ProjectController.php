<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\UserHelper;
use App\Models\Project;
use App\Repositories\ProjectRepository as ProjectRepo;
use Illuminate\Http\Response as IlluminateResponse;

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

}
