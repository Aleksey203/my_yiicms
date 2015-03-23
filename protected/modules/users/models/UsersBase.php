<?php

/**
 * This is the model class for table "users".
 *
 * The followings are the available columns in table 'users':
 * @property integer $id
 * @property string $date
 * @property string $last_visit
 * @property integer $type
 * @property string $email
 * @property string $hash
 * @property string $avatar
 * @property string $fields
 */
class UsersBase extends ActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'users';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('date, last_visit, email, hash, avatar, fields', 'required'),
			array('type', 'numerical', 'integerOnly'=>true),
			array('email', 'length', 'max'=>255),
			array('hash', 'length', 'max'=>32),
			array('avatar', 'length', 'max'=>10),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, date, last_visit, type, email, hash, avatar, fields', 'safe', 'on'=>'search'),
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
            'news' => array(self::HAS_MANY, 'News', 'user'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ИД',
			'date' => 'дата регистрации',
			'last_visit' => 'время последней авторизации',
			'type' => 'группа пользователей',
			'email' => 'логин',
			'hash' => 'hash',
			'avatar' => 'изображение',
			'fields' => 'динамические характеристики',
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
		$criteria->compare('date',$this->date,true);
		$criteria->compare('last_visit',$this->last_visit,true);
		$criteria->compare('type',$this->type);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('hash',$this->hash,true);
		$criteria->compare('avatar',$this->avatar,true);
		$criteria->compare('fields',$this->fields,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Users the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
