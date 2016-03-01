<?php
namespace Poet\Framework\Db;
/**
 * 操作数据库的中间层
 * Class Db
 * @package Poet\Framework\Db
 */
class Db {
    protected $dbType = null;
    protected $autoFree = false;
    //当前操作所属的模型名
    protected $model = "__think__";
    //是否使用永久连接
    protected $pconnect = false;
    //当前sql指令
    protected $queryStr = '';
    protected $modelsql = array();
    protected $lastInsID = null;
    protected $numRows = 0;
    protected $numCols = 0;
    protected $transTimes = 0;
    protected $error = '';
    //数据库连接id,支持多个数据库连接
    protected $linkID = array();
    //当前的数据库连接
    protected $_linkID = null;
    protected $queryID = null;
    protected $connected = false;
    protected $config = '';
    protected $comparison = array('eq'=>'=','neq'=>'<>','gt'=>'>','egt'=>'>=','lt'=>'<','elt'=>'<=','notlike'=>'NOT LIKE','like'=>'LIKE','in'=>'IN','notin'=>'NOT IN');
    protected $selectSql = 'SELECT%DISTINCT% %FIELD% FROM %TABLE%%JOIN%%WHERE%%GROUP%%HAVING%%ORDER%%LIMIT% %UNION%%COMMENT%';
    protected $bind = array();


    /**
     * 获取数据库实例
     * 不同的链接配置,获得一个连接
     */
    public static function getInstance($db_config=''){
        static $_instance = array();
        $guid  = to_guid_string($db_config);
        if(!isset($_instance[$guid])){
            $obj = new Db();
            $_instance[$guid] = $obj->factory($db_config);
        }
        return $_instance[$guid];
    }

    /**
     * 加载数据库
     */
    public function factory($db_config=''){

        $db_config = $this->parseConfig($db_config);
        if(empty($db_config['dbms'])){
            throw new \Exception("_NO_DB_CONFIG_");
        }
        if(strpos($db_config['dbms'],"\\")){
            $class = $db_config['dbms'];
        }else {
            $dbType = ucwords(strtolower($db_config['dbms']));
            $class = 'Poet\\Framework\\Db\\Driver\\'.$dbType;
        }
        //检查驱动类
        if(class_exists($class)){
            $db = new $class($db_config);
        }else {
            throw new \Exception('_NO_DB_DRIVER_'.":".$class);
        }

        return $db;
    }

    /**
     * 分析数据库的配置信息,支持数组和dsn
     */
    private function parseConfig($db_config){
        if(!empty($db_config)  && is_string($db_config)){
            $db_config = $this->parseDSN($db_config);
        }elseif(is_array($db_config)){
            $db_config = array_change_key_case($db_config);
            $db_config = array(
                'dbms'      =>  $db_config['db_type'],
                'username'  =>  $db_config['db_user'],
                'password'  =>  $db_config['db_pwd'],
                'hostname'  =>  $db_config['db_host'],
                'hostport'  =>  $db_config['db_port'],
                'database'  =>  $db_config['db_name'],
                'dsn'       =>  $db_config['db_dsn'],
                'params'    =>  $db_config['db_params'],
            );
        }elseif(empty($db_config)){
            //如果配置文件为空,读取配置文件
           if(config('app.db.DB_DSN') && 'pdo'!=strtolower(config('app.db.DB_TYPE'))){
               $db_config = $this->parseDSN(config('app.db.DB_DSN'));
           }else {
                $db_config = array (
                'dbms'      =>   config('app.db.DB_TYPE'),
                'username'  =>   config('app.db.DB_USER'),
                'password'  =>   config('app.db.DB_PWD'),
                'hostname'  =>   config('app.db.DB_HOST'),
                'hostport'  =>   config('app.db.DB_PORT'),
                'database'  =>   config('app.db.DB_NAME'),
                'dsn'       =>   config('app.db.DB_DSN'),
                'params'    =>   config('app.db.DB_PARAMS'),
            );
           }
        }
        return $db_config;
    }

    /**
     * 解析dsn字符串
     * @param $dsnStr
     */
    public function parseDSN($dsnStr){
         if( empty($dsnStr)) {return false;}
         $info = parse_url($dsnStr);
         if($info['scheme']){
             $dsn = array(
                 'dbms'      => $info['scheme'],
                 'username'  => isset($info['user']) ? $info['user'] :'',
                 'password'  => isset($info['pass']) ? $info['pass'] :'',
                 'hostname'  => isset($info['host']) ? $info['host'] :'',
                 'hostport'  => isset($info['port']) ? $info['port'] :'',
                 'database'  => isset($info['path']) ? substr($info['path'],1) :''
             );
         }else {
             preg_match('/^(.*?)\:\/\/(.*?)\:(.*?)\@(.*?)\:([0-9]{1, 6})\/(.*?)$/',trim($dsnStr),$matches);
             $dsn = array (
                 'dbms'      =>  $matches[1],
                 'username'  =>  $matches[2],
                 'password'  =>  $matches[3],
                 'hostname'  =>  $matches[4],
                 'hostport'  =>  $matches[5],
                 'database'  =>  $matches[6]
             );
         }
          $dsn['dsn'] = '';
          return $dsn;

   }


    /**
    * 根据dsn获取数据类型,返回大写
    */
    protected function _getDsnType($dsn){
        $match = explode(":",$dsn);

    }

    //初始化数据库连接
    protected function initConnect($master=false){

    }

    //分布式连接
    protected function multiConnect($master=false){

    }

    //数据库调试,记录当前的sql
    protected function debug(){

    }

    //设置锁机制
    protected function parseLock($lock=false){

    }
    //set 分析
    protected function parseSet($data){

    }

    //参数绑定
    protected function bindParam($name,$value){

    }

    //参数绑定分析
    protected function parseBind($bind){

    }

    //字段名解析
    protected function parseKey(&$key){
        return $key;
    }

    //value分析
    protected function parseValue(){

    }
    //filed分析
    protected function parseField(){

    }

    //table分析
    protected function parseTable(){

    }


    //where 分析
    protected function parseWhere(){

    }

    //where 子单元分析
    protected function parseWhereItem($key,$value){

    }

    //特殊条件分析
    protected function parseThinkWhere($key,$val){

    }

    // limit 分析
    protected function parseLimit($limit){
        return !empty($limit) ? ' LIMIT '.$limit.' ':'';
    }

    //join分析
    protected function parseJoin($join){

    }

    //order 分析
    protected function parseOrder($order){

    }

    //group分析
    protected function parseGroup(){

    }

    //having 分析
    protected function parseHaving(){

    }

    //comment分析
    protected function parseComment($comment){

    }

    //union 分析
    protected function parseUnion($union){

    }

    //插入记录
    public function insert($data,$options=array(),$replace=false){

    }

    //通过select方式插入记录
    public function selectInsert($fields,$table,$options=array()){

    }

    //更新记录
    public function update($data,$options){

    }

    //删除操作
    public function delete($options=array()){

    }

    //查找记录
    public function select($options=array()){

    }

    //生成查询sql
    public function buildSelectSql($options=array()){

    }

    //替换sql语句中的表达式
    public function parseSql($sql,$options=array()){

    }

    //获取最近一次查询的sql
    public function getLastSql($model=''){

    }
    //获取最近错误信息
    public function getError(){

    }
    //sql指令安全过滤
    public function escapeString($str){

    }

    //设置当前操作模型
    public function setModel($model){

    }

    //析构方法
    public function __destruct(){

    }

    //关闭数据库,由驱动类定义
    public function close(){}






}