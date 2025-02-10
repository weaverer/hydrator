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

    /** @var ArrayListType|null */
    public ?ArrayListType $arrayListType = null;

    /** @var EnumType|null */
    public ?EnumType $enumType = null;

    /** @var ClassType|null */
    public ?ClassType $classType = null;

    /**
     * @param string $typeName
     * @return DataType
     */
    public function setTypeName(string $typeName): self
    {
        $this->typeName = $typeName;
        return $this;
    }

    /**
     * @param bool $nullable
     * @return DataType
     */
    public function setNullable(bool $nullable): self
    {
        $this->nullable = $nullable;
        return $this;
    }

    /**
     * @param bool $hasDefaultValue
     * @return DataType
     */
    public function setHasDefaultValue(bool $hasDefaultValue): self
    {
        $this->hasDefaultValue = $hasDefaultValue;
        return $this;
    }

    /**
     * @param mixed $defaultValue
     * @return DataType
     */
    public function setDefaultValue(mixed $defaultValue): self
    {
        $this->defaultValue = $defaultValue;
        return $this;
    }

    /**
     * @param ArrayListType $arrayListType
     * @return DataType
     */
    public function setArrayListType(ArrayListType $arrayListType): self
    {
        $this->arrayListType = $arrayListType;
        return $this;
    }

    /**
     * @param EnumType $enumType
     * @return DataType
     */
    public function setEnumType(EnumType $enumType): self
    {
        $this->enumType = $enumType;
        return $this;
    }

    /**
     * @param ClassType $objectType
     * @return DataType
     */
    public function setClassType(ClassType $objectType): self
    {
        $this->objectType = $objectType;
        return $this;
    }


    public function isScalar(): bool
    {
        return Utils::isScalar($this->typeName);
    }

    public function isList(): bool
    {
        return Utils::isList($this->typeName);
    }

    public function isObject(): bool
    {
        return Utils::isObject($this->typeName);
    }

    public function isCustomClass(): bool
    {
        return Utils::isCustomerClass($this->typeName);
    }

    public function isEnum(): bool
    {
        return $this->typeName === Utils::ENUM;
    }


}