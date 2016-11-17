<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\UserHelper;
use App\Models\VisualImpairment;
use App\Repositories\VisualImpairmentRepository as VisualImpairmentRepo;
use Illuminate\Http\Response as IlluminateResponse;

class VisualImpairmentController extends Controller {

    private $visual_impairment;

    function __construct(VisualImpairmentRepo $visualImpairmentRepo) {
        $this->visual_impairment = $visualImpairmentRepo;
    }

    public function show(Request $request, $id) {
        $relationships = $request->get('relationships', null);
        $visual_impairment = $this->visual_impairment->find($id, $relationships);
        return response()->json($visual_impairment);
    }

    public function index(Request $request) {
        $options = $request->all() ?: [];
        return response()->json($this->visual_impairment->get($options));
    }

    public function store(Request $request) {
        $data = $request->all();

        $visual_impairment = new VisualImpairment($data);

        if ( $this->visual_impairment->create($visual_impairment) ) {
            return response()->json($visual_impairment);
        }

        return response()->json($visual_impairment->getErrors(),
            IlluminateResponse::HTTP_BAD_REQUEST);
    }

}
