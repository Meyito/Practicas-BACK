<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\UserHelper;
use App\Models\HearingImpairment;
use App\Repositories\IdentificationTypeRepository as IdentificationTypeRepo;
use Illuminate\Http\Response as IlluminateResponse;

/**
 *
 * @author Melissa Delgado
 */

class IdentificationTypeController extends Controller {

    private $identification_type;

    function __construct(IdentificationTypeRepo $identificationTypeRepo) {
        $this->identification_type = $identificationTypeRepo;
    }

    public function index(Request $request) {
        $options = $request->all() ?: [];
        return response()->json($this->identification_type->get($options));
    }
}
