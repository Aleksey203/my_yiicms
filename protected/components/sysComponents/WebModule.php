<?php

/**
 * Base admin module 
 * 
 * @uses CWebModule
 * @package Admin
 * @version $id$
 */
class WebModule extends CWebModule {

	public $_assetsUrl = null;

/*	public function initAdmin()
	{
		$this->setImport(array(
			'admin.models.*',
			'admin.components.*',
			'admin.widgets.*',
		));
	}*/

    public function init()
    {
        if(Yii::app()->params['cfgName']=='backend'){
            $this->controllerPath = $this->basePath.'/controllers/backend';
        }
        if(Yii::app()->params['cfgName']=='frontend'){
            $this->controllerPath = $this->basePath.'/controllers/frontend';
            //$this->viewPath = $this->basePath.'/views/frontend';
        }
    }
	/**
	 * Publish admin stylesheets,images,scripts,etc.. and return assets url
	 *
	 * @access public
	 * @return string Assets url
	 */
	public function getAssetsUrl()
	{
		if($this->_assetsUrl===null)
		{
			$this->_assetsUrl=Yii::app()->getAssetManager()->publish(
				Yii::getPathOfAlias('application.assets'),
				false,
				-1,
				YII_DEBUG
			);
		}

		return $this->_assetsUrl;
	}

	/**
	 * Set assets url
	 *
	 * @param string $url
	 * @access public
	 * @return void
	 */
	public function setAssetsUrl($url)
	{
		$this->_assetsUrl = $url;
	}

}
