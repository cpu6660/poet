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
use Poet\Framework\Container\LaravelContainer;
use Illuminate\Container\Container  as Icontainer;
use Poet\Framework\Cache\Driver\Redis;
use Poet\Framework\Cache\Driver\Memcache;
use Poet\Framework\Db\Driver\Mysql;
//设置系统时间
date_default_timezone_set('Asia/Shanghai');
$application = new Application(__DIR__);
//设置这个实例
$application->setInstance($application);
$application->bootstrapWith($application->getBootstrappers());
$config = $application['config'];

//var_dump($config['app.db']); exit;

// var_dump(config('app.cache')); exit;


try {

    $model  = new Mysql();



}catch(\Exception $e){



}




































