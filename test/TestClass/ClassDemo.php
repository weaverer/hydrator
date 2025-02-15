<?php
declare(strict_types=1);

namespace Weaverer\Hydrator\Tests\TestClass;

use Weaverer\Hydrator\Attribute\Convert;
use Weaverer\Hydrator\Attribute\RequestField;
use Weaverer\Hydrator\AutoHydrate;

class ClassDemo extends AutoHydrate
{

    public int $id;
    public string $name;
    public float $price;
    #[RequestField('is_enable', 'isEnable', '是否启用')]
    public bool $isEnable;

    #[RequestField('desc', 'desc', '描述')]
    public ?string $description;

    #[RequestField('category_id', 'categoryId', '分类ID')]
    public ?int $categoryId;

    #[RequestField('discount', 'discount', '折扣')]
    public ?float $discount;

    #[RequestField('is_hot', 'isHot', '是否热门')]
    public ?bool $isHot;

    #[RequestField('is_new', 'isNew', '是否新品')]
    public StringEnum $enum;


    public array $array;

    /**
     * @var int[]
     */
    #[RequestField('array_int', 'arrayInt', '整数数组')]
    public array $arrayInt1;

    /**
     * @var int[][][]
     */
    #[RequestField('array_int2', 'arrayInt2', '整数数组2')]
    public array $arrayInt3;

    /**
     * @var ArrayDemo1[] $arrayDemo2
     */
    #[RequestField('array_demo_list', 'arrayDemoList', '数组Demo列表')]
    public array $arrayDemoList;

    #[RequestField('array_demo1', 'arrayDemo1', '数组Demo1')]
    public ArrayDemo1 $arrayDemo1;

    #[RequestField('datetime', 'arrayDemo2', '数组Demo2')]
    #[Convert('strtotime')]
    #[Convert('date', 'Y-m-d H:i:s+9','$var')]
    public string $date;

    protected string $protectedField;
    private string $privateField;

}