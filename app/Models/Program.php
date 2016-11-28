<?php

namespace App\Models;

use App\Models\BaseModel;

/**
 * Description of Program
 *
 * @author Melissa Delgado
 */
class Program extends BaseModel {

    protected $fillable = [
        "code",
        "name",
        "axe_id"
    ];

    protected $hidden = [
        "updated_at"
    ];

    protected static $rules = [
        'code' => 'required',
        'name' => 'required',
        'axe_id' => 'required|exists:axes,id'
    ];

    protected $messages = [
        "axe_id.required" => "El eje es requerido",
        "axe_id.exists" => "El eje es inválido",
        "code.required" => "El código es requerido",
        "name.required" => "El nombre es requerido",
    ];

    function axe(){
        return $this->belongsTo(Axe::class);
    }

    function subprograms(){
        return $this->hasMany(Subprogram::class);
    }

    function goals(){
        return $this->hasManyThrough(Goal::class, Subprogram::class);
    }

    function secretaries(){
        return $this->belongsToMany('App\Models\secretaries', 'secretary_programs', 'program_id', 'secretary_id');
    }

}
