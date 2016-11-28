<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

/**
 * Description of EthnicGroup Model
 *
 * @author Melissa Delgado
 */
class EthnicGroup extends BaseModel {    

    protected $fillable = [
        "name",
        "abbreviation"
    ];

    protected $hidden = [
        "updated_at"
    ];

    protected static $rules = [
        'name' => 'required|unique:ethnic_groups,name,:ID',
    ];

    protected $messages = [
        "name.required" => "El nombre es requerido",
        "name.unique" => "Ya existe un grupo etnico con el nombre suministrado"
    ];

}
