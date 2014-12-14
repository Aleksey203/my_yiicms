<?php
/** File: BackEndController.php Date: 01.12.14 Time: 14:44 */



class BackEndController extends CController {

    public $layout='//backend/column1';


    public $menu=array();
    /**
     * @var array the breadcrumbs of the current page. The value of this property will
     * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
     * for more details on how to specify this property.
     */
    public $breadcrumbs=array();

    public function init()
    {
        parent::init();
        if($this->modelName === '') throw new CHttpException(400,'Не задано имя модели в контроллере');
    }

    public function actionIndex()
    {
        $model = new $this->modelName;
        $items = $model->model()->findAll();
        // renders the view file 'protected/views/site/index.php'
        // using the default layout 'protected/views/layouts/main.php'
        $this->render('index',array( 'model'=>$items));
    }
} 