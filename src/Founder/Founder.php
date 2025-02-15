<?php
declare(strict_types=1);

namespace Weaverer\Hydrator\Founder;

use Weaverer\Hydrator\Interface\ValueConvertInterface;
use Weaverer\Hydrator\Types\DataType;
use Weaverer\Hydrator\Utils;

class Founder
{
    /** @var array<string,ValueConvertInterface> */
    protected array $valueConvert = [];

    protected string $typeName;

    public function found($value,?string $mapWayName = null)
    {
        return $value;
    }


    public function setTypeName(string $typeName): static
    {
        $this->typeName = $typeName;
        return $this;
    }


    public function setValueConvert(array $valueConvert): self
    {
        $this->valueConvert = $valueConvert;
        return $this;
    }

    protected function toConvertValue($value)
    {
        $converters = $this->valueConvert ?? [];
        if (empty($converters)) {
            return $value;
        }
        foreach ($converters as $converter) {
            $value = $converter->convert($value);
        }
        return $value;
    }

    protected function throwTypeError(string $expectedType, mixed $value): void
    {
        throw new \TypeError(sprintf('parameter type expected %s, %s given,value: %s', $expectedType, gettype($value), Utils::varToString($value)));
    }
}