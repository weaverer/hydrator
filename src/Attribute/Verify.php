<?php
declare(strict_types=1);

namespace Weaverer\Hydrator\Attribute;

use Attribute;
use Weaverer\Hydrator\Interface\AnnotationInterface;

#[Attribute(Attribute::TARGET_PARAMETER | Attribute::TARGET_PROPERTY)]
class Verify implements AnnotationInterface
{
    public string|array $rule;
    public string $message;
    public function __construct(string|array $rule, string $message)
    {
    }
}