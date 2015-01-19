<?php
/** File: BackEndController.php Date: 01.12.14 Time: 14:44 */



class BackEndController extends Controller {

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

        $this->registerScript("elfinderConnectorUrl = '".$this->createUrl('elfinderConnector')."'",
            CClientScript::POS_BEGIN);
    }

    public function actionList()
    {
        $url = Yii::app()->urlManager->parseUrl(Yii::app()->request);
        $module = Yii::app()->controller->module->id;
        $controller = Yii::app()->controller->id;
        $action = Yii::app()->controller->action->id;
        if ($url!=$module.'/'.$controller.'/'.$action) $this->redirect(array($controller));
        $model = new $this->modelName('search');
        $model->unsetAttributes();
        if (!empty($_GET[$this->modelName]))
            $model->attributes = $_GET[$this->modelName];
        $this->render('list',array( 'model'=>$model, 'columns'=>$model->getColumns() ));
    }

    public function actionCreate()
    {
        $this->actionUpdate(true);
    }

    public function actionUpdate($new = false)
    {
        $modelName =Yii::app()->controller->modelName;
        if ($new === true) {
            $model = new $modelName;
            $model->unsetAttributes();
        }
        else
            $model = $modelName::model()->findByPk($_GET['id']);

        if (!$model)
            throw new CHttpException(404, 'Страница не найдена.');

        //$form = new СForm($model);

        if (Yii::app()->request->isPostRequest)
        {
            $model->attributes = $_POST[get_class($model)];

            if ($model->validate())
            {
                $model->save();
                $this->redirect(array(Yii::app()->controller->id));
            }
        }

        $this->render('update', array(
            'model'=>$model,
            //'form2'=>$form2,
        ));
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

    public function actions() {
        return array (
            'elfinderconnector' => 'ext.elFinder-2.actions.elfinderConnector'
            //'ajaxupload' => 'ext.AjaxUpload.AjaxUploadAction'
        );
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