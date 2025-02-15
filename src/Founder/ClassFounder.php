<?php
declare(strict_types=1);

namespace Weaverer\Hydrator\Founder;

use Weaverer\Hydrator\Utils;

class ClassFounder extends Founder
{
    public function found($value, ?string $mapWayName = null): ?object
    {
        $value = $this->toConvertValue($value);
        if (null === $value || is_object($value) || is_array($value)) {
             return new ($this->typeName)($value,$mapWayName);
        }
        $this->throwTypeError(Utils::OBJECT, $value);
    }
}