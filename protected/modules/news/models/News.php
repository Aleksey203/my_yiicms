<?php

/**
 * This is the model class for table "news".
 *
 * The followings are the available columns in table 'news':
 * @property integer $id
 * @property string $date
 * @property string $user
 * @property integer $display
 * @property string $name
 * @property string $text
 * @property string $title
 * @property string $url
 * @property string $keywords
 * @property string $description
 */
class News extends ActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'news';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, url, user', 'required'),
			array('display, user', 'numerical', 'integerOnly'=>true),
			array('name, title, url, keywords, description', 'length', 'max'=>255),
			array('date, text', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('date, user, display, name, title, url', 'safe', 'on'=>'search'),
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
            'users' => array(self::BELONGS_TO, 'Users', 'user'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabelsArray()
	{
		return array(
			'user' => 'автор новости',
		);
	}

    public function getFieldsArray()
    {
        return array(
            'name'=> array('input c6'),
            'date'=> array('input c2'),
            'user'=> array('select c2',CHtml::listData(Users::model()->orderByEmail()->findAll(),'id', 'email')),
            'display'=> array('checkbox c2'),
            'text'=> array('elrte c12',350),
            'seo'=> array('checkbox c2'),
            'url'=> array('input c4'),
            'title'=> array('input c6'),
            'keywords'=> array('input c12'),
            'description'=> array('input c12'),
        );
    }

    public function getColumnsArray()
    {
        return array(
            'id','name',
            array(
                'name'   => 'user',
                'type'   => 'raw',
                'value'  => '$data->users ? CHtml::encode($data->users->email) : ""',
                'filter' => CHtml::listData(Users::model()->orderByEmail()->findAll(),'id', 'email')
            ),
            'title','display','url','date'
        );
    }

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return News the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
