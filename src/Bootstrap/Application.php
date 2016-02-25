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


    public function __construct($basePath = null){
        if($basePath){
            $this->setBasePath($basePath);
        }
    }


    public function setBasePath($basePath){
        $this->basePath = rtrim($basePath);
        return $this;
    }

    public function configPath(){
        return $this->basePath.DIRECTORY_SEPARATOR.'config';
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