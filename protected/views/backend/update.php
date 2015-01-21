<?php
/* @var $this Controller */
?>
<div class="update">
    <div class="buttons">
        <?=CHtml::link('Назад',Yii::app()->createUrl($this->uniqueId.''),array('class'=>'back button'));?>
        <?=CHtml::link($model->isNewRecord ? 'Создать' : 'Сохранить','#',array('class'=>'save_continue button'));?>
        <?=CHtml::link($model->isNewRecord ? 'Создать и закрыть' : 'Сохранить и закрыть','#',array('class'=>'save button'));?>
    </div>
    <?php if (@$model->isNewRecord) { ?>
    <h1>Создать запись</h1>
   <?php } else {?>
<h1>Редактировать запись "<?=(@$model->name)?$model->name:$model->id;?>"</h1>
    <?php } ?>
<?php $this->renderPartial('//backend/_form', array('model'=>$model)); ?>
    <div class="buttons">
        <?=CHtml::link('Назад',Yii::app()->createUrl($this->uniqueId.''),array('class'=>'back button'));?>
        <?=CHtml::link($model->isNewRecord ? 'Создать' : 'Сохранить','#',array('class'=>'save_continue button'));?>
        <?=CHtml::link($model->isNewRecord ? 'Создать и закрыть' : 'Сохранить и закрыть','#',array('class'=>'save button'));?>
    </div>
    <div class="clear"></div>
</div>