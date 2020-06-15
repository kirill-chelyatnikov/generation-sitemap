<?php

namespace frontend\controllers;

use yii\console\Controller;
use frontend\models\SiteMapModel;

class SiteMapController extends Controller
{
    public function actionCreateXmlMaps(){

        ini_set('memory_limit', '1024M');

        $model = new SiteMapModel();

        //Обазятельные параметры: наименование таблицы, начало URL
        //Необязательные параметры: changefreq, priority, is_it_goods?, условие для запроса (массив), конец URL
        $model->create_files('ok_goods', 'https://otkorobki.ru/g/', 'monthly', '0.5', true);
        $model->create_files('ok_category', 'https://otkorobki.ru/cat/', 'weekly');
        $model->create_files('ok_brand', 'https://otkorobki.ru/brand/', 'weekly');
        $model->create_files('ok_store', 'https://otkorobki.ru/s/', 'weekly');
        $model->create_files('ok_manufacturer', 'https://otkorobki.ru/m/', 'weekly');
        $model->create_files('ok_article', 'https://otkorobki.ru/article/', 'daily');

        //Создание основной карты
        $model->create_main_map();

    }
}

