<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DevelopmentPlan;
use App\Repositories\DevelopmentPlanRepository as DevelopmentPlanRepo;
use Illuminate\Http\Response as IlluminateResponse;
use Excel;

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

    public function last(Request $request) {
        $options = $request->all() ?: [];
        return response()->json($this->developmentPlan->getLast($options));
    }

    public  function uploadPlan(Request $request){

        $file = $this->getFile($request);

        $data = $request->all()["data"];
        $developmentPlan = new DevelopmentPlan($data);

        if ($this->developmentPlan->create($developmentPlan)) {
            try {
                $reader = Excel::selectSheetsByIndex(0)->load($file->getRealPath(),
                        null, null, true);

                $results = $this->developmentPlan->bulkStore( $reader->toArray(), $developmentPlan->id );

                if ($results === true) {
                    return response()->json(['msg' => 'Se cargó el plan de desarrollo exitosamente.']);
                } else {
                    return response()->json($results,
                                    IlluminateResponse::HTTP_BAD_REQUEST);
                }
            } catch (Exception $e) {
                return response()->json(["error" => "Ocurrió un error inesperado en la carga del archivo."],
                                IlluminateResponse::HTTP_BAD_REQUEST);
            }
        }

        return response()->json($developmentPlan->getErrors(),
            IlluminateResponse::HTTP_BAD_REQUEST);
    }

    private function getFile($request) {
        if (!$request->hasFile('file')) {
            return response()->json("Debe suministrar un archivo de plan de desarrollo.",
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
