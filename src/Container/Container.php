<?php namespace Poet\Framework\Container;
/**
 * User:eliot
 * Date:16/02/23
 */
use Pimple\Container as PimpleContainer;

class Container {
    public static function show(){
        $container = new PimpleContainer();
        var_dump("this is a test");
    }

}