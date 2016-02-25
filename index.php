<?php

require  "./vendor/autoload.php";
use Poet\Framework\Container\Container;
use Poet\Framework\Foundation\EnvironmentDetector;
use Poet\Framework\Util\Traits\Macroable;
use Poet\Framework\Util\Collection;
use Poet\Framework\Util\Contract\Arrayable;
use Illuminate\Support\Arr;
use Poet\Framework\Bootstrap\Application;

$application = new Application(__DIR__);
$application->bootstrapWith($application->getBootstrappers());

$logger = $application['Logger'];

$logger->emergency('hello',['d','e']);






















