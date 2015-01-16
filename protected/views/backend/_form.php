<?php
/* @var $this PostController */
/* @var $model Post */
/* @var $form CActiveForm */
/*$this->registerScript("
    $('textarea.elrte').elrte(".Y::elrteOpts(array('height'=>200)).");
    //$('.form input[type=text]:first').focus();
", CClientScript::POS_END );*/
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'post-form',
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
        else $array[]['class']=$params[0];
        ?>

	<div class="row <?=$params[0].' '.$params[1]?>">
		<?php echo $form->labelEx($model,$field); ?>
        <div>
            <?php echo $form->$params[2]($array[0],$array[1],$array[2],@$array[3]); ?>
            <?php if ($params[0]=='elrte') {
                $height = (@$params[3]) ? $params[3] : 100;
                ?>
                <div class="hint"><a onclick="return setupElrteEditor('<?=get_class($model).'_'.$field?>', this, 'compant', '<?=$height?>');">WYSIWYG</a></div>
            <?php } ?>
        </div>
		<?php echo $form->error($model,$field); ?>
	</div>




    <?php } ?>
	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->