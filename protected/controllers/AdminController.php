<?php

class AdminController extends BackEndController
{
    public $modelName = 'null';
    public $defaultAction = 'index';

	public function actionIndex()
	{
        $this->redirect(array('admin.php/pages/item'));
		//$this->render('index');
	}
}