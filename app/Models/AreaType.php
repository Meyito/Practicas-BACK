<?php

namespace App\Models;

use App\Models\BaseModel;

/**
 * Description of AreaType
 *
 * @author Melissa Delgado
 */
class AreaType extends BaseModel {

    protected $fillable = [
        "code",
        "name",
        "sisben_zone_id"
    ];

    protected $hidden = [
        "updated_at"
    ];

    protected static $rules = [
        'code' => 'required|unique:area_types,code,:ID',
        'name' => 'required',
        'sisben_zone_id' => 'required|exists:sisben_zones,id'
    ];

    protected $messages = [
        "sisben_zone_id.required" => "La zona sisben es requerida",
        "sisben_zone_id.exists" => "La zona sisben es inválida",
        "code.required" => "El código es requerido",
        "code.unique" => "Ya existe un tipo de area con el código suministrado",
        "name.required" => "El nombre es requerido",
    ];

    function sisben_zone(){
        return $this->belongsTo(SisbenZone::class);
    }

}
