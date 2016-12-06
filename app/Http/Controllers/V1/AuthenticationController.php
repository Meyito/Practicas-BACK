<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response as IlluminateResponse;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Repositories\UserRepository as User;
use Illuminate\Support\Facades\Hash;
use JWTFactory;
use JWTAuth;

/**
* Class AuthenticationController
*/
class AuthenticationController extends Controller{

    private $user;

    function __construct(User $user) {
        $this->user = $user;
    }

    /**
     * Authenticates an User given his username/password
     * @param Request $request
     * @return JsonResponse Token generated if the user was successfully authenticated, 
     * error information otherwise
     */
    public function login(Request $request) {
        $credentials = [
            "username" => $request->input("username", ""),
            "password" => $request->input("password", "")
        ];

        $user = $this->user->findBy("username", $credentials["username"]);

        if (!$user) {
            return response()->json([
                        'error' => "Usuario y/o contraseña incorrectos"],
                            IlluminateResponse::HTTP_BAD_REQUEST);
        }

        if (!Hash::check($credentials["password"], $user->password)) {
            return response()->json([
                        'error' => "Usuario y/o contraseña incorrectos"],
                            IlluminateResponse::HTTP_BAD_REQUEST);
        }

        $views = [];

        /*foreach ($user->role->views as $view) {
            $views[$view->name] = "allowed";
        }*/

        /*$payload = JWTFactory::make([
                    "username" => $user->username,
                    "sub" => $user->id,
                    "role" => $user->role,
                    "views" => $views
        ]);*/
        $payload = JWTFactory::make([
            'name' => $user->name,
            'role' => "admin",
            'views' => $views
        ]);

        $token = JWTAuth::encode($payload)->get();
        return response()->json(compact('token'));
    }

     /**
     * Invalidates a token
     * @return JsonResponse Contains a message with the result when attempting to
     * invalidate the current token
     */
    public function invalidate() {
        try {
            JWTAuth::invalidate(JWTAuth::getToken());
            return response()->json(["message" => "Token invalidado satisfactoriamente"]);
        } catch (\Tymon\JWTAuth\Exceptions\TokenBlacklistedException $exc) {
            return response()->json(["error" => "El token suministrado es inválido"],
                            IlluminateResponse::HTTP_BAD_REQUEST);
        }
    }

}