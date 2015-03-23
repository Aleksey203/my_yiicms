<?php

/**
 * This is the model class for table "users".
 *
 */
class Users extends UsersBase
{
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

}
