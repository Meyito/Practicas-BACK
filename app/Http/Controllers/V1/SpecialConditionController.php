<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\UserHelper;
use App\Models\SpecialCondition;
use App\Repositories\SpecialConditionRepository as SpecialConditionRepo;
use Illuminate\Http\Response as IlluminateResponse;

/**
 *
 * @author Melissa Delgado
 */

class SpecialConditionController extends Controller {

    private $special_condition;

    function __construct(SpecialConditionRepo $specialConditionRepo) {
        $this->special_condition = $specialConditionRepo;
    }

    public function show(Request $request, $id) {
        $relationships = $request->get('relationships', null);
        $special_condition = $this->special_condition->find($id, $relationships);
        return response()->json($special_condition);
    }

    public function index(Request $request) {
        $options = $request->all() ?: [];
        return response()->json($this->special_condition->get($options));
    }

    public function store(Request $request) {
        $data = $request->all();

        $special_condition = new SpecialCondition($data);

        if ($this->special_condition->create($special_condition)) {
            return response()->json($special_condition);
        }

        return response()->json($special_condition->getErrors(),
            IlluminateResponse::HTTP_BAD_REQUEST);
    }

}
