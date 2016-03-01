<?php
namespace Poet\Framework\Cache;
use Poet\Framework\Foundation\Exception\DbException;
/**
 * 缓存管理类
 * Class Cache
 * @package Poet\Framework\Cache
 */
class Cache {
  /**
   * 操作句柄
   */

  protected $handler;

  protected $options = array();

  public function connect($type='',$options=array()){
      if(empty($type)) $type = config('cache.DATA_CACHE_TYPE');
      if(strpos($type,'\\')){ //驱动类支持独立的命名空间
          $class  = $type;
      }else {
          $class = 'Poet\\Framework\\Cache\\Dirver\\'.ucwords(strtolower($type));
      }
      if(class_exists($class)){
          $cache = new $class($options);
      }else {
          throw new DbException("数据库驱动:".$class."不存在");
      }

      return $cache;
  }

    /**
     * 获取缓存类实例
     * @param string $type
     * @param array $options
     * @return mixed
     * @throws DbException
     */
   public static function getInstance($type='',$options=array()){
        static $_instances = [];
        $guid = $type.to_guid_string($options);
        if(!isset($_instances[$guid])){
            $obj = new Cache();
            $_instances[$guid] =  $obj->connect($type,$options);
        }
        return $_instances[$guid];
   }

    public function __get($name){
        return $this->get($name);
    }

    public function __set($name,$value){
        return $this->set($name,$value);
    }

    public function __unset($name){
        $this->rm($name);
    }

    public function setOptions($name,$value){
        $this->options[$name] = $value;
    }

    public function getOptions($name){
        return $this->options[$name];
    }

    public function __call($method,$args){
        if(method_exists($this->handler,$method)){
            return call_user_func_array(array($this->handler,$method),$args);
        }else {
            throw new DbException("所调用的方法不存在");

        }
    }
}