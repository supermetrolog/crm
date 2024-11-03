<?php

//include_once($_SERVER['DOCUMENT_ROOT'].'/errors.php');

if ($_COOKIE['member_id']){
    //ini_set('display_errors', 1); ini_set('display_startup_errors', 1); ini_set('error_reporting', E_ALL);
}



function getActiveOnly(array $array) : array {
    $active_arr =[];
    foreach($array as $item){
        $block_mix = new OfferMix($item);
        if($block_mix->getField('status') == 1){
            $active_arr[] = $item;
        }
    }
    return $active_arr;
}

?>

<? include_once($_SERVER['DOCUMENT_ROOT'].'/global_pass.php');?>
<?php

$objects = new Item(0);

?>
<?

$filters = [];

//$data = file_get_contents('php://input');

if($_POST['request']){
    $filters_arr = json_decode($_POST['request']);
}else{

    if ($_COOKIE['member_id'] == 141) {


        $filters['id'] =  0;
        $filters['page_num'] = 1;

        $filters['page_items'] = 500;


        $filters['search'] =  '';

        $filters['region'] =  '';
        $filters['directions'] =  '';
        $filters['towns'] =  '';
        $filters['highway'] =  [];
        $filters['metros'] = '' ;


       $filters['deal_type'] = 1;
        $filters['purposes'] =  [];
        $filters['object_type'] = [];
        //$filters['safe_type'] = [1,2];
        $filters['safe_type'] = '';
        $filters['self_leveling'] = '';


        $filters['racks'] = 0;
        $filters['cranes'] = 0;
        $filters['railway'] = 0;
        $filters['steam'] = 0;
        $filters['gas'] = 0;
        $filters['water'] = 0;
        $filters['sewage'] = 0;
        $filters['ground_floor'] = 0;


        $filters['area_min'] = '';
        $filters['area_max'] = '';


        $filters['price_min'] = '';
        $filters['price_max'] = '';
        $filters['price_format'] = '';

        $filters['ceiling_height_min'] = 0;
        $filters['ceiling_height_max'] = 0;
        $filters['pallet_place_max'] = 0;
        $filters['pallet_place_min'] = 0;
        $filters['from_mkad_min'] = 0;
        $filters['from_mkad_max'] = 0;

        $filters['power'] =  0;

    }



    $filters = json_encode($filters);

    $filters_arr = json_decode($filters);

    //echo $filters;

}


$filter_line = '';



if (true) {

    if($value = $filters_arr->search) {

        if (iconv_strlen($value) < 6 && ctype_digit($value)) {       

            $filter_line = ' AND o.object_id='.$value;

        } else {

            $search_fields = [
                'object_id',
                'address',
                'region_name',
                'town_name',
                'district_name',
                'district_moscow_name',
                'direction_name',
                'highway_name',
                'highway_moscow_name',
                'railway_station',
                'landscape_type',
                'agent_name',
                'title',
                //'highway_moscow',
                'metro_name',

            ];
            $fields_line = '';

            foreach ($search_fields as $field) {
                $fields_line .= "o.$field LIKE '%$value%' OR ";
            }
            //echo $fields_line;
            $filter_line .= ' AND (' . trim($fields_line, 'OR ') . ')';

        }


    }


    if($filters_arr->id) {
        $value = (int)$filters_arr->id;
        $filter_line .= " AND i.id=$value";
    }


    /*
     * ФИЛЬТРЫ К ПРЕДЛОЖЕНИЮ
     */
    //ТИП СДЕЛКИ
    if($filters_arr->deal_type) {
        $value = (int)$filters_arr->deal_type;
        if($filters_arr->deal_type == 1){
            $filter_line .= " AND (o.deal_type=$value OR o.deal_type=4 ) ";
        }else{
            $filter_line .= " AND ( o.deal_type=$value  ";
        }
    }

    if($value = (int)$filters_arr->self_leveling) {
        $filter_line .= " AND o.self_leveling=1";
    }


    /*
     * ФИЛЬТРЫ К ОБЪЕКТУ
     */
//РЕГИОН
    if($value = $filters_arr->region) {
        if(is_numeric($value)){

            if($value == 100){
                $filter_line .= " AND (o.region=1 OR o.region=6)  ";
            }elseif($value == 200){
                $filter_line .= " AND o.region=6 AND o.outside_mkad=0";
            }elseif($value == 300){
                $filter_line .= " AND o.region=1 OR (o.outside_mkad=1 AND o.region=6)";
            }elseif($value == 400){
                $filter_line .= " AND o.region=1 OR o.near_mo=1 ";
            }elseif($value == 1000){
                $filter_line .= " ";
            }else{
                $filter_line .= " AND o.region=$value";
            }
        }else{
            if($value == 'moskva-i-mo'){
                $filter_line .= " AND (o.region=1 OR o.region=6)  ";
            }elseif($value == 'moskva-vnutri-mkad'){
                $filter_line .= " AND o.region=6 AND o.outside_mkad=0";
            }elseif($value == 'mo-moskva-snaruzhi-mkad'){
                $filter_line .= " AND o.region=1 OR (o.outside_mkad=1 AND l.region=6)";
            }elseif($value == 'mo-regiony-ryadom'){
                $filter_line .= " AND o.region=1 OR o.near_mo=1 ";
            }elseif($value == 'vsya-rosssiya'){
                $filter_line .= " ";
            }else{
                $region = new Post();
                $region->getTable('l_regions');

                $value = $region->getPostByField('title_eng',$filters_arr->region);
                $filter_line .= " AND o.region=$value";
            }
        }


        if($value = $filters_arr->directions) {
            $dirIds = [];



            $dirLine='';

            foreach($value as $dir) {
                $dirLine .= "'$dir',";
            }

            $dirLine = trim($dirLine, ',');

            $disSql = $pdo->prepare("SELECT id FROM l_directions WHERE title_eng IN ($dirLine)");

            $disSql->execute();
            while($dir = $disSql->fetch(PDO::FETCH_LAZY)){
                $dirIds[] = $dir->id;
            }
            $dirIdLine = implode(',',$dirIds);

            $filter_line .= " AND o.direction IN($dirIdLine)";
        }
    }

    if(1) {

        $arr_location = [


            [
                'name'=>'districts_moscow',
                'table'=>'l_districts_moscow',
                'fields'=>['district_moscow','district_moscow_relevant'],
            ],
            [
                'name'=>'towns',
                'table'=>'l_towns_central',
                'fields'=>['town'],
            ],
            [
                'name'=>'highways',
                'table'=>'l_highways',
                'fields'=>['highway'],
            ],
            [
                'name'=>'highways_moscow',
                'table'=>'l_highways_moscow',
                'fields'=>['highway_moscow'],
            ],
            [
                'name'=>'metros',
                'table'=>'l_metros',
                'fields'=>['metro'],
            ],
            [
                'name'=>'districts',
                'table'=>'l_districts',
                'fields'=>['district'],
            ]
        ];

        foreach ($arr_location as $filter){
            if($value = $filters_arr->{$filter['name']}) {
                if(is_numeric($value[0])){
                    $items_line = implode(',',$value);
                }else{
                    $items = [];
                    foreach($value as $item_eng){
                        $item = new Post();
                        $item->getTable($filter['table']);
                        $items[] = $item->getPostByField('title_eng',$item_eng);
                    }
                    $items_line = implode(',',$items);

                }
                $fields_line = '';
                foreach ($filter['fields'] as $field){
                    $fields_line.= "o.$field IN($items_line) OR ";
                }
                //echo $fields_line;
                $filter_line .= ' AND ('.trim($fields_line,'OR ').')';
                //echo $filter_line;

            }
        }
    }


    //АЙДИШНИКИ МИКСОВАНЫХ ПРЕДЛОЖЕНИЙ
    if($filters_arr->offers_id) {
        $blocks_id = implode(',',$filters_arr->offers_id);
        $filter_line .= " AND o.id IN($blocks_id)";
    }

    //НАЗНАЧЕНИЕ ОБЪЕКТА
    if($filters_arr->object_type && $filters_arr->object_type != 'all' ) {
        $types = $filters_arr->object_type;
        foreach($types as $type){
            if ($type != 'all') {
                $object_line .= " o.object_type LIKE '%".(int)$type."%' OR";
            }
        }
        $filter_line .= " AND (".trim($object_line,'OR').")";



        //НАЗНАЧЕНИЕ ОБЪЕКТА
        if($filters_arr->purposes) {
            $purposes = $filters_arr->purposes;
            foreach($purposes as $purpose){
                //$purpose_line .= " o.purposes LIKE '".'%"'.(int)$purpose.'"%'."'".'OR'.' o.safe_type_furl LIKE '%".$type."%')   OR;
                $purpose_line .= " (o.purposes LIKE '%".'"'.(int)$purpose.'"'."%' OR o.purposes_furl LIKE '%".$purpose."%')   OR";
            }
            $filter_line .= " AND (".trim($purpose_line,'OR').")";
        }
    }


    ///////Условие работы
    //if($filters_arr->deal_type && $filters_arr->object_type) {
    if($filters_arr->deal_type) {

        //ТИП ХРАНЕНИЯ
        if($types = $filters_arr->safe_type) {
            foreach($types as $type){
                $safe_type_line .= " (o.safe_type LIKE '%".(int)$type."%' OR o.safe_type_furl LIKE '%".$type."%')   OR";
            }
            $filter_line .= " AND (".trim($safe_type_line,'OR').")";
        }
        /*
        * ФИЛЬТРЫ К ОБЪЕКТУ
        */
        //КЛАСС
        if($filters_arr->object_class) {
            $class_line = implode(',',$filters_arr->object_class);
            $filter_line .= " AND o.class IN($class_line)";
        }
        //ЖД ветка
        if($filters_arr->railway) {
            $filter_line .= " AND o.railway='1'";
        }
        //ЭЛЕКТРИЧЕСТВО
        if($filters_arr->power) {
            $value = (int)$filters_arr->power;
            $filter_line .= " AND o.power>=$value";
        }
        //ОТ МКАД
        if($filters_arr->from_mkad_min) {
            $value = (int)$filters_arr->from_mkad_min;
            $filter_line .= " AND o.from_mkad>=$value";
        }
        if($filters_arr->from_mkad_max) {
            $value = (int)$filters_arr->from_mkad_max;
            $filter_line .= " AND o.from_mkad<=$value";
        }
        //ПАР
        if($filters_arr->steam) {
            $value = (int)$filters_arr->steam;
            $filter_line .= " AND o.steam_value=$value";
        }
        //ГАЗ
        if($filters_arr->gas) {
            $value = (int)$filters_arr->gas;
            $filter_line .= " AND o.gas_value=$value";
        }

        /*
        * ФИЛЬТРЫ К БЛОКУ
        */
        //ЦЕНА АРЕНДЫ ОТ
        if($filters_arr->price_min) {
            $value = (int)$filters_arr->price_min;

            if($filters_arr->price_format == 1){
                $filter_line .= " AND o.price_floor_min >=$value";
            }elseif($filters_arr->price_format == 2){
                $filter_line .= " AND o.price_floor_min/12 >=$value";
            }elseif($filters_arr->price_format == 3){
                $filter_line .= " AND o.price_floor_min*o.area_min/12 >=$value";
            }elseif($filters_arr->price_format == 4){
                $filter_line .= " AND o.price_sale_min >=$value";
            }elseif($filters_arr->price_format == 5){
                $filter_line .= " AND o.price_sale_min*o.area_min >=$value";
            }elseif($filters_arr->price_format == 6){
                $filter_line .= " AND o.price_sale_min*100 >=$value";
            }elseif($filters_arr->price_format == 7){
                $filter_line .= " AND o.price_safe_pallet_min >=$value";
            }elseif($filters_arr->price_format == 8){
                $filter_line .= " AND o.price_safe_volume_min >=$value";
            }elseif($filters_arr->price_format == 9){
                $filter_line .= " AND b.price_safe_floor_min >=$value";
            }else{
                if($filters_arr->deal_type == 2){
                    $filter_line .= " AND o.price_sale_min >=$value";
                }elseif($filters_arr->deal_type == 3){
                    $filter_line .= " AND o.price_safe_pallet_min >=$value";
                }else{
                    $filter_line .= " AND o.price_floor_min >=$value";
                }
            }
        }
        //ЦЕНА АРЕНДЫ  ДО
        if($filters_arr->price_max) {
            $value = (int)$filters_arr->price_max;

            if($filters_arr->price_format == 1){
                $filter_line .= " AND o.price_floor_max <=$value";
            }elseif($filters_arr->price_format == 2){
                $filter_line .= " AND o.price_floor_max/12 <=$value";
            }elseif($filters_arr->price_format == 3){
                $filter_line .= " AND o.price_floor_max*o.area_max/12 <=$value";
            }elseif($filters_arr->price_format == 4){
                $filter_line .= " AND o.price_sale_max <=$value";
            }elseif($filters_arr->price_format == 5){
                $filter_line .= " AND o.price_sale_max*o.area_max <=$value";
            }elseif($filters_arr->price_format == 6){
                $filter_line .= " AND o.price_sale_max*100 <=$value";
            }elseif($filters_arr->price_format == 7){
                $filter_line .= " AND o.price_safe_pallet_max <=$value";
            }elseif($filters_arr->price_format == 8){
                $filter_line .= " AND o.price_safe_volume_max <=$value";
            }elseif($filters_arr->price_format == 9){
                $filter_line .= " AND b.price_safe_floor_max <=$value";
            }else{
                if($filters_arr->deal_type == 2){
                    $filter_line .= " AND o.price_sale_max <=$value";
                }elseif($filters_arr->deal_type == 3){
                    $filter_line .= " AND o.price_safe_pallet_max <=$value";
                }else{
                    $filter_line .= " AND o.price_floor_max <=$value";
                }
            }
        }
        //ЦЕНА ПРОДАЖИ ОТ
        if($filters_arr->price_sale_min) {
            $value = (int)$filters_arr->price_sale_min;

            if($filters_arr->price_format == 1){
                $filter_line .= " AND ( o.price_sale*b.area_min >=$value OR b.price_sale*o.area_max >=$value";
            }else{
                $filter_line .= " AND o.price_sale>=$value";
            }
        }
        //ЦЕНА ПРОДАЖИ ДО
        if($filters_arr->price_sale_max) {
            $value = (int)$filters_arr->price_max;

            if($filters_arr->price_format == 1){
                $filter_line .= " AND (o.price_sale*o.area_min <=$value OR o.price_sale*o.area_max <=$value)";
            }else{
                $filter_line .= " AND o.price_sale<=$value";
            }
        }
        //ЦЕНА ОТВЕТ ХРАНЕНИЯ ОТ
        if($filters_arr->price_safe_min) {
            $value = (int)$filters_arr->price_safe_min;

            if($filters_arr->price_format == 1){
                $filter_line .= " AND (o.price_safe_rack_min >=$value OR o.price_safe_rack_max >=$value) ";
            }else{
                $filter_line .= " AND (o.price_safe_cell_min >=$value OR o.price_safe_cell_max >=$value)";
            }
        }
        //ЦЕНА ОТВЕТ ХРАНЕНИЯ ДО
        if($filters_arr->price_safe_max) {
            $value = (int)$filters_arr->price_safe_max;

            if($filters_arr->price_format == 1){
                $filter_line .= " AND (b.price_safe_rack_min <=$value OR b.price_safe_rack_max <=$value) ";
            }else{
                $filter_line .= " AND (b.price_safe_cell_min <=$value OR b.price_safe_cell_max <=$value)";
            }
        }
        //ПЛОЩАДЬ ОТ
        if($filters_arr->area_min){
            $value = (int)$filters_arr->area_min;
            $filter_line .= " AND (o.area_max>=$value )";
            //$filter_line .= " AND (b.area_min>=$value OR b.area_max>=$value OR (SELECT SUM(b3.area_max) FROM c_industry_blocks b3 WHERE b3.offer_id = o.id AND b3.status=1) >= $value)";
            //$filter_line .= " AND (b.area_min>=$value OR (SELECT SUM(b3.area_max) FROM c_industry_blocks b3 WHERE b3.offer_id = o.id) =< $value)";
        }
        //ПЛОЩАДЬ ДО
        if($filters_arr->area_max){
            $value = (int)$filters_arr->area_max;
            //$filter_line .= " AND ((b.area_min<=$value OR b.area_max<=$value) OR (SELECT SUM(b3.area_max) FROM c_industry_blocks b3 WHERE b3.offer_id = o.id) =< $value)  ";
            $filter_line .= " AND (o.area_min<=$value )  ";
        }
        //ПАЛЛЕТ МЕСТ ОТ
        if($filters_arr->pallet_place_min){
            $value = (int)$filters_arr->pallet_place_min;
            $filter_line .= " AND (o.pallet_place_min>=$value OR o.pallet_place_max>=$value)";
        }
        //ПАЛЛЕТ МЕСТ ДО
        if($filters_arr->pallet_place_max){
            $value = (int)$filters_arr->pallet_place_max;
            $filter_line .= " AND (o.pallet_place_min<=$value OR o.pallet_place_max<=$value )  ";
        }
        //ПОТОЛКИ ОТ
        if($filters_arr->ceiling_height_min) {
            $value = (int)$filters_arr->ceiling_height_min;
            $filter_line .= " AND (o.ceiling_height_min>=$value OR o.ceiling_height_max>=$value)";
        }
        //ПОТОЛКИ ДО
        if($filters_arr->ceiling_height_max) {
            $value = (int)$filters_arr->ceiling_height_max;
            $filter_line .= " AND (o.ceiling_height_min<=$value OR o.ceiling_height_max<=$value)";
        }
        //ОТАПЛИВАЕМЫЙ
        if($filters_arr->heated) {
            $value = implode(',',$filters_arr->heated);
            $filter_line .= " AND o.heated IN($value)";
        }
        //ТОЛЬКО ПЕРВЫЙ ЭТАЖ
        if($filters_arr->ground_floor) {
            //$filter_line .= " AND (SELECT COUNT(b4.floor) FROM c_industry_blocks b4 WHERE b4.offer_id = o.id AND b4.floor=1) > 0";
            $filter_line .= " AND (o.floor_min=1 OR o.floor_max=1)";
        }
        //СТЕЛЛАЖИ
        if($filters_arr->racking) {
            $filter_line .= " AND o.racks=1";
        }
        //КРАНЫ
        if($filters_arr->cranes) {
            //$filter_line .= " AND (b.telphers>0 OR b.cranes_cathead>0 OR b.cranes_overhead>0 OR b.cranes_runways>0 OR i.gantry_cranes>0 OR i.railway_cranes>0)";
            //$filter_line .= " AND (o.cranes_overhead_num>0 OR o.cranes_cathead_num>0 OR o.cranes_railway_num>0 OR o.cranes_gantry_num OR o.telpher_num>0)";
            $filter_line .= " AND o.has_cranes=1  ";
        }
        //КАНАЛИЗАЦИЯ
        if($filters_arr->sewage) {
            $filter_line .= " AND o.sewage_central=1";
        }
        //ВОДОСНАБЖЕНИЕ
        if($filters_arr->water) {
            $filter_line .= " AND o.water=1";
        }

        //ТИП ВОРОТ
        if($filters_arr->gate_type) {
            //$filter_line .= " AND b.gates LIKE" . "'%". '"'. $filters_arr->gate_type .'"' ."%'" . " " ;
            //$filter_line .= " AND b.gates LIKE '%1%' " ;
            foreach($filters_arr->gate_type as $gate){
                $gates_line .= " o.gates LIKE '".'%"'.(int)$gate.'"%'."'".'OR';
            }
            $filter_line .= " AND (".trim($gates_line,'OR').")";
        }

        /*
        //ТИП ВОРОТ
        if ($filters_arr->gate_dock || $filters_arr->gate_ramp || $filters_arr->gate_zero) {

            $gatesLine = '';
            if($filters_arr->gate_dock) {
                $gatesLine .= "o.gates LIKE '".'%"'.(int)$filters_arr->gate_dock.'"%'."'".' OR';
            }

            if($filters_arr->gate_ramp) {
                $gatesLine .= "o.gates LIKE '".'%"'.(int)$filters_arr->gate_ramp.'"%'."'".' OR';
            }

            if($filters_arr->gate_zero) {
                $gatesLine .= "o.gates LIKE '".'%"'.(int)$filters_arr->gate_zero.'"%'."'".' OR';
            }
            //$gatesLine = trim($gatesLine,'OR');
            $filter_line .= " AND (".trim($gatesLine,'OR').")";
        }
        */

        //if($filters_arr->gate_dock) {
        //$filter_line .= "AND o.gates LIKE '".'%"'.(int)$filters_arr->gate_dock.'"%'."'".' ';
        //$filter_line .= "AND o.deleted=1";
        //}



        //ТИП ПОЛА
        if($filters_arr->floor_type) {
            $value = implode(',',$filters_arr->floor_type);
            $filter_line .= " AND b.floor_type IN($value)";
        }

    }



}








//СОРТИРОВКА
if($filters_arr->sort_field){
    $sort_field = $filters_arr->sort_field;
    $sort_sql = 'ORDER BY o.'.$sort_field;
    if($filters_arr->sort_dir){
        $sort_sql = $sort_sql.' '.$filters_arr->sort_dir;
    }
}else{
    $sort_sql = 'ORDER BY o.last_update DESC';
}


if($filters_arr->page_items){
    $pageItems = $filters_arr->page_items;
}else{
    $pageItems = 50;
}

if($filters_arr->page_num){
    $page_num = $filters_arr->page_num;
}else{
    $page_num = 1;
}

$curr_num = $pageItems*($page_num-1);


/*$sql_search_text11 = "FROM  c_industry_offers_mix o
                                       LEFT JOIN  c_industry i ON o.object_id=i.id
                                       LEFT JOIN l_locations l ON l.id=i.location_id

                                       $join_line WHERE o.ad_realtor=1 AND o.type_id!=3  $filter_line  $sort_sql ";*/

$sql_search_text = "FROM  c_industry_offers_mix o  $join_line WHERE  o.ad_realtor=1 AND (o.object_type LIKE '%1%' OR o.object_type LIKE '%2%')  AND type_id=2  AND area_min > 0  AND test_only!=1   $filter_line  $sort_sql ";
//$sql_search_text = "FROM  c_industry_offers_mix o  $join_line WHERE  o.ad_realtor=1  AND  type_id=2  AND test_only!=1 AND photos!='[\"[]\"]'  $filter_line  $sort_sql ";

//echo " SELECT DISTINCT o.id $sql_search_text LIMIT $curr_num, $pageItems ";


$all_offers = [];

$intersect = 0;

if($_COOKIE['member_id'] == 141){
    echo "$sql_search_text <br><br>";



    //var_dump($all_fields);

    echo '<br><br>';
}

$table = new OfferMix();
$all_fields = $table->getTableColumnsNames();


$arr_exclude = [
    'ad_cian',
    'ad_cian_top3',
    'ad_cian_premium',
    'ad_cian_hl',
    'ad_yandex',
    'ad_yandex_raise',
    'ad_yandex_promotion',
    'ad_yandex_premium',
    'ad_arendator',
    'ad_realtor',
    'ad_free',
    'ad_special',
    'holidays',
    'commission_client',
    'commission_owner',
    'deposit',
    'pledge',
    'deleted',
    'land_width',
    'land_length',
    'cian_region',
    'outside_mkad',
    'near_mo',
    'town',
    'district',
    'district_moscow',
    'direction',
    'highway',
    'highway_moscow',
    'metro',
    'price_safe_volume_min',
    'price_safe_volume_max',
    '------',
    'photos',

    "warehouse_equipment",
    "charging_room",
    "cross_docking",
    "cranes_runways",
    "cadastral_number",
    "cadastral_number_land",
    "field_allow_usage",
    "available_from",
    "own_type",
    "own_type_land",
    "land_category",
    "entry_territory",
    "parking_car",
    "parking_car_value",
    "parking_lorry",
    "parking_lorry_value",
    "parking_truck",
    "parking_truck_value",
    "built_to_suit",
    "built_to_suit_time",
    "built_to_suit_plan",
    "rent_business",
    "rent_business_fill",
    "rent_business_price",
    "rent_business_long_contracts",
    "rent_business_last_repair",
    "rent_business_payback",
    "rent_business_income",
    "rent_business_profit",
    "sale_company",

];

//$sql_objects = $pdo->prepare("SELECT DISTINCT o.id $sql_search_text LIMIT $curr_num, $pageItems ");
$sql_objects = $pdo->prepare("SELECT DISTINCT o.id $sql_search_text  ");
$sql_objects->execute();


//$sql_objects_count = $pdo->prepare("SELECT COUNT(DISTINCT i.id) as a, COUNT(DISTINCT o.id) as b $sql_search_text  ");
//$sql_objects_count->execute();
//$count_res = $sql_objects_count->fetch();

//$offersAmount = $count_res['b'];


$offers = [];

$offers_list_shown = [];
$intersect_arr = [];

while($offer = $sql_objects->fetch(PDO::FETCH_LAZY)){

    $offerMix = new OfferMix($offer->id);
    $show = 0;

    //если блок то показываем
    if($offerMix->getField('type_id') == 1){
        if(!in_array($offerMix->getField('id'),$offers_list_shown)){
            $show = 1;
            $offers_list_shown[] =  $offerMix->getField('id');
        }else{
            $show = 0;
        }

    }else{
        //echo $offerMix->getField('id').' - '.$offerMix->getField('blocks').' - '.json_encode(getActiveOnly($offerMix->getJsonField('blocks')));
        //echo '<br><br>';
        $active_blocks = getActiveOnly($offerMix->getJsonField('blocks'));
        $active_block = $active_blocks[0];
        //если больше одного активного у предложения то сразу показываем
        if(count($active_blocks) > 1){
            $show = 1;
            //var_dump(getActiveOnly($offerMix->getJsonField('blocks')));
            //echo 'больше 2---<br><br>';
        }else{
            //если активный один и попал в список уже выведенных то не показываем
            //if(count($inter = array_intersect($offers_list_shown,getActiveOnly($offerMix->getJsonField('blocks')))) > 0){
            //echo 'Блок внутри предлож - '.$active_block.'<br><br>';
            if(in_array($active_block,$offers_list_shown)){
                //var_dump($active_blocks);
                //if($active_block == 224){
                //echo 'Блок внутри предлож'.$active_block.'<br><br>';
                //}

                //$intersect++;
                //$intersect_arr[] = $inter[0];
                $show = 0;
            }else{
                $show = 1;
                $offers_list_shown[] =  $active_block;
            }
        }
    }


    //if($show){
    if(true){

        //$offers_list_shown[] = (int)$offer->id;

        $offer_arr = [];
        $building_arr =[];

        //echo $offer->id.'<br>';

        $object = new Building((int)$offerMix->getField('object_id'));

        //ID объекта
        $building_stat = $offerMix->getField('object_id');
        $building_arr['object_id'] = $building_stat;

        $building_stat = $offerMix->getJsonField('photos');
        $building_stat = explode('/',$building_stat[0]);
        $name = array_pop($building_stat);
        $id = array_pop($building_stat);
        $building_arr['photos'] = 'https://pennylane.pro/system/controllers/photos/watermark.php/300/'.$id.'/'.$name;


        //НАЗВАНИЕ объекта
        $building_stat = $offerMix->getField('title');
        $building_arr['title'] = $building_stat;

        //АДРЕС объекта
        $building_stat = capitalize_rus($offerMix->getField('town_name'));

        if($offerMix->getField('highway_name') && $offerMix->getField('region_name') != 'москва'){
            $building_stat.= ', '.capitalize_rus($offerMix->getField('highway_name')).' ш.';
        }
        if($offerMix->getField('from_mkad')){
            $building_stat.= ', '.$offerMix->getField('from_mkad').' км от МКАД';
        }
        if($offerMix->getField('metro_name')){
            $building_stat.= ', м.'.capitalize_rus($offerMix->getField('metro_name'));
        }
        $building_arr['address'] = $building_stat;

        //АДРЕС объекта полный
        $building_stat = $offerMix->getField('address');
        $building_arr['address_full'] = $building_stat;

        //РЕГИОН объекта
        $building_stat = $offerMix->getField('region_name');
        $building_arr['region'] = $building_stat;

        //НАСЕЛЕННЫЙ ПУНКТ объекта
        $building_stat = $offerMix->getField('town_name');
        $building_arr['town'] = $building_stat;

        //ШОССЕ объекта
        $building_stat = $offerMix->getField('highway_name');
        $building_arr['highway']=$building_stat;

        //МЕТРО объекта
        $building_stat = $offerMix->getField('metro_name');
        $building_arr['metro']=$building_stat;

        //ШИРОТА
        $building_stat = $offerMix->getField('latitude') ??  '-';
        $building_arr['latitude'] = $building_stat;

        //ДОЛГОТА
        $building_stat = $offerMix->getField('longitude') ??  '-';
        $building_arr['longitude'] = $building_stat;


        //Название объекта объекта
        $building_stat = $object->getField('title');
        $building_arr['title'] = $building_stat;

        //РАССТОЯНИЕ ОТ МКАД
        $building_stat = $object->getField('from_mkad') ??  '-';
        $building_arr['from_mkad'] = $building_stat;

        //ЭЛЕКТРИЧЕСКИЕ МОЩНОСТИ
        $building_stat = $object->getField('power_value') ??  '-';
        $building_arr['power'] = $building_stat;



        //СОБИРАЕМ ОСНОВНЫЕ ХАРАКТЕРИСТИКИ
        $general = [];
        if($offerMix->getField('floor_min') && !$offerMix->getField('is_land') ){
            $val= valuesCompare($offerMix->getField('floor_min'),$offerMix->getField('floor_max')).' этаж';
            $general['floors'] = $val;
        }
        if($offerMix->getField('gate_type') && !$offerMix->getField('is_land')){
            $val= $offerMix->getField('gate_type');
            $general['gates'] = $val;
        }
        if($offerMix->getField('power')){
            $val= $offerMix->getField('power_value').' кВт';
            $general['power'] = $val;
        }
        if($offerMix->getField('ceiling_height_min') && !$offerMix->getField('is_land')){
            $val= valuesCompare($offerMix->getField('ceiling_height_min'),$offerMix->getField('ceiling_height_max')).' метров';
            $general['ceiling'] = $val;
        }
        if($offerMix->getField('floor_type')){
            $val= $offerMix->getField('floor_type');
            $general['floor'] = $val;
        }
        if(!$offerMix->getField('is_land') && !2){
            if($offerMix->getField('temperature_max') > 10){
                $val= 'Теплый';
            }else{
                $val= 'Холодный';
            }
            $general['heating'] = $val;
        }

        if($offerMix->getField('water') && $offerMix->getField('is_land')){
            $val= 'Вода';
            $general['water'] = $val;
        }
        if($offerMix->getField('sewage_central') && $offerMix->getField('is_land')){
            $val= 'Канализация';
            $general['sewage'] = $val;
        }
        if($offerMix->getField('gas')){
            $val= 'Газ';
            $general['gas'] = $val;
        }
        if($offerMix->getField('steam')){
            $val= 'Пар';
            $general['steam'] = $val;
        }
        if((int)$offerMix->getField('cranes_min') != 0){
            $val= valuesCompare($offerMix->getField('cranes_min'),$offerMix->getField('cranes_max')).' тонн';
            $general['cranes'] = $val;
        }

        $offer_arr['general_stats'] = $general;




        /**
         * тут нужно посмотреть все поля и в ццикле наполнять ключ - значение
         */
        foreach ($all_fields as $field) {
            if(!in_array($field,$arr_exclude)) {
                $offer_arr[$field]  = $offerMix->getField($field);
            }
        }


        //НАЛОГИ И КУ
        $offer_stat = '';
        if($offerMix->getField('deal_type') == 2){
            if($offerMix->getField('deal_type') != NULL){
                $offer_stat.= mb_strtoupper($offerMix->getField('tax_form'));
            }
        }else{
            if($offerMix->getField('tax_form') == 'triple net' ){
                $offer_stat.= 'без НДС, дополнительно OPEX и КУ';
            }else{
                if($offerMix->getField('tax_form') == 'c ндс'){
                    $offer_stat.= 'c НДС';
                }else{
                    $offer_stat.= 'без НДС';
                }
                if($offerMix->getField('price_opex_inc') == 0 || $offerMix->getField('price_public_services_inc') == 0){
                    $offer_stat.= ', дополнительно';
                    if($offerMix->getField('price_opex_inc') == 0){
                        $offer_stat.= ' OPEX ';
                    }
                    if($offerMix->getField('price_public_services_inc') == 0){
                        $offer_stat.= ', КУ ';
                    }
                }
            }
        }

        $offer_arr['tax'] = $offer_stat;


        $offer_arr['building'] = $building_arr;
        $offers[] = $offer_arr;


    }
}

if($_COOKIE['member_id']){

    //var_dump($offers_list_shown);
    //echo '<br><br>';
    //echo 'кол-во пересекшихся'.$intersect++;
    //var_dump($intersect_arr);

}

$offersAmount = count($offers);
$pagesAmount = $offersAmount/$pageItems;
$all_offers['amount'] = $offersAmount;
$all_offers['pages'] = ceil($pagesAmount);
$all_offers['page'] = $page_num;

$page_offers = [];

for($i =$curr_num; $i < ($curr_num+$pageItems); $i++){
    if($offers[$i]){
        $page_offers[] = $offers[$i];
    }

}

$all_offers['offers'] = $page_offers;




echo json_encode($all_offers, JSON_UNESCAPED_UNICODE);





































/*
include_once($_SERVER['DOCUMENT_ROOT'].'/global_pass.php');

//$search = $_POST['search'];

if($_POST['request']){
    $filters_arr = json_decode($_POST['request']);

    $search = $filters_arr->search;
}else{

    $search = '2413';
}





$arr_tables = [
    //'ID'=>'c_)industry',
    'Регион'=>['l_regions','regions'],
    'Город'=>['l_towns','towns'],
    'Район'=>['l_districts','districts'],
    'Округ'=>['l_districts_moscow','districts_moscow'],
    'Направления'=>['l_directions','directions'],
    'Метро'=>['l_metros','metros'],
    'Шоссе МО'=>['l_highways','highways'],
    'Шоссе Москвы'=>['l_highways_moscow','highways_moscow'],
];

$arr_response = [];


foreach ($arr_tables as $key=>$value){
    $arr = [];
    $sql = $pdo->prepare("SELECT * FROM $value[0] WHERE title LIKE '%$search%'   ORDER BY title DESC LIMIT 5");
    $sql->execute();
    while($item = $sql->fetch(PDO::FETCH_LAZY)){
        $arr['title'] = $key;
        $arr['eng'] = $item->title_eng;
        $arr['type'] = $value[1];
        $arr['name'] = $item->title;
    }
    if($arr){
        $arr_response[] = $arr;
    }


}

echo json_encode($arr_response, JSON_UNESCAPED_UNICODE) ;
