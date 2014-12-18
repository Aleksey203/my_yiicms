<?php
/** File: AdminMenu.php Date: 16.12.14 Time: 13:49 */



class AdminMenu extends CWidget {

    private $_items;

    /**
     * Render menu
     */
    public function run()
    {
        $modules = AdminConf::getModules();
        $parents = self::generateItems($modules);
        $childs = self::generateItems($modules,'orders');

        $this->widget('zii.widgets.CMenu', array('items'=>$parents));
        $this->widget('zii.widgets.CMenu', array('items'=>$childs));
    }

    protected function generateItems($modules,$child = false)
    {
        $items = array();
        if ($child) {
            foreach ($modules as $k => $v) {
                if (is_array($v) AND $v[0]==$child)
                    foreach ($v[1] as $label => $url) {
                        $items[] = array('label'=>$label, 'url'=>array('/'.$child.'/'.$url));
                    }


            }
        }
        else foreach ($modules as $k => $v) {
            if (!is_array($v)) $items[] = array('label'=>$k, 'url'=>array('/'.$v.'/index'));
            else {
                $items[] = array('label'=>$k, 'url'=>array('/'.$v[0].'/'.array_shift($v[1])));
            }
        }
        return $items;
    }
} 