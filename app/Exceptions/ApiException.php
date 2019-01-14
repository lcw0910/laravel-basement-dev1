<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Request;
use Throwable;

class ApiException extends Exception
{
    /**
     * @var array|null $errors
     */
    protected $errors = [];

    /**
     * ApiException constructor.
     * @param int $code
     * @param string $message
     * @param array $errors
     * @param Throwable|null $previous
     */
    public function __construct(int $code = 0, string $message = "", array $errors = [], Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->errors = $errors ?: null;
    }

    /**
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
    public function render()
    {
        return response($this->errors, $this->getCode());
    }
}
