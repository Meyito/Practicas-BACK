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
        "sisben_code",
        "area_id",
        "administrative_unit_type_id"
    ];

    protected $hidden = [
        "updated_at"
    ];

    protected static $rules = [
        'name' => 'required',
        'sisben_code' => 'required',
        'area_id' => 'required|exists:areas,id',
        'administrative_unit_type_id' => 'required|exists:administrative_unit_types,id',
    ];

    protected $messages = [
        "name.required" => "El nombre es requerido",
        "sisben_code.required" => "El código sisben es requerido",
        "area_id.required" => "El area es requerida",
        "area_id.exists" => "El area es inválida",
        "administrative_unit_type_id.required" => "El tipo de unidad administrativa es requerida",
        "administrative_unit_type_id.exists" => "El tipo de unidad administrativa es inválida",
    ];

    function area(){
        return $this->belongsTo(Area::class);
    }
    
    function administrative_unit_type(){
        return $this->belongsTo(AdministrativeUnitType::class);
    }

}
