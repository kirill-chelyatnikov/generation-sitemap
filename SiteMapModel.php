<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\db\Query;


class SiteMapModel extends Model
{

    public function create_files( $table, $start_url, $changefreq ='monthly', $priority = '0.5', $is_goods = false, $condition = [],  $end_url = '.htm'){

        $begin = '<?xml version="1.0" encoding="UTF-8"?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'.PHP_EOL;
        $end = '</urlset>';
        $offset = 0; $i = 1;

        $model = new SiteMapModel();

        if ($is_goods) $count_files = $model->actual_goods_arr(true);
        else $count_files = $model->count_files(['adjusted_name'],$table,$condition);

        while ($count_files > 0){
            $xml_items = "";
            if ($is_goods) $goods = $model->actual_goods_arr();
            else $goods = (new Query())
                ->select(['adjusted_name'])
                ->from($table)
                ->where($condition)
                ->limit(50000)
                ->offset($offset)
                ->all();

            foreach ($goods as $item){
                $url = $start_url.$item['adjusted_name'].$end_url;
                $xml_items .= '<url>
                                 <loc>'.$url.'</loc>
                                 <changefreq>'.$changefreq.'</changefreq>
                                 <priority>'.$priority.'</priority>
                                </url>'.PHP_EOL;
            }

            $path_to_frontend = \Yii::getAlias('@frontend');
            $file_name = 'sitemap_'.$table.'_'.$i.'.xml';
            $dir = $path_to_frontend.'/sitemap';
            if(!is_dir($dir)) {
                mkdir($dir, 0777, true);
            }

            $fp = fopen($path_to_frontend.'/sitemap/'.$file_name, "w");
            $sting_xml = $model->pretty_xml($begin.$xml_items.$end);
            fwrite($fp,$sting_xml);
            fclose($fp);

            $offset += 50000;
            $count_files--; $i++;
        }
    }

    public function count_files($fields_arr, $table, $condition = []){
        $count = (new Query())
            ->select($fields_arr)
            ->from($table)
            ->where($condition)
            ->count();

        return ceil($count/50000);
    }

    public function create_main_map(){
        $model = new SiteMapModel();

        $begin = '<?xml version="1.0" encoding="UTF-8" standalone="no"?><sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/siteindex.xsd">'.PHP_EOL;
        $end = '</sitemapindex>';
        $xml_items = "";

        $path_to_frontend = \Yii::getAlias('@frontend');
        $dir    = $path_to_frontend.'/sitemap';
        $files = array_diff( scandir( $dir), array('.', '..', 'sitemap.xml'));

        foreach ($files as $key => $item){
            $url = 'https://otkorobki.ru/'.$item;
            $xml_items .= '<sitemap>
                            <loc>'.$url.'</loc>
                           </sitemap>'.PHP_EOL;
        }

        $fp = fopen($path_to_frontend.'/sitemap/sitemap.xml', "w");
        $sting_xml = $model->pretty_xml($begin.$xml_items.$end);
        fwrite($fp,$sting_xml);
        fclose($fp);
    }

    public function pretty_xml($str) {
        $str = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $str);
        //$str = str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $str);
        $str = str_replace(array("\r\n", "\r", "\t", '  ', '    ', '    '), '', $str);
        return $str;
    }

    public function  actual_goods_arr($count=false){

        $connection = Yii::$app->getDb();
        $field = "adjusted_name";
        if ($count) $field = "COUNT(id)";

        $command = $connection->createCommand("SELECT $field
                                               FROM ok_goods
                                               LEFT JOIN ok_xsr_search_results_4275 as t1 on t1.goods_id = ok_goods.id
                                               LEFT JOIN ok_xsr_search_results_4285 as t2 on t2.goods_id = ok_goods.id
                                               LEFT JOIN ok_xsr_search_results_4361 as t3 on t3.goods_id = ok_goods.id
                                               LEFT JOIN ok_xsr_search_results_4389 as t4 on t4.goods_id = ok_goods.id
                                               LEFT JOIN ok_xsr_search_results_4565 as t5 on t5.goods_id = ok_goods.id
                                               LEFT JOIN ok_xsr_search_results_4584 as t6 on t6.goods_id = ok_goods.id
                                               LEFT JOIN ok_xsr_search_results_4676 as t7 on t7.goods_id = ok_goods.id
                                               LEFT JOIN ok_xsr_search_results_4765 as t8 on t8.goods_id = ok_goods.id
                                               LEFT JOIN ok_xsr_search_results_4862 as t9 on t9.goods_id = ok_goods.id
                                               LEFT JOIN ok_xsr_search_results_4935 as t10 on t10.goods_id = ok_goods.id
                                               LEFT JOIN ok_xsr_search_results_5000 as t11 on t11.goods_id = ok_goods.id
                                               LEFT JOIN ok_xsr_search_results_5068 as t12 on t12.goods_id = ok_goods.id
                                               LEFT JOIN ok_xsr_search_results_5105 as t13 on t13.goods_id = ok_goods.id
                                               LEFT JOIN ok_xsr_search_results_5176 as t14 on t14.goods_id = ok_goods.id
                                               LEFT JOIN ok_xsr_search_results_5206 as t15 on t15.goods_id = ok_goods.id
                                               LEFT JOIN ok_xsr_search_results_5240 as t16 on t16.goods_id = ok_goods.id
                                               LEFT JOIN ok_xsr_search_results_5258 as t17 on t17.goods_id = ok_goods.id
                                               LEFT JOIN ok_xsr_search_results_5291 as t18 on t18.goods_id = ok_goods.id
                                               LEFT JOIN ok_xsr_search_results_5335 as t19 on t19.goods_id = ok_goods.id
                                               LEFT JOIN ok_xsr_search_results_5375 as t20 on t20.goods_id = ok_goods.id
                                               LEFT JOIN ok_xsr_search_results_5428 as t21 on t21.goods_id = ok_goods.id
                                               LEFT JOIN ok_xsr_search_results_5469 as t22 on t22.goods_id = ok_goods.id
                                               LEFT JOIN ok_xsr_search_results_5518 as t23 on t23.goods_id = ok_goods.id
                                               LEFT JOIN ok_xsr_search_results_5557 as t24 on t24.goods_id = ok_goods.id
                                               LEFT JOIN ok_xsr_search_results_5652 as t25 on t25.goods_id = ok_goods.id
                                               LEFT JOIN ok_xsr_search_results_5716 as t26 on t26.goods_id = ok_goods.id
                                               LEFT JOIN ok_xsr_search_results_5813 as t27 on t27.goods_id = ok_goods.id
                                               LEFT JOIN ok_xsr_search_results_5884 as t28 on t28.goods_id = ok_goods.id
                                               LEFT JOIN ok_xsr_search_results_5972 as t29 on t29.goods_id = ok_goods.id
                                               LEFT JOIN ok_xsr_search_results_6158 as t30 on t30.goods_id = ok_goods.id
                                               LEFT JOIN ok_xsr_search_results_6265 as t31 on t31.goods_id = ok_goods.id
                                               LEFT JOIN ok_xsr_search_results_6310 as t32 on t32.goods_id = ok_goods.id
                                               LEFT JOIN ok_xsr_search_results_6349 as t33 on t33.goods_id = ok_goods.id
                                               LEFT JOIN ok_xsr_search_results_6397 as t34 on t34.goods_id = ok_goods.id
                                               LEFT JOIN ok_xsr_search_results_6429 as t35 on t35.goods_id = ok_goods.id
                                               LEFT JOIN ok_xsr_search_results_6468 as t36 on t36.goods_id = ok_goods.id
                                               LEFT JOIN ok_xsr_search_results_6528 as t37 on t37.goods_id = ok_goods.id
                                               LEFT JOIN ok_xsr_search_results_6568 as t38 on t38.goods_id = ok_goods.id
                                               LEFT JOIN ok_xsr_search_results_6635 as t39 on t39.goods_id = ok_goods.id
                                               LEFT JOIN ok_xsr_search_results_6673 as t40 on t40.goods_id = ok_goods.id
                                               LEFT JOIN ok_xsr_search_results_6712 as t41 on t41.goods_id = ok_goods.id
                                               LEFT JOIN ok_xsr_search_results_6804 as t42 on t42.goods_id = ok_goods.id
                                               LEFT JOIN ok_xsr_search_results_6882 as t43 on t43.goods_id = ok_goods.id
                                               LEFT JOIN ok_xsr_search_results_6923 as t44 on t44.goods_id = ok_goods.id
                                               LEFT JOIN ok_xsr_search_results_6955 as t45 on t45.goods_id = ok_goods.id
                                               LEFT JOIN ok_xsr_search_results_7015 as t46 on t46.goods_id = ok_goods.id
                                               LEFT JOIN ok_xsr_search_results_7038 as t47 on t47.goods_id = ok_goods.id
                                               LEFT JOIN ok_xsr_search_results_7081 as t48 on t48.goods_id = ok_goods.id
                                               LEFT JOIN ok_xsr_search_results_7109 as t49 on t49.goods_id = ok_goods.id
                                               LEFT JOIN ok_xsr_search_results_7137 as t50 on t50.goods_id = ok_goods.id
                                               LEFT JOIN ok_xsr_search_results_7238 as t51 on t51.goods_id = ok_goods.id
                                               LEFT JOIN ok_xsr_search_results_7267 as t52 on t52.goods_id = ok_goods.id
                                               LEFT JOIN ok_xsr_search_results_7291 as t53 on t53.goods_id = ok_goods.id
                                               LEFT JOIN ok_xsr_search_results_7311 as t54 on t54.goods_id = ok_goods.id
                                               
                                               WHERE t1.goods_id IS NOT NULL 
                                               OR t2.goods_id IS NOT NULL 
                                               OR t3.goods_id IS NOT NULL 
                                               OR t4.goods_id IS NOT NULL 
                                               OR t5.goods_id IS NOT NULL 
                                               OR t6.goods_id IS NOT NULL 
                                               OR t7.goods_id IS NOT NULL 
                                               OR t8.goods_id IS NOT NULL 
                                               OR t9.goods_id IS NOT NULL 
                                               OR t10.goods_id IS NOT NULL
                                               OR t11.goods_id IS NOT NULL 
                                               OR t12.goods_id IS NOT NULL
                                               OR t13.goods_id IS NOT NULL
                                               OR t14.goods_id IS NOT NULL
                                               OR t15.goods_id IS NOT NULL
                                               OR t16.goods_id IS NOT NULL
                                               OR t17.goods_id IS NOT NULL
                                               OR t18.goods_id IS NOT NULL
                                               OR t19.goods_id IS NOT NULL
                                               OR t20.goods_id IS NOT NULL
                                               OR t21.goods_id IS NOT NULL
                                               OR t22.goods_id IS NOT NULL
                                               OR t23.goods_id IS NOT NULL
                                               OR t24.goods_id IS NOT NULL
                                               OR t25.goods_id IS NOT NULL
                                               OR t26.goods_id IS NOT NULL
                                               OR t27.goods_id IS NOT NULL
                                               OR t28.goods_id IS NOT NULL
                                               OR t29.goods_id IS NOT NULL
                                               OR t30.goods_id IS NOT NULL
                                               OR t31.goods_id IS NOT NULL
                                               OR t32.goods_id IS NOT NULL
                                               OR t33.goods_id IS NOT NULL
                                               OR t34.goods_id IS NOT NULL
                                               OR t35.goods_id IS NOT NULL
                                               OR t36.goods_id IS NOT NULL
                                               OR t37.goods_id IS NOT NULL
                                               OR t38.goods_id IS NOT NULL
                                               OR t39.goods_id IS NOT NULL
                                               OR t40.goods_id IS NOT NULL
                                               OR t41.goods_id IS NOT NULL
                                               OR t42.goods_id IS NOT NULL
                                               OR t43.goods_id IS NOT NULL
                                               OR t44.goods_id IS NOT NULL
                                               OR t45.goods_id IS NOT NULL
                                               OR t46.goods_id IS NOT NULL
                                               OR t47.goods_id IS NOT NULL
                                               OR t48.goods_id IS NOT NULL
                                               OR t49.goods_id IS NOT NULL
                                               OR t50.goods_id IS NOT NULL
                                               OR t51.goods_id IS NOT NULL
                                               OR t52.goods_id IS NOT NULL
                                               OR t53.goods_id IS NOT NULL
                                               OR t54.goods_id IS NOT NULL
                                               ");
        $result = $command->queryAll();

        if($count){
            return ceil(intval($result)/50000);
        }else return $result;

    }
}