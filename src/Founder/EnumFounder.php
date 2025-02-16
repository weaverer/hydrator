<?php
declare(strict_types=1);

namespace Weaverer\Hydrator\Founder;

use BackedEnum;
use Weaverer\Hydrator\Exception\HydratorTypeError;
use Weaverer\Hydrator\Types\EnumType;
use Weaverer\Hydrator\Utils;

class EnumFounder extends Founder
{
    public EnumType $enumType;

    public function setEnumType(EnumType $enumType): self
    {
        $this->enumType = $enumType;
        return $this;
    }

    public function found($value,?string $mapWayName = null): ?BackedEnum
    {
        if (is_a($value, $this->typeName)) {
            $value = $value->value;
        }
        $value = $this->toConvertValue($value);
        if (null === $value) {
            return null;
        }

        if (!is_int($value) && !is_string($value)) { //回退枚举类型只有int和string
            $this->throwTypeError(Utils::ENUM, $value);
        }
        if ($this->enumType->backingType === Utils::INT) {
            $value = (int)$value;
        }
        if ($this->enumType->backingType === Utils::STRING) {
            $value = (string)$value;
        }

        if (!in_array($value, $this->enumType->values, true)) {
            throw new HydratorTypeError(sprintf("enum expected one of:%s",implode(', ', $this->enumType->values)), $value);
        }
        return $this->typeName::from($value);


    }

}
