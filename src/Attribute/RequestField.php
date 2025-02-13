<?php
declare(strict_types=1);

namespace Weaverer\Hydrator\Attribute;

use Attribute;
use Weaverer\Hydrator\Interface\MapFromInterface;

#[Attribute(Attribute::TARGET_PARAMETER | Attribute::TARGET_PROPERTY)]
readonly class RequestField implements MapFromInterface
{

    /**
     * @param string $requestField 请求字段
     * @param string $fieldTitle 字段名称
     * @param string|null $fieldDescription 字段描述
     */
    public function __construct(
        private string  $requestField,
        private string  $fieldTitle,
        private ?string $fieldDescription = null,
    )
    {
    }

    /**
     * @return string
     */
    public function getFieldTitle(): string
    {
        return $this->fieldTitle;
    }

    /**
     * @return string|null
     */
    public function getFieldDescription(): ?string
    {
        return $this->fieldDescription;
    }

    public function getMapFromName(): string
    {
        return $this->requestField;
    }


}
