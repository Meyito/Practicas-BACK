<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;

/**
 * Description of User Model
 *
 * @author Melissa Delgado
 */

class User extends BaseModel implements
    AuthenticatableContract,
    AuthorizableContract{

    use Authenticatable, Authorizable;

    protected $table = "users";

    protected $fillable = [
        "username",
        "password",
        "name",
        "role_id",
        "secretary_id"
    ];

    protected $hidden = [
        "updated_at",
        "password"
    ];

    protected static $rules = [
        'username' => 'required|unique:users,username,:ID',
        'role_id' => 'required|exists:roles,id',
        'secretary_id' => 'exists:secretaries,id',
        'password' => 'required',
        'name' => 'required'
    ];

    protected $messages = [
        "role_id.required" => "El rol del usuario es requerido",
        "role_id.exists" => "El rol es inválido",
        "secretary_id.exists" => "La secretaría es inválida",
        "username.required" => "El nombre de usuario es requerido",
        "password.required" => "El nombre de usuario es requerido",
        "name.required" => "El nombre es requerido",
        "username.unique" => "Ya existe un usuario con el nombre de usuario suministrado",
    ];

    function secretary(){
        return $this->belongsTo(Secretaries::class);
    }

    function role(){
        return $this->belongsTo(Role::class);
    }

}