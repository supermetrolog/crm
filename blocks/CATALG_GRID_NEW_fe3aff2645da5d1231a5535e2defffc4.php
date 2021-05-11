<?php
/*
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
ini_set('error_reporting', E_ALL);
*/
?>


<? include_once($_SERVER['DOCUMENT_ROOT'].'/system/classes/autoload.php');?>
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
if($filters_arr->building_class) {
    $class_line = implode(',',$filters_arr->building_class);
    $filter_line .= " AND i.building_class IN($class_line)";
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
if($filters_arr->power) {
    $filter_line .= " AND i.power>'".$filters_arr->power."'";
}
//ОТ МКАД
if($filters_arr->from_mkad_min) {
    $filter_line .= " AND i.from_mkad>'".$filters_arr->from_mkad_min."'";
}
if($filters_arr->from_mkad_max) {
    $filter_line .= " AND i.from_mkad<'".$filters_arr->from_mkad_max."'";
}
//ПАР
if($filters_arr->steam) {
    $filter_line .= " AND i.steam='".$filters_arr->steam."'";
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
//СТАТУС
if($filters_arr->status) {
    $filter_line .= " AND o.offer_status='".$filters_arr->status."'";
}
/*
 * ФИЛЬТРЫ К БЛОКУ
 */

//ПЛОЩАДЬ ОТ
if($filters_arr->area_min) {
    $filter_line .= " AND b.area_min>'".$filters_arr->area_min."'";
}
//ПЛОЩАДЬ ДО
if($filters_arr->area_max) {
    $filter_line .= " AND b.area_max<'".$filters_arr->area_max."'";
}
//ЦЕНА ОТ
if($filters_arr->price_min) {
    $filter_line .= " AND b.price>'".$filters_arr->price_min."'";
}
//ЦЕНА ДО
if($filters_arr->price_max) {
    $filter_line .= " AND b.rent_price<'".$filters_arr->price_max."'";
}
//ПОТОЛКИ ОТ
if($filters_arr->ceiling_height_min) {
    $filter_line .= " AND b.ceiling_height_min>'".$filters_arr->ceiling_height_min."'";
}
//ПОТОЛКИ ДО
if($filters_arr->ceiling_height_max) {
    $filter_line .= " AND b.ceiling_height_max<'".$filters_arr->ceiling_height_max."'";
}
//ОТАПЛИВАЕМЫЙ
if($filters_arr->heated) {
    $filter_line .= " AND b.heated='".$filters_arr->heated."'";
}
//ТОЛЬКО ПЕРВЫЙ ЭТАЖ
if($filters_arr->ground_floor) {
    $filter_line .= " AND b.floor='1'";
}
//СТЕЛЛАЖИ
if($filters_arr->racks) {
    $filter_line .= " AND b.has_racks='1'";
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
    $search_arr = explode(' ',trim($filters_arr->search));
    /*
     * Массив таблиц для подключения и поиска
     */
    $search_table_arr = array(
        'i'=>array('c_industry','',''), //формат : таблица - поле прикрепляемой - поле основной
        //'o'=>array('c_industry','',''),
        //'b'=>array('c_industry_blocks','',''),
        //'u'=>array('users','id','agent_id'),
        //'c'=>array('c_industry_companies','id','company_id'),
        //'k'=>array('c_industry_customers','id','contact_id')
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
            $join_line .= " LEFT JOIN ".$value[0]." $key ON $key.".$value[1]."=o.".$value[2]."  ";
        }
    }
    $search_fil = "AND ".$search_fil."";
}

/*
 * LINE SEARCH BLOCK
 */
//echo "SELECT * FROM  c_industry i LEFT JOIN c_industry_offers o  ON o.object_id=i.id LEFT JOIN c_industry_blocks b ON b.offer_id=o.id  $join_line  WHERE o.deleted!='1' $search_fil $filter_line   AND i.deleted!='1' AND b.deleted!='1' ORDER BY b.dt_update DESC ";
//echo "SELECT * FROM  c_industry_offers o   LEFT JOIN c_industry i ON i.id=o.object_id LEFT JOIN c_industry_blocks b ON b.offer_id=o.id  $join_line  WHERE o.deleted!='1' $search_fil $filter_line   AND i.deleted!='1' AND b.deleted!='1' ORDER BY b.dt_update DESC ";

$pageItems = 12;
if($filters_arr->page_num){
    $page_num = $filters_arr->page_num;
}else{
    $page_num =1;
}
$from_num = ($page_num - 1)*$pageItems;

//ВИБИРАЕМ ВСЕ ДЛЯ ОБЬЕКТО
$sql_text = "SELECT * FROM  c_industry_offers o LEFT JOIN c_industry i  ON o.object_id=i.id LEFT JOIN c_industry_blocks b ON b.offer_id=o.id  $join_line    WHERE o.deleted!='1' $search_fil $filter_line   AND i.deleted!='1' AND b.deleted!='1' ORDER BY b.dt_update DESC ";
//$sql_text = "SELECT * FROM  c_industry i LEFT JOIN c_industry_offers o  ON o.object_id=i.id LEFT JOIN c_industry_blocks b ON b.offer_id=o.id  $join_line    WHERE o.deleted!='1' $search_fil $filter_line   AND i.deleted!='1' AND b.deleted!='1' ORDER BY b.dt_update DESC ";
echo $sql_text.'<br>';
$obj_sql = $pdo->prepare($sql_text);
$obj_sql->execute();
$obj_count = $obj_sql->rowCount();



$pagesAmount = $obj_count/$pageItems;
?>
<div id="main-area">
    <div class="hidden" id="preloader" style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: rgba(256,256,256, 0.9); z-index: 9;">
        <img style="width: 100px; margin-top: 100px;" src="https://loading.io/spinners/coolors/lg.palette-rotating-ring-loader.gif"/>
    </div>
    <div class="map-block">
        <div id="map_google" style="height: 100px; width: 100%; border-bottom: 1px solid #d0d0d0;">

        </div>
        <div class="flex-box flex-center">
            <div class="isBold box-small pointer map-more" style=" width: 180px;  border-top: 1px solid #FFFFFF; border-left: 1px solid #d0d0d0; border-right: 1px solid #d0d0d0; border-bottom: 1px solid #d0d0d0;">
                Показать на карте <span><i class="fas fa-caret-down"></i></span>
            </div>
        </div>
    </div>
    <div class="flex-box flex-center">
        <div>
            <?=$obj_sql->rowCount()?> предложений
        </div>
        <div class="icon-round to-end modal-call-btn" data-id="" data-table="c_industry"  data-form-size="modal-very-big"  >
            <span title="Редактировать"><a href="javascript: 0"><i class="fas fa-pencil-alt"></i></a> </span>
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
                            Адрес, фото ,назанчение
                        </a>
                    </div>
                </div>
                <div class="obj-col-3">
                    <div class="sortel ">
                        <a href="/industry/asc/region/1/?scroll2list">
                            Регион
                            <i class="fas fa-exchange-alt rotate-90"></i>
                        </a>
                    </div>
                </div>
                <div class="obj-col-4">
                    <nobr class="sortel ">
                        <a href="/industry/asc/region/1/?scroll2list">
                            Направление
                            <i class="fas fa-exchange-alt rotate-90"></i>
                        </a>
                    </nobr>
                    <!--
                    <div class="sortel ">
                        <a href="/industry/asc/highway/1/?scroll2list">
                            Шоссе
                        </a>
                    </div>
                    -->
                </div>
                <div class="obj-col-5">
                    <div class="sortel sortel-line2 ">
                        <a href="/industry/asc/otmkad/1/?scroll2list">
                            МКАД
                            <i class="fas fa-exchange-alt rotate-90"></i>
                        </a>
                    </div>
                </div>
                <div class="for-area obj-col-6">
                    <div class="sortt">
                        Площадь
                        <i class="fas fa-exchange-alt rotate-90"></i>
                    </div>
                </div>
                <div class="for-price obj-col-7">
                    <div class="sortt">
                        Цена
                        <i class="fas fa-exchange-alt rotate-90"></i>
                    </div>
                </div>
                <div class="obj-col-8">
                    <div class="for-area ">
                        <div class="sortt">
                            Контакт
                        </div>
                    </div>
                </div>
                <div class="obj-col-9">
                    <div class="sortel ">
                        <a href="/industry/asc/agent/1/?scroll2list">
                            Брокер
                            <i class="fas fa-exchange-alt rotate-90"></i>
                        </a>
                    </div>
                </div>
                <div class="obj-col-10">
                    <div class="sortel ">
                        <a href="/industry/asc/result/1/?scroll2list">
                            Статус
                            <i class="fas fa-exchange-alt rotate-90"></i>
                        </a>
                    </div>
                </div>
                <div class="obj-col-11">
                    <div class="sortt">
                        Обновление
                        <i class="fas fa-long-arrow-alt-down"></i>
                    </div>
                    <!--
                    <nobr class="sortel ">
                        <a href="/industry/asc/rent_price/1/?scroll2list">
                            <span class="b">реклама</span>
                        </a>
                    </nobr>
                    -->
                </div>
            </div>
            </div>
            <div class="">
                <?
                $sql = $pdo->prepare("$sql_text LIMIT $from_num, $pageItems");
                $sql->execute();
                while($item = $sql->fetch(PDO::FETCH_LAZY)){
                    $offer = new Offer($item->id);
                    $object = new Item($offer->showField('object_id')); ?>
                    <?if($offer->offerId() != $last_id){?>
                        <?  include ($_SERVER['DOCUMENT_ROOT'].'/templates/offers/list/index.php') ?>
                    <?}?>
                    <?$last_id = $offer->offerId()?>
                <?}?>
            </div>
    </div>
        <?//include ($_SERVER['DOCUMENT_ROOT'].'/system/templates/pagination/index.php') ?>
        <? include_once($_SERVER["DOCUMENT_ROOT"].'/templates/modals/empty-edit/index.php')?>
<script>

    function initMap() {
        console.log('fdfdfd');
        var home = {lat: 55.7182753, lng: 37.6775274};
        //создаем карту
        var map = new google.maps.Map(document.getElementById('map_google'), {
            zoom: 16,
            center: home,
            disableDefaultUI: true
        });
        //содаем маркер
        var marker = new google.maps.Marker({
            position: home,
            map: map
        });
        //создаем всплывающее окно с текстом
        var contentString = "<div style='text-align: center; ' id='content'>г.Москва, Шарикоподшипниковская ул., дом 13, стр.3, офис 16 (ст.метро 'Дубровка')</div>";
        var infowindow_users = new google.maps.InfoWindow({
            content: contentString
        });
        //цепляем окно на маркер
        google.maps.event.addListener(marker, 'click', function() {
            infowindow_users.open(map,marker);
        });





        var map = new google.maps.Map(document.getElementById('map_filter'), {
            center: {lat: 55.7182753, lng: 37.6775274},
            zoom: 8,
            disableDefaultUI: true
        });

        var drawingManager = new google.maps.drawing.DrawingManager({
            drawingMode: google.maps.drawing.OverlayType.MARKER,
            drawingControl: true,
            drawingControlOptions: {
                position: google.maps.ControlPosition.TOP_CENTER,
                drawingModes: ['circle', 'polygon', 'polyline']
            },
            markerOptions: {icon: 'https://developers.google.com/maps/documentation/javascript/examples/full/images/beachflag.png'},
            circleOptions: {
                fillColor: '#ffff00',
                fillOpacity: 1,
                strokeWeight: 5,
                clickable: false,
                editable: true,
                zIndex: 1
            }
        });
        drawingManager.setMap(map);
    }

    initMap();

</script>
<script type="text/javascript">
    $(document).ready(function() {

        /*
        document.querySelector(".blocks-dropdown-button").onclick =  function(){
            alert('fdfdf'+divis.id);
            alert(document.querySelector(".block_"+divis.id));
            document.querySelector(".block_"+divis.id).style.display = 'block';
        }
        */

        $('body').on('click', '.empty-modal-call', function() {
            alert($(this).attr('id'));
        });



        $('body').on('click', '.blocks-dropdown-button', function(){
            $('.blocks_'+$(this).attr('id')).slideToggle();
            if($(this).find('a').html() == '<i class="fas fa-angle-up"></i>'){
                $(this).find('a').html('<i class="fas fa-bars"></i>');
            }else{
                $(this).find('a').html('<i class="fas fa-angle-up"></i>');
            }
        });
    });
</script>
<script>
    /**
     * ДОБАВЛЕНИЕ В ИЗБРАННОЕ
     */
    let fav_items = document.getElementsByClassName("icon-star");
    for (let i = 0; i < fav_items.length; i++) {
        fav_items[i].addEventListener("click", function () {
            let element_id = this.getAttribute('data-object-id');
            alert(element_id);
            let xhttp = new XMLHttpRequest();
            xhttp.open('GET',"<?=PROJECT_URL?>/system/modules/favourites/add.php?object_id="+element_id,false);
            xhttp.send();
            if (xhttp.readyState === 4 && xhttp.status === 200){
                alert(xhttp.responseText);
            }
        }, false);
    }
</script>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCwbktBM3GY5GfsT0VfA1MGEobYqkvrSkc&libraries=drawing&callback=initMap" async defer>  </script>
</div>