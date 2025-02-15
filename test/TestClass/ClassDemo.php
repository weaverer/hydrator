<?php
declare(strict_types=1);

namespace Weaverer\Hydrator\Tests\TestClass;

use Weaverer\Hydrator\AutoHydrate;

class ClassDemo extends AutoHydrate
{
    public int $id;
    public string $name;
    public float $price;
    public bool $isEnable;
    public ?string $description;
    public ?int $categoryId;
    public ?float $discount;
    public ?bool $isHot;

    protected string $protectedField;
    private string $privateField;

}