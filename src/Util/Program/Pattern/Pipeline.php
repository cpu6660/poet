<?php
namespace Poet\Framework\Util\Program\Pattern;
/**
 * 常用程式-pipeline
 */
use Poet\Framework\Bootstrap\Application;
use Closure;
class Pipeline {

      protected $app;


    /**
     * 所需传递的参数
     * @var
     */
      protected $passable;

    /**
     * 所需经历的过滤器,管道
     * @var
     */
      protected $pipes;

    /**
     * 各过滤器所要处理的方法
     * @var string
     */
      protected $method = 'handle';

      public function __construct(Application $app){
         $this->app = $app;
      }

    /**
     *设置要传递的参数
     * @param $passable
     * @return $this
     */
      public  function send($passable){
          $this->passable = $passable;
          return $this;
      }

    /**
     * 经过哪些管道
     * @param $pipes
     * @return $this
     */
      public function through($pipes){
          $this->pipes = is_array($pipes) ? $pipes : func_get_args() ;
          return $this;
      }

    /**
     * 设置管道所需处理的方法
     * @param $method
     * @return $this
     */
      public function via($method){
          $this->method = $method;
          return $this;
      }

    /**
     * 逻辑从这里开始执行
     * @param Closure $destination
     */
      public function then(Closure $destination){
         $firstSlice = $this->getInitialSlice($destination);
         $pipes = array_reverse($this->pipes);
         return call_user_func(array_reduce($pipes,$this->getSlice(),$firstSlice),$this->passable);
      }

    /**
     * 初始化第一个回调(格式化)
     * @param Closure $destination
     */
    public function getInitialSlice(Closure $destination){
        return function($passable)use($destination){
             return call_user_func($destination,$passable);
        };
    }

    /**
     * 获取执行片
     */
    public function getSlice(){
        return function($stack,$pipe){
            return function($passable)use($stack,$pipe){
                if($pipe instanceof Closure){
                    return call_user_func($pipe,$passable,$stack);
                }else {
                 //如果不是匿名函数
                 list($name,$parameters) = $this->parsePipeString($pipe);
                  //这里修改一下,让middleware的方法能够直接得到错传入的参数,可以重新规定传入参数的格式
//                 return call_user_func_array([$this->app[$name],$this->method],
//                                              array_merge([$passable,$stack],$parameters));
                    return call_user_func_array([$this->app[$name],$this->method],
                       [array_merge($passable,$parameters),$stack]);
                }

            };
        };
    }

    /**
     * 从过滤器配置中解析出相应的类,方法和参数
     * @param $pipe
     * @return array
     */
    public function parsePipeString($pipe){
        list($name,$parameters) = array_pad(explode(':',$pipe,2),2,[]);
        if(is_string($parameters)){
            $parameters = explode(',',$parameters);
        }
        return [$name,$parameters];
    }


}


/**
 *
 * 测试代码
 */
//$params = ['a','b'];
//$a = function($passable,Closure $next){
//    echo 'a';
//    return $next($passable);
//};
//
//$b = function($passable,Closure $next){
//    echo "b";
//    return $next($passable);
//};
//
//$application  = new Application(__DIR__);
//
//(new Pipeline($application))->send($params)
//    ->through([$a,$b])
//    ->then(function(){
//        echo  "the end";
//    });