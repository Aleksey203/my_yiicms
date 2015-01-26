<?php

/**
 * This is the model class for table "shop_categories".
 *
 * The followings are the available columns in table 'shop_categories':
 * @property integer $id
 * @property string $parent
 * @property string $left_key
 * @property string $right_key
 * @property integer $level
 * @property integer $display
 * @property string $name
 * @property string $title
 * @property string $url
 * @property string $keywords
 * @property string $description
 */
class ShopCategories extends ActiveRecord
{
	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
			array('name', 'required'),
			array('level, display', 'numerical', 'integerOnly'=>true),
			array('parent, left_key, right_key', 'length', 'max'=>10),
			array('name, title, url, keywords, description', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, parent, left_key, right_key, level, display, name, title, url, keywords, description', 'safe', 'on'=>'search'),
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
            //'parent'          => array('input c'),
            //'left_key'        => array('input c'),
            //'right_key'       => array('input c'),
            //'level'           => array('input c'),
            'name'            => array('input c'),
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
            'display',
            'name',
            'title',
            'url',
            'keywords',
            'description',
        );
    }

    /**
    * @return string the associated database table name
    */
    public function tableName()
    {
        return 'shop_categories';
    }

/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ShopCategories the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
