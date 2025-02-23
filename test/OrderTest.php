<?php
declare(strict_types=1);

namespace Weaverer\Hydrator\Tests;

use Weaverer\Hydrator\Attribute\RequestField;
use Weaverer\Hydrator\Exception\ValidateException;
use Weaverer\Hydrator\Tests\TestClass\Order;

class OrderTest extends \PHPUnit\Framework\TestCase
{
    public function testOrder()
    {
        $orderData = [
            'order_id' => '12345',
            'customer_info' => [
                'name' => 'CUS1001',
                'customer_id' => 'John Doe',
                'contact_number' => '1234567890',
                'sex'=>1
            ],
            'shipping_address' => [
                'address_line1' => '123 Main St',
                'address_line2' => 'Apt 4B',
                'country' => 'US',
                'city' => 'New York',
                'state' => 'NY',
                'postal_code' => '10001',
                'phone' => 'john.doe@example.com'
            ],
            'products' => [
                [
                    'product_id' => 'P001',
                    'product_name' => 'Product 1',
                    'product_price' => 99.99
                ],
                [
                    'product_id' => 'P002',
                    'product_name' => 'Product 2',
                    'product_price' => 149.99
                ]
            ]
        ];
        $orderBean = new Order($orderData,RequestField::class);
        $this->assertEquals(2, count($orderBean->products));
    }

    public function testOrderValidation()
    {
        $this->expectException(ValidateException::class);
        $orderData = [];
        $orderBean = new Order($orderData,RequestField::class);
    }

    public function testOrderValidation2()
    {
        $this->expectException(ValidateException::class);
        $orderData = [
            'order_id' => '12345',
            'customer_info' => [
                'name' => 'CUS1001',
                'customer_id' => 'John Doe',
                'contact_number' => '1234567890',
                'sex'=>1
            ],
            'shipping_address' => [
                'address_line1' => '123 Main St',
                'address_line2' => 'Apt 4B',
                'country' => 'US',
                'city' => 'New York',
                'state' => 'NY',
                'postal_code' => '10001',
                'phone' => 'john.doe@example.com'
            ],
            'products' => [
            ]
        ];
        try {
            $orderBean = new Order($orderData,RequestField::class);
        }catch (ValidateException $e){
            var_dump($e->getErrors());
            $this->assertEquals(['products' => ['The 商品列表 field is required.']], $e->getErrors());
            throw $e;
        }

    }

    public function testOrderValidation3()
    {
        $this->expectException(ValidateException::class);
        $orderData = [
            'order_id' => '12345',
            'shipping_address' => [
                'address_line1' => '123 Main St',
                'address_line2' => 'Apt 4B',
                'country' => 'US',
                'city' => 'New York',
                'state' => 'NY',
                'postal_code' => '10001',
                'phone' => 'john.doe@example.com'
            ],
            'products' => [
                [
                    'product_id' => 'P001',
                    'product_name' => 'Product 1',
                    'product_price' => 99.99
                ],
            ]
        ];
        try {
            $orderBean = new Order($orderData,RequestField::class);
        }catch (ValidateException $e){
            var_dump($e->getErrors());
            $this->assertEquals(['customer_info' => ['The 客户信息 field is required.']], $e->getErrors());
            throw $e;
        }

    }

    public function testOrderValidation4()
    {
        $this->expectException(ValidateException::class);
        $orderData = [
            'order_id' => "2222",
            'shipping_address' => [
                'address_line1' => '123 Main St',
                'address_line2' => 'Apt 4B',
                'country' => 'US',
                'city' => 'New York',
                'state' => 'NY',
                'postal_code' => '10001',
                'phone' => 'john.doe@example.com'
            ],
            'customer_info' => [
                'name' => 'CUS1001',
                'customer_id' => 'John Doe',
                'contact_number' => '1234567890',
            ],
            'products' => [
                [
                    'product_id' => 'P001',
                    'product_name' => 'Product 1',
                    'product_price' => 99.99
                ],
            ]
        ];
        try {
            $orderBean = new Order($orderData,RequestField::class);
        }catch (ValidateException $e){
            var_dump($e->getErrors());
            $this->assertEquals(['sex' => ['The 性别 field is required.']], $e->getErrors());
            throw $e;
        }
    }

    public function testOrderValidation5()
    {
        $this->expectException(ValidateException::class);
        $orderData = [
            'order_id' => "2222",
            'shipping_address' => [
                'address_line1' => '123 Main St',
                'address_line2' => 'Apt 4B',
                'country' => 'US',
                'city' => 'New York',
                'state' => 'NY',
                'postal_code' => '10001',
                'phone' => 'john.doe@example.com'
            ],
            'customer_info' => [
                'name' => 'C',
                'customer_id' => 'John Doe',
                'contact_number' => '1234567890',
                'sex'=>1
            ],
            'products' => [
                [
                    'product_id' => 'P001',
                    'product_name' => 'Product 1',
                    'product_price' => 99.99
                ],
            ]
        ];
        try {
            $orderBean = new Order($orderData,RequestField::class);
        }catch (ValidateException $e){
            var_dump($e->getErrors());
            $this->assertEquals(['name' => ['The 姓名 field must be at least 2 characters.']], $e->getErrors());
            throw $e;
        }
    }

    public function testOrderValidation6()
    {
        $this->expectException(ValidateException::class);
        $orderData = [
            'order_id' => "2222",
            'shipping_address' => [
                'address_line1' => '123 Main St',
                'address_line2' => 'Apt 4B',
                'country' => 'US',
                'city' => 'New York',
                'state' => '',
                'postal_code' => '10001',
                'phone' => 'john.doe@example.com'
            ],
            'customer_info' => [
                'name' => 'Cc',
                'customer_id' => 'John Doe',
                'contact_number' => '1234567890',
                'sex'=>1
            ],
            'products' => [
                [
                    'product_id' => 'P001',
                    'product_name' => 'Product 1',
                    'product_price' => 99.99
                ],
            ]
        ];
        try {
            $orderBean = new Order($orderData,RequestField::class);
        }catch (ValidateException $e){
            var_dump($e->getErrors());
            $this->assertEquals(['state' => ['The 省份 field is required when 国家 is US.']], $e->getErrors());
            throw $e;
        }
    }

    public function testOrderValidation7()
    {
        $this->expectException(ValidateException::class);
        $orderData = [
            'order_id' => "2222",
            'shipping_address' => [
                'address_line1' => '123 Main St',
                'address_line2' => 'Apt 4B',
                'country' => 'US',
                'city' => 'New York',
                'state' => 'NY',
                'postal_code' => '10001',
                'phone' => 'john.doe@example.com'
            ],
            'customer_info' => [
                'name' => 'Cc',
                'customer_id' => 'John Doe',
                'contact_number' => '1234567890',
                'sex'=>1
            ],
            'products' => [
                [
                    'product_id' => '',
                    'product_name' => 'Product 1',
                    'product_price' => 99.99
                ],
            ]
        ];
        try {
            $orderBean = new Order($orderData,RequestField::class);
        }catch (ValidateException $e){
            var_dump($e->getErrors());
            $this->assertEquals(['product_id' => ['The 商品ID field is required.']], $e->getErrors());
            throw $e;
        }
    }

    public function testOrderValidation8()
    {
        $orderData = [
            'order_id' => "2222",
            'shipping_address' => [
                'address_line1' => '123 Main St',
                'address_line2' => 'Apt 4B',
                'country' => 'US',
                'city' => 'New York',
                'state' => 'NY',
                'postal_code' => '10001',
                'phone' => 'john.doe@example.com'
            ],
            'customer_info' => [
                'name' => 'Cc',
                'customer_id' => 'John Doe',
                'contact_number' => '1234567890',
                'sex'=>1
            ],
            'products' => [
                [
                    'product_id' => '1',
                    'product_name' => 'Product 1',
                ],
            ]
        ];
        $orderBean = new Order($orderData,RequestField::class);
        $this->assertEquals(1, count($orderBean->products));
    }

    public function testOrderValidation9()
    {
        $this->expectException(ValidateException::class);
        $orderData = [
            'order_id' => "2222",
            'shipping_address' => [
                'address_line1' => '123 Main St',
                'address_line2' => 'Apt 4B',
                'country' => 'US',
                'city' => 'New York',
                'state' => 'NY',
                'postal_code' => '10001',
                'phone' => 'john.doe@example.com'
            ],
            'customer_info' => [
                'name' => 'Cc',
                'customer_id' => 'John Doe',
                'contact_number' => '1234567890',
                'sex'=>1
            ],
            'products' => [
                [
                    'product_id' => '88',
                    'product_name' => 'Product 1',
                    'product_price' => "-1"
                ],
            ]
        ];
        try {
            $orderBean = new Order($orderData,RequestField::class);
        }catch (ValidateException $e){
            var_dump($e->getErrors());
            $this->assertEquals(['product_price' => ['The 商品价格 field must be between 0 and 9999.']], $e->getErrors());
            throw $e;
        }
    }

    public function testOrderValidation10()
    {
        $this->expectException(ValidateException::class);
        $orderData = [
            'order_id' => "2222",
            'shipping_address' => [
                'address_line1' => '123 Main St',
                'address_line2' => 'Apt 4B',
                'country' => 'US',
                'city' => 'New York',
                'state' => 'NY',
                'postal_code' => '10001',
                'phone' => 'john.doe@example.com'
            ],
            'customer_info' => [
                'name' => 'Cc',
                'customer_id' => 'John Doe',
                'contact_number' => '1234567890',
                'sex'=>1
            ],
            'products' => [
                [
                    'product_id' => '88',
                    'product_name' => 'Product 1',
                    'product_price' => "1",
                    'product_tag'=>["a","b",'C']
                ],
            ]
        ];
        try {
            $orderBean = new Order($orderData,RequestField::class);
        }catch (ValidateException $e){
            var_dump($e->getErrors());
            $this->assertEquals(['product_tag' => ['The 商品tag field must not have more than 2 items.']], $e->getErrors());
            throw $e;
        }
    }

    public function testOrderValidation11()
    {
        $this->expectException(ValidateException::class);
        $orderData = [
            'order_id' => "2222",
            'shipping_address' => [
                'address_line1' => '123 Main St',
                'address_line2' => 'Apt 4B',
                'country' => 'US',
                'city' => 'New York',
                'state' => 'NY',
                'postal_code' => '10001',
                'phone' => 'john.doe@example.com'
            ],
            'customer_info' => [
                'name' => 'Cc',
                'customer_id' => 'John Doe',
                'contact_number' => '1234567890',
                'sex'=>0
            ],
            'products' => [
                [
                    'product_id' => '88',
                    'product_name' => 'Product 1',
                    'product_price' => "1",
                    'product_tag'=>["a","b"]
                ],
            ]
        ];
        try {
            $orderBean = new Order($orderData,RequestField::class);
        }catch (ValidateException $e){
            var_dump($e->getErrors());
            $this->assertEquals(['sex' => ['The selected 性别 is invalid.']], $e->getErrors());
            throw $e;
        }
    }

}