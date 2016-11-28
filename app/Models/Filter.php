<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

/**
 * Description of Filter Model
 *
 * @author Melissa Delgado
 */
class Filter extends BaseModel {

    function filters(){
        return $this->belongsToMany('App\Models\Counter', 'counter_filters', 'filter_id', 'counter_id');
    }

}
