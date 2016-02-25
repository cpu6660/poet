<?php namespace Poet\Framework\Util;
/**
 * 对数组操作的工具类
 * Class Arr
 * @package Poet\Framework\Util
 */
use Poet\Framework\Util\Traits\Macroable;
class Arr {
   use Macroable;

//   public static function add($array,$key,$value){
//       if(is_null(static::get($array,$key))){
//           static::set($array,$key,$value);
//       }
//       return $array;
//   }
//
//   public static function build($array,callable  $callback){
//       $results = [];
//       foreach($array as $key=>$value){
//           list($innerKey,$innerValue) = call_user_func($callback,$key,$value);
//           $results[$innerKey] = $innerValue ;
//       }
//       return $results;
//   }

   public static function get($array,$key,$default = null){
        if(is_null($key)){
            return $array;
        }

        if(isset($array[$key])){
            return $array[$key];
        }

        foreach(explode('.',$key) as $segment) {
            if (!is_array($array) ||  !array_key_exists($segment,$array)) {
                return value($default);
            }
            $array = $array[$segment];
          }


        return $array;
   }

    public static function set(&$array,$key,$value){
       if(is_null($key)){
           return $array = $value;
       }
       $keys = explode(".",$key);
       while(count($keys) > 1){
           $key = array_shift($keys);
           if(!isset($array[$key]) || !is_array($array[$key])){
               $array[$key]  = [];
           }
           $array =  &$array[$key];

       }
        $array[array_shift($keys)] = $value;
        return $array;

    }


    public static function has($array,$key){
        if(empty($array) || is_null($key)){
            return false;
        }
        if(array_key_exists($key,$array)){
             return $array[$key];
        }

        $keys = explode(".",$key);
        foreach($keys as $key){
            if( !is_array($array) || !array_key_exists($key,$array)){
                return false;
            }
            $array = $array[$key];
        }
          return true;

    }





}