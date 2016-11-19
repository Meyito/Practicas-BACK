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
        "dimention_id",
        "created_by"
    ];

    protected $hidden = [
        "updated_at"
    ];

    protected static $rules = [
        'code' => 'required',
        'name' => 'required',
        'dimention_id' => 'required|exists:dimentions,id'
    ];

    protected $messages = [
        "dimention_id.required" => "La dimensión es requerida",
        "dimention_id.exists" => "La dimensión es inválida",
        "code.required" => "El número de identificación es requerido",
        "name.required" => "El nombre es requerido",
    ];

    function dimention(){
        return $this->belongsTo(Dimention::class);
    }

    function programs(){
        return $this->hasMany(Program::class);
    }

}
