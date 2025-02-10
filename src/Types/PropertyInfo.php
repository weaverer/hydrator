<?php
declare(strict_types=1);

namespace Weaverer\Hydrator\Types;

class PropertyInfo extends DataType
{
    /**
     * @var string 属性名
     */
    public string $name;

    /**
     * @param string $name
     * @return PropertyInfo
     */
    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

}