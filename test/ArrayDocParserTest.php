<?php
declare(strict_types=1);

namespace Weaverer\Hydrator\Tests;

use Weaverer\Hydrator\Parser\ArrayDocParser;
use Weaverer\Hydrator\Parser\NamespaceParser;
use Weaverer\Hydrator\Tests\TestClass\ArrayDemo1;

class ArrayDocParserTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var string[] $codeNull = []
     */
    private array $codeNull = [];

    /**
     * @var ?string[][] $codeNull2
     */
    private ?array $codeNull2 = [];

    /**
     * @var string[][][]|null $codeNull3
     */
    private ?array $codeNull3 = [];

    /**
     * @var null|string[][][][] $codeNull4
     */
    private ?array $codeNull4 = [];

    /**
     * @var string[][][][][]|null $codeNull5
     */
    private ?array $codeNull5 = [];

    /**
     * @var ?ArrayDemo1[] $code7Null
     */
    private ?array $code7Null = [];

    /**
     * @var ?\Weaverer\Hydrator\Tests\TestClass\ArrayDemo1[] $code8Null
     */
    private ?array $code8Null = [];

    /**
     * @var ArrayDemo1[]|null $code9Null
     */
    private ?array $code9Null = [];

    /**
     * @var \Weaverer\Hydrator\Tests\TestClass\ArrayDemo1[]|null $code10Null
     */
    private ?array $code10Null = [];


    public function testParse()
    {
        $doc = (new \ReflectionClass($this))->getProperty('codeNull')->getDocComment();
        $arrayType = (new ArrayDocParser($doc, new NamespaceParser($this)))->parsePropertyDoc();
        $this->assertSame('string', $arrayType->type);
        $this->assertSame(1, $arrayType->depth);
        $this->assertTrue($arrayType->isScalar);


    }

    public function testParse2()
    {
        $doc = (new \ReflectionClass($this))->getProperty('codeNull2')->getDocComment();
        $arrayType = (new ArrayDocParser($doc, new NamespaceParser($this)))->parsePropertyDoc();
        $this->assertSame('string', $arrayType->type);
        $this->assertSame(2, $arrayType->depth);
        $this->assertTrue($arrayType->isScalar);
    }

    public function testParse3()
    {
        $doc = (new \ReflectionClass($this))->getProperty('codeNull3')->getDocComment();
        $arrayType = (new ArrayDocParser($doc, new NamespaceParser($this)))->parsePropertyDoc();
        $this->assertSame('string', $arrayType->type);
        $this->assertSame(3, $arrayType->depth);
        $this->assertTrue($arrayType->isScalar);
    }

    public function testParse4()
    {
        $doc = (new \ReflectionClass($this))->getProperty('codeNull4')->getDocComment();
        $arrayType = (new ArrayDocParser($doc, new NamespaceParser($this)))->parsePropertyDoc();
        $this->assertSame('string', $arrayType->type);
        $this->assertSame(4, $arrayType->depth);
        $this->assertTrue($arrayType->isScalar);
    }

    public function testParse5()
    {
        $doc = (new \ReflectionClass($this))->getProperty('codeNull5')->getDocComment();
        $arrayType = (new ArrayDocParser($doc, new NamespaceParser($this)))->parsePropertyDoc();
        $this->assertSame('string', $arrayType->type);
        $this->assertSame(5, $arrayType->depth);
        $this->assertTrue($arrayType->isScalar);
    }

    public function testParse6()
    {
        $doc = (new \ReflectionClass($this))->getProperty('code7Null')->getDocComment();
        $arrayType = (new ArrayDocParser($doc, new NamespaceParser($this)))->parsePropertyDoc();
        $this->assertSame('\Weaverer\Hydrator\Tests\TestClass\ArrayDemo1', $arrayType->type);
        $this->assertSame(1, $arrayType->depth);
        $this->assertFalse($arrayType->isScalar);
    }

    public function testParse7()
    {
        $doc = (new \ReflectionClass($this))->getProperty('code8Null')->getDocComment();
        $arrayType = (new ArrayDocParser($doc, new NamespaceParser($this)))->parsePropertyDoc();
        $this->assertSame('\Weaverer\Hydrator\Tests\TestClass\ArrayDemo1', $arrayType->type);
        $this->assertSame(1, $arrayType->depth);
        $this->assertFalse($arrayType->isScalar);
    }

    public function testParse8()
    {
        $doc = (new \ReflectionClass($this))->getProperty('code9Null')->getDocComment();
        $arrayType = (new ArrayDocParser($doc, new NamespaceParser($this)))->parsePropertyDoc();
        $this->assertSame('\Weaverer\Hydrator\Tests\TestClass\ArrayDemo1', $arrayType->type);
        $this->assertSame(1, $arrayType->depth);
        $this->assertFalse($arrayType->isScalar);
    }

    public function testParse9()
    {
        $doc = (new \ReflectionClass($this))->getProperty('code10Null')->getDocComment();
        $arrayType = (new ArrayDocParser($doc, new NamespaceParser($this)))->parsePropertyDoc();
        $this->assertSame('\Weaverer\Hydrator\Tests\TestClass\ArrayDemo1', $arrayType->type);
        $this->assertSame(1, $arrayType->depth);
        $this->assertFalse($arrayType->isScalar);
    }

    public function testParse10()
    {
        $doc = (new \ReflectionClass($this))->getProperty('code10Null')->getDocComment();
        $arrayType = (new ArrayDocParser($doc, new NamespaceParser($this)))->parsePropertyDoc();
        $this->assertSame('\Weaverer\Hydrator\Tests\TestClass\ArrayDemo1', $arrayType->type);
        $this->assertSame(1, $arrayType->depth);
        $this->assertFalse($arrayType->isScalar);
    }

    public function testIsisBuiltin()
    {
        $ref = new \ReflectionClass(ArrayDemo1::class);

        var_dump( $ref->getProperty('enum')->getType()->isBuiltin());
    }
}