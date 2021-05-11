<?

//ini_set('memory_limit', '-1');
$start  = time();



if ($_COOKIE['member_id'] == 141 ) {
    //include_once($_SERVER['DOCUMENT_ROOT'].'/errors.php');
}


include_once($_SERVER['DOCUMENT_ROOT'].'/global_pass.php');

$mix_table = 'c_industry_offers_mix';

//$logedUser = new Member($_COOKIE['member_id']);
$telegram = new Bitkit\Social\Telegram('736512998:AAGIlIPVdPdrffvQRmh1Kwoj2_isbvYUKc4');


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
        echo $object_id;
        //для удаления
        if($mix_delete){
            $sql = $pdo->prepare("UPDATE $mix_table SET deleted=1 WHERE object_id=$post_id ");
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
    $block_sql = "SELECT * FROM c_industry_blocks b LEFT JOIN c_industry_offers o ON b.offer_id = o.id WHERE o.object_id IN ($object_id)   ";
    //$offer_sql = "SELECT * FROM c_industry_offers o WHERE o.object_id IN ($object_id) AND o.deleted !=1  AND (SELECT MIN(b2.status) FROM c_industry_blocks b2 WHERE b2.offer_id = o.id) = 1 ";
    $offer_sql = "SELECT * FROM c_industry_offers o WHERE o.object_id IN ($object_id)  ";
    $object_sql = "SELECT * FROM c_industry  WHERE id IN ($object_id)  ";
    $action = 'обновления';

}else{

    $objects_active = [];
    $sql = $pdo->prepare("SELECT i.id as iid FROM c_industry i LEFT JOIN c_industry_complex c ON i.complex_id=c.id WHERE i.deleted!=1 AND c.deleted!=1 ");
    $sql->execute();
    while($active_obj = $sql->fetch(PDO::FETCH_LAZY)){
        $objects_active[] = $active_obj['id'];
    }
    $objects_active_str = implode(',',$objects_active);

    //для решения трабла когда лот или оффер удален а блок нет
    $active_offers = "SELECT o.id as oid FROM  c_industry_offers o LEFT JOIN c_industry i  ON o.object_id=i.id LEFT JOIN c_industry_complex c ON i.complex_id=c.id WHERE i.deleted!=1 AND c.deleted!=1 AND o.deleted!=1 ";


    $block_sql = "SELECT * FROM c_industry_blocks  WHERE  deleted !=1 AND object_id!=0  AND offer_id IN ($active_offers)  ";
    //$offer_sql = "SELECT * FROM c_industry_offers o WHERE deleted !=1  AND (SELECT MIN(b2.status) FROM c_industry_blocks b2 WHERE b2.offer_id = o.id) = 1 ";
    $offer_sql = "SELECT * FROM c_industry_offers  WHERE deleted !=1 AND id IN ($active_offers) ";
    $object_sql = "SELECT * FROM c_industry  WHERE deleted !=1    ";
    $action = 'выгрузки';

    //ОЧИЩАЕМ ВСЕ ТАБЛИЦЫ
    $sql = $pdo->prepare("TRUNCATE TABLE $mix_table");
    $sql->execute();
}


//Собираем MIX для блоков
$sql = $pdo->prepare($block_sql);
$sql->execute();

$values_all_arr = [];

while($block = $sql->fetch(PDO::FETCH_LAZY)){
    $block_obj = new Subitem($block->id);

    $offer = new Offer((int)$block_obj->getField('offer_id'));

    $object = new Building((int)$offer->getField('object_id'));

    $complex = new Complex((int)$object->getField('complex_id'));

    $fields_arr = [];
    $values_arr = [];

    //
    $fields_arr[]= 'status';
    $values_arr[]= $block->deal_id > 0 ? 2 : 1;

    //
    $fields_arr[]= 'hide_from_market';
    $values_arr[]= $offer->getField('hide_from_market');

    //
    $fields_arr[]= 'deal_id';
    $values_arr[]= $block->deal_id;

    //
    $fields_arr[]= 'parent_id';
    $values_arr[]= $offer->getField('id');

    //
    $fields_arr[]= 'agent_id';
    $values_arr[]= $offer->getField('agent_id');

    //
    $fields_arr[]= 'agent_visited';
    $values_arr[]= $offer->getField('agent_visited');

    //
    $fields_arr[]= 'agent_name';
    if ($agent_id = $offer->getField('agent_id')) {
        $agent = new Member($agent_id);
        $values_arr[]= $agent->title();
    }else{
        $values_arr[] = '';
    }

    //ID элемента в своей таблице
    $fields_arr[]= 'original_id';
    $values_arr[]= $block->id;
    //Тип элемента 1 - блок 2 - предложение
    $fields_arr[]= 'type_id';
    $values_arr[]= 1;


    $gates_types = [];
    $gates_num = 0;

    //Собираем типы ворот
    $gates = $block_obj->getJsonField('gates');

    $gates_types = getArrayUnique(getArrayEven($gates));
    $gates_num = array_sum(getArrayOdd($gates));


    $fields_arr[]= 'gates';
    $values_arr[]= $block->gates;

    //
    $fields_arr[]= 'gate_type';
    if(count($gates_types) > 1  && arrayIsNotEmpty($gates_types)){
        //echo "юольше нуля ";
        $gate_type = 'разные';
    }elseif(arrayIsNotEmpty($gates_types) && $gates_types != NULL){
        $gate_type_obj = new Post((int)(($gates_types)[0]));
        $gate_type_obj->getTable('l_gates_types');
        $gate_type = $gate_type_obj->title();
    }else{
        $gate_type = '';
    }
    $values_arr[]= $gate_type;
    //
    $fields_arr[]= 'gate_num';
    $values_arr[]= $gates_num;

    //
    $fields_arr[]= 'area_building';
    $values_arr[]= $object->getField('area_building');

    //
    $fields_arr[]= 'area_floor_full';
    $values_arr[]= $object->getField('area_floor_full');
    //
    $fields_arr[]= 'area_mezzanine_full';
    $values_arr[]= $object->getField('area_mezzanine_full');

    //
    $fields_arr[]= 'area_office_full';
    $values_arr[]= $object->getField('area_office_full');

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
    $fields_arr[]= 'phone';
    $values_arr[]= $block->phone_line;

    //
    $fields_arr[]= 'canteen';
    $values_arr[]= $complex->getField('canteen');

    //
    $fields_arr[]= 'hostel';
    $values_arr[]= $complex->getField('hostel');

    //
    $fields_arr[]= 'water';
    $res = 0;
    if($object->getField('water')){
        $item = new Post($object->getField('water'));
        $item->getTable('l_waters');
        $res= $item->title();
    }
    $values_arr[] = $block->water == 1 ? 'есть' : 'нет';

    //
    $fields_arr[]= 'water_value';
    $values_arr[]= $object->getField('water_value');

    $fields_arr[]= 'test_only';
    $values_arr[]= $object->getField('test_only');

    $fields_arr[]= 'is_exclusive';
    $values_arr[]= $object->getField('is_exclusive');

    //
    $fields_arr[]= 'sewage_central';
    $values_arr[]= $block->sewage == 1 ? 'есть' : 'нет';
    //
    $fields_arr[]= 'sewage_central_value';
    $values_arr[]= $object->getField('sewage_central_value');

    //
    $fields_arr[]= 'sewage_rain';
    $values_arr[]= $object->getField('sewage_rain');

    //
    $fields_arr[]= 'heating';
    $res = 0;
    if($object->getField('heating')){
        $item = new Post($object->getField('heating'));
        $item->getTable('l_heatings');
        $res= $item->title();
    }
    $values_arr[] = $res;


    //
    $fields_arr[]= 'facing';
    $res = 0;
    if($object->getField('facing_type')){
        $item = new Post($object->getField('facing_type'));
        $item->getTable('l_facing_types');
        $res= $item->title();
    }
    $values_arr[] = $res;


    //
    $fields_arr[]= 'internet';
    $res = 0;
    if($object->getField('internet_type')){ 
        $item = new Post((int)$object->getField('internet_type'));
        $item->getTable('l_internet');
        $res= $item->title();
    }
    $values_arr[] = $res;

    //
    $fields_arr[]= 'ventilation';
    $res = 0;
    //if($object->getField('ventilation')){
    if($ventId = json_decode($block->ventilation)[0]){
        $item = new Post($ventId);
        $item->getTable('l_ventilations');
        $res= $item->title();
    }
    $values_arr[] = $res;


    //
    $fields_arr[]= 'guard';
    $res = 0;
    if($object->getField('guard')){
        $item = new Post($object->getField('guard'));
        $item->getTable('l_guards_industry');
        $res= $item->title();
    }
    $values_arr[] = $res;

    //
    $fields_arr[]= 'firefighting';
    $res = 0;
    if($object->getField('firefighting_type')){
        $item = new Post($object->getField('firefighting_type'));
        $item->getTable('l_firefighting');
        $res = $item->title();
    }
    $values_arr[]= $res;
    //
    $fields_arr[]= 'video_control';
    $values_arr[]= $object->getField('video_control');
    //
    $fields_arr[]= 'access_control';
    $values_arr[]= $object->getField('access_control');
    //
    $fields_arr[]= 'security_alert';
    $values_arr[]= $object->getField('security_alert');
    //
    $fields_arr[]= 'fire_alert';
    $values_arr[]= $object->getField('fire_alert');
    //
    $fields_arr[]= 'smoke_exhaust';
    $values_arr[]= $object->getField('smoke_exhaust');


    //
    $fields_arr[]= 'cadastral_number';
    $values_arr[]= $object->getField('cadastral_number');

    //
    $fields_arr[]= 'videos';
    $values_arr[]= $object->getField('videos');

    //
    $fields_arr[]= 'land_use_restrictions';
    $values_arr[]= $object->getField('land_use_restrictions');
    //
    $fields_arr[]= 'cadastral_number_land';
    $values_arr[]= $object->getField('cadastral_number_land');
    //
    $fields_arr[]= 'field_allow_usage';
    $values_arr[]= $object->getField('field_allow_usage');
    //
    $fields_arr[]= 'own_type';
    $res = 0;
    if($object->getField('own_type')){
        $item = new Post($object->getField('own_type'));
        $item->getTable('l_own_type');
        $res = $item->title();
    }
    $values_arr[] = $res;

    //
    $fields_arr[] = 'own_type_land';
    $res = 0;
    if($object->getField('own_type_land')){
        $item = new Post($object->getField('own_type_land'));
        $item->getTable('l_own_type_land');
        $res = $item->title();
    }
    $values_arr[] = $res;

    //
    $fields_arr[] = 'available_from';
    $val = 0;
    if($block->available_from){
        $val = $block->available_from;
    }
    $values_arr[] = $val;


    //
    $fields_arr[] = 'class';
    $values_arr[] = $object->getField('object_class');

    //
    $fields_arr[] = 'class_name';
    $res = 0;
    if($object->getField('object_class')){
        $item = new Post($object->getField('object_class'));
        $item->getTable('l_classes');
        $res = $item->title();
    }
    $values_arr[] = $res;
    //
    $fields_arr[] = 'landscape_type';
    $res = 0;
    if($object->getField('landscape_type')){
        $item = new Post($object->getField('landscape_type'));
        $item->getTable('l_landscape');
        $res = $item->title();
    }
    $values_arr[] = $res;

    //
    $fields_arr[]= 'land_category';
    $res = 0;
    if($object->getField('land_category')){
        $item = new Post($object->getField('land_category'));
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



    $incs_offer = $offer->getJsonField('inc_services');
    //
    $fields_arr[]= 'inc_electricity';
    if(in_array(4,$incs_offer)){
        $val = 1;
    }else{
        $val = '';
    }
    $values_arr[] = $val;
    //
    $fields_arr[]= 'inc_water';
    if(in_array(3,$incs_offer)){
        $val = 1;
    }else{
        $val = '';
    }
    $values_arr[] = $val;
    //
    $fields_arr[]= 'inc_heating';
    if(in_array(2,$incs_offer)){
        $val = 1;
    }else{
        $val = '';
    }
    $values_arr[] = $val;
    //
    $fields_arr[]= 'commission_owner';
    $values_arr[] = $offer->getField('commission_owner');
    //
    $fields_arr[]= 'commission_client';
    $values_arr[] = $offer->getField('commission_client');
    //
    $fields_arr[]= 'deposit';
    $values_arr[] = $offer->getField('deposit');
    //
    $fields_arr[]= 'pledge';
    $values_arr[] = $offer->getField('pledge');



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


    $elevators = $block_obj->getJsonField('elevators');
    //
    $fields_arr[]= 'elevators_min';
    $values_arr[]= $offer->getOfferBlocksMaxValue('elevators_min');
    //
    $fields_arr[]= 'elevators_max';
    $values_arr[]= $offer->getOfferBlocksMaxValue('elevators_max');
    //
    $fields_arr[]= 'elevators_num';
    $values_arr[]= $offer->getOfferBlocksMaxValue('elevators_num');


    $cranes_overhead = $block_obj->getJsonField('cranes_overhead');
    //
    $fields_arr[]= 'cranes_overhead_min';
    $values_arr[]= min(getArrayOdd($cranes_overhead));
    //
    $fields_arr[]= 'cranes_overhead_max';
    $values_arr[]= max(getArrayOdd($cranes_overhead));
    //
    $fields_arr[]= 'cranes_overhead_num';
    $values_arr[]= array_sum(getArrayEven($cranes_overhead));


    $cranes_cathead = $block_obj->getJsonField('cranes_cathead');
    //
    $fields_arr[]= 'cranes_cathead_min';
    $values_arr[]= min(getArrayOdd($cranes_cathead));
    //
    $fields_arr[]= 'cranes_cathead_max';
    $values_arr[]= max(getArrayOdd($cranes_cathead));
    //
    $fields_arr[]= 'cranes_cathead_num';
    $values_arr[]= array_sum(getArrayEven($cranes_cathead));




    $telphers =  $block_obj->getJsonField('telphers');
    //
    $fields_arr[]= 'telphers_min';
    $values_arr[]= min(getArrayOdd($telphers));
    //
    $fields_arr[]= 'telphers_max';
    $values_arr[]= max(getArrayOdd($telphers));
    //
    $fields_arr[]= 'telphers_num';
    $values_arr[]= array_sum(getArrayEven($telphers));


    $cranes_all = array_merge($cranes_gantry,$cranes_cathead,$cranes_overhead,$cranes_railway,$telphers);

    $fields_arr[]= 'cranes_max';
    $values_arr[] = $block_obj->getField('cranes_max');

    $fields_arr[]= 'cranes_min';
    $values_arr[] = $block_obj->getField('cranes_min');

    $fields_arr[]= 'cranes_num';
    $values_arr[] = $block_obj->getField('cranes_num');

    $fields_arr[]= 'has_cranes';
    $has_cranes = 0 ;
    if ($object->hasCranes() == 1  || $block_obj->getField('cranes_num') > 0 ) {
        $has_cranes = 1;
    }
    $values_arr[] = $has_cranes;


    //echo '--------------------';



    //echo 'объект локация '.$object->getField('location_id');

    //
    $fields_arr[]= 'title';
    $values_arr[]= $complex->getField('title');

    $fields_arr[]= 'complex_id';
    $values_arr[]= $complex->getField('id');

    $fields_arr[]= 'object_type';
    $values_arr[]= $object->getField('object_type');

    $fields_arr[]= 'purposes';
    $values_arr[]= $object->getField('purposes');

    //
    $fields_arr[]= 'purposes_furl';
    $purposes = $object->getJsonField('purposes');
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
    if($object->getField('is_land')){
        $val = 'Земельный участок';
    }elseif(in_array(1,$object->getJsonField('object_type'))  && in_array(2,$object->getJsonField('object_type'))){
        $val = 'Производственно-складской комплекс';
    }elseif(in_array(1,$object->getJsonField('object_type'))){
        $val = 'Складской комплекс';
    }elseif(in_array(2,$object->getJsonField('object_type'))){
        $val = 'Производственный комплекс';
    }else{
        $val = 'Складской комплекс';
    }
    $values_arr[]= $val;
    //
    $fields_arr[]= 'power';
    if($block->power){
        $has_power = 1;
    }else{
        $has_power = 0;
    }
    $values_arr[]= $has_power;

    //
    $fields_arr[]= 'power_value';
    $values_arr[]= $complex->getField('power_value');
    //
    $fields_arr[]= 'address';
    $values_arr[]= $object->getField('address');
    //
    $fields_arr[]= 'latitude';
    $values_arr[]= $object->getField('latitude');
    //
    $fields_arr[]= 'longitude';
    $values_arr[]= $object->getField('longitude');
    //
    $fields_arr[]= 'is_land';
    $values_arr[]= $object->getField('is_land');

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
    /*
    $val = 0;
    if($val =  $object->getField('from_metro')){
        $item = new Post($val);
        $item->getTable('l_station_ways');
        $val = $item->title();
    }
    $values_arr[]= $val;
    */
    //
    $fields_arr[]= 'railway_station';
    $val = 0;
    if($object->getField('railway_station')){
        $item = new Post($object->getField('railway_station'));
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
    $fields_arr[]= 'land_width';
    $values_arr[]= $block->land_width;
    //
    $fields_arr[]= 'land_length';
    $values_arr[]= $block->land_length;



    //
    $fields_arr[]= 'built_to_suit';
    $values_arr[]= $offer->getField('built_to_suit');
    //
    $fields_arr[]= 'built_to_suit_time';
    $values_arr[]= $offer->getField('built_to_suit_time');
    //
    $fields_arr[]= 'built_to_suit_plan';
    $values_arr[]= $offer->getField('built_to_suit_plan');
    //

    $fields_arr[]= 'rent_business';
    $values_arr[]= $offer->getField('rent_business');
    //
    $fields_arr[]= 'rent_business_fill';
    $values_arr[]= $offer->getField('rent_business_fill');
    //
    $fields_arr[]= 'rent_business_price';
    $values_arr[]= $offer->getField('rent_business_price');
    //
    $fields_arr[]= 'rent_business_long_contracts';
    $values_arr[]= $offer->getField('rent_business_long_contracts');
    //
    $fields_arr[]= 'rent_business_last_repair';
    $values_arr[]= $offer->getField('rent_business_last_repair');
    //
    $fields_arr[]= 'rent_business_payback';
    $values_arr[]= $offer->getField('rent_business_payback');
    //
    $fields_arr[]= 'rent_business_income';
    $values_arr[]= $offer->getField('rent_business_income');
    //
    $fields_arr[]= 'rent_business_profit';
    $values_arr[]= $offer->getField('rent_business_profit');

    //
    $fields_arr[]= 'sale_company';
    $values_arr[]= $offer->getField('sale_company');




    //
    $fields_arr[]= 'deal_type';
    $values_arr[]= $offer->getField('deal_type');

    //
    $fields_arr[]= 'deal_type_name';
    $arr_deal = ['Аренда','Продажа','Ответственное хранение','Субаренда'];
    $values_arr[]= $arr_deal[$offer->getField('deal_type') - 1];

    //ID объекта у элемента
    $fields_arr[]= 'object_id';
    $values_arr[]= $offer->getField('object_id');

    //
    $fields_arr[]= 'area_floor_max';
    $val_max = $block->area_floor_max;
    $values_arr[]= $val_max;
    //
    $fields_arr[]= 'area_floor_min';
    $val_min = $block->area_floor_min;
    if(!$val_min){
        $val_min = $val_max;
    }
    $values_arr[]= $val_min;

    //
    $fields_arr[]= 'area_mezzanine_min';
    $values_arr[]= $block->area_mezzanine_min ?? 0;
    //
    $fields_arr[]= 'area_mezzanine_max';
    $values_arr[]= $block->area_mezzanine_max ?? 0 ;
    //
    $fields_arr[]= 'area_mezzanine_add';
    $values_arr[]= $block->area_mezzanine_add;
    //
    $fields_arr[]= 'area_office_min';
    $values_arr[]= $block->area_office_min;
    //
    $fields_arr[]= 'area_office_max';
    $values_arr[]= $block->area_office_max;
    //
    $fields_arr[]= 'area_office_add';
    $values_arr[]= $block->area_office_add;

    //
    //
    $fields_arr[]= 'area_tech_min';
    $values_arr[]= $block->area_tech_min;
    //
    $fields_arr[]= 'area_tech_max';
    $values_arr[]= $block->area_tech_max;

    //
    $fields_arr[]= 'area_field_min';
    $values_arr[]= $block->area_field_min;
    //
    $fields_arr[]= 'area_field_max';
    $values_arr[]= $block->area_field_max;
    //
    $fields_arr[]= 'pallet_place_min';
    $values_arr[]= $block->pallet_place_min;
    //
    $fields_arr[]= 'pallet_place_max';
    $values_arr[]= $block->pallet_place_max;
    //
    $fields_arr[]= 'cells_place_min';
    $values_arr[]= $block->cells_place_min;
    //
    $fields_arr[]= 'cells_place_max';
    $values_arr[]= $block->cells_place_max;


    //
    $fields_arr[]= 'area_min';
    $values_arr[]= $block->area_min;
    //
    $fields_arr[]= 'area_max';
    $values_arr[]= $block->area_max;


    //НАЛОГОВЫЙ ТИП
    $fields_arr[]= 'tax_form';
    $val = 0;
    if($offer->getField('tax_form')){
        $item = new Post($offer->getField('tax_form'));
        $item->getTable('l_tax_form');
        $val = $item->title();
    }
    $values_arr[]= $val;

    //
    $fields_arr[]= 'price_opex_inc';
    $opex_inc = 0;
    if(in_array(1,$offer->getJsonField('inc_services'))){
        $opex_inc = 1;
    }
    $values_arr[]= $opex_inc;

    //
    $fields_arr[]= 'price_opex';
    $values_arr[]= $offer->getField('price_opex');

    //
    $fields_arr[]= 'public_services';
    $values_arr[]= $offer->getField('public_services');


    //
    $fields_arr[]= 'price_opex_min';
    $values_arr[]= $offer->getField('price_opex_min');
    //
    $fields_arr[]= 'price_opex_max';
    $values_arr[]= $offer->getField('price_opex_max');

    $fields_arr[]= 'holidays';
    $values_arr[]= $offer->getField('holidays_min');
    //
    $fields_arr[]= 'price_public_services_inc';
    $public_services_inc = 0;
    if(count(array_intersect([2,3,4],$offer->getJsonField('inc_services')))){
        $public_services_inc = 1;
    }
    $values_arr[]= $public_services_inc;
    //
    $fields_arr[]= 'price_public_services_min';
    $values_arr[]= $offer->getField('price_public_services_min');
    //
    $fields_arr[]= 'price_public_services_max';
    $values_arr[]= $offer->getField('price_public_services_max');

    $arr_fields_prices_rent = [
        'price_floor',
        'price_floor_two',
        'price_floor_three',
        'price_floor_four',
        'price_floor_five',
        'price_floor_six',
        'price_mezzanine',
        'price_mezzanine_two',
        'price_mezzanine_three',
        'price_mezzanine_four',
        'price_sub',
        'price_sub_two',
        'price_sub_three',

    ];

    $prices_min = [];
    $prices_max = [];

    foreach($arr_fields_prices_rent as $price){
        $prices_min[] = $block[$price.'_min'];
        $prices_max[] = $block[$price.'_max'];
    }


    $price_min = getArrayMin($prices_min);
    $price_max = max($prices_max);
    //
    $fields_arr[]= 'price_floor_min';
    $values_arr[]= $price_min;
    //
    $fields_arr[]= 'price_floor_max';
    $values_arr[]=  $price_max;

    //
    if($object->getField('is_land')){
        $fields_arr[]= 'price_floor_100_min';
        $values_arr[]= $price_min * 100;


        $fields_arr[]= 'price_floor_100_max';
        $values_arr[]= $price_max*100;
    }

    //
    $fields_arr[]= 'price_floor_min_month';
    $values_arr[]= $price_min/12;
    //
    $fields_arr[]= 'price_floor_max_month';
    $values_arr[]= $price_max/12;
    //
    $fields_arr[]= 'price_min_month_all';
    $values_arr[]= $price_min*($block_obj->getBlockSumAreaMin())/12;
    //
    $fields_arr[]= 'price_max_month_all';
    $values_arr[]= $price_max*($block_obj->getBlockSumAreaMax())/12;
    //
    $fields_arr[]= 'price_sale_min';
    $values_arr[]= ($block->price_sale_min);
    //
    $fields_arr[]= 'price_sale_max';
    $values_arr[]= ($block->price_sale_max);
    //
    $fields_arr[]= 'price_sale_min_all';
    $values_arr[]= ($block->price_sale_min)*($block_obj->getBlockSumAreaMin());
    //
    $fields_arr[]= 'price_sale_max_all';
    $values_arr[]= ($block->price_sale_max)*($block_obj->getBlockSumAreaMax());
    //
    $fields_arr[]= 'price_mezzanine_min';
    $values_arr[]= $block->price_mezzanine_min;
    //
    $fields_arr[]= 'price_mezzanine_max';
    $values_arr[]= $block->price_mezzanine_max;
    //
    $fields_arr[]= 'price_office_min';
    $values_arr[]= $block->price_office_min;
    //
    $fields_arr[]= 'price_office_max';
    $values_arr[]= $block->price_office_max;
    //
    $fields_arr[]= 'price_safe_pallet_min';
    $values_arr[]= $block->price_safe_pallet_eu_min;
    //
    $fields_arr[]= 'price_safe_pallet_max';
    $values_arr[]= $block->price_safe_pallet_eu_max;
    //
    $fields_arr[]= 'price_safe_volume_min';
    $values_arr[]= $block->price_safe_volume_min;
    //
    $fields_arr[]= 'price_safe_volume_max';
    $values_arr[]= $block->price_safe_volume_max;
    //
    $fields_arr[]= 'price_safe_floor_min';
    $values_arr[]= $block->price_safe_floor_min;
    //
    $fields_arr[]= 'price_safe_floor_max';
    $values_arr[]= $block->price_safe_floor_max;
    //
    $fields_arr[]= 'price_safe_calc_min';
    $values_arr[]= ($block->price_safe_pallet_eu_min * $block->pallet_place_min * 30 * 12)/$block->area_min;
    //
    $fields_arr[]= 'price_safe_calc_max';
    $values_arr[]= ($block->price_safe_pallet_eu_max * $block->pallet_place_max * 30 * 12)/$block->area_max;
    //
    $fields_arr[]= 'price_safe_calc_month_min';
    $values_arr[]= ($block->price_safe_pallet_eu_min * $block->pallet_place_min * 30)/$block->area_min;
    //
    $fields_arr[]= 'price_safe_calc_month_max';
    $values_arr[]= ($block->price_safe_pallet_eu_max * $block->pallet_place_max * 30)/$block->area_max;
    //
    $fields_arr[]= 'ceiling_height_min';
    $values_arr[]= $block->ceiling_height_min;
    //
    $fields_arr[]= 'ceiling_height_max';
    $values_arr[]= $block->ceiling_height_max;
    //
    $fields_arr[]= 'temperature_min';
    $values_arr[]= $block->temperature_min;
    //
    $fields_arr[]= 'temperature_max';
    $values_arr[]= $block->temperature_max;
    //
    $fields_arr[]= 'load_floor_min';
    $values_arr[]= $block->load_floor_min;
    //
    $fields_arr[]= 'load_floor_max';
    $values_arr[]= $block->load_floor_max;
    //
    $fields_arr[]= 'load_mezzanine_min';
    $values_arr[]= $block->load_mezzanine_min;
    //
    $fields_arr[]= 'load_mezzanine_max';
    $values_arr[]= $block->load_mezzanine_max;

    //
    $fields_arr[]= 'floor_types';
    $values_arr[]= $block->floor_types;
    //
    $fields_arr[]= 'floor_type';
    $val = 0;
    if($block->floor_types){
        $floor_vars = json_decode($block->floor_types);
        if(in_array(2,$floor_vars)){
            $floor_type_id = 2;
        }else{
            $floor_type_id = $floor_vars[0];
        }
        $floor_type = new Post($floor_type_id);
        $floor_type->getTable('l_floor_types');
        $val= $floor_type->title();
    }
    $values_arr[]= $val;

    //
    $fields_arr[]= 'self_leveling';
    if($floor_type_id == 2){
        $val = 1;
    }else{
        $val = 0;
    }
    $values_arr[]= $val;

    //
    $fields_arr[]= 'column_grid';
    $val = 0;
    if($block->column_grid){
        $column_grid = new Post(json_decode($block->column_grid)[0]);
        $column_grid->getTable('l_pillars_grid');
        $val= $column_grid->title();
    }
    $values_arr[]= $val;
    //
    $fields_arr[]= 'heated';
    if($block->heated == 1){
        $is_heated = 1;
    }else{
        $is_heated = 2;
    }
    $values_arr[]= $is_heated;
    //
    $fields_arr[]= 'racks';
    $values_arr[]= $block->racks;
    //
    $fields_arr[]= 'charging_room';
    $values_arr[]= $block->charging_room;
    //
    $fields_arr[]= 'cranes_runways';
    $values_arr[]= $block->cranes_runways;
    //
    $fields_arr[]= 'cross_docking';
    $values_arr[]= $block->cross_docking;
    //
    $fields_arr[]= 'warehouse_equipment';
    $values_arr[]= $block->warehouse_equipment;


    $floors = json_decode($block->floor);
    $floor_nums = [];
    foreach ($floors as $floor) {
        $floor_nums[] = (int)$floor;
    }
    //
    $fields_arr[]= 'floor_min';
    $values_arr[]= min($floor_nums);

    $floor_max = (int)$block->floor;
    $fields_arr[]= 'floor_max';
    $values_arr[]= max($floor_nums);
    //
    $fields_arr[]= 'last_update';
    $values_arr[]= $block->last_update;
    //
    $fields_arr[]= 'photos';
    if(count(json_decode($block->photo_block))> 0){
        $val = $block->photo_block;
        //echo 'Нашли фото';
    }else{
        $val = $object->getField('photo');
        //$val = '';
    }
    $values_arr[]= $val;
    //
    $fields_arr[]= 'company_id';
    $values_arr[]= $offer->getField('company_id');

    $fields_arr[]= 'contact_id';
    $values_arr[]= $offer->getField('contact_id');
    //
    $fields_arr[]= 'visual_id';
    $blocks_ids = $offer->subItemsIdFloors();
    //var_dump($blocks_ids);
    $blocks_count = count($blocks_ids);
    for($i =0; $i < $blocks_count;  $i++){
        //if($block->id = $blocks_all_info[$i]['id']){

        if($block->id == $blocks_ids[$i]){
            //echo 'ID блока для визуала '.$blocks_ids[$i];
            //echo '<br>ID блока для визуала '.$blocks_ids[$i];
            $bl_vis_num = $i+1;
            break;
        }
    }
    //echo 'ID-объекта'.$offer->getField('object_id');
    $values_arr[]= $offer->getField('object_id').'-'.preg_split('//u',$offer->getOfferDealType(),-1,PREG_SPLIT_NO_EMPTY)[0].'-'.$bl_vis_num;
    //
    $fields_arr[]= 'ad_realtor';
    $values_arr[]= $block->ad_realtor;
    //
    $fields_arr[]= 'ad_cian';
    $values_arr[]= $block->ad_cian;
    //
    $fields_arr[]= 'ad_cian_top3';
    $values_arr[]= $block->ad_cian_top3;
    //
    $fields_arr[]= 'ad_cian_premium';
    $values_arr[]= $block->ad_cian_premium;
    //
    $fields_arr[]= 'ad_cian_hl';
    $values_arr[]= $block->ad_cian_hl;
    //
    $fields_arr[]= 'ad_yandex';
    $values_arr[]= $block->ad_yandex;
    //
    $fields_arr[]= 'ad_yandex_raise';
    $values_arr[]= $block->ad_yandex_raise;
    //
    $fields_arr[]= 'ad_yandex_promotion';
    $values_arr[]= $block->ad_yandex_promotion;
    //

    $fields_arr[]= 'ad_yandex_premium';
    $values_arr[]= $block->ad_yandex_premium;
    //

    $fields_arr[]= 'ad_arendator';
    $values_arr[]= $block->ad_arendator;
    //
    $fields_arr[]= 'ad_free';
    $values_arr[]= $block->ad_free;

    $fields_arr[]= 'ad_special';
    $values_arr[]= $block->ad_special;
    //
    $fields_arr[]= 'description';
    $values_arr[]= $block->description_auto;
    //
    if(arrayIsNotEmpty(json_decode($block->parts))){
        $blocks_parts = json_decode($block->parts);
        $blocks_parts_mix = [];
        foreach($blocks_parts as $block_part){
            $block_part_mix = new OfferMix();
            $block_part_mix->getRealId($block_part,1);
            $blocks_parts_mix[] = $block_part_mix->id;
        }
        $blocks_parts_str = json_encode($blocks_parts_mix);
    }else{
        $blocks_parts_str = '';
    }
    $fields_arr[]= 'blocks';
    $values_arr[]= $blocks_parts_str;
    //
    $fields_arr[]= 'blocks_amount';
    $values_arr[]= 1;
    //
    $fields_arr[]= 'deleted';
    $values_arr[]= $block->deleted;

    //
    $fields_arr[]= 'safe_type';
    $safe_types_arr = $block->safe_type;
    $values_arr[]= $safe_types_arr;

    //
    $fields_arr[]= 'safe_type_furl';
    $safe_types_arr_furl = [];
    foreach ($safe_types_arr as $safe_type){
        $type_obj = new Post($safe_type);
        $type_obj->getTable('l_safe_types');
        $safe_types_arr_furl[] = $type_obj->getField('title_eng');
    }
    $values_arr[]= json_encode($safe_types_arr_furl);


    $mix_offer = new OfferMix(0);
    $type_id = 1;
    $mix_offer->getRealId($block->id,$type_id);

    $values_all_arr[] = $values_arr;

    //ОБНОВЛЯЕМ ИЛИ СОЗДАЕМ
    if($mix_offer->id){
        $mix_offer->updateLine($fields_arr,$values_arr);
    }else{
        $mix_offer->createLine($fields_arr,$values_arr);
    }

    //$feed->createLine($fields_arr,$values_arr);

}

//--------собираем быстро одним запросом--------------//
/*
if(!$table_id) {
   $fields_str = '';

    //собираю строку полей
    foreach ($fields_arr as $field) {
        $fields_str .= $field . ',';
    }

    $fields_str = trim($fields_str, ',');

    echo $fields_str;

    $chunked = array_chunk($values_all_arr,500);

    foreach ($chunked as $chunk) {
        //собираю строку значений
        $values_str = '';
        foreach ($chunk as $values_arr) {
            $values_str_unit = '';
            foreach ($values_arr as $value) {
                $values_str_unit .= "'" . $value . "',";
            }
            $values_str_unit = '(' . trim($values_str_unit, ',') . '),';
            $values_str .= $values_str_unit;
        }
        $values_str = trim($values_str, ',');

        //echo $values_str;

        $multi_insert_sql_text = "INSERT INTO $mix_table($fields_str)  VALUES $values_str ";

        $sql_mass_create = $pdo->prepare($multi_insert_sql_text);
        $sql_mass_create->execute();
    }

    //echo '----'.$multi_insert_sql_text;

}
*/




//echo 'СТАРТУЕМ ПРЕДЛОЖЕНИЯ ';
/*
if($logedUser->member_id() == 141) {
    $message = 'MIX обновлено блоки норм';
    //$telegram->sendMessage($message, $logedUser->getField('telegram_id'));
}
*/



/*--------------------СОЗДАЕМ MIX ИЗ ПРЕДЛОЖЕНИЙ---------------------------------*/



$sql = $pdo->prepare($offer_sql);
$sql->execute();

while($offer = $sql->fetch(PDO::FETCH_LAZY)){


    //echo '-------------------------olololoolololololololollololollol----------------------------';

    //Собираем типы сделаки для блоков
    $sql_blocks = $pdo->prepare("SELECT * FROM c_industry_blocks WHERE offer_id=$offer->id AND deleted !=1 ORDER BY last_update DESC ");
    $sql_blocks->execute();


    if(1){
    //if($sql_blocks->rowCount() > 0){



        $offer_obj = new Offer($offer->id);

        //echo $offer_obj->postId();

        $object = new Building($offer_obj->getField('object_id'));

        $complex = new Complex((int)$object->getField('complex_id'));


        $fields_arr = [];
        $values_arr = [];

        //
        $fields_arr[]= 'original_id';
        $values_arr[]= $offer_obj->getField('id');

        //
        $fields_arr[]= 'hide_from_market';
        $values_arr[]= $offer_obj->getField('hide_from_market');
        //
        $fields_arr[]= 'visual_id';
        $values_arr[]= $offer_obj->getField('object_id').'-'.preg_split('//u',$offer_obj->getOfferDealType(),-1,PREG_SPLIT_NO_EMPTY)[0];
        //
        $fields_arr[]= 'type_id';
        $values_arr[]= 2;
        //
        $fields_arr[]= 'deal_type';
        $values_arr[]= $offer_obj->getField('deal_type');

        //
        $fields_arr[]= 'deal_type_name';
        $arr_deal = ['Аренда','Продажа','Ответственное хранение','Субаренда'];
        $values_arr[]= $arr_deal[$offer_obj->getField('deal_type') - 1];

        //ID объекта у элемента
        $fields_arr[]= 'object_id';
        $values_arr[]= $offer_obj->getField('object_id');

        //
        $fields_arr[]= 'company_id';
        $values_arr[]= $offer_obj->getField('company_id');

        $fields_arr[]= 'contact_id';
        $values_arr[]= $offer_obj->getField('contact_id');

        //
        $fields_arr[]= 'status';
        $values_arr[]= $offer_obj->getOfferStatus();

        //
        $fields_arr[]= 'deal_id';
        $values_arr[]= $offer_obj->getOfferBlocksMaxValue('deal_id');



        //
        $fields_arr[]= 'agent_id';
        $values_arr[]= $offer_obj->getField('agent_id');

        //
        $fields_arr[]= 'agent_visited';
        $values_arr[]= $offer_obj->getField('agent_visited');

        //
        $fields_arr[]= 'agent_name';
        if ($agent_id = $offer_obj->getField('agent_id')) {
            $agent = new Member($agent_id);
            $values_arr[]= $agent->title();
        }else{
            $values_arr[] = '';
        }

        //
        $fields_arr[]= 'safe_type';
        $safe_types_arr = $offer_obj->getOfferBlocksValuesUnique('safe_type');
        $values_arr[]=  json_encode($safe_types_arr);

        //
        $fields_arr[]= 'safe_type_furl';
        $safe_types_arr_furl = [];
        foreach ($safe_types_arr as $safe_type){
            $type_obj = new Post($safe_type);
            $type_obj->getTable('l_safe_types');
            $safe_types_arr_furl[] = $type_obj->getField('title_eng');
        }
        $values_arr[]= json_encode($safe_types_arr_furl);




        $offer_photos = [];
        $arr_gates = [];
        $arr_cranes_overhead = [];
        $arr_cranes_cathead = [];
        $arr_telphers = [];
        $arr_elevators = [];
        $arr_heating_types = [];
        $offer_blocks = [];
        //echo 'Предложение: '.$offer_obj->postId();
        while($block = $sql_blocks->fetch(PDO::FETCH_LAZY)){

            //Получаем айди блоков предложения в таблицу фидов
            $block_mix = $pdo->prepare("SELECT * FROM $mix_table WHERE original_id=$block->id AND type_id=1  ");
            $block_mix->execute();
            $block_mix_info = $block_mix->fetch(PDO::FETCH_LAZY);
            if($block_mix_info->id){
                $offer_blocks[] = $block_mix_info->id;
            }


            $block_obj = new Subitem($block->id);

            $block_photos = json_decode($block->photo_block);

            foreach($block_photos as $photo){
                if(!in_array($photo,$offer_photos)){
                    $offer_photos[] = $photo;
                }
            }

            //Собираем ворота для всех блоков предложения
            $gates = $block_obj->getJsonField('gates');
            $arr_gates = array_merge($arr_gates,$gates);

            //Собираем подъемники для всех блоков предложения
            $elevators = $block_obj->getJsonField('elevators');
            $arr_elevators = array_merge($arr_elevators,$elevators);

            //Собираем мостовые краны для всех блоков предложения
            $cranes_overhead = $block_obj->getJsonField('cranes_overhead');
            $arr_cranes_overhead = array_merge($arr_cranes_overhead,$cranes_overhead);

            //Собираем кран-балки для всех блоков предложения
            $cranes_cathead = $block_obj->getJsonField('cranes_cathead');
            $arr_cranes_cathead = array_merge($arr_cranes_cathead,$cranes_cathead);

            //Собираем тельферы для всех блоков предложения
            $telphers = $block_obj->getJsonField('telphers');
            $arr_telphers = array_merge($arr_telphers,$telphers);
        }


        //
        $fields_arr[]= 'area_building';
        $values_arr[]= $object->getField('area_building');
        //
        $fields_arr[]= 'area_floor_full';
        $values_arr[]= $object->getField('area_floor_full');
        //
        $fields_arr[]= 'area_mezzanine_full';
        $values_arr[]= $object->getField('area_mezzanine_full');

        //
        $fields_arr[]= 'area_office_full';
        $values_arr[]= $object->getField('area_office_full');

        //
        $fields_arr[]= 'gas';
        $values_arr[]= $complex->getField('gas');

        $fields_arr[]= 'test_only';
        $values_arr[]= $object->getField('test_only');

        $fields_arr[]= 'is_exclusive';
        $values_arr[]= $object->getField('is_exclusive');
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
        $fields_arr[]= 'phone';
        $values_arr[]= $offer_obj->getOfferBlocksMaxValueAll('phone_line');

        //
        $fields_arr[]= 'canteen';
        $values_arr[]= $complex->getField('canteen');

        //
        $fields_arr[]= 'hostel';
        $values_arr[]= $complex->getField('hostel');

        //
        $fields_arr[]= 'water';
        $res=0;
        if($object->getField('water')){
            $item = new Post($object->getField('water'));
            $item->getTable('l_waters');
            $res= $item->title();
        }
        $values_arr[] = $res;

        //
        $fields_arr[]= 'water_value';
        $values_arr[]= $object->getField('water_value');


        //
        $fields_arr[]= 'sewage_central';
        $values_arr[]= $object->getField('sewage_central');
        //
        $fields_arr[]= 'sewage_central_value';
        $values_arr[]= $object->getField('sewage_central_value');

        //
        $fields_arr[]= 'sewage_rain';
        $values_arr[]= $object->getField('sewage_rain');

        //
        $fields_arr[]= 'heating';
        $res=0;
        if($object->getField('heating')){
            $item = new Post($object->getField('heating'));
            $item->getTable('l_heatings');
            $res= $item->title();
        }
        $values_arr[] = $res;


        //
        $fields_arr[]= 'facing';
        $res=0;
        if($object->getField('facing_type')){
            $item = new Post($object->getField('facing_type'));
            $item->getTable('l_facing_types');
            $res= $item->title();
        }
        $values_arr[] = $res;


        //
        $fields_arr[]= 'internet';
        $res=0;
        if($object->getField('internet_type')){
            $item = new Post((int)$object->getField('internet_type'));
            $item->getTable('l_internet');
            $res= $item->title();
        }
        $values_arr[] = $res;

        //
        $fields_arr[]= 'ventilation';
        $res=0;
        if($object->getField('ventilation')){
            $item = new Post((int)$object->getField('ventilation'));
            $item->getTable('l_ventilations');
            $res= $item->title();
        }
        $values_arr[] = $res;


        //
        $fields_arr[]= 'guard';
        $res=0;
        if($object->getField('guard')){
            $item = new Post((int)$object->getField('guard'));
            $item->getTable('l_guards_industry');
            $res= $item->title();
        }
        $values_arr[] = $res;

        //
        $fields_arr[]= 'firefighting';
        $res=0;
        if($object->getField('firefighting_type')){
            $item = new Post((int)$object->getField('firefighting_type'));
            $item->getTable('l_firefighting');
            $res = $item->title();
        }

        $values_arr[]= $res;
        //
        $fields_arr[]= 'video_control';
        $values_arr[]= $object->getField('video_control');
        //
        $fields_arr[]= 'access_control';
        $values_arr[]= $object->getField('access_control');
        //
        $fields_arr[]= 'security_alert';
        $values_arr[]= $object->getField('security_alert');
        //
        $fields_arr[]= 'fire_alert';
        $values_arr[]= $object->getField('fire_alert');
        //
        $fields_arr[]= 'smoke_exhaust';
        $values_arr[]= $object->getField('smoke_exhaust');


        //
        $fields_arr[]= 'cadastral_number';
        $values_arr[]= $object->getField('cadastral_number');

        //
        $fields_arr[]= 'videos';
        $values_arr[]= $object->getField('videos');

        //
        $fields_arr[]= 'land_use_restrictions';
        $values_arr[]= $object->getField('land_use_restrictions');
        //
        $fields_arr[]= 'cadastral_number_land';
        $values_arr[]= $object->getField('cadastral_number_land');
        //
        $fields_arr[]= 'field_allow_usage';
        $values_arr[]= $object->getField('field_allow_usage');
        //
        $fields_arr[]= 'own_type';
        $res=0;
        if($object->getField('own_type')){
            $item = new Post($object->getField('own_type'));
            $item->getTable('l_own_type');
            $res = $item->title();
        }
        $values_arr[] = $res;

        //
        $fields_arr[] = 'own_type_land';
        $res=0;
        if($object->getField('own_type_land')){
            $item = new Post($object->getField('own_type_land'));
            $item->getTable('l_own_type_land');
            $res = $item->title();
        }
        $values_arr[] = $res;

        //
        $fields_arr[] = 'available_from';
        $val = 0;
        $values_arr[] = $val;


        //
        $fields_arr[]= 'land_category';
        $res=0;
        if($object->getField('land_category')){
            $item = new Post($object->getField('land_category'));
            $item->getTable('l_land_categories');
            $res= $item->title();
        }
        $values_arr[] = $res;

        //
        $fields_arr[] = 'class';
        $values_arr[] = $object->getField('object_class');

        //
        $fields_arr[] = 'class_name';
        $res = 0;
        if($object->getField('object_class')){
            $item = new Post($object->getField('object_class'));
            $item->getTable('l_classes');
            $res = $item->title();
        }
        $values_arr[] = $res;
        //
        $fields_arr[] = 'landscape_type';
        $res = 0;
        if($object->getField('landscape_type')){
            $item = new Post($object->getField('landscape_type'));
            $item->getTable('l_landscape');
            $res = $item->title();
        }
        $values_arr[] = $res;

        //
        $fields_arr[]= 'entry_territory';
        $res=0;
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
        $res=0;
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
            $item = new Post((int)$complex->getField('parking_lorry_value'));
            $item->getTable('l_parking_type');
            $res= $item->title();
        }
        $values_arr[] = $res;






        //
        $fields_arr[]= 'parking_truck';
        $values_arr[] = $complex->getField('parking_truck');
        //
        $fields_arr[]= 'parking_truck_value';
        $res=0;
        if($complex->getField('parking_truck_value')){
            $item = new Post((int)$complex->getField('parking_truck_value'));
            $item->getTable('l_parking_type');
            $res= $item->title();
        }
        $values_arr[] = $res;


        $incs_offer = $offer_obj->getJsonField('inc_services');
        //
        $fields_arr[]= 'inc_electricity';
        if(in_array(4,$incs_offer)){
            $val = 1;
        }else{
            $val = '';
        }
        $values_arr[] = $val;
        //
        $fields_arr[]= 'inc_water';
        if(in_array(3,$incs_offer)){
            $val = 1;
        }else{
            $val = '';
        }
        $values_arr[] = $val;
        //
        $fields_arr[]= 'inc_heating';
        if(in_array(2,$incs_offer)){
            $val = 1;
        }else{
            $val = '';
        }
        $values_arr[] = $val;
        //
        $fields_arr[]= 'commission_owner';
        $values_arr[] = $offer_obj->getField('commission_owner');
        //
        $fields_arr[]= 'commission_client';
        $values_arr[] = $offer_obj->getField('commission_client');
        //
        $fields_arr[]= 'deposit';
        $values_arr[] = $offer_obj->getField('deposit');
        //
        $fields_arr[]= 'pledge';
        $values_arr[] = $offer_obj->getField('pledge');







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


        //
        $fields_arr[]= 'elevators_min';
        $values_arr[]= $offer_obj->getOfferBlocksMinValue('elevators_min');
        //
        $fields_arr[]= 'elevators_max';
        $values_arr[]= $offer_obj->getOfferBlocksMaxValue('elevators_max');
        //
        $fields_arr[]= 'elevators_num';
        $values_arr[]= count(getArrReal($offer_obj->getOfferBlocksArrayValuesUnique('elevators')));


        //
        $fields_arr[]= 'cranes_overhead_min';
        $values_arr[]= min(getArrayOdd($arr_cranes_overhead));
        //
        $fields_arr[]= 'cranes_overhead_max';
        $values_arr[]= max(getArrayOdd($arr_cranes_overhead));
        //
        $fields_arr[]= 'cranes_overhead_num';
        $values_arr[]= array_sum(getArrayEven($arr_cranes_overhead));


        //
        $fields_arr[]= 'cranes_cathead_min';
        $values_arr[]= min(getArrayOdd($arr_cranes_cathead));
        //
        $fields_arr[]= 'cranes_cathead_max';
        $values_arr[]= max(getArrayOdd($arr_cranes_cathead));
        //
        $fields_arr[]= 'cranes_cathead_num';
        $values_arr[]= array_sum(getArrayEven($arr_cranes_cathead));


        //
        $fields_arr[]= 'telphers_min';
        $values_arr[]= min(getArrayEven($arr_telphers));
        //
        $fields_arr[]= 'telphers_max';
        $values_arr[]= max(getArrayEven($arr_telphers));
        //
        $fields_arr[]= 'telphers_num';
        $values_arr[]= array_sum(getArrayOdd($arr_telphers));


        $cranes_all = array_merge($cranes_gantry,$arr_cranes_cathead,$arr_cranes_overhead,$cranes_railway,$arr_telphers);

        $fields_arr[]= 'cranes_max';
        //$cranes_max = max(getArrayOdd($cranes_all));
        $values_arr[] = $offer_obj->getOfferBlocksMaxValue('cranes_max');

        $fields_arr[]= 'cranes_min';
        //$cranes_min = min(getArrayOdd($cranes_all));
        $values_arr[] = $offer_obj->getOfferBlocksMinValue('cranes_min');

        $fields_arr[]= 'cranes_num';
        $values_arr[] = count(getArrReal($offer_obj->getOfferBlocksArrayValuesUnique('cranes')));

        $fields_arr[]= 'has_cranes';
        $has_cranes = 0 ;
        if ($object->hasCranes() == 1  || count(getArrReal($offer_obj->getOfferBlocksArrayValuesUnique('cranes'))) > 0 ) {
            $has_cranes = 1;
        }
        $values_arr[] = $has_cranes;

        $gates_types = [];
        $gates_num = 0;

        //Собираем типы ворот и количество ворот
        $gates_types = getArrayUnique(getArrayEven($arr_gates));
        $gates_num = array_sum(getArrayOdd($arr_gates));

        $fields_arr[]= 'gates';
        $values_arr[]= json_encode($arr_gates);

        //
        $fields_arr[]= 'gate_type';
        if(count($gates_types) > 0 && arrayIsNotEmpty($gates_types)){
            //echo "юольше нуля ";
            $gate_type = 'разные';
        }elseif(arrayIsNotEmpty($gates_types) && $gates_types != NULL){
            $gate_type_obj = new Post((int)(($gates_types)[0]));
            $gate_type_obj->getTable('l_gates_types');
            $gate_type = $gate_type_obj->title();
        }else{
            $gate_type = '';
        }
        $values_arr[]= $gate_type;
        //
        $fields_arr[]= 'gate_num';
        $values_arr[]= $gates_num;





        //
        $fields_arr[]= 'title';
        $values_arr[]= $complex->getField('title');


        $fields_arr[]= 'complex_id';
        $values_arr[]= $object->getField('complex_id');



        $fields_arr[]= 'object_type';
        $values_arr[]= $object->getField('object_type');

        $fields_arr[]= 'purposes';
        $values_arr[]= $object->getField('purposes');
        //

        $fields_arr[]= 'purposes_furl';
        $purposes = $object->getJsonField('purposes');
        $purposes_names_arr = [];
        foreach($purposes as $purpose){
            $purp_obj = new Post($purpose);
            $purp_obj->getTable('l_purposes');
            $purposes_names_arr[] = $purp_obj->getField('title_eng');
        }
        $values_arr[]= json_encode($purposes_names_arr);

        $fields_arr[]= 'object_type_name';
        $val = '';
        if($object->getField('is_land')){
            $val = 'Земельный участок';
        }elseif(in_array(1,$object->getJsonField('object_type'))  && in_array(2,$object->getJsonField('object_type'))){
            $val = 'Производственно-складской комплекс';
        }elseif(in_array(1,$object->getJsonField('object_type'))){
            $val = 'Складской комплекс';
        }elseif(in_array(2,$object->getJsonField('object_type'))){
            $val = 'Производственный комплекс';
        }else{
            $val = 'Складской комплекс';
        }
        $values_arr[]= $val;
        //
        $offer_power = $offer_obj->getOfferBlocksMaxSumValue('power');
        $fields_arr[]= 'power';
        if($offer_power){
            $has_power = 1;
        }else{
            $has_power = 0;
        }
        $values_arr[]= $has_power;

        //
        $fields_arr[]= 'power_value';
        $values_arr[]= $complex->getField('power_value');
        //
        $fields_arr[]= 'address';
        $values_arr[]= $object->getField('address');
        //
        $fields_arr[]= 'latitude';
        $values_arr[]= $object->getField('latitude');
        //
        $fields_arr[]= 'longitude';
        $values_arr[]= $object->getField('longitude');
        //
        $fields_arr[]= 'is_land';
        $values_arr[]= $object->getField('is_land');


        //
        $fields_arr[]= 'land_width';
        $values_arr[]= $object->getField('land_width');
        //
        $fields_arr[]= 'land_length';
        $values_arr[]= $object->getField('land_length');

        //
        $fields_arr[]= 'built_to_suit';
        $values_arr[]= $offer_obj->getField('built_to_suit');
        //
        $fields_arr[]= 'built_to_suit_time';
        $values_arr[]= $offer_obj->getField('built_to_suit_time');
        //
        $fields_arr[]= 'built_to_suit_plan';
        $values_arr[]= $offer_obj->getField('built_to_suit_plan');
        //

        $fields_arr[]= 'rent_business';
        $values_arr[]= $offer_obj->getField('rent_business');
        //
        $fields_arr[]= 'rent_business_fill';
        $values_arr[]= $offer_obj->getField('rent_business_fill');
        //
        $fields_arr[]= 'rent_business_price';
        $values_arr[]= $offer_obj->getField('rent_business_price');
        //
        $fields_arr[]= 'rent_business_long_contracts';
        $values_arr[]= $offer_obj->getField('rent_business_long_contracts');
        //
        $fields_arr[]= 'rent_business_last_repair';
        $values_arr[]= $offer_obj->getField('rent_business_last_repair');
        //
        $fields_arr[]= 'rent_business_payback';
        $values_arr[]= $offer_obj->getField('rent_business_payback');
        //
        $fields_arr[]= 'rent_business_income';
        $values_arr[]= $offer_obj->getField('rent_business_income');
        //
        $fields_arr[]= 'rent_business_profit';
        $values_arr[]= $offer_obj->getField('rent_business_profit');

        //
        $fields_arr[]= 'sale_company';
        $values_arr[]= $offer_obj->getField('sale_company');


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
        /*
        $val = 0;
        if($val =  $object->getField('from_metro')){
            $item = new Post($val);
            $item->getTable('l_station_ways');
            $val = $item->title();
        }
        $values_arr[]= $val;
        */
        //
        $fields_arr[]= 'railway_station';
        $val = 0;
        if($object->getField('railway_station')){
            $item = new Post($object->getField('railway_station'));
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

        // echo '--------------------';
        $fields_arr[]= 'photos';
        if($offer_photos){
            $val = $offer_photos;
            $val = json_encode($val);
        }else{
            $val = $object->getField('photo');
            //$val = '';
        }
        $values_arr[]= $val;

        //
        //$fields_arr[]= 'area_min';
        //$values_arr[]= $offer_obj->getOfferBlocksRealAreaMin('area_floor_min') ;
        //
        //$fields_arr[]= 'area_max';
        //$values_arr[]= $offer_obj->getOfferBlocksRealAreaSum('area_floor_max');
        //
        $fields_arr[]= 'area_floor_max';
        //$val_max = $offer_obj->getOfferBlocksMaxSumValue('area_floor_max');
        $val_max = $offer_obj->getOfferBlocksRealAreaSum('area_floor_max');
        $values_arr[] = $val_max;
        //
        $fields_arr[]= 'area_floor_min';
        $val_min = $offer_obj->getOfferBlocksRealAreaMin('area_floor_min');
        if(!$val_min){
            $val_min = $val_max;
        }
        $values_arr[]= $val_min;
        //
        $fields_arr[]= 'area_mezzanine_min';
        $values_arr[]= $offer_obj->getOfferBlocksRealAreaMin('area_mezzanine_min') ?? 0;
        //
        $fields_arr[]= 'area_mezzanine_max';
        $values_arr[]= $offer_obj->getOfferBlocksRealAreaSum('area_mezzanine_max') ?? 0;
        //
        $fields_arr[]= 'area_office_min';
        $values_arr[]= $offer_obj->getOfferBlocksRealAreaMin('area_office_min');
        //
        $fields_arr[]= 'area_office_max';
        $values_arr[]= $offer_obj->getOfferBlocksRealAreaSum('area_office_max');
        //
        $fields_arr[]= 'area_tech_min';
        $values_arr[]= $offer_obj->getOfferBlocksRealAreaMin('area_tech_min');
        //
        $fields_arr[]= 'area_tech_max';
        $values_arr[]= $offer_obj->getOfferBlocksRealAreaSum('area_tech_max');
        //
        $fields_arr[]= 'area_field_min';
        $values_arr[]= $offer_obj->getOfferBlocksRealAreaMin('area_field_min');
        //
        $fields_arr[]= 'area_field_max';
        $values_arr[]= $offer_obj->getOfferBlocksRealAreaSum('area_field_max');


        //
        $fields_arr[]= 'area_min';
        //$values_arr[]= $offer_obj->getOfferBlocksRealAreaMin('area_floor_min') ;
        $values_arr[]= $offer_obj->getOfferBlocksMinValue('area_min') ;

        //
        $fields_arr[]= 'area_max';

        if ($offer_obj->getField('deal_type') == 2) {
            $values_arr[]= $offer_obj->getOfferBlocksRealAreaSum('area_floor_max') + $offer_obj->getOfferBlocksRealAreaSum('area_mezzanine_max') + $offer_obj->getOfferBlocksRealAreaSum('area_office_max') + $offer_obj->getOfferBlocksRealAreaSum('area_tech_max') + $offer_obj->getOfferBlocksRealAreaSum('area_field_max');
        } else {
            //$values_arr[]= 0;
            $values_arr[]= $offer_obj->getOfferBlocksRealAreaSum('area_floor_max') + $offer_obj->getOfferBlocksRealAreaSum('area_mezzanine_max');
        }


        //$values_arr[] = $offer_obj->getOfferBlocksMaxSumValue('area_max');



        //НАЛОГОВЫЙ ТИП
        $fields_arr[]= 'tax_form';
        $val = 0;
        if($offer_obj->getField('tax_form')){
            $item = new Post($offer_obj->getField('tax_form'));
            $item->getTable('l_tax_form');
            $val = $item->title();
        }
        $values_arr[]= $val;

        //
        $fields_arr[]= 'price_opex';
        $values_arr[]= 1;  

        //
        $fields_arr[]= 'public_services';
        $values_arr[]= $offer_obj->getField('public_services');

        //
        $fields_arr[]= 'price_opex_inc';
        $opex_inc = 0;
        if(in_array(1,$offer_obj->getJsonField('inc_services'))){
            $opex_inc = 1;
        }
        $values_arr[]= $opex_inc;
        //
        $fields_arr[]= 'price_opex_min';
        $values_arr[]= $offer_obj->getField('price_opex_min');
        //
        $fields_arr[]= 'price_opex_max';
        $values_arr[]= $offer_obj->getField('price_opex_max');

        //
        $fields_arr[]= 'price_public_services_inc';
        $public_services_inc = 0;
        if(count(array_intersect([2,3,4],$offer_obj->getJsonField('inc_services')))){
            $public_services_inc = 1;
        }
        $values_arr[]= $public_services_inc;
        //
        $fields_arr[]= 'price_public_services_min';
        $values_arr[]= $offer_obj->getField('price_public_services_min');
        //
        $fields_arr[]= 'price_public_services_max';
        $values_arr[]= $offer_obj->getField('price_public_services_max');
        //
        $arr_fields_prices_rent = [
            'price_floor',
            'price_floor_two',
            'price_floor_three',
            'price_floor_four',
            'price_floor_five',
            'price_floor_six',
            'price_mezzanine',
            'price_mezzanine_two',
            'price_mezzanine_three',
            'price_mezzanine_four',
            'price_sub',
            'price_sub_two',
            'price_sub_three',
        ];

        $prices_min = [];
        $prices_max = [];

        //тут пароеб
        foreach($arr_fields_prices_rent as $price){
            $prices_min[] = $offer_obj->getOfferBlocksMinValue($price.'_min');
            $prices_max[] = $offer_obj->getOfferBlocksMaxValue($price.'_max');
        }

        $price_min = getArrayMin($prices_min);
        $price_max = max($prices_max);



        $fields_arr[]= 'price_floor_min';
        $values_arr[]= $price_min;
        //
        $fields_arr[]= 'price_floor_max';
        $values_arr[]= $price_max;

        //
        if($object->getField('is_land')){
            $fields_arr[]= 'price_floor_100_min';
            $values_arr[]= $price_min;


            $fields_arr[]= 'price_floor_100_max';
            $values_arr[]= $price_max*100;
        }
        //
        $fields_arr[]= 'price_mezzanine_min';
        $values_arr[]= $offer_obj->getOfferBlocksMinValue('price_mezzanine_min');
        //
        $fields_arr[]= 'price_mezzanine_max';
        $values_arr[]= $offer_obj->getOfferBlocksMaxValue('price_mezzanine_max');
        //
        $fields_arr[]= 'price_office_min';
        $values_arr[]= $offer_obj->getOfferBlocksMinValue('price_office_min');
        //
        $fields_arr[]= 'price_office_max';
        $values_arr[]= $offer_obj->getOfferBlocksMaxValue('price_office_max');
        //
        $fields_arr[]= 'price_floor_min_month';
        $values_arr[]= $price_min/12;
        //
        $fields_arr[]= 'price_floor_max_month';
        $values_arr[]= $price_max/12;
        //
        $fields_arr[]= 'price_min_month_all';
        $values_arr[]= ($price_min/12)*$offer_obj->getOfferSumAreaMin();
        //
        $fields_arr[]= 'price_max_month_all';
        $values_arr[]= ($price_max/12)*$offer_obj->getOfferSumAreaMax();
        //
        $fields_arr[]= 'price_sale_min';
        $values_arr[]= $offer_obj->getOfferBlocksMinValue('price_sale_min');
        //
        $fields_arr[]= 'price_sale_max';
        $values_arr[]= $offer_obj->getOfferBlocksMaxValue('price_sale_max');
        //
        $fields_arr[]= 'price_sale_min_all';
        $values_arr[]= ($offer_obj->getOfferBlocksMinValue('price_sale_min'))*$offer_obj->getOfferSumAreaMin();
        //
        $fields_arr[]= 'price_sale_max_all';
        $values_arr[]= ($offer_obj->getOfferBlocksMaxValue('price_sale_max'))*$offer_obj->getOfferSumAreaMax();
        //
        $fields_arr[]= 'price_safe_pallet_min';
        $values_arr[]= $offer_obj->getOfferBlocksMinValue('price_safe_pallet_eu_min');
        //
        $fields_arr[]= 'price_safe_pallet_max';
        $values_arr[]= $offer_obj->getOfferBlocksMaxValue('price_safe_pallet_eu_max');
        //
        $fields_arr[]= 'price_safe_volume_min';
        $values_arr[]= $offer_obj->getOfferBlocksMinValue('price_safe_volume_min');
        //
        $fields_arr[]= 'price_safe_volume_max';
        $values_arr[]= $offer_obj->getOfferBlocksMaxValue('price_safe_volume_max');
        //
        $fields_arr[]= 'price_safe_floor_min';
        $values_arr[]= $offer_obj->getOfferBlocksMinValue('price_safe_floor_min');
        //
        $fields_arr[]= 'price_safe_floor_max';
        $values_arr[]= $offer_obj->getOfferBlocksMaxValue('price_safe_floor_max');
        //
        $fields_arr[]= 'price_safe_calc_min';
        $values_arr[]= ($offer_obj->getOfferBlocksMinValue('price_safe_pallet_eu_min') * $offer_obj->getOfferBlocksMinValue('pallet_place_min') * 30 * 12)/$offer_obj->getOfferBlocksMinValue('area_min');
        //
        $fields_arr[]= 'price_safe_calc_max';
        $values_arr[]= ($offer_obj->getOfferBlocksMaxValue('price_safe_pallet_eu_max') * $offer_obj->getOfferBlocksMaxSumValue('pallet_place_max') * 30 * 12)/$offer_obj->getOfferBlocksMaxSumValue('area_max');
        //
        $fields_arr[]= 'price_safe_calc_month_min';
        $values_arr[]= ($offer_obj->getOfferBlocksMinValue('price_safe_pallet_eu_min') * $offer_obj->getOfferBlocksMinValue('pallet_place_min') * 30)/$offer_obj->getOfferBlocksMinValue('area_min');
        //
        $fields_arr[]= 'price_safe_calc_month_max';
        $values_arr[]= ($offer_obj->getOfferBlocksMaxValue('price_safe_pallet_eu_max') * $offer_obj->getOfferBlocksMaxSumValue('pallet_place_max') * 30)/$offer_obj->getOfferBlocksMaxSumValue('area_max');
        //
        $fields_arr[]= 'pallet_place_min';
        $values_arr[]= $offer_obj->getOfferBlocksMinValue('pallet_place_min');
        //
        $fields_arr[]= 'pallet_place_max';
        $values_arr[]= $offer_obj->getOfferBlocksMaxSumValue('pallet_place_max');
        //
        $fields_arr[]= 'cells_place_min';
        $values_arr[]= $offer_obj->getOfferBlocksMinValue('cells_place_min');
        //
        $fields_arr[]= 'cells_place_max';
        $values_arr[]= $offer_obj->getOfferBlocksMaxSumValue('cells_place_max');
        //
        $fields_arr[]= 'ceiling_height_min';
        $values_arr[]= $offer_obj->getOfferBlocksMinValue('ceiling_height_min');
        //
        $fields_arr[]= 'ceiling_height_max';
        $values_arr[]= $offer_obj->getOfferBlocksMaxValue('ceiling_height_max');
        //
        $fields_arr[]= 'load_floor_min';
        $values_arr[]= $offer_obj->getOfferBlocksMinValue('load_floor_min');
        //
        $fields_arr[]= 'load_floor_max';
        $values_arr[]= $offer_obj->getOfferBlocksMaxValue('load_floor_max');
        //
        $fields_arr[]= 'load_mezzanine_min';
        $values_arr[]= $offer_obj->getOfferBlocksMinValue('load_mezzanine_min');
        //
        $fields_arr[]= 'load_mezzanine_max';
        $values_arr[]= $offer_obj->getOfferBlocksMaxValue('load_mezzanine_max');
        //
        $fields_arr[]= 'temperature_min';
        $values_arr[]= $offer_obj->getOfferBlocksMinValue('temperature_min');
        //
        $fields_arr[]= 'temperature_max';
        $values_arr[]= $offer_obj->getOfferBlocksMaxValue('temperature_max');

        //
        $fields_arr[]= 'floor_types';
        $values_arr[] = json_encode($offer_obj->getOfferBlocksValuesUnique('floor_types'));

        //
        $fields_arr[]= 'floor_type';
        $floor_types_arr = $offer_obj->getOfferBlocksValuesUnique('floor_types');
        $floor_type_id = 0;
        $selfLeveling = 0;
        if (arrayIsNotEmpty($floor_types_arr)) {
            if (in_array(2,$floor_types_arr)) {
                $floor_type_id = 2;
                $selfLeveling = 1;
            } else {
                $floor_type_id = $floor_types_arr[0];
            }
        }


        if($floor_type_id){
            $floor_type = new Post($floor_type_id);
            $floor_type->getTable('l_floor_types');
            $val= $floor_type->title();
        }else{
            $val = '';
        }
        $values_arr[]= $val;
        //
        $fields_arr[]= 'self_leveling';
        $values_arr[]= $selfLeveling;

        //
        $fields_arr[]= 'column_grid';
        if(count($offer_obj->getOfferBlocksValuesUnique('column_grid')) > 1 ){
            //echo "юольше нуля ";
            $column_grid = 'разные';
        }elseif(arrayIsNotEmpty($offer_obj->getOfferBlocksValuesUnique('column_grid')) && $offer_obj->getOfferBlocksValuesUnique('column_grid') != NULL){
            //echo "юольше нуля ";
            $column_grid_obj = new Post((int)(($offer_obj->getOfferBlocksValuesUnique('column_grid'))[0]));
            $column_grid_obj->getTable('l_pillars_grid');
            $column_grid = $column_grid_obj->title();
        }else{
            $column_grid = '';
        }
        $values_arr[]= $column_grid;
        //
        $fields_arr[]= 'heated';
        ($offer_obj->getOfferBlocksValuesUnique('heated')[0] == 1) ? $is_heated=1 : $is_heated=2;
        $values_arr[]= $is_heated;

        $fields_arr[]= 'racks';
        $values_arr[]= $offer_obj->getOfferBlocksMaxValue('racks');
        //
        $fields_arr[]= 'charging_room';
        $values_arr[]= $offer_obj->getOfferBlocksMaxValue('charging_room');
        //
        $fields_arr[]= 'cranes_runways';
        $values_arr[]= $offer_obj->getOfferBlocksMaxValue('cranes_runways');
        //
        $fields_arr[]= 'cross_docking';
        $values_arr[]= $offer_obj->getOfferBlocksMaxValue('cross_docking');
        //
        $fields_arr[]= 'warehouse_equipment';
        $values_arr[]= $offer_obj->getOfferBlocksMaxValue('warehouse_equipment');


        //
        $fields_arr[]= 'holidays';
        $values_arr[]= $offer_obj->getField('holidays_min');

        $floors = $offer_obj->getOfferBlocksValuesUnique('floor');
        $floor_nums = [];
        foreach ($floors as $floor ) {
            $floor_nums[] = (int)$floor;
        }

        //
        $fields_arr[]= 'floor_min';
        $values_arr[]= min($floor_nums);
        //
        $fields_arr[]= 'floor_max';
        $values_arr[]= max($floor_nums);
        //
        $fields_arr[]= 'last_update';
        $values_arr[]= $offer_obj->getOfferBlocksMaxValueAll('last_update');

        //
        $fields_arr[]= 'ad_realtor';
        $values_arr[]= $offer_obj->getField('ad_realtor');
        //
        $fields_arr[]= 'ad_cian';
        $values_arr[]= $offer_obj->getField('ad_cian');
        //
        $fields_arr[]= 'ad_cian_top3';
        $values_arr[]= $offer_obj->getField('ad_cian_top3');
        //
        $fields_arr[]= 'ad_cian_premium';
        $values_arr[]= $offer_obj->getField('ad_cian_premium');
        //
        $fields_arr[]= 'ad_cian_hl';
        $values_arr[]= $offer_obj->getField('ad_cian_hl');
        //
        $fields_arr[]= 'ad_yandex';
        $values_arr[]= $offer_obj->getField('ad_yandex');
        //
        $fields_arr[]= 'ad_yandex_raise';
        $values_arr[]= $offer_obj->getField('ad_yandex_raise');
        //
        $fields_arr[]= 'ad_yandex_promotion';
        $values_arr[]= $offer_obj->getField('ad_yandex_promotion');
        //
        $fields_arr[]= 'ad_yandex_premium';
        $values_arr[]= $offer_obj->getField('ad_yandex_premium');
        //
        $fields_arr[]= 'ad_arendator';
        $values_arr[]= $offer_obj->getField('ad_arendator');
        //
        $fields_arr[]= 'ad_free';
        $values_arr[]= $offer_obj->getField('ad_free');

        $fields_arr[]= 'ad_special';
        $values_arr[]= $offer_obj->getField('ad_special');
        //
        $fields_arr[]= 'description';
        $values_arr[]= $offer_obj->getField('description_auto');
        //
        $fields_arr[]= 'blocks';
        $values_arr[]= json_encode($offer_blocks);
        //
        $fields_arr[]= 'blocks_amount';
        $values_arr[]= count($offer_blocks);

        //$values_arr[]= '';
        //
        $fields_arr[]= 'deleted';
        $values_arr[]= !(int)($offer_obj->hasBlocksAlive());
        //
        $gate_type = json_encode($arr_gate_types);
        //
        //echo 133333;


        //echo $offer_obj->postId();

        $mix_offer = new OfferMix();
        $type_id = 2;
        $mix_offer->getRealId($offer_obj->postId(),$type_id);

        //ОБНОВЛЯЕМ ИЛИ СОЗДАЕМ
        if($mix_offer->postId()){
            $mix_offer->updateLine($fields_arr,$values_arr);
        }else{
            $mix_offer->createLine($fields_arr,$values_arr);
        }
    }


    //$feed->createLine($fields_arr,$values_arr);




}


/*-------------------------СОЗДАЕМ "ПАССИВНЫЕ" предложения из ЛОТОВ----------*/

/*-------------------------СОЗДАЕМ "ПАССИВНЫЕ" предложения из ЛОТОВ----------*/

//if($action == 'выгрузки') {
if(1) {
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
        $fields_arr[]= 'deleted';
        $values_arr[]= 0;

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
        $fields_arr[]= 'heated';
        $values_arr[]= $complex->getField('heating_autonomous');

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
        $values_arr[]= $complex->getField('sewage');
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

        $fields_arr[] = 'description';
        $values_arr[] = $object->description ? $object->description :  $object->description_auto ;
        //$values_arr[] = '34343';

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
        $values_arr[]= $object->area_building ? $object->area_building : $object->area_field_full  ;
        //
        $fields_arr[]= 'area_max';
        $values_arr[]= $object->area_building ? $object->area_building : $object->area_field_full;
        //
        $fields_arr[]= 'area_floor_max';
        $val_max = $object->area_building;
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
        $values_arr[]= 0; //потому что Артур сказал так
        //
        $fields_arr[]= 'area_field_max';
        $values_arr[]= $object->area_field_full;

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

        $object_obj = new Building($object->id);

        $fields_arr[]= 'last_update';



        /*
        $blocks_last_update = $object_obj->getBlocksLastUpdate();
        $offers_last_update = $object_obj->getOffersLastUpdate();

        $values_arr[]=  $blocks_last_update > $offers_last_update  ? $blocks_last_update  :  $offers_last_update;

        */

        $values_arr[] = $object_obj->getField('last_update');

        $mix_offer = new OfferMix(0);
        $type_id = 3;
        $mix_offer->getRealId($object->id,$type_id);


        //ОБНОВЛЯЕМ ИЛИ СОЗДАЕМ
        if($mix_offer->getField('id')){
            $mix_offer->updateLine($fields_arr,$values_arr);
        }else{
            $mix_offer->createLine($fields_arr,$values_arr);
        }


        //$mix_offer = new OfferMix(0);


        //$mix_offer->createLine($fields_arr,$values_arr);

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
