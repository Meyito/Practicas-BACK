<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

/**
 * Description of BaseModel
 *
 * @author Francisco Bastos
 */
class Axe extends BaseModel {

    protected $fillable = [
        "code",
        "name",
        "dimension_id",
        "created_by"
    ];

    protected $hidden = [
        "updated_at"
    ];

    protected static $rules = [
        'code' => 'required',
        'name' => 'required',
        'dimension_id' => 'required|exists:dimentions,id'
    ];

    protected $messages = [
        "dimension_id.required" => "La dimensión es requerida",
        "dimension_id.exists" => "La dimensión es inválida",
        "code.required" => "El número de identificación es requerido",
        "name.required" => "El nombre es requerido",
    ];

    function dimention(){
        return $this->belongsTo(Dimention::class);
    }

}
