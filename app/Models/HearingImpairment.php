<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

/**
 * Description of HearingImpairment Model
 *
 * @author Melissa Delgado
 */
class HearingImpairment extends BaseModel {

    protected $fillable = [
        "name"
    ];

    protected $hidden = [
        "updated_at"
    ];

    protected static $rules = [
        'name' => 'required|unique:hearing_impairments,name,:ID'
    ];

    protected $messages = [
        "name.required" => "El nombre es requerido",
        "name.unique" => "Ya existe una discapacidad auditiva con el nombre suministrado"
    ];

}
