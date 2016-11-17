<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

/**
 * Description of AdministrativeUnit Model
 *
 * @author Melissa Delgado
 */
class AdministrativeUnit extends BaseModel {

    protected $fillable = [
        "name",
        "code",
        "sisben_code",
        "area_id",
        "administrative_unit_type_id"
    ];

    protected $hidden = [
        "updated_at"
    ];

    protected static $rules = [
        'name' => 'required',
        'code' => 'required|unique:administrative_units,code,:ID',
        'sisben_code' => 'required|unique:administrative_units,code,:ID',
        'area_id' => 'required|exists:areas,id',
        'administrative_unit_type_id' => 'required|exists:administrative_unit_types,id',
    ];

    protected $messages = [
        "name.required" => "El nombre es requerido",
        "code.required" => "El código es requerido",
        "code.unique" => "Ya existe un area administrativa con el código suministrado",
        "sisben_code.required" => "El código sisben es requerido",
        "sisben_code.unique" => "Ya existe un area administrativa con el código sisben suministrado",
        "area_id.required" => "El area es requerida",
        "area_id.exists" => "El area es inválida",
        "administrative_unit_type_id.required" => "El tipo de unidad administrativa es requerida",
        "administrative_unit_type_id.exists" => "El tipo de unidad administrativa es inválida",
    ];

}
