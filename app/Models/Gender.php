<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

/**
 * Description of Gender Model
 *
 * @author Melissa Delgado
 */
class Gender extends BaseModel {

    protected $fillable = [
        "name",
        "abbreviation"
    ];

    protected $hidden = [
        "updated_at"
    ];

    protected static $rules = [
        'name' => 'required|unique:genders,name,:ID',
        'abbreviation' => 'required|unique:genders,abbreviation,:ID',
    ];

    protected $messages = [
        "name.required" => "El nombre es requerido",
        "name.unique" => "Ya existe un género con el nombre suministrado",
        "abbreviation.required" => "La abreviación es requerida",
        "abbreviation.unique" => "Ya existe un género con la abreviación suministrada"
    ];

}
