<?php

namespace App\Repositories;

use Schema;
use DB;
use DateTime;

/**
 *
 * @author Francisco Bastos
 */
abstract class EloquentRepository {

    protected $model;
    protected $defaultKeySearch = "id";
    protected $options = [
        "page" => 0,
        "items" => -1,
        "orderBy" => "id",
        "orderDirection" => "DESC",
        "relationships" => [],
        "count" => false,
        "search" => ""
    ];
    protected $leftJoins = [];
    protected $searchColumns = [];
    protected $filterColumns = [];
    protected $dateFilterColumn = 'created_at';
    protected $additionalColumns = [];

    public function find($id, $relationships = null, $filters = []) {
        return $this->findBy($this->defaultKeySearch, $id, $relationships,
            $filters);
    }

    public function findBy($field, $value, $relationships = null, $filters = []) {
        $model = $this->model;
        $relationships = is_string($relationships) ? explode(",", $relationships)
            : [];

        $query = $model::with($relationships)->where($field, $value);

        return $this->applySingleFilters($query, $filters, $field, $value)->first();
    }

    public function findByMany(array $fields, $relationships = null) {
        $model = $this->model;
        $relationships = is_string($relationships) ? explode(",", $relationships)
            : [];
        $query = $model::with($relationships);
        foreach ($fields as $key => $value) {
            $query->where($key, $value);
        }

        return $query->first();
    }

    public function getCount(array $options = []) {
        $model = $this->model;
        $modelObject = new $model;
        $table = $modelObject->getTable();
        $tables = $this->getTables();
        $tables[] = $table;
        $columns = $this->getColumns($tables);
        $queryParams = array_diff_key($options, $this->options);
        $firstParam = true;
        $query = $model;

        foreach ($this->leftJoins as $join) {
            if ($firstParam) {
                $query = $query::leftJoin($join['table'], $join['localColumn'],
                    '=', $join['foreignColumn']);
                $firstParam = false;
            } else {
                $query->leftJoin($join['table'], $join['localColumn'], '=',
                    $join['foreignColumn']);
            }
        }

        if ($modelObject->usesTimestamps()) {
            $query = $this->applyDateFilter($query, $queryParams, $table);
        }

        $query = $this->applyCustomFilters($query, $options);
        $query = $this->applyInFilter($query, $options, $table);
        $query = $this->applyNotInFilter($query, $options, $table);

        foreach ($queryParams as $key => $value) {
            if (in_array($key, $columns)) {
                if (is_string($query)) {
                    if ($value === "null") {
                        $query = $query::whereNull($key);
                    } else {
                        $query = $query::where($key, $value);
                    }
                } else {
                    if ($value === "null") {
                        $query->whereNull($key);
                    } else {
                        $query->where($key, $value);
                    }
                }
            } else if (isset($this->additionalColumns[$key])) {
                if (is_string($query)) {
                    if ($value === "null") {
                        $query = $query::whereNull($this->additionalColumns[$key],
                            $value);
                    } else {
                        $query = $query::where($this->additionalColumns[$key],
                            $value);
                    }
                } else {
                    if ($value === "null") {
                        $query->whereNull($this->additionalColumns[$key], $value);
                    } else {
                        $query->where($this->additionalColumns[$key], $value);
                    }
                }
            }
        }

        if (!empty($options["search"])) {
            $search = $options["search"];
            $searchColumns = $this->searchColumns;

            if (is_string($query)) {
                $query = $query::where(function ($q) use ($searchColumns, $search) {
                    foreach ($searchColumns as $col) {
                        $q->orWhere($col, "ILIKE", "%" . $search . "%");
                    }
                });
            } else {
                $query->where(function ($q) use ($searchColumns, $search) {
                    foreach ($searchColumns as $col) {
                        $q->orWhere($col, "ILIKE", "%" . $search . "%");
                    }
                });
            }
        }

        if (!empty($options["filter"])) {
            $search = $options["filter"];
            $filterColumns = $this->filterColumns;
            $query->where(function ($q) use ($filterColumns, $search) {
                foreach ($filterColumns as $col) {
                    $q->orWhere($col, "ILIKE", "%" . $search . "%");
                }
            });
        }

        if (is_string($query)) {
            return $query::count(DB::raw("DISTINCT {$table}.id"));
        } else {
            return $query->count(DB::raw("DISTINCT {$table}.id"));
        }
    }

    public function get($options = []) {
        $model = $this->model;
        $modelObject = new $model;
        $table = $modelObject->getTable();
        $tables = $this->getTables();
        $tables[] = $table;
        $columns = $this->getColumns($tables);
        $queryOptions = array_merge($this->options, $options);
        $queryParams = array_diff_key($options, $this->options);

        $page = intval($queryOptions['page']) > 0 ?
            intval($queryOptions['page']) - 1 : 0;

        $offset = $page * $queryOptions['items'];

        $relationships = is_string($queryOptions['relationships']) ? explode(",",
            $queryOptions['relationships']) : [];

        $query = $model::with($relationships);

        foreach ($this->leftJoins as $join) {
            $query->leftJoin($join['table'], $join['localColumn'], '=',
                $join['foreignColumn']);
        }

        $query->orderBy($queryOptions['orderBy'],
            $queryOptions['orderDirection'])
            ->take($queryOptions['items']);

        if ($offset) {
            $query->offset($offset);
        }

        if ($modelObject->usesTimestamps()) {
            $query = $this->applyDateFilter($query, $queryParams, $table,
                $this->dateFilterColumn);
        }

        $query = $this->applyCustomFilters($query, $options);
        $query = $this->applyInFilter($query, $options, $table);
        $query = $this->applyNotInFilter($query, $options, $table);

        foreach ($queryParams as $key => $value) {
            if (in_array($key, $columns)) {
                if ($value === "null") {
                    $query->whereNull($key);
                } else {
                    $query->where($key, $value);
                }
            } else if (isset($this->additionalColumns[$key])) {
                if ($value === "null") {
                    $query->whereNull($this->additionalColumns[$key]);
                } else {
                    $query->where($key, $value);
                }
            }
        }

        if (!empty($queryOptions["search"])) {
            $search = $queryOptions["search"];
            $searchColumns = $this->searchColumns;
            $query->where(function ($q) use ($searchColumns, $search) {
                foreach ($searchColumns as $col) {
                    $q->orWhere($col, "ILIKE", "%" . $search . "%");
                }
            });
        }

        if (!empty($options["filter"])) {
            $search = $options["filter"];
            $filterColumns = $this->filterColumns;
            $query->where(function ($q) use ($filterColumns, $search) {
                foreach ($filterColumns as $col) {
                    $q->orWhere($col, "ILIKE", "%" . $search . "%");
                }
            });
        }

        if ($queryOptions["count"] == "true") {
            return [
                "count" => $this->getCount($options),
                "items" => $query->distinct($table . ".*")->get([$table . ".*"])
            ];
        }

        return $query->distinct($table . ".*")->get($this->getSelect($table));
    }

    protected function getSelect($table) {
        return [$table . ".*"];
    }

    public function create($model) {
        return $model->save();
    }

    public function update($model, $attributes = []) {
        return $model->update($attributes);
    }

    public function bulkUpdate(array $ids, array $data, array $conditions) {
        $model = $this->model;
        $modelObject = new $model;
        return $model::whereIn($modelObject->getKeyName(), $ids)->where($conditions)->update($data);
    }

    public function bulkDestroy(array $data) {
        $model = $this->model;

        if (count($data) == 0) {
            return 0;
        }

        foreach ($data as $key => $value) {
            if (is_string($model)) {
                $model = $model::where($key, $value);
            } else {
                $model->where($key, $value);
            }
        }

        return $model->delete();
    }

    public function delete($model) {
        return $model->delete();
    }

    protected function getTables() {
        $tables = [];
        foreach ($this->leftJoins as $item) {
            $tables[] = $item['table'];
        }
        return $tables;
    }

    protected function getColumns($tables) {
        $columns = [];

        foreach ($tables as $table) {
            $cols = Schema::getColumnListing($table);
            $columns = array_merge($columns, $cols);
        }
        return $columns;
    }

    public function concatColumns($cols, $table) {
        $columns = [];
        foreach ($cols as $col) {
            $columns[] = $table . "." . $col;
        }
        return $columns;
    }

    protected function applyCustomFilters($query, $options) {
        return $query;
    }

    protected function applySingleFilters($query, $options, $field, $value) {
        return $query;
    }

    protected function applyDateFilter($query, $queryParams, $table,
                                       $column = 'created_at') {
        $format = "Y-m-d";
        $column = $table . "." . $column;
        if (isset($queryParams['start_date'])) {
            $startDate = DateTime::createFromFormat($format,
                $queryParams['start_date']);
            if (isset($queryParams['end_date'])) {
                $endDate = DateTime::createFromFormat($format,
                    $queryParams['end_date']);
                if ($endDate > $startDate) {
                    if (is_string($query)) {
                        $query = $query::whereRaw("DATE({$column}) BETWEEN '{$startDate->format($format)}' "
                            . "AND '{$endDate->format($format)}'");
                    } else {
                        $query->whereRaw("DATE({$column}) BETWEEN '{$startDate->format($format)}' "
                            . "AND '{$endDate->format($format)}'");
                    }
                }
            } else {
                if (is_string($query)) {
                    $query = $query::whereRaw("DATE({$column}) >= '{$startDate->format($format)}'");
                } else {
                    $query->whereRaw("DATE({$column}) >= '{$startDate->format($format)}'");
                }
            }
        } else if (isset($queryParams['end_date'])) {
            $endDate = DateTime::createFromFormat($format,
                $queryParams['end_date']);
            if (is_string($query)) {
                $query = $query::whereRaw("DATE({$column}) <= '{$endDate->format($format)}'");
            } else {
                $query->whereRaw("DATE({$column}) <= '{$endDate->format($format)}'");
            }
        }
        return $query;
    }

    public function applyInFilter($query, $options, $table) {

        if (!isset($options['in'])) {
            return $query;
        }

        $in = explode(",", $options['in']);
        if (count($in) === 0) {
            return $query;
        }

        if (is_string($query)) {
            $query::whereIn("{$table}.id", $in);
        } else {
            $query->whereIn("{$table}.id", $in);
        }

        return $query;
    }

    public function applyNotInFilter($query, $options, $table) {

        if (!isset($options['not_in'])) {
            return $query;
        }

        $in = explode(",", $options['not_in']);
        if (count($in) === 0) {
            return $query;
        }

        if (is_string($query)) {
            $query::whereNotIn("{$table}.id", $in);
        } else {
            $query->whereNotIn("{$table}.id", $in);
        }

        return $query;
    }

}
