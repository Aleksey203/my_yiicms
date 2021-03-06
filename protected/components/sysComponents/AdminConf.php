<?php
/** File: AdminConf.php Date: 16.12.14 Time: 16:04 */

class AdminConf extends CComponent {

    public static function getModules()
    {
        $modules_admin = array(
            'КАРТА САЙТА'	=>	'pages',
            //'ТЕСТ'		    =>	'test',
            'НОВОСТИ'		=>	'news',
            'КАТАЛОГ'		=>	 array('shop',array( //shop - это название модуля, 'товары' - это вкладка подменю, 'products' - файл для вкладки подменю
                'товары'				=>	'products',
                'производители'			=>	'brands',
                'разделы'				=>	'categories',
                'параметры'				=>	'parameters',
                'экспорт в файл'		=>	'export',
                'импорт из файла'		=>	'import',
            )),
            'МАГАЗИН'		=>	array('orders',array(
                'статистика заказов'	=>	'list',
                'статусы заказов'		=>	'types',
                'доставка'				=>	'deliveries',
                'оплата'				=>	'payments',
            )),
            'ПОЛЬЗОВАТЕЛИ'	=>	array('users',array(
                'пользователи'			=>	'list',
                'статусы пользователей'	=>	'types',
                'дополнительные поля'	=>	'fields',
            )),
            /*'НАСТРОЙКИ'		=>	'config',
            'СЛОВАРЬ'		=>	'languages',
            'ДИЗАЙН'		=>	array('template',array(
                'стили'					=>	'css',
                'картинки'				=>	'images',
                'шаблоны'				=>	'includes',
                'модули'				=>	'modules',
            )),
            'ЛОГИ'			=>	'logs',
            'BACKUP'		=>	'_dump',*/
        );
        return $modules_admin;
    }
    public static function getLabels()
    {
        $fieldset = array(
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
            'description'	=> 'Description',
            'display'		=> 'показывать',
            'email'			=> 'email',
            'faq_category'	=> 'раздел',
            'faq'			=> 'вопросы',
            'free'			=> 'бесплатно с',
            'filter'		=> 'показать в фильтре',
            'forum_category'=> 'разделы',
            'forum_topic'	=> 'темы',
            'id'			=> 'ID',
            'img'			=> 'фото',
            'in_filter'     => 'в фильтре',
            'in_product'    => 'в товаре',
            'in_list'       => 'в списке',
            'keywords'		=> 'Keywords',
            'level'			=> 'уровень',
            'login'			=> 'логин',
            'language'		=> 'язык',
            'material'		=> 'материал',
            'menu'			=> 'меню',
            'model'			=> 'модель',
            'module'		=> 'модуль',
            'multiple'		=> 'множественный выбор',
            'name'			=> 'название',
            'news'			=> 'новости',
            'orders'		=> 'заказы',
            'page'			=> 'текстовые страницы',
            'parameters'	=> 'параметры',
            'parent'		=> 'родитель',
            'password'		=> 'пароль',
            'price'			=> 'цена',
            'price2'		=> '<s> цена </s>',
            'product'		=> 'товар',
            'phone'			=> 'телефон',
            'question'		=> 'вопрос',
            'rank'			=> 'рейтинг',
            'required'		=> 'обязательное поле',
            'sale'			=> 'распродажа',
            'seo'			=> 'сгенерировать seo-поля',
            'special'		=> 'спец-товар',
            'text'			=> 'текст',
            'title'			=> 'Title',
            'total'			=> 'итого',
            'type'			=> 'статус',
            'url'			=> 'Url',
            'user'			=> 'пользователь',
            'user_type'		=> 'статус',
            'values'		=> 'значения',
        );
        return $fieldset;
    }

    public static function getConfArray($key,$value = false)
    {
        $conf['attrTypes'] = array(
            '1' => 'число',
            '2' => 'строка',
            '3' => 'текст',
            '4' => 'выпадающий список',
            '5' => 'чекбокс',
        );
        $conf['attrTypesFunc'] = array(
            '1' => 'textField',
            '2' => 'textField',
            '3' => 'textArea',
            '4' => 'dropDownList',
            '5' => 'checkBox',
        );
        $conf['attrTypesIdFunc'] = array(
            'textField'     => '1',
            'intField'      => '2',
            'textArea'      => '3',
            'dropDownList'  => '4',
            'checkBox'      => '5',
        );
        if ($value) {
            return $conf[$key][$value];
        } else {
            return $conf[$key];
        }
    }
}