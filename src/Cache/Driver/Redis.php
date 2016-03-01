<?php
namespace Poet\Framework\Cache\Driver;

use Poet\Framework\Cache\Cache;
use Poet\Framework\Foundation\Exception\CacheException;

/**
 * redis 操作类
 * handler 可以换成其他的实现,phpredis等
 * Class Redis
 * @package Poet\Framework\Cache\Driver
 */
class Redis extends Cache
{

    public function __construct($options = array())
    {
        if (!extension_loaded('redis')) {
            throw new CacheException("redis 扩展未加载");
        }
        //如果options是空的,就读取相应的配置
        if (empty($options)) {
            $options = [
                'host' => config('cache.redis.REDIS_HOST') ? config('cache.redis.REDIS_HOST') : '127.0.0.1',
                'port' => config('cache.redis.REDIS_PORT') ? config('cache.redis.REDIS_PORT') : 6379,
                'password' => config('cache.redis.REDIS_PASSWORD') ? config('cache.redis.REDIS_PASSWORD') : '',
                'timeout' => config('cache.redis.REDIS_TIMEOUT') ? config('cache.redis.REDIS_TIMEOUT') : false,
                'persistent' => false

            ];
        }
        //如果设置了,直接赋值
        $this->options = $options;
        //如果这几个选项没有配置,则设置默认值
        $this->options['expire'] = isset($options['expire']) ? $options['expire'] : config('cache.redis.CACHE_TIME');
        $this->options['prefix'] = isset($options['prefix']) ? $options['prefix'] : config('cache.redis.CACHE_PREFIX');
        $this->options['length'] = isset($options['length']) ? $options['length'] : 0;
        $func = $options['persistent'] ? 'pconnect' : 'connect';
        $this->handler = new \Redis();
        $options['timeout'] == false ? $this->handler->$func($options['host'], $options['port'])
            : $this->handler->$func($options['host'], $options['port'], $options['timeout']);
        if (!empty($options['password'])) {
            $this->handler->auth($options['password']);
        }

    }

    public function get($name)
    {
       $value = $this->handler->get($this->options['prefix'].$name);
       $jsonData = json_decode($value,true);
       return ($jsonData === null) ? $value :$jsonData;  //检测是否为json数据, true 返回json解析数组,false返回源数据
    }

    public function set($name, $value, $expire = null)
    {
        if(is_null($expire)){
            $expire = $this->options['expire'];
        }
        $name  = $this->options['prefix'].$name;
        $value = (is_object($value)) || (is_array($value))  ? json_encode($value) : $value;
        if(is_int($expire)){
            $result = $this->handler->setnx($name,$expire,$value);
        }else {
            $result = $this->handler->set($name,$value);
        }

        return $result;

    }

    public function rm($name)
    {
       return $this->handler->del($this->options['prefix'].$name);
    }

    public function clear()
    {
       return $this->handler->flushDB();
    }

    public function set2($name, $value,$expire=null)
    {
       return $this->handler->set($name,$value,$expire);
    }

    public function get2($name)
    {
       return $this->handler->get($name);
    }

    public function incBy($name, $value)
    {
       return $this->handler->incrBy($name,$value);
    }

    public function decrBy($name, $value)
    {
      return $this->handler->decrBy($name,$value);
    }

    public function incr($name)
    {
     return  $this->handler->incr($name);
    }

    public function expire($key, $seconds)
    {
      return $this->handler->expire($key,$seconds);
    }

    public function rPush($name, $value)
    {
      return $this->handler->rpush($name,$value);
    }

    public function lPush($name, $value)
    {
      return $this->handler->lPush($name,$value);
    }


    public function del($name)
    {
      $this->handler->del($name);
    }

    public function multi()
    {
       $this->handler->multi();
    }

    public function exec()
    {
      $this->handler->exec();
    }

    public function discard(){
        $this->handler->discard();
    }
    public function setnx($name, $value)
    {
      return $this->handler->setnx($name,$value);
    }

    public function getset($name, $value)
    {
      return $this->handler->getSet($name,$value);
    }

    public function delnx($name)
    {
      return $this->handler->del($name);
    }
}