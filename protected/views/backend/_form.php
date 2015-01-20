<?php
/* @var $this PostController */
/* @var $model Post */
/* @var $form CActiveForm */
?>

<div class="form">
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
        ?>

	<div class="row <?=$params[0].' '.$params[1]?> <?=($field=='url' OR $field=='title' OR $field=='keywords' OR $field=='description' OR $field=='seo')?'seo':''?>">
		<?php if ($field!='seo') echo $form->labelEx($model,$field);
              else echo CHtml::label('cгенерировать seo-поля','seo');?>
        <div>
            <?php if($params[0]=='img' AND $model->img) { ?>
                <p><?php echo CHtml::encode($model->img); ?></p>
            <?php } ?>
            <?php if ($field!='seo') echo $form->$params[2]($array[0],$array[1],$array[2],@$array[3]);
            else {
                echo CHtml::checkBox('seo',$model->isNewRecord);
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