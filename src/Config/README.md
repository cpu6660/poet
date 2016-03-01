
##1.设置系统时间
date_default_timezone_set('Asia/Shanghai');
$application = new Application(__DIR__);
//设置这个实例
$application->setInstance($application);
$application->bootstrapWith($application->getBootstrappers());
$config = $application['config'];
$dbConfig = config('app.db.mysql');
var_dump($dbConfig);

