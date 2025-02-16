<?php
declare(strict_types=1);

namespace Weaverer\Hydrator;

use Weaverer\Hydrator\Exception\HydratorTypeError;
use Weaverer\Hydrator\Founder\FounderFactory;
use Weaverer\Hydrator\Parser\ClassPropertyParser;
use Weaverer\Hydrator\Types\PropertyInfo;

class Hydrator
{

    public object $instance;


    public function __construct(object $object)
    {
        $this->instance = $object;
    }
    /**
     * @param array|object|null $data
     * @param class-string|null $mapWay
     * @return void
     * @throws Exception\HydratorException
     * @throws \ReflectionException
     */
    public function hydrate(array|object|null $data, ?string $mapWay = null)
    {
        if (!$data) {
            return;
        }
        if (is_object($data) && !($data instanceof \ArrayAccess)) {
            $data = (array)$data;
        }
        $properties = (new ClassPropertyParser($this->instance))->getAccessibleProperties();
        try {
            foreach ($properties as $propertyName => $propertyInfo) {
                //1.根据MapFromInterface接口的实现类,获取数据的key,如果没有实现,则使用属性名
                $fromIndex = $this->getMapFromIndex($propertyInfo, $mapWay) ?? $propertyName;
                if (!key_exists($fromIndex, $data)) {
                    continue;
                }
                $value = $data[$fromIndex];
                $newValue = FounderFactory::createFounder($propertyInfo)->found($value,$mapWay);
                $this->setPropertyValue($propertyName, $newValue);
            }
        }catch (\TypeError|\InvalidArgumentException|HydratorTypeError $e){
           throw new Exception\HydratorException($e->getMessage(),$e->getCode(),$e);
        }

    }


    /**
     * 设置属性值
     *
     * @param string $property
     * @param $value
     */
    private function setPropertyValue(string $property, $value): void
    {

        $this->instance->{$property} = $value;
    }

    /**
     * @param PropertyInfo $propertyInfo
     * @param class-string|null $mapWayName
     * @return ?string
     */
    private function getMapFromIndex(PropertyInfo $propertyInfo, ?string $mapWayName): ?string
    {
        if ($mapWayName) {
            $mapWay = $propertyInfo->attributes?->mapFrom[$mapWayName] ?? null;
            if ($mapWay) {
                return $mapWay->getMapFromName();
            }
        }
        return null;
    }


}