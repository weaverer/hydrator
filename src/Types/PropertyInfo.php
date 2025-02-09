<?php
declare(strict_types=1);

namespace Weaverer\Hydrator\Types;

class PropertyInfo
{
    /**
     * @var string 属性名
     */
    public string $name;

    /**
     * @var DataType 数据类型
     */
    public DataType $dataType;

}