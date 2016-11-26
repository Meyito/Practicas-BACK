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

    public function test(Request $request){
        
        $total = $request->get('total');
        $filters = $request->get('filters');
        $conditions = $this->getConditions($filters);

        $result = DB::select("SELECT COUNT({$total}) FROM 
                characterizations ch 
                LEFT JOIN people p ON p.id = ch.person_id
                LEFT JOIN ethnic_groups eg ON eg.id = ch.ethnic_group_id
                LEFT JOIN victim_types vt ON vt.id = ch.victim_type_id
                LEFT JOIN motor_disabilities md ON md.id = ch.motor_disability_id
                LEFT JOIN visual_impairments vi ON  vi.id = ch.visual_impairment_id
                LEFT JOIN hearing_impairments hi ON hi.id = ch.hearing_impairment_id
                LEFT JOIN special_conditions sc ON sc.id = ch.special_condition_id
                LEFT JOIN age_range ar ON ar.id = ch.age_range_id
                LEFT JOIN genders g ON g.id = ch.gender_id
                WHERE TRUE {$conditions}
        ");

    }

    private function getConditions($filters){

        $sql = "";
        foreach($filters as $filter){
            $sql.="AND {$filter['column']} = {$filter['value']} ";
        }
        return $sql;
    }

}
