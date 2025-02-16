<?php
declare(strict_types=1);

namespace Weaverer\Hydrator\Types;

use Weaverer\Hydrator\Attribute\RequestField;

class ClassInfo
{
    public array $properties = [];

    public ?array $verifyRules = null;

    public ?array $verifyMessages = null;

    public ?array $verifyAttributes = null;

    public function __construct(array $properties)
    {
        $this->properties = $properties;
        $this->intVerifyInfo();
    }

    private function intVerifyInfo(): void
    {
        $rules = [];
        $messages = [];
        $attributes = [];
        /** @var PropertyInfo $property */
        foreach ($this->properties as $property) {
            /** @var RequestField|null $requestFrom */
            $requestFrom = $property->attributes?->mapFrom[RequestField::class] ?? null;
            if (null !== $requestFrom) {
                [$rule, $message] = $requestFrom->getValidateData();
                $rule && $rules[] = $rule;
                $message && $messages[] = $message;
                $attribute = $requestFrom->getAttribute();
                $attribute && $attributes[] = $attribute;
            }
        }
        if (!empty($rules)) {
            $this->verifyRules = $rules;
            $this->verifyMessages = $messages;
            $this->verifyAttributes = $attributes;
        }
    }


}