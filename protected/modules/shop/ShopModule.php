<?php

class ShopModule extends WebModule
{
    public $defaultController = 'products';

	public function init()
	{
		// this method is called when the module is being created
		// you may place code here to customize the module or the application
        parent::init();

		// import the module-level models and components
		$this->setImport(array(
			'shop.models.*',
			'shop.models.backend.*',
			'shop.models.frontend.*',
			'shop.components.*',
		));
	}

	public function beforeControllerAction($controller, $action)
	{
		if(parent::beforeControllerAction($controller, $action))
		{
			// this method is called before any module controller action is performed
			// you may place customized code here
			return true;
		}
		else
			return false;
	}
}
