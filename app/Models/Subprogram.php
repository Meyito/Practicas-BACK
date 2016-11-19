<?php

namespace App\Models;

use App\Models\BaseModel;

/**
 * Description of Program
 *
 * @author Melissa Delgado
 */
class Subprogram extends BaseModel {

    protected $fillable = [
        "code",
        "name",
        "program_id"
    ];

    protected $hidden = [
        "updated_at"
    ];

    protected static $rules = [
        'code' => 'required',
        'name' => 'required',
        'program_id' => 'required|exists:programs,id'
    ];

    protected $messages = [
        "program_id.required" => "El programa es requerido",
        "program_id.exists" => "El programa es inválido",
        "code.required" => "El código es requerido",
        "name.required" => "El nombre es requerido",
    ];

    function program(){
        return $this->belongsTo(Program::class);
    }

    function goals(){
        return $this->hasMany(Goal::class);
    }

}
