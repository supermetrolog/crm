<?php
/**
 * Created by PhpStorm.
 * User: Zhitkov
 * Date: 12.10.2020
 * Time: 16:42
 */

$filters['id'] =  'ID миксованного предложения';
$filters['page_num'] = 'номер старницы';


$filters['search'] =  'строка поиска';

$filters['region'] =  'регион';
$filters['directions'] =  'направления';
$filters['towns'] =  'города';
$filters['metros'] = 'метро' ;


$filters['deal_type'] = 'тип сделки';
$filters['purposes'] =  'назначения';
$filters['object_type'] = 'тип объекта';
//$filters['safe_type'] = [1,2];
$filters['safe_type'] = 'тип хранения';
$filters['self_leveling'] = 'антипыль';


$filters['racks'] = 'стеллажи';
$filters['cranes'] = 'краны';
$filters['railway'] = 'ж/д';
$filters['steam'] = 'пар';
$filters['gas'] = 'газ';
$filters['water'] = 'вода';
$filters['sewage'] = 'канализация';
$filters['ground_floor'] = 'только первый';


$filters['area_min'] = 'площадь от';
$filters['area_max'] = 'площадь до';


$filters['price_min'] = 'минимальная цена';
$filters['price_max'] = 'максимальная цена';
$filters['price_format'] = 'формат цены';

$filters['ceiling_height_min'] = 'высота потолков от';
$filters['ceiling_height_max'] = 'высота потолков до';
$filters['pallet_place_max'] = 'палето места от';
$filters['pallet_place_min'] = 'палето-места до';
$filters['from_mkad_min'] = 'от мкад от';
$filters['from_mkad_max'] = 'от мкад до';

$filters['power'] =  'электричество';

foreach ($filters as $key=>$value) {
    echo "$key - $value <br>";
}