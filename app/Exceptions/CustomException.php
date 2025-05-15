<?php

namespace App\Exceptions;

use Exception;

class CustomException extends Exception
{
    protected $message;
    protected $code;

    public function __construct($message, $code = 400)
    {
        parent::__construct($message, $code);
        $this->message = $message;
        $this->code = $code;
    }

    public function render($request)
    {
        return response()->json([
            'success' => false,
            'message' => $this->message,
        ], $this->code);
    }
}