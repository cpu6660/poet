<?php
use Poet\Framework\Bootstrap\Application;
/**
 *  根据php的各种类型生成唯一标识号
 */
function to_guid_string($mix){
    if(is_object($mix)){
        return spl_object_hash($mix);
    }else if(is_resource($mix)){
        $mix = get_resource_type($mix).strval($mix);
    }else {
        $mix = serialize($mix);
    }

    return md5($mix);
}

if(!function_exists('app')){
    function app($make){
        if(is_null($make)){
            return Application::getInstance();
        }else {
            $app = Application::getInstance();
            return  $app[$make];
        }
     }
}


if(!function_exists('config')){
    function config($key = null,$default = null){
       if(is_null($key)){
           return app('config');
       }
       if(is_array($key)){
           return app('config')->set($key);
       }
       return app('config')->get($key,$default);

    }
}