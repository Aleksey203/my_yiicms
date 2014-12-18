<?php

class DefaultController extends BackEndController
{
    public $modelName = 'ShopBrands';
    public $title = '';
	public function actionIndex()
	{
		$this->render('index');
	}
}