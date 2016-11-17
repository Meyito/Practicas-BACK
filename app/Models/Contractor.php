<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

/**
 * Description of Contractor Model
 *
 * @author Melissa Delgado
 */
class Contractor extends BaseModel {

    protected $fillable = [
        "first_name",
        "last_name",
        "identification_number",
        "identification_type_id"
    ];

    protected $hidden = [
        "updated_at"
    ];

    protected static $rules = [
        'first_name' => 'required',
        'last_name' => 'required',
        'identification_type_id' => 'required|exists:identification_types,id',
        'identification_number' => 'required|unique:contractors,identification_number,:ID'
    ];

    protected $messages = [
        "first_name.required" => "El nombre es requerido",
        "last_name.required" => "El apellido es requerido",
        "identification_type_id.required" => "El tipo de identificación es requerido",
        "identification_type_id.exists" => "El tipo de identificación es inválido",
        "identification_number.required" => "El número de identificación es requerido",
        "identification_number.unique" => "Ya existe un contratista con el número de identificación suministrado",
    ];

    function identification_type(){
        return $this->belongsTo(IdentificationType::class);
    }

}
