<?php

/**
 * This is the model class for table "shop_brands".
 *
 */
class ShopProducers extends ShopProducersBase
{
    public $order = 'id.desc';

    public function getFieldsArray()
    {
        return array(
            'name'=> array('input c3'),
            'producer'=> array('input c2'),
            'country'=> array('input c2'),
            'rank'=> array('input c1'),
            'discount'=> array('input c2'),
            'display'=> array('checkbox c2'),
            'text'=> array('elrte c12',300),
            'img'=> array('img c4',$this->imgConf),
            'seo'=> array('checkbox c3'),
            'url'=> array('input c4'),
            'title'=> array('input c5'),
            'keywords'=> array('input c12'),
            'description'=> array('input c12'),
        );
    }


    public function getColumnsArray()
    {
        return array(
            'id','name','url','title','producer','country','rank','img__image','discount','display'
        );
    }

}
