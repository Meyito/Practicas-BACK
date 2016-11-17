<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

/**
 * Description of Municipality Model
 *
 * @author Melissa Delgado
 */
class Municipality extends BaseModel {

    protected $table = "municipalities"; 

    protected $fillable = [
        "name",
        "code",
        "zone_id"
    ];

    protected $hidden = [
        "updated_at"
    ];

    protected static $rules = [
        'name' => 'required',
        'code' => 'required|unique:municipalities,code,:ID',
        'zone_id' => 'required|exists:sisben_zones,id'
    ];

    protected $messages = [
        "name.required" => "El nombre es requerido",
        "code.required" => "El código es requerido",
        "code.unique" => "Ya existe un municipio con el código suministrado",
        "zone_id.required" => "La zona es requerida",
        "zone_id.exists" => "La zona es inválida",
    ];

}
