<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\UserHelper;
use App\Models\MotorDisability;
use App\Repositories\MotorDisabilityRepository as MotorDisabilityRepo;
use Illuminate\Http\Response as IlluminateResponse;

class MotorDisabilityController extends Controller {

    private $motor_disability;

    function __construct(MotorDisabilityRepo $motorDisabilityRepo) {
        $this->motor_disability = $motorDisabilityRepo;
    }

    public function show(Request $request, $id) {
        $relationships = $request->get('relationships', null);
        $motor_disability = $this->motor_disability->find($id, $relationships);
        return response()->json($motor_disability);
    }

    public function index(Request $request) {
        $options = $request->all() ?: [];
        return response()->json($this->motor_disability->get($options));
    }

    public function store(Request $request) {
        $data = $request->all();

        $motor_disability = new MotorDisability($data);

        if ( $this->motor_disability->create($motor_disability) ) {
            return response()->json($motor_disability);
        }

        return response()->json($motor_disability->getErrors(),
            IlluminateResponse::HTTP_BAD_REQUEST);
    }

}
