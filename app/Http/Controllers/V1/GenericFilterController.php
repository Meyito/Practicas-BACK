<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\UserHelper;
use App\Models\GenericFilter;
use App\Repositories\GenericFilterRepository as GenericFilterRepo;
use Illuminate\Http\Response as IlluminateResponse;

class GenericFilterController extends Controller {

    private $generic_filter;

    function __construct(GenericFilterRepo $genericFilterRepo) {
        $this->generic_filter = $genericFilterRepo;
    }

    public function show(Request $request, $id) {
        $relationships = $request->get('relationships', null);
        $generic_filter = $this->generic_filter->find($id, $relationships);
        return response()->json($generic_filter);
    }

    public function index(Request $request) {
        $options = $request->all() ?: [];
        return response()->json($this->generic_filter->get($options));
    }

}
