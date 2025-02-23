<?php
declare(strict_types=1);

namespace Weaverer\Hydrator\Founder;

use Weaverer\Hydrator\Exception\HydratorTypeError;
use Weaverer\Hydrator\Utils;

class ScalarFounder extends Founder
{

    public function found($value, ?string $mapWayName = null): float|bool|int|string|null
    {
        $value = $this->toConvertValue($value);
        if (null === $value) {
            return null;
        }
        return match ($this->typeName) {
            Utils::INT => $this->foundIntType($value),
            Utils::FLOAT => $this->foundFloatType($value),
            Utils::BOOL => $this->foundBoolType($value),
            Utils::STRING => $this->foundStringType($value),
            default => throw new \TypeError('Unsupported scalar type: ' . $this->typeName),
        };
    }


    /**
     * @param mixed $value
     * @return int
     * @throws HydratorTypeError
     */
    private function foundIntType(mixed $value): int
    {
        if (is_int($value)) {
            return $value;
        }
        if (is_string($value) && (preg_match('/^-?[1-9]?\d*$/', $value) && (int)$value == $value)) {
            return (int)$value;
        }
        $this->throwTypeError(Utils::INT, $value);
    }

    /**
     * 是否是浮点数
     * @param mixed $value
     * @return float
     * @throws HydratorTypeError
     */
    private function foundFloatType(mixed $value): float
    {
        if (is_float($value)) {
            return $value;
        }
        if (is_string($value) && is_numeric($value)) {
            return (float)$value;
        }
        if (is_int($value)) {
            return (float)$value;
        }
        $this->throwTypeError(Utils::FLOAT, $value);
    }

    /**
     * 是否是布尔值
     * @param mixed $value
     * @return bool
     * @throws HydratorTypeError
     */
    private function foundBoolType(mixed $value): bool
    {
        if (is_bool($value)) {
            return $value;
        }
        $this->throwTypeError(Utils::BOOL, $value);
    }

    /**
     * 是否是字符串
     * @param mixed $value
     * @return string
     * @throws HydratorTypeError
     */
    private function foundStringType(mixed $value): string
    {
        if (is_bool($value)) {
            $this->throwTypeError(Utils::STRING, $value);
        }
        return (string)$value;
    }


}