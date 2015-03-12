<?php
/* @var $this ListController */
?>
<!--<h1 style="float: left;"><?php /*echo $this->uniqueId . '/' . $this->action->id; */?></h1>

<p>
This is the view content for action "<?php /*echo $this->action->id; */?>".
The action belongs to the controller "<?php /*echo get_class($this); */?>"
in the "<?php /*echo $this->module->id; */?>" module.
</p>-->

<?php
$dataProvider = $model->search();
Yii::trace("Начало рендеринга шаблона list",'system.base.CModule');
$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider'=>$dataProvider,
    'ajaxUpdate'    => false,
    'selectableRows'    => 0,
    'columns'=>$columns,
    'filter' => $model,
    'template' => '{pager}'.CHtml::link('Добавить новую запись',Yii::app()->createUrl($this->uniqueId.'/create'),array('class'=>'create button')).'{items}{pager}{summary}',
    'rowHtmlOptionsExpression'=>'array("data-id" => "$data->id")',
    'htmlOptions'=>array("data-model" => get_class($model),"data-url" => $this->uniqueId),
));
Yii::trace("Окончание рендеринга шаблона  list",'system.base.CModule');
?>