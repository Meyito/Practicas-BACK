<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\UserHelper;
use App\Models\User;
use App\Repositories\UserRepository as UserRepo;
use Illuminate\Http\Response as IlluminateResponse;
use Illuminate\Support\Facades\Hash;

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

        $data["password"] = Hash::make($data["password"]);

        $user = new User($data);

        if ( $this->user->create($user) ) {
            return response()->json($user);
        }

        return response()->json($user->getErrors(),
            IlluminateResponse::HTTP_BAD_REQUEST);
    }

    public function destroy($id) {
        $user = $this->user->find($id);

        if (!$user) {
            return response()->json(["error" =>
                        "No existe la dependencia suministrada"],
                            IlluminateResponse::HTTP_BAD_REQUEST);
        }

        if ($this->user->delete($user)) {
            return response()->json($user);
        }
        return response()->json(["error" =>
                    "No se pudo eliminar la dependencia"],
                        IlluminateResponse::HTTP_BAD_REQUEST);
    }

    public function passwordUpdate(Request $request, $id){
        $data = $request->get('user');
        $data["password"] = Hash::make($data["password"]);

        $user = $this->user->find($id);

        if (!$user) {
            return response()->json(["error" => "No existe el usuario suministrado"],
                            IlluminateResponse::HTTP_BAD_REQUEST);
        }

        try {
            $this->user->update($user, $data);
            return response()->json($user);
        } catch (TransactionException $exc) {
            return response()->json($exc->getErrorsArray(),
                            IlluminateResponse::HTTP_BAD_REQUEST);
        }
    }

}
