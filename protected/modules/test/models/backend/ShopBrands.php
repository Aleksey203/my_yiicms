<?php

/**
 * This is the model class for table "shop_brands".
 *
 */
class ShopBrands extends ShopBrandsBase
{
	public function getColumns()
	{
		$columns = array(
        	'id','name','url','title','producer','country','rank','img__image','discount__boolean','display'		);
		return parent::getColumns($columns);
	}


	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		/*$criteria=new CDbCriteria;

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
		$criteria->compare('discount',$this->discount);*/

		return new CActiveDataProvider($this, array(
			//'criteria'=>$criteria,
			'pagination'=>array('pageSize'=>25),
		));
	}

}
