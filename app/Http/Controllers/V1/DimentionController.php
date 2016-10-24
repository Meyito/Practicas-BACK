<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\DimentionRepository as DimentionRepo;

class DimentionController extends Controller {

    private $dimention;

    function __construct(DimentionRepo $dimentionRepo) {
        $this->dimention = $dimentionRepo;
    }

    public function show(Request $request, $id) {
        $relationships = $request->get('relationships', null);
        $dimention = $this->dimention->find($id, $relationships);
        return response()->json($dimention);
    }

    public function index(Request $request) {
        $options = $request->all() ?: [];
        return response()->json($this->dimention->get($options));
    }

}
