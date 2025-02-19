<?php

namespace Weaverer\Hydrator\Exception;

class ValidateException extends \Exception
{
    private array $errors;

    public function __construct(array $errors, $code = 0, \Throwable $previous = null)
    {
        $this->errors = $errors;
        parent::__construct("param error", $code, $previous);
    }

    public function getErrors()
    {
        return $this->errors;
    }
}
