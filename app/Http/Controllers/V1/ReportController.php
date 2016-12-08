<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\UserHelper;
use App\Models\Person;
use App\Repositories\PersonRepository as PersonRepo;
use Illuminate\Http\Response as IlluminateResponse;
use DB;

class ReportController extends Controller {

    public function report(Request $request){
        $total = $request->get('total');
        $group = $request->get('group');
        $filters = $request->get('filters');
        $conditions = $this->getConditions($filters);

        $result = DB::select("SELECT {$total}
                FROM activity_characterizations ac
                LEFT JOIN characterizations ch ON ch.id = ac.characterization_id
                LEFT JOIN people p ON p.id = ch.person_id
                LEFT JOIN activities a ON a.id = ac.activity_id
                LEFT JOIN goals go ON go.id = a.goal_id
                LEFT JOIN projects pj ON pj.id = a.project_id
                LEFT JOIN subprograms sp ON sp.id = go.subprogram_id
                LEFT JOIN programs pg ON pg.id = sp.program_id
                LEFT JOIN axes ax ON ax.id = pg.axe_id
                LEFT JOIN dimentions dm ON dm.id = ax.dimention_id
                LEFT JOIN development_plans dp ON dp.id = dm.development_plan_id
                LEFT JOIN secretary_programs spg ON spg.program_id = pg.id
                LEFT JOIN secretaries se ON se.id = a.secretary_id
                LEFT JOIN administrative_units au ON au.id = a.administrative_unit_id
                LEFT JOIN areas are ON are.id = au.area_id
                LEFT JOIN area_types aty ON aty.id = are.area_type_id
                LEFT JOIN sisben_zones sz ON sz.id = aty.sisben_zone_id
                LEFT JOIN municipalities m ON m.id = are.municipality_id
                {$conditions} {$group}");
        
        return response()->json($result);
    }

    private function getConditions($filters){
        $sql = "";

        for($i = 0; $i < count($filters); $i++){
            if($i > 0){
                $sql.="AND ";
            }else{
                $sql.="WHERE ";
            }
            $sql.=" {$filters[$i]['column']} = {$filters[$i]['value']} ";
        }

        return $sql;
    }

}
