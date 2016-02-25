<?php

require  "./vendor/autoload.php";
use Poet\Framework\Container\Container;
use Poet\Framework\Foundation\EnvironmentDetector;
use Poet\Framework\Util\Traits\Macroable;
use Poet\Framework\Util\Collection;
use Poet\Framework\Util\Contract\Arrayable;
use Illuminate\Support\Arr;
use Poet\Framework\Bootstrap\Application;


$app = new Application(__DIR__);
//加载相应的启动项
$app->bootstrapWith($app->getBootstrappers());
//测试配置是否
//加载了默认配置,还可以根据需要加载其他的配置
$configuration  =  $app['config'];
$configuration->set('app',null);


var_dump($configuration->get('app'));




















