<?php
/**
 * Main Helper
 */
class H extends CComponent
{

    public static function getImgSizeName($prefix='')
    {
        $array = array('xxs-'=>'наименьшая','xs-'=>'мелкая','s-'=>'маленькая','m-'=>'средняя','l-'=>'крупная','xl-'=>'большая','xxl-'=>'наибольшая');
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

    public static function getBaseModules()
    {
        $array = array();
//изначально массив $fieldset строится на массиве модулей
        foreach (AdminConf::getModules() as $value) {
            if (is_array($value)) $array[] = $value[0];
            else $array[] = $value;
        }
        return $array;
    }

    public static function getKeysBaseModules()
    {
        $array = array();
//изначально массив $fieldset строится на массиве модулей
        foreach (AdminConf::getModules() as $value) {
            if (is_array($value)) $array["$value[0]"] = $value[0];
            else $array["$value"] = $value;
        }
        return $array;
    }

    public static function getAllModels()
    {
        $array = array();
//изначально массив $fieldset строится на массиве модулей
        foreach (self::getBaseModules() as $module) {
            $array[] = 'application.modules.'.$module.'.models.*';
            $array[] = 'application.modules.'.$module.'.models.backend.*';
            //$array[] = 'application.modules.'.$module.'.models.frontend.*';
        }
        return $array;
    }
    public static function getAllBackEndModels()
    {
        $array = array();
//изначально массив $fieldset строится на массиве модулей
        foreach (self::getBaseModules() as $module) {
            $array[] = 'application.modules.'.$module.'.models.*';
            $array[] = 'application.modules.'.$module.'.models.backend.*';
        }
        return $array;
    }
    public static function getAllFrontEndModels()
    {
        $array = array();
//изначально массив $fieldset строится на массиве модулей
        foreach (self::getBaseModules() as $module) {
            $array[] = 'application.modules.'.$module.'.models.*';
            $array[] = 'application.modules.'.$module.'.models.frontend.*';
        }
        return $array;
    }

    public static function getLabels()
    {
        $fieldset = array();
//изначально массив $fieldset строится на массиве модулей
        foreach (AdminConf::getModules() as $key=>$value) {
            if (is_array($value)) foreach ($value[1] as $k=>$v) $fieldset[$v] = $k;
            else $fieldset[$value] = $key;
        }
//расширение массива $fieldset
        $fieldset = array_merge ($fieldset, AdminConf::getLabels());
        return $fieldset;
    }

    public static function nbsp($name,$length=15)
    {
        $diff = $length-strlen($name);
        if ($diff<0) $diff = 0;
        $str = '                                                                   ';
        $str = substr($str,0,$diff);
        return $str;
    }
}


