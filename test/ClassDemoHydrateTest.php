<?php
declare(strict_types=1);

namespace Weaverer\Hydrator\Tests;

use Weaverer\Hydrator\Exception\HydratorException;
use Weaverer\Hydrator\Tests\TestClass\ClassDemo;
use Weaverer\Hydrator\Tests\TestClass\StringEnum;

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
        $this->expectException(HydratorException::class);
        $this->expectExceptionMessage('Expected type: int, given: boolean<true>.');
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
        $this->expectException(HydratorException::class);
        $this->expectExceptionMessage('Expected type: enum expected one of:1, 2, given: string<a>.');
        $data = [
            'enum' => 'a'
        ];

        $hydrator = new ClassDemo($data);
        var_dump($data);
        $this->assertEquals($data, $hydrator->toArray());

    }

    public function testHydrate6()
    {
        $data = [
            'enum' => '1'
        ];

        $hydrator = new ClassDemo($data);
        $this->assertEquals($data, $hydrator->toArray());

    }

    public function testHydrate7()
    {
        $data = [
            'enum' => StringEnum::from('1')
        ];

        $hydrator = new ClassDemo($data);
        $this->assertEquals([ 'enum' => '1'], $hydrator->toArray());

    }

    public function testHydrate8()
    {
        $data = [
            'array' => [1,2,null,3]
        ];

        $hydrator = new ClassDemo($data);
        $this->assertEquals($data, $hydrator->toArray());

    }

    public function testHydrate9()
    {
        $this->expectException(HydratorException::class);
        $this->expectExceptionMessage('Expected type: array, given: integer<1>.');
        $data = [
            'intArray2' => [1,2,null,3]
        ];

        $hydrator = new ClassDemo($data);
        var_dump($hydrator);
        $this->assertEquals($data, $hydrator->toArray());

    }

    public function testHydrateArrayInt1()
    {
        $data = [
            'arrayInt1' => [1,2,null,3]
        ];

        $hydrator = new ClassDemo($data);
        $this->assertEquals($data, $hydrator->toArray());

    }

    public function testHydrate1ArrayInt1()
    {
        $data = [
            'array' => ['1','2',null,3]
        ];

        $hydrator = new ClassDemo($data);
        var_dump($hydrator);
        $this->assertEquals($data, $hydrator->toArray());

    }

    public function testHydrate2ArrayInt1()
    {
        $this->expectException(HydratorException::class);
        $this->expectExceptionMessage('Expected type: int, given: double<1.1>.');
        $data = [
            'arrayInt1' => [1.1,'2',null,3]
        ];

        $hydrator = new ClassDemo($data);
        var_dump($hydrator);
        $this->assertEquals($data, $hydrator->toArray());

    }

    public function testHydrateArrayInt3()
    {
        $data = [
            'arrayInt3' => [[[1,2,null,3]]]
        ];

        $hydrator = new ClassDemo($data);
        $this->assertEquals($data, $hydrator->toArray());

    }

    public function testHydrate1ArrayInt3()
    {
        $data = [
            'arrayInt3' => [[[1,2,null,3]]]
        ];

        $hydrator = new ClassDemo($data);
        $this->assertEquals($data, $hydrator->toArray());

    }

    public function testHydrate2ArrayInt3()
    {
        $this->expectException(HydratorException::class);
        $this->expectExceptionMessage('Expected type: int, given: double<1.1>.');
        $data = [
            'arrayInt3' =>[[[1.1,2,null,3]]]
        ];
        $hydrator = new ClassDemo($data);
    }

    public function testHydrateClass()
    {
        $data = [
            'arrayDemo1' =>[
                'enum' => '1',
                'string' => 'string',
                'int' => 1,
                'float' => 1.1,
                'array' => [1,2,null,3],
            ]
        ];
        $hydrator = new ClassDemo($data);
        $this->assertEquals($data, $hydrator->toArray());
    }

    public function testHydrateArrayClass()
    {
        $data = [
            'arrayDemoList' =>[
                [
                    'enum' => '1',
                    'string' => 'string',
                    'int' => 1,
                    'float' => 1.1,
                    'array' => [1,2,null,3],
                ],
                [
                    'enum' => '2',
                    'string' => 'string2',
                    'int' => 2,
                    'float' => 2.1,
                    'array' => [1,2,null,3],
                ]
            ]
        ];
        $hydrator = new ClassDemo($data);
        $this->assertEquals($data, $hydrator->toArray());
    }


    public function testHydrateArrayClass2()
    {
        $this->expectException(HydratorException::class);
        $data = [
            'arrayDemoList' =>[
                [
                    [
                        'enum' => '1',
                        'string' => 'string',
                        'int' => 1,
                        'float' => 1.1,
                        'array' => [1,2,null,3],
                    ],
                    [
                        'enum' => '2',
                        'string' => 'string2',
                        'int' => 2,
                        'float' => 2.1,
                        'array' => [1,2,null,3],
                    ]
                ]
            ]
        ];
        $hydrator = new ClassDemo($data);
        var_dump($hydrator);
        $this->assertEquals($data, $hydrator->toArray());
    }

    public function testHydrateArrayClass3()
    {
        $this->expectException(HydratorException::class);
        $this->expectExceptionMessage('Expected type: int, given: array<[1,2,null,3]>.');
        $data = [
            'arrayDemoList' =>[
                [
                    'enum' => '1',
                    'string' => 'string',
                    'int' => 1,
                    'float' => 1.1,
                    'array' => [[1,2,null,3]],
                ],
                [
                    'enum' => '2',
                    'string' => 'string2',
                    'int' => 2,
                    'float' => 2.1,
                    'array' => [1,2,null,3],
                ]
            ]
        ];
        $hydrator = new ClassDemo($data);
        var_dump($hydrator);
        $this->assertEquals($data, $hydrator->toArray());
    }


}