<?php namespace Poet\Framework\Util;
/**
 * 对数组操作的工具类
 * Class Arr
 * @package Poet\Framework\Util
 */
use Poet\Framework\Util\Traits\Macroable;
class Arr {
   use Macroable;

   public static function add($array,$key,$value){
       if(is_null(static::get($array,$key))){
           static::set($array,$key,$value);
       }
       return $array;
   }

   public static function build($array,callable  $callback){
       $results = [];
       foreach($array as $key=>$value){
           list($innerKey,$innerValue) = call_user_func($callback,$key,$value);
           $results[$innerKey] = $innerValue ;
       }
       return $results;
   }




}