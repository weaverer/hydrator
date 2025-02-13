<?php
declare(strict_types=1);

namespace Weaverer\Hydrator\Trait;

trait ToJsonTrait
{
    public function toJson(int $flags = 0, int $depth = 512): string
    {
        return json_encode($this, $flags, $depth);
    }

    public function toArray(): array
    {
        return json_decode($this->toJson(), true);
    }
}