<?php
declare(strict_types=1);

namespace Weaverer\Hydrator\Types;

class ListType
{
    /** @var int $depth 数组层级 */
    public int $depth;

    /** @var string $type 数组元素类型 */
    public string $type;

    /** @var bool $isScalar 数组元素是否是标量 */
    public bool $isScalar;

    public function __construct(int $depth, string $type, bool $isScalar)
    {
        $this->depth = $depth;
        $this->type = $type;
        $this->isScalar = $isScalar;
    }

}