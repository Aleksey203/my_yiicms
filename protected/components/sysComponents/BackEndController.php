<?php
/** File: BackEndController.php Date: 01.12.14 Time: 14:44 */



class BackEndController extends CController {

    public $layout='//backend/column1';
    public $defaultAction = 'list';
    public $viewPath = '//backend';

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

    public function actionList()
    {
        $model = new $this->modelName;

        $this->render('list',array( 'model'=>$model, 'columns'=>$model->getColumns() ));
    }

    public function render($view,$data=null,$return=false)
    {
        if ($this->getViewFile($view)) {
            parent::render($view, $data, $return);
        } else {
            parent::render("application.views.backend.{$view}", $data, $return);
        }
    }
}