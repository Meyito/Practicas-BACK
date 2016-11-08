<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\UserHelper;
use App\Models\Contractor;
use App\Repositories\ContractorRepository as ContractorRepo;
use Illuminate\Http\Response as IlluminateResponse;

class ContractorController extends Controller {

    private $contractor;

    function __construct(ContractorRepo $contractorRepo) {
        $this->contractor = $contractorRepo;
    }

    public function show(Request $request, $id) {
        $relationships = $request->get('relationships', null);
        $contractor = $this->contractor->find($id, $relationships);
        return response()->json($contractor);
    }

    public function index(Request $request) {
        $options = $request->all() ?: [];
        return response()->json($this->contractor->get($options));
    }

    public function store(Request $request) {
        $data = $request->all();

        $contractor = new Contractor($data);

        if ( $this->contractor->create($contractor) ) {
            return response()->json($contractor);
        }

        return response()->json($contractor->getErrors(),
            IlluminateResponse::HTTP_BAD_REQUEST);
    }

}
