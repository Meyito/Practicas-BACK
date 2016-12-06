<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;

class User extends BaseModel implements
    AuthenticatableContract,
    AuthorizableContract{

    use Authenticatable, Authorizable;

    protected $fillable = [
        "username",
        "password",
        "name"
    ];

    protected $hidden = [
        "updated_at",
        "password"
    ];

    protected static $rules = [
        'username' => 'required|unique:user,username,:ID',
        'password' => 'required',
        'name' => 'required'
    ];

    protected $messages = [
        "username.required" => "El nombre de usuario es requerido",
        "password.required" => "El nombre de usuario es requerido",
        "name.required" => "El nombre es requerido",
        "username.unique" => "Ya existe un usuario con el nombre de usuario suministrado",
    ];

    function secretary(){
        return $this->belongsTo(Secretary::class);
    }

}