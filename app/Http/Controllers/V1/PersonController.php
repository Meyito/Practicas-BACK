<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\UserHelper;
use App\Models\Person;
use App\Repositories\PersonRepository as PersonRepo;
use Illuminate\Http\Response as IlluminateResponse;

/**
 *
 * @author Melissa Delgado
 */

class PersonController extends Controller {

    private $person;

    function __construct(PersonRepo $personRepo) {
        $this->person = $personRepo;
    }

    public function show(Request $request, $id) {
        $relationships = $request->get('relationships', null);
        $person = $this->person->find($id, $relationships);
        return response()->json($person);
    }

    public function index(Request $request) {
        $options = $request->all() ?: [];
        return response()->json($this->person->get($options));
    }

    public function store(Request $request) {

        $data = $request->all();
        $data['user_id'] = UserHelper::getCurrentUser()->id;

        $person = new Person($data);

        if ($this->person->create($person)) {
            return response()->json($person);
        }
        return response()->json($person->getErrors(),
                        IlluminateResponse::HTTP_BAD_REQUEST);
    }

}
