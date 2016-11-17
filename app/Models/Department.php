<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

/**
 * Description of Department Model
 *
 * @author Melissa Delgado
 */
class Department extends BaseModel {

    protected $fillable = [
        "name",
        "code",
    ];

    protected $hidden = [
        "updated_at"
    ];

    protected static $rules = [
        'name' => 'required',
        'code' => 'required|unique:departments,code,:ID',
    ];

    protected $messages = [
        "name.required" => "El nombre es requerido",
        "code.required" => "El código es requerido",
        "code.unique" => "Ya existe un departamento con el código suministrado",
    ];

}
