<? include_once($_SERVER['DOCUMENT_ROOT'].'/global_pass.php');?>
<?php
ini_set('display_errors', 1); ini_set('display_startup_errors', 1); ini_set('error_reporting', E_ALL);
//$filter_name = $_POST['name'];
//$filter_name = $_GET['name'];

/*
$filters_arr = [
    'deal_types'=>'l_deal_types',
    'object_classes'=>'l_classes',
    'statuses'=>'l_statuses_all',
    'purposes'=>'l_purposes',
    'floor_types'=>'l_floor_types',
    'gate_types'=>'l_gates_types',
    'heated'=>'l_blocks_heating',
    'regions'=>'l_regions',
    'directions'=>'l_directions',
    'districts'=>'l_districts',
    'districts_moscow'=>'l_districts_moscow',
    'highways'=>'l_highways',
    'highways_moscow'=>'l_highways_moscow',
    'metros'=>'l_metros',
    'towns'=>'l_towns',
    'towns_central'=>'l_towns_central',
];
*/

$filters_list = [
    'l_deal_types'=>'Типы сделки',
    'l_classes'=>'Класс обьекта',
    'l_statuses_all'=>'Статусы',
    'l_object_types'=>'Тип объекта',
    'l_purposes'=>'Назначения',
    'l_floor_types'=>'Типы пола',
    'l_gates_types'=>'Типы ворот',
    'l_blocks_heating'=>'l_blocks_heating',
    'l_regions'=>'Регионы',
    'l_directions'=>'Направления',
    'l_districts'=>'Районы',
    'l_districts_moscow'=>'Районы Москвы',
    'l_highways'=>'Шоссе',
    'l_highways_moscow'=>'Шоссе Москвы',
    'l_metros'=>'Метро',
    'l_towns'=>'Города',
    'l_towns_central'=>'Города Центральные',
    'l_price_formats'=>'Формат цены',
    'l_area_measures'=>'Тип площади',
    'l_safe_types'=>'Тип хранения',
];

$arr_for_eng = [
    'l_regions',
    'l_towns',
    'l_towns_central',
    'l_districts',
    'l_districts_moscow',
    'l_directions',
    'l_metros',
    'l_highways',
    'l_highways_moscow',
];

//echo $filters_arr[$filter_name];

$filters_all = [];

foreach ($filters_list as $key=>$value){
    $filter_arr = [];
    $filter_arr['name_rus'] = $value;

    $sql = $pdo->prepare("SELECT * FROM $key WHERE exclude!=1 ");
    $sql->execute();

    $variants = [];
    if($key == 'l_regions'){
        $variants['100'] =  ['name'=>'Москва и МО','en'=>furl_create('Москва и МО')];
        $variants['200'] =  ['name'=>'Москва внутри МКАД','en'=>furl_create('Москва внутри МКАД')];
        $variants['300'] =  ['name'=>'МО + Москва снаружи МКАД','en'=>furl_create('МО + Москва снаружи МКАД')];
        $variants['400'] =  ['name'=>'МО + регионы рядом','en'=>furl_create('МО + регионы рядом')];
        $variants['1000'] =  ['name'=>'Вся росссия','en'=>furl_create('Вся росссия')];
    }
    while($item = $sql->fetch(PDO::FETCH_LAZY)) {
        if($key == 'l_price_formats'){
            $variants[$item['id']] =  $item['title_safe'];
        }else{
            if(in_array($key,$arr_for_eng)){

                $variants[$item['id']] =  ['name'=>$item['title'],'en'=>$item['title_eng']];
            }else{
                $variants[$item['id']] = $item['title'];
            }

        }

    }
    $filter_arr['value'] = $variants;

    $filters_all[$key] = $filter_arr;
}






echo json_encode($filters_all, JSON_UNESCAPED_UNICODE);