<?php

require_once('defines.php');

$config=dirname(__FILE__).'/protected/config/backend.php';

require_once(YII_START);

Yii::createWebApplication($config)->run();
