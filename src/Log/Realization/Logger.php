<?php
namespace Poet\Framework\Log\Realization;
use Psr\Log\AbstractLogger;
use Poet\Framework\Bootstrap\Application;
use Poet\Framework\Foundation\Exception\LoggerException;
class Logger extends AbstractLogger {
    //防止直接创建该对象
//   private  static  $instance;
//   //private 构造函数组织直接实例化
//   private function __construct(){
//
//   }
//
//   public static  function getInstance(){
//      if(is_null(self::$instance)){
//          self::$instance =  new self();
//      }
//      return self::$instance;
//   }

   public function log($level,$message, array $context=array()){
       //todo 完成logger的编写,流程已经调通(怎么防止多个实例)
         echo "something";
   }

    public function bootstrap(Application $app){
       //do something to boostrap logger,如果日志目录不可写,或者没有配置日志目录就报错
       //判断日志记录的目录是否存在,如果不存在,就创建(等filesystem写完以后,就可以直接使用filesystem来操作了)
        if(is_dir($logDir = $app->logPath())){
            if(!is_writable($logDir)){
               throw new LoggerException("日志目录不可写,请手动设置日志目录可写");
            }
        }else {
         //创建目录
          if (!mkdir($logDir,0777,true)){
               throw new LoggerException('无法自动创建日志目录,请手动在项目目录下创建storage/log目录');
          }
        }
    }


}