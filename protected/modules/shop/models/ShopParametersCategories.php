<?php

/**
 * This is the model class for table "shop_parameters__categories".
 *
 * The followings are the available columns in table 'shop_parameters__categories':
 * @property string $id
 * @property string $child
 * @property string $parent
 */
class ShopParametersCategories extends ActiveRecord
{
	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
			array('child, parent', 'required'),
			array('child, parent', 'length', 'max'=>10),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, child, parent', 'safe', 'on'=>'search'),
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
            'child'           => array('input c'),
            'parent'          => array('input c'),
        );
    }

    public function getColumnsArray()
    {
        return array(
            'id',
            'child',
            'parent',
        );
    }

    /**
    * @return array customized attribute labels (name=>label)
    */
    public function attributeLabelsArray()
    {
        return array();
    }

    /**
    * @return string the associated database table name
    */
    public function tableName()
    {
        return 'shop_parameters__categories';
    }

/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ShopParametersCategories the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
