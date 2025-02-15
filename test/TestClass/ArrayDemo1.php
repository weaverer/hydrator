<?php
declare(strict_types=1);

namespace Weaverer\Hydrator\Tests\TestClass;

use Weaverer\Hydrator\Attribute\RequestField;
use Weaverer\Hydrator\AutoHydrate;

class ArrayDemo1 extends AutoHydrate
{
    #[RequestField('IS_OK', 'enum')]
    public StringEnum $enum;

    #[RequestField('String', 'name')]
    public string $string;

    #[RequestField('intger', 'int')]
    public int $int;

    #[RequestField('double', 'float')]
    public float $float;

    /** @var int[]  */
    #[RequestField('list', 'array')]
    public array $array;


}