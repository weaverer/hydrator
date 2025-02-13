<?php
declare(strict_types=1);

namespace Weaverer\Hydrator\Interface;

interface ToJsonInterface
{
    public function toJson(): string;

    public function toArray(): array;
}