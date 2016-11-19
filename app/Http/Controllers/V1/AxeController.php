<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\UserHelper;
use App\Models\Axe;
use App\Repositories\AxeRepository as AxeRepo;
use Illuminate\Http\Response as IlluminateResponse;

class AxeController extends Controller {

    private $axe;

    function __construct(AxeRepo $axeRepo) {
        $this->axe = $axeRepo;
    }

    public function show(Request $request, $id) {
        $relationships = $request->get('relationships', null);
        $axe = $this->axe->find($id, $relationships);
        return response()->json($axe);
    }

    public function index(Request $request) {
        $options = $request->all() ?: [];
        return response()->json($this->axe->get($options));
    }

}
