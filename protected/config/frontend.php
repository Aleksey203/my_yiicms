<?php
require_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'../components/sysComponents/AdminConf.php');
$models = H::getAllFrontEndModels();

return CMap::mergeArray(
    require_once(dirname(__FILE__).'/main.php'),
    array(
        // стандартный контроллер
        /*'defaultController' => 'site',

        'homeUrl' => '/',

        'import'=>array(    ),

        'preload' => array('log', 'maintenanceMode'),

        'onBeginRequest' => function($event)
        {
            // add rules in urlManager from db
            $urlManager = Yii::app()->getUrlManager();
            foreach(MenuModule::getRawList(MenuModule::SITE_ID) as $item){
                for($i=1;$i<4;$i++)
                    if($item->{'rule'.$i}){
                        $data = explode('=>',str_replace("'",'',$item->{'rule'.$i}));
                        $urlManager->addRules(array($data[0]=>$data[1]),false);
                    }
            }
            //Yii::app()->user->returnUrl = Yii::app()->session['returnUrl'];
            return true;
        },
        'onEndRequest' => function($event){
            //Yii::app()->session['returnUrl'] = Y::app()->request->url;
            return true;
        },

        // компоненты
        'components'=>array(
            // пользователь
            'user'=>array(
                'loginUrl' => array('/user/login'),
            ),

            'urlManager'=>array(
          		'urlFormat'=>'path',
                'showScriptName'=>false,
                'caseSensitive'=>false,
                'rules'=>array(

                    'catalog/<c_alias>_<c_id>'=>'shop/item/list',
                    'catalog/products/<i_alias>_<i_id>'=>'shop/item/view',
                    'catalog/cart'=>'shop/cart',

                    '/articles/page/<ContentItem_page:\d{1,2}>/'=>'content/item/list',
                    '/articles/<alias>'=>'content/item/view',
                    '/articles'=>'content/item/list',
                    '/articles/tag/<tag_id>'=>'content/item/listByTag',


                    'home'=>'/site/index',
                    'page/<alias>'=>'content/page/view',
                    //'<alias>'=>'content/page/view',

                    'contacts'=>'feedback/default/index',

                    '<module:\w+>/<controller:\w+>/<action:\w+>'=>'<module>/<controller>/<action>',
                ),
          	),

            'shoppingCart' =>
                array(
                    'class' => 'application.modules.shop.extensions.shoppingCart.EShoppingCart',
                ),

            'errorHandler'=>array(
          			// use 'site/error' action to display errors
                      'errorAction'=>'site/error',
                  ),

            'maintenanceMode' => array(
                'class' => 'application.extensions.MaintenanceMode.MaintenanceMode',
                'enabledMode'=>false,
            ),
        ),

        */
        'params'=>array(
            // this is used in Contact page
            'controllerPath'=>'frontend',
            'cfgName'=>'frontend',
        ),
    )
);