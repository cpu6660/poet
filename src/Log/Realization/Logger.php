<?php
namespace Poet\Framework\Log\Realization;
use Poet\Framework\Util\Contract\BaseLogger;
use Poet\Framework\Bootstrap\Application;
use Poet\Framework\Foundation\Exception\LoggerException;
use Monolog\Logger as MonoLogger;
use Monolog\Handler\RotatingFileHandler;
class Logger extends BaseLogger {


    /**
     * 程序启动时默认的日志记录器
     * @param Application $app
     * @throws LoggerException
     */
    public function bootstrap(Application $app){
        $this->app = $app;
       //判断日志记录的目录是否存在,如果不存在,就创建(等filesystem写完以后,就可以直接使用filesystem来操作了)
        if(is_dir($logDir = $app->logPath())){
            if(!is_writable($logDir)){
               throw new LoggerException("日志目录不可写,请手动设置日志目录可写");
            }
        }else {
         //创建目录
          if (!mkdir($logDir,0777,true)){
               throw new LoggerException('无法自动创建日志目录,请手动在项目目录下创建storage/log目录,并配置可写权限');
          }
        }

        //启动定义的日志服务
        $this->boot();
    }

    public function getHandlers(){
        return $this->logHandlers;
    }
    public function setHandler(){
       $this->logHandlers[] = new RotatingFileHandler($this->app->logPath().$this->app->getLogfileName(),0,'debug');
    }

    public function getLogger(){

        return $this->logger;
    }

    public function setLogger(){
        $this->logger = new MonoLogger("application");
    }





}