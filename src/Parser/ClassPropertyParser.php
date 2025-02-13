<?php
declare(strict_types=1);

namespace Weaverer\Hydrator\Parser;

use ReflectionProperty;
use Weaverer\Hydrator\Exception\HydratorException;
use Weaverer\Hydrator\Types\ListType;
use Weaverer\Hydrator\Types\DataType;
use Weaverer\Hydrator\Types\PropertyInfo;
use Weaverer\Hydrator\Utils;

class ClassPropertyParser
{

    private string $className;

    /** @var array 对象缓存池 */
    private static array $classCachePools = [];
    private NamespaceParser $namespaceParser;

    public function __construct(string|object $class)
    {

        if (is_object($class)) {
            $class = get_class($class);
        }
        if (!class_exists($class)) {
            throw new HydratorException('Class not found: ' . $class);
        }
        $this->className = $class;
        $this->namespaceParser = new NamespaceParser($class);
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
            if (!is_a($refType, \ReflectionNamedType::class)) { //只解析命名类型
                continue;
            }
            $result[$property->getName()] = $this->parseProperty($property, $refType);
        }
        self::$classCachePools[$this->className] = $result;
        return $result;
    }

    private function parseProperty(ReflectionProperty $property, \ReflectionNamedType $refType): DataType
    {
        $propertyInfo = new PropertyInfo();
        $typeName = $refType->getName();
        $propertyInfo->setName($property->getName());
        $propertyInfo->nullable = $refType->allowsNull();
        $propertyInfo->hasDefaultValue = $property->hasDefaultValue();
        $propertyInfo->defaultValue = $property->getDefaultValue();
        $propertyInfo->typeName = $typeName;

        if (Utils::isScalar($typeName)) {
            $propertyInfo->isScalar = true;
        }
        if (Utils::isList($typeName) && $type = $this->parsePropertyWithTypeArray($property)) {
            $propertyInfo->listType = $type;
            $propertyInfo->isList = true;
        }

        if (!$refType->isBuiltin() && class_exists($typeName)) { //类、枚举、接口或 trait 的类型。
            if ((new \ReflectionClass($typeName))->isEnum()) {
                $enumParser = (new EnumParser($typeName));
                if ($enumParser->isBacked()) {
                    $propertyInfo->isEnum = true;
                    $propertyInfo->enumType = $enumParser->parseBacked();
                }
            } else {
                $propertyInfo->isCustomClass = true;
                $propertyInfo->classType = $typeName;
            }
        }

        return $propertyInfo;
    }

    /**
     * 解析数组(list)类型的属性
     * @param ReflectionProperty $property
     * @return ListType|null
     */
    public function parsePropertyWithTypeArray(ReflectionProperty $property): ?ListType
    {
        $docComment = $property->getDocComment();
        if (false === $docComment) {
            return null;
        }
        return (new ArrayDocParser($docComment, $this->namespaceParser))->parsePropertyDoc();
    }


}