
<?php
/**
 * Created by PhpStorm.
 * User: Zhitkov
 * Date: 11.07.2018
 * Time: 16:20
 */
?>
<?php
set_time_limit(0);

$filedir = $_SERVER['DOCUMENT_ROOT']."/data/images/c_industry/$object_id/";
$filedir = $_SERVER['DOCUMENT_ROOT']."/watermark/result/industry/";
$del_photos = scandir($filedir);
foreach($del_photos as $del_photo){

    if(! is_dir($filedir.$del_photo) && file_exists($filedir.$del_photo)){
        unlink($filedir.$del_photo);
        echo 'Фото удалено';
    }

}
require_once('global_pass.php');
var_dump($pdo);

$sql = $pdo->prepare("SELECT * FROM c_industry WHERE deleted!='1' AND result IN(0,5) ");
$sql->execute();

while($object_item = $sql->fetch(PDO::FETCH_LAZY)){
    //ФОТОГРАФИИ////////////////////////////////////////////////////////////////////////////////////

    $object_id = $object_item->id;


    $filedir = $_SERVER['DOCUMENT_ROOT']."/data/images/c_industry/$object_id/";
    $block_photos = scandir($filedir);

    foreach($block_photos as $block_photo){

        //Отрезаем ненужное
        $photo = trim($block_photo,'.');
        if(stristr($photo, 'del') === FALSE){

            $filename ="http://industry.gorki.ru/data/images/c_industry/$object_id/$block_photo";

            if($photo != NULL){


                if(preg_match('/[.](jpg)$/', $filename)) {
                    $im = imagecreatefromjpeg($filename);
                } else if (preg_match('/[.](gif)$/', $filename)) {
                    $im = imagecreatefromgif($filename);
                } else if (preg_match('/[.](png)$/', $filename)) {
                    $im = imagecreatefrompng($filename);
                }

                // Наложение ЦВЗ с прозрачным фоном
                imagealphablending($im, true);
                imagesavealpha($im, true);

                // Создаем ресурс изображения для нашего водяного знака
                $watermark_image = imagecreatefrompng($_SERVER['DOCUMENT_ROOT'].'/watermark/images/watermark.png');

                // Получаем значения ширины и высоты
                $watermark_width = imagesx($watermark_image);
                $watermark_height = imagesy($watermark_image);


                // Самая важная функция - функция копирования и наложения нашего водяного знака на исходное изображение
                //imagecopy($im, $watermark_image, $im_width - $watermark_width, $im_height - $watermark_height, 0, 0, $watermark_width, $watermark_height);

                imagecopy($im, $watermark_image, 0, 0, 0, 0, $watermark_width, $watermark_height);
                imagecopy($im, $watermark_image, 250, 150, 0, 0, $watermark_width, $watermark_height);
                imagecopy($im, $watermark_image, 500, 300, 0, 0, $watermark_width, $watermark_height);
                imagecopy($im, $watermark_image, 750, 450, 0, 0, $watermark_width, $watermark_height);

                imagecopy($im, $watermark_image, 600, 0, 0, 0, $watermark_width, $watermark_height);
                imagecopy($im, $watermark_image, 850, 150, 0, 0, $watermark_width, $watermark_height);
                imagecopy($im, $watermark_image, 1100, 300, 0, 0, $watermark_width, $watermark_height);
                imagecopy($im, $watermark_image, 1350, 450, 0, 0, $watermark_width, $watermark_height);

                imagecopy($im, $watermark_image, -600, 0, 0, 0, $watermark_width, $watermark_height);
                imagecopy($im, $watermark_image, -350, 150, 0, 0, $watermark_width, $watermark_height);
                imagecopy($im, $watermark_image, -100, 300, 0, 0, $watermark_width, $watermark_height);
                imagecopy($im, $watermark_image, 150, 450, 0, 0, $watermark_width, $watermark_height);
                imagecopy($im, $watermark_image, 400, 600, 0, 0, $watermark_width, $watermark_height);
                imagecopy($im, $watermark_image, 650, 750, 0, 0, $watermark_width, $watermark_height);

                // Создание и сохранение результирующего изображения с водяным знаком
                imagejpeg($im, $_SERVER['DOCUMENT_ROOT']."/watermark/result/industry/$object_id-$block_photo", 60);
                // Уничтожение всех временных ресурсов
                imagedestroy($im);
                imagedestroy($watermark_image);


            }
        }
    }
}







$start = microtime(true);


$blocks_count = 0;
$objects_count = 0;



//Создает XML-строку и XML-документ при помощи DOM
$dom = new DomDocument('1.0');

//добавление корня - <books>
$feed = $dom->appendChild($dom->createElement('feed'));

//добавление элемента <$feed_version> в <$feed>
$feed_version = $feed->appendChild($dom->createElement('feed_version'));
$feed_version->appendChild($dom->createTextNode('2'));




$sql = $pdo->prepare("SELECT * FROM c_industry WHERE region IN(1,2) AND deleted!='1' AND result IN(0,5)  ORDER BY dt_update_full DESC  LIMIT 1000");
//$sql = $pdo->prepare("SELECT * FROM c_industry WHERE (import_sale_cian='1' OR import_rent_cian='1') AND deleted!='1' AND result IN(0,5)  ORDER BY dt_update_full DESC $from , LIMIT $limit"); 
//$sql = $pdo->prepare("SELECT * FROM c_industry_blocks WHERE import_cian='1' AND deleted!='1' AND result!='1' AND result!='2' AND result!='3' AND result!='4'  ORDER BY dt_update_full DESC LIMIT 5");
$sql->execute();
while($object_item = $sql->fetch(PDO::FETCH_LAZY)){

    $objects_count++;

    $agent_sql = $pdo->prepare("SELECT * FROM c_users WHERE id='".$object_item->agent."'");
    $agent_sql->execute();
    $agent = $agent_sql->fetch(PDO::FETCH_LAZY);

    $highway_sql = $pdo->prepare("SELECT * FROM l_highways WHERE id='".$object_item->highway."'"); //l_highways
    $highway_sql->execute();
    $highway = $highway_sql->fetch(PDO::FETCH_LAZY);

    $metro_sql = $pdo->prepare("SELECT * FROM l_metros WHERE id='".$object_item->metro."'"); //l_metros
    $metro_sql->execute();
    $metro = $metro_sql->fetch(PDO::FETCH_LAZY);

    $class_sql = $pdo->prepare("SELECT * FROM l_classes WHERE id='".$object_item->object_class."'");
    $class_sql->execute();
    $class = $class_sql->fetch(PDO::FETCH_LAZY);

    $firefighting_type_sql = $pdo->prepare("SELECT * FROM l_skladno_firefighting WHERE id='".$object_item->firefighting."'");
    $firefighting_type_sql->execute();
    $firefighting_type = $firefighting_type_sql->fetch(PDO::FETCH_LAZY);

    $object_infrastructure = explode(',',trim($object_item->infrastructure, ','));
    in_array(2,$object_infrastructure) ? $hasBuffet = 'true' : $hasBuffet = 'false' ;
    in_array(1,$object_infrastructure) ? $hasHotel = 'true' : $hasHotel = 'false' ;
    $object_item->nooffice ? $hasOffice = 'false' : $hasOffice = 'true' ;


    $object_types = explode(',',trim($object_item->object_type2, ','));
    if(in_array(1,$object_types) || in_array(3,$object_types) || in_array(8,$object_types) || in_array(9,$object_types)){
        $postObjectType = 'warehouse';
        $type_value = 'warehouseComplex';
    }else{
        $postObjectType = 'industry';
        $type_value = 'industrialComplex';
    }


    //ДЛЯ ОБЬЕКТА ТИП СДЕЛКИ
    /*
    $object_deals = explode(',',trim($object_item->deal_type, ','));
    if(in_array(1,$object_deals) || in_array(3,$object_deals) || in_array(4,$object_deals)){
        $postObjectDeal = 'Rent';
        $object_deal == '4' ? $leaseType_value = 'sublease' :   $leaseType_value = 'direct';
    }else{
        $postObjectDeal = 'Sale';
    }
    */

    //$category_value = $postObjectType.$postObjectDeal;



    //Парковка
    //echo $object_item->parking_truck;
    if($object_item->parking_truck){
        //echo "truck";
        $parkingPurposeType = 'cargo';
        $object_item->parking_truck_type == 2 ? $isFree = 'true' : $isFree = 'false';
    }elseif($object_item->parking_car && !$object_item->parking_truck){
        $parkingPurposeType = 'passenger';
        $object_item->parking_car_type == 2 ? $isFree = 'true' : $isFree = 'false';
        //echo "car";
    }else{
        $isFree = 'false';
    }


    $heating_arr = array( 1 => 'autonomous' , 2 => 'central' , 4 => 'no');
    $transport_type_arr = array( 1 => 'walk' , 2 => 'transport');




////ПЕРЕБИРАЕМ ПОДХОДЯЩИЕ БЛОКИ ВНУТРИ ОБЪЕКТА
    $building_max_ceiling = 0;




    $blocks_sql = $pdo->prepare("SELECT * FROM c_industry_blocks WHERE parent_id='".$object_item->id."' AND import_cian='1' AND deleted!='1' AND result='5' ");
    $blocks_sql->execute();
    if($blocks_sql->rowCount() > 0) {echo "не пустой: ".$object_item->id."<br>";


        //ФОТОГРАФИИ////////////////////////////////////////////////////////////////////////////////////

        $object_id = $object_item->id;

        $obj_photo_array = array();

        $filedir = $_SERVER['DOCUMENT_ROOT']."/data/images/c_industry/$object_id/";
        $block_photos = scandir($filedir);

        foreach($block_photos as $block_photo){
            array_push($obj_photo_array, "http://industry.gorki.ru/watermark/result/industry/$object_id-$block_photo");
        }


        //БЛОКИ ВНУТРИ ОБЪЕКТОВ
        while($block = $blocks_sql->fetch(PDO::FETCH_LAZY)){

            //$building_max_ceiling < $block->ceiling_height2  ? $building_max_ceiling = $block->ceiling_height2 : ' ' ;
            $building_max_ceiling = $block->ceiling_height2;

            $floor_type_sql = $pdo->prepare("SELECT * FROM l_floor_types WHERE id='".$block->floor_type."'");
            $floor_type_sql->execute();
            $floor_type = $floor_type_sql->fetch(PDO::FETCH_LAZY);

            $ventilation_type_sql = $pdo->prepare("SELECT * FROM l_ventilations WHERE id='".$block->floor_type."'");
            $ventilation_type_sql->execute();
            $ventilation_type = $ventilation_type_sql->fetch(PDO::FETCH_LAZY);

            $gate_type_sql = $pdo->prepare("SELECT * FROM l_gate_types WHERE id='".$block->gate_type."'");
            $gate_type_sql->execute();
            $gate_type = $gate_type_sql->fetch(PDO::FETCH_LAZY);

            $column_type_sql = $pdo->prepare("SELECT * FROM l_collon_meshes WHERE id='".$block->collon_mesh."'");
            $column_type_sql->execute();
            $column_type = $column_type_sql->fetch(PDO::FETCH_LAZY);

            //ДЛЯ БЛОКА ТИП СДЕЛКИ
            $object_deals = explode(',',trim($block->deal_type, ','));
            if(in_array(1,$object_deals) || in_array(3,$object_deals) || in_array(4,$object_deals)){
                $postObjectDeal = 'Rent';
                in_array(4,$object_deals) ? $leaseType_value = 'sublease' :   $leaseType_value = 'direct';
            }else{
                $postObjectDeal = 'Sale';
            }
            $category_value = $postObjectType.$postObjectDeal;


            if($postObjectDeal == 'Sale'){
                $price_value = $block->sale_price*$block->area2;
                $clientFee_value = $block->owner_pays_howmuch_4client_sale;
            }else{
                $price_value = $block->rent_price;
                $clientFee_value = $block->owner_pays_howmuch_4client;
            }

            //ПОПРАВКА ПРОВЕРКА СТОИМОСТИ
            if($block->rent_price == 0){
                $postObjectDeal = 'Sale';
                $price_value = $block->sale_price*$block->area2;
                $clientFee_value = $block->owner_pays_howmuch_4client_sale;
            }

            if($block->payinc == 'usn'){
                $VatType_value = 'usn';
                $vat_inc='false';
            }else{
                if($block->rent_payopt == 'triplenet'){
                    $VatType_value = 'notIncluded';
                    $vat_inc='false';
                }else{
                    $VatType_value = 'included';
                    $vat_inc='true';
                }
            }


            //добавление элемента <object> в <$feed>
            $object = $feed->appendChild($dom->createElement('object'));

            //КАТЕГОРИЯ ОБЪЯВЛЕНИЯ
            $Category = $object->appendChild($dom->createElement('Category'));
            $Category->appendChild($dom->createTextNode($category_value));

            //ВНУТРЕННИЙ ID БЛОУВ И ОБЪЕКТА
            $ExternalId = $object->appendChild($dom->createElement('ExternalId'));
            $ExternalId->appendChild($dom->createTextNode($block->parent_id.'-'.$block->id_visual));

            //ОПИСАНИЕ
            $Description = $object->appendChild($dom->createElement('Description'));
            $Description->appendChild($dom->createTextNode($block->description ? $block->description: $block->description_handmade));

            //АДРЕС СОГЛАСНО ЯНДЕКС КАРТ
            $Address = $object->appendChild($dom->createElement('Address'));
            $Address->appendChild($dom->createTextNode($object_item->yandex_address_str));

            //КООРДИНАТЫ
            $Coordinates = $object->appendChild($dom->createElement('Coordinates'));
            $Lat = $Coordinates->appendChild($dom->createElement('Lat'));
            $Lat->appendChild($dom->createTextNode($object_item->c_x));

            $Lng = $Coordinates->appendChild($dom->createElement('Lng'));
            $Lng->appendChild($dom->createTextNode($object_item->c_y));

            //КАДАСТРОВЫЕ НОМЕРА
            //$CadastralNumber = $object->appendChild($dom->createElement('CadastralNumber'));
            //$CadastralNumber->appendChild($dom->createTextNode($object_item->cadastral_number));

            //ТЕЛЕФОНЫ
            $Phones = $object->appendChild($dom->createElement('Phones'));
            $PhoneSchema = $Phones->appendChild($dom->createElement('PhoneSchema'));
            $CountryCode = $PhoneSchema->appendChild($dom->createElement('CountryCode'));
            $CountryCode->appendChild($dom->createTextNode('+7'));

            $Number = $PhoneSchema->appendChild($dom->createElement('Number'));
            $Number->appendChild($dom->createTextNode('9265356912'));

            //ШОССЕ И РАССТОЯНИЕ ОТ МКАД
            $Highway = $object->appendChild($dom->createElement('Highway'));
            $Id = $Highway->appendChild($dom->createElement('Id'));
            $Id->appendChild($dom->createTextNode($highway->id_cian));

            $Distance = $Highway->appendChild($dom->createElement('Distance'));
            $Distance->appendChild($dom->createTextNode($object_item->otmkad));

            //МЕТРО
            if($object_item->metro > 0) {
                $Undergrounds = $object->appendChild($dom->createElement('Undergrounds'));
                $UndergroundInfoSchema = $Undergrounds->appendChild($dom->createElement('UndergroundInfoSchema'));
                $Id = $UndergroundInfoSchema->appendChild($dom->createElement('Id'));
                $Id->appendChild($dom->createTextNode($metro->cian_id));

                if($object_item->from_metro){
                    $Time = $UndergroundInfoSchema->appendChild($dom->createElement('Time'));
                    $Time->appendChild($dom->createTextNode($object_item->from_metro));
                }

                if($object_item->from_metro_by){
                    $TransportType = $UndergroundInfoSchema->appendChild($dom->createElement('TransportType'));
                    $TransportType->appendChild($dom->createTextNode($transport_type_arr[$object_item->from_metro_by]));
                }
            }

            //ОБЩАЯ ПЛОЩАДЬ
            $TotalArea = $object->appendChild($dom->createElement('TotalArea'));
            $TotalArea->appendChild($dom->createTextNode($block->area2));

            //МИНИМАЛЬНАЯ ПЛОЩАДЬ
            $MinArea = $object->appendChild($dom->createElement('MinArea'));
            $MinArea->appendChild($dom->createTextNode($block->area));

            //ЭТАЖ
            $FloorNumber = $object->appendChild($dom->createElement('FloorNumber'));
            $FloorNumber->appendChild($dom->createTextNode($block->floor));

            //СОСТОЯНИЕ
            $ConditionType = $object->appendChild($dom->createElement('ConditionType'));
            $ConditionType->appendChild($dom->createTextNode('typical'));

            //БРОКЕР
            $SubAgent = $object->appendChild($dom->createElement('SubAgent'));
            $Email = $SubAgent->appendChild($dom->createElement('Email'));
            $Email->appendChild($dom->createTextNode($agent->user_email));

            $Phone = $SubAgent->appendChild($dom->createElement('Phone'));
            $Phone->appendChild($dom->createTextNode($agent->user_phone));

            $FirstName = $SubAgent->appendChild($dom->createElement('FirstName'));
            $FirstName->appendChild($dom->createTextNode($agent->user_name));

            $LastName = $SubAgent->appendChild($dom->createElement('LastName'));
            $LastName->appendChild($dom->createTextNode($agent->user_name));

            //ПЛАНИРОВКА
            //$Layout = $object->appendChild($dom->createElement('Layout'));
            //$Layout->appendChild($dom->createTextNode('cabinet'));

            //$LayoutPhoto = $object->appendChild($dom->createElement('LayoutPhoto'));
            //$FullUrl = $LayoutPhoto->appendChild($dom->createElement('FullUrl'));
            //$FullUrl->appendChild($dom->createTextNode('http://example.com/flat1.jpg'));

            //$IsDefault = $LayoutPhoto->appendChild($dom->createElement('IsDefault'));
            //$IsDefault->appendChild($dom->createTextNode('true'));

            //ФОТОГРАФИИ ОБЪЕКТА
            $Photos = $object->appendChild($dom->createElement('Photos'));


            $photo_num = 0;
            foreach($obj_photo_array as $block_photo){

                $photo_num++;

                $PhotoSchema = $Photos->appendChild($dom->createElement('PhotoSchema'));
                $FullUrl = $PhotoSchema->appendChild($dom->createElement('FullUrl'));
                $FullUrl->appendChild($dom->createTextNode($block_photo));

                $IsDefault = $PhotoSchema->appendChild($dom->createElement('IsDefault'));
                $IsDefault->appendChild($dom->createTextNode($photo_num == 1 ? 'true' : 'false'));

            }


            //ДАТА ОСВОБОЖДЕНИЯ
            $AvailableFrom = $object->appendChild($dom->createElement('AvailableFrom'));
            $AvailableFrom->appendChild($dom->createTextNode($block->finishing));

            //ТИП ПОЛА
            $FloorMaterialTypeType = $object->appendChild($dom->createElement('FloorMaterialTypeType'));
            $FloorMaterialTypeType->appendChild($dom->createTextNode($floor_type->title_cian));

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

            //$Videos = $object->appendChild($dom->createElement('Videos'));
            //$VideoSchema = $Videos->appendChild($dom->createElement('VideoSchema'));
            //$Url = $VideoSchema->appendChild($dom->createElement('Url'));
            //$Url->appendChild($dom->createTextNode('true'));

            //$VideoSchema = $Videos->appendChild($dom->createElement('VideoSchema'));
            //$Url = $VideoSchema->appendChild($dom->createElement('Url'));
            //$Url->appendChild($dom->createTextNode('true'));

            //ЗДАНИЕ
            $Building = $object->appendChild($dom->createElement('Building'));

            //НАЗВАНИЕ ОБЬЕКТА
            $Name = $Building->appendChild($dom->createElement('Name'));
            $Name->appendChild($dom->createTextNode($object_item->address));

            //КОЛИЧЕСТВО ЭТАЖЕЙ
            $FloorsCount = $Building->appendChild($dom->createElement('FloorsCount'));
            $FloorsCount->appendChild($dom->createTextNode($object_item->floors));


            //ГОД ПОСТРОЙКИ
            if($object_item->year_build > 0){
                $BuildYear = $Building->appendChild($dom->createElement('BuildYear'));
                $BuildYear->appendChild($dom->createTextNode($object_item->year_build));
            }

            //ОБЩАЯ ПЛОЩАДЬ ОБЪЕКТА
            $TotalArea = $Building->appendChild($dom->createElement('TotalArea'));
            $TotalArea->appendChild($dom->createTextNode($object_item->t_area));

            //ОТОПЛЕНИЕ
            $object_item->heating ? $heat_value = $heating_arr[$object_item->heating] : $heat_value = 'no';
            $HeatingType = $Building->appendChild($dom->createElement('HeatingType'));
            $HeatingType->appendChild($dom->createTextNode($heat_value));

            //ВЫСОТА ПОТОЛКОВ
            $CeilingHeight = $Building->appendChild($dom->createElement('CeilingHeight'));
            $CeilingHeight->appendChild($dom->createTextNode($building_max_ceiling));

            //ПАРКОВКА
            $Parking = $Building->appendChild($dom->createElement('Parking'));

            //РАСПОЛОЖЕНИЕ ПАРКОВКИ -- ПОСТОЯННОЕ--
            $LocationType = $Parking->appendChild($dom->createElement('LocationType'));
            $LocationType->appendChild($dom->createTextNode('internal'));

            //ТИП ПАРКОВКИ (ЛЕГКОВАЯ ИЛИ ГРУЗОВАЯ)
            $PurposeType = $Parking->appendChild($dom->createElement('PurposeType'));
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
            $Type = $Building->appendChild($dom->createElement('Type'));
            $Type->appendChild($dom->createTextNode($type_value));

            //КЛАСС ОБЪЕКТА
            $ClassType = $Building->appendChild($dom->createElement('ClassType'));
            $ClassType->appendChild($dom->createTextNode(strtolower($class->title)));

            //$Developer = $Building->appendChild($dom->createElement('Developer'));
            //$Developer->appendChild($dom->createTextNode('5.4'));

            //$ManagementCompany = $Building->appendChild($dom->createElement('ManagementCompany'));
            //$ManagementCompany->appendChild($dom->createTextNode('5.4'));

            //СИСТЕМА ВЕНТИЛЯЦИИ
            $VentilationType = $Building->appendChild($dom->createElement('VentilationType'));
            $VentilationType->appendChild($dom->createTextNode($ventilation_type->title_cian));

            //$ConditioningType = $Building->appendChild($dom->createElement('ConditioningType'));
            //$ConditioningType->appendChild($dom->createTextNode('5.4'));

            //СИСТЕМА ПОЖАРОТУШЕНИЯ
            $ExtinguishingSystemType = $Building->appendChild($dom->createElement('ExtinguishingSystemType'));
            $ExtinguishingSystemType->appendChild($dom->createTextNode($firefighting_type->title_cian));

            //ТИПЫ ЛИФТОВ
            $LiftTypes = $Building->appendChild($dom->createElement('LiftTypes'));
            $LiftTypeSchema = $LiftTypes->appendChild($dom->createElement('LiftTypeSchema'));

            if($block->s_elevators){
                $elevators_info = explode(',',$block->s_elevators);
                $elevators_amount = $elevators_info[0];
                $elevators_capacity = $elevators_info[1];
                //ТИП ЛИФТА --ПОСТОЯННОЕ--
                $Type = $LiftTypeSchema->appendChild($dom->createElement('Type'));
                $Type->appendChild($dom->createTextNode('cargo'));

                //$AdditionalType = $LiftTypeSchema->appendChild($dom->createElement('AdditionalType'));
                //$AdditionalType->appendChild($dom->createTextNode('cargo'));

                //КОЛИЧЕСТВО ЛИФТОВ
                $Count = $LiftTypeSchema->appendChild($dom->createElement('Count'));
                $Count->appendChild($dom->createTextNode($elevators_amount));

                //ГРУЗОПОДЪЕМНОСТЬ
                $LoadCapacity = $LiftTypeSchema->appendChild($dom->createElement('LoadCapacity'));
                $LoadCapacity->appendChild($dom->createTextNode($elevators_capacity));
            }

            //КАТЕГОРИЯ ЗАДНИЯ --ПОСТОЯННОЕ--
            $StatusType = $Building->appendChild($dom->createElement('StatusType'));
            $StatusType->appendChild($dom->createTextNode('operational'));

            //КРАНЫ
            $CranageTypes = $Building->appendChild($dom->createElement('CranageTypes'));


            if($object_item->gantry_cranes){
                $CranageTypeSchema = $CranageTypes->appendChild($dom->createElement('CranageTypeSchema'));

                $cranes_info = explode(',',$object_item->gantry_cranes);
                $cranes_amount = $elevators_info[0];
                $cranes_capacity = $elevators_info[1];
                //ТИП КРАНА
                $Type = $CranageTypeSchema->appendChild($dom->createElement('Type'));
                $Type->appendChild($dom->createTextNode('gantry'));

                //ГРУЗОПОДЪЕМНОСТЬ
                $LoadCapacity = $CranageTypeSchema->appendChild($dom->createElement('LoadCapacity'));
                $LoadCapacity->appendChild($dom->createTextNode($cranes_amount));

                //КОЛИЧЕСТВО КРАНОВ
                $Count = $CranageTypeSchema->appendChild($dom->createElement('Count'));
                $Count->appendChild($dom->createTextNode($cranes_capacity));
            }

            if($object_item->railway_cranes){
                $CranageTypeSchema = $CranageTypes->appendChild($dom->createElement('CranageTypeSchema'));

                $cranes_info = explode(',',$object_item->railway_cranes);
                $cranes_amount = $elevators_info[0];
                $cranes_capacity = $elevators_info[1];
                //ТИП КРАНА
                $Type = $CranageTypeSchema->appendChild($dom->createElement('Type'));
                $Type->appendChild($dom->createTextNode('railway'));

                //ГРУЗОПОДЪЕМНОСТЬ
                $LoadCapacity = $CranageTypeSchema->appendChild($dom->createElement('LoadCapacity'));
                $LoadCapacity->appendChild($dom->createTextNode($cranes_amount));

                //КОЛИЧЕСТВО КРАНОВ
                $Count = $CranageTypeSchema->appendChild($dom->createElement('Count'));
                $Count->appendChild($dom->createTextNode($cranes_capacity));
            }

            if($block->catheads){
                $CranageTypeSchema = $CranageTypes->appendChild($dom->createElement('CranageTypeSchema'));

                $cranes_info = explode(',',$block->catheads);
                $cranes_amount = $elevators_info[0];
                $cranes_capacity = $elevators_info[1];
                //ТИП КРАНА
                $Type = $CranageTypeSchema->appendChild($dom->createElement('Type'));
                $Type->appendChild($dom->createTextNode('beam'));

                //ГРУЗОПОДЪЕМНОСТЬ
                $LoadCapacity = $CranageTypeSchema->appendChild($dom->createElement('LoadCapacity'));
                $LoadCapacity->appendChild($dom->createTextNode($cranes_amount));

                //КОЛИЧЕСТВО КРАНОВ
                $Count = $CranageTypeSchema->appendChild($dom->createElement('Count'));
                $Count->appendChild($dom->createTextNode($cranes_capacity));
            }

            if($block->overhead_cranes){
                $CranageTypeSchema = $CranageTypes->appendChild($dom->createElement('CranageTypeSchema'));

                $cranes_info = explode(',',$block->overhead_cranes);
                $cranes_amount = $elevators_info[0];
                $cranes_capacity = $elevators_info[1];
                //ТИП КРАНА
                $Type = $CranageTypeSchema->appendChild($dom->createElement('Type'));
                $Type->appendChild($dom->createTextNode('overhead'));

                //ГРУЗОПОДЪЕМНОСТЬ
                $LoadCapacity = $CranageTypeSchema->appendChild($dom->createElement('LoadCapacity'));
                $LoadCapacity->appendChild($dom->createTextNode($cranes_amount));

                //КОЛИЧЕСТВО КРАНОВ
                $Count = $CranageTypeSchema->appendChild($dom->createElement('Count'));
                $Count->appendChild($dom->createTextNode($cranes_capacity));
            }


            //ТИП ВОРОТ
            $GatesType = $Building->appendChild($dom->createElement('GatesType'));
            $GatesType->appendChild($dom->createTextNode($gate_type->title_cian));

            //СЕТКА КОЛОНН
            $ColumnGrid = $Building->appendChild($dom->createElement('ColumnGrid'));
            $ColumnGrid->appendChild($dom->createTextNode($column_type->title));

            //ИНФРАСТРУКТУРА
            $Infrastructure = $Building->appendChild($dom->createElement('Infrastructure'));

            //ЕСТЬ ЛИ БУФФЕТ
            $HasBuffet = $Infrastructure->appendChild($dom->createElement('HasBuffet'));
            $HasBuffet->appendChild($dom->createTextNode($hasBuffet));

            //ЕСТЬ ЛИ СТОЛОВАЯ
            $HasCanteen = $Infrastructure->appendChild($dom->createElement('HasCanteen'));
            $HasCanteen->appendChild($dom->createTextNode($hasBuffet));

            //ЕСТЬ ЛИ ЦЕНТРАЛЬНАЯ РЕЦЕПЦИЯ
            //$HasCentralReception = $Infrastructure->appendChild($dom->createElement('HasCentralReception'));
            //$HasCentralReception->appendChild($dom->createTextNode('true'));

            //ЕСТЬ ЛИ ОБЩЕЖИТИЕ
            $HasHotel = $Infrastructure->appendChild($dom->createElement('HasHotel'));
            $HasHotel->appendChild($dom->createTextNode($hasHotel));

            //ЕСТЬ ЛИ ОФИСЫ
            $HasOfficeSpace = $Infrastructure->appendChild($dom->createElement('HasOfficeSpace'));
            $HasOfficeSpace->appendChild($dom->createTextNode($hasOffice));


            //ЗЕМЛЯ
            $Land = $object->appendChild($dom->createElement('Land'));

            //ПЛОЩАДЬ
            $Area = $Land->appendChild($dom->createElement('Area'));
            $Area->appendChild($dom->createTextNode($object_item->u_area));


            //ЕДИНИЦА ИЗМЕРЕНИЯ
            $AreaUnitType = $Land->appendChild($dom->createElement('AreaUnitType'));
            $AreaUnitType->appendChild($dom->createTextNode('sotka'));


            //ТИП УЧАСТКА
            $Type = $Land->appendChild($dom->createElement('Type'));
            $Type->appendChild($dom->createTextNode('owned'));

            //$HasSafeCustody = $object->appendChild($dom->createElement('HasSafeCustody'));
            //$HasSafeCustody->appendChild($dom->createTextNode('1x1'));

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

            if($block->import_cian_premium){
                $ServicesEnum = $Services->appendChild($dom->createElement('ServicesEnum'));
                $ServicesEnum->appendChild($dom->createTextNode('premium'));
            }

            if($block->import_cian_top3 ){
                $ServicesEnum = $Services->appendChild($dom->createElement('ServicesEnum'));
                $ServicesEnum->appendChild($dom->createTextNode('top3'));
            }

            if($block->import_cian_hl){
                $ServicesEnum = $Services->appendChild($dom->createElement('ServicesEnum'));
                $ServicesEnum->appendChild($dom->createTextNode('highlight'));
            }

            $ExcludedServices = $PublishTermSchema->appendChild($dom->createElement('ExcludedServices'));

            if($block->import_cian_premium == 0){
                $ExcludedServicesEnum = $ExcludedServices->appendChild($dom->createElement('ExcludedServicesEnum'));
                $ExcludedServicesEnum->appendChild($dom->createTextNode('premium'));
            }

            if($block->import_cian_top3 == 0){
                $ExcludedServicesEnum = $ExcludedServices->appendChild($dom->createElement('ExcludedServicesEnum'));
                $ExcludedServicesEnum->appendChild($dom->createTextNode('top3'));
            }

            if($block->import_cian_hl == 0){
                $ExcludedServicesEnum = $ExcludedServices->appendChild($dom->createElement('ExcludedServicesEnum'));
                $ExcludedServicesEnum->appendChild($dom->createTextNode('highlight'));
            }


            //УСЛОВИЯ СДЕЛКИ
            $BargainTerms = $object->appendChild($dom->createElement('BargainTerms'));

            //ЦЕНА
            $Price = $BargainTerms->appendChild($dom->createElement('Price'));
            $Price->appendChild($dom->createTextNode($price_value));


            //ТИП ЦЕНЫ
            $PriceType = $BargainTerms->appendChild($dom->createElement('PriceType'));
            $PriceType->appendChild($dom->createTextNode('squareMeter'));

            //ВАЛЮТА
            $Currency = $BargainTerms->appendChild($dom->createElement('Currency'));
            $Currency->appendChild($dom->createTextNode('rur'));

            //ПЕРИОД ОПЛАТЫ
            $PaymentPeriod = $BargainTerms->appendChild($dom->createElement('PaymentPeriod'));
            $PaymentPeriod->appendChild($dom->createTextNode('annual'));

            //ВКЛЮЧЕН ЛИ НДС
            $VatIncluded = $BargainTerms->appendChild($dom->createElement('VatIncluded'));
            $VatIncluded->appendChild($dom->createTextNode($vat_inc));

            //ЧТО ВКЛЮЧЕНО!!!!!!!
            $VatType = $BargainTerms->appendChild($dom->createElement('VatType'));
            $VatType->appendChild($dom->createTextNode($VatType_value));

            //ЦЕНА ДОП РАСХОДОВ????
            $VatPrice = $BargainTerms->appendChild($dom->createElement('VatPrice'));
            $VatPrice->appendChild($dom->createTextNode(0));

            //ТИП АРЕНДЫ
            if($postObjectDeal == 'Rent'){
                $LeaseType = $BargainTerms->appendChild($dom->createElement('LeaseType'));
                $LeaseType->appendChild($dom->createTextNode($leaseType_value));
            }

            //ВКЛЮЧЕНО В СТАВКУ
            $IncludedOptions = $BargainTerms->appendChild($dom->createElement('IncludedOptions'));

            if($block->payinc_opex){
                $IncludedOptionsEnum = $IncludedOptions->appendChild($dom->createElement('IncludedOptionsEnum'));
                $IncludedOptionsEnum->appendChild($dom->createTextNode('operationalCosts'));
            }

            if($block->payinc_heat || $block->payinc_water || $block->payinc_e ){
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

            //ОБЕСПЕЧИТЕЛЬНЫЙ ДЕПОЗИТ
            $SecurityDeposit = $BargainTerms->appendChild($dom->createElement('SecurityDeposit'));
            $SecurityDeposit->appendChild($dom->createTextNode(0));

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
    }
}
//остановился на  LiftTypes
//генерация xml
$dom->formatOutput = true; // установка атрибута formatOutput
// domDocument в значение true
// save XML as string or file
$test1 = $dom->saveXML(); // передача строки в test1
$dom->save('xml/cian_feed_2.xml'); // сохранение файла

echo 'Колво блоков'.$blocks_count.'<br>';
echo 'Колво объектов'.$objects_count.'<br>';


//header("Location: http://industry.gorki.ru/xml_industry_new_obj.php?page=$next_page"); 

echo (microtime(true) - $start);
?>
