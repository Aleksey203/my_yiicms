<?php

/**
 * This is the model class for table "shop_parameters".
 *
 * The followings are the available columns in table 'shop_parameters':
 * @property string $id
 * @property integer $rank
 * @property integer $type
 * @property integer $required
 * @property integer $in_filter
 * @property integer $in_product
 * @property integer $in_list
 * @property string $name
 * @property string $values
 */
class ShopParameters extends ActiveRecord
{
	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
			array('name,type', 'required'),
			array('rank, type, required, in_filter, in_product, in_list', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, rank, type, required, in_filter, in_product, in_list, name, values', 'safe', 'on'=>'search'),
		);
	}

	public function relations()
	{
        return array(
            'parameters'=>array(self::MANY_MANY, 'ShopCategories',
                'shop_parameters__categories(child, parent)'),
            'values'=>array(self::HAS_MANY, 'ShopProductValues','parameter'),
        );
	}

    public function getFieldsArray()
    {
        return array(
            'name'            => array('input c2'),
            'rank'            => array('input c2'),
            'type'            => array('select c2',AdminConf::getConfArray('attrTypes')),
            'required'        => array('checkbox'),
            'in_filter'       => array('checkbox'),
            'in_product'      => array('checkbox'),
            'in_list'         => array('checkbox'),
            'values'          => array('elrte c12'),
        );
    }

    public function getColumnsArray()
    {
        return array(
            'id',
            'name',
            //'values',
            array(
                'name'   => 'type',
                'type'   => 'raw',
                'value'  => '$data->type ? AdminConf::getConfArray("attrTypes",$data->type) : ""',
                'filter' => AdminConf::getConfArray('attrTypes')
            ),
            'rank',
            'required__boolean',
            'in_filter__boolean',
            'in_product__boolean',
            'in_list__boolean',
        );
    }

    /**
    * @return array customized attribute labels (name=>label)
    */
    public function attributeLabelsArray()
    {
        return array(
            'type' => 'тип данных'
        );
    }

    public function beforeDelete()
    {
        parent::beforeDelete();
        ShopParametersCategories::model()->deleteAllByAttributes(array('child'=>$this->id));
        return true;
    }

    /**
    * @return string the associated database table name
    */
    public function tableName()
    {
        return 'shop_parameters';
    }

/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ShopParameters the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
