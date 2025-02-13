<?php
declare(strict_types=1);

namespace Weaverer\Hydrator\Trait;

trait ArrayAccessTrait
{
    public function offsetSet(mixed $offset,mixed $value): void
    {
        $this->{$offset} = $value;
    }

    public function offsetExists(mixed $offset): bool
    {
        return isset($this->{$offset});
    }

    public function offsetUnset(mixed $offset): void
    {
        unset($this->{$offset});
    }

    public function offsetGet(mixed $offset) :mixed{
        return $this->{$offset};
    }
}