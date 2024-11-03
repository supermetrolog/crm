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

$offres_arr = [
    'АРЕНДА - ЗДАНИЕ лот первый'=>1165,
    'АРЕНДА - ЗДАНИЕ лот второй'=>1166,
    'ПРОДАЖА - ЗДАНИЕ лот третий'=>1167,
    'ОТВЕТКА - ЗДАНИЕ лот четвертый'=>1168,
    'АРЕНДА - УЧАСТОК лот пятый'=>1232,
    'ПРОДАЖА - УЧАСТОК лот шестой'=>1240,
    //'ОТВЕТКА - УЧАСТОК лот 3132'=>1368,
];

//1713 - аренда здание 1368 продажа здание

foreach($offres_arr as $key=>$value){

    echo '<br><b>'.$key.'</b><br>';
    $offer = new OfferMix($value);


    //вступление
    $intro = $intro_arr[$offer->gf('deal_type') - 1][random_int(0, count($intro_arr[$offer->gf('deal_type') - 1]) - 1 )];



    //раздел про местоположение
    $region = $offer->gf('region');
    $direction = mb_strtolower($offer->gf('direction'));
    $town = mb_convert_case($offer->gf('town'),MB_CASE_TITLE, "UTF-8");
    $district = $offer->gf('district');
    $highway = $offer->gf('highway');
    $from_mkad = $offer->gf('from_mkad');

    ($offer->gf('metro')) ? $objMetro='Ближайшее метро '.mb_convert_case($offer->gf('metro'),MB_CASE_TITLE, "UTF-8") : $objMetro='' ;
    ($offer->gf('from_metro_time')) ? $objMetroTime=', '.$offer->gf('from_metro_time').' мин ' : $objMetroTime='' ;
    ($offer->gf('from_metro_way')) ? $objMetroWay=$offer->gf('from_metro_way').'ом ' : $objMetroWay='' ;

    ($offer->gf('railway_station')) ? $objStation='Ж/Д станция - '.$offer->gf('railway_station') : $objStation='' ;
    ($offer->gf('railway_station_time')) ? $objStationTime=', '.$offer->gf('railway_station_time').' мин ' : $objStationTime='' ;
    ($offer->gf('railway_station_way')) ? $objStationWay=$offer->gf('railway_station_way') : $objStationWay='' ;
    if($region == 'московская область'){
        $line_loc = "на $direction".'е Московской области, '.$town.", в $from_mkad км от МКАД. $objStation $objStationTime". mb_strtolower($objStationWay);
    }else{
        $district = $offer->gf('district');
        $line_loc = "в $district Москвы $objMetro $objMetroTime ". mb_strtolower($objMetroWay).'. ';

    }



    //раздел про проект
    $line_proj = '';
    if($offer->gf('built_to_suit')){

        if($offer->gf('deal_type') == 2){
            $projType = 'Built-to-suit';
        }else{
            $projType = 'Built-to-rent';
        }
        $line_proj .= "Проект $projType  ";
        if($offer->gf('built_to_suit_time')){
            $time = $offer->gf('built_to_suit_time');
            $line_proj .= ", строительство гарантировано за $time месяцев";
        }
        if($offer->gf('built_to_suit_plan')){
            $line_proj .= ", проект имеется";
        }

    }



    //раздел про бизнес
    $line_business = '';
    if($offer->gf('deal_type') == 2 && $offer->gf('rent_business')){
        $line_business = '<br><br>Объект продается с арендным бизнесом. ';
        if($offer->gf('rent_business_fill') ){
            $fill = $offer->gf('rent_business_fill') ;
            $line_business.= "Объект заполнен на $fill %. ";
        }
        if($offer->gf('rent_business_long_contracts') ){
            $long = $offer->gf('rent_business_long_contracts') ;
            $line_business.= "Долгосрочных контарктов -  $long %. ";
        }
        if($offer->gf('rent_business_payback') ){
            $payback = $offer->gf('rent_business_payback') ;
            $line_business.= "Предварительный срок окупаемости -  $payback лет. ";
        }
        $line_business.= 'Данные по средней ставке аренды, показатель EBITDA и чистые потоки предоставляются по запросу. ';
        if($offer->gf('sale_company') ){
            $payback = $offer->gf('rent_business_payback') ;
            $line_business.= "Возможна продажа юридического лица. ";
        }

    }

    //параграф про деление
    $parts_line = '';
    if($offer->gf('deal_type') == 2) {
        $parts_line.='<br><br>';
        if($offer->gf('area_min') != $offer->gf('area_max')){
            if($offer->gf('is_land')){
                $parts_line.= "Возможна продажа участка частями от ".$offer->gf('area_min')." м<sup>2</sup>";
            }else{
                $parts_line.= "Возможна продажа складского комплекса частями от ".$offer->gf('area_min')." м<sup>2</sup>";
            }
        }else{
            if($offer->gf('is_land')){
                $parts_line.= "Продажа земельного учкастка частями не предполагается";
            }else{
                $parts_line.= "Продажа складского комплекса частями не предполагается";
            }
        }
    }elseif($offer->gf('deal_type') == 3){
        $parts_line.='<br><br>';
        if($offer->gf('area_min') != $offer->gf('area_max')){
            $parts_line.= "Присутствует зонирование по блокам. Минимальный объем хранения в блоках от ".$offer->gf('pallet_place_min')." п.м.";
        }else{
            $parts_line.= "Зонирования по блокам нет";
        }
    }else{
        $parts_line.='<br><br>';
        if($offer->gf('area_min') != $offer->gf('area_max')){
            if($offer->gf('is_land')){
                $parts_line.= "Возможно деление участка от ".$offer->gf('area_min')." м<sup>2</sup>";
            }else{
                $parts_line.= "Возможно деление складского комплекса от ".$offer->gf('area_min')." м<sup>2</sup>";
            }
        }else{
            if($offer->gf('is_land')){
                $parts_line.= "Деление земельного учкастка не предполагается";
            }else{
                $parts_line.= "Деление складского комплекса не предполагается";
            }
        }

    }

    //echo 2222;

    //остальные параметры первого абзаца
    ($offer->gf('is_land')) ? $objType='земельный участок' : $objType='складской комплекс' ;
    ($offer->gf('class')) ? $objClass='категории '.$offer->gf('class') : $objClass='' ;
    ($offer->gf('area_max')) ? $objArea=$offer->gf('area_max') : $objArea='' ;
    ($offer->gf('pallet_place_max')) ? $objVolume='Общая вместимость '.$offer->gf('pallet_place_max').' п.м.' : $objVolume='' ;

    $land_intro ='';
    if($offer->gf('is_land')  || $offer->gf('deal_type') == 2){
        ($offer->gf('land_category')) ? $objCategory='Категория :'.mb_strtolower($offer->gf('land_category')).'. ' : $objCategory='' ;
        ($offer->gf('own_type_land')) ? $objOwnType='Право: '.mb_strtolower($offer->gf('own_type_land')).'. '  : $objOwnType='' ;
        ($offer->gf('land_use_restrictions')) ? $objRestriction='Есть ограничения. '  : $objRestriction='Ограничения отсутствуют' ;
        $land_intro.=$objCategory.$objOwnType.$objRestriction;
    }



    //echo 333;


    //echo 4444;
    $main_line = '<br><br>';
    if($offer->gf('type_id') == 2){
        $blocks = $offer->getJsonField('blocks');
    }else{
        $blocks = [$offer->gf('id')];
    }
    foreach($blocks as $block){
        $offer_block = new OfferMix($block);
        ($offer_block->gf('area_min')) ? $objArea='Свободная площадь '.valuesCompare($offer_block->gf('area_min'),$offer_block->gf('area_max')). ' м.кв. ' : $objArea='' ;
        ($offer_block->gf('area_mezzanine_min')) ? $objMezz=', из них мезонан '.valuesCompare($offer_block->gf('area_mezzanine_min'),$offer_block->gf('area_mezzanine_max')). ' м.кв. ' : $objMezz='' ;
        ($offer_block->gf('area_office_min')) ? $objOffice='. Офисные помещения '.valuesCompare($offer_block->gf('area_office_min'),$offer_block->gf('area_office_max')). ' м.кв. ' : $objOffice='' ;
        ($offer_block->gf('area_office_add')) ? $objOfficeAdd='обязателны к аренде' : $objOfficeAdd=' по желанию ' ;
        ($offer_block->gf('area_office_add')) ? $objMezzAdd='обязателны к аренде' : $objMezzAdd=' по желанию ' ;
        ($offer_block->gf('land_width') && $offer_block->gf('is_land')) ? $objMeasure='Габариты участка '.$offer_block->gf('land_width').'x'.$offer_block->gf('land_length').' м. ' : $objMeasure='' ;
        ($offer_block->gf('landscape_type') && $offer_block->gf('is_land')) ? $objLandscape='Рельеф участка: '.mb_strtolower($offer_block->gf('landscape_type'))  : $objLandscape='' ;
        ($offer_block->gf('temperature_min')) ? $objTemp=' Температурный режим от '.$offer_block->gf('temperature_min')  : $objTemp='' ;
        ($offer_block->gf('temperature_max')) ? $objTemp.=' до '.$offer_block->gf('temperature_max')  : '' ;
        ($offer_block->gf('temperature_min')) ? $objTemp.=' C '  : '' ;
        ($offer_block->gf('ceiling_height_min')) ? $objHeight=', высота потолков '.valuesCompare($offer_block->gf('ceiling_height_min'),$offer_block->gf('ceiling_height_max')). ' м. ' : $objHeight='' ;
        ($offer_block->gf('floor_type')) ? $objFloorType=',  покрытие - '.$offer_block->gf('floor_type')  : $objFloorType='' ;
        ($offer_block->gf('cross_docking')) ? 'Кросс-докинг'  : '' ;
        ($offer_block->gf('load_floor_min')) ? $objLoadFloor=' Нагрузка на пол '.valuesCompare($offer_block->gf('load_floor_min'),$offer_block->gf('load_floor_max')).' т/м.кв.'  : $objLoadFloor='' ;
        ($offer_block->gf('load_mezzanine_min')) ? $objLoadMezz=' Нагрузка на мезонин '.valuesCompare($offer_block->gf('load_mezzanine_min'),$offer_block->gf('load_mezzanine_max')).' т/м.кв.'  : $objLoadMezz='' ;
        ($offer_block->gf('cross_docking')) ? $objFloorType='Кросс-докинг'  : $objFloorType='' ;
        $main_line.= $objArea.
            $objMezz.
            $objMeasure.
            $objLandscape.
            $objTemp.
            $objHeight.
            $objFloorType.
            $objLoadFloor.
            $objLoadMezz.
            $objOffice
        ;
        $main_line.= '<br><br>';

    }









    //раздел КОММУНИКАЦИЙ
    $communication_line ='<br>ТУ, коммуникации и безопасность: ';
    ($offer->gf('power')) ? $objPower=$offer->gf('power').'кВт, ' : $objPower='' ;
    ($offer->gf('gas')) ? $objGas='ГАЗ, ' : $objGas='' ;
    ($offer->gf('steam')) ? $objSteam='ПАР, ' : $objSteam='' ;
    ($offer->gf('water')) ? $objWater='вода, ' : $objWater='' ;
    ($offer->gf('sewage_central')) ? $objSewage='канализация, ' : $objSewage='' ;
    ($offer->gf('ventilation')) ? $objVent=$offer->gf('ventilation').' вентиляция, ' : $objVent='' ;
    ($offer->gf('fire_alert')) ? $objFireAlert='пожарная сигнализация, ' : $objFireAlert='' ;
    ($offer->gf('smoke_exhaust')) ? $objSmoke='дымоудаление, ' : $objSmoke='' ;
    ($offer->gf('firefighting')) ? $objFireFight=$offer->gf('firefighting').', ' : $objFireFight='' ;
    ($offer->gf('video_control')) ? $objVideoControl='видеонаблюдение, ' : $objVideoControl='' ;
    ($offer->gf('security_alert')) ? $objSecurityAlert='охранная сигнализация, ' : $objSecurityAlert='' ;
    ($offer->gf('access_control')) ? $objAccessControl='контроль доступа на территорию, ' : $objAccessControl='' ;
    ($offer->gf('phone')) ? $objPhone='телефония, ' : $objPhone='' ;
    ($offer->gf('internet')) ? $objInternet='и интернет, ' : $objInternet='' ;


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
    $entrance_line ='<br><br> ';
    ($offer->gf('guard')) ? $objGuard='Обьект под охраной '.$offer->gf('guard').'. ' : $objGuard='' ;
    ($offer->gf('entry_territory')) ? $objEntry=$offer->gf('entry_territory').' вьезд на территорию. ' : $objEntry='' ;

    $parking_line = '';
    if($offer->gf('parking_car') ||  $offer->gf('parking_lorry') || $offer->gf('parking_truck')){
        $parking_line = 'Парковка: ';
        if($offer->gf('parking_truck')){
            $parking_line.= 'для а/м от 10т';
            if($offer->gf('parking_truck_value')){
                $parking_line.= ' - '.mb_strtolower($offer->gf('parking_truck_value'));
            }
            $parking_line.= ', ';
        }
        if($offer->gf('parking_lorry')){
            $parking_line.= 'для а/м от 5-10т';
            if($offer->gf('parking_lorry_value')){
                $parking_line.= ' - '.mb_strtolower($offer->gf('parking_lorry_value'));
            }
            $parking_line.= ', ';
        }
        if($offer->gf('parking_car')){
            $parking_line.= 'для легковых а/м ';
            if($offer->gf('parking_car_value')){
                $parking_line.= ' - '.mb_strtolower($offer->gf('parking_car_value'));
            }
            $parking_line.= ', ';
        }
    }
    ($offer->gf('hostel')) ? $objHostel='общежитие, ' : $objHostel='' ;
    ($offer->gf('canteen')) ? $objCanteen='столовая, ' : $objCanteen='' ;
    ($offer->gf('railway')) ? $objRailway='действующая Ж/Д ветка, ' : $objRailway='' ;
    ($offer->gf('cranes_railway_num')) ? $objRailCranes='Ж/Д краны, ' : $objRailCranes='' ;
    ($offer->gf('cranes_gantry_num')) ? $objGantryCranes='козловые краны, ' : $objGantryCranes='' ;

    $has_line = '<br><br> ';
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
    $price_line = '<br><br>';
    if($offer->gf('deal_type') == 2){
        $price_min = $offer->gf('price_sale_min');
        $price_max = $offer->gf('price_sale_max');
        $price_min_all = $offer->gf('price_sale_min_all');
        $price_max_all = $offer->gf('price_sale_max_all');
        $price_line.= 'Стоимость объекта '. valuesCompare($price_min_all,$price_max_all).'  руб  ('.valuesCompare($price_min,$price_max).' руб. за м2)' ;
    }elseif($offer->gf('deal_type') == 3){
        $price_line.= 'Перечень оказываемых услуг ответственного хранения с подробными ценами предоставляем по запросу';
    }else{
        $price_line.='Ставка аренды: ';
        $price_line.= "<br>- ";
        $price_min = $offer->gf('price_floor_min');
        $price_max = $offer->gf('price_floor_max');
        if($offer->gf('is_land')){
            $price_line.= 'открытая площадь ';
        }else{
            $price_line.= 'пол ';
        }
        $price_line.= valuesCompare($price_min,$price_max).' руб. м2/год';
        if($offer->gf('price_mezzanine_min')){
            $price_mezzanine_min = $offer->gf('price_mezzanine_min');
            $price_mezzanine_max = $offer->gf('price_mezzanine_max');
            $price_line.= '<br>- мезонин '. valuesCompare($price_mezzanine_min,$price_mezzanine_max).'  руб. м2/год';
        }
        if($offer->gf('price_office_min')){
            $price_office_min = $offer->gf('price_office_min');
            $price_office_max = $offer->gf('price_office_max');
            $price_line.= '<br>- офисы '. valuesCompare($price_office_min,$price_office_max).'  руб. м2/год';
        }

        if($offer->gf('price_opex_min') || $offer->gf('price_public_services_min')){



            $price_line.= '<br> Дополнительно оплачивается  ';
            if($offer->gf('price_opex_min')){
                $price_opex = $offer->gf('price_opex_min');
                $price_line.= 'OPEX';
                if($offer->gf('price_opex_min') != $offer->gf('price_opex_max')){
                    $price_line.= ' от ';
                }
                $price_line.= $price_opex.' руб. м2/год';
            }

            if($offer->gf('price_public_services_min')){
                $price_services = $offer->gf('price_public_services_min');
                $price_line.= ', КУ';
                if($offer->gf('price_public_services_min') != $offer->gf('price_public_services_max')){
                    $price_line.= ' от ';
                }
                $price_line.= $price_services.' руб. м2/год';
            }


        }
    }

    $price_line.= '<br><br>Планы БТИ и дополнительную информацию отправим по запросу';

    if($offer->gf('deal_type') == 2){
        $deal = '-П';
    }elseif($offer->gf('deal_type') == 3){
        $deal = '-О';
    }else{
        $deal = '-А';
    }
    $price_line.= '<br><br><b>ID '.$offer->gf('object_id').$deal.'</b>';






    //собираем все вместе))
    $desc =
        "
    $intro 
    $objType 
    $objClass - $objArea м кв.
     $objVolume. $land_intro.
     Объект находится $line_loc 
     $line_proj
     
     
     $line_business    
     <br>
     $parts_line
     
     $main_line
     
     $communication_line
     
     $entrance_line
     
     
     $price_line
    ";


    echo $desc;

    echo '<br>';
    echo '<br>';
}



echo 1111;
