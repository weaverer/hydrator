<?php
declare(strict_types=1);

namespace Weaverer\Hydrator\Tests\TestClass;

use Weaverer\Hydrator\Attribute\RequestField;
use Weaverer\Hydrator\AutoHydrate;

class Product extends BaseBean
{
    #[RequestField('product_id', '商品ID', ['string', 'required'])]
    public string $productId;

    #[RequestField('product_name', '商品名称', ['string'])]
    public string $productName;

    #[RequestField('product_price', '商品价格', ['between:0,9999','numeric'])]
    public float $productPrice;

    /** @var string[]  */
    #[RequestField('product_tag', '商品tag', ['array',"max:2"])]
    public array $tags;
}