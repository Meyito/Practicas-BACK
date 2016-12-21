<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\UserHelper;
use App\Models\Counter;
use App\Repositories\CounterRepository as CounterRepo;
use Illuminate\Http\Response as IlluminateResponse;

/**
 *
 * @author Melissa Delgado
 */

class CounterController extends Controller {

    private $counter;

    function __construct(CounterRepo $counterRepo) {
        $this->counter = $counterRepo;
    }

    public function show(Request $request, $id) {
        $relationships = $request->get('relationships', null);
        $counter = $this->counter->find($id, $relationships);
        return response()->json($counter);
    }

    public function index(Request $request) {
        $options = $request->all() ?: [];
        return response()->json($this->counter->get($options));
    }

}
