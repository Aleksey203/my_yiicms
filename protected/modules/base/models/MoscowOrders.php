<?php

/**
 * This is the model class for table "moscow_orders".
 *
 * The followings are the available columns in table 'moscow_orders':
 * @property string $id
 * @property string $date
 * @property string $updated
 * @property integer $type
 * @property integer $mail_sent
 * @property string $name
 * @property string $phone
 * @property string $email
 * @property integer $delivery_type
 * @property string $delivery_cost
 * @property string $total
 * @property string $discount
 * @property string $total_discount
 * @property string $basket
 */
class MoscowOrders extends ActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'moscow_orders';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('date, updated, type, name, phone, email, delivery_type, delivery_cost, discount, total_discount', 'required'),
			array('type, mail_sent, delivery_type', 'numerical', 'integerOnly'=>true),
			array('name, email', 'length', 'max'=>255),
			array('phone', 'length', 'max'=>127),
			array('delivery_cost, total, discount, total_discount', 'length', 'max'=>10),
			array('basket', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, date, updated, type, mail_sent, name, phone, email, delivery_type, delivery_cost, total, discount, total_discount, basket', 'safe', 'on'=>'search'),
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
			'date' => 'Date',
			'updated' => 'последнее изменение',
			'type' => 'Type',
			'mail_sent' => 'отправлено письмо с благодарностью',
			'name' => 'имя заказчика',
			'phone' => 'телефон',
			'email' => 'Email',
			'delivery_type' => 'тип доставки',
			'delivery_cost' => 'стоимость доставки',
			'total' => 'итого без скидки',
			'discount' => 'размер общей скидки',
			'total_discount' => 'итого с учётом скидки',
			'basket' => 'Basket',
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

		$criteria->compare('id',$this->id,true);
		$criteria->compare('date',$this->date,true);
		$criteria->compare('updated',$this->updated,true);
		$criteria->compare('type',$this->type);
		$criteria->compare('mail_sent',$this->mail_sent);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('phone',$this->phone,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('delivery_type',$this->delivery_type);
		$criteria->compare('delivery_cost',$this->delivery_cost,true);
		$criteria->compare('total',$this->total,true);
		$criteria->compare('discount',$this->discount,true);
		$criteria->compare('total_discount',$this->total_discount,true);
		$criteria->compare('basket',$this->basket,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return MoscowOrders the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
