     
<?php

include_once($_SERVER['DOCUMENT_ROOT'].'/global_pass.php');
//include_once($_SERVER['DOCUMENT_ROOT'].'/errors.php');
set_time_limit(0);

$start = microtime(true);


$blocks_count = 0;
$objects_count = 0;

$root = $_SERVER['DOCUMENT_ROOT'];
$root = '/var/www/www-root/data/www/pennylane.pro/';





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
$feed_version->appendChild($dom->createTextNode(date(DATE_ATOM)));


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
    1832,
    3226,
    3202,
    2398,
    2875,
    2187,  
    3292,
    10312,
    3270,
    2084,
    9,
    263,
    2452,
    10403,
    10270,
    1989,
    2382,
    10382,
    10334,
    2887,
    2363,
    120,
    3346,
    3346,
    2526,
    111,
    1750,
    504,
    2469,
    10382,             
    1632,
    10419,
    2519,
];

$blocklist_str = implode(',',$blocklist);

$sql = $pdo->prepare("SELECT * FROM $table WHERE type_id=1 AND  deleted!=1 AND hide_from_market !=1  AND ad_yandex=1 AND is_land !=1 AND status=1 AND (price_floor_min > 0 OR  price_sale_min > 0)   AND  test_only!=1  AND photos!='[\"[]\"]' ");
//$sql = $pdo->prepare("SELECT * FROM $table WHERE (type_id=1 ||  blocks_amount > 1) AND  deleted!='1' AND ad_yandex=1 AND status=1 AND (price_floor_min > 0 OR  price_sale_min > 0)   AND    test_only!=1  AND photos!='[\"[]\"]'AND id NOT IN($blocklist_str)");
//echo "SELECT * FROM $table WHERE deleted!='1' AND ad_yandex=1 AND deal_id=0 AND test_only!=1 AND id NOT IN($blocklist_str)";
//echo '<br>';
//$sql = $pdo->prepare("SELECT * FROM $table WHERE object_id=10248");
$sql->execute();
while($item = $sql->fetch(PDO::FETCH_LAZY)){


            $object_building = new Building($item->object_id);


            //добавление элемента <offer> в <realty-feed>
            $offer = $feed->appendChild($dom->createElement('offer'));
            $internalId = $dom->createAttribute('internal-id');
            // Value for the created attribute
            $internalId->value = $item->visual_id;
            // Don't forget to append it to the element
            $offer->appendChild($internalId);

            //ТИП ОБЪЯВЛЕНИЯ
            $type = $offer->appendChild($dom->createElement('type'));   
            if($item->deal_type == 2){
                $type_name = 'Продажа';
            }else{
                $type_name = 'Аренда';
            }
            $type->appendChild($dom->createTextNode($type_name));

            //КАТЕГОРИЯ ОБЪЯВЛЕНИЯ
            $category = $offer->appendChild($dom->createElement('category'));
            $category->appendChild($dom->createTextNode('commercial'));

            //ТИП  ОБЪЯВЛЕНИЯ
            $commercial_type = $offer->appendChild($dom->createElement('commercial-type'));
            $type_obj = min(json_decode($item->object_type));
            if($type_obj == 1 || $type_obj == 3){
                $commercial = 'warehouse';
            }else{
                $commercial = 'manufacturing';
            }
            if($item->is_land){
                $commercial = 'land';
            }
            $commercial_type->appendChild($dom->createTextNode($commercial));

            //ТИП ЗДАНИЯ  ОБЪЯВЛЕНИЯ
            /*
            $building_type = $offer->appendChild($dom->createElement('commercial-building-type'));
            $building_type->appendChild($dom->createTextNode('warehouse'));
            */

            //Назанчения склада Yandex
            $names_arr = [
                '10'=>'alcohol',
                '11'=>'pharmaceutical storehouse',
                '12'=>'vegetable storehouse',
            ];
            $purposes = json_decode($item->purposes);
            foreach ($purposes as $purpose){
                if(in_array($purpose,[10,11,12])){
                    $name = $names_arr[$purpose];
                    $purpose_warehouse = $offer->appendChild($dom->createElement('purpose-warehouse'));
                    $purpose_warehouse->appendChild($dom->createTextNode($name));
                }
            }


            //Назанчения склада Yandex
            $lot_number = $offer->appendChild($dom->createElement('lot-number'));
            $lot_number->appendChild($dom->createTextNode($item->visual_id));

            //ССЫЛКА НА ЛОТ
            $lot_url = $offer->appendChild($dom->createElement('url'));
            $lot_url->appendChild($dom->createTextNode('http://realtor.ru'));



            //КАДАСТРОВЫЙ НОМЕР
            if($item->is_land){
                if($item->cadastral_number_land){
                    $cadastral_number = $offer->appendChild($dom->createElement('cadastral-number'));
                    $cadastral_number->appendChild($dom->createTextNode($item->cadastral_number_land));
                }
            }else{
                if($item->cadastral_number){
                    $cadastral_number = $offer->appendChild($dom->createElement('cadastral-number'));
                    $cadastral_number->appendChild($dom->createTextNode($item->cadastral_number));
                }
            }


            //ДАТА СОЗДАНИЯ ОБЪЯВЛЕНИЯ
            $creation_date = $offer->appendChild($dom->createElement('creation-date'));
            $creation_date->appendChild($dom->createTextNode(date(DATE_ATOM,$item->last_update)));

            //ДАТА ОБНОВЛЕНИЯ ОБЪЯВЛЕНИЯ
            $last_update_date = $offer->appendChild($dom->createElement('last-update-date'));
            $last_update_date->appendChild($dom->createTextNode(date(DATE_ATOM,$item->last_update)));


            /*
            //ЯНДЕКС ПРЕМИУМ
            if($item->ad_yandex_premium == 1){
                $vas_premium = $offer->appendChild($dom->createElement('vas'));
                $vas_premium->appendChild($dom->createTextNode('premium'));
            }

            //ЯНДЕКС ПОДНЯТЬ
            if($item->ad_yandex_raise == 1){
                $vas_premium = $offer->appendChild($dom->createElement('vas'));
                $vas_premium->appendChild($dom->createTextNode('raise'));
            }


            //ЯНДЕКС ПРОДВИНУТЬ
            if($item->ad_yandex_promotion == 1){
                $vas_premium = $offer->appendChild($dom->createElement('vas'));
                $vas_premium->appendChild($dom->createTextNode('promotion'));
            }
            */

            //МЕСТОПОЛОЖЕНИЕ
            $location = $offer->appendChild($dom->createElement('location'));
            $country = $location->appendChild($dom->createElement('country'));
            $country->appendChild($dom->createTextNode('Россия'));

            $district = $location->appendChild($dom->createElement('region'));
            $district->appendChild($dom->createTextNode($item->region_name));

            if($item->town){
                $locality_name = $location->appendChild($dom->createElement('locality-name'));
                $locality_name->appendChild($dom->createTextNode($item->town_name));
            }


            //$sub_locality_name = $location->appendChild($dom->createElement('sub-locality-name'));
            //$sub_locality_name->appendChild($dom->createTextNode('Центральный'));


            $address = $location->appendChild($dom->createElement('address'));
            $address->appendChild($dom->createTextNode($item->address));

            if($item->highway){
                $direction = $location->appendChild($dom->createElement('direction'));
                $direction->appendChild($dom->createTextNode($item->highway_name));
            }elseif($item->highway_moscow) {
                $direction = $location->appendChild($dom->createElement('direction'));
                $direction->appendChild($dom->createTextNode($item->highway_moscow_name));
            }else{

            }

            if($item->from_mkad){
                $distance = $location->appendChild($dom->createElement('distance'));
                $distance->appendChild($dom->createTextNode($item->from_mkad));
            }

            if($item->latitude && $item->longitude){
                $latitude = $location->appendChild($dom->createElement('latitude'));
                $latitude->appendChild($dom->createTextNode($item->latitude));

                $longitude = $location->appendChild($dom->createElement('longitude'));
                $longitude->appendChild($dom->createTextNode($item->longitude));

            }




                //МЕТРО
            if($item->metro) {
                    $metro = $location->appendChild($dom->createElement('metro'));
                        $name = $metro->appendChild($dom->createElement('name'));
                        $name->appendChild($dom->createTextNode($item->metro));

                        if($item->from_metro == 1){
                            $Time = $metro->appendChild($dom->createElement('time-on-foot'));
                            $Time->appendChild($dom->createTextNode($item->from_metro_value));
                        }

                        if($item->from_metro == 2){
                            $Time = $metro->appendChild($dom->createElement('time-on-transport'));
                            $Time->appendChild($dom->createTextNode($item->from_metro_value));
                        }

            }

            //Ж/Д станция
            if($item->railway_station){
                $railway_station = $location->appendChild($dom->createElement('railway-station'));
                $railway_station->appendChild($dom->createTextNode($item->railway_station));
            }

            //КЛАСС ОБЪЕКТА
            if($item->class){
                $class_tag = $offer->appendChild($dom->createElement('office-class'));
                $class_tag->appendChild($dom->createTextNode($item->class_name));
            }


            //ВЫСОТА ПОТОЛКОВ
            if($item->ceiling_height_max){
                $ceiling_height_tag = $offer->appendChild($dom->createElement('ceiling-height'));
                $ceiling_height_tag->appendChild($dom->createTextNode($item->ceiling_height_max));
            }


            //ЕСТЬ ЛИ СТОЛОВАЯ
            if($item->canteen) {
                $eating_facilities = $offer->appendChild($dom->createElement('eating-facilities'));
                $eating_facilities->appendChild($dom->createTextNode((bool)$item->canteen));
            }


            //БРОКЕР
            $agent = $offer->appendChild($dom->createElement('sales-agent'));

            $agent_obj = new Member($item->agent_id);

            $Name = $agent->appendChild($dom->createElement('name'));
            $Name->appendChild($dom->createTextNode($agent_obj->getField('first_name').' '.$agent_obj->getField('last_name')));

            $Phone = $agent->appendChild($dom->createElement('phone'));
            //$Phone->appendChild($dom->createTextNode('+79263705570'));
            //$Phone->appendChild($dom->createTextNode('+79263705570'));
            $Phone->appendChild($dom->createTextNode('+74951500323'));

            $category = $agent->appendChild($dom->createElement('category'));
            $category->appendChild($dom->createTextNode('agency'));

            $organization = $agent->appendChild($dom->createElement('organization'));
            $organization->appendChild($dom->createTextNode('Penny Lane Realty'));

            //ПОЧТА
            $email = $agent->appendChild($dom->createElement('email'));
            $email->appendChild($dom->createTextNode('sklad@realtor.ru'));

            $url = $agent->appendChild($dom->createElement('url'));
            $url->appendChild($dom->createTextNode('http://industry.realtor.ru'));

            $photo_com = $agent->appendChild($dom->createElement('photo'));
            $photo_com->appendChild($dom->createTextNode('https://sun9-4.userapi.com/c854528/v854528867/16b54b/PhgVGDdoWZk.jpg'));


            //УСЛОВИЯ СДЕЛКИ
            $price = $offer->appendChild($dom->createElement('price'));

            //ЦЕНА
            $value = $price->appendChild($dom->createElement('value'));
            if($item->deal_type == 2) {

                if($item->is_land){
                    $price_value = $item->price_floor_max;
                    if (!$price_value) {
                        $price_value = $item->price_floor_max;
                    }
                    $price_value = $price_value*100;
                }else{
                    $price_value = $item->price_sale_max;
                    if (!$price_value) {
                        $price_value = $item->price_sale_max;
                    }
                }
            }elseif($item->deal_type == 3){
                $price_value = $item->price_safe_pallet_min;
                if (!$price_value) {
                    $price_value = $item->price_safe_pallet_max;
                }
                $price_value = $price_value*30;
            }else{
                $price_value = $item->price_floor_max/12;
                if(!$price_value){
                    $price_value = $item->price_floor_max/12;
                }
            }
            if($item->tax_form == 'без ндс' || $item->tax_form == 'triple net' ){
                $vat_mult =1.2;
            }else{
                $vat_mult = 1;
            }
            $value->appendChild($dom->createTextNode(((int)$price_value)*$vat_mult));

            //ВАЛЮТА
            $currency = $price->appendChild($dom->createElement('currency'));
            $currency->appendChild($dom->createTextNode('RUB'));

            //ЕДИНИЦА ИЗМЕРЕНИЯ
            $price_unit = $price->appendChild($dom->createElement('unit'));
            if($item->is_land && $item->deal_type == 2 ){
                $pr_unit = 'сотка';
            }else{
                $pr_unit = 'кв.м';
            }
            $price_unit->appendChild($dom->createTextNode($pr_unit));

            if($item->deal_type!= 2){
                //ПЕРИОД ОПЛАТЫ
                $period = $price->appendChild($dom->createElement('period'));
                $period->appendChild($dom->createTextNode('month'));
            }


            if($item->tax_form){
                //СИСТЕМА
                $VatType = $price->appendChild($dom->createElement('taxation-form'));
                if($item->tax_form == 'с ндс'){
                    $vat_inc='НДС';
                }elseif($item->tax_form == 'без ндс' ){
                    $vat_inc='НДС';
                }elseif($item->tax_form == 'triple net' ){
                    $vat_inc='НДС';
                }elseif($item->tax_form == 'усн' ){
                    $vat_inc='УСН';
                }else{

                }
                $VatType->appendChild($dom->createTextNode($vat_inc));
            }

            //КОМИССИЯ ОТ ПРЯМОГО КЛИЕНТА
            if($item->commission_client){
                $commission = $offer->appendChild($dom->createElement('commission'));
                $commission->appendChild($dom->createTextNode($item->commission_client));
            }


            //ОБЕСПЕЧИТЕЛЬНЫЙ ДЕПОЗИТ
            if($item->deposit){
                $SecurityDeposit = $offer->appendChild($dom->createElement('security-payment'));
                $SecurityDeposit->appendChild($dom->createTextNode(100*$item->deposit));
            }

            //ЗАЛОГ
            if($item->pledge == 1){
                $Pledge = $offer->appendChild($dom->createElement('rent-pledge'));
                $pledge = $Pledge->appendChild($dom->createTextNode(true));
            }


            //ОПЛАТА
            if(1){
                $prePayment = $offer->appendChild($dom->createElement('prepayment'));
                $prePayment->appendChild($dom->createTextNode(100));
            }



            //Включены ли электричество
            $electricity_included = $offer->appendChild($dom->createElement('electricity-included'));
            if($item->inc_electricity){
                $el_inc = 'true';
            }else{
                $el_inc = 'false';
            }
            $electricity_included->appendChild($dom->createTextNode($el_inc));

            //Включены ли уборка
            $cleaning_included = $offer->appendChild($dom->createElement('cleaning-included'));
            $cleaning_included->appendChild($dom->createTextNode('false'));

            //Включены ли ништяки в стоимость?
            $utilities_included = $offer->appendChild($dom->createElement('utilities-included'));
            if($item->inc_electricity || $item->inc_water || $item->inc_heating){
                $ut_inc = 'true';
            }else{
                $ut_inc = 'false';
            }
            $utilities_included->appendChild($dom->createTextNode($ut_inc));


            //ТИП АРЕНДЫ
            if($item->deal_type != 2){
                if($item->deal_type != 4){
                    $rent_type = 'direct rent';
                }else{
                    $rent_type = 'subrent';
                }
                $LeaseType = $offer->appendChild($dom->createElement('deal-status'));
                $LeaseType->appendChild($dom->createTextNode($rent_type));
            }




            //ВКЛЮЧЕНО В СТАВКУ
            $area = $offer->appendChild($dom->createElement('area'));

            $area_val = (int)$item->area_max;

            if($item->is_land && $item->deal_type == 2 ){
                $area_val = $area_val/100;
            }

            $value = $area->appendChild($dom->createElement('value'));
            $value->appendChild($dom->createTextNode($area_val));

            $unit = $area->appendChild($dom->createElement('unit'));
            if($item->is_land && $item->deal_type == 2){
                $ar_unit = 'сотка';
            }else{
                $ar_unit = 'кв.м';
            }
            $unit->appendChild($dom->createTextNode($ar_unit));

            echo $block->parent_id.'-'.$block->id_visual.' :: '.count($curr_block_photos).':   '.implode('--',$curr_block_photos).'<br><br>';
            //ФОТО
            $photo_num = 0;
            $photos = json_decode($item->photos);
            foreach($photos as $photo){

                $photo = str_replace('//', '/', $photo);

                $photo_way_arr = explode('/',$photo);

                $name = array_pop($photo_way_arr);
                $post = (int)array_pop($photo_way_arr);


                if($image = $offer->appendChild($dom->createElement('image'))){
                    echo 'создали';

                }
                //$image = $offer->appendChild($dom->createElement('image'));
                $image->appendChild($dom->createTextNode(PROJECT_URL.'/system/controllers/photos/watermark.php/1900/'.$post.'/'.$name));
                //$image->appendChild($dom->createTextNode(PROJECT_URL.'/system/controllers/photos/watermark_all.php?width=1600&photo='.PROJECT_URL.$photo));

            }

            echo '<br>';
            echo '<br>';

            //РЕМОНТ
            //$renovation = $offer->appendChild($dom->createElement('renovation'));
            //$renovation->appendChild($dom->createTextNode('хороший'));

            //СОСТОЯНИЕ
            //$quality = $offer->appendChild($dom->createElement('quality'));
            //$quality->appendChild($dom->createTextNode('хорошее'));

            //ОПИСАНИЕ
            $Description = $offer->appendChild($dom->createElement('description'));
            $original_id = $item->original_id;
            $original_type = $item->type_id;
            ob_start();
            include($root."/autodesc.php");
            $desc = ob_get_clean();
            $Description->appendChild($dom->createTextNode(strip_tags($desc)));

            //Вход в блок
            $entrance_type = $offer->appendChild($dom->createElement('entrance-type'));
            $entrance_type->appendChild($dom->createTextNode('separate'));


            //ИНТЕРНЕТ
            $internet = $offer->appendChild($dom->createElement('internet'));
            if($item->internet){
                $internet_val = 'true';
            }else{
                $internet_val = 'false';
            }
            $internet->appendChild($dom->createTextNode($internet_val));








            //ВЕНТИЛЯЦИЯ
            //$air_cond = $offer->appendChild($dom->createElement('air-conditioner'));
            //$air_cond->appendChild($dom->createTextNode(''));

            //ПОЖАРНАЯ СИГНАЛИЗАЦИЯ
            if($item->ventilation ){
                $ventilation = $offer->appendChild($dom->createElement('ventilation'));
                $ventilation->appendChild($dom->createTextNode('true'));
            }


            //ОТАПЛИВАЕМЫЙ
            if($item->fire_alert == 1){
                $fire_alarm = $offer->appendChild($dom->createElement('fire-alarm'));
                $fire_alarm->appendChild($dom->createTextNode('true'));
            }


            //ЕСТЬ ВОДА
            if($item->water == 1){
                $water_supply = $offer->appendChild($dom->createElement('water-supply'));
                $water_supply->appendChild($dom->createTextNode('true'));
            }


            //ЕСТЬ ЭЛЕКТРИЧЕСТВО
            if($item->sewage_central == 1) {
                $sewerage_supply = $offer->appendChild($dom->createElement('sewerage-supply'));
                $sewerage_supply->appendChild($dom->createTextNode(1));
            }

            //ЕСТЬ ЭЛЕКТРИЧЕСТВО
            if($item->heated == 1) {
                $heating_supply = $offer->appendChild($dom->createElement('heating-supply'));
                $heating_supply->appendChild($dom->createTextNode('true'));
            }

            //ЕСТЬ ЭЛЕКТРИЧЕСТВО
            if($item->electricity ) {
                $electricity_supply = $offer->appendChild($dom->createElement('electricity-supply'));
                $electricity_supply->appendChild($dom->createTextNode('true'));
            }

            //ЕСТЬ ЭЛЕКТРИЧЕСТВО
            if($item->power_value) {
                $electric_capacity = $offer->appendChild($dom->createElement('electric-capacity'));
                $electric_capacity->appendChild($dom->createTextNode($item->power_value));
            }

            //ЕСТЬ ЭЛЕКТРИЧЕСТВО
            if($item->gas == 1) {
                $gas_supply = $offer->appendChild($dom->createElement('gas-supply'));
                $gas_supply->appendChild($dom->createTextNode('true'));
            }

            //ЕСТЬ ОХРАНА
            if($item->guard) {
                $guarded_building = $offer->appendChild($dom->createElement('guarded-building'));
                $guarded_building->appendChild($dom->createTextNode('true'));
            }

            //ЕСТЬ СИСТЕМА ДОСТУПА
            if($item->guard ) {
                $access_control_system = $offer->appendChild($dom->createElement('access-control-system'));
                $access_control_system->appendChild($dom->createTextNode('true'));
            }

            //Лифты
            if($item->elevators_num) {
                $lift = $offer->appendChild($dom->createElement('lift'));
                $lift->appendChild($dom->createTextNode('true'));

                $lift_load = $offer->appendChild($dom->createElement('freight-elevator'));
                $lift_load->appendChild($dom->createTextNode('true'));
            }


            //Охрана
            if($item->guard) {
                $security = $offer->appendChild($dom->createElement('security'));
                $security->appendChild($dom->createTextNode('true'));
            }





            //-------ОТВЕТКА-----------//


            if($item->deal_type == 3){
                //ЕСТЬ ЭЛЕКТРИЧЕСТВО
                $responsible_storage = $offer->appendChild($dom->createElement('responsible-storage'));
                $responsible_storage->appendChild($dom->createTextNode('true'));

                //ЕСТЬ ЭЛЕКТРИЧЕСТВО
                $pallet_price = $offer->appendChild($dom->createElement('pallet-price'));
                $pallet_price->appendChild($dom->createTextNode($item->price_safe_pallet_min));
            }


            //ПАРКОВКА ГРУЗОВИКОВ
            if($item->parking_truck){
                $truck_entrance = $offer->appendChild($dom->createElement('truck-entrance'));
                $truck_entrance->appendChild($dom->createTextNode('true'));
            }


            //ЕСТЬ ЭЛЕКТРИЧЕСТВО
            if($item->railway == 1){
                $railway = $offer->appendChild($dom->createElement('railway'));
                $railway->appendChild($dom->createTextNode('true'));
            }

            //ЕСТЬ РАМПА
            $gates = json_decode($item->gates);
            $has_ramp = 0;
            foreach($gates as $gate){
                if($gate === "1" | $gate === "3" || $gate === "4"){
                    $has_ramp = 1;
                    break;
                }
            }
            if($has_ramp){
                $ramp = $offer->appendChild($dom->createElement('ramp'));
                $ramp->appendChild($dom->createTextNode('true'));
            }


            //ОТКРЫТАЯ ПЛОЩАДЬ
            if($item->area_field_min || $item->area_field_max){
                $open_area = $offer->appendChild($dom->createElement('open-area'));
                $open_area->appendChild($dom->createTextNode(1));
            }

            //ТЕМПЕРАТУРА
            if($item->temperature_min){
                $temperature_comment = $offer->appendChild($dom->createElement('temperature-comment'));
                $temp = '';
                if($temp_min = $item->temperature_min){
                    ($temp_min > 0) ? $temp_min_sign='+' : $temp_min_sign='';
                    $temp = $temp.$temp_min_sign.$temp_min;
                }
                if($temp_max = $item->temperature_max){
                    $temp.='/';
                    ($temp_max > 0) ? $temp_max_sign='+' : $temp_max_sign='';
                    $temp =  $temp.$temp_max_sign.$temp_max;
                }
                $temperature_comment->appendChild($dom->createTextNode($temp));
            }







            //ЭТАЖ
            if((int)$item->floor_min){
                $floor = $offer->appendChild($dom->createElement('floor'));
                $floor->appendChild($dom->createTextNode((int)$item->floor_min));
            }


            //ВСЕГО ЭТАЖЕЙ
            if((int)$object_building->getField('floors')) {
                $floors = $offer->appendChild($dom->createElement('floors-total'));
                $floors->appendChild($dom->createTextNode((int)$object_building->getField('floors')));
            }

            //НАЗВАНИЕ КОМПЛЕКСА
            //$building_name = $offer->appendChild($dom->createElement('building-name'));
            //$building_name->appendChild($dom->createTextNode($item->address));

            if((int)$object_building->getField('year_build')){
                //ГОД ПОСТРОЙКИ
                $built_year = $offer->appendChild($dom->createElement('built-year'));
                $built_year->appendChild($dom->createTextNode((int)$object_building->getField('year_build')));
            }



            $blocks_count++;


}
//остановился на  LiftTypes
//генерация xml
$dom->formatOutput = true; // установка атрибута formatOutput
// domDocument в значение true
// save XML as string or file
$test1 = $dom->saveXML(); // передача строки в test1
$dom->save('feed.xml'); // сохранение файла

echo 'Колво блоков'.$blocks_count.'<br>';
echo 'Колво объектов'.$objects_count.'<br>';


//header("Location: http://industry.gorki.ru/xml_industry_new_obj.php?page=$next_page"); 

echo (microtime(true) - $start);
?>
