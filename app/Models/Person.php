<?php

namespace App\Models;

use App\Models\BaseModel;

/**
 * Description of Person
 *
 * @author Francisco Bastos
 */
class Person extends BaseModel {

    protected $table = "people";

    protected $fillable = [
        "identification_type_id",
        "identification_number"
    ];

    protected $hidden = [
        "updated_at"
    ];

    protected static $rules = [
        'identification_type_id' => 'required|exists:identification_types,id',
        'identification_number' => 'required|unique:people,identification_number,:ID'
    ];

    protected $messages = [
        "identification_type_id.required" => "El tipo de identificación es requerido",
        "identification_type_id.exists" => "El tipo de identificación es inválido",
        "identification_number.required" => "El número de identificación es inválido",
        "identification_number.unique" => "Ya existe una persona con el número de identificación suministrado",
    ];

    function identification_type(){
        return $this->belongsTo(IdentificationType::class);
    }

}
