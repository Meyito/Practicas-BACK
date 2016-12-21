<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\UserHelper;
use App\Models\AreaType;
use App\Repositories\AreaTypeRepository as AreaTypeRepo;
use Illuminate\Http\Response as IlluminateResponse;

/**
 *
 * @author Melissa Delgado
 */

class AreaTypeController extends Controller {

    private $area_type;

    function __construct(AreaTypeRepo $areaTypeRepo) {
        $this->area_type = $areaTypeRepo;
    }

    public function show(Request $request, $id) {
        $relationships = $request->get('relationships', null);
        $area_type = $this->area_type->find($id, $relationships);
        return response()->json($area_type);
    }

    public function index(Request $request) {
        $options = $request->all() ?: [];
        return response()->json($this->area_type->get($options));
    }

    public function store(Request $request) {
        $data = $request->all();

        $area_type = new AreaType($data);

        if ( $this->area_type->create($area_type) ) {
            return response()->json($area_type);
        }

        return response()->json($area_type->getErrors(),
            IlluminateResponse::HTTP_BAD_REQUEST);
    }

}
