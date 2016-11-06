<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\UserHelper;
use App\Models\User;
use App\Repositories\UserRepository as UserRepo;
use Illuminate\Http\Response as IlluminateResponse;

class UserController extends Controller {

    private $user;

    function __construct(UserRepo $userRepo) {
        $this->user = $userRepo;
    }

    public function show(Request $request, $id) {
        $relationships = $request->get('relationships', null);
        $user = $this->user->find($id, $relationships);
        return response()->json($user);
    }

    public function index(Request $request) {
        $options = $request->all() ?: [];
        return response()->json($this->user->get($options));
    }

    public function store(Request $request) {

        $data = $request->all();

        $user = new User($data);

        if ($this->user->create($user)) {
            return response()->json($user);
        }

        return response()->json($user->getErrors(),
            IlluminateResponse::HTTP_BAD_REQUEST);
    }

}
