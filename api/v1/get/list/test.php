
<?php

///это бэкап апишки что была перед тем как перделываем с фроловым

if($_COOKIE['member_id']){
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

if($_POST['request']){
    $filters_arr = json_decode($_POST['request']);
}else{

    $filters['id'] =  0;
    $filters['page_num'] = 1;


    $filters['search'] =  '';

    $filters['region'] =  '';
    $filters['directions'] =  '';
    $filters['towns'] =  '';
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



    $filters = json_encode($filters);

    $filters_arr = json_decode($filters);

}




$filter_line = '';


if($value = $filters_arr->search) {

    $search_fields = [
        'object_id',
        'title',
        'object_type',
        'direction',
        'highway',
        //'highway_moscow',
        'town',
        //'town_central',
        'metro',
        'district',
        //'district_moscow',
    ];
    $fields_line = '';

    foreach($search_fields as $field){
        $fields_line.= "o.$field LIKE '%$value%' OR ";
    }
    //echo $fields_line;
    $filter_line .= ' AND ('.trim($fields_line,'OR ').')';
}else{
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
            $filter_line .= " AND (o.deal_type=$value OR o.deal_type=4) ";
        }else{
            $filter_line .= " AND o.deal_type=$value ";
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
                $filter_line .= " AND (l.region=1 OR l.region=6)  ";
            }elseif($value == 200){
                $filter_line .= " AND l.region=6 AND l.outside_mkad=0";
            }elseif($value == 300){
                $filter_line .= " AND l.region=1 OR (l.outside_mkad=1 AND l.region=6)";
            }elseif($value == 400){
                $filter_line .= " AND l.region=1 OR l.near_mo=1 ";
            }elseif($value == 1000){
                $filter_line .= " ";
            }else{
                $filter_line .= " AND l.region=$value";
            }
        }else{
            if($value == 'moskva-i-mo'){
                $filter_line .= " AND (l.region=1 OR l.region=6)  ";
            }elseif($value == 'moskva-vnutri-mkad'){
                $filter_line .= " AND l.region=6 AND l.outside_mkad=0";
            }elseif($value == 'mo-moskva-snaruzhi-mkad'){
                $filter_line .= " AND l.region=1 OR (l.outside_mkad=1 AND l.region=6)";
            }elseif($value == 'mo-regiony-ryadom'){
                $filter_line .= " AND l.region=1 OR l.near_mo=1 ";
            }elseif($value == 'vsya-rosssiya'){
                $filter_line .= " ";
            }else{
                $region = new Post();
                $region->getTable('l_regions');

                $value = $region->getPostByField('title_eng',$filters_arr->region);
                $filter_line .= " AND l.region=$value";
            }
        }
    }

    if(1) {

        $arr_location = [
            [
                'name'=>'directions',
                'table'=>'l_directions',
                'fields'=>['direction','direction_relevant'],
            ],
            [
                'name'=>'districts_moscow',
                'table'=>'l_districts_moscow',
                'fields'=>['district_moscow','district_moscow_relevant'],
            ],
            [
                'name'=>'towns',
                'table'=>'l_towns_central',
                'fields'=>['town_central'],
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
                    $fields_line.= "l.$field IN($items_line) OR ";
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
    if($filters_arr->object_type) {
        $types = $filters_arr->object_type;
        foreach($types as $type){
            $object_line .= " o.object_type LIKE '%".(int)$type."%' OR";
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
            $filter_line .= " AND i.object_class IN($class_line)";
        }
        //ЖД ветка
        if($filters_arr->railway) {
            $filter_line .= " AND i.railway='1'";
        }
        //ЭЛЕКТРИЧЕСТВО
        if($filters_arr->power) {
            $value = (int)$filters_arr->power;
            $filter_line .= " AND i.power>=$value";
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
                $filter_line .= " AND ( b.price_sale*b.area_min >=$value OR b.price_sale*b.area_max >=$value";
            }else{
                $filter_line .= " AND b.price_sale>=$value";
            }
        }
        //ЦЕНА ПРОДАЖИ ДО
        if($filters_arr->price_sale_max) {
            $value = (int)$filters_arr->price_max;

            if($filters_arr->price_format == 1){
                $filter_line .= " AND (b.price_sale*b.area_min <=$value OR b.price_sale*b.area_max <=$value)";
            }else{
                $filter_line .= " AND b.price_sale<=$value";
            }
        }
        //ЦЕНА ОТВЕТ ХРАНЕНИЯ ОТ
        if($filters_arr->price_safe_min) {
            $value = (int)$filters_arr->price_safe_min;

            if($filters_arr->price_format == 1){
                $filter_line .= " AND (b.price_safe_rack_min >=$value OR b.price_safe_rack_max >=$value) ";
            }else{
                $filter_line .= " AND (b.price_safe_cell_min >=$value OR b.price_safe_cell_max >=$value)";
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
            $filter_line .= " AND (o.area_min>=$value OR o.area_max>=$value )";
            //$filter_line .= " AND (b.area_min>=$value OR b.area_max>=$value OR (SELECT SUM(b3.area_max) FROM c_industry_blocks b3 WHERE b3.offer_id = o.id AND b3.status=1) >= $value)";
            //$filter_line .= " AND (b.area_min>=$value OR (SELECT SUM(b3.area_max) FROM c_industry_blocks b3 WHERE b3.offer_id = o.id) =< $value)";
        }
        //ПЛОЩАДЬ ДО
        if($filters_arr->area_max){
            $value = (int)$filters_arr->area_max;
            //$filter_line .= " AND ((b.area_min<=$value OR b.area_max<=$value) OR (SELECT SUM(b3.area_max) FROM c_industry_blocks b3 WHERE b3.offer_id = o.id) =< $value)  ";
            $filter_line .= " AND (o.area_min<=$value OR o.area_max<=$value )  ";
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
        if($filters_arr->racks) {
            $filter_line .= " AND o.racks=1";
        }
        //КРАНЫ
        if($filters_arr->cranes) {
            //$filter_line .= " AND (b.telphers>0 OR b.cranes_cathead>0 OR b.cranes_overhead>0 OR b.cranes_runways>0 OR i.gantry_cranes>0 OR i.railway_cranes>0)";
            $filter_line .= " AND (o.cranes_overhead_num>0 OR o.cranes_cathead_num>0 OR o.cranes_railway_num>0 OR o.cranes_gantry_num OR o.telpher_num>0)";
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
                $gates_line .= " b.gates LIKE '".'%"'.(int)$gate.'"%'."'".'OR';
            }
            $filter_line .= " AND (".trim($gates_line,'OR').")";
        }

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


$sql_search_text = "FROM  c_industry_offers_mix o    
                                       LEFT JOIN  c_industry i ON o.object_id=i.id                      
                                       LEFT JOIN l_locations l ON l.id=i.location_id                                                                                                
                                                  
                                       $join_line WHERE o.status=1 AND o.ad_realtor=1 AND o.type_id=2  $filter_line  $sort_sql ";

//echo " SELECT DISTINCT o.id $sql_search_text LIMIT $curr_num, $pageItems ";


$all_offers = [];

$intersect = 0;

if($_COOKIE['member_id'] == 141){
    echo "SELECT DISTINCT o.id $sql_search_text LIMIT $curr_num, $pageItems <br><br>";

    $table = new Post(42);
    $table->getTable('c_industry_offers_mix');
    $all_fields = $table->getTableColumnsNames();

    var_dump($all_fields);

    echo '<br><br>';
}

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


    if($show){

        //$offers_list_shown[] = (int)$offer->id;

        $offer_arr = [];
        $building_arr =[];

        //echo $offer->id.'<br>';

        $object = new Building((int)$offerMix->getField('object_id'));

        //ID объекта
        $building_stat = $offerMix->getField('object_id');
        $building_arr['object_id'] = $building_stat;

        //НАЗВАНИЕ объекта
        $building_stat = $offerMix->getField('title');
        $building_arr['title'] = $building_stat;



        //АДРЕС объекта
        $building_stat = capitalize_rus($offerMix->getField('town'));


        if($offerMix->getField('highway') && $offerMix->getField('region') != 'москва'){
            $building_stat.= ', '.capitalize_rus($offerMix->getField('highway')).' ш.';
        }
        if($offerMix->getField('from_mkad')){
            $building_stat.= ', '.$offerMix->getField('from_mkad').' км от МКАД';
        }
        if($offerMix->getField('metro')){
            $building_stat.= ', м.'.capitalize_rus($offerMix->getField('metro'));
        }
        $building_arr['address'] = $building_stat;


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
        if($offerMix->getField('cranes_min')){
            $val= valuesCompare($offerMix->getField('cranes_min'),$offerMix->getField('cranes_max')).' тонн';
            $general['cranes'] = $val;
        }

        $offer_arr['general_stats'] = $general;


        //АДРЕС объекта полный
        $building_stat = $offerMix->getField('address');
        $building_arr['address_full'] = $building_stat;

//РЕГИОН объекта
        $building_stat = $offerMix->getField('region');
        $building_arr['region'] = $building_stat;

//НАСЕЛЕННЫЙ ПУНКТ объекта
        $building_stat = $offerMix->getField('town');
        $building_arr['town'] = $building_stat;

//ШОССЕ объекта
        $building_stat = $offerMix->getField('highway');
        $building_arr['highway']=$building_stat;

//МЕТРО объекта
        $building_stat = $offerMix->getField('metro');
        $building_arr['metro']=$building_stat;

//ШИРОТА
        $building_stat = $offerMix->getField('latitude') ??  '-';
        $building_arr['latitude'] = $building_stat;

//ДОЛГОТА
        $building_stat = $offerMix->getField('longitude') ??  '-';
        $building_arr['longitude'] = $building_stat;


        //НАЗНАЧЕНИЯ объекта
        /*
        $building_stat = $object->getField('purposes');
        $purpopes_arr =[];
        foreach($object->getJsonField('purposes') as $purpose){
            $purpose_arr = [];

            $purp_item = new Post($purpose);
            $purp_item->getTable('l_purposes');

            $purpose_arr['id'] = $purp_item->postId();
            $purpose_arr['title'] = $purp_item->title();

            $purpopes_arr[] = $purpose_arr;
        }
        $building_arr['purposes'] = $purpopes_arr;
        */


        //Название объекта объекта
        $building_stat = $object->getField('title');
        $building_arr['title'] = $building_stat;

        //РАССТОЯНИЕ ОТ МКАД
        $building_stat = $object->getField('from_mkad') ??  '-';
        $building_arr['from_mkad'] = $building_stat;

        //ЭЛЕКТРИЧЕСКИЕ МОЩНОСТИ
        $building_stat = $object->getField('power') ??  '-';
        $building_arr['power'] = $building_stat;


//ID МИКСОВАНОГО ПРЕДЛОЖЕНИЯ
        $offer_stat = $offerMix->getField('id') ??  '-';
        $offer_arr['id'] = $offer_stat;

        //ID блока визуально
        $offer_stat = $offerMix->getField('visual_id');
        $offer_arr['visual_id'] = $offer_stat;

//ID ПРЕДЛОЖЕНИЯ
        $offer_stat = $offerMix->getField('original_id') ??  '-';
        $offer_arr['original_id'] = $offer_stat;

//ID типа блок или предложение
        $offer_stat = $offerMix->getField('type_id') ??  '-';
        $type_arr = [];
        if($offerMix->getField('type_id') == 1){
            $type_title = 'Блок';
        }else{
            $type_title = 'Предложение';
        }
        $type_arr['id'] = $offerMix->getField('type_id');
        $type_arr['title'] = $type_title;
        $offer_arr['type_id'] = $type_arr;

//ТИП СДЕЛКИ ПРЕДЛОЖЕНИЯ
        $offer_stat = $offerMix->getField('deal_type') ??  '-';
        $deal_type = new Post($offerMix->getField('deal_type'));
        $deal_type->getTable('l_deal_types');
        $deal_arr = [];
        $deal_arr['id'] = $deal_type->postId();
        $deal_arr['title'] = $deal_type->title();
        $offer_arr['deal_type'] = $deal_arr;

//ФОТОГРАФИИ
        $offer_stat = $offerMix->getField('photos') ??  '-';
        if(json_decode($offer_stat)[0]){
            $parts = explode('/',json_decode($offer_stat)[0]);
            $photo = array_pop($parts);
        }else{
            $photo = '';
        }
        $offer_arr['photos'] = $photo;

//ПЛОЩАДЬ ОТ
        $offer_stat = $offerMix->getField('area_min') ??  '-';
        $offer_arr['area_min'] = $offer_stat;

//ПЛОЩАДЬ ДО
        $offer_stat = $offerMix->getField('area_max') ??  '-';
        $offer_arr['area_max'] = $offer_stat;

//ВЫСОТА ПОТОЛКОВ ОТ
        $offer_stat = $offerMix->getField('ceiling_height_min') ??  '-';
        $offer_arr['ceiling_height_min'] = $offer_stat;

//ВЫСОТА ПОТОЛКОВ ДО
        $offer_stat = $offerMix->getField('ceiling_height_max') ??  '-';
        $offer_arr['ceiling_height_max'] = $offer_stat;

//ПАЛЛЕТ МЕСТ ОТ
        $offer_stat = ($offerMix->getField('pallet_place_min')) ??  '-';
        $offer_arr['pallet_place_min'] = $offer_stat;

//ПАЛЛЕТ МЕСТ ДО
        $offer_stat = $offerMix->getField('pallet_place_max') ??  '-';
        $offer_arr['pallet_place_max'] = $offer_stat;

//ЭТАЖ ОТ
        $offer_stat = ($offerMix->getField('floor_min')) ?? '-';
        $offer_arr['floor_min'] = $offer_stat;

//ЭТАЖ ДО
        $offer_stat = ($offerMix->getField('floor_max')) ?? '-';
        $offer_arr['floor_max'] = $offer_stat;


        //ЦЕНА АРЕДЫ ОТ
        $offer_stat = ($offerMix->getField('price_floor_min')) ?? '-';
        $offer_arr['price_min'] = $offer_stat;

        //ЦЕНА АРЕДЫ ДО
        $offer_stat = ($offerMix->getField('price_floor_max')) ?? '-';
        $offer_arr['price_max'] = $offer_stat;

        //ЦЕНА 100 АРЕДЫ ОТ
        $offer_stat = ($offerMix->getField('price_floor_100_min')) ?? '-';
        $offer_arr['price_100_min'] = $offer_stat;

        //ЦЕНА 100 АРЕДЫ ДО
        $offer_stat = ($offerMix->getField('price_floor_100_max')) ?? '-';
        $offer_arr['price_100_max'] = $offer_stat;

        //ЦЕНА АРЕДЫ В МЕСЯЦ ОТ
        $offer_stat = ($offerMix->getField('price_floor_min_month')) ?? '-';
        $offer_arr['price_min_month'] = $offer_stat;

        //ЦЕНА АРЕДЫ в МЕСЯЦ ДО
        $offer_stat = ($offerMix->getField('price_floor_max_month')) ?? '-';
        $offer_arr['price_max_month'] = $offer_stat;

        //ЦЕНА АРЕДЫ В МЕСЯЦ ЗА ВСЕ ОТ
        $offer_stat = ($offerMix->getField('price_min_month_all')) ?? '-';
        $offer_arr['price_min_month_all'] = $offer_stat;

        //ЦЕНА АРЕДЫ в МЕСЯЦ ЗА ВСЕ ДО
        $offer_stat = ($offerMix->getField('price_max_month_all')) ?? '-';
        $offer_arr['price_max_month_all'] = $offer_stat;

        //ЦЕНА ПРОДАЖИ ОТ
        $offer_stat = ($offerMix->getField('price_sale_min')) ?? '-';
        $offer_arr['price_sale_min'] = $offer_stat;

        //ЦЕНА ПРОДАЖИ ДО
        $offer_stat = ($offerMix->getField('price_sale_max')) ?? '-';
        $offer_arr['price_sale_max'] = $offer_stat;

        //ЦЕНА ПРОДАЖИ ЗА ВСЕ ОТ
        $offer_stat = ($offerMix->getField('price_sale_min_all')) ?? '-';
        $offer_arr['price_sale_min_all'] = $offer_stat;

        //ЦЕНА ПРОДАЖИ ЗА ВСЕ ДО
        $offer_stat = ($offerMix->getField('price_sale_max_all')) ?? '-';
        $offer_arr['price_sale_max_all'] = $offer_stat;

        //ЦЕНА ОТВЕТКИ ОТ
        $offer_stat = ($offerMix->getField('price_safe_pallet_min')) ?? '-';
        $offer_arr['price_safe_pallet_min'] = $offer_stat;

        //ЦЕНА АРЕДЫ ПРОДАЖИ ДО
        $offer_stat = ($offerMix->getField('price_safe_pallet_max')) ?? '-';
        $offer_arr['price_safe_pallet_max'] = $offer_stat;

        //ЦЕНА ОТВЕТКИ ОТ
        $offer_stat = ($offerMix->getField('price_safe_floor_min')) ?? '-';
        $offer_arr['price_safe_floor_min'] = $offer_stat;

        //ЦЕНА АРЕДЫ ПРОДАЖИ ДО
        $offer_stat = ($offerMix->getField('price_safe_floor_max')) ?? '-';
        $offer_arr['price_safe_floor_max'] = $offer_stat;

        //ЦЕНА ОТВЕТКИ ОТ
        $offer_stat = ($offerMix->getField('price_safe_volume_min')) ?? '-';
        $offer_arr['price_safe_volume_min'] = $offer_stat;

        //ЦЕНА АРЕДЫ ПРОДАЖИ ДО
        $offer_stat = ($offerMix->getField('price_safe_volume_max')) ?? '-';
        $offer_arr['price_safe_volume_max'] = $offer_stat;

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



