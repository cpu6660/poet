<?php
namespace Poet\Framework\Bootstrap;
use Poet\Framework\Container\Container;
/**
 * 程序应用实例,启动,配置
 * Class Application
 * @package Poet\Framework\Bootstrap
 */
class Application extends Container {
    const VERSION='1.0.0';

    protected $basePath;

    protected $storagePath;

    protected $environmentPath;

    protected $environmentFile = ".env";

    protected $namespace = null;

    protected $logFilename = 'poet';

    private static  $instance ;
    public function __construct($basePath = null){
        if($basePath){
            $this->setBasePath($basePath);
        }
    }

    public static function setInstance(Application $instance){
       self::$instance  = $instance;
    }

    public static function getInstance(){
        return self::$instance;
    }


    public function getLogfileName(){
        return $this->logFilename;
    }

    public function setBasePath($basePath){
        $this->basePath = rtrim($basePath);
        return $this;
    }

    public function configPath(){
        return $this->basePath.DIRECTORY_SEPARATOR.'config';
    }

    public function logPath(){
        return $this->basePath.DIRECTORY_SEPARATOR.'storage/log/';
    }

    public function logFilename(){
        return $this->logFilename;
    }

    /**
 * 启动配置的启动加载项
 * @param $bootstrappers
 */
    public function bootstrapWith($bootstrappers){
        foreach($bootstrappers as $key => $bootstrapper){
            //启动
            list($bootkey,$bootObject) = $bootstrapper ;
            $this[$bootkey] = function()use($bootObject){

              return new $bootObject;
            };
            $this[$bootkey]->bootstrap($this);
        }
    }

    /**
     * 配置启动加载项
     * @return array
     */
    public function getBootstrappers(){
        return [
            ['LogConfiguration','Poet\Framework\Bootstrap\LoadConfiguration'],
            ['Logger','Poet\Framework\Log\Realization\Logger']
        ];
    }


}