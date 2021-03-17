
<? include_once($_SERVER['DOCUMENT_ROOT'].'/global_pass.php');?>
<?php

$logedUser = new Member($_COOKIE['member_id']);

$objects = new Item();

?>
<?


$filters_arr = json_decode($_GET['request']);

$filter_line = '';
/*
 * ФИЛЬТРЫ К ОБЪЕКТУ
 */
$sort_direction = 'DESC';
$sort_param = 'c.last_update';


if($filters_arr->last_update[0]) {
    $sort_param = 'c.last_update';
    $sort_direction = 'ASC';
}

if($filters_arr->id[0]) {
    $sort_param = 'c.id';
    $sort_direction = 'ASC';
}

if($filters_arr->publ_time[0]) {
    $sort_param = 'c.publ_time';
    $sort_direction = 'ASC';
}


if($filters_arr->has_requests) {
    $filter_line .= " AND r.id>'0'";
}

//ПЛОЩАДЬ ОТ
if($filters_arr->area_floor_min) {
    $filter_line .= " AND r.area_floor_min>'".$filters_arr->area_floor_min."'";
}
//ПЛОЩАДЬ ДО
if($filters_arr->area_floor_max) {
    $filter_line .= " AND r.area_floor_max<'".$filters_arr->area_floor_max."'";
}

if($filters_arr->creation_date_min) {
    $time_min = strtotime($filters_arr->creation_date_min);
    $filter_line .= " AND c.publ_time>$time_min";
}


if($filters_arr->creation_date_max) {
    $time_max = strtotime($filters_arr->creation_date_max);
    $filter_line .= " AND c.publ_time<$time_max";
}


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
if($filters_arr->railway) {
    $filter_line .= " AND i.railway='1'";
}
//ЭЛЕКТРИЧЕСТВО
if($filters_arr->power_from) {
    $filter_line .= " AND i.power>'".$filters_arr->power_from."'";
}
//ОТ МКАД
if($filters_arr->from_mkad_from) {
    $filter_line .= " AND i.from_mkad>'".$filters_arr->from_mkad_from."'";
}
if($filters_arr->from_mkad_to) {
    $filter_line .= " AND i.from_mkad<'".$filters_arr->from_mkad_to."'";
}
//ПАР
if($filters_arr->steam) {
    $filter_line .= " AND i.vape='".$filters_arr->steam."'";
}
//ГАЗ
if($filters_arr->gas) {
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
if($filters_arr->deal_type) {
    $filter_line .= " AND o.deal_type='".$filters_arr->deal_type."'";
}
/*
 * ФИЛЬТРЫ К БЛОКУ
 */





//ЦЕНА ОТ
if($filters_arr->price_from) {
    $filter_line .= " AND b.rent_price>'".$filters_arr->price_from."'";
}
//ЦЕНА ДО
if($filters_arr->price_to) {
    $filter_line .= " AND b.rent_price<'".$filters_arr->price_to."'";
}
//ПОТОЛКИ ОТ
if($filters_arr->height_ceiling_from) {
    $filter_line .= " AND b.ceiling_height>'".$filters_arr->height_ceiling_from."'";
}
//ПОТОЛКИ ДО
if($filters_arr->height_ceiling_to) {
    $filter_line .= " AND b.ceiling_height2<'".$filters_arr->height_ceiling_to."'";
}
//ОТАПЛИВАЕМЫЙ
if($filters_arr->heated) {
    $filter_line .= " AND b.heated='".$filters_arr->heated."'";
}
//ТОЛЬКО ПЕРВЫЙ ЭТАЖ
if($filters_arr->ground_floor) {
    $filter_line .= " AND b.floor='1'";
}


/*
 * LINE SEARCH BLOCK
 */
if($filters_arr->search){
    $search_arr = explode(' ',trim($filters_arr->search));
    /*
     * Массив таблиц для подключения и поиска
     */
    $search_table_arr = array(
        'c'=>array('c_industry_companies','',''),
        'u'=>array('core_users','id','agent_id'),
        'k'=>array('c_industry_contacts','company_id','id')
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
            $join_line .= " LEFT JOIN ".$value[0]." $key ON $key.".$value[1]."=c.".$value[2]."  ";
        }
    }
    $search_fil = "AND ".$search_fil."";
}

/*
 * LINE SEARCH BLOCK
 */

$pageItems = 50;
if($filters_arr->page_num){
    $page_num = $filters_arr->page_num;
}else{
    $page_num = 1;
}

$unique_objects = [];
//ВИБИРАЕМ ВСЕ ДЛЯ ОБЬЕКТОВ
//$sql_objects = $pdo->prepare("SELECT (c.id) FROM  c_industry_companies c LEFT JOIN c_industry_requests r ON r.company_id=c.id  $join_line  WHERE c.deleted!='1' $search_fil $filter_line ORDER BY $sort_param $sort_direction  ");
$sql_objects = $pdo->prepare("SELECT (c.id) FROM  c_industry_companies c LEFT JOIN c_industry_requests r ON r.company_id=c.id  $join_line  WHERE c.deleted!='1' $search_fil $filter_line ORDER BY c.last_update DESC ");
$sql_objects->execute();
while($obj = $sql_objects->fetch(PDO::FETCH_LAZY)){
    if(!in_array($obj->id,$unique_objects)){
        array_push($unique_objects,$obj->id);
    }
}
$objectsAmount = count($unique_objects);
$pagesAmount = $objectsAmount/$pageItems;


?>
<div>
    <div class="hidden" id="preloader" style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: rgba(256,256,256, 0.9); z-index: 9;">
        <img style="width: 100px; margin-top: 100px;" src="https://loading.io/spinners/coolors/lg.palette-rotating-ring-loader.gif"/>
    </div>
    <div class="flex-box box">
        <div>
            <?=$objectsAmount?> вариантов
        </div>
        <?if($logedUser->isAdmin()){?>
            <div class="to-end">
                <div class="icon-round  modal-call-btn" data-id="" data-table="<?=(new CompanyGroup(0))->setTableId()?>" data-modal="edit-all"  data-modal-size="modal-middle"  >
                    <span title="Создать Группу Компаний"><i class="fas fa-users"></i></span>
                </div>
                <div class="icon-round  modal-call-btn" data-id="" data-table="<?=(new Company(0))->setTableId()?>" data-modal="edit-all"  data-modal-size="modal-middle"  >
                    <span title="Создать компанию"><i class="fas fa-plus"></i></span>
                </div>
            </div>
        <?}?>

    </div>
    <div class="main-table-block">
        <?include ($_SERVER['DOCUMENT_ROOT'].'/templates/pagination/index.php') ?>
        <div class="table-results-list">
            <div id="catalog-caption" class="objects-caption company-list-template">
                <div class="for-id obj-col-1">
                    <div class="sortel ">
                        ID
                        <input value="asc" name="id" data-sort="1" class="hidden" id="id" type="checkbox" />
                        <label for="id">
                            <i class="fas fa-exchange-alt rotate-90"></i>
                        </label>
                    </div>
                </div>
                <div class="obj-col-2">
                    <div class="sortel ">
                        Название компании
                    </div>
                </div>
                <div class="obj-col-3">
                    <nobr class="sortel ">
                        Статус компании
                    </nobr>
                    <!--
                    <div class="sortel ">
                        <a href="/industry/asc/highway/1/?scroll2list">
                            Шоссе
                        </a>
                    </div>
                    -->
                </div>
                <div class="obj-col-4">
                    <div>
                        Сайт
                    </div>
                </div>
                <div class="for-area obj-col-5">
                    Контакт
                </div>
                <div class="obj-col-6">
                    Задачи
                </div>
                <div class="obj-col-7">
                    <div class="for-area ">
                        <div class="sortt">
                            Брокер
                        </div>
                    </div>
                </div>
                <div class="obj-col-8">
                    <div class="sortel ">
                        Статус
                        <i class="fas fa-exchange-alt rotate-90"></i>
                    </div>
                </div>
                <div class="obj-col-9">
                    <div class="sortel ">
                        Обновление
                        <input value="asc" name="last_update" data-sort="1" class="hidden" id="last-upadate" type="checkbox" />
                        <label for="last-upadate">
                            <i class="fas fa-exchange-alt rotate-90"></i>
                        </label>
                    </div>
                </div>
                <div class="obj-col-10">
                    <div class="sortt">

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
                $company = $factory->createCompany($unique_objects[(int)$i]);
                include ($_SERVER['DOCUMENT_ROOT'].'/templates/companies/list/index.php');
            }?>
        </div>
    </div>
    <? include ($_SERVER['DOCUMENT_ROOT'].'/templates/pagination/index.php') ?>
</div>