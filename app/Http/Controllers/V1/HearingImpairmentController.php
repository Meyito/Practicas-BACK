<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\UserHelper;
use App\Models\HearingImpairment;
use App\Repositories\HearingImpairmentRepository as HearingImpairmentRepo;
use Illuminate\Http\Response as IlluminateResponse;

class HearingImpairmentController extends Controller {

    private $hearing_impairment;

    function __construct(HearingImpairmentRepo $hearingImpairmentRepo) {
        $this->hearing_impairment = $hearingImpairmentRepo;
    }

    public function show(Request $request, $id) {
        $relationships = $request->get('relationships', null);
        $hearing_impairment = $this->hearing_impairment->find($id, $relationships);
        return response()->json($hearing_impairment);
    }

    public function index(Request $request) {
        $options = $request->all() ?: [];
        return response()->json($this->hearing_impairment->get($options));
    }

    public function store(Request $request) {
        $data = $request->all();

        $hearing_impairment = new HearingImpairment($data);

        if ( $this->hearing_impairment->create($hearing_impairment) ) {
            return response()->json($hearing_impairment);
        }

        return response()->json($hearing_impairment->getErrors(),
            IlluminateResponse::HTTP_BAD_REQUEST);
    }

}
