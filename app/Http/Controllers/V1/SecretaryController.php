<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\UserHelper;
use App\Models\Secretaries;
use App\Repositories\SecretaryRepository as SecretaryRepo;
use Illuminate\Http\Response as IlluminateResponse;

/**
 *
 * @author Melissa Delgado
 */

class SecretaryController extends Controller {

    private $secretary;

    function __construct(SecretaryRepo $secretaryRepo) {
        $this->secretary = $secretaryRepo;
    }

    public function show(Request $request, $id) {
        $relationships = $request->get('relationships', null);
        $secretary = $this->secretary->find($id, $relationships);
        return response()->json($secretary);
    }

    public function index(Request $request) {
        $options = $request->all() ?: [];
        return response()->json($this->secretary->get($options));
    }

    public function store(Request $request) {
        $data = $request->all();
        $secretary = new Secretaries($data);

        if ($this->secretary->create($secretary)) {
            return response()->json($secretary);
        }

        return response()->json($secretary->getErrors(),
            IlluminateResponse::HTTP_BAD_REQUEST);
    }

    public function update(Request $request, $id) {
        $data = $request->get('secretary');
        $secretary = $this->secretary->find($id);

        if (!$secretary) {
            return response()->json(["error" => "No existe la dependencia suministrado"],
                            IlluminateResponse::HTTP_BAD_REQUEST);
        }

        try {
            $this->secretary->update($secretary, $data);
            return response()->json($secretary);
        } catch (TransactionException $exc) {
            return response()->json($exc->getErrorsArray(),
                            IlluminateResponse::HTTP_BAD_REQUEST);
        }
    }

    public function destroy($id) {
        $secretary = $this->secretary->find($id);

        if (!$secretary) {
            return response()->json(["error" =>
                        "No existe la dependencia suministrada"],
                            IlluminateResponse::HTTP_BAD_REQUEST);
        }

        if ($this->secretary->delete($secretary)) {
            return response()->json($secretary);
        }
        return response()->json(["error" =>
                    "No se pudo eliminar la dependencia"],
                        IlluminateResponse::HTTP_BAD_REQUEST);
    }

}
