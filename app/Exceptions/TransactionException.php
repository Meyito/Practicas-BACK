<?php

namespace App\Exceptions;

use Exception;

/**
 * Description of TransactionException
 *
 * @author Melissa Delgado
 */
class TransactionException extends Exception {

    protected $arrayErrors;

    public function __construct($arrayErrors, $message, $code = 0,
            Exception $previous = null) {

        $this->arrayErrors = $arrayErrors;
        parent::__construct($message, $code, $previous);
    }

    public function getErrorsArray() {
        return $this->arrayErrors;
    }

}