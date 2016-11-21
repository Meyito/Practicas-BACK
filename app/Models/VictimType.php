<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

/**
 * Description of VictimType Model
 *
 * @author Melissa Delgado
 */
class VictimType extends BaseModel {

    protected $fillable = [
        "name",
        "abbreviation"
    ];

    protected $hidden = [
        "updated_at"
    ];

    protected static $rules = [
        'name' => 'required|unique:victim_types,name,:ID',
        'abbreviation' => 'required|unique:victim_types,abbreviation,:ID',
    ];

    protected $messages = [
        "name.required" => "El nombre es requerido",
        "name.unique" => "Ya existe un tipo de víctima con el nombre suministrado"
    ];

}
