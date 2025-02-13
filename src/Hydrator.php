<?php
declare(strict_types=1);

namespace Weaverer\Hydrator;

use Weaverer\Hydrator\Interface\ToJsonInterface;
use Weaverer\Hydrator\Trait\ArrayAccessTrait;
use Weaverer\Hydrator\Trait\HydrateTrait;
use Weaverer\Hydrator\Trait\ToJsonTrait;

class Hydrator implements \ArrayAccess, ToJsonInterface
{
    use ArrayAccessTrait, ToJsonTrait, HydrateTrait;


}