<?php
$microtime_start = microtime(1);
$time_start = time();
$micro_start = $microtime_start - $time_start;
//$date_start = date('H:i:s');

require_once('defines.php');

$config=dirname(__FILE__).'/protected/config/backend.php';

require_once(YII_START);
$time_middle = microtime(1);
Yii::createWebApplication($config)->run();

$time_end = microtime(1);
$time = $time_end - $time_start;
$time2 = $time_end - $time_middle;

$microtime_end = microtime(1);
$time_end = time();
$micro_end = $microtime_end - $time_end;
$date_end = date('H:i:s');

//echo "Начало в $date_start".substr($micro_start,1)." либо в microtime = $microtime_start";
echo '<br/>';
echo "Окончание в $date_end".substr($micro_end,1)." либо в microtime = $microtime_end";
echo '<br/>';
echo "Длительность ".round(($microtime_end-$microtime_start)*1000).' ms';
//echo "Начало $time_start секунд\n $microtime_start секунд\n";
//echo "Время работы скрипта $time секунд\n перед запуском $time2 секунд\n";
