<?php

namespace App\Models;

use App\Models\BaseModel;

/**
 * Description of DevelopmentPlan
 *
 * @author Melissa Delgado
 */
class DevelopmentPlan extends BaseModel {

    public $timestamps = false;

    protected $fillable = [
        "name",
        "init_year",
        "end_year"
    ];

    protected static $rules = [
        'name' => 'required',
        'init_year' => 'required',
        'end_year' => 'required',  
    ];

    protected $messages = [
        "name.required" => "El nombre es requerido",    
        "init_year.required" => "El año de inicio es requerido",
        "end_year.required" => "El año de fin es requerido",
    ];

    function dimentions(){
        return $this->hasMany(Dimention::class);
    }
}
