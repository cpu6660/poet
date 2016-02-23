<?php namespace Poet\Framework\Foundation;
/**
 * 环境检测
 * 检测dev,test,pro
 * @author eliot
 */
use Poet\Framework\Foundation\Exception\EnvironmentException;
use Jenssegers\Agent\Agent;
class EnvironmentDetector {

      //开发环境
     const ENVIRONMENT_DEV  = "dev";
      //测试环境
     const ENVIRONMENT_TEST = "test";
      //生产环境
     const ENVIRONMENT_PRO  =  "pro";
     //访问来源
     const SOURCE_WEB      = "from_web";
     const SOURCE_ANDROID  = "from_android";
     const SOURCE_IOS      = "from_ios";
     const SOURCE_APP      = "from_app";

      //设置成private,只能从getInstance 中获取
      private function __construct(){

      }
      //默认环境
      private static $environment = self::ENVIRONMENT_TEST;
      private static $instance;

     /**
     * 设置环境
     * @param $environment
     * @throws EnvironmentException
     */
      public static function setEnvironment($environment){
         if(!in_array($environment,[self::ENVIRONMENT_DEV,self::ENVIRONMENT_PRO,self::ENVIRONMENT_TEST])){
             throw new EnvironmentException("您所设定的环境超出范围");
         }
         self::$environment  =  $environment ;
      }

      /**
      * @return EnvironmentDetector
      * 获取环境单例
      */
      public static function getInstance(){
          if(is_null(self::$instance)){
              self::$instance = new self();
          }
          return self::$instance;
      }

     /**
     * 获取环境
     * @return string
     */
      public static function getEnvironment(){
          return self::$environment;
      }

     /**
     * 返回是否从web访问
     */
      public function isWeb(){

          $agent = $this->getAgent();
          return $agent->isDesktop();
      }

     /**
     * 返回是否从app访问
     */
      public function isApp(){
        $agent = $this->getAgent();
        return $agent->isMobile();
      }

    /**
     * 获取客户端信息
     * @return Agent
     */
      public function getAgent(){
          return new Agent();
      }

}
