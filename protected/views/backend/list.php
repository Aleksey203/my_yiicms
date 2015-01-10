<?php
/* @var $this ListController */
?>
<h1 style="float: left;"><?php echo $this->uniqueId . '/' . $this->action->id; ?></h1>

<p>
This is the view content for action "<?php echo $this->action->id; ?>".
The action belongs to the controller "<?php echo get_class($this); ?>"
in the "<?php echo $this->module->id; ?>" module.
</p>

<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider'=>$model->search(),
    'columns'=>$columns,
    'rowHtmlOptionsExpression'=>'array("data-id" => "$data->id")',
    'htmlOptions'=>array("data-model" => get_class($model),"data-url" => $this->uniqueId),
));
?>