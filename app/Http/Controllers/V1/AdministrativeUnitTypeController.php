<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\UserHelper;
use App\Models\AdministrativeUnitType;
use App\Repositories\AdministrativeUnitTypeRepository as AdministrativeUnitTypeRepo;
use Illuminate\Http\Response as IlluminateResponse;

class AdministrativeUnitTypeController extends Controller {

    private $administrative_unit_type;

    function __construct(AdministrativeUnitTypeRepo $administrativeUnitTypeRepo) {
        $this->administrative_unit_type = $administrativeUnitTypeRepo;
    }

    public function show(Request $request, $id) {
        $relationships = $request->get('relationships', null);
        $administrative_unit_type = $this->administrative_unit_type->find($id, $relationships);
        return response()->json($administrative_unit_type);
    }

    public function index(Request $request) {
        $options = $request->all() ?: [];
        return response()->json($this->administrative_unit_type->get($options));
    }

    public function store(Request $request) {
        $data = $request->all();

        $administrative_unit_type = new AdministrativeUnitType($data);

        if ( $this->administrative_unit_type->create($administrative_unit_type) ) {
            return response()->json($administrative_unit_type);
        }

        return response()->json($administrative_unit_type->getErrors(),
            IlluminateResponse::HTTP_BAD_REQUEST);
    }

}
