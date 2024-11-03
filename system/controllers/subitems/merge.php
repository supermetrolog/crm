<?php


//require_once($_SERVER['DOCUMENT_ROOT'].'/errors.php');

//var_dump($_GET['blocks']);

require_once($_SERVER['DOCUMENT_ROOT'].'/global_pass.php');


$telegram = new \Bitkit\Social\Telegram('736512998:AAGIlIPVdPdrffvQRmh1Kwoj2_isbvYUKc4');



if($_GET['blocks']){
    //если новый
    //echo 11;
    $block_sum = new Subitem();
    //$blocks = json_decode($_GET['blocks']);
    $blocks = $_GET['blocks'];
    $parts_not_deleted = $blocks;
}else{
    //если пересобираем
    $block_sum = new Subitem($sum_block_id);
    $blocks = $block_sum->getJsonField('parts');

    $parts_not_deleted = [];
    foreach ($blocks as $part_writen) {
        $part_obj = new Part($part_writen);
        if($part_obj->getField('deleted') != 1) {
            $parts_not_deleted[] = $part_writen;
        }
    }

    $blocks = $parts_not_deleted;

    $telegram->sendMessage(json_encode($parts_not_deleted),'223054377');

}

//если блоко в ТП больше не осталось то удаляем а иначе пересобираем
if (count($parts_not_deleted) == 0) {
    $block_sum->deleteLine();

} else {




    var_dump($_GET['inc_mezz'] );

    var_dump($_GET['inc_office'] );

    var_dump($_GET['inc_tech'] );


    var_dump($blocks);

    //массив с уникальными этажами
    $floors_nums_arr = [];

    $blocks_num = count($blocks);

    //echo 'Сложили '.$blocks_num.' блоков<br><br>';

    for($i=0; $i< $blocks_num; $i++){
        $block_{$i} = new Part($blocks[$i]);

        //наполняем массив чтобы смотреть какие этажи теперь остались и чистить цены
        if (!in_array($block_{$i}->getField('floor'),$floors_nums_arr)) {
            $floors_nums_arr[] = $block_{$i}->getField('floor');
        }
    }


    $floor = new Floor((int)$block_{0}->getField('floor_id'));
    $offer_obj  = new Offer((int)$block_{0}->getField('offer_id'));
    $object_id = (new Building((int)$floor->getField('object_id')))->postId() ;


    $arr_min_fields_more_than_null = [
        'area_floor_min',

        'area_mezzanine_min',

        'area_office_min',

        'area_tech_min',

        'area_field_min',

        'pallet_place_min',

        'ceiling_height_min',
    ];

    $arr_min_fields = [

        'sewage',

        'water',

        'temperature_min',

        'load_floor_min',

        'load_mezzanine_min',

        'racks',
        'rack_levels',
        'cells',
        'heated',

        'climate_control',
        'gas',
        'steam',
        'internet',
        'phone_line',

        'smoke_exhaust',
        'video_control',
        'access_control',
        'security_alert',
        'fire_alert',

        'cranes_runways',
        'warehouse_equipment',
        'charging_room',


    ];

    $arr_max_fields = [


        'ceiling_height_max',

        'temperature_max',

        'enterance_block',

        'is_land',

        'barrier',

        'fence',

        'load_floor_max',

        'load_mezzanine_max',

    ];

    $arr_sum_fields = [
        'area_floor_max',

        'area_mezzanine_max',

        'area_office_max',

        'area_field_max',

        'area_tech_max',


        'pallet_place_max',

        'power',
    ];

    $arr_unique_fields = [
        'purposes_block',
        'rack_types',
        'safe_type',
        'floor_types',
        'floor_types_land',
        'firefighting_type',
        'ventilation',
        'floor',
        'column_grids',
        'photo_block',
        'building_layouts_block',
        'photos_360_block',
        'building_presentations_block',
        'lighting',
        'elevators',
        'cranes',

    ];

    $arr_merge_fields = [

        'gates',


        'cranes_cathead',
        'cranes_overhead',
        'telphers',

    ];


    $arr_fields =[];
    $arr_values =[];
    $arr_assoc = [];

    //считаем все МИНИМАЛЬНЫЕ НЕНУЛЕВЫЕ
    foreach ($arr_min_fields_more_than_null as $field) {
        $arr = [];
        for($i=0; $i< $blocks_num; $i++){
            if($block_{$i}->getField($field) && $block_{$i}->getField($field) > 0){
                $arr[] = $block_{$i}->getField($field);
            }
        }
        $arr_assoc[$field] = min($arr);
    }

    //считаем все МИНИМАЛЬНЫЕ
    foreach ($arr_min_fields as $field) {
        $arr = [];
        for($i=0; $i< $blocks_num; $i++){
            if($block_{$i}->getField($field)){
                $arr[] = $block_{$i}->getField($field);
            }
        }


        $arr_assoc[$field] = min($arr);
    }

    //считаем все МАКСИМАЛЬНЫЕ
    foreach ($arr_max_fields as $field) {
        $arr = [];
        for($i=0; $i< $blocks_num; $i++){
            if($block_{$i}->getField($field)){
                $arr[] = $block_{$i}->getField($field);
            }
        }


        $arr_assoc[$field] = max($arr);
    }


    //считаем все СУММАРНЫЕ
    foreach ($arr_sum_fields as $field) {
        $arr =0;
        for($i=0; $i< $blocks_num; $i++){
            if($block_{$i}->getField($field)){
                $arr += $block_{$i}->getField($field);
            }
        }


        $arr_assoc[$field] = $arr;
    }

    //считаем все JSON
    foreach ($arr_merge_fields as $field) {
        $arr = [];
        for($i=0; $i< $blocks_num; $i++){
            if($block_{$i}->getField($field)){
                $arr = array_merge($arr,$block_{$i}->getJsonField($field));
            }
        }



        $arr_assoc[$field] = json_encode($arr);
    }

    //считаем все JSON УНИКАЛЬНЫЕ
    foreach ($arr_unique_fields as $field) {
        $arr = [];
        for($i=0; $i< $blocks_num; $i++){
            if(is_array(json_decode($block_{$i}->getField($field))) && arrayIsNotEmpty(json_decode($block_{$i}->getField($field)))){
                $arr = array_merge($arr,$block_{$i}->getJsonField($field));
            }else{
                if($block_{$i}->getField($field)){
                    $arr[] = $block_{$i}->getField($field);
                }
            }
        }



        $arr_assoc[$field] = json_encode(getArrayUnique($arr));
    }


    //ДОП ПАРАМЕТРЫ

    $arr_assoc['status'] = 1;

    $arr_assoc['parts'] = json_encode($blocks);

    $arr_assoc['offer_id'] = $block_{0}->getField('offer_id');

    $arr_assoc['object_id'] = $object_id;

    $is_solid = $_GET['is_solid'] ? $_GET['is_solid'] : $block_sum->getField('is_solid');

    $arr_assoc['is_solid'] = $is_solid;

    $arr_assoc['last_update'] = time();

    //сохраняем инфу по исключенным
    if (isset($_GET['blocks'])) {
        $excluded = [];
        foreach($_GET['blocks'] as $part_id) {
            $excluded[$part_id] = [
                'mezz'=>(int) $_GET[$part_id.'_mezz'],
                'office'=>(int) $_GET[$part_id.'_office'],
                'tech'=>(int) $_GET[$part_id.'_tech'],
            ];
        }
    } else {
        $excluded = json_decode($block_sum->getField('excluded_areas'),true);
    }
    $excluded_json = json_encode($excluded);


    $arr_assoc['excluded_areas'] = $excluded_json;


    /**
     * Вот тут тут нужно собрать cranes_min и cranes_max / elevators_min и elevatoes_max
     */

    $cranes_arr = json_decode($arr_assoc['cranes']);
    $elevators_arr = json_decode($arr_assoc['elevators']);
    $arrCranesCapacity = [];
    $arrElevatorCapacity = [];
    foreach ($cranes_arr as $id) {
        $crane = new Crane((int)$id);
        if ($crane->getField('crane_capacity') > 0 ) {
            $arrCranesCapacity[] = $crane->getField('crane_capacity');
        }
    }
    foreach ($elevators_arr as $id) {
        $elevator= new Elevator((int)$id);
        if ($elevator->getField('elevator_capacity') > 0 ) {
            $arrElevatorCapacity[] = $elevator->getField('elevator_capacity');
        }
    }

    $arr_assoc['cranes_num'] = arrayIsNotEmpty($cranes_arr) ? count($cranes_arr) : 0;
    $arr_assoc['cranes_min'] = min($arrCranesCapacity);
    $arr_assoc['cranes_max'] = max($arrCranesCapacity);

    $arr_assoc['elevators_num'] = arrayIsNotEmpty($elevators_arr) ? count($elevators_arr) : 0;
    $arr_assoc['elevators_min'] = min($arrElevatorCapacity);
    $arr_assoc['elevators_max'] = max($arrElevatorCapacity);


    //если сборка целиком
    if ($is_solid == 1 ) {


        $palle_place_max = $arr_assoc['pallet_place_max'];

        $arr_assoc['pallet_place_min'] = $palle_place_max;

        //если ПРОДАЖА
        if ($offer_obj->getField('deal_type') == 2) {
            $area_max = $arr_assoc['area_floor_max'] + $arr_assoc['area_mezzanine_max'] + $arr_assoc['area_office_max'] + $arr_assoc['area_tech_max'] + $arr_assoc['area_field_max'] ;

            $area_warehouse_max = $arr_assoc['area_floor_max'] + $arr_assoc['area_mezzanine_max'] + $arr_assoc['area_field_max'];

            //все площади
            $arr_assoc['area_min'] =  $area_max;
            $arr_assoc['area_max'] =  $area_max;

            //складские площади
            $arr_assoc['area_warehouse_min'] = $area_warehouse_max;
            $arr_assoc['area_warehouse_max'] = $area_warehouse_max;

        //если АРЕНДА СУБАРЕНДА ОТВЕТКА
        } else {

            //вот тут где аренда целиком - жестка)) !!!!!!!!!!!!!

            //пока без галочек  если целиком то плюсую в площадь и офисы
            $area_max = $arr_assoc['area_floor_max'] + $arr_assoc['area_mezzanine_max'] + $arr_assoc['area_office_max'] + $arr_assoc['area_tech_max'] + $arr_assoc['area_field_max'];
            $area_min = $area_max;

            $area_warehouse_max = $arr_assoc['area_floor_max'] + $arr_assoc['area_mezzanine_max'] + $arr_assoc['area_field_max'];
            $area_warehouse_min = $area_warehouse_max;

            //вычитаем  из общих площадей и СКЛАДСКИХ если мез
            foreach($excluded as $part_id => $info) {
                $part = new Part((int)$part_id);
                if ($info['mezz']) {
                    //убираем из общих мезз
                    $area_min = $area_min - $part->getField('area_mezzanine_max');

                    //убираем из складских мезз
                    $area_warehouse_min = $area_warehouse_min - $part->getField('area_mezzanine_max');
                }

                if($info['office']) {
                    $area_min = $area_min - $part->getField('area_office_max');
                }

                if($info['tech']) {
                    $area_min = $area_min - $part->getField('area_tech_max');

                }
            }

            /*
            //вычитаем офисы
            foreach($excluded as $part_id => $info) {
                $part = new Part((int)$part_id);
                if($info['office']) {
                    $area_min = $area_min - $part->getField('area_office_max');

                }
            }

            //вычитаем технич
            foreach($excluded as $part_id => $info) {
                $part = new Part((int)$part_id);
                if($info['tech']) {
                    $area_min = $area_min - $part->getField('area_tech_max');

                }
            }

            */


            /*
            foreach($_GET['blocks'] as $part_id) {
                $part = new Part($part_id);
                if($_GET[$part_id.'_mezz']) {
                    $area_min = $area_min - $part->getField('area_mezzanine_max');
                }
            }

            //вычитаем офисы
            foreach($_GET['blocks'] as $part_id) {
                $part = new Part($part_id);
                if($_GET[$part_id.'_office']) {
                    $area_min = $area_min - $part->getField('area_office_max');
                    //echo 333;
                }
            }

            //вычитаем технич
            foreach($_GET['blocks'] as $part_id) {
                $part = new Part($part_id);
                if($_GET[$part_id.'_tech']) {
                    $area_min = $area_min - $part->getField('area_tech_max');
                    //echo 4444;
                }
            }
            */

            //все площади
            $arr_assoc['area_min'] =  $area_min;
            $arr_assoc['area_max'] =  $area_max ;

            //складские площади
            $arr_assoc['area_warehouse_min'] = $area_warehouse_min ;
            $arr_assoc['area_warehouse_max'] =  $area_warehouse_max;
        }
    }  else {
        //если ПРОДАЖА
        if ($offer_obj->getField('deal_type') == 2) {
            $area_max = $arr_assoc['area_floor_max'] + $arr_assoc['area_mezzanine_max'] + $arr_assoc['area_office_max'] + $arr_assoc['area_tech_max']  + $arr_assoc['area_field_max'] ;


            $arr_assoc['area_min'] =  $arr_assoc['area_floor_min'] ? $arr_assoc['area_floor_min']  : $arr_assoc['area_field_min'] ;
            $arr_assoc['area_max'] =  $area_max;

            $arr_assoc['area_warehouse_min'] = $arr_assoc['area_floor_min'] ? $arr_assoc['area_floor_min']  : $arr_assoc['area_field_min'];
            $arr_assoc['area_warehouse_max'] = $arr_assoc['area_floor_max'] + $arr_assoc['area_mezzanine_max'] + $arr_assoc['area_field_max'];


         //если АРЕНДА СУБАРЕНДА ОТВЕТКА
        } else {
            $area_max = $arr_assoc['area_floor_max'] + $arr_assoc['area_mezzanine_max'] + $arr_assoc['area_office_max'] + $arr_assoc['area_tech_max'] + $arr_assoc['area_field_max']  ;

            $arr_assoc['area_min'] =  $arr_assoc['area_floor_min'] ? $arr_assoc['area_floor_min']  : $arr_assoc['area_field_min'] ;
            $arr_assoc['area_max'] =  $area_max ;

            $arr_assoc['area_warehouse_min'] = $arr_assoc['area_floor_min'] ? $arr_assoc['area_floor_min']  : $arr_assoc['area_field_min'];
            $arr_assoc['area_warehouse_max'] = $arr_assoc['area_floor_max'] + $arr_assoc['area_mezzanine_max'] + $arr_assoc['area_field_max'];
        }
    }

    if(!$sum_block_id){
        $arr_assoc['publ_time'] = time();
    }

    //разбираем данные чтобы всунуть в ТП
    $arr_fields = [];
    $arr_values = [];

    foreach ($arr_assoc as $key=>$value) {
        $arr_fields[] = $key;
        $arr_values[] = $value;
    }

    //массив с возможными цекнами по этажам
    $floors_prices =  [
        '-3'=>'price_sub_three',
        '-2'=>'price_sub_two',
        '-1'=>'price_sub',
        '1f'=>'price_field',
        '1'=>'price_floor',
        '1m'=>'price_mezzanine',
        '2m'=>'price_mezzanine_two',
        '3m'=>'price_mezzanine_three',
        '4m'=>'price_mezzanine_four',
        '2'=>'price_floor_two',
        '3'=>'price_floor_three_min',
        '4'=>'price_floor_four_min',
        '5'=>'price_floor_five_min',
        '6'=>'price_floor_six_min',
    ];



    //var_dump($arr_assoc);




    if ($_COOKIE['member_id'] == 941) {
        echo $arr_assoc['area_min'] .'<br>';
        echo $arr_assoc['area_max'] .'<br><br><br>';
        echo 'Вот это массив этажей';
        var_dump($floors_nums_arr);
    } else {
        if($sum_block_id){
            $block_id = $block_sum->updateLine($arr_fields,$arr_values);

            $block_sum->updateField('parts',json_encode($blocks));

            //$block_sum->updateField('excluded_areas',$excluded);

            //корректируем цены
            foreach ($floors_prices as $key=>$value) {
                if(!in_array($key,$floors_nums_arr)) {
                    $block_sum->updateField($value.'_min',0);
                    $block_sum->updateField($value.'_max',0);
                }
            }
        }else{
            $block_id = $block_sum->createLine($arr_fields,$arr_values);
        }



    }


}
if ($_COOKIE['member_id'] != 941) {
    header('Location: ' . $_SERVER['HTTP_REFERER']);
}