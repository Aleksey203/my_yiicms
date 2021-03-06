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
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('module, name, url', 'required'),
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


    public function getColumnsArray()
    {
        return array(
            'id','name','module__text','url','title','menu__boolean','display',
        );
    }

    public function getFieldsArray()
    {
        return array(
            'name'=> array('input c6'),
            'module'=> array('select c2',H::getKeysBaseModules()),
            'menu'=> array('checkbox'),
            'display'=> array('checkbox'),
            'text'=> array('elrte c12'),
            'seo'=> array('checkbox c2'),
            'url'=> array('input c4'),
            'title'=> array('input c6'),
            'keywords'=> array('input c12'),
            'description'=> array('input c12'),
        );
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'pages';
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
