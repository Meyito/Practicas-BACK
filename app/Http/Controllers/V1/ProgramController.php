<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\UserHelper;
use App\Models\Program;
use App\Repositories\ProgramRepository as ProgramRepository;
use Illuminate\Http\Response as IlluminateResponse;

/**
 *
 * @author Melissa Delgado
 */

class ProgramController extends Controller {

    private $program;

    function __construct(ProgramRepository $programRepository) {
        $this->program = $programRepository;
    }

    public function show(Request $request, $id) {
        $relationships = $request->get('relationships', null);
        $program = $this->program->find($id, $relationships);
        return response()->json($program);
    }

    public function index(Request $request) {
        $options = $request->all() ?: [];
        return response()->json($this->program->get($options));
    }

    public function store(Request $request) {
        $data = $request->all();

        $program = new Program($data);

        if ( $this->program->create($program) ) {
            return response()->json($program);
        }

        return response()->json($program->getErrors(),
            IlluminateResponse::HTTP_BAD_REQUEST);
    }

    public function secretaries(Request $request, $id){
        $data = $request->get('secretaries');
        $program = $this->program->find($id);

        if (!$program) {
            return response()->json(["error" => "No existe el programa suministrado"],
                            IlluminateResponse::HTTP_BAD_REQUEST);
        }

        try {
            $program->secretaries()->detach();
            $program->secretaries()->attach($data);
            return response()->json($program);
        } catch (TransactionException $exc) {
            return response()->json($exc->getErrorsArray(),
                            IlluminateResponse::HTTP_BAD_REQUEST);
        }
    }

}
