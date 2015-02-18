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
    protected $parameters_array;
	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
			array('name', 'required'),
			array('parametersArray', 'safe'),
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
            'parameters'=>array(self::MANY_MANY, 'ShopParameters',
                'shop_parameters__categories(parent, child)'),
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
            'parameters'      => array('checkboxlist c12'),
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

    public function getParametersArray()
    {
        if ($this->parameters_array===null)
            $this->parameters_array=CHtml::listData($this->parameters, 'id', 'id');
        return $this->parameters_array;
    }

    public function setParametersArray($value)
    {
        $this->parameters_array=$value;
    }

    protected function afterSave()
    {
        $this->refreshParameters();
        parent::afterSave();
    }

    protected function refreshParameters()
    {
        $parameters = $this->parametersArray;

        ShopParametersCategories::model()->deleteAllByAttributes(array('parent'=>$this->id));

        if (is_array($parameters))
        {
            foreach ($parameters as $id)
            {
                if (ShopCategories::model()->exists('id=:id', array(':id'=>$this->id)))
                {
                    $paramCat = new ShopParametersCategories();
                    $paramCat->parent = $this->id;
                    $paramCat->child = $id;
                    $paramCat->save();
                }
            }
        }
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
