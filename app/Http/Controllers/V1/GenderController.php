<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\UserHelper;
use App\Models\Gender;
use App\Repositories\GenderRepository as GenderRepo;
use Illuminate\Http\Response as IlluminateResponse;

/**
 *
 * @author Melissa Delgado
 */

class GenderController extends Controller {

    private $gender;

    function __construct(GenderRepo $genderRepo) {
        $this->gender = $genderRepo;
    }

    public function show(Request $request, $id) {
        $relationships = $request->get('relationships', null);
        $gender = $this->gender->find($id, $relationships);
        return response()->json($gender);
    }

    public function index(Request $request) {
        $options = $request->all() ?: [];
        return response()->json($this->gender->get($options));
    }

    public function store(Request $request) {
        $data = $request->all();

        $gender = new Gender($data);

        if ($this->gender->create($gender)) {
            return response()->json($gender);
        }

        return response()->json($gender->getErrors(),
            IlluminateResponse::HTTP_BAD_REQUEST);
    }

}
