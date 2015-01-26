<?php

class DefaultController extends BackEndController
{
    public $modelName = 'ShopProducers';
    public $title = '';
	public function actionIndex()
	{
		$this->render('index');
	}
}