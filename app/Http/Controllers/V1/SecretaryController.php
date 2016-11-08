<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\UserHelper;
use App\Models\Secretaries;
use App\Repositories\SecretaryRepository as SecretaryRepo;
use Illuminate\Http\Response as IlluminateResponse;

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
        //$data['user_id'] = UserHelper::getCurrentUser()->id;

        $secretary = new Secretaries($data);

        if ($this->secretary->create($secretary)) {
            return response()->json($secretary);
        }

        return response()->json($secretary->getErrors(),
            IlluminateResponse::HTTP_BAD_REQUEST);
    }

}
