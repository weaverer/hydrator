<?php
declare(strict_types=1);

namespace Weaverer\Hydrator\Types;

use Weaverer\Hydrator\Interface\MapFromInterface;
use Weaverer\Hydrator\Interface\ValueConvertInterface;

class Annotations
{
    /** @var array<string,MapFromInterface> */
    public array $mapFrom = [];

    /** @var ValueConvertInterface[] */
    public array $valueConvert = [];
}