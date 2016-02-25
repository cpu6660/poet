<?php

require  "./vendor/autoload.php";
use Poet\Framework\Container\Container;
use Poet\Framework\Foundation\EnvironmentDetector;
use Poet\Framework\Util\Traits\Macroable;
use Poet\Framework\Util\Collection;
use Poet\Framework\Util\Contract\Arrayable;
use Illuminate\Support\Arr;
use Poet\Framework\Bootstrap\Application;

$arr  = [

    'db' => [
        'mysql'=> [
            'host' => '127.0.0.1',
            'user' => 'root',
            'password' => '123456'
        ]
    ],
    'cache'=> 'redis',
    'log'  => '/storage'

];

$a  = Arr::add($arr,'ee','value1');

var_dump($arr);




















