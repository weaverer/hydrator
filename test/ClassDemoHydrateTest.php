<?php
declare(strict_types=1);

namespace Weaverer\Hydrator\Tests;

use Weaverer\Hydrator\Tests\TestClass\ClassDemo;

class ClassDemoHydrateTest extends \PHPUnit\Framework\TestCase
{

    public function testHydrate()
    {
        $data = [];
        $hydrator = new ClassDemo($data);
        $this->assertEquals($data, $hydrator->toArray());
    }

    public function testHydrate2()
    {
        $data = null;
        $hydrator = new ClassDemo($data);
        $this->assertEquals([], $hydrator->toArray());
    }

    public function testHydrate3()
    {
        $data = [
            "id" => 1,
            "name" => "Sample Name",
            "price" => 99.99,
            "isEnable" => true,
            "description" => "Sample Description",
            "categoryId" => 2,
            "discount" => 10.5,
            "isHot" => false
        ];
        $hydrator = new ClassDemo($data);
        $this->assertEquals($data, $hydrator->toArray());
    }

    public function testHydrate4()
    {
        $this->expectException(\TypeError::class);
        $data = [
            "id" => true,
            "name" => "Sample Name",
            "price" => 99.99,
            "isEnable" => true,
            "description" => "Sample Description",
            "categoryId" => 2,
            "discount" => 10.5,
            "isHot" => false
        ];
        $hydrator = new ClassDemo($data);

    }

    public function testHydrate5()
    {

        $data = [
            "id" => 100,
            "discount" => 10.5,
            "isHot" => false
        ];
        $hydrator = new ClassDemo($data);
        $this->assertEquals($data, $hydrator->toArray());

    }


}