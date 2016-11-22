<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\UserHelper;
use App\Models\AdministrativeUnit;
use App\Repositories\AdministrativeUnitRepository as AdministrativeUnitRepo;
use Illuminate\Http\Response as IlluminateResponse;
use Excel;

class AdministrativeUnitController extends Controller {

    private $administrative_unit;

    function __construct(AdministrativeUnitRepo $administrativeUnitRepo) {
        $this->administrative_unit = $administrativeUnitRepo;
    }

    public function show(Request $request, $id) {
        $relationships = $request->get('relationships', null);
        $administrative_unit = $this->administrative_unit->find($id, $relationships);
        return response()->json($administrative_unit);
    }

    public function index(Request $request) {
        $options = $request->all() ?: [];
        return response()->json($this->administrative_unit->get($options));
    }

    public function store(Request $request) {
        $data = $request->all();

        $administrative_unit = new AdministrativeUnit($data);

        if ($this->administrative_unit->create($administrative_unit)) {
            return response()->json($administrative_unit);
        }

        return response()->json($administrative_unit->getErrors(),
            IlluminateResponse::HTTP_BAD_REQUEST);
    }

    public function uploadUnits(Request $request){
        $file = $this->getFile($request);

        try {
            $reader = Excel::selectSheetsByIndex(0)->load($file->getRealPath(),
                        null, null, true);

            $results = $this->administrative_unit->bulkStore( $reader->toArray() );

            if ($results === true) {
                return response()->json(['msg' => 'Se cargaron las unidades administrativas exitosamente.']);
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
            return response()->json("Debe suministrar un archivo de unidades administrativas.",
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
