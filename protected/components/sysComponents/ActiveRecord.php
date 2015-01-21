<?php
/** File: ActiveRecord.php Date: 01.12.14 Time: 14:44 */

class ActiveRecord extends CActiveRecord {
    public $display = 1;
    public $rank = 10;
    public $imgPath;
    public $imgRootPath;
    public $imgConf = array();

    public function getColumns($columns=array())
    {
        if(!isset($columns) OR count($columns)<2)
        $columns = array(
            'id','name','display'
        );
        $module = Yii::app()->controller->module->id;
        $controller = Yii::app()->controller->id;
        array_unshift($columns,
            array(
                'class' => 'CButtonColumn',
                'header'=>CHtml::link(' ',Yii::app()->createUrl($module.'/'.$controller.'/create'),array('class'=>'create','title'=>'Добавить новую запись')),
                'template'=>'{edit}',
                'buttons' => array(
                    'edit' => array(
                        'url' => 'Yii::app()->createUrl("'.$module.'/'.$controller.'/update?id=$data->id")',
                        'imageUrl'=>'/css/pencil.png',
                        'label'=>'Редактировать запись',
                    ),
                ),
            )
        );

        $nodelete = false;
        foreach ($columns as $k=>$column) {
            if ($column=='nodelete') {unset($columns[$k]); $nodelete = true;}
            elseif ($column=='display') {
                unset($columns[$k]);
                array_push($columns, array(
                    //'class' => 'CButtonColumn',
                    //'template'=>'{display}{nodisplay}',
                    'name' => 'display',
                    'type' => 'html',
                    'header' => '',
                    'filterHtmlOptions' => array('class' => 'filter_display'),
                    'htmlOptions'=> array('class' => 'display'),
                    'filter'=>array(1=> 'Да', 0=> 'Нет'),
                    'value'=>function ($data,$row) {
                            if ($data->display==1)
                                return '<a href="'.CHtml::normalizeUrl(array("ajax","id"=>$data->id,"name"=>"display","value"=>0)).'" title="Выключить" class="active"></a>';
                            elseif ($data->display==0)
                                return '<a href="'.CHtml::normalizeUrl(array("ajax","id"=>$data->id,"name"=>"display","value"=>1)).'" title="Включить" class="non-active"></a>';
                            else return '';
                        }

                    /*'buttons' => array(
                        'display' => array(
                            //'url' => 'Yii::app()->createUrl("/".$module."/display/$data->id")',
                            'url' => 'CHtml::normalizeUrl(array("ajax","id"=>$data->id,"name"=>"display","value"=>0))',
                            'imageUrl'=>'/css/display.png',
                            'label'=>'Показывать',
                            'options'=>array('class'=>'active'),
                            'visible'=>'$data->display==1',
                        ),
                        'nodisplay' => array(
                            'url' => 'CHtml::normalizeUrl(array("ajax","id"=>$data->id,"name"=>"display","value"=>1))',
                            'imageUrl'=>'/css/nodisplay.png',
                            'label'=>'Показывать',
                            'options'=>array('class'=>'non-active'),
                            'visible'=>'$data->display==0',
                        ),
                    ),*/
                ));
            }
            elseif (!is_array($column) AND strpos($column,'__')!==false) {
                $name = array_shift(explode('__',$column));
                $type = array_pop(explode('__',$column));
                if ($type == 'boolean') {
                    $columns[$k] =  array(
                        'name' => $name,
                        'headerHtmlOptions' => array('class'=>'ta_center'),
                        'htmlOptions' => array('class'=>'boolean'),
                        'filterHtmlOptions' => array('class' => 'filter_boolean'),
                        'type' => 'html',
                        'filter'=>array(1=> 'Да', 0=> 'Нет'),
                        'value'=>function ($data,$row,$name) {
                                $class = get_class($data);
                                $name = $name->name;
                                if ($data->$name==1)
                                    return '<a href="'.CHtml::normalizeUrl(array("ajax","id"=>$data->id,"name"=>$name,"value"=>0)).'" title="Выключить" class="active"></a>';
                                elseif ($data->$name==0)
                                    return '<a href="'.CHtml::normalizeUrl(array("ajax","id"=>$data->id,"name"=>$name,"value"=>1)).'" title="Включить" class="non-active" alt="'.$name.'"></a>';
                                else return '';
                            }
                    );
                }
                elseif ($type == 'image') {
                    $columns[$k] =  array(
                        'name' => $name,
                        'htmlOptions' => array('class'=>'img'),
                        'type' => 'raw',
                        'filter' => false,
                        'value'=>function ($data,$row,$name) {
                                $class = get_class($data);
                                $name = $name->name;
                                if (is_file(ROOT_DIR.'files/'.$class.'/'.$data->id.'/'.$name.'/a-'.$data->$name))
                                    return CHtml::link('<img src="/files/'.$class.'/'.$data->id.'/'.$name.'/a-'.$data->$name.'" title="просмотр картинки">','/files/'.$class.'/'.$data->id.'/'.$name.'/'.$data->$name, array('onclick' => 'return hs.expand(this)', 'class'=>'highslide'));
                                else return '';
                            }
                    );
                }
                elseif ($type == 'text') {
                    $columns[$k] =  array(
                        'name' => $name,
                        'type' => 'html',
                        'value' => '$data->'.$name,
                        'htmlOptions' => array('data-name'=>$column),
                    );
                }
            }         elseif (!is_array($column) AND strpos($column,'.')>0===false) {
                $columns[$k] =  array(
                    'name' => $column,
                    'type' => 'html',
                    'value' => '$data->'.$column,
                    'htmlOptions' => array('data-name'=>$column, 'class'=>($column=='id')?'id':'post'),
                );
                if ($column=='id') $columns[$k]['filter']=false;
            }
        }
        if ($nodelete === false) {
            array_push($columns,
                array(
                    'name' => $name,
                    'htmlOptions' => array('class'=>'button-column'),
                    'header' => '',
                    'type' => 'raw',
                    'filter' => false,
                    'value'=>function ($data,$row) {
                            $title = 'Удалить "';
                            $title .= (isset($data->name)) ? $data->name : 'запись '.$data->id;
                            $title .= '"';
                            return CHtml::link('<img src="/css/del.png"/>','#',array('class'=>'delete','title'=>$title));
                        }
                )/*,
                array(
                    'class' => 'CButtonColumn',
                    'template'=>'{delete}',
                    'deleteConfirmation'=>"js:'Запись с ID '+$(this).parent().parent().children(':first-child').text()+' будет удалена! Вы уверены?'",
                    'buttons' => array(
                        'delete' => array(
                            'url' => 'Yii::app()->createUrl("/delete/$data->id")',
                            'imageUrl'=>'/css/del.png',
                            'label'=>'Удалить запись',
                        ),
                    ),
                )*/
            );
        }
        return $columns;
    }

    public function getFields($fields=array())
    {
        $func = array(
            'input' => 'textField',
            'textarea' => 'textArea',
            'elrte' => 'textArea',
            'select' => 'dropDownList',
            'checkbox' => 'checkBox',
            'checkboxlist' => 'checkBoxList',
            'datetime' => 'dateTimeField',
            'date' => 'dateField',
            'img' => 'fileField',
        );
        if(!isset($fields) OR count($fields)<2)
            $fields = array(
                'name'=> array('input c1'),
                'display'=> array('checkbox c3'),
            );
        foreach ($fields as $k => $v) {
            $array = explode(' ',$v[0]);
            $array[2] = $func[$array[0]];
            unset($fields[$k][0]);
            array_unshift($fields[$k],$array[2]);
            array_unshift($fields[$k],$array[1]);
            array_unshift($fields[$k],$array[0]);
        }
        return $fields;
    }
    public function scopes()
    {
        $alias = $this->getTableAlias();
        return array(
            'active'              => array('condition'=>$alias.'.display=1'),
            'orderByName'         => array('order'=>$alias.'.name ASC' ),
            'orderByEmail'         => array('order'=>$alias.'.email ASC' ),
        );
    }


    protected function beforeValidate()
    {
        if(parent::beforeValidate())
        {

            if(isset($_POST['seo'])) {
                $this->url = H::trunslit($this->name);
                if (isset($this->title)) $this->title = $this->name;
                if (isset($this->description)) $this->description = H::description(@$this->text.' '.$this->name);
                if (isset($this->keywords)) $this->keywords = H::keywords($this->name.' '.@$this->description.' '.@$this->text);
            }
            if(isset($this->date)) {
                if($this->isNewRecord OR $this->date=='0000-00-00 00:00:00')
                    $this->date=date('Y-m-d H:i:s',time());
            }
            return true;
        }
        else
            return false;
    }

    protected function beforeSave(){
        if(!parent::beforeSave())
            return false;
        if(($this->scenario=='insert' || $this->scenario=='update') &&
            ($img=CUploadedFile::getInstance($this,'img'))){
                $this->img=H::trunslit($img->name);
        }
        return true;
    }

    protected function afterSave(){
        if(($this->scenario=='insert'  || $this->scenario=='update') &&
            ($img=CUploadedFile::getInstance($this,'img'))){
            $this->img=H::trunslit($img->name);
            $this->imgPath='files/'.get_class($this).'/'.$this->id.'/img/';
            $this->imgRootPath=Yii::getPathOfAlias('webroot').DIRECTORY_SEPARATOR.$this->imgPath;
            if (!is_dir($this->imgRootPath)) H::make_dir($this->imgPath);
                else $this->deleteImg(false); // старую картинку удалим, потому что загружаем новую
            $img->saveAs($this->imgRootPath.'/'.$this->img);
            $img = Yii::app()->image->load($this->imgPath.'/'.$this->img);
            foreach ($this->imgConf as $prefix => $v) {
                $array = explode(' ',$v);
                $type = $array[0];
                $array2 = explode('x',$array[1]);
                $width = $array2[0];
                $height = $array2[1];
                $img->$type($width, $height);
                $img->save($this->imgPath.'/'.$prefix.$this->img);
            }

            $img->resize(85, 85);
            $img->save($this->imgPath.'/a-'.$this->img); // or $image->save('images/small.jpg');
        }
        parent::afterSave();
    }

    protected function beforeDelete(){
        if(!parent::beforeDelete())
            return false;
        if (isset($this->img)) {
            $this->imgPath='files/'.get_class($this).'/'.$this->id;
            $this->imgRootPath=Yii::getPathOfAlias('webroot').DIRECTORY_SEPARATOR.$this->imgPath;
            $this->deleteImg(true); // удалили модель? удаляем и файл
        }
        return true;
    }

    public function deleteImg($i){
        H::delete_all($this->imgRootPath,$i);
    }
}