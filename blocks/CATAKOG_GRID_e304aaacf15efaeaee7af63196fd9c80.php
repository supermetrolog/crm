<?php
$actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$furl = parse_url($actual_link);
$page_num = explode('/',$furl['path'])[2];
if($page_num >0 ){
    $page_num = explode('/',$furl['path'])[2];;
}else{
    $page_num =1;
}
$objects = new Item(0);
$pageItems = 12;


?>
<div class="main-area">
    <div class="search-block box">
        <div class="search-line-block">
            <form action="/objects/" method="get">
                <div class="search-line flex-box">
                    <input type="text" value="<?=$_GET['search']?>" name="search" placeholder="ID, адрес, собственник, телефон, фио, брокер, название" />
                    <button><i class="fas fa-search"></i></button>
                </div>
            </form>
        </div>
    </div>
    <div class="filters-container">
        <form class="filters-block box" method="post">
            <div class="search-categories box">
                <?
                $dealTypes = new Post(0);
                $dealTypes->getTable('c_deal_types');
                foreach($dealTypes->getAllUnits() as $dealType){?>
                    <div>
                        <label class="radio-container">
                            <input type="radio" <?=($dealType['id'] == $_POST['deal_type']) ? 'checked' : '' ;?> value="<?=$dealType['id']?>" name="deal_type"/>
                            <span class="checkmark"><?=$dealType['title']?></span>
                        </label>
                    </div>
                <?}?>
            </div>
            <div class="filters-panel flex-box flex-between flex-vertical-top">
                <?
                $sql_column = $pdo->prepare("SELECT * FROM filters_columns WHERE activity='1' ORDER BY id ASC");
                $sql_column->execute();
                while($filter_column = $sql_column->fetch(PDO::FETCH_LAZY)){?>
                    <div class="filter-column text_left ">
                        <?
                        $sql = $pdo->prepare("SELECT * FROM filters_groups WHERE activity='1' AND filter_column='".$filter_column->id."' ORDER BY order_row DESC");
                        $sql->execute();
                        while($filter_group = $sql->fetch(PDO::FETCH_LAZY)){?>
                            <div class="filter-group box">
                                <div class="filter-title box-vertical">
                                    <?=$filter_group->title?>
                                </div>
                                <?
                                $sql_filters = $pdo->prepare("SELECT * FROM filters WHERE activity='1' AND filter_group='".$filter_group->id."' ORDER BY order_row DESC");
                                $sql_filters->execute();
                                while($filter_item = $sql_filters->fetch(PDO::FETCH_LAZY)){?>
                                    <div class="filter-unit ">
                                        <?if($filter_item->filter_type == 1){?>
                                            <? include($_SERVER["DOCUMENT_ROOT"] . '/system/templates/filters/tumbler-radio/index.php') ?>
                                        <?}elseif($filter_item->filter_type == 2){?>
                                            <? include($_SERVER["DOCUMENT_ROOT"].'/system/templates/filters/tiles-checkbox/index.php');?>
                                        <?}elseif($filter_item->filter_type == 3){?>
                                            <? include($_SERVER["DOCUMENT_ROOT"].'/system/templates/filters/range/index.php');?>
                                        <?}elseif($filter_item->filter_type == 4){?>
                                            <? include($_SERVER["DOCUMENT_ROOT"].'/system/templates/filters/dropdown/index.php');?>
                                        <?}elseif($filter_item->filter_type == 5){?>
                                            <? include($_SERVER["DOCUMENT_ROOT"].'/system/templates/filters/tiles-radio/index.php');?>
                                        <?}elseif($filter_item->filter_type == 6){?>
                                            <? include($_SERVER["DOCUMENT_ROOT"].'/system/templates/filters/value-number/index.php');?>
                                        <?}elseif($filter_item->filter_type == 7){?>
                                            <? include($_SERVER["DOCUMENT_ROOT"].'/system/templates/filters/tumbler-checkbox/index.php');?>
                                        <?}else{?>

                                        <?}?>
                                    </div>
                                <?}?>
                            </div>
                        <?}?>
                    </div>
                <?}?>
            </div>

            <?
            $filter_line = '';
            /*
             * ФИЛЬТРЫ К ОБЪЕКТУ
             */

            //КЛАСС
            if($_POST['object_class']) {
                $class_line = implode(',',$_POST['object_class']);
                $filter_line .= " AND o.object_class IN($class_line)";
            }
            if($_POST['industry_type']) {
                foreach($_POST['industry_type'] as $object_type_item){
                    $obj_type_line .= "o.purposes LIKE '%$object_type_item%' OR ";
                }
                $filter_line .= " AND (".trim(trim($obj_type_line),'OR').")";
            }
            //ЖД ветка
            if($_POST['railway']) {
                $filter_line .= " AND o.railway='1'";
            }
            //ЭЛЕКТРИЧЕСТВО
            if($_POST['power']) {
                $filter_line .= " AND o.power>'".$_POST['power']."'";
            }
            //ОТ МКАД
            if($_POST['from_mkad']) {
                $filter_line .= " AND o.from_mkad<'".$_POST['from_mkad']."'";
            }
            //ПАР
            if($_POST['steam']) {
                $filter_line .= " AND o.vape='".$_POST['steam']."'";
            }
            //ГАЗ
            if($_POST['gas']) {
                $filter_line .= " AND o.gas='".$_POST['gas']."'";
            }
            //НАПРАВЛЕНИЕ
            if($_POST['directions']) {
                $directions_line = implode(',',$_POST['directions']);
                $filter_line .= " AND o.direction IN($directions_line)";
            }
            //РЕГИОН
            if($_POST['region']) {
                $filter_line .= " AND o.region='".$_POST['region']."'";
            }
            //СТАТУС
            if($_POST['status']) {
                $filter_line .= " AND o.result='".$_POST['status']."'";
            }



            /*
             * ФИЛЬТРЫ К БЛОКу
             */
            //ТИП СДЕЛКИ
            if($_POST['deal_type']) {
                $filter_line .= " AND (o.deal_type='".$_POST['deal_type']."' OR b.deal_type='".$_POST['deal_type']."')";
            }
            //ПЛОЩАДЬ ОТ
            if($_POST['area_from']) {
                $filter_line .= " AND b.area>'".$_POST['area_from']."'";
            }
            //ПЛОЩАДЬ ДО
            if($_POST['area_to']) {
                $filter_line .= " AND b.area2<'".$_POST['area_to']."'";
            }
            //ЦЕНА ОТ
            if($_POST['price_from']) {
                $filter_line .= " AND b.rent_price>'".$_POST['price_from']."'";
            }
            //ЦЕНА ДО
            if($_POST['price_from']) {
                $filter_line .= " AND b.rent_price<'".$_POST['price_to']."'";
            }
            //ПОТОЛКИ ОТ
            if($_POST['height_ceiling_from']) {
                $filter_line .= " AND b.ceiling_height>'".$_POST['height_ceiling_from']."'";
            }
            //ПОТОЛКИ ДО
            if($_POST['height_ceiling_to']) {
                $filter_line .= " AND b.ceiling_height2<'".$_POST['height_ceiling_to']."'";
            }
            //ОТАПЛИВАЕМЫЙ
            if($_POST['heated']) {
                $filter_line .= " AND b.heated='".$_POST['heated']."'";
            }
            //ТОЛЬКО ПЕРВЫЙ ЭТАЖ
            if($_POST['ground_floor']) {
                $filter_line .= " AND b.floor='1'";
            }
            //СТЕЛЛАЖИ
            if($_POST['rack']) {
                $filter_line .= " AND b.pallet_mest2>'0'";
            }
            //КРАНЫ
            if($_POST['cranes']) {
                $filter_line .= " AND (b.telphers>'0' OR b.telphers>'0' OR b.catheads>'0' OR b.overhead_cranes>'0' OR o.gantry_cranes>'0' OR o.railway_cranes>'0')";
            }
            //ТИП ВОРОТ
            if($_POST['gate_type']) {
                foreach($_POST['gate_type'] as $gate_type_item){
                    $gate_type_line .= "b.gate_type='$gate_type_item' OR ";
                }
                $filter_line .= " AND (".trim(trim($gate_type_line),'OR').")";
            }
            //ТИП ПОЛА
            if($_POST['floor_type']) {
                foreach($_POST['floor_type'] as $floor_type_item){
                    $floor_type_line .= "b.floor_type='$floor_type_item' OR ";
                }
                $filter_line .= " AND (".trim(trim($floor_type_line),'OR').")";
            }

            /*
             * LINE SEARCH BLOCK
             */
            if(isset($_GET['search'])){
                $search_arr = explode(' ',trim($_GET['search']));
                /*
                 * Массив таблиц для подключения и поиска
                 */
                $search_table_arr = array(
                    'o'=>array('c_industry','',''), //формат : таблица - поле прикрепляемой - поле основной
                    'b'=>array('c_industry_blocks','',''),
                    'u'=>array('users','id','agent'),
                    'c'=>array('c_industry_customers','id','clyent_id'));

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


            $from_num = ($page_num - 1)*$pageItems;

            //ВИБИРАЕМ ВСЕ ДЛЯ ОБЬЕКТОВ
            $sql_text = "SELECT * FROM  c_industry o LEFT JOIN c_industry_blocks b ON b.parent_id=o.id  $join_line WHERE o.id!='0' $search_fil $filter_line ORDER BY  b.dt_update_full DESC, o.dt_update_full DESC  ";
            echo $sql_text.'<br>';
            $obj_sql = $pdo->prepare($sql_text);
            $obj_sql->execute();
            $obj_count = $obj_sql->rowCount();

            $pagesAmount = $obj_count/$pageItems;
            ?>
            <div class="filter-accept">
                <div class="filter-accept-button-container">
                    <button class="filter-accept-button">
                        показать <span><?=$obj_count?></span> предложений
                    </button>
                </div>
            </div>
        </form>
    </div>
    <div class="map-block">
        <div id="map_google" style="height: 100px; width: 100%;">

        </div>
    </div>
    <div class="main-table-block">
        <?include ($_SERVER['DOCUMENT_ROOT'].'/system/templates/objects/pagination/index.php') ?>
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
                    $object = new Item($item->id)?>
                    <?if($object->itemId() != $last_id){?>
                        <? include ($_SERVER['DOCUMENT_ROOT'].'/system/templates/objects/list/index.php') ?>
                    <?}?>
                    <?$last_id = $object->itemId()?>
                <?}?>
            </div>
        </div>
        <div class="load-more-block">

        </div>
        <?include ($_SERVER['DOCUMENT_ROOT'].'/system/templates/objects/pagination/index.php') ?>
    </div>
<? include_once($_SERVER["DOCUMENT_ROOT"].'/system/templates/modals/empty-edit/index.php')?>
<script>
    function initMap() {
        var home = {lat: 55.7182753, lng: 37.6775274};
        //создаем карту
        var map = new google.maps.Map(document.getElementById('map_google'), {
            zoom: 16,
            center: home
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
    }
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

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCwbktBM3GY5GfsT0VfA1MGEobYqkvrSkc&callback=initMap" async defer>  </script>		    		