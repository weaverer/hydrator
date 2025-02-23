<?php
declare(strict_types=1);

namespace Weaverer\Hydrator\Tests\TestClass;

use Weaverer\Hydrator\Attribute\Convert;
use Weaverer\Hydrator\Attribute\RequestField;
use Weaverer\Hydrator\AutoHydrate;

class ConvertObject extends AutoHydrate
{
    #[Convert("strtotime")]
    #[RequestField('date', 'date')]
    public int $timestamp;

    #[Convert("strtotime")]
    #[Convert("date",'Y-m-d H:i:s','$var')]
    #[RequestField('local_time', 'local_time')]
    public string $date;

}