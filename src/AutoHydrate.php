<?php
declare(strict_types=1);

namespace Weaverer\Hydrator;

use Weaverer\Hydrator\Exception\HydratorException;
use Weaverer\Hydrator\Interface\ToJsonInterface;
use Weaverer\Hydrator\Trait\ArrayAccessTrait;
use Weaverer\Hydrator\Trait\HydrateTrait;
use Weaverer\Hydrator\Trait\ToJsonTrait;
use Weaverer\Hydrator\Validation\RequestValidator;

class AutoHydrate implements \ArrayAccess, ToJsonInterface
{
    use ArrayAccessTrait, ToJsonTrait, HydrateTrait;

    /**
     * @param array|object|null $data
     * @param class-string|null $mapWay
     * @throws HydratorException
     * @throws \ReflectionException
     */
    public function __construct(array|object|null $data, ?string $mapWay = null)
    {
        $this->beforeHydrate($data);
        $this->hydrate($data, $mapWay);
        $this->afterHydrate();
    }

    /**
     * @param array|object|null $data
     * @param class-string|null $mapWay |null $mapWay
     * @return void
     * @throws HydratorException
     * @throws \ReflectionException
     */
    public function hydrate(array|object|null $data, ?string $mapWay = null): void
    {
        (new Hydrator($this))->hydrate($data,$mapWay);
    }

    public function validator():?RequestValidator
    {
        return null;
    }

}
