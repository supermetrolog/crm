<div class="search-block">
        <form class="filters-block box-small" method="POST">
            <div class="box">
                <div class="custom-select text_left" >
                    <div class="flex-box pointer"  >
                        <div class="flex-box">
                            <div>
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                            <div style="padding: 2px 10px; box-sizing: border-box;  width: 100%;  border-bottom: 2px dashed grey;  font-weight: bold;">
                                Регион
                            </div>
                            <div>
                                <i class="fas fa-caret-down"></i>
                            </div>
                        </div>
                    </div>
                    <div class="custom-select-body" >
                        <ul class="custom-select-list">
                            <?$filter = new Filter(33);?>
                            <?foreach($filter->getFilterVariants() as $filter_item_unit){?>
                                <?if( $filter_item_unit['id'] != $_POST[trim($filter_item->description)]){?>
                                    <li>
                                        <div>
                                            <input id="<?=$filter->showField("description").'-'.$filter_item_unit['id']?>" <?= (in_array($filter_item_unit['id'],$_POST[trim($filter->showField("description"))]))? 'checked="checked"' : ''?> value="<?=$filter_item_unit['id']?>" name="<?=trim($filter->showField("description"))?>[]" type="checkbox" />
                                            <label style="padding: 5px 10px; box-sizing: border-box;"  class="flex-box pointer" for="<?=$filter->showField("description").'-'.$filter_item_unit['id']?>">
                                                <div>
                                                    <?=$filter_item_unit['title']?>
                                                </div>
                                                <div class="to-end">
                                                    <i class="fas fa-check"></i>
                                                </div>
                                            </label>
                                        </div>
                                    </li>
                                <?}?>
                            <?}?>
                        </ul>
                    </div>
                </div>
                <div class="search-categories box-small">
                    <?
                    $dealTypes = new Post(0);
                    $dealTypes->getTable('l_object_types');
                    foreach($dealTypes->getAllUnits() as $filter_item_unit){?>
                        <div>
                            <label class="radio-container">
                                <input name="object_type[]" type="checkbox" value="<?=$filter_item_unit['id']?>" <?=(in_array($filter_item_unit['id'],$_POST['object_type'])) ? 'checked' : '' ;?>/>
                                <span class="checkmark tap-btn"><?=$filter_item_unit['title']?></span>
                            </label>
                        </div>
                    <?}?>
                </div>
                <div class="search-line-block">
                    <div class="search-line flex-box">
                        <div class="custom-select" style="width: 20%;" >
                            <div class="flex-box pointer" style="padding: 10px 15px; box-sizing: border-box; border: none; width: 100%;  outline: none; border-radius: 40px 0px 0px 40px; border-right: 1px solid #acacac;  font-weight: bold; background: #ffdf88">
                                <div>
                                    Тип сделки
                                </div>
                                <div class="to-end">
                                    <i class="fas fa-caret-down"></i>
                                </div>
                            </div>
                            <div class="custom-select-body" >
                                <ul class="custom-select-list">
                                    <?$filter = new Filter(42);?>
                                    <?foreach($filter->getFilterVariants() as $filter_item_unit){?>
                                        <?if( $filter_item_unit['id'] != $_POST[trim($filter_item->description)]){?>
                                            <li>
                                                <div>
                                                    <input id="<?=$filter->showField("description").'-'.$filter_item_unit['id']?>" <?= ($filter_item_unit['id'] == $_POST[trim($filter->showField("description"))]) ? 'checked="checked"' : ''?> value="<?=$filter_item_unit['id']?>" name="<?=trim($filter->showField("description"))?>" type="radio" />
                                                    <label style="padding: 5px 10px; box-sizing: border-box;"  class="flex-box pointer" for="<?=$filter->showField("description").'-'.$filter_item_unit['id']?>">
                                                        <div>
                                                            <?=$filter_item_unit['title']?>
                                                        </div>
                                                        <div class="to-end">
                                                            <i class="fas fa-check"></i>
                                                        </div>
                                                    </label>
                                                </div>
                                            </li>
                                        <?}?>
                                    <?}?>
                                </ul>
                            </div>
                        </div>
                        <div class="custom-select" style="width: 20%;" >
                            <div class="flex-box pointer" style="padding: 10px 15px; box-sizing: border-box; border: none; width: 100%;  outline: none; border-right: 1px solid #acacac;  font-weight: bold; background: #ffdf88">
                                <div>
                                    Статус
                                </div>
                                <div class="to-end">
                                    <i class="fas fa-caret-down"></i>
                                </div>
                            </div>
                            <div class="custom-select-body" >
                                <ul class="custom-select-list">
                                    <?$filter = new Filter(1);?>
                                    <?foreach($filter->getFilterVariants() as $filter_item_unit){?>
                                        <?if( $filter_item_unit['id'] != $_POST[trim($filter_item->description)]){?>
                                            <li>
                                                <div>
                                                    <input id="<?=$filter_item->description.'-'.$filter_item_unit['id']?>" <?= ($filter_item_unit['id'] == $_POST[trim($filter->showField("description"))]) ? 'checked="checked"' : ''?> value="<?=$filter_item_unit['id']?>" name="<?=trim($filter->showField("description"))?>" type="radio" />
                                                    <label style="padding: 5px 10px; box-sizing: border-box;"  class="flex-box pointer" for="<?=$filter_item->description.'-'.$filter_item_unit['id']?>">
                                                        <div>
                                                            <?=$filter_item_unit['title']?>
                                                        </div>
                                                        <div class="to-end">
                                                            <i class="fas fa-check"></i>
                                                        </div>
                                                    </label>
                                                </div>
                                            </li>
                                        <?}?>
                                    <?}?>
                                </ul>
                            </div>
                        </div>
                        <div style="width: 60%;">
                            <input style="width: 100%; box-sizing: border-box; padding: 15px 20px;" value="<?=$_POST['search']?>" class="box" type="text"  name="search" placeholder="ID, адрес, собственник, телефон, Ф.И.О, брокер, название СК" />
                        </div>
                    </div>
                </div>
            </div>
            <div class="box-small" style="border: 1px solid #e1e1e1; background: #FFFFFF">
                <div class="box-small">
                    <?
                    $dealTypes = new Post(0);
                    $dealTypes->getTable('directions');
                    foreach($dealTypes->getAllUnits() as $filter_item_unit){?>
                        <div class="toggle-checkbox tap-btn" >
                            <input value="<?=$filter_item_unit['id']?>" name="directions[]" <?=(in_array($filter_item_unit['id'],$_POST['directions'])) ? 'checked' : '' ;?> type="checkbox"/>
                            <div>
                                <span class="ghost"><?=$filter_item_unit['icon']?></span>
                                <?=$filter_item_unit['title']?>
                            </div>
                        </div>
                    <?}?>
                </div>
                <div class="modal-filter-row flex-box flex-center">
                    <div class="box flex-box flex-around half ">
                        <div class="modal-call-btn pointer modal-filter-call"  style="border-bottom: 1px dotted #8a8c8f;" data-modal="filter" data-filter-select="tab-1">
                            <i class="fas fa-globe ghost-double"></i>
                            Область на карте
                        </div>
                        <div class="modal-call-btn pointer modal-filter-call" style="border-bottom: 1px dotted #8a8c8f" data-modal="filter" data-filter-select="tab-2">
                            <i class="fas fa-star ghost-double"></i>
                            Населенный пункт
                        </div>
                        <div class="modal-call-btn pointer modal-filter-call" style="border-bottom: 1px dotted #8a8c8f" data-modal="filter" data-filter-select="tab-3">
                            <i class="far fa-dot-circle ghost-double"></i>
                            Район
                        </div>
                        <div class="modal-call-btn pointer modal-filter-call" style="border-bottom: 1px dotted #8a8c8f" data-modal="filter" data-filter-select="tab-4">
                            <i class="fas fa-road ghost-double"></i>
                            Шоссе
                        </div>
                        <div class="modal-call-btn pointer modal-filter-call" style="border-bottom: 1px dotted #8a8c8f" data-modal="filter" data-filter-select="tab-5">
                            <i class="fab fa-monero ghost-double"></i>
                            Метро
                        </div>
                    </div>
                </div>
                <script>
                    let filters_modal_btns = document.getElementsByClassName('modal-filter-call');
                    for(let i = 0; i < filters_modal_btns.length; i++){
                        filters_modal_btns[i].addEventListener("click", function () {
                            //alert(filters_modal_btns[i].getAttribute('data-filter-select'));
                            document.getElementById(filters_modal_btns[i].getAttribute('data-filter-select')).setAttribute('checked','checked');
                        });
                    }
                </script>
                <? include_once ($_SERVER['DOCUMENT_ROOT'].'/system/templates/modals/filter-modal/index.php') ?>
                <div class="filters-panel box-small" style="background: #FFFFFF; border: 1px solid #d0d0d0">
                    <div class="flex-box flex-wrap text_left flex-vertical-bottom flex-around" style="background: #f6f6f6">
                        <?
                        $sql_filters = $pdo->prepare("SELECT * FROM filters WHERE activity='1'  ORDER BY order_row DESC");
                        $sql_filters->execute();
                        while($filter_item = $sql_filters->fetch(PDO::FETCH_LAZY)){?>
                            <div class="filter-unit box">
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
                                <?}elseif($filter_item->filter_type == 8){?>
                                    <? include($_SERVER["DOCUMENT_ROOT"].'/system/templates/filters/select-radio/index.php');?>
                                <?}elseif($filter_item->filter_type == 9){?>
                                    <? include($_SERVER["DOCUMENT_ROOT"].'/system/templates/filters/select-checkbox/index.php');?>
                                <?}else{?>

                                <?}?>
                            </div>
                        <?}?>
                    </div>
                </div>
                <?
                $filter_line = '';
                /*
                 * ФИЛЬТРЫ К ОБЪЕКТУ
                 */

                //КЛАСС
                if($_POST['object_class']) {
                    $class_line = implode(',',$_POST['object_class']);
                    $filter_line .= " AND i.object_class IN($class_line)";
                }
                //НАЗНАЧЕНИЕ ОБЪЕКТА
                if($_POST['purposes']) {
                    foreach($_POST['purposes'] as $purpose){
                        echo $purpose;
                        $purpose_line .= "i.purposes LIKE '%".$purpose."%' OR ";
                    }
                    $filter_line .= " AND (".trim(trim($purpose_line),'OR').")";
                }

                //ЖД ветка
                if($_POST['railway']) {
                    $filter_line .= " AND i.railway='1'";
                }
                //ЭЛЕКТРИЧЕСТВО
                if($_POST['power_from']) {
                    $filter_line .= " AND i.power>'".$_POST['power_from']."'";
                }
                //ОТ МКАД
                if($_POST['from_mkad_from']) {
                    $filter_line .= " AND i.from_mkad>'".$_POST['from_mkad_from']."'";
                }
                if($_POST['from_mkad_to']) {
                    $filter_line .= " AND i.from_mkad<'".$_POST['from_mkad_to']."'";
                }
                //ПАР
                if($_POST['steam']) {
                    $filter_line .= " AND i.vape='".$_POST['steam']."'";
                }
                //ГАЗ
                if($_POST['gas']) {
                    $filter_line .= " AND i.gas='".$_POST['gas']."'";
                }
                //НАПРАВЛЕНИЕ
                if($_POST['directions']) {
                    $directions_line = implode(',',$_POST['directions']);
                    $filter_line .= " AND i.direction IN($directions_line)";
                }
                //НАСЕЛЕННЫЙ ПУНКТ
                if($_POST['villages']) {
                    $villages_line = implode(',',$_POST['villages']);
                    $filter_line .= " AND i.village IN($villages_line)";
                }
                //ШОССЕ
                if($_POST['highways']) {
                    $highways_line = implode(',',$_POST['highways']);
                    $filter_line .= " AND i.highway IN($highways_line)";
                }
                //МЕТРО
                if($_POST['metros']) {
                    $metros_line = implode(',',$_POST['metros']);
                    $filter_line .= " AND i.metro IN($metros_line)";
                }
                //РЕГИОН
                if($_POST['region']) {
                    foreach($_POST['region'] as $region){
                        $region_line .= "i.region LIKE '%".$region."%' OR ";
                    }
                    $filter_line .= " AND (".trim(trim($region_line),'OR').")";
                }
                //ТИП ОБЪЕКТА
                if($_POST['object_type']) {
                    foreach($_POST['object_type'] as $object_type){
                        $object_type_line .= "i.object_type LIKE '%".$object_type."%' OR ";
                    }
                    $filter_line .= " AND (".trim(trim($object_type_line),'OR').")";
                }

                //РАЙОН
                if($_POST['districts']) {
                    $districts_line = implode(',',$_POST['districts']);
                    $filter_line .= " AND i.district IN($districts_line)";
                }



                /*
                 * ФИЛЬТРЫ К ПРЕДЛОЖЕНИЮ
                 */
                //ТИП СДЕЛКИ
                if($_POST['deal_type']) {
                    $filter_line .= " AND o.deal_type='".$_POST['deal_type']."'";
                }
                if($_POST['status']) {
                    $filter_line .= " AND o.offer_status='".$_POST['status']."'";
                }
                /*
                 * ФИЛЬТРЫ К БЛОКУ
                 */

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
                    $filter_line .= " AND (b.telphers>'0' OR b.telphers>'0' OR b.catheads>'0' OR b.overhead_cranes>'0' OR i.gantry_cranes>'0' OR i.railway_cranes>'0')";
                }
                //ТИП ВОРОТ
                if($_POST['gate_type']) {
                    $filter_line .= " AND b.gate_type='".$_POST['gate_type']."'";
                }
                //ТИП ПОЛА
                if($_POST['floor_type']) {
                    /*
                    foreach($_POST['floor_type'] as $floor_type_item){
                        $floor_type_line .= "b.floor_type='$floor_type_item' OR ";
                    }
                    $filter_line .= " AND (".trim(trim($floor_type_line),'OR').")";
                    */
                    $filter_line .= " AND b.floor_type='".$_POST['floor_type']."'";
                }

                /*
                 * LINE SEARCH BLOCK
                 */
                if($_POST['search']){
                    $search_arr = explode(' ',trim($_POST['search']));
                    /*
                     * Массив таблиц для подключения и поиска
                     */
                    $search_table_arr = array(
                        'i'=>array('c_industry','',''), //формат : таблица - поле прикрепляемой - поле основной
                        'b'=>array('c_industry_blocks','',''),
                        'u'=>array('users','id','agent_id'),
                        'c'=>array('c_industry_customers','id','client_id'));

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
                //$sql_text = "SELECT * FROM  c_industry_offers o LEFT JOIN c_industry_blocks b ON b.offer_id=o.id  $join_line WHERE o.id!='0' $search_fil $filter_line ORDER BY  b.dt_update_full DESC, o.dt_update_full DESC  ";
                //$sql_text = "SELECT * FROM  c_industry_offers  WHERE id!='0'  ";
                $sql_text = "SELECT * FROM  c_industry_offers o  LEFT JOIN c_industry i ON o.object_id=i.id LEFT JOIN c_industry_blocks b ON b.parent_id=i.id  $join_line   WHERE o.deleted!='1' $search_fil $filter_line   AND i.deleted!='1' AND b.deleted!='1'  ";
                echo $sql_text.'<br>';
                $obj_sql = $pdo->prepare($sql_text);
                $obj_sql->execute();
                $obj_count = $obj_sql->rowCount();

                $pagesAmount = $obj_count/$pageItems;
                ?>
                <div class="isBold">
                    Меньше параметров <span><i class="fas fa-caret-down"></i></span>
                </div>
                <div class="filter-accept">
                    <div class="filter-accept-button-container">
                        <button class="filter-accept-button">
                            <b>
                                Показать <span><?=$obj_count?></span> предложений
                            </b>
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>