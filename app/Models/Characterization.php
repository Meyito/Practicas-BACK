<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

/**
 * Description of Characterization Model
 *
 * @author Melissa Delgado
 */
class Characterization extends BaseModel {

    protected $fillable = [
        "person_id",
        "first_name",
        "last_name",
        "second_last_name",
        "age",
        "is_mentally_disabled",
        "age_range_id",
        "gender_id",
        "special_condition_id",
        "hearing_impairment_id",
        "visual_impairment_id",
        "motor_disability_id",
        "victim_type_id",
        "ethnic_group_id",
        "is_mother_head"
    ];

    protected $hidden = [
        "updated_at"
    ];

    protected static $rules = [
        'person_id' => 'required|exists:people,id',
        'first_name' => 'required',
        'last_name' => 'required',        
        'age' => 'required',
        'is_mentally_disabled' => 'required',
        'age_range_id' => 'required|exists:age_range,id',
        'gender_id' => 'required|exists:genders,id',
        'special_condition_id' => 'required|exists:special_conditions,id',
        'hearing_impairment_id' => 'required|exists:hearing_impairments,id',
        'visual_impairment_id' => 'required|exists:visual_impairments,id',
        'motor_disability_id' => 'required|exists:motor_disabilities,id',
        'victim_type_id' => 'required|exists:victim_types,id',
        'ethnic_group_id' => 'required|exists:victim_types,id',
    ];

    protected $messages = [
        "person_id.required" => "La persona es requerida",
        "person_id.exists" => "La persona es inválida",
        "first_name.required" => "El nombre de la persona es requerido",
        "last_name.required" => "El apellido es requerido",
        "is_mentally_disabled.required" => "La condición mental es requerida",
        "age_range_id.required" => "El rango de edad es requerido",
        "age_range_id.exists" => "El rango de edad es inválido",
        "gender_id.required" => "El género es requerido",
        "gender_id.exists" => "El género es inválido",
        "special_condition_id.required" => "La condición especial es requerida",
        "special_condition_id.exists" => "La condición especial es inválida",
        "hearing_impairment_id.required" => "La discapacidad auditiva es requerida",
        "hearing_impairment_id.exists" => "La discapacidad auditiva es inválida",
        "visual_impairment_id.required" => "La discapacidad visual es requerida",
        "visual_impairment_id.exists" => "La discapacidad visual es inválida",
        "motor_disability_id.required" => "La discapacidad motriz es requerida",
        "motor_disability_id.exists" => "La discapacidad motriz es inválida",
        "victim_type_id.required" => "El tipo de victima es requerida",
        "victim_type_id.exists" => "El tipo de victima es inválida",
        "ethnic_group_id.required" => "El grupo etnico es requerido",
        "ethnic_group_id.exists" => "El grupo etnico es inválido"
    ];

    function activities(){
        return $this->belongsToMany('App\Models\Activity', 'activity_characterizations', 'characterization_id', 'activity_id');
    }
}
