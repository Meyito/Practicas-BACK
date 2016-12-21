<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\UserHelper;
use App\Models\Subprogram;
use App\Repositories\SubprogramRepository as SubprogramRepo;
use Illuminate\Http\Response as IlluminateResponse;

/**
 *
 * @author Melissa Delgado
 */

class SubprogramController extends Controller {

    private $subprogram;

    function __construct(SubprogramRepo $subprogramRepo) {
        $this->subprogram = $subprogramRepo;
    }

    public function show(Request $request, $id) {
        $relationships = $request->get('relationships', null);
        $subprogram = $this->subprogram->find($id, $relationships);
        return response()->json($subprogram);
    }

    public function index(Request $request) {
        $options = $request->all() ?: [];
        return response()->json($this->subprogram->get($options));
    }

    public function store(Request $request) {
        $data = $request->all();

        $subprogram = new Subprogram($data);

        if ( $this->subprogram->create($subprogram) ) {
            return response()->json($subprogram);
        }

        return response()->json($subprogram->getErrors(),
            IlluminateResponse::HTTP_BAD_REQUEST);
    }

}
