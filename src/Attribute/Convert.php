<?php
declare(strict_types=1);

namespace Weaverer\Hydrator\Attribute;

use Attribute;
use Weaverer\Hydrator\Interface\AnnotationInterface;
use Weaverer\Hydrator\Interface\ValueConvertInterface;

#[Attribute(Attribute::TARGET_PROPERTY|Attribute::IS_REPEATABLE)]
class Convert implements ValueConvertInterface,AnnotationInterface
{
    /**
     * @var callable $callback
     */
    protected $callback;
    protected array $args;

    /**
     * @param callable $callback
     * @param ...$args
     */
    public function __construct(callable $callback, ...$args)
    {
        $this->callback = $callback;
        $this->args = $args;
    }

    /**
     * 使用指定的回调函数转换给定的值。
     *
     * 此方法检查是否提供了额外的参数。如果没有参数，则直接使用输入值调用回调函数。
     * 如果有参数，它会将参数中的占位符 ('$var') 替换为输入值，然后使用修改后的参数调用回调函数。
     *
     * @param mixed $value 要转换的值。
     * @return mixed 回调函数处理后返回的结果。
     */
    public function convert($value): mixed
    {
        if(empty($this->args)){
            return call_user_func($this->callback, $value);
        }
        //替换$args中的占位符
        foreach ($this->args as $index => $arg) {
            if ('$var' === $arg) {
                $this->args[$index] = $value;
            }
        }
        return call_user_func_array($this->callback, $this->args);
    }
}