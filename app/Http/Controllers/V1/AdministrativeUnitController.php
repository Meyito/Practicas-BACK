<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\UserHelper;
use App\Models\AdministrativeUnit;
use App\Repositories\AdministrativeUnitRepository as AdministrativeUnitRepo;
use Illuminate\Http\Response as IlluminateResponse;

class AdministrativeUnitController extends Controller {

    private $administrative_unit;

    function __construct(AdministrativeUnitRepo $administrativeUnitRepo) {
        $this->administrative_unit = $administrativeUnitRepo;
    }

    public function show(Request $request, $id) {
        $relationships = $request->get('relationships', null);
        $administrative_unit = $this->administrative_unit->find($id, $relationships);
        return response()->json($administrative_unit);
    }

    public function index(Request $request) {
        $options = $request->all() ?: [];
        return response()->json($this->administrative_unit->get($options));
    }

    public function store(Request $request) {
        $data = $request->all();

        $administrative_unit = new AdministrativeUnit($data);

        if ($this->administrative_unit->create($administrative_unit)) {
            return response()->json($administrative_unit);
        }

        return response()->json($administrative_unit->getErrors(),
            IlluminateResponse::HTTP_BAD_REQUEST);
    }

}
