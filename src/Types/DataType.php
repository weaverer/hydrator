<?php
declare(strict_types=1);

namespace Weaverer\Hydrator\Types;

use Weaverer\Hydrator\Utils;

class DataType
{

    /** @var string 类型名 */
    public string $typeName;

    /** @var bool 是否可为空 */
    public bool $nullable;

    /** @var bool 是否有默认值 */
    public bool $hasDefaultValue;

    /** @var mixed 默认值 */
    public mixed $defaultValue;

    public ArrayListType $arrayListType;

    public EnumType $enumType;

    public ObjectType $objectType;

    /**
     * @param string $typeName
     */
    public function setTypeName(string $typeName): void
    {
        $this->typeName = $typeName;
    }

    /**
     * @param bool $nullable
     */
    public function setNullable(bool $nullable): void
    {
        $this->nullable = $nullable;
    }

    /**
     * @param bool $hasDefaultValue
     */
    public function setHasDefaultValue(bool $hasDefaultValue): void
    {
        $this->hasDefaultValue = $hasDefaultValue;
    }

    /**
     * @param mixed $defaultValue
     */
    public function setDefaultValue(mixed $defaultValue): void
    {
        $this->defaultValue = $defaultValue;
    }

    /**
     * @param ArrayListType $arrayListType
     */
    public function setArrayListType(ArrayListType $arrayListType): void
    {
        $this->arrayListType = $arrayListType;
    }

    /**
     * @param EnumType $enumType
     */
    public function setEnumType(EnumType $enumType): void
    {
        $this->enumType = $enumType;
    }

    /**
     * @param ObjectType $objectType
     */
    public function setObjectType(ObjectType $objectType): void
    {
        $this->objectType = $objectType;
    }



    public function isScalar(): bool
    {
        return Utils::isScalar($this->typeName);
    }

    public function isList():bool
    {
        return Utils::isList($this->typeName);
    }

    public function isObject():bool
    {
        return Utils::isObject($this->typeName);
    }

    public function isEnum():bool
    {
        return $this->typeName === Utils::ENUM;
    }



}