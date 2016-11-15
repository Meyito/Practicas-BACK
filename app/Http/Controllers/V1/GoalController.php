<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\UserHelper;
use App\Models\Goal;
use App\Repositories\GoalRepository as GoalRepo;
use Illuminate\Http\Response as IlluminateResponse;

class GoalController extends Controller {

    private $goal;

    function __construct(GoalRepo $goalRepo) {
        $this->goal = $goalRepo;
    }

    public function show(Request $request, $id) {
        $relationships = $request->get('relationships', null);
        $goal = $this->goal->find($id, $relationships);
        return response()->json($goal);
    }

    public function index(Request $request) {
        $options = $request->all() ?: [];
        return response()->json($this->goal->get($options));
    }

    public function store(Request $request) {
        $data = $request->all();

        $goal = new Goal($data);

        if ( $this->goal->create($goal) ) {
            return response()->json($goal);
        }

        return response()->json($goal->getErrors(),
            IlluminateResponse::HTTP_BAD_REQUEST);
    }

}
