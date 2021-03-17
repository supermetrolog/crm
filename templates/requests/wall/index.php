<? include_once($_SERVER['DOCUMENT_ROOT'].'/global_pass.php');?>
<?php
$objects = new Item(0);
?>
<?

$filters_arr = json_decode($_GET['request']);

$filter_line = '';
/*
 * ФИЛЬТРЫ К ОБЪЕКТУ
 */

//КЛАСС
if($filters_arr->object_class) {
    $class_line = implode(',',$filters_arr->object_class);
    $filter_line .= " AND i.object_class IN($class_line)";
}
//НАЗНАЧЕНИЕ ОБЪЕКТА
if($filters_arr->purposes) {
    foreach($filters_arr->purposes as $purpose){
        $purpose_line .= "i.purposes LIKE '%".$purpose."%' OR ";
    }
    $filter_line .= " AND (".trim(trim($purpose_line),'OR').")";
}

//ЖД ветка
if($value = $filters_arr->railway) {
    $filter_line .= " AND i.railway='1'";
}
//ЭЛЕКТРИЧЕСТВО
if($value =$filters_arr->power_from) {
    $filter_line .= " AND i.power>'".$filters_arr->power_from."'";
}
//ОТ МКАД
if($filters_arr->from_mkad_from) {
    $filter_line .= " AND i.from_mkad>'".$filters_arr->from_mkad_from."'";
}
if($value = $filters_arr->from_mkad_max) {
    $filter_line .= " AND i.from_mkad<'".$filters_arr->from_mkad_to."'";
}
//ПАР
if($value =$filters_arr->steam) {
    $filter_line .= " AND i.vape='".$filters_arr->steam."'";
}
//ГАЗ
if($value =$filters_arr->gas) {
    $filter_line .= " AND i.gas='".$filters_arr->gas."'";
}



//НАПРАВЛЕНИЕ
if($filters_arr->directions) {
    $directions_line = implode(',',$filters_arr->directions);
    $filter_line .= " AND i.direction IN($directions_line)";
}
//НАСЕЛЕННЫЙ ПУНКТ
if($filters_arr->villages) {
    $villages_line = implode(',',$filters_arr->villages);
    $filter_line .= " AND i.village IN($villages_line)";
}
//ШОССЕ
if($filters_arr->highways) {
    $highways_line = implode(',',$filters_arr->highways);
    $filter_line .= " AND i.highway IN($highways_line)";
}
//МЕТРО
if($filters_arr->metros) {
    $metros_line = implode(',',$filters_arr->metros);
    $filter_line .= " AND i.metro IN($metros_line)";
}
//РЕГИОН
if($filters_arr->region) {
    foreach($filters_arr->region as $region){
        $region_line .= "i.region LIKE '%".$region."%' OR ";
    }
    $filter_line .= " AND (".trim(trim($region_line),'OR').")";
}
//ТИП ОБЪЕКТА
if($filters_arr->object_type) {
    foreach($filters_arr->object_type as $object_type){
        $object_type_line .= "i.object_type LIKE '%".$object_type."%' OR ";
    }
    $filter_line .= " AND (".trim(trim($object_type_line),'OR').")";
}


//РАЙОН МОСКВЫ
if($filters_arr->districts_moscow) {
    $districts_line = implode(',',$filters_arr->districts_moscow);
    $filter_line .= " AND i.district IN($districts_line)";
}
//РАЙОН
if($filters_arr->districts) {
    $districts_line = implode(',',$filters_arr->districts);
    $filter_line .= " AND i.district IN($districts_line)";
}



/*
 * ФИЛЬТРЫ К ПРЕДЛОЖЕНИЮ
 */
//ТИП СДЕЛКИ
if($value = $filters_arr->deal_type) {
    $filter_line .= " AND r.deal_type=$value";
}
//СТАТУС
if($value =  $filters_arr->status) {
    $filter_line .= " AND r.status=$value";
}
/*
 * ФИЛЬТРЫ К БЛОКУ
 */

//ПЛОЩАДЬ ОТ
if($filters_arr->area_from) {
    $filter_line .= " AND r.area_min>'".$filters_arr->area_from."'";
}
//ПЛОЩАДЬ ДО
if($filters_arr->area_to) {
    $filter_line .= " AND r.area_max<'".$filters_arr->area_to."'";
}
//ЦЕНА ОТ
if($filters_arr->price_from) {
    $filter_line .= " AND r.price_min>'".$filters_arr->price_from."'";
}
//ЦЕНА ДО
if($filters_arr->price_to) {
    $filter_line .= " AND r.price_max<'".$filters_arr->price_to."'";
}
//ПОТОЛКИ ОТ
if($filters_arr->height_ceiling_from) {
    $filter_line .= " AND r.ceiling_height_min>'".$filters_arr->height_ceiling_from."'";
}
//ПОТОЛКИ ДО
if($filters_arr->height_ceiling_to) {
    $filter_line .= " AND r.ceiling_height_max<'".$filters_arr->height_ceiling_to."'";
}
//ОТАПЛИВАЕМЫЙ
if($filters_arr->heated) {
    $filter_line .= " AND r.heated='".$filters_arr->heated."'";
}
//ТОЛЬКО ПЕРВЫЙ ЭТАЖ
if($filters_arr->ground_floor) {
    $filter_line .= " AND b.floor='1'";
}
//СТЕЛЛАЖИ
if($filters_arr->racks) {
    $filter_line .= " AND r.pallet_place_min>'0'";
}
//КРАНЫ
if($filters_arr->cranes) {
    $filter_line .= " AND (b.telphers>'0' OR b.telphers>'0' OR b.catheads>'0' OR b.overhead_cranes>'0' OR i.gantry_cranes>'0' OR i.railway_cranes>'0')";
}
//ТИП ВОРОТ
if($filters_arr->gate_type) {
    $filter_line .= " AND b.gate_type='".$filters_arr->gate_type."'";
}
//ТИП ПОЛА
if($filters_arr->floor_type) {
    /*
    foreach($_POST['floor_type'] as $floor_type_item){
        $floor_type_line .= "b.floor_type='$floor_type_item' OR ";
    }
    $filter_line .= " AND (".trim(trim($floor_type_line),'OR').")";
    */
    $filter_line .= " AND b.floor_type='".$filters_arr->floor_type."'";
}

/*
 * LINE SEARCH BLOCK
 */
if($filters_arr->search){
    $search_line = trim($filters_arr->search);
    //начинаем поиск только если в строке более 4 символов и только цифры
    if(iconv_strlen($search_line) < 5 && ctype_digit($search_line)) {
        $search_fil = "AND r.id='".$search_line."'";
    }else{
        $search_arr = explode(' ',$search_line);
        /*
         * Массив таблиц для подключения и поиска
         */
        $search_table_arr = array(
            'r'=>array('c_industry_requests','',''),
            'u'=>array('core_users','id','agent_id'),
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
                $join_line .= " LEFT JOIN ".$value[0]." $key ON $key.".$value[1]."=r.".$value[2]."  ";
            }
        }
        $search_fil = "AND ".$search_fil."";
    }

}

//echo "SELECT * FROM  c_industry_requests r LEFT JOIN c_industry_companies c ON r.company_id=c.id LEFT JOIN users u ON r.agent=u.id WHERE r.deleted!='1'  $search_fil $filter_line ORDER BY r.dt_update DESC ";
/*
 * LINE SEARCH BLOCK
 */

$pageItems = 12;
if($filters_arr->page_num){
    $page_num = $filters_arr->page_num;
}else{
    $page_num =1;
}


$unique_objects = [];
//ВИБИРАЕМ ВСЕ ДЛЯ ОБЬЕКТОВ
$sql_objects = $pdo->prepare("SELECT (r.id) FROM  c_industry_requests r $join_line WHERE r.deleted!='1'  $search_fil $filter_line ORDER BY r.last_update DESC ");
$sql_objects->execute();
while($obj = $sql_objects->fetch(PDO::FETCH_LAZY)){
    if(!in_array($obj->id,$unique_objects)){
        array_push($unique_objects,$obj->id);
    }
}
$objectsAmount = count($unique_objects);
$pagesAmount = $objectsAmount/$pageItems;
?>
<br><br>
<div>
    <div class="hidden" id="preloader" style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: rgba(256,256,256, 0.9); z-index: 9;">
        <img style="width: 100px; margin-top: 100px;" src="https://loading.io/spinners/coolors/lg.palette-rotating-ring-loader.gif"/>
    </div>
    <div class="flex-box flex-center">
        <div>
            <?=$objectsAmount?> запросов
        </div>
    </div>
    <div class="main-table-block">
        <?include ($_SERVER['DOCUMENT_ROOT'].'/templates/pagination/index.php') ?>
        <div class="table-results-list">
            <div class="objects-caption object-list-template">
                <div class="for-id obj-col-1">
                    <div class="sortel ">
                        <a href="/industry/asc/id/1/?scroll2list">
                            ID
                            <i class="fas fa-exchange-alt rotate-90"></i>
                        </a>
                    </div>
                </div>
                <div class="obj-col-2">
                    <div class="sortel ">
                        <a href="/industry/asc/yandex_address_str/1/?scroll2list">
                            Вид сделки
                        </a>
                    </div>
                </div>
                <div class="obj-col-3">
                    <div class="sortel ">
                        <a href="/industry/asc/region/1/?scroll2list">
                            Площадь
                            <i class="fas fa-exchange-alt rotate-90"></i>
                        </a>
                    </div>
                </div>
                <div class="obj-col-4">
                    <a href="/industry/asc/region/1/?scroll2list">
                        Цена
                        <i class="fas fa-exchange-alt rotate-90"></i>
                    </a>
                </div>
                <div class="obj-col-5">
                    <div class="sortel sortel-line2 ">
                        <a href="/industry/asc/otmkad/1/?scroll2list">
                            Параметры поиска
                            <i class="fas fa-exchange-alt rotate-90"></i>
                        </a>
                    </div>
                </div>
                <div class="for-area obj-col-6">
                    <div class="sortt">
                        Компания и контакт
                        <i class="fas fa-exchange-alt rotate-90"></i>
                    </div>
                </div>
                <div class="obj-col-7">
                    <div class="sortel ">
                        <a href="/industry/asc/agent/1/?scroll2list">
                            Брокер
                            <i class="fas fa-exchange-alt rotate-90"></i>
                        </a>
                    </div>
                </div>
                <div class="obj-col-8">
                    <div class="sortel ">
                        <a href="/industry/asc/result/1/?scroll2list">
                            Статус
                            <i class="fas fa-exchange-alt rotate-90"></i>
                        </a>
                    </div>
                </div>
                <div class="obj-col-9">
                    <div class="sortt">
                        Обновление
                        <i class="fas fa-long-arrow-alt-down"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="">
            <?
            $factory = new Factory();
            $start = ($page_num - 1)*$pageItems;
            $finish = ($page_num - 1)*$pageItems + $pageItems;
            for($i = $start; $i < $finish; $i++){
                $request = $factory->createRequest($unique_objects[(int)$i]);
                include ($_SERVER['DOCUMENT_ROOT'].'/templates/requests/list/index.php');
            }?>
        </div>
    </div>
</div>