<?php

return CMap::mergeArray(
    require_once(dirname(__FILE__) . '/main.php'),
    array(
        // стандартный контроллер
        'defaultController' => 'Site',

        'homeUrl' => '',

        /*'import' => array(
            'zii.widgets.grid.CGridView',
        ),

        'onBeginRequest' => function($event)
        {
            // add rules in urlManager from db
            $urlManager = Yii::app()->getUrlManager();
            foreach(MenuModule::getRawList(MenuModule::ADMIN_ID) as $item){
                for($i=1;$i<4;$i++)
                    if($item->{'rule'.$i}){
                        $data = explode('=>',str_replace("'",'',$item->{'rule'.$i}));
                        $urlManager->addRules(array(BACKEND_NAME.$data[0]=>$data[1]),false);
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
        'components' => array(

            /*'errorHandler'=>array(
                'errorAction'=>'admin/error',
            ),*/
            /*'clientScript' => array(
                'scriptMap' => array(
                    'jquery.js' => false,
                    'jquery.min.js' => false,
                    'jquery-ui.min.js' => false,
                    'jquery-ui.css' => false,
                    //'jquery.ba-bbq.js'=>false,
                    'jquery.yiigridview.js' => false,
                ),
            ),

            'user' => array(
                'loginUrl' => array('/user/login'),
            ),
            'urlManager' => array(
                'urlFormat' => 'path',
                'showScriptName' => false,
                'caseSensitive' => false,
                'rules' => array(

                    //BACKEND_NAME.'/igallery/item3/<action:\w+>'=>'/content/item3/<action>', // for mix menu

                    BACKEND_NAME => BACKEND_NAME,
                    BACKEND_NAME . '/<module:\w+>' => '<module>',
                    BACKEND_NAME . '/<module:\w+>/<controller:\w+>' => '<module>/<controller>',
                    BACKEND_NAME . '/<module:\w+>/<controller:\w+>/<action:\w+>' => '<module>/<controller>/<action>',
                    //BACKEND_NAME.'/<module:\w+>/<controller:\w+>/<action:\w+>/<id:\d+>'=>'<module>/<controller>/<action>',
                ),
            ),
        ),

        'params' => array(
            'cfgName' => 'backend',
        ),*/
    )
);