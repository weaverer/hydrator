<?php
declare(strict_types=1);

namespace Weaverer\Hydrator\Tests\TestClass;

use Weaverer\Hydrator\Attribute\Convert;
use Weaverer\Hydrator\Attribute\RequestField;
use Weaverer\Hydrator\AutoHydrate;

class ClassDemo extends AutoHydrate
{

    #[RequestField('id', 'ID',['int','required'])]
    public int $id;
    public string $name;
    public float $price;
    #[RequestField('is_enable', 'isEnable')]
    public bool $isEnable;

    #[RequestField('desc', 'desc')]
    public ?string $description;

    #[RequestField('category_id', 'categoryId')]
    public ?int $categoryId;

    #[RequestField('discount', 'discount')]
    public ?float $discount;

    #[RequestField('is_hot', 'isHot')]
    public ?bool $isHot;

    #[RequestField('is_new', 'isNew')]
    public StringEnum $enum;


    public array $array;

    /**
     * @var int[][]
     */
    public array $intArray2;

    /**
     * @var int[]
     */
    #[RequestField('array_int', 'arrayInt')]
    public array $arrayInt1;

    /**
     * @var int[][][]
     */
    #[RequestField('array_int2', 'arrayInt2')]
    public array $arrayInt3;

    /**
     * @var ArrayDemo1[] $arrayDemo2
     */
    #[RequestField('array_demo_list', 'arrayDemoList')]
    public array $arrayDemoList;

    #[RequestField('array_demo1', 'arrayDemo1')]
    public ArrayDemo1 $arrayDemo1;

    #[RequestField('datetime', 'arrayDemo2')]
    #[Convert('strtotime')]
    #[Convert('date', 'Y-m-d H:i:s+9','$var')]
    public string $date;

    protected string $protectedField;
    private string $privateField;

}