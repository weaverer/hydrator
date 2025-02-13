<?php
declare(strict_types=1);

namespace Weaverer\Hydrator\Parser;

use Weaverer\Hydrator\Types\ListType;
use Weaverer\Hydrator\Utils;

class ArrayDocParser
{

    /** @var string 属性类型匹配正则 */
    private string $propertyPattern = '/@var\s+((?:\?|null\|)?[0-9a-zA-Z\\\]+(?:\[\])*(?:\|[0-9a-zA-Z\\\]+(?:\[\])*)*)\s+/i';

    /** @var string 参数类型匹配正则 */
    private string $paramPattern = '/@param\s+((?:\?|null\|)?[0-9a-zA-Z\\\]+(?:\[\])*(?:\|[0-9a-zA-Z\\\]+(?:\[\])*)*)\s+/i';

    public function __construct(public string $doc, public NamespaceParser $classParser)
    {

    }

    public function parsePropertyDoc(): null|ListType
    {
        return $this->parse($this->propertyPattern);
    }

    public function parseParamsDoc(): null|ListType
    {
        return $this->parse($this->paramPattern);
    }


    protected function parse(string $pattern): null|ListType
    {
        preg_match($pattern, $this->doc, $matches);
        $matchesText = $matches[1] ?? '';
        if (!$matchesText) {
            return null;
        }
        $doc = $this->getArrayTypeDoc($matchesText);
        $arrayDepth = substr_count($doc, '[]');
        if (0 === $arrayDepth) {
            return null; //doc错误,不是数组类型
        }
        //数组元素的类型(减去数组的深度的两倍)
        $itemTypeDoc = substr($doc, 0, -2 * $arrayDepth);
        $isScalar = Utils::isScalar($itemTypeDoc);
        $itemsType = $isScalar ? $itemTypeDoc : $this->getItemsType($itemTypeDoc);
        if($itemsType === null){
            return null;
        }
        return new ListType($arrayDepth, $itemsType, $isScalar);
    }


    /**
     * 获取DOC中关于数组的类型(去除null|和?符号以及|null)
     * @param string $matchesText
     * @return string
     */
    protected function getArrayTypeDoc(string $matchesText): string
    {
        return str_replace(['null|', '?', '|null'], '', $matchesText);
    }

    /**
     * 获取数组元素的类型
     * @param string $doc
     * @return string|null
     */
    private function getItemsType(string $doc): ?string
    {
        if (str_contains($doc, '\\')) {
            return $doc;
        }
        return $this->classParser->getUsedClassName($doc);

    }

}