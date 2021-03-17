<?

//получаем запрос
$filters_arr = json_decode($_GET['request']);

//строка фильтрации
$filter_line = '';

//если ищем в большом поле поиска
if($search_line = trim($filters_arr->search)){

    //начинаем поиск только если в строке более 3 символов
    if (iconv_strlen($search_line) < 6 && ctype_digit($search_line)) {

        $search_fil = 'AND o.object_id='.$search_line;

    } else {

        $search_arr = explode(' ',$search_line);

        $search_table_arr = array(
            //'i'=>array('c_industry','',''), //формат : таблица - поле прикрепляемой - поле основной
            //'o'=>array('c_industry_offers','',''),
            //'b'=>array('c_industry_blocks','',''),
            //'u'=>array('core_users','',''),
            'o'=>array('c_industry_offers_mix','',''),
            'c'=>array('c_industry_companies','id','company_id'),
            'k'=>array('c_industry_contacts','id','contact_id')
        );

        $search_fil_word = '';
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
        $search_fil = " AND ".$search_fil;
    }

    $filter_line .= $search_fil;

}



//ТИП СДЕЛКИ
if ($value = (int)$filters_arr->deal_type) {
    if($filters_arr->deal_type == 1){

        //добавляем фильтрацию по типу сделки
        $filter_line .= " AND (o.deal_type=$value OR o.deal_type=4 OR o.deal_type=3 OR o.deal_type IS NULL ) ";

        //ЦЕНА АРЕНДЫ ОТ
        if($value = (int)$filters_arr->price_min) {
            if($filters_arr->price_format == 2){

                $filter_line .= " AND ( o.price_floor_max/12 >=$value OR o.price_safe_calc_month_max >=$value) ";

            }elseif($filters_arr->price_format == 3){

                $filter_line .= " AND ( o.price_floor_max*o.area_max/12 >=$value)";

            }elseif($filters_arr->price_format == 1){

                $filter_line .= " AND ( o.price_floor_max>=$value OR o.price_safe_calc_max>=$value) ";

            }else{

                $filter_line .= " AND ( o.price_floor_max>=$value OR o.price_safe_calc_max>=$value) ";

            }
        }

        //ЦЕНА АРЕНДЫ  ДО
        if($value = (int)$filters_arr->price_max) {
            if($filters_arr->price_format == 2){

                $filter_line .= " AND (o.price_floor_min/12 <=$value OR  o.price_safe_calc_month_min <=$value  ) ";

            }elseif($filters_arr->price_format == 3){

                $filter_line .= " AND o.price_floor_min*o.area_min/12 <=$value ";

            }elseif($filters_arr->price_format == 1){

                $filter_line .= " AND ( o.price_floor_min<=$value OR  o.price_safe_calc_min<=$value )  ";

            }else{

                $filter_line .= " AND ( o.price_floor_min<=$value OR  o.price_safe_calc_min<=$value )  ";

            }
        }

    } elseif ($filters_arr->deal_type == 2) {

        //добавляем фильтрацию по типу техники
        $filter_line .= " AND (o.deal_type=$value  OR o.deal_type IS NULL )";

        //ЦЕНА ПРОДАЖИ ОТ
        if ($value = (int)$filters_arr->price_sale_min) {
            if ($filters_arr->price_format == 5) {

                $filter_line .= " AND (o.price_sale_max*o.area_max >=$value) ";

            } elseif ($filters_arr->price_format == 6) {

                $filter_line .= " AND (o.price_sale_max*100 >=$value";

            } elseif ($filters_arr->price_format == 4) {

                $filter_line .= " AND (o.price_sale_max>=$value )";

            } else {

                $filter_line .= " AND (o.price_sale_max>=$value)";

            }
        }
        //ЦЕНА ПРОДАЖИ ДО
        if ($value = (int)$filters_arr->price_sale_max) {

            if ($filters_arr->price_format == 5) {
                $filter_line .= " AND o.price_sale_min*o.area_min <=$value  ";
            } elseif ($filters_arr->price_format == 6) {
                $filter_line .= " AND  o.price_sale_min/100 <=$value  ";
            } elseif ($filters_arr->price_format == 4) {
                $filter_line .= " AND o.price_sale_min <=$value  ";
            } else {
                $filter_line .= " AND o.price_sale_min <=$value  ";
            }
        }

    } elseif ($filters_arr->deal_type == 3) {

        //добавляем фильтрацию по типу сделки
        $filter_line .= " AND (o.deal_type=3 ) ";

        //ПАЛЛЕТ МЕСТ ОТ
        if($value = (int)$filters_arr->pallet_place_min){

            $filter_line .= " AND (o.pallet_place_max>=$value )";

        }
        //ПАЛЛЕТ МЕСТ ДО
        if($value = (int)$filters_arr->pallet_place_max){

            $filter_line .= " AND o.pallet_place_min<=$value  ";

        }

        //ЦЕНА ОТВЕТ ХРАНЕНИЯ ОТ
        if( $value = (int)$filters_arr->price_safe_min) {

            if ($filters_arr->price_format == 7) {

                $filter_line .= " AND (o.price_safe_pallet_max >=$value) ";

            } elseif($filters_arr->price_format == 8) {

                $filter_line .= " AND ( o.price_volume_max >=$value) ";

            } elseif ($filters_arr->price_format == 9) {

                $filter_line .= " AND (o.price_safe_floor_max >=$value)";

            } else {

                $filter_line .= " AND ( o.price_safe_pallet_max >=$value)";
            }
        }
        //ЦЕНА ОТВЕТ ХРАНЕНИЯ ДО
        if ($value = (int)$filters_arr->price_safe_max) {

            if ($filters_arr->price_format == 7) {

                $filter_line .= " AND o.price_safe_pallet_min <=$value  ";

            }elseif($filters_arr->price_format == 8) {

                $filter_line .= " AND o.price_volume_min <=$value  ";

            } elseif ($filters_arr->price_format == 9) {

                $filter_line .= " AND o.price_safe_floor_min <=$value )";

            } else {

                $filter_line .= " AND o.price_safe_pallet_min <=$value )";

            }
        }


    } else {

    }
}


//СТАТУС

if ($value = (int)$filters_arr->status == 1) {

    $filter_line .= " AND o.type_id=2  AND area_min > 0" ;  

} elseif ($value = (int)$filters_arr->status == 2) {

    $filter_line .= " AND o.type_id=3";

} else {

}



//РЕГИОН
if($value = (int)$filters_arr->region) {

    //фильтрация по регионам
    if($value == 100){
        $filter_line .= " AND (o.region=1 OR o.region=6)  ";
    }elseif($value == 200){
        $filter_line .= " AND (o.region=6 AND o.outside_mkad=0)";
    }elseif($value == 300){
        $filter_line .= " AND (o.region=1 OR (o.outside_mkad=1 AND o.region=6))";
    }elseif($value == 400){
        $filter_line .= " AND (o.region=1 OR o.near_mo=1) ";
    }elseif($value == 1000){
        $filter_line .= " ";
    }else{
        $filter_line .= " AND (o.region=$value)";
    }

    //РАЙОН МОСКВЫ
    //НАПРАВЛЕНИЕ

    if($filters_arr->districts_moscow && $filters_arr->directions) {
        $districts_line = implode(',',$filters_arr->districts_moscow);
        $directions_line = implode(',',$filters_arr->directions);

        $filter_line .= " AND ( o.district_moscow IN($districts_line)  OR o.direction IN($directions_line)  )";
    }else{
        if($filters_arr->directions) {
            $directions_line = implode(',',$filters_arr->directions);
            $filter_line .= " AND (o.direction IN($directions_line) )";
        }
        if($filters_arr->districts_moscow) {
            $districts_line = implode(',',$filters_arr->districts_moscow);
            $filter_line .= " AND (o.district_moscow IN($districts_line) )";
        }
    }
    //НАСЕЛЕННЫЙ ПУНКТ
    if($filters_arr->towns) {
        $towns_line = implode(',',$filters_arr->towns);
        $filter_line .= " AND o.town IN($towns_line)";
    }
    //ШОССЕ
    if($filters_arr->highways) {
        $highways_line = implode(',',$filters_arr->highways);
        $filter_line .= " AND o.highway IN($highways_line)";
    }

    if($filters_arr->highways_moscow) {
        $highways_line = implode(',',$filters_arr->highways_moscow);
        $filter_line .= " AND o.highway_moscow IN($highways_line)";
    }
    //МЕТРО
    if($filters_arr->metros) {
        $metros_line = implode(',',$filters_arr->metros);
        $filter_line .= " AND o.metro IN($metros_line)";
    }

    //РАЙОН
    if($filters_arr->districts) {
        $districts_line = implode(',',$filters_arr->districts);
        $filter_line .= " AND o.district IN($districts_line)";
    }


}


//ТИП ОБЪЕКТА
if($type = (int)$filters_arr->object_type) {

    //фильтрация по типу объекта
    if ($type == 1) {
        $filter_line .= " AND  (o.object_type LIKE '%1%' OR o.object_type LIKE '%2%') ";


        //ТОЛЬКО ПЕРВЫЙ ЭТАЖ
        if($filters_arr->ground_floor) {
            $filter_line .= " AND (o.floor_min=1 OR o.floor_max=1)"; //Расширенный вариант
        }

        //ПОТОЛКИ ОТ
        if($value = (int)$filters_arr->ceiling_height_min) {
            $filter_line .= " AND o.ceiling_height_max>=$value";
        }
        //ПОТОЛКИ ДО
        if($value = (int)$filters_arr->ceiling_height_max) {
            $filter_line .= " AND o.ceiling_height_min<=$value ";
        }

        //КЛАСС
        if($filters_arr->object_class) {
            $class_line = implode(',',$filters_arr->object_class);
            $filter_line .= " AND o.class IN($class_line)";
        }

        //ОТАПЛИВАЕМЫЙ
        if($filters_arr->heated) {
            $value = implode(',',$filters_arr->heated);
            $filter_line .= " AND o.heated IN($value)";
        }


    } else {
        $filter_line .= " AND o.object_type LIKE '%3%'";
    }

    //НАЗНАЧЕНИЕ ОБЪЕКТА
    if($filters_arr->purposes) {
        foreach($filters_arr->purposes as $purpose){
            $purp_obj = new Purpose($purpose);
            if($purp_obj->getField('type') == $type){
                $purpose_line .= " o.purposes LIKE '".'%"'.(int)$purpose.'"%'."'".'OR';
            }
        }
        if($purpose_line){
            $filter_line .= " AND (".trim($purpose_line,'OR').")";
        }
    }

}


//только если есть выбранные тип сделки и тип объекта  - тогда показываются доп фильтры и считаются их значения
if($filters_arr->deal_type && ($filters_arr->object_type || $filters_arr->safe_type)) {


    //ПЛОЩАДЬ ОТ
    if($value = (int)$filters_arr->area_floor_min ){
        $filter_line .= " AND (o.area_max)>=$value ";
    }
    //ПЛОЩАДЬ ДО
    if($value = (int)$filters_arr->area_floor_max ){
        $filter_line .= " AND o.area_min<=$value ";
    }

    //для земли
    //ПЛОЩАДЬ ОТ
    if($value = (int)$filters_arr->area_field_min ){
        $filter_line .= " AND ( o.area_max>=$value OR area_field_max>=$value ) ";
    }

    //ПЛОЩАДЬ ДО
    if($value = (int)$filters_arr->area_field_max ){
        $filter_line .= " AND (o.area_min<=$value OR area_field_min<=$value ) ";
    }



    //СТЕЛЛАЖИ
    if($filters_arr->racks) {
        $filter_line .= " AND o.racks=1 ";
    }


    //ЖД ветка
    if ($filters_arr->railway) {
        $filter_line .= " AND o.railway=1";
    }
    //ЭЛЕКТРИЧЕСТВО
    if ($value = (int)$filters_arr->power) {
        $filter_line .= " AND o.power_value>=$value";
    }
    //ОТ МКАД
    if ($value = (int)$filters_arr->from_mkad) {
        $filter_line .= " AND (o.from_mkad<=$value OR o.from_mkad IS NULL OR o.from_mkad=0 )";
    }

    //ПАР
    if ($filters_arr->steam) {
        $value = (int)$filters_arr->steam;
        $filter_line .= " AND o.steam=$value";
    }
    //ГАЗ
    if ($filters_arr->gas) {
        $value = (int)$filters_arr->gas;
        $filter_line .= " AND o.gas=$value";
    }

    //КАНАЛИЗАЦИЯ
    if ($filters_arr->sewage) {
        $filter_line .= " AND o.sewage_central=1";
    }


    //ВОДОСНАБЖЕНИЕ
    if ($filters_arr->water) {
        $filter_line .= " AND o.water != '0'  ";
    }

    //ТИП ВОРОТ
    if ($filters_arr->gate_type) {
        //$filter_line .= " AND b.gates LIKE" . "'%". '"'. $filters_arr->gate_type .'"' ."%'" . " " ;
        //$filter_line .= " AND b.gates LIKE '%1%' " ;
        foreach($filters_arr->gate_type as $gate){
            $gates_line .= " o.gates LIKE '".'%"'.(int)$gate.'"%'."'".'OR';
        }
        $filter_line .= " AND (".trim($gates_line,'OR').")";
    }

    //ТИП ПОЛА
    if ($filters_arr->floor_type) {
        //$value = implode(',',$filters_arr->floor_type);
        //$filter_line .= " AND o.floor_types IN($value)";
        foreach($filters_arr->floor_type as $floor_type){
            $floor_types_line .= " o.floor_types LIKE '".'%"'.(int)$floor_type.'"%'."'".'OR';
        }
        $filter_line .= " AND (".trim($floor_types_line,'OR').")";
    }


    //КРАНЫ
    if($filters_arr->cranes) {
        $filter_line .= " AND (o.has_cranes=1 )";
    }


}


if($value = (int)$filters_arr->no_safe){   
    $filter_line .= " AND o.deal_type!=3";
}

if($value = (int)$filters_arr->ad_realtor){
    $filter_line .= " AND o.ad_realtor=1";
}



//СОРТИРОВКА
if($filters_arr->sort){

    $sort_fields = [
        'mkad'=>'o.from_mkad',
        'area'=>'o.area_floor_min, o.area_min, o.pallet_place_min',
        'price'=>'o.price_floor_min, o.price_sale_min,o.price_safe_pallet_eu_min',
        'id'=>'o.object_id',
        'update'=>'o.last_update',
        'region'=>'o.region',
        'direction'=>'o.direction, o.highway, o.highway_moscow',
    ];
    $sort_dir = [
        '1'=>'ASC',
        '2'=>'DESC',
    ];

    $value = explode('-',$filters_arr->sort);

    $sort_part = "ORDER BY ".$sort_fields[$value[0]].' '.$sort_dir[$value[1]];
}else{
    $sort_part = "ORDER BY o.last_update DESC";
}


