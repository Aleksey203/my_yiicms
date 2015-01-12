<?php
/** File: ActiveRecord.php Date: 01.12.14 Time: 14:44 */



class ActiveRecord extends CActiveRecord {
    public function getColumns($columns)
    {
        if(!isset($columns) OR count($columns)<2)
        $columns = array(
            'id','name','display'
        );

        array_unshift($columns,
            array(
                'class' => 'CButtonColumn',
                'template'=>'{edit}',
                'buttons' => array(
                    'edit' => array(
                        'url' => 'Yii::app()->createUrl("/edit/$data->id")',
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
            }
            elseif (!is_array($column) AND strpos($column,'.')>0===false) {
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
                )
            );
        }
        return $columns;
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
} 