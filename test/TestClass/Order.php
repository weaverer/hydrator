<?php
declare(strict_types=1);

namespace Weaverer\Hydrator\Tests\TestClass;

use Weaverer\Hydrator\Attribute\RequestField;
use Weaverer\Hydrator\AutoHydrate;

class Order extends BaseBean
{
    #[RequestField('order_id', '订单id', ['required', 'string', "min:4", "max:5"])]
    public string $orderId;

    #[RequestField('customer_info', '客户信息', ['required'])]
    public CustomerInfo $customerInfo;

    #[RequestField('shipping_address', '收货地址', ['required'])]
    public ShippingAddress $shippingAddress;

    /** @var Product[] */
    #[RequestField('products', '商品列表', ['required', 'array', 'min:1'])]
    public array $products;
}

