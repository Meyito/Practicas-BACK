<?php

namespace App\Models;

use App\Models\BaseModel;

/**
 * Description of Dimention
 *
 * @author Melissa Delgado
 */
class Dimention extends BaseModel {

    protected $fillable = [
        "code",
        "name",
        "development_plan_id",
    ];

    protected $hidden = [
        "updated_at"
    ];

    protected static $rules = [
        'code' => 'required',
        'name' => 'required',
        'development_plan_id' => 'required|exists:development_plans,id'
    ];

    protected $messages = [
        "development_plan_id.required" => "El plan de desarrollo es requerido",
        "development_plan_id.exists" => "El plan de desarrollo es inválido",
        "code.required" => "El número de identificación es requerido",
        "name.required" => "El nombre es requerido",
    ];

    function development_plan(){
        return $this->belongsTo(DevelopmentPlan::class);
    }

    function axes(){
        return $this->hasMany(Axe::class);
    }

}
