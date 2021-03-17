<?
$start  = time();

//include_once($_SERVER['DOCUMENT_ROOT'].'/errors.php');

include_once($_SERVER['DOCUMENT_ROOT'].'/global_pass.php');



//$logedUser = new Member($_COOKIE['member_id']);
//$telegram = new Bitkit\Social\Telegram('736512998:AAGIlIPVdPdrffvQRmh1Kwoj2_isbvYUKc4');


//$table_id = 11;
//$post_id = 9979;

//ЕСЛИ ПЕРЕДАЕМ ТАБЛИЦУ ЗНАЧИТ ОБНОВЛЯЕМ ЧАСТИЧНО ЛОТ ИНАЧЕ ВСЮ ВЫГРУЗКУ
if($table_id){

    //$message = 'MIX обновлено верх';
    //$telegram->sendMessage($message,$logedUser->getField('telegram_id'));

    //получил ID лота
    if($table_id == 11){ //блоки
        $block_obj = new Subitem($post_id);
        $offer = new Offer($block_obj->getField('offer_id'));
        $object = new Building($offer->getField('object_id'));
        $object_id = $object->getField('id');
        //для удаления
        if($mix_delete){
            $offer_mix = new OfferMix();
            $offer_mix->getRealId($post_id,1);
            $offer_mix->updateField('deleted',1);
        }
    }elseif($table_id == 35){  //части
        $part = new Part($post_id);
        $object = new Building($part->getField('object_id'));
    }elseif($table_id == 16){  //предложения
        $offer = new Offer($post_id);
        $object = new Building($offer->getField('object_id'));
        $object_id = $object->getField('id');
        //для удаления
        if($mix_delete){
            $offer_mix = new OfferMix();
            $offer_mix->getRealId($post_id,2);
            $offer_mix->updateField('deleted',1);

            $blocks = $offer_mix->getJsonField('blocks');
            foreach($blocks as $block_id){
                $offer_mix = new OfferMix((int)$block_id);
                $offer_mix->updateField('deleted',1);
            }
        }
    }elseif($table_id == 5){  //объекты
        $object_id = $post_id;
        //для удаления
        if($mix_delete){
            $sql = $pdo->prepare("UPDATE c_industry_offers_mix SET deleted=1 WHERE object_id=$post_id ");
            $sql->execute();
        }
    }else{
        $objects = [];
        $sql = $pdo->prepare("SELECT * FROM c_industry WHERE complex_id=$post_id ");
        $sql->execute();
        while($test = $sql->fetch(PDO::FETCH_LAZY)){
            $objects[] = $test['id'];
        }
        $object_id = implode(',',$objects);

    }



    //$block_sql = "SELECT * FROM c_industry_blocks b LEFT JOIN c_industry_offers o ON b.offer_id = o.id WHERE o.object_id=$object_id  ";
    //$offer_sql = "SELECT * FROM c_industry_offers o WHERE o.object_id=$object_id   ";
    $block_sql = "SELECT * FROM c_industry_blocks b LEFT JOIN c_industry_offers o ON b.offer_id = o.id WHERE o.object_id IN ($object_id) AND b.deleted !=1  ";
    //$offer_sql = "SELECT * FROM c_industry_offers o WHERE o.object_id IN ($object_id) AND o.deleted !=1  AND (SELECT MIN(b2.status) FROM c_industry_blocks b2 WHERE b2.offer_id = o.id) = 1 ";
    $offer_sql = "SELECT * FROM c_industry_offers o WHERE o.object_id IN ($object_id)  ";
    $action = 'обновления';

}else{

    $object_sql = "SELECT * FROM c_industry  WHERE deleted !=1   ";
    $action = 'выгрузки';
    $sql = $pdo->prepare("DELETE FROM c_industry_offers_mix WHERE type_id=3");
    $sql->execute();



}





/*-------------------------СОЗДАЕМ "ПАССИВНЫЕ" предложения из ЛОТОВ----------*/

if($action == 'выгрузки') {
    //Собираем MIX для блоков
    $sql = $pdo->prepare($object_sql);
    $sql->execute();

    while($object = $sql->fetch(PDO::FETCH_LAZY)){
        $fields_arr = [];
        $values_arr = [];

        $complex = new Complex($object->complex_id);

        $fields_arr = [];
        $values_arr = [];

        //
        $fields_arr[]= 'status';
        $values_arr[]= 2;

        //
        $fields_arr[]= 'parent_id';
        $values_arr[]= $object->id;


        //ID элемента в своей таблице
        $fields_arr[]= 'original_id';
        $values_arr[]= $object->id;
        //Тип элемента 1 - блок 2 - предложение
        $fields_arr[]= 'type_id';
        $values_arr[]= 3;


        $gates_types = [];
        $gates_num = 0;

        //
        $fields_arr[]= 'company_id';
        $values_arr[]= $object->company_id;


        //
        $fields_arr[]= 'area_building';
        $values_arr[]= $object->area_building;

        //
        $fields_arr[]= 'area_floor_full';
        $values_arr[]= $object->area_floor_full;
        //
        $fields_arr[]= 'area_mezzanine_full';
        $values_arr[]= $object->area_mezzanine_full;

        //
        $fields_arr[]= 'area_office_full';
        $values_arr[]= $object->area_office_full;

        //
        $fields_arr[]= 'gas';
        $values_arr[]= $complex->getField('gas');
        //
        $fields_arr[]= 'gas_value';
        $values_arr[]= $complex->getField('gas_value');

        //
        $fields_arr[]= 'steam';
        $values_arr[]= $complex->getField('steam');
        //
        $fields_arr[]= 'steam_value';
        $values_arr[]= $complex->getField('steam_value');

        //
        $fields_arr[]= 'railway';
        $values_arr[]= $complex->getField('railway');
        //
        $fields_arr[]= 'railway_value';
        $values_arr[]= $complex->getField('railway_value');

        //
        $fields_arr[]= 'canteen';
        $values_arr[]= $complex->getField('canteen');

        //
        $fields_arr[]= 'hostel';
        $values_arr[]= $complex->getField('hostel');

        //
        $fields_arr[]= 'water';
        $res = 0;
        if($complex->getField('water')){
            $item = new Post($complex->getField('water'));
            $item->getTable('l_waters');
            $res= $item->title();
        }
        $values_arr[] = $res;

        //
        $fields_arr[]= 'water_value';
        $values_arr[]= $complex->getField('water_value');

        $fields_arr[]= 'test_only';
        $values_arr[]= $object->test_only;

        $fields_arr[]= 'is_exclusive';
        $values_arr[]= $object->is_exclusive;

        //
        $fields_arr[]= 'sewage_central';
        $values_arr[]= $complex->getField('sewage_central');
        //
        $fields_arr[]= 'sewage_central_value';
        $values_arr[]= $complex->getField('sewage_central_value');

        //
        $fields_arr[]= 'sewage_rain';
        $values_arr[]= $complex->getField('sewage_rain');

        //
        $fields_arr[]= 'heating';
        $res = 0;
        if($complex->getField('heating')){
            $item = new Post($complex->getField('heating'));
            $item->getTable('l_heatings');
            $res= $item->title();
        }
        $values_arr[] = $res;


        //
        $fields_arr[]= 'facing';
        $res = 0;
        if($object->facing_type){
            $item = new Post($object->facing_type);
            $item->getTable('l_facing_types');
            $res= $item->title();
        }
        $values_arr[] = $res;


        //
        $fields_arr[]= 'video_control';
        $values_arr[]= $complex->getField('video_control');
        //
        $fields_arr[]= 'access_control';
        $values_arr[]= $complex->getField('access_control');
        //
        $fields_arr[]= 'security_alert';
        $values_arr[]= $complex->getField('security_alert');
        //
        $fields_arr[]= 'fire_alert';
        $values_arr[]= $complex->getField('fire_alert');
        //
        $fields_arr[]= 'smoke_exhaust';
        $values_arr[]= $complex->getField('smoke_exhaust');


        //
        $fields_arr[]= 'cadastral_number';
        $values_arr[]= $object->cadastral_number;

        //
        $fields_arr[]= 'videos';
        $values_arr[]= $object->videos;

        //
        $fields_arr[]= 'land_use_restrictions';
        $values_arr[]= $object->land_use_restrictions;
        //
        $fields_arr[]= 'cadastral_number_land';
        $values_arr[]= $object->cadastral_number_land;
        //
        $fields_arr[]= 'field_allow_usage';
        $values_arr[]= $object->field_allow_usage;
        //
        $fields_arr[]= 'own_type';
        $res = 0;
        if($object->own_type){
            $item = new Post($object->own_type);
            $item->getTable('l_own_type');
            $res = $item->title();
        }
        $values_arr[] = $res;

        //
        $fields_arr[] = 'own_type_land';
        $res = 0;
        if($object->own_type_land){
            $item = new Post($object->own_type_land);
            $item->getTable('l_own_type_land');
            $res = $item->title();
        }
        $values_arr[] = $res;




        //
        $fields_arr[] = 'class';
        $values_arr[] = $object->object_class;

        //
        $fields_arr[] = 'class_name';
        $res = 0;
        if($object->object_class){
            $item = new Post($object->object_class);
            $item->getTable('l_classes');
            $res = $item->title();
        }
        $values_arr[] = $res;
        //
        $fields_arr[] = 'landscape_type';
        $res = 0;
        if($object->landscape_type){
            $item = new Post($object->landscape_type);
            $item->getTable('l_landscape');
            $res = $item->title();
        }
        $values_arr[] = $res;

        //
        $fields_arr[]= 'land_category';
        $res = 0;
        if($object->land_category){
            $item = new Post($object->land_category);
            $item->getTable('l_land_categories');
            $res= $item->title();
        }
        $values_arr[] = $res;

        //
        $fields_arr[]= 'entry_territory';
        $res = 0;
        if($complex->getField('entry_territory')){
            $item = new Post($complex->getField('entry_territory'));
            $item->getTable('l_entry_territory');
            $res= $item->title();
        }
        $values_arr[] = $res;


        $fields_arr[]= 'parking_car';
        $values_arr[] = $complex->getField('parking_car');
        //
        $fields_arr[]= 'parking_car_value';
        $res = 0;
        if($complex->getField('parking_car_value')){
            $item = new Post($complex->getField('parking_car_value'));
            $item->getTable('l_parking_type');
            $res= $item->title();
        }
        $values_arr[] = $res;

        //
        $fields_arr[]= 'parking_lorry';
        $values_arr[] = $complex->getField('parking_lorry');
        //
        $fields_arr[]= 'parking_lorry_value';
        $res = 0;
        if($complex->getField('parking_lorry_value')){
            $item = new Post($complex->getField('parking_lorry_value'));
            $item->getTable('l_parking_type');
            $res= $item->title();
        }
        $values_arr[] = $res;



        //
        $fields_arr[]= 'parking_truck';
        $values_arr[] = $complex->getField('parking_truck');
        //
        $fields_arr[]= 'parking_truck_value';
        $res = 0;
        if($complex->getField('parking_truck_value')){
            $item = new Post($complex->getField('parking_truck_value'));
            $item->getTable('l_parking_type');
            $res= $item->title();
        }
        $values_arr[] = $res;


        $cranes_railway = $complex->getJsonField('cranes_railway');
        //
        $fields_arr[]= 'cranes_railway_min';
        $values_arr[]= min(getArrayOdd($cranes_railway));
        //
        $fields_arr[]= 'cranes_railway_max';
        $values_arr[]= max(getArrayOdd($cranes_railway));
        //
        $fields_arr[]= 'cranes_railway_num';
        $values_arr[]= array_sum(getArrayEven($cranes_railway));



        $cranes_gantry = $complex->getJsonField('cranes_gantry');
        //
        $fields_arr[]= 'cranes_gantry_min';
        $values_arr[]= min(getArrayOdd($cranes_gantry));
        //
        $fields_arr[]= 'cranes_gantry_max';
        $values_arr[]= max(getArrayOdd($cranes_gantry));
        //
        $fields_arr[]= 'cranes_gantry_num';
        $values_arr[]= array_sum(getArrayEven($cranes_gantry));



        $cranes_all = array_merge($cranes_gantry,$cranes_railway);

        $fields_arr[]= 'cranes_max';
        $cranes_max = max(getArrayOdd($cranes_all));
        $values_arr[] = $cranes_max;

        $fields_arr[]= 'cranes_min';
        $cranes_min = min(getArrayOdd($cranes_all));
        $values_arr[] = $cranes_min;




        //echo '--------------------';



        //echo 'объект локация '.$object->getField('location_id');

        //
        $fields_arr[]= 'title';
        $values_arr[]= $complex->getField('title');

        $fields_arr[]= 'complex_id';
        $values_arr[]= $complex->getField('id');

        $fields_arr[]= 'object_type';
        $values_arr[]= $object->object_type;

        $fields_arr[]= 'purposes';
        $values_arr[]= $object->purposes;

        //
        $fields_arr[]= 'purposes_furl';
        $purposes = json_decode($object->purposes);
        //var_dump($purposes);
        $purposes_names_arr = [];
        foreach($purposes as $purpose){
            $purp_obj = new Post($purpose);
            $purp_obj->getTable('l_purposes');
            //echo $purp_obj->getField('title_eng');
            $purposes_names_arr[] = $purp_obj->getField('title_eng');
        }
        $values_arr[]= json_encode($purposes_names_arr);

        $fields_arr[]= 'object_type_name';
        $val = '';
        if($object->is_land){
            $val = 'Земельный участок';
        }elseif(in_array(1,json_decode($object->object_type))  && in_array(2,json_decode($object->object_type))){
            $val = 'Производственно-складской комплекс';
        }elseif(in_array(1,json_decode($object->object_type))){
            $val = 'Складской комплекс';
        }elseif(in_array(2,json_decode($object->object_type))){
            $val = 'Производственный комплекс';
        }else{
            $val = 'Складской комплекс';
        }
        $values_arr[]= $val;


        //
        $fields_arr[]= 'power_value';
        $values_arr[]= $complex->getField('power_value');
        //
        $fields_arr[]= 'address';
        $values_arr[]= $object->address;
        //
        $fields_arr[]= 'latitude';
        $values_arr[]= $object->latitude;
        //
        $fields_arr[]= 'longitude';
        $values_arr[]= $object->longitude;
        //
        $fields_arr[]= 'is_land';
        $values_arr[]= $object->is_land;

        //
        $fields_arr[]= 'from_mkad';
        $values_arr[]= $complex->getField('from_mkad');

        if($complex->getField('location_id')){
            $location = new Location((int)$complex->getField('location_id'));

            //echo "номер локации ".$location->postId().'<br>';

            //РЕГИОН объекта
            $fields_arr[] = 'region';
            $values_arr[] = $location->getField('region');

            $fields_arr[] = 'region_name';
            $values_arr[] = $location->getLocationRegion();

            $fields_arr[] = 'cian_region';
            $values_arr[] = $location->getField('cian_region');

            $fields_arr[] = 'outside_mkad';
            $values_arr[] = $location->getField('outside_mkad');

            $fields_arr[] = 'near_mo';
            $values_arr[] = $location->getField('near_mo');

            //НАСЕЛЕННЫЙ ПУНКТ объекта
            $fields_arr[] = 'town';
            $values_arr[] = $location->getField('town');

            $fields_arr[] = 'town_name';
            $values_arr[] = $location->getLocationTown();

            //НАСЕЛЕННЫЙ ПУНКТ объекта
            $fields_arr[] = 'district';
            $values_arr[] = $location->getField('district');

            $fields_arr[] = 'district_name';
            $values_arr[] = getPostTitle($location->getField('district'),'l_districts');

            //НАСЕЛЕННЫЙ ПУНКТ объекта
            $fields_arr[] = 'district_moscow';
            $values_arr[] = $location->getField('district_moscow');

            $fields_arr[] = 'district_moscow_name';
            $values_arr[] = getPostTitle($location->getField('district_moscow'),'l_districts_moscow');

            //НАСЕЛЕННЫЙ ПУНКТ объекта
            $fields_arr[] = 'direction';
            $values_arr[] = $location->getField('direction');

            $fields_arr[] = 'direction_name';
            $values_arr[] = $location->getLocationDirection();

            //ШОССЕ объекта
            $fields_arr[] = 'highway';
            $values_arr[] = $location->getField('highway');

            //ШОССЕ объекта
            $fields_arr[] = 'highway_name';
            $values_arr[] = getPostTitle($location->getField('highway'),'l_highways');

            //ШОССЕ объекта
            $fields_arr[] = 'highway_moscow';
            $values_arr[] = $location->getField('highway_moscow');

            //ШОССЕ объекта
            $fields_arr[] = 'highway_moscow_name';
            $values_arr[] = getPostTitle($location->getField('highway_moscow'),'l_highways_moscow');

            //if($location->getLocationHighway()){ $highway = $location->getLocationHighway();}else{$highway = '';}
            //if($location->getLocationHighwayMoscow()){$highway = $location->getLocationHighwayMoscow();}else{$highway = '';}


            //МЕТРО объекта
            $fields_arr[] = 'metro';
            $values_arr[] = $location->getField('metro');

            $fields_arr[] = 'metro_name';
            $values_arr[] = $location->getLocationMetro();
        }


        //
        $fields_arr[]= 'from_metro_value';
        $values_arr[]= $complex->getField('from_metro_value');
        //
        $fields_arr[]= 'from_metro';
        $values_arr[]= $complex->getField('from_metro');

        //
        $fields_arr[]= 'railway_station';
        $val = 0;
        if($complex->getField('railway_station')){
            $item = new Post($complex->getField('railway_station'));
            $item->getTable('l_railway_stations');
            $val = $item->title();
        }
        $values_arr[]= $val;
        //
        $fields_arr[]= 'from_station_value';
        $values_arr[]= $complex->getField('from_station_value');
        //
        $fields_arr[]= 'from_station';
        $val = 0;
        if($complex->getField('from_station')){
            $item = new Post($complex->getField('from_station'));
            $item->getTable('l_station_ways');
            $val = $item->title();
        }
        $values_arr[]= $val;


        //

        //ID объекта у элемента
        $fields_arr[]= 'object_id';
        $values_arr[]= $object->id;
        //
        $fields_arr[]= 'area_min';
        $values_arr[]= $object->area_building;
        //
        $fields_arr[]= 'area_max';
        $values_arr[]= $object->area_building;
        //
        $fields_arr[]= 'area_floor_max';
        $val_max = $object->area_floor_full;
        $values_arr[]= $val_max;
        //
        $fields_arr[]= 'area_floor_min';
        $val_min = 0; //Артур сказал от 0
        $values_arr[]= $val_min;

        //
        $fields_arr[]= 'area_mezzanine_min';
        $values_arr[]= 0;
        //
        $fields_arr[]= 'area_mezzanine_max';
        $values_arr[]= $object->area_mezzanine_full ;

        //
        $fields_arr[]= 'area_office_min';
        $values_arr[]= 0;
        //
        $fields_arr[]= 'area_office_max';
        $values_arr[]= $object->area_office_full;

        //
        $fields_arr[]= 'area_field_min';
        $values_arr[]= 0;
        //
        $fields_arr[]= 'area_field_max';
        $values_arr[]= $object->area_field_full;

        //
        $fields_arr[]= 'last_update';
        $values_arr[]= $object->last_update;
        //
        $fields_arr[]= 'photos';
        if(count(json_decode($object->photo))> 0){
            $val = $object->photo;
            //echo 'Нашли фото';
        }else{
            $val = $object->photo;
            //$val = '';
        }
        $values_arr[]= $val;

        //
        $fields_arr[]= 'visual_id';
        $values_arr[]= $object->id;
        //

        $mix_offer = new OfferMix(0);


        $mix_offer->createLine($fields_arr,$values_arr);

    }
}




/*
if($logedUser->member_id() == 141){
    $message = 'MIX обновлено предложения норм';
    $telegram->sendMessage($message,$logedUser->getField('telegram_id'));
    $message = 'Время выгрузки '.(time() - $start). ' сек';
    $telegram->sendMessage($message,$logedUser->getField('telegram_id'));
}
*/


/*
    $feed->createLine(['original_id','type_id','deal_type','object_id','last_update','area_min','area_max','price_min', 'price_max','ceiling_height_min','ceiling_height_max','floor','floor_type','heated','gate_type'],
                      [ $original_id,$type_id, $deal_type,  $object_id, $last_update, $area_min, $area_max, $price_min, $price_max,  $ceiling_height_min, $ceiling_height_max, $floor, $floor_type, $heated, $gate_type]);
    */



echo 'Время выгрузки '.(time() - $start). ' сек';
//echo 111;
