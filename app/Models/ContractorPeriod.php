<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

/**
 * Description of ContractorPeriods Model
 *
 * @author Melissa Delgado
 */
class ContractorPeriod extends BaseModel {

    protected $table = "contractor_periods";

    protected $fillable = [
        "contractor_id",
        "contract_code",
        "init_date",
        "end_date"
    ];

    protected $hidden = [
        "updated_at"
    ];

    protected static $rules = [
        'contractor_id' => 'required|exists:contractors,id',
        'contract_code' => 'required',
        'init_date' => 'required',
        'end_date' => 'required',
    ];

    protected $messages = [
        "contractor_id.required" => "El contratista es requerido",
        "contract_code.required" => "El número del contrato es requerido",
        "init_date.required" => "El código es requerido",
        "end_date.required" => "El código es requerido",
        "contractor_id.exists" => "El contratista es inválido",
    ];

    function contractor(){
        return $this->belongsTo(Contractor::class);
    }

}
