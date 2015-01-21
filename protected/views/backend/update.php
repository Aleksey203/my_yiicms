<?php
/* @var $this Controller */
?>
<div class="update">
    <div class="buttons">
        <?php if(Yii::app()->user->hasFlash('success')):?>
            <div class="flash-success">
                <?php echo Yii::app()->user->getFlash('success'); ?>
            </div>
        <?php endif; ?>
        <a aria-disabled="false" role="button" class="back button ui-button ui-widget ui-state-default ui-corner-all ui-button-text-icon-primary"
           href="<?=Yii::app()->createUrl($this->uniqueId.'')?>">
            <span class="ui-button-icon-primary ui-icon ui-icon-arrowthick-1-w"></span>
            <span class="ui-button-text">Назад</span>
        </a>
        <a aria-disabled="false" role="button"
           class="save_continue button ui-button ui-widget ui-state-default ui-corner-all ui-button-text-icon-primary" href="#">
            <span class="ui-button-icon-primary ui-icon ui-icon-check"></span>
            <span class="ui-button-text"><?=($model->isNewRecord ? 'Создать' : 'Сохранить');?></span>
        </a>
        <a aria-disabled="false" role="button" class="save button ui-button ui-widget ui-state-default ui-corner-all ui-button-text-icon-primary" href="#">
            <span class="ui-button-icon-primary ui-icon ui-icon-circle-triangle-e"></span>
            <span class="ui-button-text"><?=($model->isNewRecord ? 'Создать и закрыть' : 'Сохранить и закрыть');?></span>
        </a>
    </div>
    <?php if (@$model->isNewRecord) { ?>
    <h1>Создать запись</h1>
   <?php } else {?>
<h1>Редактировать запись "<?=(@$model->name)?$model->name:$model->id;?>"</h1>
    <?php } ?>

<?php $this->renderPartial('//backend/_form', array('model'=>$model)); ?>
    <div class="buttons">
        <a aria-disabled="false" role="button" class="back button ui-button ui-widget ui-state-default ui-corner-all ui-button-text-icon-primary"
           href="<?=Yii::app()->createUrl($this->uniqueId.'')?>">
            <span class="ui-button-icon-primary ui-icon ui-icon-arrowthick-1-w"></span>
            <span class="ui-button-text">Назад</span>
        </a>
        <a aria-disabled="false" role="button"
           class="save_continue button ui-button ui-widget ui-state-default ui-corner-all ui-button-text-icon-primary" href="#">
            <span class="ui-button-icon-primary ui-icon ui-icon-check"></span>
            <span class="ui-button-text"><?=($model->isNewRecord ? 'Создать' : 'Сохранить');?></span>
        </a>
        <a aria-disabled="false" role="button" class="save button ui-button ui-widget ui-state-default ui-corner-all ui-button-text-icon-primary" href="#">
            <span class="ui-button-icon-primary ui-icon ui-icon-circle-triangle-e"></span>
            <span class="ui-button-text"><?=($model->isNewRecord ? 'Создать и закрыть' : 'Сохранить и закрыть');?></span>
        </a>
    </div>
    <div class="clear"></div>
</div>
