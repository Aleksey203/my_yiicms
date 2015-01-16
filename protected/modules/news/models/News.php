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
    public $columns;
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
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'date' => 'дата',
			'user' => 'автор новости',
			'display' => 'показывать',
			'name' => 'Название',
			'text' => 'Текст',
			'title' => 'Title',
			'url' => 'Url',
			'keywords' => 'Keywords',
			'description' => 'Description',
		);
	}

    public function getColumns()
    {
        $columns = array(
            'id','name',
            array(
                'name'   => 'user',
                'type'   => 'raw',
                'value'  => '$data->users ? CHtml::encode($data->users->email) : ""',
                'filter' => CHtml::listData(Users::model()->orderByEmail()->findAll(),'id', 'email')
            ),
            'title','display','url','date'
        );
        return parent::getColumns($columns);
    }

    public function getFields()
    {
        $fields = array(
            'name'=> array('input c6'),
            'date'=> array('input c2'),
            'user'=> array('select c2',array(1=>'admin',2=>'test')),
            'display'=> array('checkbox c2'),
            'text'=> array('elrte c12'),
            'url'=> array('input c4'),
            'title'=> array('input c4'),
            'keywords'=> array('input c4'),
            'description'=> array('input c12'),
        );
        return parent::getFields($fields);
    }

    protected function beforeSave()
    {
        if(parent::beforeSave())
        {
            if($this->isNewRecord OR $this->date=='0000-00-00 00:00:00')
                $this->date=date('Y-m-d H:i:s',time());
            return true;
        }
        else
            return false;
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
		$criteria->compare('user',$this->user,true);
		$criteria->compare('display',$this->display);
		//$criteria->compare('name',$this->name,true);
		$criteria->compare('text',$this->text,true);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('url',$this->url,true);
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
	 * @return News the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
