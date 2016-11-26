<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

/**
 * Description of Contract Model
 *
 * @author Melissa Delgado
 */
class Contract extends BaseModel {

    protected $fillable = [
        "code",
        "init_date",
        "end_date"
    ];

    protected $hidden = [
        "updated_at"
    ];

    protected static $rules = [
        'code' => 'required|unique:contracts,code,:ID',
        'init_date' => 'required',
        'end_date' => 'required',
    ];

    protected $messages = [
        "code.required" => "El número del contrato es requerido",
        "code.unique" => "Ya existe un contrato con el código suministrado",
        "init_date.required" => "El código es requerido",
        "end_date.required" => "El código es requerido"
    ];

    function contractors(){
        return $this->belongsToMany(Contractor::class, 'contractor_contracts', 'contract_id', 'contractor_id' );
    }

}
