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
        "goal_id",
        "contractor_contract_id",
        "administrative_unit_id",
        "secretary_id"
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
        'contractor_contract_id' => 'required|exists:contractor_contracts,id',
        'administrative_unit_id' => 'required|exists:administrative_units,id',
        'secretary_id' => 'required|exists:secretaries,id'
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
        "contractor_contract_id.required" => "El contrato/contratista es requerido",
        "contractor_contract_id.exists" => "El contrato/contratista es inválido",
        "administrative_unit_id.required" => "La localización es requerida",
        "administrative_unit_id.exists" => "La localización es inválida",
        "secretary_id.required" => "La secretaria es requerida",
        "secretary_id.exists" => "La secretaria es inválida",
    ];

    function assistants(){
        return $this->belongsToMany('App\Models\Characterization', 'activity_characterizations', 'activity_id', 'characterization_id');
    }

}
