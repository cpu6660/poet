<?php
namespace Poet\Framework\Log\Realization;
use Psr\Log\AbstractLogger;
use Poet\Framework\Bootstrap\Application;
class Logger extends AbstractLogger {
    //防止直接创建该对象

   public function log($level,$message, array $context=array()){
       //todo 完成logger的编写,流程已经调通(怎么防止多个实例)
         echo "something";
   }

    public function bootstrap(Application $app){
       //do something to boostrap logger,如果日志目录不可写,或者没有配置日志目录就报错
    }


}