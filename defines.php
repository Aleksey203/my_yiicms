<?

error_reporting(E_ALL ^ E_NOTICE);
defined('YII_DEBUG') or define('YII_DEBUG',true);
defined('YII_DEBUG') or define('YII_DEBUG',false);

if ($_SERVER['SERVER_ADDR'] == '127.0.0.1')  define('LOCALHOST',true);
else define('LOCALHOST',false);

$localPath =  $_SERVER['DOCUMENT_ROOT'] . '/../../';
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);

if(YII_DEBUG == 1 ) $start = 'yii.php';
else $start = 'yiilite.php';


define('YII_START', $localPath.'yii/framework/'.$start);

//define('LOAD_ICO','/assets_static/images/front/loading.gif');
//define('BACKEND_NAME','admin');
?>