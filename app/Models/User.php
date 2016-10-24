<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class User extends Model {

    protected $fillable = [
        "username",
        "password"
    ];

    protected $hidden = [
        "updated_at",
        "password"
    ];

    protected static $rules = [
        'username' => 'required|unique:user,username,:ID',
        'password' => 'required'
    ];

    protected $messages = [
        "username.required" => "El nombre de usuario es requerido",
        "password.required" => "El nombre de usuario es requerido",
        "username.unique" => "Ya existe un usuario con el nombre de usuario suministrado",
    ];

    function secretary(){
        return $this->belongsTo(Secretary::class);
    }

}
