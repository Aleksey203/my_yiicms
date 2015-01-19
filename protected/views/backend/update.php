<?php
/* @var $this Controller */
?>
<div class="update">
    <?php if (@$model->isNewRecord) { ?>
    <h1>Создать запись</h1>
   <?php } else {?>
<h1>Редактировать запись "<?=(@$model->name)?$model->name:$model->id;?>"</h1>
    <?php } ?>
<?php $this->renderPartial('//backend/_form', array('model'=>$model)); ?>
</div>