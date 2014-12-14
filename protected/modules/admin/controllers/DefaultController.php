<?php

class DefaultController extends Controller
{
    public $layout='//admin/column1';

	public function actionIndex()
	{
		$this->render('index');
	}
}