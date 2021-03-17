
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

/*
$filedir = $_SERVER['DOCUMENT_ROOT']."/data/images/c_industry/$object_id/";
$filedir = $_SERVER['DOCUMENT_ROOT']."/watermark/result/industry/";
$del_photos = scandir($filedir);
foreach($del_photos as $del_photo){
	unlink($filedir.$del_photo);
	echo 'Фото удалено';
}

*/


$start = microtime(true);


$blocks_count = 0;
$objects_count = 0;

require_once('global_pass.php');

//Создает XML-строку и XML-документ при помощи DOM
$dom = new DomDocument('1.0','UTF-8');

//добавление корня - <books>
$feed = $dom->appendChild($dom->createElement('realty-feed'));

$xmlns = $dom->createAttribute('xmlns');
// Value for the created attribute
$xmlns->value = 'http://webmaster.yandex.ru/schemas/feed/realty/2010-06';
// Don't forget to append it to the element
$feed->appendChild($xmlns);

//добавление элемента <$feed_version> в <$feed>
$feed_version = $feed->appendChild($dom->createElement('generation-date'));
//$curr_time = date('');
$feed_version->appendChild($dom->createTextNode('2010-12-11T12:00:00+04:00'));




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




    $blocks_sql = $pdo->prepare("SELECT * FROM c_industry_blocks WHERE parent_id='".$object_item->id."' AND import_yandex='1' AND deleted!='1' AND result='5' ");
    $blocks_sql->execute();
    if($blocks_sql->rowCount() > 0) { /*echo "не пустой: ".$object_item->id."<br>"*/;


        //ФОТОГРАФИИ////////////////////////////////////////////////////////////////////////////////////

        $object_id = $object_item->id;

        $obj_photo_array = array();

        //$filedir = $_SERVER['DOCUMENT_ROOT']."/data/images/c_industry/$object_id/";
        $filedir = $_SERVER['DOCUMENT_ROOT']."/watermark/result/industry/";
        $block_photos = scandir($filedir);

        $curr_block_photos = array();
        foreach($block_photos as $photo){
            $block_find = explode('-',$photo);
            $block_find = $block_find[0];
            if( $block_find == $object_id){
                array_push($curr_block_photos, $photo);
            }
        }

        /*
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

                                    array_push($obj_photo_array, "http://industry.gorki.ru/watermark/result/industry/$object_id-$block_photo");

                }
            }

        }
        */



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
                $postObjectDeal = 'аренда';
                in_array(4,$object_deals) ? $leaseType_value = 'subrent' :   $leaseType_value = 'direct rent';
            }else{
                $postObjectDeal = 'продажа';
            }



            if($postObjectDeal == 'продажа'){
                $price_value = $block->sale_price*$block->area2;
                $clientFee_value = $block->owner_pays_howmuch_4client_sale;
            }else{
                $price_value = (($block->rent_price)*($block->area2))/12;
                $clientFee_value = $block->owner_pays_howmuch_4client;
            }

            //ПОПРАВКА ПРОВЕРКА СТОИМОСТИ
            if($block->rent_price == 0){
                $postObjectDeal = 'продажа';
                $price_value = $block->sale_price*$block->area2;
                $clientFee_value = $block->owner_pays_howmuch_4client_sale;
            }

            if($block->payinc == 'usn'){
                $taxform = 'УСН';
            }elseif($block->payinc == 'nds'){
                $taxform = 'НДС';
            }else{

            }


            //добавление элемента <offer> в <realty-feed>
            $offer = $feed->appendChild($dom->createElement('offer'));
            $internalId = $dom->createAttribute('internal-id');
            // Value for the created attribute
            $internalId->value = $block->parent_id.'-'.$block->id_visual;
            // Don't forget to append it to the element
            $offer->appendChild($internalId);

            //ТИП ОБЪЯВЛЕНИЯ
            $type = $offer->appendChild($dom->createElement('type'));
            $type->appendChild($dom->createTextNode($postObjectDeal));

            //КАТЕГОРИЯ ОБЪЯВЛЕНИЯ
            $сategory = $offer->appendChild($dom->createElement('category'));
            $сategory->appendChild($dom->createTextNode('commercial'));

            //ТИП  ОБЪЯВЛЕНИЯ
            $commercial_type = $offer->appendChild($dom->createElement('commercial-type'));
            $commercial_type->appendChild($dom->createTextNode('warehouse'));

            //ТИП ЗДАНИЯ  ОБЪЯВЛЕНИЯ
            $building_type = $offer->appendChild($dom->createElement('commercial-building-type'));
            $building_type->appendChild($dom->createTextNode('warehouse'));

            //ДАТА СОЗДАНИЯ ОБЪЯВЛЕНИЯ
            $creation_date = $offer->appendChild($dom->createElement('creation-date'));
            //$creation_date->appendChild($dom->createTextNode(date("Y-m-dTH:i:s+04:00 ",strtotime($block->dt_update_full))));
            $creation_date->appendChild($dom->createTextNode(date(DATE_ATOM,strtotime($block->dt_update_full))));
            //$creation_date->appendChild($dom->createTextNode(date("Y-m-dTH:i:s+04:00 ",strtotime($block->dt_update_full))));

            //ДАТА ОБНОВЛЕНИЯ ОБЪЯВЛЕНИЯ
            $last_update_date = $offer->appendChild($dom->createElement('last-update-date'));
            $last_update_date->appendChild($dom->createTextNode(date(DATE_ATOM,strtotime($block->dt_update_full))));

            //ЯНДЕКС ПРЕМИУМ
            if($block->import_yandex_premium == 2){
                $vas_premium = $offer->appendChild($dom->createElement('vas'));
                $vas_premium->appendChild($dom->createTextNode('premium'));
            }

            //ЯНДЕКС ПОДНЯТЬ
            if($block->import_yandex_raise == 1){
                $vas_premium = $offer->appendChild($dom->createElement('vas'));
                $vas_premium->appendChild($dom->createTextNode('raise'));
            }

            //ЯНДЕКС ПРОДВИНУТЬ
            if($block->import_yandex_promotion == 2){
                $vas_premium = $offer->appendChild($dom->createElement('vas'));
                $vas_premium->appendChild($dom->createTextNode('promotion'));
            }

            //МЕСТОПОЛОЖЕНИЕ
            $location = $offer->appendChild($dom->createElement('location'));
            $country = $location->appendChild($dom->createElement('country'));
            $country->appendChild($dom->createTextNode('Россия'));

            //$district = $location->appendChild($dom->createElement('district'));
            //$district->appendChild($dom->createTextNode('Москва'));

            //$locality_name = $location->appendChild($dom->createElement('locality-name'));
            //$locality_name->appendChild($dom->createTextNode('г Москва'));

            //$sub_locality_name = $location->appendChild($dom->createElement('sub-locality-name'));
            //$sub_locality_name->appendChild($dom->createTextNode('Центральный'));

            $address = $location->appendChild($dom->createElement('address'));
            $address->appendChild($dom->createTextNode($object_item->yandex_address_str));

            if($highway->title){
                $direction = $location->appendChild($dom->createElement('direction'));
                $direction->appendChild($dom->createTextNode($highway->title));
            }

            if($object_item->otmkad){
                $distance = $location->appendChild($dom->createElement('distance'));
                $distance->appendChild($dom->createTextNode($object_item->otmkad));
            }

            $latitude = $location->appendChild($dom->createElement('latitude'));
            $latitude->appendChild($dom->createTextNode($object_item->c_y));

            $longitude = $location->appendChild($dom->createElement('longitude'));
            $longitude->appendChild($dom->createTextNode($object_item->c_x));

            /*
                //МЕТРО
                if($metro->title && $object_item->metro) {
                $metro = $offer->appendChild($dom->createElement('metro'));
                        $name = $metro->appendChild($dom->createElement('name'));
                        $name->appendChild($dom->createTextNode($metro->title));

                        if($object_item->from_metro){
                        $Time = $metro->appendChild($dom->createElement('time-on-foot'));
                        $Time->appendChild($dom->createTextNode($object_item->from_metro));
                        }

                }
            */

            //КЛАСС ОБЪЕКТА
            $class_tag = $offer->appendChild($dom->createElement('office-class'));
            $class_tag->appendChild($dom->createTextNode($class->title));

            //ВЫСОТА ПОТОЛКОВ
            $ceiling_height_tag = $offer->appendChild($dom->createElement('ceiling-height'));
            $ceiling_height_tag->appendChild($dom->createTextNode($block->ceiling_height2));

            //ЕСТЬ ЛИ СТОЛОВАЯ
            $eating_facilities = $offer->appendChild($dom->createElement('eating-facilities'));
            $eating_facilities->appendChild($dom->createTextNode($hasBuffet));


            //БРОКЕР
            $agent = $offer->appendChild($dom->createElement('sales-agent'));

            $Phone = $agent->appendChild($dom->createElement('phone'));
            $Phone->appendChild($dom->createTextNode('+79263705570'));

            $category = $agent->appendChild($dom->createElement('category'));
            $category->appendChild($dom->createTextNode('agency'));

            $organization = $agent->appendChild($dom->createElement('organization'));
            $organization->appendChild($dom->createTextNode('Penny Lane Realty'));

            $url = $agent->appendChild($dom->createElement('url'));
            $url->appendChild($dom->createTextNode('http://industry.realtor.ru'));

            $photo = $agent->appendChild($dom->createElement('photo'));
            $photo->appendChild($dom->createTextNode('http://industry.realtor.ru/public/images/ico/logo-plr-ver2.png'));


            //УСЛОВИЯ СДЕЛКИ
            $price = $offer->appendChild($dom->createElement('price'));

            //ЦЕНА
            $value = $price->appendChild($dom->createElement('value'));
            $value->appendChild($dom->createTextNode($price_value));

            //ВАЛЮТА
            $currency = $price->appendChild($dom->createElement('currency'));
            $currency->appendChild($dom->createTextNode('RUB'));

            if($postObjectDeal == 'аренда'){
                //ПЕРИОД ОПЛАТЫ
                $period = $price->appendChild($dom->createElement('period'));
                $period->appendChild($dom->createTextNode('month'));
            }


            if($taxform){
                //СИСТЕМА
                $VatType = $price->appendChild($dom->createElement('taxation-form'));
                $VatType->appendChild($dom->createTextNode($taxform));
            }

            //КОМИССИЯ ОТ ПРЯМОГО КЛИЕНТА
            $commission = $offer->appendChild($dom->createElement('commission'));
            $commission->appendChild($dom->createTextNode('0'));

            //ОБЕСПЕЧИТЕЛЬНЫЙ ДЕПОЗИТ
            $SecurityDeposit = $offer->appendChild($dom->createElement('security-payment'));
            $SecurityDeposit->appendChild($dom->createTextNode('0'));

            //Включены ли ништяки в стоимость?
            $utilities_included = $offer->appendChild($dom->createElement('utilities-included'));
            $utilities_included->appendChild($dom->createTextNode('true'));


            //ТИП АРЕНДЫ
            if($postObjectDeal == 'аренда'){
                $LeaseType = $offer->appendChild($dom->createElement('deal-status'));
                $LeaseType->appendChild($dom->createTextNode($leaseType_value));
            }

            //ВКЛЮЧЕНО В СТАВКУ
            $area = $offer->appendChild($dom->createElement('area'));

            $value = $area->appendChild($dom->createElement('value'));
            $value->appendChild($dom->createTextNode($block->area2));

            $unit = $area->appendChild($dom->createElement('unit'));
            $unit->appendChild($dom->createTextNode('кв. м'));

            echo $block->parent_id.'-'.$block->id_visual.' :: '.count($curr_block_photos).':   '.implode('--',$curr_block_photos).'<br><br>';
            //ФОТО
            $photo_num = 0;
            foreach($curr_block_photos as $block_photo){

                $photo_num++;

                echo $photo_num;
                echo '<br>';
                echo 'http://industry.gorki.ru/watermark/result/industry/'.$block_photo;
                echo '<br>';

                if($image = $offer->appendChild($dom->createElement('image'))){
                    echo 'создали';

                }
                //$image = $offer->appendChild($dom->createElement('image'));
                $image->appendChild($dom->createTextNode('http://industry.gorki.ru/watermark/result/industry/'.$block_photo));

            }

            echo '<br>';
            echo '<br>';

            //РЕМОНТ
            $renovation = $offer->appendChild($dom->createElement('renovation'));
            $renovation->appendChild($dom->createTextNode('хороший'));

            //СОСТОЯНИЕ
            $quality = $offer->appendChild($dom->createElement('quality'));
            $quality->appendChild($dom->createTextNode('хорошее'));

            //ОПИСАНИЕ
            $Description = $offer->appendChild($dom->createElement('description'));
            $Description->appendChild($dom->createTextNode($block->description ? $block->description: $block->description_handmade));

            /*
            //ИНТЕРНЕТ
            $image = $offer->appendChild($dom->createElement('image-included'));
            $image->appendChild($dom->createTextNode('http://commer.ru/image/1.jpg'));

            //ВЕНТИЛЯЦИЯ
            $image = $offer->appendChild($dom->createElement('image-included'));
            $image->appendChild($dom->createTextNode('http://commer.ru/image/1.jpg'));

            //ПОЖАРНАЯ СИГНАЛИЗАЦИЯ
            $image = $offer->appendChild($dom->createElement('image-included'));
            $image->appendChild($dom->createTextNode('http://commer.ru/image/1.jpg'));

            //ОТАПЛИВАЕМЫЙ
            $image = $offer->appendChild($dom->createElement('image-included'));
            $image->appendChild($dom->createTextNode('http://commer.ru/image/1.jpg'));

            //ЕСТЬ ЭЛЕКТРИЧЕСТВО
            $image = $offer->appendChild($dom->createElement('image-included'));
            $image->appendChild($dom->createTextNode('http://commer.ru/image/1.jpg'));

*/
            //ЭТАЖ
            $floor = $offer->appendChild($dom->createElement('floor'));
            $floor->appendChild($dom->createTextNode($block->floor));

            //ВСЕГО ЭТАЖЕЙ
            $floors = $offer->appendChild($dom->createElement('floors-total'));
            $floors->appendChild($dom->createTextNode($object_item->floors));

            //НАЗВАНИЕ КОМПЛЕКСА
            $building_name = $offer->appendChild($dom->createElement('building-name'));
            $building_name->appendChild($dom->createTextNode($object_item->yandex_address_str));

            if($object_item->year_build){
                //ГОД ПОСТРОЙКИ
                $built_year = $offer->appendChild($dom->createElement('built-year'));
                $built_year->appendChild($dom->createTextNode($object_item->year_build));
            }

            /*


            //СИСТЕМА ДОСТУПА
            $image = $BargainTerms->appendChild($dom->createElement('image-included'));
            $image->appendChild($dom->createTextNode('http://commer.ru/image/1.jpg'));

            //ВИДЕОНАБЛЮДЕНИЕ
            $image = $BargainTerms->appendChild($dom->createElement('image-included'));
            $image->appendChild($dom->createTextNode('http://commer.ru/image/1.jpg'));

            //ЛИФТЫ
            $image = $BargainTerms->appendChild($dom->createElement('image-included'));
            $image->appendChild($dom->createTextNode('http://commer.ru/image/1.jpg'));

            //ОХРАНА
            $image = $BargainTerms->appendChild($dom->createElement('image-included'));
            $image->appendChild($dom->createTextNode('http://commer.ru/image/1.jpg'));

            //ОХРАНА
            $image = $BargainTerms->appendChild($dom->createElement('image-included'));
            $image->appendChild($dom->createTextNode('http://commer.ru/image/1.jpg'));


                //Ответственное хранение.
                $image = $BargainTerms->appendChild($dom->createElement('image-included'));
                $image->appendChild($dom->createTextNode('http://commer.ru/image/1.jpg'));

                //Стоимость палето-места в месяц в рублях с учетом налогов
                $image = $BargainTerms->appendChild($dom->createElement('image-included'));
                $image->appendChild($dom->createTextNode('http://commer.ru/image/1.jpg'));

                //Наличие грузового лифта.
                $image = $BargainTerms->appendChild($dom->createElement('image-included'));
                $image->appendChild($dom->createTextNode('http://commer.ru/image/1.jpg'));

                //Возможность подъезда фуры.
                $image = $BargainTerms->appendChild($dom->createElement('image-included'));
                $image->appendChild($dom->createTextNode('http://commer.ru/image/1.jpg'));

                //Наличие пандуса.
                $image = $BargainTerms->appendChild($dom->createElement('image-included'));
                $image->appendChild($dom->createTextNode('http://commer.ru/image/1.jpg'));

                //Наличие ветки железной дороги.
                $image = $BargainTerms->appendChild($dom->createElement('image-included'));
                $image->appendChild($dom->createTextNode('http://commer.ru/image/1.jpg'));

                //Наличие офиса на складе.
                $image = $BargainTerms->appendChild($dom->createElement('image-included'));
                $image->appendChild($dom->createTextNode('http://commer.ru/image/1.jpg'));

                //Наличие открытой площадки.
                $image = $BargainTerms->appendChild($dom->createElement('image-included'));
                $image->appendChild($dom->createTextNode('http://commer.ru/image/1.jpg'));

                //Комментарий про температурный режим на складе.
                $image = $BargainTerms->appendChild($dom->createElement('image-included'));
                $image->appendChild($dom->createTextNode('http://commer.ru/image/1.jpg'));

            */








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
$dom->save('xml/yandex_feed_2.xml'); // сохранение файла

echo 'Колво блоков'.$blocks_count.'<br>';
echo 'Колво объектов'.$objects_count.'<br>';


//header("Location: http://industry.gorki.ru/xml_industry_new_obj.php?page=$next_page");

echo (microtime(true) - $start);
?>
