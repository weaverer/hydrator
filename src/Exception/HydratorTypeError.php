<?php
declare(strict_types=1);

namespace Weaverer\Hydrator\Exception;

use Weaverer\Hydrator\Utils;

class HydratorTypeError extends \Exception
{
    public string $expectedType;
    public mixed $givenValue;

    public function __construct(string $expectedType, mixed $givenValue,\Exception $previous = null)
    {
        $this->expectedType = $expectedType;
        $this->givenValue = $givenValue;
        $message = sprintf('Expected type: %s, given: %s<%s>.', $expectedType, gettype($givenValue),Utils::varToString($givenValue));
        parent::__construct($message,0,$previous);
    }
}