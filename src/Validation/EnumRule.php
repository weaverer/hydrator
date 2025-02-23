<?php
declare(strict_types=1);

namespace Weaverer\Hydrator\Validation;

use Illuminate\Contracts\Validation\ValidationRule;

class EnumRule implements ValidationRule
{
    private array $accept;

    public function __construct(array $accept)
    {
        $this->accept = $accept;
    }

    /**
     * 运行验证规则。
     */
    public function validate(string $attribute, mixed $value, \Closure $fail): void
    {
        if (!in_array($value, $this->accept, true)) {
            $fail('The :attribute field must exist in :other.');
        }
    }
}
