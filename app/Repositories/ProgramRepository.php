<?php

namespace App\Repositories;
use App\Models\Program;
use DB;

/**
 * Description of ProgramRepository
 *
 * @author Melissa Delgado
 */
class ProgramRepository extends EloquentRepository {

    protected $model = "App\Models\Program";

    
    public function get($options = []){
        $queryOptions = array_merge($this->options, $options);

        $page = intval($queryOptions['page']) > 0 ?
                intval($queryOptions['page']) - 1 : 0;

        $items = $queryOptions['items'] > 0 ? $queryOptions['items'] : -1;

        $limit = $items > 0 ? "LIMIT {$items}" : "";
        $offsetCount = $page * $items;
        $offset = $items > 0 ? "OFFSET {$offsetCount}" : "";
        $programSql = "SELECT p.id, p.code, p.axe_id, p.name, (SELECT COUNT(g.id) "
                     ."FROM goals g, subprograms sp, programs pp WHERE pp.id = sp.program_id "
                     ."AND g.subprogram_id = sp.id AND pp.id = p.id) AS goals_count FROM programs p ";

        $query = DB::connection("")->select("{$programSql} {$limit} {$offset}");

        $index = [];
        $i = 0;

        foreach($query as $item){
            $index[ $item->id ] = $i;
            $i++;
        }

        $relationships = is_string($queryOptions['relationships']) ? explode(",",
            $queryOptions['relationships']) : [];

        $programs = Program::with($relationships)->get();

        foreach ($programs as $program) {
            $pos = $index[strval($program->id)];
            $program["goals_count"] = $query[$pos]->goals_count;
            $query[$pos] = $program;
        }

        return $query;
    }

}
