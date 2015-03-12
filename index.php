<?php
$time_start = microtime(1);

require_once('defines.php');

$config=dirname(__FILE__).'/protected/config/frontend.php';

require_once(YII_START);

Yii::createWebApplication($config)->run();

$time_end = microtime(1);
$time = $time_end - $time_start;

echo "Время работы скрипта $time секунд\n";