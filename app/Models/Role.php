<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

/**
 * Description of Role Model
 *
 * @author Melissa Delgado
 */
class Role extends BaseModel {

    protected $fillable = [
        "id",
        "role_name",
        "label"
    ];

    protected $hidden = [
        "updated_at"
    ];

    protected static $rules = [
        'id' => 'required|unique:roles,id,:ID',
        'role_name' => 'required|unique:roles,role_name,:ID',
    ];

    protected $messages = [
        "role_name.required" => "El nombre es requerido",
        "role_name.unique" => "Ya existe un rol con el nombre suministrado",
        "id.required" => "El id es requerido",
        "id.unique" => "Ya existe una vista con el id suministrado"
    ];

    function views(){
        return $this->belongsToMany('App\Models\View', 'role_views', 'role_id', 'view_id');
    }

}
