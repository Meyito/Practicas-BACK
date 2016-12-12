<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

/**
 * Description of View Model
 *
 * @author Melissa Delgado
 */
class View extends BaseModel {

    protected $fillable = [
        "id",
        "view_name"
    ];

    protected $hidden = [
        "updated_at"
    ];

    protected static $rules = [
        'id' => 'required|unique:views,id,:ID',
        'view_name' => 'required|unique:views,view_name,:ID',
    ];

    protected $messages = [
        "view_name.required" => "El nombre es requerido",
        "view_name.unique" => "Ya existe una vista con el nombre suministrado",
        "id.required" => "El id es requerido",
        "id.unique" => "Ya existe una vista con el id suministrado"
    ];

}
