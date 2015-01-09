<?php
// Register jquery and jquery ui.
$adminAssetsUrl = Yii::app()->getModule('pages')->assetsUrl;

$assetsManager = Yii::app()->clientScript;
$assetsManager->registerCoreScript('jquery');
$assetsManager->registerCoreScript('jquery.ui');

// Disable jquery-ui default theme
$assetsManager->scriptMap=array(
    'jquery-ui.css'=>false,
);

$assetsManager->registerCssFile($adminAssetsUrl.'/css/yui-grids/reset-fonts-grids.css');
$assetsManager->registerCssFile($adminAssetsUrl.'/css/admin.css');

$assetsManager->registerScriptFile($adminAssetsUrl.'/scripts/admin.js');
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Моя удобная и быстрая админка</title>
</head>
<body>
<div id="body">
    <div id="hd">
        <div id="adminMenu">
            <?php $this->widget('application.components.sysWidgets.AdminMenu',array('module'=>$this->module->id,'submodule'=>$this->id)); ?>
        </div>
    </div> <!-- /hd -->

    <!--<div id="navigation"></div>-->

    <div id="bd" >
        <div id="yui-main">
            <?php if (isset($this->pageHeader) && !empty($this->pageHeader)) echo '<h3>'.CHtml::encode($this->pageHeader).'</h3>'; ?>
                <!-- Main content -->
                <div id="content" class="yui-g">
                    <!-- <hr /> -->
                    <?php
                    echo $content;
                    ?>
                </div>
            </div>
        </div>

        <!-- footer -->
        <div id="ft" style="height:50px;">
            &nbsp;
            <div class="small-footer-text" style=" display: none;">
            </div>
        </div>

    </div>
</body>
</html>
