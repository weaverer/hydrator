<?php
declare(strict_types=1);

namespace Weaverer\Hydrator\Tests\TestClass;

use Illuminate\Validation\Rule;
use Weaverer\Hydrator\Attribute\RequestField;
use Weaverer\Hydrator\AutoHydrate;

class CustomerInfo extends BaseBean
{
    #[RequestField('customer_id', '客户ID',['string','required'])]
    public string $customerId;

    #[RequestField('name', '姓名',['string','required',"min:2","max:10"])]
    public string $name;

    #[RequestField('contact_number', 'string')]
    public string $contactNumber;

    #[RequestField('sex', '性别',['int','required'])]
    public SexEnum $sex;
}