<?php
namespace Poet\Framework\Cache\Driver;

use Poet\Framework\Cache\Cache;
use Poet\Framework\Foundation\Exception\CacheException;

class Memcache extends Cache
{

    public function __construct($options = array())
    {
        if (!extension_loaded('memcached')) {
            throw new CacheException("memcached 扩展不存在");
        }
        $options = array_merge(array(
            'host' => config('cache.memcached.HOST') ? config('cache.memcached.HOST') : '127.0.0.1',
            'port' => config('cache.memcached.PORT') ? config('cache.memcached.PORT') : '11211',
            'username' => config('cache.memcached.USER_NAME') ? config('cache.memcached.USER_NAME') : null,
            'password' => config('cache.memcached.PWD') ? config('cache.memcached.PWD') : null,
            'ocs' => config('cache.memcached.OCS') ? config('cache.memcached.OCS') : false,
            'timeout' => config('cache.memcached.TIME_OUT') ? config('cache.memcached.TIME_OUT') : false,
            'persistent' => false

        ), $options);
        $this->options = $options;
        $this->options['expire'] = isset($options['expire']) ? $options['expire'] : config('cache.memcached.CACHE_TIME');
        $this->options['prefix'] = isset($options['prefix']) ? $options['prefix'] : config('cache.memcached.CACHE_PREFIX');
        $this->options['length'] = isset($options['length']) ? $options['length'] : 0;
        $this->handler = new \Memcached();
        //如果配置了aliyun
        if ($options['ocs']) {
           $this->handler->setOption(\Memcached::OPT_COMPRESSION,false);
           $this->handler->setOption(\Memcached::OPT_BINARY_PROTOCOL,true);
           $this->handler->addServer($options['host'],$options['port']);
           $this->handler->setSaslAuthData($options['username'],$options['password']);
        }else {
            $this->handler->addServer($options['host'],$options['port']);
        }

    }

    public function get($name)
    {
      return $this->handler->get($this->options['prefix'].$name);
    }

    public function set($name, $value, $expire = null)
    {
      if(is_null($expire)){
          $expire = $this->options['expire'];
      }
      $name = $this->options['prefix'].$name;
      if($this->handler->set($name,$value,$expire)){
         return true;
      }
         return false;
    }

    public function rm($name, $ttl = false)
    {
        $name = $this->options['prefix'].$name;
        return $ttl === false ?
            $this->handler->delete($name):
            $this->handler->delete($name,$ttl);

    }

    public function clear()
    {
       return $this->handler->flush();
    }
}