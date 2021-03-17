<?php

require_once($_SERVER['DOCUMENT_ROOT'].'/global_pass.php');


$intro_arr = [
    [
        'Предлагается в аренду',
        'Сдается в аренду',
        'Предлагается к аренде',
    ],
    [
        'Продается',
        'Предлагается на продажу',
    ],
    [
        'Предлагается в ответственное хранение',
        'Предлагается к ответственному хранению',
    ],
    [
        'Предлагается в аренду',
        'Сдается в аренду',
        'Предлагается к аренде',
    ]
];

if($original_id){
    $offer_desc = new OfferMix();
    $offer_desc->getRealId($original_id,$original_type);
    $offres_arr = [
        'лот'=>$offer_desc->postId()
    ];
}else{
    $offres_arr = [
        //'АРЕНДА - ЗДАНИЕ лот первый 3379'=>1165,
        'АРЕНДА - ЗДАНИЕ лот 3379'=>6297,
        'АРЕНДА БЛОК - ЗДАНИЕ лот 3379'=>3303,

        'ПРОДАЖА - ЗДАНИЕ лот 3379'=>6298,
        'ПРОДАЖА БЛОК - ЗДАНИЕ лот 3379'=>3306,

        'ОТВЕТКА - ЗДАНИЕ лот 3379'=>6299,
        'ОТВЕТКА БЛОК - ЗДАНИЕ лот 3379'=>3567,
        //'АРЕНДА - УЧАСТОК лот пятый'=>1232,
        //'ПРОДАЖА - УЧАСТОК лот шестой'=>1240,
        //'ОТВЕТКА - УЧАСТОК лот 3132'=>1368,
    ];
}



//1713 - аренда здание 1368 продажа здание

foreach($offres_arr as $key=>$value){

    //echo '<br><b>'.$key.'</b><br>';
    $offer_desc = new OfferMix($value);


    //вступление
    $intro = $intro_arr[$offer_desc->gf('deal_type') - 1][random_int(0, count($intro_arr[$offer_desc->gf('deal_type') - 1]) - 1 )];

    //раздел про местоположение
    $region = $offer_desc->gf('region');
    $direction = mb_strtolower($offer_desc->gf('direction_name'));
    $town = mb_convert_case($offer_desc->gf('town_name'),MB_CASE_TITLE, "UTF-8");
    $district = $offer_desc->gf('district_name');
    $highway = capFirst($offer_desc->gf('highway_name')).' шоссе,';
    $from_mkad = $offer_desc->gf('from_mkad');

    ($offer_desc->gf('metro')) ? $objMetro='Ближайшее метро '.mb_convert_case($offer_desc->gf('metro_name'),MB_CASE_TITLE, "UTF-8") : $objMetro='' ;
    ($offer_desc->gf('from_metro_value')) ? $objMetroTime=', '.$offer_desc->gf('from_metro_value').' мин ' : $objMetroTime='' ;
    if($offer_desc->gf('from_metro')) {
        if($offer_desc->gf('from_metro') == 1){
            $objMetroWay= 'пешком';
        }else{
            $objMetroWay= 'транспортом';
        }
    }else{
        $objMetroWay= '';
    }

    //($offer_desc->gf('railway_station')) ? $objStation='Ж/Д станция - '.$offer_desc->gf('railway_station') : $objStation='' ;
    //($offer_desc->gf('from_station_value')) ? $objStationTime=', '.$offer_desc->gf('from_station_value').' мин ' : $objStationTime='' ;
    //($offer_desc->gf('from_station')) ? $objStationWay=$offer_desc->gf('from_station') : $objStationWay='' ;
    if($region == 1){
        $line_loc = "на $direction".'е Московской области, '.$town.", $highway в $from_mkad км от МКАД. $objStation $objStationTime". mb_strtolower($objStationWay);
    }else{
        $district = $offer_desc->gf('district');
        if($district == 'Новая Москва'){
            $line_loc = "в Новой Москве $objMetro $objMetroTime ". mb_strtolower($objMetroWay).'. ';
        }else{
            $line_loc = "в $district Москвы $objMetro $objMetroTime ". mb_strtolower($objMetroWay).'. ';
        }


    }



    //раздел про проект
    $line_proj = '';
    if($offer_desc->gf('built_to_suit') == 1 ){

        if($offer_desc->gf('deal_type') == 2){
            $projType = 'Built-to-suit';
        }else{
            $projType = 'Built-to-rent';
        }
        $line_proj .= "Проект $projType  ";
        if($offer_desc->gf('built_to_suit_time')){
            $time = $offer_desc->gf('built_to_suit_time');
            $line_proj .= ", строительство гарантировано за $time месяцев";
        }
        if($offer_desc->gf('built_to_suit_plan')){
            //$line_proj .= ", проект имеется";
        }

    }



    //раздел про бизнес
    $line_business = '';
    if($offer_desc->gf('deal_type') == 2 && $offer_desc->gf('rent_business')){
        $line_business = 'Объект продается с арендным бизнесом. ';
        if($offer_desc->gf('rent_business_fill') ){
            $fill = $offer_desc->gf('rent_business_fill') ;
            $line_business.= ", заполнен на $fill %. ";
        }
        if($offer_desc->gf('rent_business_long_contracts') ){
            $long = $offer_desc->gf('rent_business_long_contracts') ;
            $line_business.= "Долгосрочных контрактов -  $long %. ";
        }
        if($offer_desc->gf('rent_business_payback') ){
            $payback = $offer_desc->gf('rent_business_payback') ;
            $year = ($payback > 4) ? 'лет.' : 'года.';
            $line_business.= "Предварительный срок окупаемости -  $payback  $year"  ;
        }
        $line_business.= 'Данные по средней ставке аренды, показатель EBITDA и чистые потоки предоставляются по запросу. ';
        if($offer_desc->gf('sale_company') ){
            $payback = $offer_desc->gf('rent_business_payback') ;
            $line_business.= "Возможна продажа юр. лица. ";
        }

    }

    //параграф про деление
    $parts_line = '';
    if($offer_desc->gf('deal_type') == 2) {
        $parts_line.='';
        //if($offer_desc->gf('area_min') != $offer_desc->gf('area_max')){
        if(false){
            if($offer_desc->gf('is_land')){
                $parts_line.= "Возможна продажа участка частями от ".$offer_desc->gf('area_min')." м<sup>2</sup>";
            }else{
                $parts_line.= "Возможна продажа складского комплекса частями от ".$offer_desc->gf('area_min')." м<sup>2</sup>";
            }
        }else{
            if($offer_desc->gf('is_land')){
                $parts_line.= "Продажа земельного учкастка частями не предполагается";
            }else{
                $parts_line.= "Продажа складского комплекса частями не предполагается";
            }
        }
    }elseif($offer_desc->gf('deal_type') == 3){
        $parts_line.='';
        if($offer_desc->gf('area_min') != $offer_desc->gf('area_max')){
            $parts_line.= "Присутствует зонирование по блокам. Минимальный объем хранения в блоках от ".$offer_desc->gf('pallet_place_min')." п.м.";
        }else{
            $parts_line.= "Зонирования по блокам нет";
        }
    }else{
        $parts_line.='<br>';
        //if($offer_desc->gf('area_min') && $offer_desc->gf('area_min') != $offer_desc->gf('area_max')  ){
        if( false ){
            if($offer_desc->gf('is_land')){
                $parts_line.= "Возможно деление участка от ".$offer_desc->gf('area_min')." м<sup>2</sup>";
            }else{
                $parts_line.= "Возможно деление складского комплекса от ".$offer_desc->gf('area_min')." м<sup>2</sup>";
            }
        }else{
            if($offer_desc->gf('is_land')){
                $parts_line.= "Деление земельного учкастка не предполагается";
            }else{
                $parts_line.= "Деление складского комплекса не предполагается";
            }
        }

    }
    $parts_line.='<br>';

    //echo 2222;

    //остальные параметры первого абзаца
    ($offer_desc->gf('is_land')) ? $objType='земельный участок' : $objType='складской комплекс' ;
    ($offer_desc->gf('class')) ? $objClass='категории '.$offer_desc->gf('class_name') : $objClass='' ;
    ($offer_desc->gf('area_max')) ? $objAreaAll= valuesCompare($offer_desc->gf('area_max'),$offer_desc->gf('area_max')).' м. кв.' : $objAreaAll='' ;
    ($offer_desc->gf('pallet_place_max')) ? $objVolume='Общая вместимость '.$offer_desc->gf('pallet_place_max').' п.м.' : $objVolume='' ;

    $land_intro ='';
    if($offer_desc->gf('is_land')  || $offer_desc->gf('deal_type') == 2){
        ($offer_desc->gf('land_category')) ? $objCategory='Категория :'.mb_strtolower($offer_desc->gf('land_category')).'. ' : $objCategory='' ;
        ($offer_desc->gf('own_type_land')) ? $objOwnType='Право: '.mb_strtolower($offer_desc->gf('own_type_land')).'. '  : $objOwnType='' ;
        ($offer_desc->gf('land_use_restrictions')) ? $objRestriction='Есть ограничения. '  : $objRestriction='Ограничения отсутствуют' ;
        $land_intro.=$objCategory.$objOwnType.$objRestriction;
    }



    //echo 333;


    //echo 4444;
    $main_line = '';
    $blocks_active = [];
    if(count($offer_desc->getJsonField('blocks')) > 1){
        $blocks = $offer_desc->getJsonField('blocks');
    }else{
        $blocks = [$offer_desc->gf('id')];
        //$blocks = $offer_desc->getJsonField('blocks');
    }

    foreach($blocks as $block){
        $bl_obj = new OfferMix($block);
        if($bl_obj->gf('status') == 1){
            $blocks_active[] =  $block;
        }

    }

    foreach($blocks_active as $block){
        $offer_block = new OfferMix($block);
        ($offer_block->gf('area_min')) ? $objArea=valuesCompare($offer_block->gf('area_min'),$offer_block->gf('area_max')). ' м.кв. ' : $objArea='' ;
        ($offer_block->gf('area_mezzanine_min')) ? $objMezz=', из них мезонин '.valuesCompare($offer_block->gf('area_mezzanine_min'),$offer_block->gf('area_mezzanine_max')). ' м.кв. ' : $objMezz='' ;
        if ($offer_block->gf('area_mezzanine_min')) {
            $mezzAdd =  ($offer_block->gf('area_mezzanine_add')) ? ', вменяется' : '' ;
        } else {
            $mezzAdd = '';
        }
        ($offer_block->gf('area_office_min')) ? $objOffice='. Офисные помещения '.valuesCompare($offer_block->gf('area_office_min'),$offer_block->gf('area_office_max')). ' м.кв. ' : $objOffice='' ;
        /*
        if($offer_block->gf('area_office_min')){
            ($offer_block->gf('area_office_add')) ? $objOfficeAdd='обязателны к аренде' : $objOfficeAdd=' по желанию ' ;
        }else{
            $objOfficeAdd= '';
        }
        */
        ($offer_block->gf('area_office_add')) ? $objMezzAdd='обязателны к аренде' : $objMezzAdd=' по желанию ' ;
        ($offer_block->gf('land_width') && $offer_block->gf('is_land')) ? $objMeasure='Габариты участка '.$offer_block->gf('land_width').'x'.$offer_block->gf('land_length').' м. ' : $objMeasure='' ;
        ($offer_block->gf('landscape_type') && $offer_block->gf('is_land')) ? $objLandscape='Рельеф участка: '.mb_strtolower($offer_block->gf('landscape_type'))  : $objLandscape='' ;
        $tempSign = ($offer_block->gf('temperature_min') >= 0) ? '+' : '-';
        ($offer_block->gf('temperature_min')) ? $objTemp=' Температурный режим от '.$tempSign.$offer_block->gf('temperature_min')  : $objTemp='' ;
        ($offer_block->gf('temperature_max')) ? $objTemp.=' до '.$tempSign.$offer_block->gf('temperature_max')  : '' ;
        ($offer_block->gf('temperature_min')) ? $objTemp.=' C '  : '' ;
        $floorNum =  'Блок на '.$offer_block->gf('floor_min').' этаже';
        ($offer_block->gf('ceiling_height_min')) ? $objHeight=', высота потолков '.valuesCompare($offer_block->gf('ceiling_height_min'),$offer_block->gf('ceiling_height_max')). ' м. ' : $objHeight='' ;
        ($offer_block->gf('floor_type')) ? $objFloorType=',  покрытие - '.$offer_block->gf('floor_type').'.'  : $objFloorType='' ;
        ($offer_block->gf('cross_docking')) ? 'Кросс-докинг'  : '' ;
        ((int)$offer_block->gf('load_floor_min') !=0 ) ? $objLoadFloor=' Нагрузка на пол '.valuesCompare($offer_block->gf('load_floor_min'),$offer_block->gf('load_floor_max')).' т/м.кв.'  : $objLoadFloor='' ;
        ((int)$offer_block->gf('load_mezzanine_min') != 0) ? $objLoadMezz=', на мезонин '.valuesCompare($offer_block->gf('load_mezzanine_min'),$offer_block->gf('load_mezzanine_max')).' т/м.кв.'  : $objLoadMezz='' ;
        ($offer_block->gf('cross_docking') ==1 ) ? $crossDock='Кросс-докинг'  : $crossDock='' ;
        ($offer_block->gf('column_grid')) ? $columnGrid='Сетка колонн '.$offer_block->gf('column_grid')  : $columnGrid='' ;
        ($offer_block->gf('warehouse_equipment') ==1 ) ? $equipment='Возможна аренда складской техники.'  : $equipment='' ;
        ($offer_block->gf('charging_room') ==1) ? $chargeRoom='Имеется зарядная комната.'  : $chargeRoom='' ;
        $main_line.= $objArea.
            $objMezz .$mezzAdd.
            $objMeasure.
            $objLandscape.
            $objTemp.
            $floorNum.
            $objHeight.
            $objFloorType.
            $crossDock.
            $objLoadFloor.
            $objLoadMezz.
            $columnGrid.
            $objOffice .$objOfficeAdd
        ;
        $main_line.= '<br>';

    }

    //раздел КОММУНИКАЦИЙ
    $communication_line ='ТУ, коммуникации и безопасность: ';
    ($offer_desc->gf('power_value')) ? $objPower=$offer_desc->gf('power_value').'кВт, ' : $objPower='' ;
    ($offer_desc->gf('gas') == 1) ? $objGas='ГАЗ, ' : $objGas='' ;
    ($offer_desc->gf('steam') ==1) ? $objSteam='ПАР, ' : $objSteam='' ;
    ($offer_desc->gf('water') == 1) ? $objWater='вода, ' : $objWater='' ;
    ($offer_desc->gf('sewage_central') == 1) ? $objSewage='канализация, ' : $objSewage='' ;
    ($offer_desc->gf('ventilation') == 1) ? $objVent=$offer_desc->gf('ventilation').' вентиляция, ' : $objVent='' ;
    ($offer_desc->gf('fire_alert') ==1) ? $objFireAlert='пожарная сигнализация, ' : $objFireAlert='' ;
    ($offer_desc->gf('smoke_exhaust') ==1) ? $objSmoke='дымоудаление, ' : $objSmoke='' ;
    ($offer_desc->gf('firefighting') ==1) ? $objFireFight=$offer_desc->gf('firefighting').', ' : $objFireFight='' ;
    ($offer_desc->gf('video_control') ==1) ? $objVideoControl='видеонаблюдение, ' : $objVideoControl='' ;
    ($offer_desc->gf('security_alert') ==1) ? $objSecurityAlert='охранная сигнализация, ' : $objSecurityAlert='' ;
    ($offer_desc->gf('access_control') ==1) ? $objAccessControl='контроль доступа на территорию, ' : $objAccessControl='' ;
    ($offer_desc->gf('phone')) ? $objPhone='телефония, ' : $objPhone='' ;
    ($offer_desc->gf('internet')) ? $objInternet='и интернет, ' : $objInternet='' ;


    $communication_line.=$objPower.$objGas.
        $objSteam.
        $objWater.
        $objSewage.
        mb_strtolower($objVent).
        $objFireAlert.
        $objSmoke.
        mb_strtolower($objFireFight).
        $objVideoControl.
        $objSecurityAlert.
        $objAccessControl.
        $objPhone.
        $objInternet;


    //раздел ДОСТУПНОСТИ
    $entrance_line ='<br>';
    ($offer_desc->gf('guard')) ? $objGuard='Обьект под охраной ('.$offer_desc->gf('guard').'). ' : $objGuard='' ;
    ($offer_desc->gf('entry_territory')) ? $objEntry=$offer_desc->gf('entry_territory').' въезд на территорию. ' : $objEntry='' ;

    $parking_line = '';
    if($offer_desc->gf('parking_car') ||  $offer_desc->gf('parking_lorry') || $offer_desc->gf('parking_truck')){
        $parking_line = 'Парковка: ';
        if($offer_desc->gf('parking_truck')){
            $parking_line.= 'для а/м от 10т';
            if($offer_desc->gf('parking_truck_value')){
                $parking_line.= ' - '.mb_strtolower($offer_desc->gf('parking_truck_value'));
            }
            $parking_line.= ', ';
        }
        if($offer_desc->gf('parking_lorry')){
            $parking_line.= 'для а/м от 5-10т';
            if($offer_desc->gf('parking_lorry_value')){
                $parking_line.= ' - '.mb_strtolower($offer_desc->gf('parking_lorry_value'));
            }
            $parking_line.= ', ';
        }
        if($offer_desc->gf('parking_car')){
            $parking_line.= 'для легковых а/м ';
            if($offer_desc->gf('parking_car_value')){
                $parking_line.= ' - '.mb_strtolower($offer_desc->gf('parking_car_value'));
            }
            $parking_line.= ', ';
        }
    }
    ($offer_desc->gf('hostel') == 1) ? $objHostel='общежитие, ' : $objHostel='' ;
    ($offer_desc->gf('canteen') == 1) ? $objCanteen='столовая, ' : $objCanteen='' ;
    ($offer_desc->gf('railway') == 1) ? $objRailway='действующая Ж/Д ветка, ' : $objRailway='' ;
    ($offer_desc->gf('cranes_railway_num') == 1) ? $objRailCranes='Ж/Д краны, ' : $objRailCranes='' ;
    ($offer_desc->gf('cranes_gantry_num')) ? $objGantryCranes='козловые краны, ' : $objGantryCranes='' ;

    $has_line = '<br>';
    if($objHostel || $objCanteen || $objRailway || $objRailCranes || $objGantryCranes){
        $has_line.= 'На территории есть ';
    }

    $entrance_line.= $objGuard.
        $objEntry.
        $parking_line.
        $has_line.
        $objHostel.
        $objCanteen.
        $objRailway.
        $objRailCranes.
        $objGantryCranes

    ;

    //РАЗДЕЛ ЦЕН
    $price_line = '';
    if($offer_desc->gf('deal_type') == 2){
        $price_min = $offer_desc->gf('price_sale_min');
        $price_max = $offer_desc->gf('price_sale_max');
        $price_min_all = $offer_desc->gf('price_sale_min_all');
        $price_max_all = $offer_desc->gf('price_sale_max_all');
        $price_line.= 'Стоимость объекта '. valuesCompare($price_min_all,$price_max_all).'  руб  ('.valuesCompare($price_min,$price_max).' руб. за м2)' ;
    }elseif($offer_desc->gf('deal_type') == 3){
        $price_line.= 'Перечень оказываемых услуг ответственного хранения с подробными ценами предоставляем по запросу';
    }else{
        $price_line.='Ставка аренды: ';
        $price_line.= "<br>- ";
        $price_min = $offer_desc->gf('price_floor_min');
        $price_max = $offer_desc->gf('price_floor_max');
        if($offer_desc->gf('is_land')){
            $price_line.= 'открытая площадь ';
        }else{
            $price_line.= 'пол ';
        }
        $price_line.= valuesCompare($price_min,$price_max).' руб. м2/год';
        if($offer_desc->gf('price_mezzanine_min')){
            $price_mezzanine_min = $offer_desc->gf('price_mezzanine_min');
            $price_mezzanine_max = $offer_desc->gf('price_mezzanine_max');
            $price_line.= '<br>- мезонин '. valuesCompare($price_mezzanine_min,$price_mezzanine_max).'  руб. м2/год';
        }
        if($offer_desc->gf('price_office_min')){
            $price_office_min = $offer_desc->gf('price_office_min');
            $price_office_max = $offer_desc->gf('price_office_max');
            $price_line.= '<br>- офисы '. valuesCompare($price_office_min,$price_office_max).'  руб. м2/год';
        }

        if($offer_desc->gf('price_opex_min') || $offer_desc->gf('price_public_services_min')){



            $price_line.= '<br> Дополнительно оплачивается  ';
            if($offer_desc->gf('price_opex_min')){
                $price_opex = $offer_desc->gf('price_opex_min');
                $price_line.= 'OPEX ';
                if($offer_desc->gf('price_opex_min') != $offer_desc->gf('price_opex_max')){
                    $price_line.= ' от ';
                }
                $price_line.= $price_opex.' руб. м2/год';
            }

            if($offer_desc->gf('price_public_services_min')){
                $price_services = $offer_desc->gf('price_public_services_min');
                $price_line.= ', КУ ';
                if($offer_desc->gf('price_public_services_min') != $offer_desc->gf('price_public_services_max')){
                    $price_line.= ' от ';
                }
                $price_line.= $price_services.' руб. м2/год';
            }


        }
    }

    $price_cond = '<br> ';

    /*
    if($offer_desc->gf('tax_form') == 'c НДС'){
        $price_cond.= 'Все цены указаны c НДС';
    }elseif($offer_desc->gf('tax_form') == 'усн'){
        $price_cond.= 'Собственник на упрощенной системе налогооблажения.';
    }else{
        $price_cond.= 'Все цены указаны без НДС';
    }
    */

    //тут про каникулы и бонусы

    $price_cond.= '<br>Планы БТИ и дополнительную информацию отправим по запросу';

    if($offer_desc->gf('holidays')){
        $price_cond.= '<br>Предоставляются каникулы на переезд + возможность вернуть бонусом 10% от стоимости 1 месяца аренды в случае сотрудничества';
    }



    if($offer_desc->gf('deal_type') == 2){
        $deal = '-П';
    }elseif($offer_desc->gf('deal_type') == 3){
        $deal = '-О';
    }else{
        $deal = '-А';
    }


    //$id_line= '<br><br>ID '.$offer_desc->gf('object_id').$deal.'</b>';
    $id_line= '<br><br>ID '.$offer_desc->getField('visual_id').'</b>';


    $purp_line = '<br>На объекте возможно организовать: ';
    $purposes = $offer_desc->getJsonField('purposes');
    foreach($purposes as $purpose){
        $obj = new Post($purpose);
        $obj->getTable('l_purposes');

        $purp_line.= mb_strtolower($obj->title()).', ';
    }

    $purp_line = trim(trim($purp_line),',').'.';  





    //собираем все вместе))
$desc =
"
$intro $objType $objClass - $objAreaAll $objVolume $land_intro
Объект находится $line_loc 
$line_proj
$line_business   
     
$communication_line
$entrance_line 
     
$price_cond
$purp_line   
$id_line    
";


    echo $desc;

    //echo $purp_line;

    //if(!$no_id){

    //echo $id_line;
    //}



    echo '<br>';
    echo '<br>';
}


