<?php
declare(strict_types=1);

namespace Weaverer\Hydrator\Types;

class EnumType
{
    /**
     * @var string $backingType 枚举类型值为int|string
     */
    public string $backingType;

    /**
     * @var string[]|int[] $values 枚举值
     */
    public array $values;

}
