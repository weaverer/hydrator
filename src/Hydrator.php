<?php
declare(strict_types=1);

namespace Weaverer\Hydrator;

use Weaverer\Hydrator\Attribute\RequestField;
use Weaverer\Hydrator\Exception\HydratorTypeError;
use Weaverer\Hydrator\Exception\ValidateException;
use Weaverer\Hydrator\Founder\FounderFactory;
use Weaverer\Hydrator\Parser\ClassPropertyParser;
use Weaverer\Hydrator\Types\ClassInfo;
use Weaverer\Hydrator\Types\PropertyInfo;
use Weaverer\Hydrator\Validation\RequestValidator;

class Hydrator
{

    public AutoHydrate $instance;


    public function __construct(AutoHydrate $object)
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
    public function hydrate(array|object|null $data, ?string $mapWay = null): void
    {
        $data = $data ?? [];
        if (is_object($data) && !($data instanceof \ArrayAccess)) {
            $data = (array)$data;
        }
        $classInfo = (new ClassPropertyParser($this->instance))->getAccessibleProperties();
        $this->verifyFromRequest($data, $classInfo, $mapWay);
        if (empty($data)) {//如果数据为空,则直接返回(放在校验之后,是为了先走请求参数的校验规则)
            return;
        }
        try {
            foreach ($classInfo->properties as $propertyName => $propertyInfo) {
                //1.根据MapFromInterface接口的实现类,获取数据的key,如果没有实现,则使用属性名
                $fromIndex = $this->getMapFromIndex($propertyInfo, $mapWay) ?? $propertyName;
                if (!key_exists($fromIndex, $data)) {
                    continue;
                }
                $value = $data[$fromIndex];
                $newValue = FounderFactory::createFounder($propertyInfo)->found($value, $mapWay);
                $this->setPropertyValue($propertyName, $newValue);
            }
        } catch (\TypeError|\InvalidArgumentException|HydratorTypeError $e) {
            throw new Exception\HydratorException($e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * 检验请求参数
     * @param array $data
     * @param ClassInfo $classInfo
     * @param string|null $mapWay
     * @return void
     * @throws ValidateException
     */
    private function verifyFromRequest(array $data, ClassInfo $classInfo, ?string $mapWay = null): void
    {
        if (RequestField::class !== $mapWay || empty($classInfo->verifyRules)) {
            return;
        }
        if($validator = $this->instance->validator()){
            $validate = $validator->make($data, $classInfo->verifyRules, $classInfo->verifyMessages, $classInfo->verifyAttributes);
            if ($validate->fails()) {
                throw new ValidateException($validate->messages()->getMessages());
            }
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
