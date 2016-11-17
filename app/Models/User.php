<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;

class User extends BaseModel implements
    AuthenticatableContract,
    AuthorizableContract,
    JWTSubject {

    use Authenticatable, Authorizable;

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

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

}