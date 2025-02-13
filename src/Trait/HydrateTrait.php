<?php
declare(strict_types=1);

namespace Weaverer\Hydrator\Trait;

use Weaverer\Hydrator\Interface\MapFromInterface;
use Weaverer\Hydrator\Parser\ClassPropertyParser;

trait HydrateTrait
{
    public function __construct(array|object|null $data, ?MapFromInterface $mapWay = null)
    {
        self::hydrate($this, $data, $mapWay);
    }

    public static function hydrate(object|string $object, array|object|null $data, ?MapFromInterface $mapWay = null)
    {
        $properties = (new ClassPropertyParser($object))->getAccessibleProperties();
    }

}