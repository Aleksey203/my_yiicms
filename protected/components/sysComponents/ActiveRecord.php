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
                    'class' => 'CButtonColumn',
                    'template'=>'{display}{nodisplay}',
                    'buttons' => array(
                        'display' => array(
                            'url' => 'Yii::app()->createUrl("/display/$data->id")',
                            'imageUrl'=>'/css/display.png',
                            'label'=>'Показывать',
                            'visible'=>'$data->display==1',
                        ),
                        'nodisplay' => array(
                            'url' => 'Yii::app()->createUrl("/nodisplay/$data->id")',
                            'imageUrl'=>'/css/nodisplay.png',
                            'label'=>'Показывать',
                            'visible'=>'$data->display==0',
                        ),
                    ),
                ));
            }
            elseif (!is_array($column) AND strpos($column,'__')!==false) {
                $name = array_shift(explode('__',$column));
                $type = array_pop(explode('__',$column));
                if ($type == 'boolean') {
                    $columns[$k] =  array(
                        'class' => 'CButtonColumn',
                        'template'=>'{true}{false}',
                        'header' => 'Меню',
                        'buttons' => array(
                            'true' => array(
                                'url' => 'Yii::app()->createUrl("/display/$data->id")',
                                'imageUrl'=>'/css/yes.png',
                                'label'=>'Сменить',
                                'visible'=>'$data->'.$name.'==1',
                            ),
                            'false' => array(
                                'url' => 'Yii::app()->createUrl("/nodisplay/$data->id")',
                                'imageUrl'=>'/css/minus.png',
                                'label'=>'Сменить',
                                'visible'=>'$data->'.$name.'==0',
                            ),
                        ),
                    );
                }
                elseif ($type == 'image') {
                    $columns[$k] =  array(
                        'name' => $name,
                        'htmlOptions' => array('class'=>'img'),
                        'type' => 'html',
                        //'value' => '<a href="/files/shop_products/$data->id/img/$data->img" onclick="return hs.expand(this)" class=" "><img src="/files/shop_products/$data->id/img/a-$data->img" class="img" title="просмотр картинки"></a>',
                        'value'=>function ($data,$row,$name) {
                                $class = get_class($data);
                                $name = $name->name;
                                if (is_file(ROOT_DIR.'files/'.$class.'/'.$data->id.'/'.$name.'/a-'.$data->$name))
                                    return '<a href="/files/'.$class.'/'.$data->id.'/'.$name.'/'.$data->$name.'" onclick="return hs.expand(this)" class=" "><img src="/files/'.$class.'/'.$data->id.'/'.$name.'/a-'.$data->$name.'" title="просмотр картинки"></a>';
                                else return '';
                            }
                    );
                }
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
} 