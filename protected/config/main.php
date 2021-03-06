<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
//$modules = array('pages', 'test');

$modules = H::getBaseModules();

return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'Моя удобная и быстрая админка',
    'language'=>'ru',
	// preloading 'log' component
	'preload'=>array('log'),



	// autoloading model and component classes
	'import'=>array_merge($models, array(
		'application.models.*',
		'application.models.backend.*',
		'application.models.frontend.*',
		'application.components.*',
		'application.components.sysComponents.*',
        'application.helpers.*',
        //'application.extensions.yiidebugtb.*',
	)),

	'modules'=>array_merge($modules, array(
        // uncomment the following to enable the Gii tool
        'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'8976',
            'generatorPaths' => array('application.generators'),
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1','::1'),
		),

	)),

	// application components
	'components'=>array(
		'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
		),
        'image'=>array(
            'class'=>'application.extensions.image.CImageComponent',
            // GD or ImageMagick
            'driver'=>'GD',
            // ImageMagick setup path
            'params'=>array('directory'=>'/opt/local/bin'),
        ),

        'language'=>'ru',
		// uncomment the following to enable URLs in path-format
		/*
		'urlManager'=>array(
			'urlFormat'=>'path',
			'rules'=>array(
				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
		),
		*/
		/*'db'=>array(
			'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
		),*/
		// uncomment the following to use a MySQL database

		'db'=>array(
			'connectionString' => 'mysql:host=127.0.0.1;dbname=me',
			'emulatePrepare' => true,
			'username' => 'root',
			'password' => '',
			'charset' => 'utf8',
            // включаем профайлер
            'enableProfiling'=>true,
            // показываем значения параметров
            'enableParamLogging' => true,
		),

		'errorHandler'=>array(
			// use 'site/error' action to display errors
			'errorAction'=>'site/error',
		),
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
                /*array(
                    'class'=>'CFileLogRoute',
                    'levels'=>'error, warning, trace',
                ),

                array(
                    'class'=>'application.extensions.yii-debug-toolbar.YiiDebugToolbarRoute',
                    //'ipFilters'=>array('127.0.0.1','192.168.1.215'),
                ),*/
				// uncomment the following to show log messages on web pages
                /*array(
                    // направляем результаты профайлинга в ProfileLogRoute (отображается
                    // внизу страницы)
                    'class'=>'CProfileLogRoute',
                    'levels'=>'error, warning, trace, profile, info',
                    'enabled'=>true,
                ),
                array(
                    'class' => 'CWebLogRoute',
                    'categories' => 'application',
                    'levels'=>'error, warning, trace, profile, info',
                ),*/
			),
		),
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		'adminEmail'=>'webmaster@example.com',
	),
);