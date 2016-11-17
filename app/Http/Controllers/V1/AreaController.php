<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\UserHelper;
use App\Models\Area;
use App\Repositories\AreaRepository as AreaRepo;
use Illuminate\Http\Response as IlluminateResponse;

class AreaController extends Controller {

    private $area;

    function __construct(AreaRepo $areaRepo) {
        $this->area = $areaRepo;
    }

    public function show(Request $request, $id) {
        $relationships = $request->get('relationships', null);
        $area = $this->area->find($id, $relationships);
        return response()->json($area);
    }

    public function index(Request $request) {
        $options = $request->all() ?: [];
        return response()->json($this->area->get($options));
    }

    public function store(Request $request) {
        $data = $request->all();

        $area = new Area($data);

        if ($this->area->create($area)) {
            return response()->json($area);
        }

        return response()->json($area->getErrors(),
            IlluminateResponse::HTTP_BAD_REQUEST);
    }

}
