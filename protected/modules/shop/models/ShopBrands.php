<?php

/**
 * This is the model class for table "shop_brands".
 *
 * The followings are the available columns in table 'shop_brands':
 * @property string $id
 * @property integer $display
 * @property string $title
 * @property string $url
 * @property string $keywords
 * @property string $description
 * @property string $name
 */
class ShopBrands extends ActiveRecord
{
	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
			array('url, name', 'required'),
			array('display', 'numerical', 'integerOnly'=>true),
			array('title, url, keywords, description, name', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, display, title, url, keywords, description, name', 'safe', 'on'=>'search'),
		);
	}

	public function relations()
	{
		return array(
		);
	}

    public function getFieldsArray()
    {
        return array(
            'name'            => array('input c9'),
            'display'         => array('checkbox'),
            'seo'             => array('checkbox c2'),
            'title'           => array('input c6'),
            'url'             => array('input c4'),
            'keywords'        => array('input c12'),
            'description'     => array('input c12'),
        );
    }

    public function getColumnsArray()
    {
        return array(
            'id',
            'name',
            'display',
            'title',
            'url',
            'keywords',
            'description',
        );
    }

    public function beforeDelete()
    {
        parent::beforeDelete();
        if (ShopProducts::model()->exists('brand=:brand', array(':brand'=>$this->id)))
        {
            echo 'Перед удалением необходимо удалить все товары данного производителя';
            return false;
        }
        return true;
    }

    /**
    * @return string the associated database table name
    */
    public function tableName()
    {
        return 'shop_brands';
    }

/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ShopBrands the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
