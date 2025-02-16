<?php
declare(strict_types=1);

namespace Weaverer\Hydrator\Attribute;

use Attribute;
use Weaverer\Hydrator\Interface\AnnotationInterface;
use Weaverer\Hydrator\Interface\MapFromInterface;

#[Attribute(Attribute::TARGET_PARAMETER | Attribute::TARGET_PROPERTY)]
readonly class RequestField implements MapFromInterface, AnnotationInterface
{

    /**
     * @param string $requestField 请求字段
     * @param string $fieldTitle 字段名称
     * @param array $rules 验证规则 example:['required'=>"必填",'max:255'=>'最大长度为255']
     */
    public function __construct(
        private string $requestField,
        private string $fieldTitle,
        private array  $rules = [],
        private string $description = '',
    )
    {
    }

    /**
     * @return string
     */
    public function getFieldTitle(): string
    {
        return $this->fieldTitle;
    }

    public function getMapFromName(): string
    {
        return $this->requestField;
    }


    /**
     * 解析验证规则(['required'=>"必填",'max:255'=>'最大长度为255'] => ['title.required'=>':title字段不能为空','title.max'=>':title字段最大长度为255'])
     * @return array
     * example: ['title.required'=>':title字段不能为空']
     */
    public function getValidateData(): array
    {
        if (empty($this->rules)) {
            return [[],[]];
        }
        $rules =[];
        $messages = [];
        foreach ($this->rules as $rule => $message) {
            if (is_numeric($rule)) {
                $rules[] = $message;
                continue;
            }
            $rules[] = $rule;
            if (str_contains($rule, ':')) {
                [$rule, $parameter] = explode(':', $rule, 2);
            }
            $messages[$this->requestField . '.' . $rule] = str_contains($message, (':' . $this->requestField)) ? $message : (':' . $this->requestField . ' ' . $message);
        }
        $ruleData = [$this->requestField => $rules];
        return [$ruleData,$messages];
    }

    /**
     * @return array
     * eg: ['title'=>'标题']
     */
    public function getAttribute(): array
    {
        return [$this->requestField => $this->fieldTitle];
    }

    public function getDescription(): string
    {
        return $this->description;
    }


}
