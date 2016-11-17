<?php

namespace App\Models;

use App\Models\BaseModel;

/**
 * Description of SisbenZone
 *
 * @author Melissa Delgado
 */
class SisbenZone extends BaseModel {

    protected $fillable = [
        "code",
        "name"
    ];

    protected $hidden = [
        "updated_at"
    ];

    protected static $rules = [
        'code' => 'required',
        'name' => 'required'
    ];

    protected $messages = [
        "code.required" => "El código es requerido",
        "name.required" => "El nombre es requerido",
    ];

}
