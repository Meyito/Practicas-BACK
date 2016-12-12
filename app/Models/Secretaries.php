<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

/**
 * Description of Secretaries Model
 *
 * @author Melissa Delgado
 */
class Secretaries extends BaseModel {

    protected $table = "secretaries";

    protected $fillable = [
        "name",
        "id"
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

    function programs(){
        return $this->belongsToMany('App\Models\Programs', 'secretary_programs', 'secretary_id', 'program_id');
    }

}
