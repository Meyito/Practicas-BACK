<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

/**
 * Description of Activity Model
 *
 * @author Melissa Delgado
 */
class Activity extends BaseModel {

    protected $table = "activities";

    protected $fillable = [
        "description",
        "code",
        "date",
        "rubro",
        "registro_pptal",
        "project_id",
        "goal_id"
    ];

    protected $hidden = [
        "updated_at"
    ];

    protected static $rules = [
        'description' => 'required',
        'code' => 'required|unique:activities,code,:ID',
        'date' => 'required',
        'rubro' => 'required',
        'registro_pptal' => 'required',
        'project_id' => 'required|exists:projects,id',
        'goal_id' => 'required|exists:goals,id',
    ];

    protected $messages = [
        "description.required" => "La descripcion de la actividad es requerida",
        "code.required" => "El código es requerido",
        "code.unique" => "Ya existe una actividad con el código suministrado",
        "date.required" => "La fecha es requerida",
        "rubro.required" => "El rubro es requerido",
        "registro_pptal.required" => "El registro presupuestal es requerido",
        "area_id.exists" => "El area es inválida",
        "project_id.required" => "El proyecto es requeridp",
        "project_id.exists" => "El proyecto es inválida",
        "goal_id.required" => "La meta es requerida",
        "goal_id.exists" => "La meta es inválida",
    ];

}
