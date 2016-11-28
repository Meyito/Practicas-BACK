<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\UserHelper;
use App\Models\Activity;
use App\Repositories\ActivityRepository as ActivityRepo;
use Illuminate\Http\Response as IlluminateResponse;
use Excel;
use DB;

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

    public function filterActivities(Request $request){
        $filters = $request->get('filters');
        $conditions = $this->getConditions($filters);

        $result = DB::select("SELECT a.id, a.date, a.code, c.first_name, c.last_name, 
                sp.name, COUNT(DISTINCT(p.id)) AS total
                FROM activity_characterizations ac
                LEFT JOIN activities a ON a.id = ac.activity_id
                LEFT JOIN goals go ON go.id = a.goal_id
                LEFT JOIN projects pj ON pj.id = a.project_id
                LEFT JOIN subprograms sp ON sp.id = go.subprogram_id
                LEFT JOIN programs pg ON pg.id = sp.program_id
                LEFT JOIN axes ax ON ax.id = pg.axe_id
                LEFT JOIN dimentions dm ON dm.id = ax.dimention_id
                LEFT JOIN development_plans dp ON dp.id = dm.development_plan_id
                LEFT JOIN secretary_programs spg ON spg.program_id = pg.id
                LEFT JOIN secretaries se ON se.id = spg.secretary_id
                LEFT JOIN contractor_contracts cc ON cc.id = a.contractor_contract_id
                LEFT JOIN contractors c ON c.id = cc.contractor_id
                LEFT JOIN characterizations ch ON ch.id = ac.characterization_id
                LEFT JOIN people p ON p.id = ch.person_id
                WHERE TRUE {$conditions}
                GROUP BY a.id");
        
        return response()->json($result);
    }

    private function getConditions($filters){
        $sql = "";

        for($i = 0; $i < count($filters); $i++){
            $sql.=" AND {$filters[$i]['column']} = {$filters[$i]['value']} ";
        }

        return $sql;
    }

}
