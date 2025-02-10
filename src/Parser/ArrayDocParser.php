<?php
declare(strict_types=1);

namespace Weaverer\Hydrator\Parser;

class ArrayDocParser
{

    /** @var string 属性类型匹配正则 */
    private string $propertyPattern = '/@var\s+((?:\?|null\|)?[0-9a-zA-Z\\\]+(?:\[\])*(?:\|[0-9a-zA-Z\\\]+(?:\[\])*)*)\s+/i';

    /** @var string 参数类型匹配正则 */
    private string $paramPattern = '/@param\s+((?:\?|null\|)?[0-9a-zA-Z\\\]+(?:\[\])*(?:\|[0-9a-zA-Z\\\]+(?:\[\])*)*)\s+/i';

    public function __construct(public string $doc,public string|object|null $class = null)
    {

    }

    public function parsePropertyDoc(): null|string
    {
        return $this->parse($this->propertyPattern);
    }

    public function parseParamsDoc(): null|string
    {
        return $this->parse($this->paramPattern);
    }


    protected function parse(string $pattern): null|string
    {
        preg_match($pattern, $this->doc, $matches);
        $matchesText = $matches[1] ?? '';
        if (!$matchesText) {
            return null;
        }
        $matchesText = $this->getRealType($matchesText);
        return $matchesText;
    }


    private function getRealType(string $matchesText): string
    {
        // Combine regex patterns to reduce redundancy
        $patterns = [
            "/\|?null\|?/i", // Remove |null| or |null or null|
            "/^null(?:\[\])+\|/i", // Remove leading null[]|
            "/\|null(?:\[\])+/i", // Remove trailing |null[]
            "/^\?/", // Remove leading ?
            "/\|?null$/i", // Remove trailing |null or null
            "/^null\|/i" // Remove leading null|
        ];
        $replacements = ['', '', '', '', '', ''];
        $matchesText = preg_replace($patterns, $replacements, $matchesText);

        return $matchesText;
    }

}