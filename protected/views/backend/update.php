<?php
/* @var $this Controller */
?>
<div class="update">
<h1>Редактировать запись "<?=(@$model->name)?$model->name:$model->id;?>"</h1>

<?php $this->renderPartial('//backend/_form', array('model'=>$model)); ?>
</div>