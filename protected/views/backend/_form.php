<?php
/* @var $this PostController */
/* @var $model Post */
/* @var $form CActiveForm */
?>

<div class="form" data-url="<?=Yii::app()->controller->uniqueId;?>" data-id="<?=$model->id;?>">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'post-form',
    'htmlOptions'=>array('enctype'=>'multipart/form-data'),
	//'action'=>array(Yii::app()->controller->id.'/update'),
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
));
$redirect = ($this->action->id=='update') ? 'false' : 'update';
?>

	<?php echo CHtml::hiddenField('redirect',$redirect)?>
	<?php echo $form->errorSummary($model); ?>
    <?php $fields = $model->getFields();
    foreach ($fields as $field => $params) {
        $array=array($model,$field);
        if ($params[0]=='select') {
            $selected = array($model->$field => array('selected' => 'selected'));
            $array[]=$params[3];
            $array[] = array('class' => $params[0],'prompt'=>' - - - ','options'=>$selected);
        }
        elseif ($params[0]=='elrte') $array[] = array('class' => $params[0],'style'=>'height:'.$params[3].'px');
        elseif ($params[0]=='checkbox') $array[] = array('class' => $params[0]);
        elseif ($params[0]=='checkboxlist') {
            $related = $model->getActiveRelation($field)->className;
            $array[] = CHtml::listData($related::model()->findAll(),'id', 'name');
            $array[1] .= 'Array';
        }
        elseif ($params[0]=='many') {
            $fk = $model->getActiveRelation($field)->foreignKey;
            $related = $model->getActiveRelation($field)->className;
            $array[] = CHtml::listData($related::model()->findAllByAttributes(array($fk=>$model->id)),'parameter', 'value');
            $many = $model->$field.'Many';
        }
        else $array[]['class']=$params[0];
        if ($field=='seo') echo '<div class="row c12 toggle">'.CHtml::link('<span>SEO-оптимизация</span>','#', array('id' => 'seo')).'</div>';
        $class = ($field=='url' OR $field=='title' OR $field=='keywords' OR $field=='description' OR $field=='seo')?'seo':'';
        if ($params[0]=='img' OR $params[0]=='file' OR $params[0]=='images') $class .= ' files';
        if ($params[0]=='img' OR $params[0]=='file') $class .= ' file';
        ?>


	<div class="row <?=$params[0].' '.$params[1]?> <?=$class?>">
		<?php if ($field!='seo' AND $field!='img') echo $form->labelEx($model,$field);
              elseif ($field=='seo') echo CHtml::label('cгенерировать seo-поля','seo');?>
        <div <?=($params[0]=='img')?'class="data"':''?>>
            <?php if ($field=='seo') echo CHtml::checkBox('seo',$model->isNewRecord);
                elseif ($params[0]=='img') {
                    $img = ($model->img) ? '/files/'.get_class($model).'/'.$model->id.'/img/a-'.$model->img : '/css/no_img.png';
                    $img_class = ($model->img) ? '' : 'no_img';
                    ?>
                    <div title="<?=$model->img;?>" data-img="/files/<?=get_class($model)?>/<?=$model->id;?>" class="img <?=$img_class?>">
                        <img src="<?=$img?>"><span>&nbsp;</span>
                    </div>
                    <div class="name">Основная картинка</div>
                    <?php if ($model->img) { ?>
                    <div class="desc">
                        <a href="#" title="Удалить &quot;<?=$model->img;?>&quot;" class="delete"><img src="/css/del.png"></a>
                        <div>
                            <a onclick="return hs.expand(this)" href="/files/<?=get_class($model)?>/<?=$model->id;?>/img/<?=$model->img;?>" class=" ">исходная</a>
                        </div>
                        <?php foreach ($model->imgConf as $k=>$v) { ?>
                            <div>
                                <a onclick="return hs.expand(this)" href="/files/<?=get_class($model)?>/<?=$model->id;?>/img/<?=$k.$model->img;?>" class=" "><?=H::getImgSizeName($k);?></a>
                                <span><?=$v;?></span>
                            </div>
                        <?php } ?>
                    </div>
                    <?php } ?>
                    <?php echo $form->$params[2]($array[0],$array[1],$array[2],isset($array[3])?$array[3]:array());?>
                    <div class="clear"></div>
           <?php }
            elseif ($params[0]=='many') {
                //echo '123';
                $parameters = $array[0]->parametersMany['parameters'];
                $values = $array[0]->parametersMany['values'];
                //echo $form->textField($fmodel,'value');
                foreach ($parameters as $parameter) {
                    if ($parameter->type==4) {
                        $options = explode("\r\n",trim($parameter->values));
                        ?>
                        <div class="row select c2 ">
                            <label class="required" for="ShopProducts[parametersMany][<?=$parameter->id?>]"><?=$parameter->name;?></label>
                            <div>
                                <select id="ShopProducts_brand" name="ShopProducts[parametersMany][<?=$parameter->id?>]" class="select">
                                    <?php foreach ($options as $v) {
                                        $selected = ($v==@$values[$parameter->id]) ? 'selected="selected"' : '';                                        ?>
                                    <option <?=$selected;?> value="<?=htmlspecialchars($v);?>"><?=$v;?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    <?php } else { ?>


                    <div class="row input c ">
                        <label for="ShopProducts[parametersMany][<?=$parameter->id?>]"><?=$parameter->name;?></label>
                        <div>
                            <input type="text" value="<?=@$values[$parameter->id]?>" maxlength="255" id="ShopProducts_Many_<?=$parameter->id?>" name="ShopProducts[parametersMany][<?=$parameter->id?>]">
                        </div>
                    </div>
                    <?php } ?>
            <?php } }
            else {
                echo $form->$params[2]($array[0],$array[1],$array[2],isset($array[3])?$array[3]:array());

            } ?>
            <?php if ($params[0]=='elrte') {
                $height = (isset($params[3]) AND $params[3]) ? $params[3] : 100;
                ?>
                <div class="hint"><a onclick="return setupElrteEditor('<?=get_class($model).'_'.$field?>', this, 'compant', '<?=$height?>');">WYSIWYG</a></div>
            <?php } ?>
        </div>
		<?php echo $form->error($model,$field); ?>
	</div>




    <?php } ?>
	<!--<div class="row buttons">
		<?php /*//echo CHtml::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить', array('class' => 'button save')); */?>
	</div>-->

<?php $this->endWidget(); ?>

</div><!-- form -->