<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\UserHelper;
use App\Models\Department;
use App\Repositories\DepartmentRepository as DepartmentRepo;
use Illuminate\Http\Response as IlluminateResponse;

/**
 *
 * @author Melissa Delgado
 */

class DepartmentController extends Controller {

    private $department;

    function __construct(DepartmentRepo $departmentRepo) {
        $this->department = $departmentRepo;
    }

    public function show(Request $request, $id) {
        $relationships = $request->get('relationships', null);
        $department = $this->department->find($id, $relationships);
        return response()->json($department);
    }

    public function index(Request $request) {
        $options = $request->all() ?: [];
        return response()->json($this->department->get($options));
    }

    public function store(Request $request) {
        $data = $request->all();

        $department = new Department($data);

        if ($this->department->create($department)) {
            return response()->json($department);
        }

        return response()->json($department->getErrors(),
            IlluminateResponse::HTTP_BAD_REQUEST);
    }

}
