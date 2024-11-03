<? //header('Content-Type: text/json; charset=utf-8');?>
<? include_once($_SERVER['DOCUMENT_ROOT'].'/global_pass.php');?>
<?// include_once($_SERVER['DOCUMENT_ROOT'].'/errors.php');?>
<?php
$url = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$furl = parse_url($url);

$id = (int)$_GET['id'];
$type = (int)$_GET['type_id'];

//echo $id;
//echo $type;

/*

$type_arr = ['1'=>'','2'=>''];

$table = 'c_industry_offers_mix';

$post = new Post($id);
$post->getTable($table);

$offer = new Offer($id);


$building_arr =[];

//var_dump($offer);




*/

//МАССИВ С РУССКИМИ НАЗВАНИЯМИ
$arr_info = [
    'object_id'=>'ID лота',
    'title'=>'Идентификатор лота',
    'object_type'=>'Тип объекта',
    'is_land'=>'',
    'address'=>'Адрес',
    'region'=>'Регион',
    'town'=>'Город',
    'district'=>'Район',
    'direction'=>'Направление',
    'highway'=>'Шоссе',
    'from_mkad'=>'от МКАД',
    'metro'=>'Станция метро',
    'from_metro_time'=>'Время от метро',
    'from_metro_way'=>'От метро как',
    'railway_station'=>'Ж/Д станция',
    'railway_station_time'=>'Время от станции',
    'railway_station_way'=>'От станции как',
    'latitude'=>'Широта',
    'longitude'=>'Долгота',

    'area'=>'Свободня площадь',
    'area_mezzanine'=>'Из них мезонина',
    'area_office'=>'Из них офисов',
    'pallet_place'=>'Вместимость',
    'cells_place'=>'Кол-во ячеек',
    'area_field'=>'Уличное хранение',

    'floor'=>'Этажность',
    'class_name'=>'Класс объекта',
    'ceiling_height'=>'Высота потолков',
    'gate_type'=>'Тип ворот',
    'gate'=>'Количество ворот',
    'racks'=>'Стеллажи',
    'load_floor'=>'Нагрузка на пол',
    'load_mezzanine'=>'Нагрузка на мезонин',
    'temperature'=>'Температура',
    'column_grid'=>'Шаг колон',
    'elevators'=>'Грузовые лифты',
    'facing'=>'Внешняя отделка',
    'land_use_restrictions'=>'В.Р.И',
    'land'=>'Габариты участка',


    'power'=>'Электричество',
    'heating'=>'Отопление',
    'water'=>'Водоснабжение',
    'sewage_central'=>'Канализация',
    'ventilation'=>'Внтиляция',
    'gas'=>'Газ',
    'steam'=>'Пар',
    'phone'=>'Телефония',
    'internet'=>'Интернет',

    'railway'=>'Ж/Д ветка',
    'cranes_gantry'=>'Козловые краны',
    'cranes_railway'=>'Ж/Д краны',
    'cranes_overhead'=>'Мостовые краны',
    'cranes_cathead'=>'Кран-балки',
    'telphers'=>'Тельферы',

    'entry_territory'=>'Въезд на территорию',
    'parking_car'=>'Парковка легковая',
    'parking_truck'=>'Парковка грузовая',
    'canteen'=>'Столовая/кафе',
    'hostel'=>'Общежитие',

    'guard'=>'Охрана объекта',
    'firefighting'=>'Пожаротушение',
    'video_control'=>'Видеонаблюдение',
    'access_control'=>'Контроль доступа',
    'security_alert'=>'Охранная сигнализация',
    'fire_alert'=>'Пожарная сигнализация',
    'smoke_exhausting'=>'Дымоудаление',

];

//МАССИВ ДЛЯ СБОРА БЛОКОВ
$block_fields = [
    'object_id',
    'visual_id',
    'floor_min',
    'area_min',
    'area_max',
    'ceiling_height_min',
    'ceiling_height_max',
    'floor_type',
    'gate_type',
    'heating',
    'temperature_min',
    'temperature_max',
    'price_floor_min',
    'price_floor_max',
    'price_floor_min_month',
    'price_floor_max_month',
    'price_min_month_all',
    'price_max_month_all',
    'price_sale_min',
    'price_sale_max',
    'price_sale_min_all',
    'price_sale_max_all',
];


//МАССИВ ДЛЯ СБОРА ОСНОВНЫХ ХАРАКТЕРИСТИК
$general_fields = [
    'object_id',
    'floor_min',
    'area_min',
    'area_max',
    'ceiling_height_min',
    'ceiling_height_max',
    'floor_type',
    'temperature_min',
    'temperature_max',
    'price_floor_min',
    'price_floor_max',
    'price_floor_min_month',
    'price_floor_max_month',
    'price_min_month_all',
    'price_max_month_all',
    'price_sale_min',
    'price_sale_max',
    'price_sale_min_all',
    'price_sale_max_all',
];




//МАССИВ ПОЛЕЙ ОТОБРАЖАЕМЫХ ВЕРТИКАЛЬНО
$vertical_arr = [
    'land_use_restrictions',
];


//МАССИВ ПО СБОРУ ПОДРОБНЫХ ПАРАМЕТРОВ
$arr = [
    'building'=>[
        ['Объект'],
        [
        'object_id'=>'',
        'title'=>'',
        'object_type'=>'',
        'is_land'=>'',
        'class'=>'',
        'address'=>'',
        'region'=>'',
        'town'=>'',
        'district'=>'',
        'direction'=>'',
        'highway'=>'',
        'from_mkad'=>'',
        'metro'=>'',
        'from_metro_time'=>'',
        'from_metro_way'=>'',
        'railway_station'=>'',
        'railway_station_time'=>'',
        'railway_station_way'=>'',
        'latitude'=>'',
        'longitude'=>'',
        ]
    ],
    'areas'=>[
        ['Площади к аренде'],
        [
        'area'=>'м.кв.',
        'area_mezzanine'=>'м.кв.',
        'area_office'=>'м.кв.',
        'pallet_place'=>'паллет мест',
        'cells_place'=>'ячейко мест',
        'area_field'=>'м.кв',
        ]
    ],
    'options'=>[
        ['Характеристики'],
        [
            'floor'=>'этаж',
            'class_name'=>'',
            'ceiling_height'=>'м.',
            'gate_type'=>'',
            'gate'=>'шт/',
            'racks'=>'',
            'load_floor'=>'т',
            'load_mezzanine'=>'т',
            'temperature'=>'С',
            'column_grid'=>'',
            'elevators'=>'шт./т.',
        ]
    ],
    'communications'=>[
        ['Коммуникации'],
        [
        'power'=>'кВт',
        'heating'=>'',
        'water'=>'м.куб/сут',
        'sewage_central'=>'м.куб/сут',
        'ventilation'=>'',
        'gas'=>'м.куб/час',
        'steam'=>'бар',
        'phone'=>'',
        'internet'=>'',
        ]
    ],
    'cranes'=>[
        ['Краны'],
        [
        'railway'=>'м.',
        'cranes_gantry'=>'шт./т.',
        'cranes_railway'=>'шт./т.',
        'cranes_overhead'=>'шт./т.',
        'cranes_cathead'=>'шт./т.',
        'telphers'=>'шт./т.',
        ]
    ],
    'infrastructure'=>[
        ['Инфраструктура'],
        [
            'entry_territory'=>'',
            'parking_car'=>'',
            'parking_truck'=>'',
            'canteen'=>'',
            'hostel'=>'',
        ]
    ],
    'security'=>[
        ['Безопасность'],
        [
            'guard'=>'',
            'firefighting'=>'',
            'video_control'=>'',
            'access_control'=>'',
            'security_alert'=>'',
            'fire_alert'=>'',
            'smoke_exhausting'=>'',
        ]
    ],

];




$offer_arr = [];




$offerMix = new OfferMix();
$offerMix->getRealId($id,$type);



$fields = $offerMix->getTableColumnsNames();

//СОБИРАЕМ ОБЩИЕ ХАРАКТЕРИСТИКИ
$general = [];


if($offerMix->getField('floor_min')){
    $val= valuesCompare($offerMix->getField('floor_min'),$offerMix->getField('floor_max')).' этаж';
    $general['floors'] = $val;
}
if($offerMix->getField('gate_num')){
    $val= $offerMix->getField('gate_num').' ворот';
    $general['gates'] = $val;
}
if($offerMix->getField('power')){
    $val= $offerMix->getField('power_value').' кВт';
    $general['power'] = $val;
}
if($offerMix->getField('ceiling_height_min')){
    $val= valuesCompare($offerMix->getField('ceiling_height_min'),$offerMix->getField('ceiling_height_max')).' метров';
    $general['ceiling'] = $val;
}
if($offerMix->getField('floor_type')){
    $val= $offerMix->getField('floor_type');
    $general['floor'] = $val;
}
if($offerMix->getField('heated') == 1 || $offerMix->getField('temperature_max') > 10){
    $val= 'Теплый';
}else{
    $val= 'Холодный';
}
$general['heating'] = $val;

if($offerMix->getField('water')){
    $val= 'Вода';
    $general['water'] = $val;
}
if($offerMix->getField('sewage_central')){
    $val= 'Канализация';
    $general['sewage'] = $val;
}
if($offerMix->getField('gas') == 1){
    $val= 'Газ';
    $general['gas'] = $val;
}
if($offerMix->getField('steam') == 1){
    $val= 'Пар';
    $general['steam'] = $val;
}
if($offerMix->getField('cranes_min')){
    $val= valuesCompare($offerMix->getField('cranes_min'),$offerMix->getField('cranes_max')).' тонн';
    $general['cranes'] = $val;
}

$offer_arr['general_stats'] = $general;


//var_dump($fields);



foreach($arr as $name=>$item){
    ${$name} = [];
    foreach($item[1] as $field=>$dimension){

        $name_rus = $arr_info[$field];
        (in_array($field,$vertical_arr))  ? $vert = 1  : $vert = 0;

        //ФОРМАТ ПЛОЩАДЕЙ
        if($offerMix->hasField($field.'_min')){
            $val = valuesCompare($offerMix->getField($field.'_min'),$offerMix->getField($field.'_max')).' '.$dimension;
            if ($val == 0) {
                ${$name}[$field] = [$name_rus,'---'];
            } else {
                ${$name}[$field] = [$name_rus,$val,$vert];
            }
        }

        //ФОРМАТ ГАБАРИТОВ
        if($offerMix->hasField($field.'_width')){
            $val = $offerMix->getField($field.'_width').''.$offerMix->getField($field.'_height');
            ${$name}[$field] = [$name_rus,$val,$vert];
        }

        //ФОРМАТ КОММУНИКАЦИЙ
        if($offerMix->hasField($field)){
            $val = '';
            if($offerMix->hasField($field)){
                if($offerMix->getField($field) == 1){
                    $val.= 'есть';
                }elseif($offerMix->getField($field) == 2){
                    $val.= 'нет';
                }elseif($offerMix->getField($field) === 0 || $offerMix->getField($field) === '0'){
                    $val.= 'не указано';
                }else{
                    //$val.= mb_strtolower($offerMix->getField($field));
                    $val.= ($offerMix->getField($field));
                }
            }
            if($offerMix->getField($field.'_value')){
                $val.= ', '. mb_strtolower($offerMix->getField($field.'_value')).' '.$dimension;
            }
            ${$name}[$field] = [$name_rus,$val,$vert];
        }

        //ФОРМАТ КРАНОВ
        if($offerMix->hasField($field.'_num')){
            $val = '';
            $dims = explode('/',$dimension);

            $val.= $offerMix->getField($field.'_num').' '.$dims[0].', '.valuesCompare($offerMix->getField($field.'_min'),$offerMix->getField($field.'_max')).' '.$dims[1];

            ${$name}[$field] = [$name_rus,$val,$vert];
        }
    }
    if($name == 'building'){
        $offer_arr[$name] = [$item[0],${$name}];
    }else{
        $offer_arr['stats'][$name] = [$item[0],${$name}];
    }

}



foreach($fields as $field){

    if($offerMix->hasField($field) && !in_array($field,$arr['building'][1]) && !in_array($field,$arr['areas'][1]) && !in_array($field,$arr['options'][1])){
        //если фотографии
        if($field === 'photos') {
            //ЕСЛИ ФОТОГРАФИИ
            $photos_full = [];
            $photos = $offerMix->getJsonField($field);
            foreach ($photos as $photo) {
                $els = explode('/',$photo);
                $img_name = array_pop($els);
                $photos_full[] = 'https://pennylane.pro/system/controllers/photos/watermark.php/1200/' . $offerMix->getField('object_id') . '/'.$img_name;
            }
            $value = $photos_full;
        }elseif($field === 'address'){
            $stat = capitalize_rus($offerMix->getField('town'));

            if($offerMix->hasField('highway') && $offerMix->getField('region') != 'москва'){
                $stat.= ', '.capitalize_rus($offerMix->getField('highway')).' ш.';
            }
            if($offerMix->hasField('from_mkad')){
                $stat.= ', '.$offerMix->getField('from_mkad').' км от МКАД';
            }
            if($offerMix->hasField('metro')){
                $stat.= ', м.'.capitalize_rus($offerMix->getField('metro'));
            }

            $value = $stat;
        }elseif($field === 'blocks'){
            //ЕСЛИ БЛОКИ
            $blocks_full = [];
            $blocks = $offerMix->getJsonField($field);
            for($i = 0; $i < count($blocks); $i++){
                $block = new OfferMix($blocks[$i]);
                foreach($fields as $field_block){
                    if(in_array($field_block,$block_fields)){
                        $blocks_full[$i][$field_block] = $block->getField($field_block);
                    }
                }
            }
            $value = $blocks_full;
        }else{
            $value = $offerMix->getField($field);
        }
        $offer_arr[$field] = $value;
    }


}

//$offer_arr['building'] = $building;
//$offer_arr['areas'] = ['Площади к аренде',$areas];
//$offer_arr['communications'] = ['Коммуникации',$communications];
//$offer_arr['cranes'] = ['Ж/Д и крановые устройства',$cranes];



//var_dump($post->getLine());

$response = json_encode($offer_arr, JSON_UNESCAPED_UNICODE );

echo $response;


