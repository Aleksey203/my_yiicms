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
			array('guid, url, title, keywords, description, text', 'required'),
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
			'name' => 'Name',
			'url' => 'Url',
			'title' => 'Title',
			'keywords' => 'Keywords',
			'description' => 'Description',
			'text' => 'Text',
			'producer' => 'производитель',
			'country' => 'страна',
			'rank' => 'Rank',
			'rank2' => 'рейтинг для главной',
			'img' => 'Img',
			'img2' => 'картинка самого АКБ',
			'display' => 'Display',
			'discount' => 'наценка в процентах',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('guid',$this->guid,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('url',$this->url,true);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('keywords',$this->keywords,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('text',$this->text,true);
		$criteria->compare('producer',$this->producer,true);
		$criteria->compare('country',$this->country,true);
		$criteria->compare('rank',$this->rank);
		$criteria->compare('rank2',$this->rank2);
		$criteria->compare('img',$this->img,true);
		$criteria->compare('img2',$this->img2,true);
		$criteria->compare('display',$this->display);
		$criteria->compare('discount',$this->discount);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
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
