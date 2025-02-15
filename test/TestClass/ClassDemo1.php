<?php
declare(strict_types=1);

namespace Weaverer\Hydrator\Tests\TestClass;

use Weaverer\Hydrator\AutoHydrate;

class ClassDemo1 extends AutoHydrate
{
    public int $id;
    public string $name;
    public float $price;
    public bool $isEnable;
    public ?string $description;
    public ?int $categoryId;
    public ?float $discount;
    public ?bool $isHot;

    public StringEnum $enum;

    protected string $protectedField;
    private string $privateField;

}