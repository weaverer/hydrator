<?php
declare(strict_types=1);

namespace Weaverer\Hydrator\Interface;

interface ValueConvertInterface
{
    public function convert($value);
}