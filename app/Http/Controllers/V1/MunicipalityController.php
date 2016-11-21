<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\UserHelper;
use App\Models\Municipality;
use App\Repositories\MunicipalityRepository as MunicipalityRepo;
use Illuminate\Http\Response as IlluminateResponse;
use Excel;

class MunicipalityController extends Controller {

    private $municipality;

    function __construct(MunicipalityRepo $municipalityRepo) {
        $this->municipality = $municipalityRepo;
    }

    public function show(Request $request, $id) {
        $relationships = $request->get('relationships', null);
        $municipality = $this->municipality->find($id, $relationships);
        return response()->json($municipality);
    }

    public function index(Request $request) {
        $options = $request->all() ?: [];
        return response()->json($this->municipality->get($options));
    }

    public function store(Request $request) {
        $data = $request->all();

        $municipality = new Municipality($data);

        if ( $this->municipality->create($municipality) ) {
            return response()->json($municipality);
        }

        return response()->json($municipality->getErrors(),
            IlluminateResponse::HTTP_BAD_REQUEST);
    }

    public function uploadTerritories(Request $request){
        $file = $this->getFile($request);

        try {
            $reader = Excel::selectSheetsByIndex(0)->load($file->getRealPath(),
                        null, null, true);

            $results = $this->municipality->bulkStore( $reader->toArray() );

            if ($results === true) {
                return response()->json(['msg' => 'Se cargaron los municipios exitosamente.']);
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
            return response()->json("Debe suministrar un archivo de municipios.",
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
