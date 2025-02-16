<?php
declare(strict_types=1);

namespace Weaverer\Hydrator\Tests;

use Weaverer\Hydrator\Attribute\RequestField;
use Weaverer\Hydrator\Exception\HydratorException;
use Weaverer\Hydrator\Tests\TestClass\ClassDemo;
use Weaverer\Hydrator\Tests\TestClass\StringEnum;

class ClassDemoHydrateTest1 extends \PHPUnit\Framework\TestCase
{

    public function testHydrate()
    {
        $data = [];
        $hydrator = new ClassDemo($data,RequestField::class);
        $this->assertEquals($data, $hydrator->toArray());
    }

    public function testHydrate2()
    {
        $data = null;
        $hydrator = new ClassDemo($data,RequestField::class);
        $this->assertEquals([], $hydrator->toArray());
    }

    public function testHydrate3()
    {
        $data = [
            "id" => 1,
            "name" => "Sample Name",
            "price" => 99.99,
            "is_enable" => true,
            "desc" => "Sample Description",
            "category_id" => 2,
            "discount" => 10.5,
            "is_hot" => false
        ];
        $result = [
            "id" => 1,
            "name" => "Sample Name",
            "price" => 99.99,
            "isEnable" => true,
            "description" => "Sample Description",
            "categoryId" => 2,
            "discount" => 10.5,
            "isHot" => false
        ];
        $hydrator = new ClassDemo($data,RequestField::class);
        $this->assertEquals($result, $hydrator->toArray());
    }

    public function testHydrate4()
    {
        $this->expectException(HydratorException::class);
        $this->expectExceptionMessage('Expected type: int, given: double<1.1>.');
        $data = [
            "id" => 1.1,
            "name" => "Sample Name",
            "price" => 99.99,
            "is_enable" => true,
            "desc" => "Sample Description",
            "category_id" => 2,
            "discount" => 10.5,
            "is_hot" => false
        ];
        $hydrator = new ClassDemo($data,RequestField::class);

    }

    public function testHydrate5()
    {
        $this->expectException(HydratorException::class);
        $this->expectExceptionMessage('Expected type: enum expected one of:1, 2, given: string<a>.');
        $data = [
            'is_new' => 'a'
        ];

        $result = [
            'enum' => 'a'
        ];
        $hydrator = new ClassDemo($data,RequestField::class);
        $this->assertEquals($result, $hydrator->toArray());

    }

    public function testHydrate6()
    {
        $data = [
            'is_new' => '1'
        ];

        $result = [
            'enum' => '1'
        ];

        $hydrator = new ClassDemo($data,RequestField::class);
        $this->assertEquals($result, $hydrator->toArray());

    }

    public function testHydrate7()
    {
        $data = [
            'is_new' => StringEnum::from('1')
        ];

        $hydrator = new ClassDemo($data,RequestField::class);
        $this->assertEquals([ 'enum' => '1'], $hydrator->toArray());

    }

    public function testHydrate8()
    {
        $data = [
            'array' => [1,2,null,3]
        ];

        $hydrator = new ClassDemo($data,RequestField::class);
        $this->assertEquals($data, $hydrator->toArray());

    }


    public function testHydrateArrayInt1()
    {
        $data = [
            'array_int' => [1,2,null,3]
        ];
        $result = [
            'arrayInt1' => [1,2,null,3]
        ];

        $hydrator = new ClassDemo($data,RequestField::class);
        $this->assertEquals($result, $hydrator->toArray());

    }

    public function testHydrate1ArrayInt1()
    {
        $data = [
            'array_int' => [1,2,null,3]
        ];
        $result = [
            'arrayInt1' => [1,2,null,3]
        ];

        $hydrator = new ClassDemo($data,RequestField::class);
        $this->assertEquals($result, $hydrator->toArray());

    }

    public function testHydrate2ArrayInt1()
    {
        $this->expectException(HydratorException::class);
        $this->expectExceptionMessage('Expected type: int, given: double<1.1>.');
        $data = [
            'array_int' => [1.1,'2',null,3]
        ];

        $hydrator = new ClassDemo($data,RequestField::class);
    }

    public function testHydrateArrayInt3()
    {
        $data = [
            'array_int2' => [[[1,2,null,3]]]
        ];
        $result = [
            'arrayInt3' => [[[1,2,null,3]]]
        ];
        $hydrator = new ClassDemo($data,RequestField::class);
        $this->assertEquals($result, $hydrator->toArray());

    }

    public function testHydrate1ArrayInt3()
    {
        $data = [
            'array_int2' => [[[1,2,null,3,2]]]
        ];
        $result = [
            'arrayInt3' => [[[1,2,null,3,2]]]
        ];

        $hydrator = new ClassDemo($data,RequestField::class);
        $this->assertEquals($result, $hydrator->toArray());

    }

    public function testHydrate2ArrayInt3()
    {
        $this->expectException(HydratorException::class);
        $this->expectExceptionMessage('Expected type: int, given: double<1.1>.');
        $data = [
            'array_int2' =>[[[1.1,2,null,3]]]
        ];
        $hydrator = new ClassDemo($data,RequestField::class);
    }

    public function testHydrateClass()
    {
        $data = [
            'array_demo1' =>[
                'IS_OK' => '1',
                'String' => 'string',
                'intger' => 1,
                'double' => 1.1,
                'list' => [1,2,null,3],
            ]
        ];
        $result = [
            'arrayDemo1' =>[
                'enum' => '1',
                'string' => 'string',
                'int' => 1,
                'float' => 1.1,
                'array' => [1,2,null,3],
            ]
        ];
        $hydrator = new ClassDemo($data,RequestField::class);
        $this->assertEquals($result, $hydrator->toArray());
    }

    public function testHydrateArrayClass()
    {
        $data = [
            'array_demo_list' =>[
                [
                    'IS_OK' => '2',
                    'String' => 'string222',
                    'intger' => 1,
                    'double' => 1.1,
                    'list' => [1,2,null,3],
                ],
                [
                    'IS_OK' => '1',
                    'String' => 'string',
                    'intger' => 2,
                    'double' => 2.1,
                    'list' => [1,2,null,3],
                ]
            ]
        ];
        $result = [
            'arrayDemoList' =>[
                [
                    'enum' => '2',
                    'string' => 'string222',
                    'int' => 1,
                    'float' => 1.1,
                    'array' => [1,2,null,3],
                ],
                [
                    'enum' => '1',
                    'string' => 'string',
                    'int' => 2,
                    'float' => 2.1,
                    'array' => [1,2,null,3],
                ]
            ]
        ];
        $hydrator = new ClassDemo($data,RequestField::class);
        $this->assertEquals($result, $hydrator->toArray());
    }


    public function testHydrateArrayClass2()
    {
      //  $this->expectException(\TypeError::class);
        $data = [
            'array_demo_list' =>[
                []
            ]
        ];
        $result = [
            'arrayDemoList' =>[
                []
            ]
        ];
        $hydrator = new ClassDemo($data,RequestField::class);
        $this->assertEquals($result, $hydrator->toArray());
    }

    public function testHydrateArrayClass3()
    {
        $this->expectException(HydratorException::class);
        $data = [
            'array_demo_list' =>[
                [
                    'IS_OK' => '1',
                    'String' => 'string',
                    'intger' => 1,
                    'double' => 1.1,
                    'list' => [[1,2,null,3]],
                ],
            ]
        ];
        $hydrator = new ClassDemo($data,RequestField::class);
        var_dump($hydrator);
     //   $this->assertEquals($result, $hydrator->toArray());
    }


    public function testHydrateConvert1()
    {
        $data = [
            'datetime' => '2021-01-01 00:00:00'
        ];
        $hydrator = new ClassDemo($data,RequestField::class);

        $this->assertEquals($hydrator->date, "2021-01-01 00:00:00+9");
    }


}