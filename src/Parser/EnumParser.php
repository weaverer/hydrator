<?php
declare(strict_types=1);

namespace Weaverer\Hydrator\Parser;

use ReflectionEnum;
use Weaverer\Hydrator\Types\EnumType;

class EnumParser
{
    private ReflectionEnum $enumRef;

    public function __construct($enumName)
    {
        $this->enumRef = new ReflectionEnum($enumName);
    }

    public function isBacked(): bool
    {
        return $this->enumRef->isBacked();
    }

    public function parseBacked(): EnumType
    {
        $type = new EnumType();
        $type->backingType = $this->enumRef->getBackingType()->getName();
        $cases = $this->enumRef->getCases();
        $type->values = array_map(function ($case) {
            return $case->getValue()->value;
        }, $cases);
        return $type;
    }
}
