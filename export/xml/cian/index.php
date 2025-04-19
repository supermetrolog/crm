
<?php

//ini_set('error_reporting', E_ALL);ini_set('display_errors', 1);ini_set('display_startup_errors', 1);
include_once($_SERVER['DOCUMENT_ROOT'] . '/global_pass.php');


$start = microtime(true);


$blocks_count = 0;
$objects_count = 0;



//Создает XML-строку и XML-документ при помощи DOM
$dom = new DomDocument('1.0', 'UTF-8');

//добавление корня - <books>
$feed = $dom->appendChild($dom->createElement('feed'));

//добавление элемента <$feed_version> в <$feed>
$feed_version = $feed->appendChild($dom->createElement('feed_version'));
$feed_version->appendChild($dom->createTextNode('2'));


$table = 'c_industry_offers_mix';

$blocklist = [
    2264,
    1731,
    2945,
    2095,
    834,
    3119,
    2398,
    2047,
    3173,
    2923,
    3147,
    10381,
    2070,
    1146,
    1833,
    2452,
    3202,
    3226,
    2398,
    2875,
    2187,
    3292,
    10403,
    10312,
    10270,
    3270,
    2084,
    2382,
    1989,
    9,
    263,
    10334,
    2469,
    2887,
    2363,
    2526,
    3346,
    120,
    1750,
    504,
    10382,
    1632,
    10419,
    2519,
];

$blocklist_str = implode(',', $blocklist);


$sql_text = "SELECT * FROM $table WHERE deal_type!=3 AND type_id IN (1) AND ad_cian=1  AND  deleted!=1 AND hide_from_market !=1  AND status=1 AND (price_floor_min > 0 OR  price_sale_min > 0)  AND test_only!=1 AND photos!='[\"[]\"]'   ";
//$sql = $pdo->prepare("SELECT * FROM $table WHERE deleted!='1' AND ad_cian=1 AND status=1 AND is_land!=1 AND (deal_type=1 OR deal_type=4 OR object_id=196) ");
$sql = $pdo->prepare($sql_text);
echo  $sql_text;
$sql->execute();
while ($offer = $sql->fetch(PDO::FETCH_LAZY)) {

    $object_building = new Building($offer->object_id);

    //добавление элемента <object> в <$feed>
    $object = $feed->appendChild($dom->createElement('object'));

    //КАТЕГОРИЯ ОБЪЯВЛЕНИЯ
    $Category = $object->appendChild($dom->createElement('Category'));
    $object_types = json_decode($offer->object_type);
    $arr_types = [
        '1' => 'warehouse',
        '2' => 'industry',
        '3' => 'commercialLand',
    ];
    $arr_deals = [
        '1' => 'Rent',
        '2' => 'Sale',
        '3' => 'Rent',
        '4' => 'Rent',
    ];
    $type = min($object_types);
    $deal = $offer->deal_type;
    $Category->appendChild($dom->createTextNode($arr_types[$type] . $arr_deals[$deal]));

    //ВНУТРЕННИЙ ID БЛОУВ И ОБЪЕКТА
    $ExternalId = $object->appendChild($dom->createElement('ExternalId'));
    $objectId = $offer->object_id;
    $visualId = $offer->visual_id;
    if (in_array($objectId, [10607])) {
        $visualId .= '-new';
    }
    $ExternalId->appendChild($dom->createTextNode($visualId));

    if ($offer->is_land) {
        $prop_type = 'land';
    } elseif (in_array(2, json_decode($offer->object_type))) {
        $prop_type = 'industry';
    } else {
        $prop_type = 'warehouse';
    }

    $PropType = $object->appendChild($dom->createElement('PropertyType'));
    $PropType->appendChild($dom->createTextNode($prop_type));
    // Продается складской комплекс категории B - 3830 м. кв.  Ограничения отсутствуют
    // Объект находится в  Москвы Ближайшее метро Нагатинская  .  



    // ТУ, коммуникации и безопасность: 100кВт, охранная сигнализация, контроль доступа на территорию, и интернет, 
    // Обьект под охраной (ЧОП). Парковка: для а/м от 10т, На территории есть столовая,  

    //  Планы БТИ и дополнительную информацию отправим по запросу
    // На объекте возможно организовать: сборочное пр-во, автосервис/мойка, швейное.   
    // ID 140-П-1   
    //ОПИСАНИЕ
    $Description = $object->appendChild($dom->createElement('Description'));
    $original_id = $offer->original_id;
    $original_type = $offer->type_id;

    //получить результат файла в переменную
    ob_start();
    include($_SERVER['DOCUMENT_ROOT'] . "/autodesc.php");
    $desc = ob_get_clean();

    if ($offer->type_id == 1) {
        $block_sql = "SELECT * FROM c_industry_blocks WHERE id = " . $offer->original_id;
        /** @var \PDO $pdo */
        $stmt = $pdo->prepare($block_sql);
        $stmt->execute();
        $offerBlock = $stmt->fetchObject();
        if ($offerBlock && $offerBlock->description_manual_use) {
            $desc = $offerBlock->description;
        }
    }



    //$desc = exec($_SERVER['DOCUMENT_ROOT']."/autodesc.php");
    $Description->appendChild($dom->createTextNode(strip_tags($desc)));

    //АДРЕС СОГЛАСНО ЯНДЕКС КАРТ
    $Address = $object->appendChild($dom->createElement('Address'));
    $Address->appendChild($dom->createTextNode($offer->address));

    //КООРДИНАТЫ
    $Coordinates = $object->appendChild($dom->createElement('Coordinates'));
    $Lat = $Coordinates->appendChild($dom->createElement('Lat'));
    $Lat->appendChild($dom->createTextNode($offer->latitude));

    $Lng = $Coordinates->appendChild($dom->createElement('Lng'));
    $Lng->appendChild($dom->createTextNode($offer->longitude));


    //КАДАСТРОВЫЕ НОМЕРА
    if ($offer->cadastral_number || $offer->cadastral_number_land) {

        $CadastralNumber = $object->appendChild($dom->createElement('CadastralNumber'));
        if ($offer->is_land) {
            $CadastralNumber->appendChild($dom->createTextNode($offer->cadastral_number_land));
        } else {
            $CadastralNumber->appendChild($dom->createTextNode($offer->cadastral_number));
        }
    }


    //ТЕЛЕФОНЫ
    $Phones = $object->appendChild($dom->createElement('Phones'));
    $PhoneSchema = $Phones->appendChild($dom->createElement('PhoneSchema'));
    $CountryCode = $PhoneSchema->appendChild($dom->createElement('CountryCode'));
    $CountryCode->appendChild($dom->createTextNode('+7'));

    $Number = $PhoneSchema->appendChild($dom->createElement('Number'));
    //$Number->appendChild($dom->createTextNode('9265356912'));
    $Number->appendChild($dom->createTextNode('4951500323'));


    //ШОССЕ И РАССТОЯНИЕ ОТ МКАД
    if ($offer->highway || $offer->from_mkad) {
        $Highway = $object->appendChild($dom->createElement('Highway'));
    }


    if ($offer->highway) {

        $Id = $Highway->appendChild($dom->createElement('Id'));

        $highway_cian = $offer->highway;
        $sql1 = $pdo->prepare("SELECT * FROM l_highways_cian WHERE title='$highway_cian'");
        $sql1->execute();
        $highway_info = $sql1->fetch(PDO::FETCH_LAZY);

        $Id->appendChild($dom->createTextNode($highway_info->id));
    }

    if ($offer->from_mkad) {
        $Distance = $Highway->appendChild($dom->createElement('Distance'));
        $Distance->appendChild($dom->createTextNode($offer->from_mkad));
    }





    //МЕТРО
    if ($offer->metro) {
        $Undergrounds = $object->appendChild($dom->createElement('Undergrounds'));

        $UndergroundInfoSchema = $Undergrounds->appendChild($dom->createElement('UndergroundInfoSchema'));
        $Id = $UndergroundInfoSchema->appendChild($dom->createElement('Id'));

        $metro_cian = $offer->metro;
        $sql2 = $pdo->prepare("SELECT * FROM l_metros_cian WHERE title='$metro_cian'");
        $sql2->execute();
        $metro_info = $sql2->fetch(PDO::FETCH_LAZY);
        $Id->appendChild($dom->createTextNode($metro_info->id));

        if ($offer->from_metro_value) {
            $Time = $UndergroundInfoSchema->appendChild($dom->createElement('Time'));
            $Time->appendChild($dom->createTextNode($offer->from_metro_value));
        }


        if ($offer->from_metro) {
            $arr_transport_metro = [
                '1' => 'walk',
                '2' => 'transport',
            ];
            $TransportType = $UndergroundInfoSchema->appendChild($dom->createElement('TransportType'));
            $TransportType->appendChild($dom->createTextNode($arr_transport_metro[$offer->from_metro]));
        }
    }


    //ДАТА ОСВОБОЖДЕНИЯ
    $availableFrom = $object->appendChild($dom->createElement('AvailableFrom'));
    if ($offer->available_from) {
        if (time() > $offer->available_from) {
            $av_time = 'свободен';
        } else {
            $av_time = 'освобождается ' . date('d/m/Y', $offer->available_from);
        }
    } else {
        $av_time = 'свободен';
    }
    $availableFrom->appendChild($dom->createTextNode($av_time));

    //ТИП СОБСТВЕННОСТИ
    $estateType = $object->appendChild($dom->createElement('EstateType'));
    if ($offer->is_land) {
        $ownType = $offer->own_type_land;
    } else {
        $ownType = $offer->own_type;
    }
    if ($ownType == 'Собственность') {
        $cian_own_type = 'owned';
    } else {
        $cian_own_type = 'rent';
    }
    $estateType->appendChild($dom->createTextNode($cian_own_type));




    //ОБЩАЯ ПЛОЩАДЬ
    $TotalArea = $object->appendChild($dom->createElement('TotalArea'));
    $TotalArea->appendChild($dom->createTextNode($offer->area_max));

    //МИНИМАЛЬНАЯ ПЛОЩАДЬ
    /*
    $MinArea = $object->appendChild($dom->createElement('MinArea'));
    $min_area = $offer->area_floor_min;
    $MinArea->appendChild($dom->createTextNode($min_area));
    */

    if ($offer->tax_form == 'с ндс') {
        $vat_inc = 'true';
        $VatType_value = 'included';
    } elseif ($offer->tax_form == 'без ндс') {
        $vat_inc = 'false';
        $VatType_value = 'notIncluded';
    } elseif ($offer->tax_form == 'triple net') {
        $vat_inc = 'false';
        $VatType_value = 'notIncluded';
    } elseif ($offer->tax_form == 'усн') {
        $vat_inc = 'false';
        $VatType_value = 'usn';
    } else {
    }



    if ($offer->area_floor_min != $offer->area_floor_max) {

        $isRentByParts = $object->appendChild($dom->createElement('IsRentByParts'));
        $isRentByParts->appendChild($dom->createTextNode(true));

        $AreaParts = $object->appendChild($dom->createElement('AreaParts'));


        //Если блоки есть то минимальный для общего не выгружаем ибо будут дублироваться с теми что внутри
        $blocks_inside_id = json_decode($offer->blocks);
        if (arrayIsNotEmpty($blocks_inside_id)) {
            foreach ($blocks_inside_id  as $id) {
                $block_inside = new OfferMix((int)$id);

                if ($block_inside->getField('deal_id') == 0 && $block_inside->getField('deleted') != 1) {
                    $RentByPartsSchema = $AreaParts->appendChild($dom->createElement('RentByPartsSchema'));
                    $Area = $RentByPartsSchema->appendChild($dom->createElement('Area'));
                    $Area->appendChild($dom->createTextNode($block_inside->getField('area_max')));

                    $Price = $RentByPartsSchema->appendChild($dom->createElement('Price'));
                    $Price->appendChild($dom->createTextNode($block_inside->getField('price_floor_max')));

                    $VatPrice = $RentByPartsSchema->appendChild($dom->createElement('VatPrice'));
                    $VatPrice->appendChild($dom->createTextNode(0)); //хз чо писать
                }
            }
            //иначе вывожу мин для общего
        } else {
            $RentByPartsSchema = $AreaParts->appendChild($dom->createElement('RentByPartsSchema'));
            $Area = $RentByPartsSchema->appendChild($dom->createElement('Area'));
            $Area->appendChild($dom->createTextNode($offer->area_min));

            $Price = $RentByPartsSchema->appendChild($dom->createElement('Price'));
            $Price->appendChild($dom->createTextNode($offer->price_floor_max));

            $VatPrice = $RentByPartsSchema->appendChild($dom->createElement('VatPrice'));
            $VatPrice->appendChild($dom->createTextNode(0)); //хз чо писать
        }
    }


    //ЭТАЖ
    $FloorNumber = $object->appendChild($dom->createElement('FloorNumber'));
    $floor_min = $offer->floor_min;
    if (!$floor_min) {
        $floor_min = $offer->floor_max;
    }
    $FloorNumber->appendChild($dom->createTextNode($floor_min));

    //СОСТОЯНИЕ
    $ConditionType = $object->appendChild($dom->createElement('ConditionType'));
    $ConditionType->appendChild($dom->createTextNode('typical'));


    //БРОКЕР
    /*
    $SubAgent = $object->appendChild($dom->createElement('SubAgent'));

    $agent = new Member($offer->agent_id);

    $Email = $SubAgent->appendChild($dom->createElement('Email'));
    $Email->appendChild($dom->createTextNode($agent->getJsonField('emails')[0]));

    $Phone = $SubAgent->appendChild($dom->createElement('Phone'));
    $Phone->appendChild($dom->createTextNode($agent->getJsonField('phones')[0]));

    $FirstName = $SubAgent->appendChild($dom->createElement('FirstName'));
    $FirstName->appendChild($dom->createTextNode($agent->getField('first_name')));

    $LastName = $SubAgent->appendChild($dom->createElement('LastName'));
    $LastName->appendChild($dom->createTextNode($agent->getField('last_name')));
    */

    /*

    //ПЛАНИРОВКА
    //$Layout = $object->appendChild($dom->createElement('Layout'));
    //$Layout->appendChild($dom->createTextNode('cabinet'));

    //$LayoutPhoto = $object->appendChild($dom->createElement('LayoutPhoto'));
    //$FullUrl = $LayoutPhoto->appendChild($dom->createElement('FullUrl'));
    //$FullUrl->appendChild($dom->createTextNode('http://example.com/flat1.jpg'));

    //$IsDefault = $LayoutPhoto->appendChild($dom->createElement('IsDefault'));
    //$IsDefault->appendChild($dom->createTextNode('true'));

    */

    //ФОТОГРАФИИ ОБЪЕКТА
    $Photos = $object->appendChild($dom->createElement('Photos'));

    $photo_num = 0;
    $photos = json_decode($offer->photos);
    foreach ($photos as $photo) {

        $photo_num++;

        $photo_way_arr = explode('/', $photo);

        $name = array_pop($photo_way_arr);
        //$post = (int)array_pop($photo_way_arr);

        $post = (int)$offer->object_id;

        $PhotoSchema = $Photos->appendChild($dom->createElement('PhotoSchema'));
        $FullUrl = $PhotoSchema->appendChild($dom->createElement('FullUrl'));
        $FullUrl->appendChild($dom->createTextNode(PROJECT_URL . '/system/controllers/photos/watermark.php/1200/' . $post . '/' . $name . '?v=1'));

        $IsDefault = $PhotoSchema->appendChild($dom->createElement('IsDefault'));
        $IsDefault->appendChild($dom->createTextNode($photo_num == 1 ? 'true' : 'false'));
    }


    //ТИПЫ НАЗНАЧЕНИЙ
    $specialty = $object->appendChild($dom->createElement('Specialty'));
    $object_types = json_decode($offer->purposes);
    foreach ($object_types as $obj_type) {
        $obj_type = new Post($obj_type);
        $obj_type->getTable('l_purposes');
        $add_type = $specialty->appendChild($dom->createElement('AdditionalType'));
        $add_type->appendChild($dom->createTextNode($obj_type->title()));
    }




    //ТИП ПОЛА
    $FloorMaterialTypeType = $object->appendChild($dom->createElement('FloorMaterialTypeType'));
    $floor_arr = [
        'Асфальт' => 'asphalt',
        'Бетон' => 'concrete',
        'Антипыль' => 'selfLeveling',
        'стяжка' => 'reinforcedConcrete',
        'бет. плиты' => 'concrete ',
        'тех. плитка' => 'tile',
        'разные' => 'selfLeveling',
    ];
    $FloorMaterialTypeType->appendChild($dom->createTextNode($floor_arr[$offer->floor_type]));

    //$IsLegalAddressProvided = $object->appendChild($dom->createElement('IsLegalAddressProvided'));
    //$IsLegalAddressProvided->appendChild($dom->createTextNode('cabinet'));

    //$WaterPipesCount = $object->appendChild($dom->createElement('WaterPipesCount'));
    //$WaterPipesCount->appendChild($dom->createTextNode('cabinet'));

    //$TaxNumber = $object->appendChild($dom->createElement('TaxNumber'));
    //$TaxNumber->appendChild($dom->createTextNode('cabinet'));

    //$IsInHiddenBase = $object->appendChild($dom->createElement('IsInHiddenBase'));
    //$IsInHiddenBase->appendChild($dom->createTextNode('cabinet'));

    //$BusinessShoppingCenter = $object->appendChild($dom->createElement('BusinessShoppingCenter'));
    //$Id = $BusinessShoppingCenter->appendChild($dom->createTextNode('Id'));
    //$Id->appendChild($dom->createTextNode('true'));

    //ВИДЕО
    if (count($videos = json_decode($offer->videos)) > 0 && arrayIsNotEmpty(json_decode($offer->videos))) {
        $Videos = $object->appendChild($dom->createElement('Videos'));
        foreach ($videos as $video) {
            $VideoSchema = $Videos->appendChild($dom->createElement('VideoSchema'));
            $Url = $VideoSchema->appendChild($dom->createElement('Url'));
            $Url->appendChild($dom->createTextNode($video));
        }
    }




    $Title = $object->appendChild($dom->createElement('title'));
    if (in_array(1, $object_types) && in_array(2, $object_types)) {
        $title_first = 'ПСК  ';
    } elseif (in_array(2, $object_types)) {
        $title_first = 'Производство ';
    } else {
        $title_first = 'Склад ';
    }
    $min_area = $offer->area_min;
    $title_first = $title_first . $offer->area_max . 'м.кв.';

    $Title->appendChild($dom->createTextNode($title_first));

    //ЗДАНИЕ
    $Building = $object->appendChild($dom->createElement('Building'));


    $building_obj = new Building($offer->object_id);

    ($building_obj->getField('title')) ?  $title = $building_obj->getField('title') : $title = $building_obj->getField('address');

    //НАЗВАНИЕ ОБЬЕКТА
    $Name = $Building->appendChild($dom->createElement('Name'));
    $Name->appendChild($dom->createTextNode($title));

    //КОЛИЧЕСТВО ЭТАЖЕЙ
    $FloorsCount = $Building->appendChild($dom->createElement('FloorsCount'));
    $FloorsCount->appendChild($dom->createTextNode($offer->floor_max));


    //ГОД ПОСТРОЙКИ
    if ($building_obj->getField('year_build') > 0) {
        $BuildYear = $Building->appendChild($dom->createElement('BuildYear'));
        $BuildYear->appendChild($dom->createTextNode($building_obj->getField('year_build')));
    }

    //ОБЩАЯ ПЛОЩАДЬ ОБЪЕКТА
    $TotalArea = $Building->appendChild($dom->createElement('TotalArea'));
    $TotalArea->appendChild($dom->createTextNode($building_obj->getField('area_building')));


    //ОТОПЛЕНИЕ

    $HeatingType = $Building->appendChild($dom->createElement('HeatingType'));
    $heating_arr = [
        'Центральное' => 'central',
        'Автономное' => 'autonomous',
        'Холодное' => 'no',
    ];
    if ($heating_arr[$offer->heating]) {
        $heat_value = $heating_arr[$offer->heating];
    } else {
        $heat_value = 'no';
    }
    $HeatingType->appendChild($dom->createTextNode($heat_value));


    //ВЫСОТА ПОТОЛКОВ
    $CeilingHeight = $Building->appendChild($dom->createElement('CeilingHeight'));
    $CeilingHeight->appendChild($dom->createTextNode($offer->ceiling_height_max));



    //ПАРКОВКА
    $Parking = $Building->appendChild($dom->createElement('Parking'));

    //РАСПОЛОЖЕНИЕ ПАРКОВКИ -- ПОСТОЯННОЕ--
    $LocationType = $Parking->appendChild($dom->createElement('LocationType'));
    $LocationType->appendChild($dom->createTextNode('internal'));

    //ТИП ПАРКОВКИ (ЛЕГКОВАЯ ИЛИ ГРУЗОВАЯ)
    $PurposeType = $Parking->appendChild($dom->createElement('PurposeType'));

    if ($offer->parking_truck) {
        //echo "truck";
        $parkingPurposeType = 'cargo';
        $offer->parking_truck_value == 2 ? $isFree = 'true' : $isFree = 'false';
    } elseif ($offer->parking_car && !$offer->parking_truck) {
        $parkingPurposeType = 'passenger';
        $offer->parking_car_value == 2 ? $isFree = 'true' : $isFree = 'false';
        //echo "car";
    } else {
        $isFree = 'false';
        $parkingPurposeType = '';
    }

    $PurposeType->appendChild($dom->createTextNode($parkingPurposeType));

    //$PlacesCount = $Parking->appendChild($dom->createElement('PlacesCount'));
    //$PlacesCount->appendChild($dom->createTextNode('true'));

    //$PriceEntry = $Parking->appendChild($dom->createElement('PriceEntry'));
    //$PriceEntry->appendChild($dom->createTextNode('true'));

    //$Currency = $Parking->appendChild($dom->createElement('Currency'));
    //$Currency->appendChild($dom->createTextNode('true'));

    $IsFree = $Parking->appendChild($dom->createElement('IsFree'));
    $IsFree->appendChild($dom->createTextNode($isFree));

    //ТИП ОБЪЕКТА

    if (in_array(1, $object_types)) {
        $Type = $Building->appendChild($dom->createElement('Type'));
        $Type->appendChild($dom->createTextNode('warehouseComplex'));
    } elseif (in_array(2, $object_types)) {
        $Type = $Building->appendChild($dom->createElement('Type'));
        $Type->appendChild($dom->createTextNode('industrialComplex'));
    } else {
    }


    //КЛАСС ОБЪЕКТА
    $ClassType = $Building->appendChild($dom->createElement('ClassType'));
    $ClassType->appendChild($dom->createTextNode(strtolower($offer->class)));

    //$Developer = $Building->appendChild($dom->createElement('Developer'));
    //$Developer->appendChild($dom->createTextNode('5.4'));

    //$ManagementCompany = $Building->appendChild($dom->createElement('ManagementCompany'));
    //$ManagementCompany->appendChild($dom->createTextNode('5.4'));

    //СИСТЕМА ВЕНТИЛЯЦИИ
    $VentilationType = $Building->appendChild($dom->createElement('VentilationType'));
    $vent_arr = [
        'Естественная' => 'natural',
        'Приточно-вытяжная' => 'forced',
        '0' => 'no',
    ];
    $VentilationType->appendChild($dom->createTextNode($vent_arr[$offer->ventilation]));

    //$ConditioningType = $Building->appendChild($dom->createElement('ConditioningType'));
    //$ConditioningType->appendChild($dom->createTextNode('5.4'));

    //СИСТЕМА ПОЖАРОТУШЕНИЯ
    $ExtinguishingSystemType = $Building->appendChild($dom->createElement('ExtinguishingSystemType'));
    $fire_arr = [
        'Гидрантная система' => 'hydrant ',
        'Спринклерная система' => 'sprinkler',
        '0' => 'no',
        'Порошковая система' => 'powder',
        'Газовая система' => 'gas',
        'Огнетушители' => 'powder',
    ];
    $ExtinguishingSystemType->appendChild($dom->createTextNode($fire_arr[$offer->firefighting]));

    //ТИПЫ ЛИФТОВ
    $LiftTypes = $Building->appendChild($dom->createElement('LiftTypes'));
    $LiftTypeSchema = $LiftTypes->appendChild($dom->createElement('LiftTypeSchema'));



    if ($offer->elevators_num) {

        //ТИП ЛИФТА --ПОСТОЯННОЕ--
        $Type = $LiftTypeSchema->appendChild($dom->createElement('Type'));
        $Type->appendChild($dom->createTextNode('cargo'));

        //$AdditionalType = $LiftTypeSchema->appendChild($dom->createElement('AdditionalType'));
        //$AdditionalType->appendChild($dom->createTextNode('cargo'));

        //КОЛИЧЕСТВО ЛИФТОВ
        $Count = $LiftTypeSchema->appendChild($dom->createElement('Count'));
        $Count->appendChild($dom->createTextNode($offer->elevators_num));

        //ГРУЗОПОДЪЕМНОСТЬ
        $LoadCapacity = $LiftTypeSchema->appendChild($dom->createElement('LoadCapacity'));
        $LoadCapacity->appendChild($dom->createTextNode($offer->elevators_max));
    }

    //КАТЕГОРИЯ ЗАДНИЯ --ПОСТОЯННОЕ--
    $StatusType = $Building->appendChild($dom->createElement('StatusType'));
    $StatusType->appendChild($dom->createTextNode('operational'));



    //КРАНЫ
    $CranageTypes = $Building->appendChild($dom->createElement('CranageTypes'));


    if ($offer->cranes_gantry_num) {
        $CranageTypeSchema = $CranageTypes->appendChild($dom->createElement('CranageTypeSchema'));

        //ТИП КРАНА
        $Type = $CranageTypeSchema->appendChild($dom->createElement('Type'));
        $Type->appendChild($dom->createTextNode('gantry'));

        //ГРУЗОПОДЪЕМНОСТЬ
        $LoadCapacity = $CranageTypeSchema->appendChild($dom->createElement('LoadCapacity'));
        $LoadCapacity->appendChild($dom->createTextNode($offer->cranes_gantry_min));

        //КОЛИЧЕСТВО КРАНОВ
        $Count = $CranageTypeSchema->appendChild($dom->createElement('Count'));
        $Count->appendChild($dom->createTextNode($offer->cranes_gantry_num));
    }

    if ($offer->cranes_railway_num) {
        $CranageTypeSchema = $CranageTypes->appendChild($dom->createElement('CranageTypeSchema'));

        //ТИП КРАНА
        $Type = $CranageTypeSchema->appendChild($dom->createElement('Type'));
        $Type->appendChild($dom->createTextNode('railway'));

        //ГРУЗОПОДЪЕМНОСТЬ
        $LoadCapacity = $CranageTypeSchema->appendChild($dom->createElement('LoadCapacity'));
        $LoadCapacity->appendChild($dom->createTextNode($offer->cranes_railway_max));

        //КОЛИЧЕСТВО КРАНОВ
        $Count = $CranageTypeSchema->appendChild($dom->createElement('Count'));
        $Count->appendChild($dom->createTextNode($offer->cranes_railway_num));
    }

    if ($offer->cranes_cathead_num) {
        $CranageTypeSchema = $CranageTypes->appendChild($dom->createElement('CranageTypeSchema'));

        //ТИП КРАНА
        $Type = $CranageTypeSchema->appendChild($dom->createElement('Type'));
        $Type->appendChild($dom->createTextNode('beam'));

        //ГРУЗОПОДЪЕМНОСТЬ
        $LoadCapacity = $CranageTypeSchema->appendChild($dom->createElement('LoadCapacity'));
        $LoadCapacity->appendChild($dom->createTextNode($offer->cranes_cathead_max));

        //КОЛИЧЕСТВО КРАНОВ
        $Count = $CranageTypeSchema->appendChild($dom->createElement('Count'));
        $Count->appendChild($dom->createTextNode($offer->cranes_cathead_num));
    }



    if ($offer->cranes_overhead_num) {
        $CranageTypeSchema = $CranageTypes->appendChild($dom->createElement('CranageTypeSchema'));

        //ТИП КРАНА
        $Type = $CranageTypeSchema->appendChild($dom->createElement('Type'));
        $Type->appendChild($dom->createTextNode('overhead'));

        //ГРУЗОПОДЪЕМНОСТЬ
        $LoadCapacity = $CranageTypeSchema->appendChild($dom->createElement('LoadCapacity'));
        $LoadCapacity->appendChild($dom->createTextNode($offer->cranes_overhead_max));

        //КОЛИЧЕСТВО КРАНОВ
        $Count = $CranageTypeSchema->appendChild($dom->createElement('Count'));
        $Count->appendChild($dom->createTextNode($offer->cranes_overhead_num));
    }




    //ТИП ВОРОТ
    $GatesType = $Building->appendChild($dom->createElement('GatesType'));
    $gates_arr = [
        'на нулевом уровне' => 'atZero',
        'докового типа' => 'dockType',
        'авторампа' => 'onRamp',
        'Ж/Д рампа' => 'onRamp',
    ];
    $GatesType->appendChild($dom->createTextNode($gates_arr[$offer->gate_type]));


    //СЕТКА КОЛОНН
    if ($offer->column_grid) {
        $ColumnGrid = $Building->appendChild($dom->createElement('ColumnGrid'));
        $ColumnGrid->appendChild($dom->createTextNode($offer->column_grid));
    }



    //ИНФРАСТРУКТУРА
    $Infrastructure = $Building->appendChild($dom->createElement('Infrastructure'));

    //ЕСТЬ ЛИ БУФФЕТ
    $HasBuffet = $Infrastructure->appendChild($dom->createElement('HasBuffet'));
    $HasBuffet->appendChild($dom->createTextNode($offer->canteen));

    //ЕСТЬ ЛИ СТОЛОВАЯ
    $HasCanteen = $Infrastructure->appendChild($dom->createElement('HasCanteen'));
    $HasCanteen->appendChild($dom->createTextNode($offer->canteen));

    //ЕСТЬ ЛИ ЦЕНТРАЛЬНАЯ РЕЦЕПЦИЯ
    //$HasCentralReception = $Infrastructure->appendChild($dom->createElement('HasCentralReception'));
    //$HasCentralReception->appendChild($dom->createTextNode('true'));

    //ЕСТЬ ЛИ ОБЩЕЖИТИЕ
    $HasHotel = $Infrastructure->appendChild($dom->createElement('HasHotel'));
    $HasHotel->appendChild($dom->createTextNode($offer->hostel));

    //ЕСТЬ ЛИ ОФИСЫ
    $HasOfficeSpace = $Infrastructure->appendChild($dom->createElement('HasOfficeSpace'));

    $object_building->getField('area_office_full') ? $hasOffice = 'true' : $hasOffice = 'false';
    $HasOfficeSpace->appendChild($dom->createTextNode($hasOffice));




    //ЗЕМЛЯ
    $Land = $object->appendChild($dom->createElement('Land'));

    //ПЛОЩАДЬ
    $Area = $Land->appendChild($dom->createElement('Area'));
    $Area->appendChild($dom->createTextNode($object_building->getField('area_field_full') / 100));


    //ЕДИНИЦА ИЗМЕРЕНИЯ
    $AreaUnitType = $Land->appendChild($dom->createElement('AreaUnitType'));
    $AreaUnitType->appendChild($dom->createTextNode('sotka'));

    //СТАТУС УЧАСТКА
    $AreaStatus = $Land->appendChild($dom->createElement('Status'));


    $oType = json_decode($offer->object_type);
    if ($oType && is_array($oType) && in_array(3, $oType)) {

        $obj_sql = "SELECT * FROM c_industry WHERE id = " . $offer->object_id;
        /** @var \PDO $pdo */
        $stmt = $pdo->prepare($obj_sql);
        $stmt->execute();
        $offerObject = $stmt->fetchObject();
        $landCategory = $offerObject->land_category;
        if ($landCategory == 6) {
            // Участок сельскохозяйственного назначения
            $AreaStatus->appendChild($dom->createTextNode('forAgriculturalPurposes'));
        } else if ($landCategory == 4) {
            // Поселений
            $AreaStatus->appendChild($dom->createTextNode('settlements'));
        } else {
            // Участок промышленности, транспорта, связи и иного не сельхоз. назначения
            $AreaStatus->appendChild($dom->createTextNode('industryTransportCommunications'));
        }
    } else {
        $AreaStatus->appendChild($dom->createTextNode('sotka'));
    }



    //ТИП УЧАСТКА
    $Type = $Land->appendChild($dom->createElement('Type'));
    if ($offer->deal_type == 4) {
        $land_own = 'rent';
    } else {
        $land_own = 'owned';
    }
    $Type->appendChild($dom->createTextNode($land_own));

    if ($offer->deal_type == 3) {
        $HasSafeCustody = $object->appendChild($dom->createElement('HasSafeCustody'));
        $HasSafeCustody->appendChild($dom->createTextNode('true'));
    }

    if ($offer->rent_business == 1) {
        $HasInvestment = $object->appendChild($dom->createElement('HasInvestmentProject'));
        $HasInvestment->appendChild($dom->createTextNode('true'));
    }

    if ($offer->land_use_restrictions) {
        $HasEncumbrances = $object->appendChild($dom->createElement('HasEncumbrances'));
        $HasEncumbrances->appendChild($dom->createTextNode('true'));
    }


    if ($offer->power) {
        $Electricity = $object->appendChild($dom->createElement('Electricity'));

        //ПЛОЩАДЬ
        $Power = $Electricity->appendChild($dom->createElement('Power'));
        $Power->appendChild($dom->createTextNode($offer->power_value));
    }

    if ($offer->gas) {
        $Gas = $object->appendChild($dom->createElement('Gas'));

        //ПЛОЩАДЬ
        $Capacity = $Gas->appendChild($dom->createElement('Capacity'));
        $Capacity->appendChild($dom->createTextNode($offer->gas_value));
    }

    if ($offer->sewage_central) {
        $Sewage = $object->appendChild($dom->createElement('Sewage'));

        //ПЛОЩАДЬ
        $Capacity = $Sewage->appendChild($dom->createElement('Capacity'));
        $Capacity->appendChild($dom->createTextNode($offer->sewage_central_value));
    }

    if ($offer->water) {
        $Water = $object->appendChild($dom->createElement('Water'));

        //ПЛОЩАДЬ
        $Capacity = $Water->appendChild($dom->createElement('Capacity'));
        $Capacity->appendChild($dom->createTextNode($offer->water_value));
    }


    //$IsCustoms = $object->appendChild($dom->createElement('IsCustoms'));
    //$IsCustoms->appendChild($dom->createTextNode('1x1'));

    //$HasTransportServices = $object->appendChild($dom->createElement('HasTransportServices'));
    //$HasTransportServices->appendChild($dom->createTextNode('1x1'));

    //ИНФРАСТРУКТУРА
    $PublishTerms = $object->appendChild($dom->createElement('PublishTerms'));
    $Terms = $PublishTerms->appendChild($dom->createElement('Terms'));
    $PublishTermSchema = $Terms->appendChild($dom->createElement('PublishTermSchema'));
    $Services = $PublishTermSchema->appendChild($dom->createElement('Services'));


    $ServicesEnum = $Services->appendChild($dom->createElement('ServicesEnum'));
    $ServicesEnum->appendChild($dom->createTextNode('paid'));

    if ($offer->ad_cian_premium) {

        $ServicesEnum = $Services->appendChild($dom->createElement('ServicesEnum'));
        $ServicesEnum->appendChild($dom->createTextNode('premium'));
    }

    if ($offer->ad_cian_top3) {

        $ServicesEnum = $Services->appendChild($dom->createElement('ServicesEnum'));
        $ServicesEnum->appendChild($dom->createTextNode('top3'));
    }

    if ($offer->ad_cian_hl) {

        $ServicesEnum = $Services->appendChild($dom->createElement('ServicesEnum'));
        $ServicesEnum->appendChild($dom->createTextNode('highlight'));
    }

    $ExcludedServices = $PublishTermSchema->appendChild($dom->createElement('ExcludedServices'));


    if ($offer->ad_cian_premium == 0) {
        $ExcludedServicesEnum = $ExcludedServices->appendChild($dom->createElement('ExcludedServicesEnum'));
        $ExcludedServicesEnum->appendChild($dom->createTextNode('premium'));
    }


    if ($offer->ad_cian_top3 == 0) {
        $ExcludedServicesEnum = $ExcludedServices->appendChild($dom->createElement('ExcludedServicesEnum'));
        $ExcludedServicesEnum->appendChild($dom->createTextNode('top3'));
    }


    if ($offer->ad_cian_hl == 0) {
        $ExcludedServicesEnum = $ExcludedServices->appendChild($dom->createElement('ExcludedServicesEnum'));
        $ExcludedServicesEnum->appendChild($dom->createTextNode('highlight'));
    }




    //УСЛОВИЯ СДЕЛКИ
    $BargainTerms = $object->appendChild($dom->createElement('BargainTerms'));

    //ЦЕНА
    $Price = $BargainTerms->appendChild($dom->createElement('Price'));
    if ($offer->is_land) {
        if ($offer->deal_type == 2) {
            // $price = $offer->price_sale_min / 100;
            // Переводим в цену за сотку
            $price = $offer->price_sale_min * $object_building->getField('area_field_full');
            if (!$price) {
                // $price = $offer->price_sale_max / 100;
                // Переводим в цену за сотку
                $price = $offer->price_sale_max * $object_building->getField('area_field_full');
            }
        } else {
            // $price = $offer->price_floor_min / 100;
            // Переводим в цену за сотку
            $price = $offer->price_floor_min * 100;
            if (!$price) {
                // $price = $offer->price_floor_max / 100;
                // Переводим в цену за сотку
                $price = $offer->price_floor_max * 100;
            }
        }
        $price_type = 'sotka';
    } else {
        if ($offer->deal_type == 2) {
            /*
            $price = $offer->price_sale_min * $offer->area_min;
            if(!$price){
                $price = $offer->price_sale_max*$offer->area_max;
            }*/
            $price = $offer->price_sale_max * $offer->area_max;
        } else {
            /*
            $price = $offer->price_floor_min;
            if(!$price){
                $price = $offer->price_floor_max;
            }
            */
            $price = $offer->price_floor_max;
        }
        $price_type = 'squareMeter';
    }

    $Price->appendChild($dom->createTextNode($price));




    //ТИП ЦЕНЫ
    $PriceType = $BargainTerms->appendChild($dom->createElement('PriceType'));
    $PriceType->appendChild($dom->createTextNode($price_type));

    //ВАЛЮТА
    $Currency = $BargainTerms->appendChild($dom->createElement('Currency'));
    $Currency->appendChild($dom->createTextNode('rur'));

    if ($offer->deal_type == 1 || $offer->deal_type == 4) {
        //ПЕРИОД ОПЛАТЫ
        $PaymentPeriod = $BargainTerms->appendChild($dom->createElement('PaymentPeriod'));
        $PaymentPeriod->appendChild($dom->createTextNode('annual'));
    }


    //ВКЛЮЧЕН ЛИ НДС
    //$VatIncluded = $BargainTerms->appendChild($dom->createElement('VatIncluded'));
    if ($offer->tax_form == 'с ндс') {
        $vat_inc = 'true';
        $VatType_value = 'included';
    } elseif ($offer->tax_form == 'без ндс') {
        $vat_inc = 'false';
        $VatType_value = 'notIncluded';
    } elseif ($offer->tax_form == 'triple net') {
        $vat_inc = 'false';
        $VatType_value = 'notIncluded';
    } elseif ($offer->tax_form == 'усн') {
        $vat_inc = 'false';
        $VatType_value = 'usn';
    } else {
    }
    //$VatIncluded->appendChild($dom->createTextNode($vat_inc));

    //ЧТО ВКЛЮЧЕНО!!!!!!!
    $VatType = $BargainTerms->appendChild($dom->createElement('VatType'));
    $VatType->appendChild($dom->createTextNode($VatType_value));

    //ЦЕНА ДОП РАСХОДОВ????
    $VatPrice = $BargainTerms->appendChild($dom->createElement('VatPrice'));
    $VatPrice->appendChild($dom->createTextNode(0));



    //ТИП АРЕНДЫ
    if ($offer->deal_type != 2) {
        $LeaseType = $BargainTerms->appendChild($dom->createElement('LeaseType'));
        if ($offer->deal_type == 4) {
            $leaseType_value = 'sublease';
        } else {
            $leaseType_value = 'direct';
        }
        $LeaseType->appendChild($dom->createTextNode($leaseType_value));
    }



    //ВКЛЮЧЕНО В СТАВКУ
    $IncludedOptions = $BargainTerms->appendChild($dom->createElement('IncludedOptions'));

    if ($offer->price_opex_inc) {
        $IncludedOptionsEnum = $IncludedOptions->appendChild($dom->createElement('IncludedOptionsEnum'));
        $IncludedOptionsEnum->appendChild($dom->createTextNode('operationalCosts'));
    }

    if ($offer->price_public_services_inc) {
        $IncludedOptionsEnum = $IncludedOptions->appendChild($dom->createElement('IncludedOptionsEnum'));
        $IncludedOptionsEnum->appendChild($dom->createTextNode('utilityCharges'));
    }

    //СРОК АРЕНДЫ --ПОСТОЯННОЕ--
    $LeaseTermType = $BargainTerms->appendChild($dom->createElement('LeaseTermType'));
    $LeaseTermType->appendChild($dom->createTextNode('longTerm'));

    //МИНИМАЛЬНЫЙ СРОК АРЕНДЫ --ПОСТОЯННОЕ--
    $MinLeaseTerm = $BargainTerms->appendChild($dom->createElement('MinLeaseTerm'));
    $MinLeaseTerm->appendChild($dom->createTextNode(12));

    //ПРЕДОПЛАТА --ПОСТОЯННОЕ--
    $PrepayMonths = $BargainTerms->appendChild($dom->createElement('PrepayMonths'));
    $PrepayMonths->appendChild($dom->createTextNode(1));

    //$HasGracePeriod = $BargainTerms->appendChild($dom->createElement('HasGracePeriod'));
    //$HasGracePeriod->appendChild($dom->createTextNode('1x1'));

    //КОМИССИЯ ОТ ПРЯМОГО КЛИЕНТА
    $ClientFee = $BargainTerms->appendChild($dom->createElement('ClientFee'));
    //$ClientFee->appendChild($dom->createTextNode($clientFee_value));
    $ClientFee->appendChild($dom->createTextNode(0));

    if ($offer->deal_type != 2) {
        //ОБЕСПЕЧИТЕЛЬНЫЙ ДЕПОЗИТ
        $SecurityDeposit = $BargainTerms->appendChild($dom->createElement('SecurityDeposit'));

        $paymentValue = ceil($offer->pledge * $offer->price_floor_max * $offer->area_max / 12);
        $SecurityDeposit->appendChild($dom->createTextNode($paymentValue));
    }



    $AgentFee = $BargainTerms->appendChild($dom->createElement('AgentFee'));
    $AgentFee->appendChild($dom->createTextNode(0));

    $AgentBonus = $BargainTerms->appendChild($dom->createElement('AgentBonus'));
    $Value = $AgentBonus->appendChild($dom->createElement('Value'));
    $Value->appendChild($dom->createTextNode(0));

    $PaymentType = $AgentBonus->appendChild($dom->createElement('PaymentType'));
    $PaymentType->appendChild($dom->createTextNode('percent'));

    $Currency = $AgentBonus->appendChild($dom->createElement('Currency'));
    $Currency->appendChild($dom->createTextNode('rur'));


    $blocks_count++;
}
//остановился на  LiftTypes
//генерация xml
$dom->formatOutput = true; // установка атрибута formatOutput
// domDocument в значение true
// save XML as string or file
$test1 = $dom->saveXML(); // передача строки в test1
$dom->save('feed.xml'); // сохранение файла

echo 'Колво блоков' . $blocks_count . '<br>';
echo 'Колво объектов' . $objects_count . '<br>';


//header("Location: http://industry.gorki.ru/xml_industry_new_obj.php?page=$next_page");

echo (microtime(true) - $start);
?>
