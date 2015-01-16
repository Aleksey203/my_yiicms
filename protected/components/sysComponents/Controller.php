<?php
/** File: Controller.php Date: 16.01.15 Time: 14:31 */

class Controller extends CController
{

    static private $script_cnt = 0;

    public function init()
    {
        parent::init();
    }

    public function registerScript( $script, $position = CClientScript::POS_READY){
        $id = __CLASS__.$this->id.self::$script_cnt++;
        Yii::app()->clientScript->registerScript($id, $script, $position);
    }
}