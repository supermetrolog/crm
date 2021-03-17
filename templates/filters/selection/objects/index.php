<?

$filters_arr = json_decode($_GET['request']);

$filter_line = '';

/*
 * LINE SEARCH BLOCK
 */
//if($filters_arr->search){
    $search_line = trim($filters_arr->search);
    //начинаем поиск только если в строке более 3 символов
    if(iconv_strlen($search_line) < 6 && ctype_digit($search_line)) {
        $search_fil = 'AND i.id='.$search_line;
    }else{
        $search_arr = explode(' ',$search_line);
        /*
         * Массив таблиц для подключения и поиска
         */
        $search_table_arr = array(
            'i'=>array('c_industry','',''), //формат : таблица - поле прикрепляемой - поле основной
            'o'=>array('c_industry_offers','',''),
            'b'=>array('c_industry_blocks','',''),
            'u'=>array('core_users','',''),
            'c'=>array('c_industry_companies','id','company_id'),
            'k'=>array('c_industry_contacts','id','contact_id')
        );

        /*
         * Формируем строку поиска и строку JOIN'ов
         */

        foreach($search_arr as $search_arr_word){ //для каждого слова из строки поиска
            foreach($search_table_arr as $key=>$value){ //для каждой таблицы из массива по которым ищем
                $table_obj = new Post(0);
                $table_obj->getTable($value[0]);
                foreach($table_obj->getTableColumnsNames() as $column_name){//для каждого поля в таблице
                    $field = new Field(0);
                    $field->getFieldByName($column_name);
                    if($field->avaliableForSearch()){
                        $search_fil_word = $search_fil_word." $key.$column_name LIKE '%".$search_arr_word."%' OR"; //набираем строку полей
                    }
                }
            }

            $search_fil_word = '('.trim($search_fil_word,'OR').') AND '; //удаляем крайние OR , берем в скобки часть строки для этого слова , добавляем AND в конце для склейки
            $search_fil = $search_fil.$search_fil_word; //добавляем строку слова к полной строке
            $search_fil_word = ''; //обнуляем строку для слова

        }

        $search_fil = trim(trim($search_fil),'AND'); //обрезаем всю строку с краев на AND
        foreach($search_table_arr as $key=>$value){ //собираем JOIN для каждой таблицы из массива по которым ищем
            if($value[1]){
                $join_line .= " LEFT JOIN ".$value[0]." $key ON o.".$value[2]."=$key.".$value[1]."  ";
            }
        }
        $search_fil = "AND ".$search_fil;
    }
//}else{
    /*
 * ФИЛЬТРЫ К ПРЕДЛОЖЕНИЮ
 */
//ТИП СДЕЛКИ
    if($value = (int)$filters_arr->deal_type) {
        if($filters_arr->deal_type == 1){
            $filter_line .= " AND (o.deal_type=$value OR o.deal_type=4 OR o.deal_type=3 ) ";
        }else{
            $filter_line .= " AND o.deal_type=$value ";
        }
    }
//СТАТУС

    if($value = (int)$filters_arr->status == 1) {
        $filter_line .= " AND ((SELECT MIN(b2.deal_id) FROM c_industry_blocks b2 WHERE b2.offer_id = o.id) = 0)";
    }elseif($value = (int)$filters_arr->status == 2){
        $filter_line .= " AND ((SELECT MIN(b2.deal_id) FROM c_industry_blocks b2 WHERE b2.offer_id = o.id) > 0)";
    }else{

    }

    if($value = (int)$filters_arr->status == 1){
        $filter_line .= " AND b.deal_id=0";
    }elseif($value = (int)$filters_arr->status == 2){
        $filter_line .= " AND b.deal_id>0";
    }else{

    }

    /*
     * ФИЛЬТРЫ К ОБЪЕКТУ
     */
//РЕГИОН
    if($value = (int)$filters_arr->region) {
        if($value == 100){
            $filter_line .= " AND (l.region=1 OR l.region=6)  ";
        }elseif($value == 200){
            $filter_line .= " AND (l.region=6 AND l.outside_mkad=0)";
        }elseif($value == 300){
            $filter_line .= " AND (l.region=1 OR (l.outside_mkad=1 AND l.region=6))";
        }elseif($value == 400){
            $filter_line .= " AND (l.region=1 OR l.near_mo=1) ";
        }elseif($value == 1000){
            $filter_line .= " ";
        }else{
            $filter_line .= " AND (l.region=$value)";
        }

    }

//ТИП ОБЪЕКТА
    if($type = (int)$filters_arr->object_type) {
        if($type == 1){
            $filter_line .= " AND  (i.object_type LIKE '%1%' OR i.object_type LIKE '%2%') ";
        }else{
            $filter_line .= " AND i.object_type LIKE '%3%'";
        }
        //$filter_line .= " AND i.object_type LIKE '%$type%'";



        //НАЗНАЧЕНИЕ ОБЪЕКТА
        if($filters_arr->purposes) {
            foreach($filters_arr->purposes as $purpose){
                $purp_obj = new Purpose($purpose);
                if($purp_obj->getField('type') == $type){
                    $purpose_line .= " i.purposes LIKE '".'%"'.(int)$purpose.'"%'."'".'OR';
                }
            }
            if($purpose_line){
                $filter_line .= " AND (".trim($purpose_line,'OR').")";
            }
        }


        /*
        if(in_array(3,$filters_arr->object_type)){
            //$object_type_line .= "i.purposes LIKE '%13%' OR ";
            $filter_line .= "AND (i.purposes LIKE '".'%"13"%' . "' OR "." i.purposes LIKE '".'%"14"%'."' OR " . "i.purposes LIKE '".'%"15"%'."')";
        }elseif(in_array(2,$filters_arr->object_type)){
            //$filter_line .= "AND i.purposes LIKE '".'%"2"%'."'";
            //$filter_line .= "AND JSON_CONTAINS(i.purposes, 'one', '2') IS NOT NULL OR JSON_CONTAINS(i.purposes, 'one', '4') IS NOT NULL OR JSON_CONTAINS(i.purposes, 'one', '5') IS NOT NULL OR JSON_CONTAINS(i.purposes, 'one', '6') IS NOT NULL";
            //$filter_line .= "AND JSON_CONTAINS(i.purposes, '2') IS NOT NULL OR JSON_CONTAINS(i.purposes,'4') IS NOT NULL OR JSON_CONTAINS(i.purposes, '5') IS NOT NULL OR JSON_CONTAINS(i.purposes, '6') IS NOT NULL";
            $filter_line .= "AND (i.purposes LIKE '".'%"2"%'."' OR "." i.purposes LIKE '".'%"4"%'."' OR "."i.purposes LIKE '".'%"5"%'."' OR "."i.purposes LIKE '".'%"6"%'."')";
        }elseif(in_array(1,$filters_arr->object_type)){
            //$filter_line .= "AND JSON_CONTAINS(i.purposes, 'one', '1') IS NOT NULL OR JSON_CONTAINS(i.purposes, 'one', '3') IS NOT NULL OR JSON_CONTAINS(i.purposes, 'one', '8') IS NOT NULL OR JSON_CONTAINS(i.purposes, 'one', '9') IS NOT NULL OR JSON_CONTAINS(i.purposes, 'one', '10') IS NOT NULL OR JSON_CONTAINS(i.purposes, 'one', '11') IS NOT NULL OR JSON_CONTAINS(i.purposes, 'one', '12') IS NOT NULL";
            $filter_line .= "AND (i.purposes LIKE '".'%"1"%'."' OR "." i.purposes LIKE '".'%"4"%'."' OR "."i.purposes LIKE '".'%"3"%'."' OR "."i.purposes LIKE '".'%"8"%'."' OR "."i.purposes LIKE '".'%"9"%'."' OR "."i.purposes LIKE '".'%"10"%'."' OR "."i.purposes LIKE '".'%"11"%'."' OR "."i.purposes LIKE '".'%"12"%'."' )";
        }else{

        }
        */
    }

    if($filters_arr->ad_cian) {
        $filter_line .= " AND (b.ad_cian=1 OR o.ad_cian=1) ";
    }

    if($filters_arr->safe_type) {
        $safe_types = $filters_arr->safe_type;
        foreach ($safe_types as $safe_type){
            $safe_type_line .= " b.safe_type LIKE '".'%"'.(int)$safe_type.'"%'."'".'OR';
        }
        if($safe_type_line){
            $filter_line .= " AND (".trim($safe_type_line,'OR').")";
        }
    }



    if($filters_arr->region) {
        //РАЙОН МОСКВЫ
        //НАПРАВЛЕНИЕ

        if($filters_arr->districts_moscow && $filters_arr->directions) {
            $districts_line = implode(',',$filters_arr->districts_moscow);
            $directions_line = implode(',',$filters_arr->directions);

            $filter_line .= " AND ( l.district_moscow IN($districts_line) OR l.district_moscow_relevant IN($districts_line) OR l.direction IN($directions_line) OR l.direction_relevant IN($directions_line) )";
        }else{
            if($filters_arr->directions) {
                $directions_line = implode(',',$filters_arr->directions);
                $filter_line .= " AND (l.direction IN($directions_line) OR l.direction_relevant IN($directions_line))";
            }
            if($filters_arr->districts_moscow) {
                $districts_line = implode(',',$filters_arr->districts_moscow);
                $filter_line .= " AND (l.district_moscow IN($districts_line) OR l.district_moscow_relevant IN($districts_line))";
            }
        }
        //НАСЕЛЕННЫЙ ПУНКТ
        if($filters_arr->towns) {
            $towns_line = implode(',',$filters_arr->towns);
            $filter_line .= " AND l.town_central IN($towns_line)";
        }
        //ШОССЕ
        if($filters_arr->highways) {
            $highways_line = implode(',',$filters_arr->highways);
            $filter_line .= " AND l.highway IN($highways_line)";
        }

        if($filters_arr->highways_moscow) {
            $highways_line = implode(',',$filters_arr->highways_moscow);
            $filter_line .= " AND l.highway_moscow IN($highways_line)";
        }
        //МЕТРО
        if($filters_arr->metros) {
            $metros_line = implode(',',$filters_arr->metros);
            $filter_line .= " AND l.metro IN($metros_line)";
        }

        //РАЙОН
        if($filters_arr->districts) {
            $districts_line = implode(',',$filters_arr->districts);
            $filter_line .= " AND l.district IN($districts_line)";
        }

    }

//СОРТИРОВКА
    if($filters_arr->sort){

        $sort_fields = [
            'mkad'=>'i.from_mkad',
            'area'=>'b.area_floor_min, b.area_min, b.pallet_place_min',
            'price'=>'b.price_floor_min, b.price_sale_min, b.price_safe_pallet_eu_min',
            'id'=>'i.id',
            'update'=>'b.last_update',
            'region'=>'l.region',
            'direction'=>'l.direction, l.highway, l.highway_moscow',
            'user'=>'u.last_name, u.title',
        ];
        $sort_dir = [
            '1'=>'ASC',
            '2'=>'DESC',
        ];

        $value = explode('-',$filters_arr->sort);

        $sort_part = "ORDER BY ".$sort_fields[$value[0]].' '.$sort_dir[$value[1]];
    }else{
        $sort_part = "ORDER BY b.last_update DESC";
    }




    if($value = (int)$filters_arr->no_safe){
        $filter_line .= " AND o.deal_type!=3";
    }


///////Условие работы
//if($filters_arr->deal_type && $filters_arr->object_type) {
    if($filters_arr->deal_type && ($filters_arr->object_type || $filters_arr->safe_type)) {

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
        if($value = (int)$filters_arr->power) {
            $filter_line .= " AND i.power>=$value";
        }
        //ОТ МКАД
        if($value = (int)$filters_arr->from_mkad) {
            $filter_line .= " AND (i.from_mkad<=$value OR i.from_mkad IS NULL OR  i.from_mkad=0 )";
        }
        /*
        if($filters_arr->from_mkad_max) {
            $value = (int)$filters_arr->from_mkad_max;
            $filter_line .= " AND (i.from_mkad<=$value OR i.from_mkad IS NULL OR  i.from_mkad=0)";
        }
        */
        //ПАР
        if($filters_arr->steam) {
            $value = (int)$filters_arr->steam;
            $filter_line .= " AND i.steam=$value";
        }
        //ГАЗ
        if($filters_arr->gas) {
            $value = (int)$filters_arr->gas;
            $filter_line .= " AND i.gas=$value";
        }

        /*
        * ФИЛЬТРЫ К БЛОКУ
        */
        //ЦЕНА АРЕНДЫ ОТ
        if($value = (int)$filters_arr->price_min) {
            if($filters_arr->price_format == 2){
                $filter_line .= " AND ( b.price_floor_max/12 >=$value) ";
            }elseif($filters_arr->price_format == 3){
                $filter_line .= " AND ( b.price_floor_max*b.area_floor_max/12 >=$value)";
            }elseif($filters_arr->price_format == 1){
                $filter_line .= " AND ( b.price_floor_max>=$value) ";
            }else{
                $filter_line .= " AND ( (b.price_floor_max>=$value AND o.deal_type!=3) OR ( o.deal_type=3 AND (SELECT MIN(b3.pallet_place_max) FROM c_industry_blocks b3 WHERE b3.offer_id = o.id )*12*30*b.price_safe_pallet_eu_max/(SELECT MIN(b3.area_floor_max) FROM c_industry_blocks b3 WHERE b3.offer_id = o.id ) >= $value ) ) ";
            }
        }
        //ЦЕНА АРЕНДЫ  ДО
        if($value = (int)$filters_arr->price_max) {
            if($filters_arr->price_format == 2){
                $filter_line .= " AND b.price_floor_min/12 <=$value ";
            }elseif($filters_arr->price_format == 3){
                $filter_line .= " AND b.price_floor_min*b.area_min/12 <=$value ";
            }elseif($filters_arr->price_format == 1){
                $filter_line .= " AND b.price_floor_min<=$value  ";
            }else{
                $filter_line .= " AND ( (b.price_floor_min<=$value AND o.deal_type!=3 ) OR ( o.deal_type=3 AND  (SELECT SUM(b3.pallet_place_max) FROM c_industry_blocks b3 WHERE b3.offer_id = o.id )*12*30*b.price_safe_pallet_eu_max/(SELECT SUM(b3.area_floor_max) FROM c_industry_blocks b3 WHERE b3.offer_id = o.id ) <= $value  )   ) ";
            }
        }


        //ЦЕНА ПРОДАЖИ ОТ
        if($value = (int)$filters_arr->price_sale_min) {
            if($filters_arr->price_format == 5){
                $filter_line .= " AND (b.price_sale_max*b.area_floor_max >=$value) ";
            }elseif($filters_arr->price_format == 6){
                $filter_line .= " AND (b.price_sale_max*100 >=$value";
            }elseif($filters_arr->price_format == 4){
                $filter_line .= " AND (b.price_sale_max>=$value )";
            }else{
                $filter_line .= " AND (b.price_sale_max>=$value)";
            }
        }
        //ЦЕНА ПРОДАЖИ ДО
        if($value = (int)$filters_arr->price_sale_max) {

            if($filters_arr->price_format == 5){
                $filter_line .= " AND b.price_sale_min*b.area_floor_min <=$value  ";
            }elseif($filters_arr->price_format == 6){
                $filter_line .= " AND  b.price_sale_min/100 <=$value  ";
            }elseif($filters_arr->price_format == 4){
                $filter_line .= " AND b.price_sale_min <=$value  ";
            }else{
                $filter_line .= " AND b.price_sale_min <=$value  ";
            }
        }


        //ЦЕНА ОТВЕТ ХРАНЕНИЯ ОТ
        if( $value = (int)$filters_arr->price_safe_min) {

            if($filters_arr->price_format == 7){
                $filter_line .= " AND (b.price_safe_pallet_eu_max >=$value) ";
            }elseif($filters_arr->price_format == 8){
                $filter_line .= " AND ( b.price_volume_max >=$value) ";
            }elseif($filters_arr->price_format == 9){
                $filter_line .= " AND ( b.price_safe_floor_max >=$value)";
            }else{
                $filter_line .= " AND ( b.price_safe_floor_max >=$value)";
            }
        }
        //ЦЕНА ОТВЕТ ХРАНЕНИЯ ДО
        if($value = (int)$filters_arr->price_safe_max) {

            if($filters_arr->price_format == 7){
                $filter_line .= " AND b.price_safe_pallet_eu <=$value  ";
            }elseif($filters_arr->price_format == 8){
                $filter_line .= " AND b.price_volume_min <=$value  ";
            }elseif($filters_arr->price_format == 9){
                $filter_line .= " AND b.price_safe_floor_min <=$value )";
            }else{
                $filter_line .= " AND b.price_safe_floor_min <=$value )";
            }
        }



        //ПЛОЩАДЬ ОТ
        if($value = (int)$filters_arr->area_floor_min){
            $filter_line .= " AND ((b.area_floor_max + b.area_mezzanine_max)>=$value OR (SELECT SUM(b3.area_floor_max + b3.area_mezzanine_max) FROM c_industry_blocks b3 WHERE b3.offer_id = o.id AND b3.status=1) >= $value)";
        }
        //ПЛОЩАДЬ ДО
        if($value = (int)$filters_arr->area_floor_max){
            $filter_line .= " AND b.area_floor_min<=$value ";
        }
        //ПАЛЛЕТ МЕСТ ОТ
        if($value = (int)$filters_arr->pallet_place_min){
            $filter_line .= " AND (b.pallet_place_max>=$value OR (SELECT SUM(b3.pallet_place_max) FROM c_industry_blocks b3 WHERE b3.offer_id = o.id AND b3.status=1) >= $value)";
        }
        //ПАЛЛЕТ МЕСТ ДО
        if($value = (int)$filters_arr->pallet_place_max){
            $filter_line .= " AND b.pallet_place_min<=$value  ";
        }
        //ПОТОЛКИ ОТ
        if($value = (int)$filters_arr->ceiling_height_min) {
            $filter_line .= " AND b.ceiling_height_max>=$value";
        }
        //ПОТОЛКИ ДО
        if($value = (int)$filters_arr->ceiling_height_max) {
            $filter_line .= " AND b.ceiling_height_min<=$value ";
        }
        //ОТАПЛИВАЕМЫЙ
        if($filters_arr->heated) {
            $value = implode(',',$filters_arr->heated);
            $filter_line .= " AND b.heated IN($value)";
        }
        //ТОЛЬКО ПЕРВЫЙ ЭТАЖ
        if($filters_arr->ground_floor) {
            $val = '%"1"%';
            $filter_line .= " AND b.floor LIKE '$val' "; //Расширенный вариант 

            //$filter_line .= " AND (SELECT COUNT(b4.floor) FROM c_industry_blocks b4 WHERE b4.offer_id = o.id AND b4.floor=1) > 0"; //  суженный вариант
        }
        //СТЕЛЛАЖИ
        if($filters_arr->racks) {
            $filter_line .= " AND b.racks='1'";
        }
        //КРАНЫ
        if($filters_arr->cranes) {
            //$filter_line .= " AND (b.telphers>0 OR b.cranes_cathead>0 OR b.cranes_overhead>0 OR b.cranes_runways>0 OR i.gantry_cranes>0 OR i.railway_cranes>0)";
            $filter_line .= " AND (
        b.telphers            LIKE '%1%' OR b.telphers LIKE '%2%' OR  b.telphers  LIKE '%3%' OR  b.telphers  LIKE '%4%' OR  b.telphers  LIKE '%5%' OR  b.telphers  LIKE '%6%' OR  b.telphers  LIKE '%7%' OR  b.telphers  LIKE '%8%' OR  b.telphers  LIKE '%9%' 
        OR b.cranes_cathead   LIKE '%1%' OR b.cranes_cathead LIKE '%2%' OR b.cranes_cathead LIKE '%3%' OR b.cranes_cathead LIKE '%5%' OR b.cranes_cathead LIKE '%5%' OR b.cranes_cathead LIKE '%6%'  OR b.cranes_cathead LIKE '%7%' OR b.cranes_cathead LIKE '%8%' OR b.cranes_cathead LIKE '%9%'
        OR b.cranes_overhead  LIKE '%1%' OR b.cranes_overhead  LIKE '%2%' OR b.cranes_overhead  LIKE '%3%' OR b.cranes_overhead  LIKE '%4%' OR b.cranes_overhead  LIKE '%5%' OR b.cranes_overhead  LIKE '%6%' OR b.cranes_overhead  LIKE '%7%' OR b.cranes_overhead  LIKE '%8%' OR b.cranes_overhead  LIKE '%9%'
        OR b.cranes_runways>0  
        OR i.cranes_gantry    LIKE '%1%' OR i.cranes_gantry LIKE '%2%' OR i.cranes_gantry LIKE '%3%' OR i.cranes_gantry LIKE '%4%' OR i.cranes_gantry LIKE '%5%' OR i.cranes_gantry LIKE '%6%' OR i.cranes_gantry LIKE '%7%' OR i.cranes_gantry LIKE '%8%' OR i.cranes_gantry LIKE '%9%'
        OR i.cranes_railway   LIKE '%1%' OR i.cranes_railway LIKE '%2%' OR i.cranes_railway LIKE '%3%' OR i.cranes_railway LIKE '%4%' OR i.cranes_railway LIKE '%5%' OR i.cranes_railway LIKE '%6%' OR i.cranes_railway LIKE '%7%' OR i.cranes_railway LIKE '%8%' OR i.cranes_railway LIKE '%9%'
        )";
        }
        //КАНАЛИЗАЦИЯ
        if($filters_arr->sewage) {
            $filter_line .= " AND i.sewage_central='1'";
        }
        //ВОДОСНАБЖЕНИЕ
        if($filters_arr->water) {
            $filter_line .= " AND i.water=1";
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



//}





