<?php
declare(strict_types=1);

namespace Weaverer\Hydrator\Tests;

use Weaverer\Hydrator\Attribute\RequestField;
use Weaverer\Hydrator\Tests\TestClass\ConvertObject;

class ConvertTest extends \PHPUnit\Framework\TestCase
{
    public function testDate1()
    {
        $data = [
            'date'=> '2021-01-01',
            'local_time'=> 'March 10, 2001, 5:16 pm',
        ];

        $object = new ConvertObject($data,RequestField::class);
        var_dump($object->toArray());

    }
}