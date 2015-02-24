<?php

/**
 * This is the model class for table "shop_product_values".
 *
 * The followings are the available columns in table 'shop_product_values':
 * @property string $id
 * @property string $product
 * @property string $parameter
 * @property string $value
 */
class ShopProductValues extends ActiveRecord
{
	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
			array('product, parameter, value', 'required'),
			array('product, parameter', 'length', 'max'=>10),
			array('value', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, product, parameter, value', 'safe', 'on'=>'search'),
		);
	}

	public function relations()
	{
		return array(
            'products' => array(self::BELONGS_TO, 'ShopProducts', 'product'),
		);
	}

    public function getFieldsArray()
    {
        return array(
            'product'         => array('input c'),
            'parameter'       => array('input c'),
            'value'           => array('input c'),
        );
    }

    public function getColumnsArray()
    {
        return array(
            'id',
            'product',
            'parameter',
            'value',
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
        return 'shop_product_values';
    }

/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ShopProductValues the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
