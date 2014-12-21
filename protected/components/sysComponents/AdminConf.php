<?php
/** File: AdminConf.php Date: 16.12.14 Time: 16:04 */

class AdminConf {

    function getModules()
    {
        $modules_admin = array(
            'КАРТА САЙТА'	=>	'pages',
            'ТЕСТ'		    =>	'test',
            'НОВОСТИ'		=>	'news',
            'КАТАЛОГ'		=>	 array('shop',array( //shop - это название модуля, 'товары' - это вкладка подменю, 'products' - файл для вкладки подменю
                'товары'				=>	'products',
                'разделы'				=>	'categories',
                'производители'			=>	'brands',
                'параметры'				=>	'parameters',
                'экспорт в файл'		=>	'export',
                'импорт из файла'		=>	'import',
            )),
            'МАГАЗИН'		=>	array('orders',array(
                'статистика заказов'	=>	'list',
                'статусы заказов'		=>	'types',
                'доставка'				=>	'deliveries',
                //'оплата'				=>	'payments',
            )),
            'ПОЛЬЗОВАТЕЛИ'	=>	array('users',array(
                'пользователи'			=>	'list',
                'статусы пользователей'	=>	'types',
                'дополнительные поля'	=>	'fields',
            )),
            'НАСТРОЙКИ'		=>	'config',
            'СЛОВАРЬ'		=>	'languages',
            'ДИЗАЙН'		=>	array('template',array(
                'стили'					=>	'css',
                'картинки'				=>	'images',
                'шаблоны'				=>	'includes',
                'модули'				=>	'modules',
            )),
            'ЛОГИ'			=>	'logs',
            'BACKUP'		=>	'_dump',
        );
        return $modules_admin;
    }
    function getLabels()
    {
        $fieldset = array();
//изначально массив $fieldset строится на массиве модулей
        foreach (self::getModules() as $key=>$value) {
            if (is_array($value)) foreach ($value[1] as $k=>$v) $fieldset[$v] = $k;
            else $fieldset[$value] = $key;
        }
//расширение массива $fieldset
        $fieldset = array_merge ($fieldset, array(
            'about'			=> 'описание',
            'address'		=> 'адрес',
            'answer'		=> 'ответ',
            'article'		=> 'артикул',
            'brand'			=> 'производитель',
            'cache'			=> 'кешировать',
            'category'		=> 'раздел',
            'city'			=> 'город',
            'cost'			=> 'стоимость',
            'count'			=> 'кол-во',
            'date'			=> 'дата',
            'description'	=> 'description',
            'display'		=> 'показывать',
            'email'			=> 'email',
            'faq_category'	=> 'раздел',
            'faq'			=> 'вопросы',
            'free'			=> 'бесплатно с',
            'filter'		=> 'показать в фильтре',
            'forum_category'=> 'разделы',
            'forum_topic'	=> 'темы',
            'id'			=> 'ID',
            'keywords'		=> 'keywords',
            'level'			=> 'уровень',
            'login'			=> 'логин',
            'material'		=> 'материал',
            'menu'			=> 'меню',
            'model'			=> 'модель',
            'module'		=> 'модуль',
            'multiple'		=> 'множественный выбор',
            'name'			=> 'название',
            'news'			=> 'новости',
            'orders'		=> 'заказы',
            'page'			=> 'текстовые страницы',
            'parent'		=> 'родитель',
            'password'		=> 'пароль',
            'price'			=> 'цена',
            'price2'		=> '<s> цена </s>',
            'product'		=> 'товар',
            'phone'			=> 'телефон',
            'question'		=> 'вопрос',
            'rank'			=> 'рейтинг',
            'sale'			=> 'распродажа',
            'seo'			=> 'сгенерировать seo-поля',
            'special'		=> 'спец-товар',
            'text'			=> 'текст',
            'title'			=> 'title',
            'total'			=> 'итого',
            'type'			=> 'статус',
            'url'			=> 'url',
            'user'			=> 'пользователь',
            'user_type'		=> 'статус',
            'values'		=> 'занчения',
        ));
        return $fieldset;
    }
    function getBaseModules()
    {
        $array = array();
//изначально массив $fieldset строится на массиве модулей
        foreach (self::getModules() as $value) {
            if (is_array($value)) $array[] = $value[0];
            else $array[] = $value;
        }
        return $array;
    }
} 