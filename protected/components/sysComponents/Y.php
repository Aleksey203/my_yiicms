<?php
/**
 * Main Helper
 */
class Y extends CComponent
{
    static function app(){  return Yii::app();  }
    static function contr(){  return Yii::app()->controller;  }
    static function cs(){  return Yii::app()->clientScript;  }
    static function user_id(){  return Yii::app()->user->id;  }

    static function path($alias){
        return Yii::getPathOfAlias($alias);
    }
    static function publish($assets_path, $forceCopy=false){
        return Yii::app()->assetManager->publish($assets_path, false, -1, $forceCopy);
    }
    static function cookie($name){
        return Yii::app()->request->cookies[$name]->value;
    }
    static function inArrayCookie($name, $elem, $delim = '~'){
        return in_array($elem,explode($delim,self::cookie($name) ) );
    }
    static function params($name){
        return Y::app()->params[$name];
    }

    static function imgUrl($model, $field, $tmb = 0)
    {
        if(!$model->$field) return Controller::noImg;
        if(strpos($model->$field,"http")===0 ) return $model->$field;

        $field_data = $model->files_config[$field];
        $tmb_p = $field_data['tmbs'][$tmb-1]['name'].'/';
        $path = $field_data['url'] ? $field_data['url'] : $field_data['path'];
        return $path.($tmb > 0 ? $tmb_p : '').$model->$field;
    }
    static function fileUrl($model, $field){
        if(!$model->$field) return null;
        $field_data = $model->files_config[$field];
        return $field_data['path'].$model->$field;
    }

    public static function getIdByAttr($model,$str){
        return CHtml::getIdByName(CHtml::resolveName($model,$str));
    }

    static function translitIt($source, $clean = true){
        $replaceList = array(
            "А"=>"A","Б"=>"B","В"=>"V","Г"=>"G", "Д"=>"D","Е"=>"E","Ж"=>"J","З"=>"Z","И"=>"I", "Й"=>"Y","К"=>"K","Л"=>"L","М"=>"M","Н"=>"N",
            "О"=>"O","П"=>"P","Р"=>"R","С"=>"S","Т"=>"T", "У"=>"U","Ф"=>"F","Х"=>"H","Ц"=>"TS","Ч"=>"CH", "Ш"=>"SH","Щ"=>"SCH","Ъ"=>"","Ы"=>"YI","Ь"=>"",
            "Э"=>"E","Ю"=>"YU","Я"=>"YA","а"=>"a","б"=>"b", "в"=>"v","г"=>"g","д"=>"d","е"=>"e","ж"=>"j", "з"=>"z","и"=>"i","й"=>"y","к"=>"k","л"=>"l",
            "м"=>"m","н"=>"n","о"=>"o","п"=>"p","р"=>"r", "с"=>"s","т"=>"t","у"=>"u","ф"=>"f","х"=>"h", "ц"=>"ts","ч"=>"ch","ш"=>"sh","щ"=>"sch","ъ"=>"",
            "ы"=>"yi","ь"=>"","э"=>"e","ю"=>"yu","я"=>"ya", " "=>"-", 'ё'=>'jo', 'Ё'=>'JO',  );
        $cleanList = array( '`&([a-z]+)(acute|grave|circ|cedil|tilde|uml|lig|ring|caron|slash);`i' => '\1','`&(amp;)?[^;]+;`i' => '-','`[^a-z0-9]`i' => '-','`[-]+`' => '-',);
        $source = str_replace(array_keys($replaceList), array_values($replaceList), $source);
        $source = htmlentities($source, ENT_COMPAT, 'UTF-8');
        if($clean) $source = preg_replace(array_keys($cleanList), array_values($cleanList), $source);
        $source = strtolower(trim($source, '-'));
        return $source;
    }

    public static function lang(){
        return Y::cookie('site_lang') ? Y::cookie('site_lang') : 'ru';
    }
    public static function langSfx(){
        if(self::lang() == 'en') return '_l2';
        if(self::lang() == 'de') return '_l3';
        return '';
    }
    public static function t($str){ return Yii::t('common',$str); }

    public static function sqlExecute($sql){
        $command = Y::app()->db->createCommand($sql);
        $rezult = $command->execute();
        $command->reset();
        return $rezult;
    }
    public static function sqlQueryAll($sql){
        $command=Y::app()->db->createCommand($sql);
        return $command->queryAll();
    }
    public static function sqlInsert( $table_name,  $values){
        $sql = 'insert into '.$table_name.' set ';
        foreach($values as $_field_name => $_field_value)
            $sql .= $_field_name . '='.Y::app()->db->quoteValue($_field_value). ' , ';
        $sql = substr($sql, 0, -2);
        self::sqlExecute($sql);
    }

    public static function months($num){
        $arr = array('01' => 'января', '02' => 'февраля', '03' => 'марта',
            '04' => 'апреля', '05' => 'мая', '06' => 'июня', '07' => 'июля', '08' => 'августа',
            '09' => 'сентября', '10' => 'октября', '11' => 'ноября', '12' => 'декабря');
        $arr_en = array('01' => 'January', '02' => 'February', '03' => 'March',
            '04' => 'April', '05' => 'May', '06' => 'June', '07' => 'July', '08' => 'August',
            '09' => 'September', '10' => 'October', '11' => 'November', '12' => 'December');
        return self::lang() == 'en' ? $arr_en[$num] : $arr[$num];
    }

    public static function toW1251($str){
        return iconv("utf-8","windows-1251", $str);
    }
    public static function toUtf8($str){
        return iconv("windows-1251","utf-8", $str);
    }

    public static function date_print($val, $format, $absolute = 0, $gmt_corr = false)
    {
        if ($val)
        {
            $val = $val + ($gmt_corr ? self::userGMT() : 0);
            $start_of_tomorrow = mktime(0, 0, 0, date('m'), date('d') + 1);
            $start_of_today = mktime(0, 0, 0);
            $last_h = time() - $val;

            if ($last_h < 3600 && $last_h >= 0 && $absolute > 0){
                if($last_h < 60) return $last_h . ' ' . self::t('секунд назад');
                return round($last_h / 60) . ' ' . self::t('минут назад');
            }

            if ($val > $start_of_today && $val < $start_of_tomorrow && $absolute > 0)
                return self::t('Сегодня') . ', ' . date('H:i', $val);

            return date($format, $val);
        }
    }
    public static function userGMT(){
        if(!self::cookie('time_zone_offset')){
            echo "<script>var now = new Date();
                    $.cookie('time_zone_offset', now.getTimezoneOffset(), {'path':'/', expires: 1});</script>";
        }
        return self::cookie('time_zone_offset')/60*3600;
    }
    public static function isToday($time){
        $start_of_tomorrow = mktime(0, 0, 0, date('m'), date('d') + 1);
        $start_of_today = mktime(0, 0, 0);
        return $time >= $start_of_today && $time < $start_of_tomorrow;
    }
    public static function isYesterday($time){
        $start_of_yesterday = mktime(0, 0, 0, date('m'), date('d') - 1);
        $start_of_today = mktime(0, 0, 0);
        return $time >= $start_of_yesterday && $time < $start_of_today;
    }

    public static function elrteOpts($opts){
        $barDef = "['save', 'copypaste', 'undoredo', 'style', 'alignment', 'colors', 'indent',
                   'lists', 'format', 'links', 'elements', 'media']";
        return "{ height: ".$opts['height'].", cssClass: 'el-rte', lang: 'ru',
                toolbars: {tb:".$barDef."}, denyTags:[],
                toolbar: 'tb', allowSource: 1}";
    }

    public static function browser(){
        $agent = $_SERVER['HTTP_USER_AGENT'];
        if(strpos($agent,'Firefox')>-1) return 'firefox';
        if(strpos($agent,'Chrome')>-1) return 'chrome';
        if(strpos($agent,'Opera')>-1) return 'opera';
        if(strpos($agent,'Safari')>-1) return 'safari';
        if(strpos($agent,'Trident')>-1) return 'msie';
        return 'unknown_browser';
    }

    public static function getImgSizeName($prefix='')
    {
        $array = array('xs-'=>'наименьшая','s-'=>'маленькая','m-'=>'средняя','l-'=>'крупная','xl-'=>'большая','xxl-'=>'наибольшая');
        if ($prefix=='') return $array;
        elseif (array_key_exists($prefix,$array)) return $array[$prefix];
        else return false;
    }


    public static function trunslit($str){
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
    public static function strtolower_utf8($str){
        $large = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','À','Á','Â','Ã','Ä','Å','Æ','Ç','È','É','Ê','Ë','Ì','Í','Î','Ï','Ð','Ñ','Ò','Ó','Ô','Õ','Ö','Ø','Ù','Ú','Û','Ü','Ý','А','Б','В','Г','Д','Е','Ё','Ж','З','И','Й','К','Л','М','Н','О','П','Р','С','Т','У','Ф','Х','Ц','Ч','Ш','Щ','Ъ','Ы','Ь','Э','Ю','Я','Є');
        $small = array('a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z','à','á','â','ã','ä','å','æ','ç','è','é','ê','ë','ì','í','î','ï','ð','ñ','ò','ó','ô','õ','ö','ø','ù','ú','û','ü','ý','а','б','в','г','д','е','ё','ж','з','и','й','к','л','м','н','о','п','р','с','т','у','ф','х','ц','ч','ш','щ','ъ','ы','ь','э','ю','я','є');
        return str_replace($large,$small,$str);
    }


    public static function keywords($str) { //04.02.10 поиск ключевых слов в тексте
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
    public static function description($str) {
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
    public static function make_dir ($path) { //$path путь product/2
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

    public static function delete_all($dir,$i = true) {
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


