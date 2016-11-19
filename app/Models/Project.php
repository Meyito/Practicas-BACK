<?php

namespace App\Models;

use App\Models\BaseModel;

/**
 * Description of Program
 *
 * @author Melissa Delgado
 */
class Project extends BaseModel {

    protected $fillable = [
        "code",
        "name",
        "description",
        "subprogram_id",
        "status"
    ];

    protected $hidden = [
        "updated_at"
    ];

    protected static $rules = [
        'code' => 'required|unique:projects,code,:ID',
        'name' => 'required',
        'subprogram_id' => 'required|exists:subprograms,id'
    ];

    protected $messages = [
        "subprogram_id.required" => "El subprograma es requerido",
        "subprogram_id.exists" => "El subprograma es inválido",
        "code.unique" => "Ya existe un proyecto con el código suministrado",
        "code.required" => "El código es requerido",
        "name.required" => "El nombre es requerido",
    ];

    function subprogram(){
        return $this->belongsTo(Subprogram::class);
    }

}
