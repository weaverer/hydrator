<?php
declare(strict_types=1);

namespace Weaverer\Hydrator\Types;

class ArrayListType
{
    /** @var int $depth 数组层级 */
    public int $depth;

    /** @var string $type 数组元素类型 */
    public string $type;

    public function __construct()
    {

    }
}