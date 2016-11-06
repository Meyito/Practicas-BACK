<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\UserHelper;
use App\Models\EthnicGroup;
use App\Repositories\EthnicGroupRepository as EthnicGroupRepo;
use Illuminate\Http\Response as IlluminateResponse;

class EthnicGroupController extends Controller {

    private $ethnic_group;

    function __construct(EthnicGroupRepo $ethnicGroupRepo) {
        $this->ethnic_group = $ethnicGroupRepo;
    }

    public function show(Request $request, $id) {
        $relationships = $request->get('relationships', null);
        $ethnic_group = $this->ethnic_group->find($id, $relationships);
        return response()->json($ethnic_group);
    }

    public function index(Request $request) {
        $options = $request->all() ?: [];
        return response()->json($this->ethnic_group->get($options));
    }

    public function store(Request $request) {
        $data = $request->all();

        $ethnic_group = new EthnicGroup($data);

        if ($this->ethnic_group->create($ethnic_group)) {
            return response()->json($ethnic_group);
        }

        return response()->json($ethnic_group->getErrors(),
            IlluminateResponse::HTTP_BAD_REQUEST);
    }

}
