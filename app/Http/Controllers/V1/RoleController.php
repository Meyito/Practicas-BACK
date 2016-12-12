<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\UserHelper;
use App\Models\Role;
use App\Repositories\RoleRepository as RoleRepo;
use Illuminate\Http\Response as IlluminateResponse;

class RoleController extends Controller {

    private $role;

    function __construct(RoleRepo $roleRepo) {
        $this->role = $roleRepo;
    }

    public function index(Request $request) {
        $options = $request->all() ?: [];
        return response()->json($this->role->get($options));
    }

}
