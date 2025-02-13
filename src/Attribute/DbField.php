<?php
declare(strict_types=1);

namespace Weaverer\Hydrator\Attribute;

use Attribute;
use Weaverer\Hydrator\Interface\MapFromInterface;

#[Attribute(Attribute::TARGET_PROPERTY)]
readonly class DbField implements MapFromInterface
{

    public function __construct(
        private string $dbField
    )
    {
    }

    public function getMapFromName(): string
    {
        return $this->dbField;
    }

}