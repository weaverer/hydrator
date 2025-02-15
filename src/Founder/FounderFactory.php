<?php
declare(strict_types=1);

namespace Weaverer\Hydrator\Founder;

use Weaverer\Hydrator\Types\DataType;
use Weaverer\Hydrator\Types\EnumType;
use Weaverer\Hydrator\Types\ListType;

class FounderFactory
{

    public static ArrayListFounder $arrayListFounder;
    public static ScalarFounder $ScalarFounder;
    public static EnumFounder $EnumFounder;
    public static ClassFounder $ClassFounder;
    public static Founder $defaultFounder;

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
        if (!isset(self::$arrayListFounder)) {
            self::$arrayListFounder = new ArrayListFounder();
        }
        return self::$arrayListFounder
            ->setTypeName($typeName)
            ->setListType($listType)
            ->setValueConvert($valueConvert);
    }

    public static function getScalarFounder(string $typeName, array $valueConvert): ScalarFounder
    {
        if (!isset(self::$ScalarFounder)) {
            self::$ScalarFounder = new ScalarFounder();
        }
        return self::$ScalarFounder
            ->setTypeName($typeName)
            ->setValueConvert($valueConvert);
    }

    public static function getEnumFounder(string $typeName, array $valueConvert, EnumType $enumType): EnumFounder
    {
        if (!isset(self::$EnumFounder)) {
            self::$EnumFounder = new EnumFounder();
        }
        return self::$EnumFounder->setTypeName($typeName)
            ->setValueConvert($valueConvert)
            ->setEnumType($enumType);
    }

    public static function getClassFounder(string $typeName, array $valueConvert): ClassFounder
    {
        if (!isset(self::$ClassFounder)) {
            self::$ClassFounder = new ClassFounder();
        }
        return self::$ClassFounder->setTypeName($typeName)
            ->setValueConvert($valueConvert);
    }

    public static function getDefaultFounder(string $typeName): Founder
    {
        if (!isset(self::$defaultFounder)) {
            self::$defaultFounder = new Founder();
        }
        return self::$defaultFounder->setTypeName($typeName)
            ->setValueConvert([]);
    }


}