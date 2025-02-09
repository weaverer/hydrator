<?php
declare(strict_types=1);

namespace Weaverer\Hydrator\Exception;

use Exception;

class HydratorException extends Exception
{
    public function __construct(string $message = "", int $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}