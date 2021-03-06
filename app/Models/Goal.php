<?php

namespace App\Models;

use App\Models\BaseModel;

/**
 * Description of Goal Model
 *
 * @author Melissa Delgado
 */
class Goal extends BaseModel {

    protected $fillable = [
        "code",
        "name",
        "subprogram_id"
    ];

    protected $hidden = [
        "updated_at"
    ];

    protected static $rules = [
        'code' => 'required',
        'name' => 'required',
        'subprogram_id' => 'required|exists:subprograms,id'
    ];

    protected $messages = [
        "subprogram_id.required" => "El subprograma es requerido",
        "subprogram_id.exists" => "El subprograma es inválido",
        "code.required" => "El código es requerido",
        "name.required" => "El nombre es requerido",
    ];

    function subprogram(){
        return $this->belongsTo(Subprogram::class);
    }

}
