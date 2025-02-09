<?php
declare(strict_types=1);

namespace Weaverer\Hydrator\Parser;

use ReflectionProperty;
use Weaverer\Hydrator\Exception\HydratorException;
use Weaverer\Hydrator\Types\DataType;

class ClassPropertyParser
{

    private string $className;

    /** @var array 对象缓存池 */
    private static array $classCachePools = [];

    public function __construct(string|object $class)
    {

        if (is_object($class)) {
            $class = get_class($class);
        }
        if (!class_exists($class)) {
            throw new HydratorException('Class not found: ' . $class);
        }
        $this->className = $class;
    }

    public function getAccessibleProperties(): array
    {
        if (isset(self::$classCachePools[$this->className])) {
            return self::$classCachePools[$this->className];
        }
        $result = [];
        $reflection = new \ReflectionClass($this->className);
        $properties = $reflection->getProperties(ReflectionProperty::IS_PUBLIC);
        foreach ($properties as $property) {
            if ($property->isStatic() || $property->isReadOnly() || !$property->hasType()) { //只解析public,非静态属性,有类型的,可读写的的属性
                continue;
            }
            $refType = $property->getType();
            if(!is_a($refType, \ReflectionNamedType::class)){ //只解析命名类型
                continue;
            }
            $result[$property->getName()] = $this->parseProperty($property);
        }
        self::$classCachePools[$this->className] = $result;
        return $result;
    }

    private function parseProperty(ReflectionProperty $property):  //todo
    {
        $type = new DataType();
    }


}