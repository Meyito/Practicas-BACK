<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\UserHelper;
use App\Models\Activity;
use App\Repositories\ActivityRepository as ActivityRepo;
use Illuminate\Http\Response as IlluminateResponse;

class ActivityController extends Controller {

    private $activity;

    function __construct(ActivityRepo $activityRepo) {
        $this->activity = $activityRepo;
    }

    public function show(Request $request, $id) {
        $relationships = $request->get('relationships', null);
        $activity = $this->activity->find($id, $relationships);
        return response()->json($activity);
    }

    public function index(Request $request) {
        $options = $request->all() ?: [];
        return response()->json($this->activity->get($options));
    }

    public function store(Request $request) {
        $data = $request->all();

        $activity = new Activity($data);

        if ($this->activity->create($activity)) {
            return response()->json($activity);
        }

        return response()->json($activity->getErrors(),
            IlluminateResponse::HTTP_BAD_REQUEST);
    }

}
