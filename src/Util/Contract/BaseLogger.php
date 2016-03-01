<?php
namespace Poet\Framework\Util\Contract;
use  Psr\Log\AbstractLogger;
abstract class BaseLogger  extends AbstractLogger {
    protected $app;

    //日志处理器
    protected  $logHandlers = [];

    //日志记录通道
    protected  $logger;


     abstract public function getHandlers();


     abstract public function setHandler();

     abstract public function getLogger();


     abstract public function setLogger();

     public function setFormatter(){

     }

     public function getFormatter(){

     }

     /**
     * 为logger设置handler
     */
     public function setHandlerForLogger(){
        foreach($this->logHandlers as $handler){
            $this->logger->pushHandler($handler);
        }
     }
    //记录日志之前启动定义的这个日志服务
    public function boot(){
        //设置logger
        $this->setLogger();
        //设置默认的handler
        $this->setHandler();
        //为logger设置handler
        $this->setHandlerForLogger();
    }

    //记录日志
    public function log($level,$message, array $context=array()){
        $this->getLogger()->log($level,$message,$context);

    }

}