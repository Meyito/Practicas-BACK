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

    public function update(Request $request, $id) {
        $data = $request->get('contractor');
        $contractor = $this->contractor->find($id);

        if (!$contractor) {
            return response()->json(["error" => "No existe el contratista suministrado"],
                            IlluminateResponse::HTTP_BAD_REQUEST);
        }

        try {
            $this->contractor->update($contractor, $data);
            return response()->json($contractor);
        } catch (TransactionException $exc) {
            return response()->json($exc->getErrorsArray(),
                            IlluminateResponse::HTTP_BAD_REQUEST);
        }
    }

    public function addContract(Request $request, $id){
        $data = $request->all();
        $contractor = $this->contractor->find($id);

        if (!$contractor) {
            return response()->json(["error" => "No existe el contratista suministrado"],
                            IlluminateResponse::HTTP_BAD_REQUEST);
        }

        try {
            $this->contractor->addContract($contractor, $data);
            return response()->json($contractor);
        } catch (TransactionException $exc) {
            return response()->json($exc->getErrorsArray(),
                            IlluminateResponse::HTTP_BAD_REQUEST);
        }
    }

}
