<?php
// Register jquery and jquery ui.
$adminAssetsUrl = Yii::app()->getModule('pages')->assetsUrl;

$assetsManager = Yii::app()->clientScript;
$assetsManager->registerCoreScript('jquery');
$assetsManager->registerCoreScript('jquery.ui');

// Back Button & Query Library
$assetsManager->registerScriptFile($adminAssetsUrl.'/vendors/jquery.ba-bbq.min.js');

// Disable jquery-ui default theme
$assetsManager->scriptMap=array(
    'jquery-ui.css'=>false,
);

$assetsManager->registerCssFile($adminAssetsUrl.'/css/yui-grids/reset-fonts-grids.css');
$assetsManager->registerCssFile($adminAssetsUrl.'/css/base.css');
$assetsManager->registerCssFile($adminAssetsUrl.'/css/forms.css');
$assetsManager->registerCssFile($adminAssetsUrl.'/css/breadcrumbs/style.css');
$assetsManager->registerCssFile($adminAssetsUrl.'/vendors/jquery_ui/css/custom-theme/jquery-ui-1.8.14.custom.css');
$assetsManager->registerCssFile($adminAssetsUrl.'/css/theme.css');

/*// jGrowl
Yii::import('ext.jgrowl.Jgrowl');
Jgrowl::register();*/



// Init script
$assetsManager->registerScriptFile($adminAssetsUrl.'/scripts/init.scripts.js');
$assetsManager->registerScriptFile($adminAssetsUrl.'/scripts/jquery-datepicker-russian.js');
$assetsManager->registerScriptFile($adminAssetsUrl.'/scripts/jquery.hotkeys.js');
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Моя удобная и быстрая админка</title>

    <style type="text/css">
        /*** Fix for tabs. ***/
        .ui-tabs {
            border:0;
        }
        .xdebug-var-dump {
            background-color:silver;
        }
    </style>
</head>
<body style="text-align:left;">

<!--
	yui-t1,3: sidebar left

	// For fixed width
	<div style="width: 80%;" class="yui-t5">
-->
<div id="doc3" class="yui-t6">
    <div id="hd">
        <div class="yui-gc">
            <div class="yui-u first" id="adminMenu">
                <?php
                $this->widget('application.components.sysWidgets.AdminMenu',array('module'=>$this->module->id));
/*                 $this->widget('zii.widgets.CMenu',array(
                    'items'=>array(
                        array('label'=>'Home', 'url'=>array('/site/index')),
                        array('label'=>'About', 'url'=>array('/site/page', 'view'=>'about')),
                        array('label'=>'Contact', 'url'=>array('/site/contact')),
                        array('label'=>'Login', 'url'=>array('/site/login'), 'visible'=>Yii::app()->user->isGuest),
                        array('label'=>'Logout ('.Yii::app()->user->name.')', 'url'=>array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest)
                    ),
                ));*/
                ?>
            </div>
            <div class="yui-u" id="topRightMenu">
                <form action="/admin/store/products/" method="get" id="topSearchForm">
                    <input type="text" name="StoreProduct[name]" id="topSearchBox">
                </form>

                <?php /*echo CHtml::link(Yii::t('AdminModule.admin', 'Выход ({name})', array('{name}'=>Yii::app()->user->model->username)), array('/admin/auth/logout'), array(
                    'confirm'=>Yii::t('StoreModule.admin','Завершить сеанс?')
                )) */?>
            </div>
        </div>
    </div> <!-- /hd -->

    <div class="yui-gc" id="navigation">
        <div class="yui-u first" style="width:1px;">
            <div class="navigation-content-left">
                <div id="breadcrumbs" class="breadCrumb module">

                    <div>
                        <?php
                        /*$this->widget('application.modules.admin.widgets.SAdminBreadcrumbs', array(
                            'homeLink'=>$this->createUrl('admin'),
                            'links'=>$this->breadcrumbs,
                        ));*/
                         if(isset($this->breadcrumbs)):
                             $this->widget('zii.widgets.CBreadcrumbs', array(
                                'links'=>$this->breadcrumbs,
                            ));
                         endif;
                        ?>
                    </div>
                </div>

            </div>
        </div>
        <div class="yui-u" style="width:50%;">
            <div class="navigation-content-right marright" align="right" style="float:right;">
                <div style="float:right;">
                    <?php
                    /*if (!empty($this->topButtons))
                        echo $this->topButtons;*/
                    ?>
                </div>
            </div>
        </div>
    </div>

    <div id="bd" class="marleft">
        <div id="yui-main">
            <?php if (isset($this->pageHeader) && !empty($this->pageHeader)) echo '<h3>'.CHtml::encode($this->pageHeader).'</h3>'; ?>

                <div class="marright">

                    <!-- Main content -->
                    <div id="content" class="yui-g">
                        <!-- <hr /> -->
                        <?php
                        echo $content;
                        ?>
                    </div>
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
