<?php

require  "./vendor/autoload.php";
use Poet\Framework\Container\Container;
use Poet\Framework\Foundation\EnvironmentDetector;
use Poet\Framework\Util\Traits\Macroable;
use Poet\Framework\Util\Collection;
use Poet\Framework\Util\Contract\Arrayable;
use Illuminate\Support\Arr;
use Poet\Framework\Bootstrap\Application;
use Poet\Framework\Util\Program\Pattern\Pipeline;
use Poet\Framework\Util\Contract\BaseMiddleware;

try {
    $application = new Application(__DIR__);
    $application->bootstrapWith($application->getBootstrappers());

//记录日志
    $application['Logger']->notice("ddd");


}catch(\Exception $e){

     var_dump($e->getMessage());
}



























