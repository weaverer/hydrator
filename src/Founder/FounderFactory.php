<?php
declare(strict_types=1);

namespace Weaverer\Hydrator\Founder;

use Weaverer\Hydrator\Types\DataType;
use Weaverer\Hydrator\Types\EnumType;
use Weaverer\Hydrator\Types\ListType;

class FounderFactory
{
    public static function createFounder(DataType $dataType): Founder
    {
        return match (true) {
            $dataType->isList => self::getArrayListFounder($dataType->typeName, $dataType->attributes?->valueConvert ?? [], $dataType->listType),
            $dataType->isEnum => self::getEnumFounder($dataType->typeName, $dataType->attributes?->valueConvert ?? [], $dataType->enumType),
            $dataType->isCustomClass => self::getClassFounder($dataType->typeName, $dataType->attributes?->valueConvert ?? []),
            $dataType->isScalar => self::getScalarFounder($dataType->typeName, $dataType->attributes?->valueConvert ?? []),
            default => self::getDefaultFounder($dataType->typeName),
        };
    }

    public static function getArrayListFounder(string $typeName, array $valueConvert, ListType $listType): ArrayListFounder
    {
        return (new ArrayListFounder())
            ->setTypeName($typeName)
            ->setListType($listType)
            ->setValueConvert($valueConvert);
    }

    public static function getScalarFounder(string $typeName, array $valueConvert): ScalarFounder
    {

        return (new ScalarFounder())
            ->setTypeName($typeName)
            ->setValueConvert($valueConvert);
    }

    public static function getEnumFounder(string $typeName, array $valueConvert, EnumType $enumType): EnumFounder
    {

        return (new EnumFounder())
            ->setTypeName($typeName)
            ->setValueConvert($valueConvert)
            ->setEnumType($enumType);
    }

    public static function getClassFounder(string $typeName, array $valueConvert): ClassFounder
    {

        return (new ClassFounder())->setTypeName($typeName)
            ->setValueConvert($valueConvert);
    }

    public static function getDefaultFounder(string $typeName): Founder
    {

        return (new Founder())->setTypeName($typeName)
            ->setValueConvert([]);
    }


}