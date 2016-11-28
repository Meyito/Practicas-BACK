<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\UserHelper;
use App\Models\Contract;
use App\Repositories\ContractRepository as ContractRepo;
use Illuminate\Http\Response as IlluminateResponse;

class ContractController extends Controller {

    private $contract;

    function __construct(ContractRepo $contractRepo) {
        $this->contract = $contractRepo;
    }

    public function show(Request $request, $id) {
        $relationships = $request->get('relationships', null);
        $contract = $this->contract->find($id, $relationships);
        return response()->json($contract);
    }

    public function index(Request $request) {
        $options = $request->all() ?: [];
        return response()->json($this->contract->get($options));
    }

    public function store(Request $request) {
        $data = $request->all();

        $contract = new Contract($data);

        if ( $this->contract->create($contract) ) {
            return response()->json($contract);
        }

        return response()->json($contract->getErrors(),
            IlluminateResponse::HTTP_BAD_REQUEST);
    }

}
