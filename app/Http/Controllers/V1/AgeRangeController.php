<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\UserHelper;
use App\Models\AgeRange;
use App\Repositories\AgeRangeRepository as AgeRangeRepo;
use Illuminate\Http\Response as IlluminateResponse;

/**
 *
 * @author Melissa Delgado
 */
 
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
}
