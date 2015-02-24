<?php

/**
 * This is the model class for table "shop_products".
 *
 * The followings are the available columns in table 'shop_products':
 * @property integer $id
 * @property string $article
 * @property integer $special
 * @property string $category
 * @property string $brand
 * @property string $date
 * @property integer $display
 * @property string $price
 * @property string $price2
 * @property string $name
 * @property string $text
 * @property string $title
 * @property string $url
 * @property string $keywords
 * @property string $description
 * @property string $img
 */
class ShopProducts extends ActiveRecord
{
    public $imgConf = array('s-'=>'cut 400x270','m-'=>'resize 800x600');
    protected $parameters_many;
	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
			array('article, category, brand, display, price', 'required'),
			array('special, display', 'numerical', 'integerOnly'=>true),
			array('article, name, title, url, keywords, description, img', 'length', 'max'=>255),
			array('category, brand, price, price2', 'length', 'max'=>10),
			array('date, text, parametersMany', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, article, special, category, brand, date, display, price, price2, name, text, title, url, keywords, description, img', 'safe', 'on'=>'search'),
		);
	}

	public function relations()
	{
        return array(
            'brands' => array(self::BELONGS_TO, 'ShopBrands', 'brand'),
            'categories' => array(self::BELONGS_TO, 'ShopCategories', 'category'),
            'parameters' => array(self::HAS_MANY, 'ShopProductValues', 'product'),
        );
	}


    public function getFieldsArray()
    {
        return array(
            'name'            => array('input c4'),
            'article'         => array('input c2'),
            'date'            => array('input c2'),
            'special'         => array('checkbox'),
            'display'         => array('checkbox'),
            'category'        => array('select c2',CHtml::listData(ShopCategories::model()->orderByName()->findAll(),'id', 'name')),
            'brand'           => array('select c2',CHtml::listData(ShopBrands::model()->orderByName()->findAll(),'id', 'name')),
            'price'           => array('input c'),
            'price2'          => array('input c'),
            'text'            => array('elrte c12'),
            'parameters'      => array('many c4'),
            'img'             => array('img c4',$this->imgConf),
            'seo'             => array('checkbox c2'),
            'url'             => array('input c4'),
            'title'           => array('input c6'),
            'keywords'        => array('input c12'),
            'description'     => array('input c12'),
        );
    }

    public function getColumnsArray()
    {
        return array(
            'id',
            'name',
            'article',
            'title',
            'url',
            array(
                'name'   => 'category',
                'type'   => 'raw',
                'value'  => '$data->categories ? CHtml::encode($data->categories->name) : ""',
                'filter' => CHtml::listData(ShopCategories::model()->orderByName()->findAll(),'id', 'name')
            ),
            array(
                'name'   => 'brand',
                'type'   => 'raw',
                'value'  => '$data->brands ? CHtml::encode($data->brands->name) : ""',
                'filter' => CHtml::listData(ShopBrands::model()->orderByName()->findAll(),'id', 'name')
            ),
            'date',
            'price',
            'price2',
            'img__image',
            'special__boolean',
            'display',
        );
    }

    public function getParametersMany()
    {
        if ($this->parameters_many===null)
            //$this->parameters_many = CHtml::listData(ShopProductValues::model()->findAllByAttributes(array('product'=>$this->id)),'parameter', 'value');
            $query = "
                SELECT sp.id, sp.name
                FROM shop_parameters sp
                LEFT JOIN shop_parameters__categories spc ON spc.parent=:category
                "; //echo $query;
        $this->parameters_many = CHtml::listData(ShopParameters::model()->findAllBySql($query,array(':category'=>$this->category)),'id', 'name');
        return $this->parameters_many;
    }

    public function setParametersMany($value)
    {
        $this->parameters_many=$value;
    }

    /**
    * @return string the associated database table name
    */
    public function tableName()
    {
        return 'shop_products';
    }

/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ShopProducts the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
