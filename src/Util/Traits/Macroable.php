<?php namespace Poet\Framework\Util\Traits;
//用于代表匿名函数的类
use Closure;
//方法调用错误异常
use BadMethodCallException;

/**
 * macro  巨大的,大量的,宏
 * 事件的实现也和这个类似
 * 用于定义宏,某个字段代表某个匿名函数
 * Class Macroable
 * @package Poet\Framework\Util\Traits
 */
trait Macroable {
    /**
     * 定义的字符串宏都保存在这里
     * @var array
     */
    protected static $macros = [];

    /**
     * 自定义的宏
     * @param $name
     * @param callable $macro
     */
    public static function marco($name,callable $macro){
        static::$macros[$name] = $macro;
    }

    /**
     * 检查某个宏是否定义
     * @param $name
     * @return bool
     */
    public static function hasMarco($name){
        return isset(static::$macros[$name]);
    }

    /**
     * 动态调用类的静态方法
     * @param $method
     * @param $parameters
     * @return mixed
     */
    public static function __callStatic($method,$parameters){
        if(static::hasMarco($method)) {
            if (static::$macros[$method] instanceof Closure) {
                return call_user_func_array(Closure::bind(static::$macros[$method], null, get_called_class()), $parameters);
            } else {
                return call_user_func_array(static::$macros[$method], $parameters);
            }
        }
        throw new BadMethodCallException(" 方法: {$method} 不存在 ");
    }

    /**
     * 动态调用对象的某个方法
     * @param $method
     * @param $parameters
     * @return mixed
     */
    public function __call($method,$parameters){
        if(static::hasMarco($method)){
            if(static::$macros[$method] instanceof Closure){
                return call_user_func_array(static::$macros[$method]->bindTo($this,get_class($this)),$parameters);
            }else {
                return call_user_func_array(static::$macros[$method],$parameters);
            }
        }
        throw new BadMethodCallException("方法:{$method} 不存在");
    }


}


