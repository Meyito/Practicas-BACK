<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

/**
 * Description of Age Range Model
 *
 * @author Melissa Delgado
 */
class AgeRange extends BaseModel {

    protected $table = "age_range";

    protected $fillable = [
        "name",
        "min_age",
        "max_age"
    ];

    protected $hidden = [
        "updated_at"
    ];

    protected static $rules = [
        'name' => 'required|unique:age_range,name,:ID',
        'min_age' => 'required',
        'max_age' => 'required'
    ];

    protected $messages = [
        "name.required" => "El nombre es requerido",
        "min_age.required" => "La edad mínima es requerido",
        "max_age.required" => "La edad máxima es requerido",
        "name.unique" => "Ya existe un rango de edad con el nombre suministrado"
    ];

}
