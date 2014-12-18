<?php

class AdminController extends BackEndController
{
    public $modelName = 'null';
    public $defaultAction = 'index';

	public function actionIndex()
	{
        $this->redirect(array('test/item/index'));
		//$this->render('index');
	}
}