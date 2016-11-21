<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

/**
 * Description of Zone Model
 *
 * @author Melissa Delgado
 */
class Zone extends BaseModel {

    protected $fillable = [
        "name",
        "code",
        "department_id"
    ];

    protected $hidden = [
        "updated_at"
    ];

    protected static $rules = [
        'name' => 'required',
        'code' => 'required|unique:zones,code,:ID',
        'department_id' => 'required|exists:departments,id'
    ];

    protected $messages = [
        "name.required" => "El nombre es requerido",
        "code.required" => "El código es requerido",
        "code.unique" => "Ya existe una zona con el código suministrado",
        "department_id.required" => "El departamento es requerido",
        "department_id.exists" => "El departamento es inválido",
    ];

}
