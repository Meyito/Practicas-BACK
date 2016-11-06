<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

/**
 * Description of Gender Model
 *
 * @author Melissa Delgado
 */
class Gender extends Model {

    protected $fillable = [
        "name"
    ];

    protected $hidden = [
        "updated_at"
    ];

    protected static $rules = [
        'name' => 'required',
    ];

    protected $messages = [
        "name.required" => "El nombre es requerido",
    ];

}
