<?php
declare(strict_types=1);

namespace Weaverer\Hydrator\Tests;

use Weaverer\Hydrator\Parser\ArrayDocParser;
use function PHPUnit\Framework\assertTrue;

class ArrayDocParserTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var string[][] $codeNull = []
     */
    private array $codeNull = [];
    public function testPaser()
    {
        $doc = (new \ReflectionClass($this))->getProperty('codeNull')->getDocComment();
        $text = (new ArrayDocParser($doc))->parsePropertyDoc();
        //断言$text和期望值是否相等
        assertTrue($text === 'string[][]');
    }
}