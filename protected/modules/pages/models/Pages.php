<?php

/**
 * This is the model class for table "pages".
 *
 * The followings are the available columns in table 'pages':
 * @property integer $id
 * @property integer $language
 * @property integer $parent
 * @property string $left_key
 * @property string $right_key
 * @property integer $level
 * @property integer $display
 * @property integer $menu
 * @property string $module
 * @property string $name
 * @property string $text
 * @property string $url
 * @property string $title
 * @property string $keywords
 * @property string $description
 */
class Pages extends ActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'pages';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('left_key, right_key, display, menu', 'required'),
			array('language, parent, level, display, menu', 'numerical', 'integerOnly'=>true),
			array('left_key, right_key', 'length', 'max'=>10),
			array('module', 'length', 'max'=>20),
			array('name, url, title, keywords, description', 'length', 'max'=>255),
			array('text', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, language, parent, left_key, right_key, level, display, menu, module, name, text, url, title, keywords, description', 'safe', 'on'=>'search'),
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
			'language' => 'Language',
			'parent' => 'Parent',
			'left_key' => 'Left Key',
			'right_key' => 'Right Key',
			'level' => 'Level',
			'display' => 'Display',
			'menu' => 'Menu',
			'module' => 'Module',
			'name' => 'Name',
			'text' => 'Text',
			'url' => 'Url',
			'title' => 'Title',
			'keywords' => 'Keywords',
			'description' => 'Description',
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
		$criteria->compare('language',$this->language);
		$criteria->compare('parent',$this->parent);
		$criteria->compare('left_key',$this->left_key,true);
		$criteria->compare('right_key',$this->right_key,true);
		$criteria->compare('level',$this->level);
		$criteria->compare('display',$this->display);
		$criteria->compare('menu',$this->menu);
		$criteria->compare('module',$this->module,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('text',$this->text,true);
		$criteria->compare('url',$this->url,true);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('keywords',$this->keywords,true);
		$criteria->compare('description',$this->description,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Pages the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
