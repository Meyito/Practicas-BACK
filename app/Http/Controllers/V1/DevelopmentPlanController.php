<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\DevelopmentPlanRepository as DevelopmentPlanRepo;

class DevelopmentPlanController extends Controller {

    private $developmentPlan;

    function __construct(DevelopmentPlanRepo $developmentPlanRepo) {
        $this->developmentPlan = $developmentPlanRepo;
    }

    public function show(Request $request, $id) {
        $relationships = $request->get('relationships', null);
        $developmentPlan = $this->developmentPlan->find($id, $relationships);
        return response()->json($developmentPlan);
    }

    public function index(Request $request) {
        $options = $request->all() ?: [];
        return response()->json($this->developmentPlan->get($options));
    }
}
