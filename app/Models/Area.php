<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

/**
 * Description of Area Model
 *
 * @author Melissa Delgado
 */
class Area extends BaseModel {

    protected $fillable = [
        "name",
        "code",
        "municipality_id",
        "area_type_id"
    ];

    protected $hidden = [
        "updated_at"
    ];

    protected static $rules = [
        'name' => 'required',
        'code' => 'required',
        'municipality_id' => 'required|exists:municipalities,id',
        'area_type_id' => 'required|exists:area_types,id',
    ];

    protected $messages = [
        "name.required" => "El nombre es requerido",
        "code.required" => "El código es requerido",
        "municipality_id.required" => "El municipio es requerido",
        "municipality_id.exists" => "El municipio es inválido",
        "area_type_id.required" => "El tipo de area es requerida",
        "area_type_id.exists" => "El tipo de area es inválida",
    ];

    function area_type(){
        return $this->belongsTo(AreaType::class);
    }

    function municipality(){
        return $this->belongsTo(Municipality::class);
    }

}
