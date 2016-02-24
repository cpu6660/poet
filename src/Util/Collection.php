<?php
namespace Poet\Framework\Util;
use Countable;
use ArrayAccess;
use ArrayIterator;
use Poet\Framework\Util\Contract\Arrayable;
use Poet\Framework\Util\Contract\Jsonable;
use Poet\Framework\Util\Traits\Macroable;


class Collection  implements Countable,Jsonable,Arrayable,ArrayAccess{
    use Macroable;

    protected $items = [];

    public function __construct($items = []){
        $this->items = is_array($items) ? $items : $this->getArrayableItems($items);
    }

    public function count(){
        return count($this->items);
    }


    public function getArrayableItems($items){
        if($items instanceof self){
            return $items->all();
        }elseif($items instanceof Arrayable){
            return $items->toArray();
        }elseif($items instanceof Jsonable){
            return json_decode($items->toJson(),true);
        }
    }

    public function toJson($options=0){
       return json_encode($this->toArray(),$options);
    }

    public function all(){
        return $this->items;
    }

    public function toArray(){
        return array_map(function($value){
            return $value instanceof Arrayable ? $value->toArray() : $value;
        },$this->items);
    }

    public function offsetExists($key)
    {
        return array_key_exists($key,$this->items);
    }

    public function offsetGet($key)
    {
        return $this->items[$key];
    }

    public function offsetSet($key, $value)
    {
        if(is_null($key)){
            $this->items[] = $value;
        }else {
            $this->items[$key] = $value;
        }
    }

    public function offsetUnset($key)
    {
        unset($this->items[$key]);
    }

    public function toString(){
        return $this->toJson();
    }


    public function getIterator(){
        return new  ArrayIterator($this->items);
    }

    public function make($items = []){
        return  new static($items);
    }

    public function sum($callback=null){
        if(is_null($callback)){
            return array_sum($this->items);
        }
        $callback = $this->valueRetriever($callback);
        return $this->reduce(function($result,$item) use($callback){
           return $result+=$callback($item);
        },0);
    }

    public function valueRetriever($value){
        if($this->useAsCallable($value)){
            return $value;
        }
        return function($item) use($value){
           return data_get($item,$value);
        };
    }

    public function useAsCallable($value){
        return !is_string($value) && is_callable($value);
    }

    public function reduce(callable $callback,$initial=null){
        return array_reduce($this->items,$callback,$initial);
    }

}