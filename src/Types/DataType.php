<?php
declare(strict_types=1);

namespace Weaverer\Hydrator\Types;

use Weaverer\Hydrator\Utils;

class DataType
{

    public bool $isScalar = false;
    public bool $isList = false;
    public bool $isCustomClass = false;
    public bool $isEnum = false;

    /** @var string 类型名 */
    public string $typeName;

    /** @var bool 是否可为空 */
    public bool $nullable;

    /** @var bool 是否有默认值 */
    public bool $hasDefaultValue;

    /** @var mixed 默认值 */
    public mixed $defaultValue;

    /** @var ListType|null */
    public ?ListType $listType = null;

    /** @var EnumType|null */
    public ?EnumType $enumType = null;

    /** @var string|null */
    public ?string $classType = null;

    /** @var Annotations|null 属性 */
    public ?Annotations $attributes = null;

}