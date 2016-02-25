<?php namespace Poet\Framework\Config\Realization;
use Poet\Framework\Config\Contract\ConfigContract;
use ArrayAccess;
use Poet\Framework\Util\Arr;
class ConfigRealization implements  ConfigContract,ArrayAccess {

    //存储临时设定的键值对
    private $items = [];


    public function __construct($items){
        $this->items = $items;
    }

    public function has($key){
        return Arr::has($this->items,$key);
    }

    /**
     * 获取某个key的值,先获取手动设定的,再读取相应的文件
     * @param $key
     */
    public  function get($key,$default=null){
        return Arr::get($this->items,$key,$default);
    }

    /**
     * 设置key对应的value值
     * @param $key
     * @param $value
     */
    public  function set($key,$value=null){
        if(is_array($key)){
            foreach($key as $innerKey=>$innerValue){
                Arr::set($this->items,$innerKey,$innerValue);
            }
        }else {
            Arr::set($this->items,$key,$value);
        }
    }

    public function prepend($key,$value){
        $array = $this->get($key);
        array_unshift($array,$value);
        $this->set($key,$array);
    }

    public function push($key,$value){
       $array = $this->get($key);
       $array[] = $value;
       $this->set($key,$value);
    }


    public function all(){
        return $this->items;
    }

    public function offsetExists($key){
         return $this->has($key);
    }

    public function offsetGet($key){
        return $this->get($key);
    }


    public function offsetSet($key,$value){
          $this->set($key,$value);
    }

    public function offsetUnset($key){
        $this->set($key,null);
    }



}