<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

/**
 * Description of Counter Model
 *
 * @author Melissa Delgado
 */
class Counter extends BaseModel {

    function filters(){
        return $this->belongsToMany('App\Models\Filter', 'counter_filters', 'counter_id', 'filter_id');
    }

}
