<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\UserHelper;
use App\Models\Area;
use App\Repositories\AreaRepository as AreaRepo;
use Illuminate\Http\Response as IlluminateResponse;
use Excel;

/**
 *
 * @author Melissa Delgado
 */
 
class AreaController extends Controller {

    private $area;

    function __construct(AreaRepo $areaRepo) {
        $this->area = $areaRepo;
    }

    public function show(Request $request, $id) {
        $relationships = $request->get('relationships', null);
        $area = $this->area->find($id, $relationships);
        return response()->json($area);
    }

    public function index(Request $request) {
        $options = $request->all() ?: [];
        return response()->json($this->area->get($options));
    }

    public function store(Request $request) {
        $data = $request->all();

        $area = new Area($data);

        if ($this->area->create($area)) {
            return response()->json($area);
        }

        return response()->json($area->getErrors(),
            IlluminateResponse::HTTP_BAD_REQUEST);
    }

    public function uploadAreas(Request $request){
        $file = $this->getFile($request);

        try {
            $reader = Excel::selectSheetsByIndex(0)->load($file->getRealPath(),
                        null, null, true);

            $results = $this->area->bulkStore( $reader->toArray() );

            if ($results === true) {
                return response()->json(['msg' => 'Se cargaron las areas exitosamente.']);
            } else {
                return response()->json($results, IlluminateResponse::HTTP_BAD_REQUEST);
            }
        } catch (Exception $e) {
            return response()->json(["error" => "Ocurrió un error inesperado en la carga del archivo."],
                                IlluminateResponse::HTTP_BAD_REQUEST);
        }

    }

    private function getFile($request) {
        if (!$request->hasFile('file')) {
            return response()->json("Debe suministrar un archivo de areas.",
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
