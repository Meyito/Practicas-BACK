<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\UserHelper;
use App\Models\SisbenZone;
use App\Repositories\SisbenZoneRepository as SisbenZoneRepo;
use Illuminate\Http\Response as IlluminateResponse;

/**
 *
 * @author Melissa Delgado
 */

class SisbenZoneController extends Controller {

    private $sisben_zone;

    function __construct(SisbenZoneRepo $sisbenZoneRepo) {
        $this->sisben_zone = $sisbenZoneRepo;
    }

    public function show(Request $request, $id) {
        $relationships = $request->get('relationships', null);
        $sisben_zone = $this->sisben_zone->find($id, $relationships);
        return response()->json($sisben_zone);
    }

    public function index(Request $request) {
        $options = $request->all() ?: [];
        return response()->json($this->sisben_zone->get($options));
    }

    public function store(Request $request) {
        $data = $request->all();

        $sisben_zone = new SisbenZone($data);

        if ($this->sisben_zone->create($sisben_zone)) {
            return response()->json($sisben_zone);
        }

        return response()->json($sisben_zone->getErrors(),
            IlluminateResponse::HTTP_BAD_REQUEST);
    }

}
