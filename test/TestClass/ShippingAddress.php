<?php
declare(strict_types=1);

namespace Weaverer\Hydrator\Tests\TestClass;

use Weaverer\Hydrator\Attribute\RequestField;
use Weaverer\Hydrator\AutoHydrate;

class ShippingAddress extends BaseBean
{
    #[RequestField('address_line1', '地址1',['required','string',"min:6","max:255"])]
    public string $addressLine1;

    #[RequestField('address_line2', '地址2',['string',"min:6","max:255"])]
    public string $addressLine2;

    #[RequestField('country', '国家',['required','string','size:2'])]
    public string $country;

    #[RequestField('city', '城市',['required','string',"min:6","max:255"])]
    public string $city;

    #[RequestField('state', '省份',['required_if:country,US','string',"min:2","max:255"])]
    public string $state;

    #[RequestField('postal_code', 'string')]
    public string $postalCode;

    #[RequestField('phone', '邮箱',['required','string','email'])]
    public string $email;
}