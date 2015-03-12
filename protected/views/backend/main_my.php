<?php
Yii::log("Начало рендеринга шаблона main");
// Register jquery and jquery ui.
$adminAssetsUrl = Yii::app()->getModule('pages')->assetsUrl;

$assetsManager = Yii::app()->clientScript;
$assetsManager->registerCoreScript('jquery');
$assetsManager->registerCoreScript('jquery.ui');

// Disable jquery-ui default theme
/*$assetsManager->scriptMap=array(
    'jquery-ui.css'=>false,
);*/

$assetsManager->registerCssFile($adminAssetsUrl.'/css/yui-grids/reset-fonts-grids.css');
$assetsManager->registerCssFile($adminAssetsUrl.'/extensions/highslide/highslide.css');
$assetsManager->registerCssFile($adminAssetsUrl.'/extensions/elRTE/css/elrte.min.css');
$assetsManager->registerCssFile($adminAssetsUrl.'/extensions/elFinder-2/css/elfinder.min.css');
$assetsManager->registerCssFile($adminAssetsUrl.'/extensions/elFinder-2/css/theme.css');
$assetsManager->registerCssFile($adminAssetsUrl.'/vendors/jquery_ui/css/custom-theme/jquery-ui-1.8.14.custom.css');
$assetsManager->registerCssFile($adminAssetsUrl.'/css/admin.css');

$assetsManager->registerScriptFile($adminAssetsUrl.'/extensions/highslide/highslide-full.js');
$assetsManager->registerScriptFile($adminAssetsUrl.'/extensions/elRTE/js/elrte.min.js');
$assetsManager->registerScriptFile($adminAssetsUrl.'/extensions/elRTE/js/elrte.ru.js');
$assetsManager->registerScriptFile($adminAssetsUrl.'/extensions/elFinder-2/js/elfinder.min.js');
$assetsManager->registerScriptFile($adminAssetsUrl.'/extensions/elFinder-2/js/elfinder.ru.js');
$assetsManager->registerScriptFile($adminAssetsUrl.'/extensions/elFinder-2/js/elfinder.ru.js');
$assetsManager->registerScriptFile($adminAssetsUrl.'/scripts/elfinder.js');
$assetsManager->registerScriptFile($adminAssetsUrl.'/scripts/highslide_conf.js');
$assetsManager->registerScriptFile($adminAssetsUrl.'/scripts/admin.js');
Yii::log("Окончание загрузки assetsManager шаблона main");
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
                <div class="yui-g">
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
<?php Yii::log("Окончание рендеринга шаблона main");
?>