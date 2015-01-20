<?php

/**
 * This is the model class for table "shop_brands".
 *
 * The followings are the available columns in table 'shop_brands':
 * @property integer $id
 * @property string $guid
 * @property string $name
 * @property string $url
 * @property string $title
 * @property string $keywords
 * @property string $description
 * @property string $text
 * @property string $producer
 * @property string $country
 * @property integer $rank
 * @property integer $rank2
 * @property string $img
 * @property string $img2
 * @property integer $display
 * @property integer $discount
 */
class ShopBrandsBase extends ActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'shop_brands';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, url', 'required'),
			array('rank, rank2, display, discount', 'numerical', 'integerOnly'=>true),
			array('guid', 'length', 'max'=>36),
			array('name, url, title, keywords, producer, country, img, img2', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, guid, name, url, title, keywords, description, text, producer, country, rank, rank2, img, img2, display, discount', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'guid' => 'Guid',
			'name' => 'название',
			'url' => 'Url',
			'title' => 'Title',
			'keywords' => 'Keywords',
			'description' => 'Description',
			'text' => 'текст',
			'producer' => 'производитель',
			'country' => 'страна',
			'rank' => 'рейтинг',
			'rank2' => 'рейтинг для главной',
			'img' => 'фото',
			'img2' => 'картинка самого АКБ',
			'display' => 'показывать',
			'discount' => 'наценка в процентах',
		);
	}

    public function getFields()
    {
        $fields = array(
            'name'=> array('input c3'),
            //'module'=> array('select c2',AdminConf::getKeysBaseModules()),
            //'menu'=> array('checkbox c1'),
            'producer'=> array('input c2'),
            'country'=> array('input c2'),
            'rank'=> array('input c1'),
            'discount'=> array('input c2'),
            'display'=> array('checkbox c2'),
            'text'=> array('elrte c12',300),
            'seo'=> array('checkbox c3'),
            'url'=> array('input c4'),
            'title'=> array('input c5'),
            'keywords'=> array('input c12'),
            'description'=> array('input c12'),
        );
        return parent::getFields($fields);
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
