<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\UserHelper;
use App\Models\AgeRange;
use App\Repositories\AgeRangeRepository as AgeRangeRepo;
use Illuminate\Http\Response as IlluminateResponse;

class AgeRangeController extends Controller {

    private $age_range;

    function __construct(AgeRangeRepo $ageRangeRepo) {
        $this->age_range = $ageRangeRepo;
    }

    public function show(Request $request, $id) {
        $relationships = $request->get('relationships', null);
        $age_range = $this->age_range->find($id, $relationships);
        return response()->json($age_range);
    }

    public function index(Request $request) {
        $options = $request->all() ?: [];
        return response()->json($this->age_range->get($options));
    }

    public function store(Request $request) {
        $data = $request->all();

        $age_range = new AgeRange($data);

        if ($this->age_range->create($age_range)) {
            return response()->json($age_range);
        }

        return response()->json($age_range->getErrors(),
            IlluminateResponse::HTTP_BAD_REQUEST);
    }

}
