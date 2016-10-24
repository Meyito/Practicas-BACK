<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\DevelopmentPlanRepository as DevelopmentPlanRepo;
use Illuminate\Http\Response as IlluminateResponse;

class DevelopmentPlanController extends Controller {

    private $developmentPlan;

    function __construct(DevelopmentPlanRepo $developmentPlanRepo) {
        $this->developmentPlan = $developmentPlanRepo;
    }

    public function show(Request $request, $id) {
        $relationships = $request->get('relationships', null);
        $developmentPlan = $this->developmentPlan->find($id, $relationships);
        return response()->json($developmentPlan);
    }

    public function index(Request $request) {
        $options = $request->all() ?: [];
        return response()->json($this->developmentPlan->get($options));
    }

    public  function uploadPlan(Request $request){
        $file = $this->getFile($request);
    }

    private function getFile($request) {

        if (!$request->hasFile('file')) {
            return response()->json("Debe suministrar un archivo de cargue",
                IlluminateResponse::HTTP_BAD_REQUEST);
        }

        $file = $request->file('file');

        if (!$this->isValid($file)) {
            return response()->json(["error" => "No se cargó un archivo de excel válido."],
                IlluminateResponse::HTTP_BAD_REQUEST);
        }

        return $file;
    }

    private function isValid($file) {

        $validFileTypes = [
            'application/vnd.ms-excel',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
        ];

        if (!in_array($file->getMimeType(), $validFileTypes)) {
            return false;
        }

        return true;
    }

}
