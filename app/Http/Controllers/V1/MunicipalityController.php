<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\UserHelper;
use App\Models\Municipality;
use App\Repositories\MunicipalityRepository as MunicipalityRepo;
use Illuminate\Http\Response as IlluminateResponse;

class MunicipalityController extends Controller {

    private $municipality;

    function __construct(MunicipalityRepo $municipalityRepo) {
        $this->municipality = $municipalityRepo;
    }

    public function show(Request $request, $id) {
        $relationships = $request->get('relationships', null);
        $municipality = $this->municipality->find($id, $relationships);
        return response()->json($municipality);
    }

    public function index(Request $request) {
        $options = $request->all() ?: [];
        return response()->json($this->municipality->get($options));
    }

    public function store(Request $request) {
        $data = $request->all();

        $municipality = new Municipality($data);

        if ( $this->municipality->create($municipality) ) {
            return response()->json($municipality);
        }

        return response()->json($municipality->getErrors(),
            IlluminateResponse::HTTP_BAD_REQUEST);
    }

}
