<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\UserHelper;
use App\Models\VictimType;
use App\Repositories\VictimTypeRepository as VictimTypeRepo;
use Illuminate\Http\Response as IlluminateResponse;

class VictimTypeController extends Controller {

    private $victim_type;

    function __construct(VictimTypeRepo $victimTypeRepo) {
        $this->victim_type = $victimTypeRepo;
    }

    public function show(Request $request, $id) {
        $relationships = $request->get('relationships', null);
        $victim_type = $this->victim_type->find($id, $relationships);
        return response()->json($victim_type);
    }

    public function index(Request $request) {
        $options = $request->all() ?: [];
        return response()->json($this->victim_type->get($options));
    }

    public function store(Request $request) {
        $data = $request->all();

        $victim_type = new VictimType($data);

        if ( $this->victim_type->create($victim_type) ) {
            return response()->json($victim_type);
        }

        return response()->json($victim_type->getErrors(),
            IlluminateResponse::HTTP_BAD_REQUEST);
    }

}
