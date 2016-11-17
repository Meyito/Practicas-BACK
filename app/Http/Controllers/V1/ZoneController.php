<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\UserHelper;
use App\Models\Zone;
use App\Repositories\ZoneRepository as ZoneRepo;
use Illuminate\Http\Response as IlluminateResponse;

class ZoneController extends Controller {

    private $zone;

    function __construct(ZoneRepo $zoneRepo) {
        $this->zone = $zoneRepo;
    }

    public function show(Request $request, $id) {
        $relationships = $request->get('relationships', null);
        $zone = $this->zone->find($id, $relationships);
        return response()->json($zone);
    }

    public function index(Request $request) {
        $options = $request->all() ?: [];
        return response()->json($this->zone->get($options));
    }

    public function store(Request $request) {
        $data = $request->all();

        $zone = new Zone($data);

        if ( $this->zone->create($zone) ) {
            return response()->json($zone);
        }

        return response()->json($zone->getErrors(),
            IlluminateResponse::HTTP_BAD_REQUEST);
    }

}
