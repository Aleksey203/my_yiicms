<?php
/** File: ActiveRecord.php Date: 01.12.14 Time: 14:44 */

class ActiveRecord extends CActiveRecord {
    public $display = 1;
    public $rank = 10;
    public $imgPath;
    public $imgRootPath;
    public $imgConf = array();

    public function getColumns($columns=array())
    {
        if(!isset($columns) OR count($columns)<2)
        $columns = array(
            'id','name','display'
        );
        $module = Yii::app()->controller->module->id;
        $controller = Yii::app()->controller->id;
        array_unshift($columns,
            array(
                'class' => 'CButtonColumn',
                'header'=>CHtml::link(' ',Yii::app()->createUrl($module.'/'.$controller.'/create'),array('class'=>'create','title'=>'Добавить новую запись')),
                'template'=>'{edit}',
                'buttons' => array(
                    'edit' => array(
                        'url' => 'Yii::app()->createUrl("'.$module.'/'.$controller.'/update?id=$data->id")',
                        'imageUrl'=>'/css/pencil.png',
                        'label'=>'Редактировать запись',
                    ),
                ),
            )
        );

        $nodelete = false;
        foreach ($columns as $k=>$column) {
            if ($column=='nodelete') {unset($columns[$k]); $nodelete = true;}
            elseif ($column=='display') {
                unset($columns[$k]);
                array_push($columns, array(
                    //'class' => 'CButtonColumn',
                    //'template'=>'{display}{nodisplay}',
                    'name' => 'display',
                    'type' => 'html',
                    'header' => '',
                    'filterHtmlOptions' => array('class' => 'filter_display'),
                    'htmlOptions'=> array('class' => 'display'),
                    'filter'=>array(1=> 'Да', 0=> 'Нет'),
                    'value'=>function ($data,$row) {
                            if ($data->display==1)
                                return '<a href="'.CHtml::normalizeUrl(array("ajax","id"=>$data->id,"name"=>"display","value"=>0)).'" title="Выключить" class="active"></a>';
                            elseif ($data->display==0)
                                return '<a href="'.CHtml::normalizeUrl(array("ajax","id"=>$data->id,"name"=>"display","value"=>1)).'" title="Включить" class="non-active"></a>';
                            else return '';
                        }

                    /*'buttons' => array(
                        'display' => array(
                            //'url' => 'Yii::app()->createUrl("/".$module."/display/$data->id")',
                            'url' => 'CHtml::normalizeUrl(array("ajax","id"=>$data->id,"name"=>"display","value"=>0))',
                            'imageUrl'=>'/css/display.png',
                            'label'=>'Показывать',
                            'options'=>array('class'=>'active'),
                            'visible'=>'$data->display==1',
                        ),
                        'nodisplay' => array(
                            'url' => 'CHtml::normalizeUrl(array("ajax","id"=>$data->id,"name"=>"display","value"=>1))',
                            'imageUrl'=>'/css/nodisplay.png',
                            'label'=>'Показывать',
                            'options'=>array('class'=>'non-active'),
                            'visible'=>'$data->display==0',
                        ),
                    ),*/
                ));
            }
            elseif (!is_array($column) AND strpos($column,'__')!==false) {
                $name = array_shift(explode('__',$column));
                $type = array_pop(explode('__',$column));
                if ($type == 'boolean') {
                    $columns[$k] =  array(
                        'name' => $name,
                        'headerHtmlOptions' => array('class'=>'ta_center'),
                        'htmlOptions' => array('class'=>'boolean'),
                        'filterHtmlOptions' => array('class' => 'filter_boolean'),
                        'type' => 'html',
                        'filter'=>array(1=> 'Да', 0=> 'Нет'),
                        'value'=>function ($data,$row,$name) {
                                $class = get_class($data);
                                $name = $name->name;
                                if ($data->$name==1)
                                    return '<a href="'.CHtml::normalizeUrl(array("ajax","id"=>$data->id,"name"=>$name,"value"=>0)).'" title="Выключить" class="active"></a>';
                                elseif ($data->$name==0)
                                    return '<a href="'.CHtml::normalizeUrl(array("ajax","id"=>$data->id,"name"=>$name,"value"=>1)).'" title="Включить" class="non-active" alt="'.$name.'"></a>';
                                else return '';
                            }
                    );
                }
                elseif ($type == 'image') {
                    $columns[$k] =  array(
                        'name' => $name,
                        'htmlOptions' => array('class'=>'img'),
                        'type' => 'raw',
                        'filter' => false,
                        'value'=>function ($data,$row,$name) {
                                $class = get_class($data);
                                $name = $name->name;
                                if (is_file(ROOT_DIR.'files/'.$class.'/'.$data->id.'/'.$name.'/a-'.$data->$name))
                                    return CHtml::link('<img src="/files/'.$class.'/'.$data->id.'/'.$name.'/a-'.$data->$name.'" title="просмотр картинки">','/files/'.$class.'/'.$data->id.'/'.$name.'/'.$data->$name, array('onclick' => 'return hs.expand(this)', 'class'=>'highslide'));
                                else return '';
                            }
                    );
                }
                elseif ($type == 'text') {
                    $columns[$k] =  array(
                        'name' => $name,
                        'type' => 'html',
                        'value' => '$data->'.$name,
                        'htmlOptions' => array('data-name'=>$column),
                    );
                }
            }         elseif (!is_array($column) AND strpos($column,'.')>0===false) {
                $columns[$k] =  array(
                    'name' => $column,
                    'type' => 'html',
                    'value' => '$data->'.$column,
                    'htmlOptions' => array('data-name'=>$column, 'class'=>($column=='id')?'id':'post'),
                );
                if ($column=='id') $columns[$k]['filter']=false;
            }
        }
        if ($nodelete === false) {
            array_push($columns,
                array(
                    'name' => $name,
                    'htmlOptions' => array('class'=>'button-column'),
                    'header' => '',
                    'type' => 'raw',
                    'filter' => false,
                    'value'=>function ($data,$row) {
                            $title = 'Удалить "';
                            $title .= (isset($data->name)) ? $data->name : 'запись '.$data->id;
                            $title .= '"';
                            return CHtml::link('<img src="/css/del.png"/>','#',array('class'=>'delete','title'=>$title));
                        }
                )/*,
                array(
                    'class' => 'CButtonColumn',
                    'template'=>'{delete}',
                    'deleteConfirmation'=>"js:'Запись с ID '+$(this).parent().parent().children(':first-child').text()+' будет удалена! Вы уверены?'",
                    'buttons' => array(
                        'delete' => array(
                            'url' => 'Yii::app()->createUrl("/delete/$data->id")',
                            'imageUrl'=>'/css/del.png',
                            'label'=>'Удалить запись',
                        ),
                    ),
                )*/
            );
        }
        return $columns;
    }

    public function getFields($fields=array())
    {
        $func = array(
            'input' => 'textField',
            'textarea' => 'textArea',
            'elrte' => 'textArea',
            'select' => 'dropDownList',
            'checkbox' => 'checkBox',
            'checkboxlist' => 'checkBoxList',
            'datetime' => 'dateTimeField',
            'date' => 'dateField',
            'img' => 'fileField',
        );
        if(!isset($fields) OR count($fields)<2)
            $fields = array(
                'name'=> array('input c1'),
                'display'=> array('checkbox c3'),
            );
        foreach ($fields as $k => $v) {
            $array = explode(' ',$v[0]);
            $array[2] = $func[$array[0]];
            unset($fields[$k][0]);
            array_unshift($fields[$k],$array[2]);
            array_unshift($fields[$k],$array[1]);
            array_unshift($fields[$k],$array[0]);
        }
        return $fields;
    }
    public function scopes()
    {
        $alias = $this->getTableAlias();
        return array(
            'active'              => array('condition'=>$alias.'.display=1'),
            'orderByName'         => array('order'=>$alias.'.name ASC' ),
            'orderByEmail'         => array('order'=>$alias.'.email ASC' ),
        );
    }


    protected function beforeValidate()
    {
        if(parent::beforeValidate())
        {

            if(isset($_POST['seo'])) {
                $this->url = self::trunslit($this->name);
                if (isset($this->title)) $this->title = $this->name;
                if (isset($this->description)) $this->description = self::description(@$this->text.' '.$this->name);
                if (isset($this->keywords)) $this->keywords = self::keywords($this->name.' '.@$this->description.' '.@$this->text);
            }
            if(isset($this->date)) {
                if($this->isNewRecord OR $this->date=='0000-00-00 00:00:00')
                    $this->date=date('Y-m-d H:i:s',time());
            }
            return true;
        }
        else
            return false;
    }

    protected function beforeSave(){
        if(!parent::beforeSave())
            return false;
        if(($this->scenario=='insert' || $this->scenario=='update') &&
            ($img=CUploadedFile::getInstance($this,'img'))){
                $this->img=self::trunslit($img->name);
        }
        return true;
    }

    protected function afterSave(){
        if(($this->scenario=='insert'  || $this->scenario=='update') &&
            ($img=CUploadedFile::getInstance($this,'img'))){
            $this->img=self::trunslit($img->name);
            $this->imgPath='files/'.get_class($this).'/'.$this->id.'/img/';
            $this->imgRootPath=Yii::getPathOfAlias('webroot').DIRECTORY_SEPARATOR.$this->imgPath;
            if (!is_dir($this->imgRootPath)) self::make_dir($this->imgPath);
                else $this->deleteImg(false); // старую картинку удалим, потому что загружаем новую
            $img->saveAs($this->imgRootPath.'/'.$this->img);
            $img = Yii::app()->image->load($this->imgPath.'/'.$this->img);
            foreach ($this->imgConf as $prefix => $v) {
                $array = explode(' ',$v);
                $type = $array[0];
                $array2 = explode('x',$array[1]);
                $width = $array2[0];
                $height = $array2[1];
                $img->$type($width, $height);
                $img->save($this->imgPath.'/'.$prefix.$this->img);
            }

            $img->resize(85, 85);
            $img->save($this->imgPath.'/a-'.$this->img); // or $image->save('images/small.jpg');
        }
        parent::afterSave();
    }

    protected function beforeDelete(){
        if(!parent::beforeDelete())
            return false;
        if (isset($this->img)) {
            $this->imgPath='files/'.get_class($this).'/'.$this->id;
            $this->imgRootPath=Yii::getPathOfAlias('webroot').DIRECTORY_SEPARATOR.$this->imgPath;
            $this->deleteImg(true); // удалили модель? удаляем и файл
        }
        return true;
    }

    public function deleteImg($i){
        self::delete_all($this->imgRootPath,$i);
    }

    public function trunslit($str){
        $str = self::strtolower_utf8(trim(strip_tags($str)));
        $str = str_replace(
            array('ä','ö','ü','а','б','в','г','д','е','ё','ж','з','и','й','к','л','м','н','о','п','р','с','т','у','ф','х','ц','ч','ш','щ','ь','ы','ъ','э','ю','я','і','ї','є'),
            array('a','o','u','a','b','v','g','d','e','e','zh','z','i','i','k','l','m','n','o','p','r','s','t','u','f','h','ts','ch','sch','shch','','y','','e','yu','ya','i','yi','e'),
            $str);
        $str = preg_replace('~[^-a-z0-9_.]+~u', '-', $str);	//удаление лишних символов
        $str = preg_replace('~[-]+~u','-',$str);			//удаление лишних -
        $str = trim($str,'-');								//обрезка по краям -
        $str = trim($str,'_');								//обрезка по краям -
        $str = trim($str,'.');
        return $str;
    }

    //зaмена функции strtolower
    public function strtolower_utf8($str){
        $large = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','À','Á','Â','Ã','Ä','Å','Æ','Ç','È','É','Ê','Ë','Ì','Í','Î','Ï','Ð','Ñ','Ò','Ó','Ô','Õ','Ö','Ø','Ù','Ú','Û','Ü','Ý','А','Б','В','Г','Д','Е','Ё','Ж','З','И','Й','К','Л','М','Н','О','П','Р','С','Т','У','Ф','Х','Ц','Ч','Ш','Щ','Ъ','Ы','Ь','Э','Ю','Я','Є');
        $small = array('a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z','à','á','â','ã','ä','å','æ','ç','è','é','ê','ë','ì','í','î','ï','ð','ñ','ò','ó','ô','õ','ö','ø','ù','ú','û','ü','ý','а','б','в','г','д','е','ё','ж','з','и','й','к','л','м','н','о','п','р','с','т','у','ф','х','ц','ч','ш','щ','ъ','ы','ь','э','ю','я','є');
        return str_replace($large,$small,$str);
    }


    function keywords($str) { //04.02.10 поиск ключевых слов в тексте
        $keywords = '';
        if (strlen($str)>0) {
            $str = preg_replace("/&[\w]+;/", ' ',$str);	//замена символов типа &nbsp; на пробел
            $str = self::strtolower_utf8(trim(strip_tags($str)));
            $str = preg_replace('~[^-їієа-яa-z0-9 ]+~u', ' ', $str);
            $token = strtok($str, ' ');
            $array = array();
            while ($token) {
                $token = trim($token);
                if (strlen($token)>=4) @$array[$token]++;
                $token = strtok(' ');
            }
            if (count($array)>0) {
                arsort ($array);
                foreach ($array as $key=>$value) {
                    if (strlen($keywords.', '.$key)>255) break;
                    $keywords.= ', '.$key;
                }
                return substr($keywords, 2);
            }
        }
    }
//генерирует описание из текста
    function description($str) {
        $description = '';
        $str = preg_replace("/&[\w]+;/", ' ',$str);	//замена символов типа &nbsp; на пробел
        $str = trim(strip_tags($str));
        $token = strtok($str, ' ');
        while ($token) {
            $token = trim($token);
            if ($token!='') {
                if (strlen($description.' '.$token)>255) break;
                $description.= trim($token).' ';
            }
            $token = strtok(' ');
        }
        return trim($description);
    }

    //29.03.10 создание дерева папок
    function make_dir ($path) { //$path путь product/2
        $path = trim($path,'/'); //обрезаем крайние слеши
        $path = trim($path,'.'); //обрезаем крайние точки
        $array = explode('/',$path);
        $dir = ROOT_DIR.'';
        if (!is_dir ($dir)) if (!mkdir($dir,0777)) return false;
        foreach ($array as $k=>$v) {
            $dir.= $v.'/';
            if (!is_dir ($dir)) if (!mkdir($dir,0777)) return false;
        }
        return true;
    }

    public function delete_all($dir,$i = true) {
        if (is_file($dir)) return unlink($dir);
        if (!is_dir($dir)) return false;
        $dh = opendir($dir);
        while (false!==($file = readdir($dh))) {
            if ($file=='.' || $file=='..') continue;
            self::delete_all($dir.'/'.$file);
        }
        closedir($dh);
        if ($i==true) return rmdir($dir);
    }
} 