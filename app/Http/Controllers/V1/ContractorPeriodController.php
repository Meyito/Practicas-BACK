<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\UserHelper;
use App\Models\ContractorPeriod;
use App\Repositories\ContractorPeriodRepository as ContractorPeriodRepo;
use Illuminate\Http\Response as IlluminateResponse;

class ContractorPeriodController extends Controller {

    private $contractor_period;

    function __construct(ContractorPeriodRepo $contractorPeriodRepo) {
        $this->contractor_period = $contractorPeriodRepo;
    }

    public function show(Request $request, $id) {
        $relationships = $request->get('relationships', null);
        $contractor_period = $this->contractor_period->find($id, $relationships);
        return response()->json($contractor_period);
    }

    public function index(Request $request) {
        $options = $request->all() ?: [];
        return response()->json($this->contractor_period->get($options));
    }

    public function store(Request $request) {
        $data = $request->all();

        $contractor_period = new ContractorPeriod($data);

        if ( $this->contractor_period->create($contractor_period) ) {
            return response()->json($contractor_period);
        }

        return response()->json($contractor_period->getErrors(),
            IlluminateResponse::HTTP_BAD_REQUEST);
    }

}
