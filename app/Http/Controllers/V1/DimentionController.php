<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Dimention;
use App\Repositories\DimentionRepository as DimentionRepo;
use Illuminate\Http\Response as IlluminateResponse;

/**
 *
 * @author Melissa Delgado
 */

class DimentionController extends Controller {

    private $dimention;

    function __construct(DimentionRepo $dimentionRepo) {
        $this->dimention = $dimentionRepo;
    }

    public function show(Request $request, $id) {
        $relationships = $request->get('relationships', null);
        $dimention = $this->dimention->find($id, $relationships);
        return response()->json($dimention);
    }

    public function index(Request $request) {
        $options = $request->all() ?: [];
        return response()->json($this->dimention->get($options));
    }

    public function store(Request $request) {
        $data = $request->all();

        $dimention = new Dimention($data);

        if ( $this->dimention->create($dimention) ) {
            return response()->json($dimention);
        }

        return response()->json($dimention->getErrors(),
            IlluminateResponse::HTTP_BAD_REQUEST);
    }

}
