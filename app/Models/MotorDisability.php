<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

/**
 * Description of MotorDisability Model
 *
 * @author Melissa Delgado
 */
class MotorDisability extends BaseModel {

    protected $table = "motor_disabilities";

    protected $fillable = [
        "name"
    ];

    protected $hidden = [
        "updated_at"
    ];

    protected static $rules = [
        'name' => 'required|unique:motor_disabilities,name,:ID',
    ];

    protected $messages = [
        "name.required" => "El nombre es requerido",
        "name.unique" => "Ya existe una discapacidad motriz con el nombre suministrado"
    ];

}
