<?php

require  "./vendor/autoload.php";
use Poet\Framework\Container\Container;
use Poet\Framework\Foundation\EnvironmentDetector;
use Poet\Framework\Util\Traits\Macroable;
use Poet\Framework\Util\Collection;
use Poet\Framework\Util\Contract\Arrayable;

class People implements  Arrayable {
    public function toArray(){
        return ['value1','value2'];
    }
}

class Man {

}



$collection = new Collection();

$collection['cc']  = 'values';
$collection[]  =  'ccccc';
var_dump($collection->all());





