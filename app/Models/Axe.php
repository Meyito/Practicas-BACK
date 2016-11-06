<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

/**
 * Description of BaseModel
 *
 * @author Francisco Bastos
 */
class Axe extends BaseModel {

    protected $fillable = [
        "code",
        "name",
        "development_plan_id",
        "created_by"
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

    function identification_type(){
        return $this->belongsTo(DevelopmentPlan::class);
    }

}
