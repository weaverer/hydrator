<?php
declare(strict_types=1);

namespace Weaverer\Hydrator\Tests\TestClass;

use Weaverer\Hydrator\AutoHydrate;
use Weaverer\Hydrator\Validation\RequestValidator;

class BaseBean extends AutoHydrate
{
    public static ?RequestValidator $instance = null;
    public function validator():?RequestValidator
    {
        if(self::$instance === null){
            self::$instance = new RequestValidator(__DIR__.'/lang/');
        }
        return self::$instance;
    }
}