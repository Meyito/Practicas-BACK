<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class Secretaries extends Model {

    protected $table = "secretaries";

    protected $fillable = [
        "name",
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
