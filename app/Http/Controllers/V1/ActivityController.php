<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\UserHelper;
use App\Models\Activity;
use App\Repositories\ActivityRepository as ActivityRepo;
use Illuminate\Http\Response as IlluminateResponse;
use Excel;

class ActivityController extends Controller {

    private $activity;

    function __construct(ActivityRepo $activityRepo) {
        $this->activity = $activityRepo;
    }

    public function show(Request $request, $id) {
        $relationships = $request->get('relationships', null);
        $activity = $this->activity->find($id, $relationships);
        return response()->json($activity);
    }

    public function index(Request $request) {
        $options = $request->all() ?: [];
        return response()->json($this->activity->get($options));
    }

    public function store(Request $request) {
        $data = $request->all();

        $activity = new Activity($data);

        if ($this->activity->create($activity)) {
            return response()->json($activity);
        }

        return response()->json($activity->getErrors(),
            IlluminateResponse::HTTP_BAD_REQUEST);
    }

    public function uploadActivity(Request $request){
        $file = $this->getFile($request);

        try {
            $reader = Excel::selectSheetsByIndex(0)->load($file->getRealPath(),
                        null, null, true);

            $results = $this->activity->bulkStore( $reader->toArray() );

            if ($results["success"] === true) {
                $reader = Excel::selectSheetsByIndex(1)->load($file->getRealPath(),
                        null, null, true);

                $results = $this->activity->bulkAssistants( $reader->toArray(), $results["id"] );

                if($results === true){
                    return response()->json(['msg' => 'Se cargo la actividad exitosamente.']);
                }else{
                    return response()->json($results, IlluminateResponse::HTTP_BAD_REQUEST);
                }
                /*CARGAR LOS ASISTENTES
                Si todo bien -> exito
                Si no, eliminar la actividad y mostrar los errores
                */
                
            } else {
                return response()->json($results, IlluminateResponse::HTTP_BAD_REQUEST);
            }
        } catch (Exception $e) {
            return response()->json(["error" => "Ocurrió un error inesperado en la carga del archivo."], IlluminateResponse::HTTP_BAD_REQUEST);
        }

    }

    private function getFile($request) {
        if (!$request->hasFile('file')) {
            return response()->json("Debe suministrar un archivo de actividades.",
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
