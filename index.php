<?php

require  "./vendor/autoload.php";
use Poet\Framework\Container\Container;
use Poet\Framework\Foundation\EnvironmentDetector;
use Poet\Framework\Util\Traits\Macroable;
use Poet\Framework\Util\Collection;
use Poet\Framework\Util\Contract\Arrayable;
use Illuminate\Support\Arr;

$target = [
    'a' => [
        'd' => [
            'q' => 'eee',
            'u' => 'qqqqq'
        ],
        'e' => '456',
        'f' => '789'
    ],
    'b' => [
        'g' =>'111',
        'h' =>'222',
        'k' =>'333',
        'f' => 'rrrr'
    ],
    'c' => [
        'i'=>'555',
        'j'=>'666',
        'o'=>'999'
    ]
];

$container  = new Container();

class People {
    public $name = "chen";
    public function show(){
        echo $this->name;
    }
}

$container['people'] = function(){
   return new People();
};

$mypeople = $container['people'];

$mypeople->show();
$mypeople->name = 'peng';


$cc = $container['people'];

$cc->name = "eeeee";

$dd = $container['people'];


$dd->show();












