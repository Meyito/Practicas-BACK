<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\UserHelper;
use App\Models\Characterization;
use App\Repositories\CharacterizationRepository as CharacterizationRepo;
use Illuminate\Http\Response as IlluminateResponse;

/**
 *
 * @author Melissa Delgado
 */

class CharacterizationController extends Controller {

    private $characterization;

    function __construct(CharacterizationRepo $characterizationRepo) {
        $this->characterization = $characterizationRepo;
    }

    public function show(Request $request, $id) {
        $relationships = $request->get('relationships', null);
        $characterization = $this->characterization->find($id, $relationships);
        return response()->json($characterization);
    }

    public function index(Request $request) {
        $options = $request->all() ?: [];
        return response()->json($this->characterization->get($options));
    }

    public function store(Request $request) {
        $data = $request->all();

        $characterization = new Characterization($data);

        if ( $this->characterization->create($characterization) ) {
            return response()->json($characterization);
        }

        return response()->json($characterization->getErrors(),
            IlluminateResponse::HTTP_BAD_REQUEST);
    }

}
