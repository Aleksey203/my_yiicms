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
        if ($url!=$module.'/'.$controller.'/'.$action) $this->redirect(array($action));
        $model = new $this->modelName('search');
        if (!isset($_GET[$this->modelName.'_sort'])) {
            if (isset($model->order)) $this->redirect(array($action,$this->modelName.'_sort'=>$model->order));
                else {
                    $columns = $model->getFieldsArray();
                    $sort = (isset($columns['date'])) ? 'date.desc' : 'id';
                    $this->redirect(array($action,$this->modelName.'_sort'=>$sort));
                }
        }
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
        $modelName = $this->modelName;
        if ($new === true) {
            $model = new $modelName;
            //$model->unsetAttributes();
        }
        else
            $model = $modelName::model($modelName)->findByPk($_GET['id']);

        if (!$model)
            throw new CHttpException(404, 'Страница не найдена.');

        //$form = new СForm($model);

        if (Yii::app()->request->isPostRequest)
        {
            $model->attributes = $_POST[get_class($model)];

            if ($model->validate())
            {
                $model->save();
                $action = Yii::app()->controller->action->id;
                if (@$_POST['redirect']=='true')
                    $this->redirect(array($this->defaultAction));
                else
                    Yii::app()->user->setFlash('success',"Изменения успешно сохранены!");
            }
        }

        $this->render('update', array(
            'model'=>$model,
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
            $model->delete();
            //$this->setFlash('mod-msg', 'Элемент удален');
        }
        else throw new CHttpException(400,'Неверный запрос. Ссылка, по которой вы пришли, неверна или устарела.');

    }
    public function actionDeleteImg($id)
    {
        if(Yii::app()->request->isAjaxRequest)
        {
            $model = $this->loadModel($id);
            $path = ROOT_DIR.'files/'.$this->modelName.'/'.$id;
            if (is_dir($path))
                if (H::delete_all($path)) {
                    $model->img = '';
                    $model->save();
                }
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
        $model= $mName::model($mName)->findByPk($id);
        if($model===null) throw new CHttpException(404,'Запрашиваемая страница не найдена.');
        return $model;
    }

}