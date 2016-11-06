<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

/**
 * Description of EthnicGroup Model
 *
 * @author Melissa Delgado
 */
class EthnicGroup extends Model {

    protected $table = "ethnic_groups";

    protected $fillable = [
        "name"
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

}
