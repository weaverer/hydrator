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
        $orderData = [];
        try {
            $orderBean = new Order($orderData,RequestField::class);
        }catch (ValidateException $e){
           var_dump($e->getErrors());
        }



    }

}