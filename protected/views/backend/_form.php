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
)); ?>

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
        elseif ($params[0]=='checkbox') $array[] = array('class' => $params[0],'style'=>'height:'.$params[3].'px');
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
                                <a onclick="return hs.expand(this)" href="/files/<?=get_class($model)?>/<?=$model->id;?>/img/<?=$k.$model->img;?>" class=" "><?=AdminConf::getImgSizeName($k);?></a>
                                <span><?=$v;?></span>
                            </div>
                        <?php } ?>
                    </div>
                    <?php } ?>
                    <?php echo $form->$params[2]($array[0],$array[1],$array[2],@$array[3]);?>
                    <div class="clear"></div>
                <?php }
            else {
                echo $form->$params[2]($array[0],$array[1],$array[2],@$array[3]);

            } ?>
            <?php if ($params[0]=='elrte') {
                $height = (@$params[3]) ? $params[3] : 100;
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