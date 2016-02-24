<?php namespace Poet\Framework\Config\Realization;
use Poet\Framework\Config\Contract\ConfigContract;

class ConfigRealization implements  ConfigContract {

    //存储临时设定的键值对
    private $items = [];
    //设置配置文件的根目录(设置为绝对路径)
    private static $config_base_dir;
    //在哪个目录层次下设置的
    private static $work_dir;


    /**
     * 获取某个key的值,先获取手动设定的,再读取相应的文件
     * @param $key
     */
    public static function get($key){

    }

    /**
     * 设置key对应的value值
     * @param $key
     * @param $value
     */
    public static function set($key,$value){

    }

    public static function setConfigDir($configDir){
        self::$work_dir = getcwd();
        //如果输入的是相对路径
        if(true) {
            self::$config_base_dir = self::$work_dir . "/" . $configDir;
        } else {
            self::$config_base_dir = $configDir ;
        }

    }


}