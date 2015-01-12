<?php
/** File: BackEndController.php Date: 01.12.14 Time: 14:44 */



class BackEndController extends CController {

    public $layout='//backend/column1';
    public $defaultAction = 'list';
    public $viewPath = '//backend';
    public $modelName;

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
        $model = new $this->modelName('search');
        $model->unsetAttributes();
        if (!empty($_GET[$this->modelName]))
            $model->attributes = $_GET[$this->modelName];
        $this->render('list',array( 'model'=>$model, 'columns'=>$model->getColumns() ));
    }

    public function actionAjax($id,$name,$value)
    {
        $model = $this->loadModel($id);
        $model->{$name} = $value;
        $model->save(false);

    }


    public function actionDelete($id)
    {
        if(Yii::app()->request->isAjaxRequest)
        {
            $model = $this->loadModel($id);
            $path = ROOT_DIR.'files/'.$this->modelName.'/'.$id;
            if (is_dir($path)) $this->delete_all($path);
            $model->delete();
            //$this->setFlash('mod-msg', 'Элемент удален');
        }
        else throw new CHttpException(400,'Неверный запрос. Ссылка, по которой вы пришли, неверна или устарела.');

    }

    public function render($view,$data=null,$return=false)
    {
        if ($this->getViewFile($view)) {
            parent::render($view, $data, $return);
        } else {
            parent::render("application.views.backend.{$view}", $data, $return);
        }
    }

    public function loadModel($id)
    {
        $mName = $this->modelName;
        $model= $mName::model()->findByPk($id);
        if($model===null) throw new CHttpException(404,'Запрашиваемая страница не найдена.');
        return $model;
    }

    public function delete_all($dir,$i = true) {
        if (is_file($dir)) return unlink($dir);
        if (!is_dir($dir)) return false;
        $dh = opendir($dir);
        while (false!==($file = readdir($dh))) {
            if ($file=='.' || $file=='..') continue;
            $this->delete_all($dir.'/'.$file);
        }
        closedir($dh);
        if ($i==true) return rmdir($dir);
    }
}