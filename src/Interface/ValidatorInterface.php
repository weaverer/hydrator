<?php
declare(strict_types=1);

namespace Weaverer\Hydrator\Interface;

interface ValidatorInterface
{

    public function validate($value): void;
}