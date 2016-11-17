<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

/**
 * Description of AdministrativeUnitType Model
 *
 * @author Melissa Delgado
 */
class AdministrativeUnitType extends BaseModel {

    protected $fillable = [
        "name",
        "code"
    ];

    protected $hidden = [
        "updated_at"
    ];

    protected static $rules = [
        'name' => 'required',
        'code' => 'required|unique:administrative_unit_types,code,:ID'
    ];

    protected $messages = [
        "name.required" => "El nombre es requerido",
        "code.required" => "El código es requerido",
        "code.unique" => "Ya existe una unidad administrativa con el código suministrado"
    ];

}
