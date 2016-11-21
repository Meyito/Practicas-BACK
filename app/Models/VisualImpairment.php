<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

/**
 * Description of Visual Impairment Model
 *
 * @author Melissa Delgado
 */
class VisualImpairment extends BaseModel {

    protected $fillable = [
        "name",
        "abbreviation"
    ];

    protected $hidden = [
        "updated_at"
    ];

    protected static $rules = [
        'name' => 'required|unique:visual_impairments,name,:ID',
        'abbreviation' => 'required|unique:visual_impairments,abbreviation,:ID',
    ];

    protected $messages = [
        "name.required" => "El nombre es requerido",
        "name.unique" => "Ya existe una discapacidad visual con el nombre suministrado"
    ];

}
