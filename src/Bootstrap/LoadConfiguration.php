<?php
namespace Poet\Framework\Bootstrap;
use Poet\Framework\Bootstrap\Application;
use Poet\Framework\Config\Realization\ConfigRealization;
class LoadConfiguration {

    /**
     * 加载配置文件
     * @param \Poet\Framework\Bootstrap\Application $app
     */
    public function bootstrap(Application $app){
         //加载对应的配置文件
         //todo 对配置进行缓存,如果有缓存,直接读取缓存里的内容(缓存到文件,或者缓存到内存)
         $items = [];
         $app['config'] = function()use($items){
             return new ConfigRealization($items);
         };
         $this->loadConfigurationFiles($app,$app['config']);
    }


    protected function loadConfigurationFiles(Application $app,ConfigRealization $realization){
       //todo 完成filesystem 的编写,再更改这里的代码,先进行简单的实现
       $configPath =   $app->configPath();
       $filename   =   $configPath."/app.php";
       if(file_exists($filename) && is_readable($filename)){
           $realization->set('app', require $filename );
       }
    }
}