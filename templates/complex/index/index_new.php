<?include_once($_SERVER['DOCUMENT_ROOT'].'/templates/complex/header/index.php')?>



<div class="tabs-block tabs-active-free">
    <div class="tabs flex-box">
        <div class="tab box-small">
            О комплексе
        </div>
        <div class="tab box-small">
            План территории
        </div>
        <div class="tab box-small">
            Презентации
        </div>
        <div class="tab box-small">
            Договора
        </div>
        <div class="tab box-small">
            Документы
        </div>
        <div class="tab box-small">
            Панорамы
        </div>
        <div class="tab box-small">
            Описание
        </div>
    </div>
    <div class="tabs-content tabs-content-overline">
        <div class="tab-content">
            <div class="full-width object-stats-block ">
                <div class="flex-box flex-vertical-top full-width">
                    <div class="object-about-section object-params-list col-1 one-fourth-flex box-small">
                        <div class="box"><b>Основное</b></div>
                        <ul>
                            <li>
                                <div>
                                    Площадь участка
                                </div>
                                <div>
                                    <?=$complex->getField('area_field_full')?> <span class="degree-fix">м<sup>2</sup></span>
                                </div>
                            </li>
                            <li>
                                <div>
                                    Габариты участка
                                </div>
                                <div>
                                    <?if($complex->getField('land_length') && $complex->getField('land_width')){?>
                                        <?=$complex->getField('land_length')?> x <?=$complex->getField('land_width')?> м
                                    <?}else{?>
                                        -
                                    <?}?>
                                </div>
                            </li>
                            <li>
                                <div>
                                    Кадастровый № участка
                                </div>
                                <div>
                                    <?= $complex->getField('cadastral_number_land') ? $complex->getField('cadastral_number_land') : '-' ?>
                                </div>
                            </li>
                            <li>
                                <div>
                                    Правовой статус зем. уч.
                                </div>
                                <div>
                                    <?/*if($object->getObjectOwnLawTypeLand()){?>
                                        <?=$object->getObjectOwnLawTypeLand()?>
                                    <?}else{?>
                                        -
                                    <?}*/?>
                                </div>
                            </li>
                            <li>
                                <div>
                                    Категория земли
                                </div>
                                <div>
                                    <?/*if($object->getObjectCategoryLand()){?>
                                        <?=$object->getObjectCategoryLand()?>
                                    <?}else{?>
                                        -
                                    <?}*/?>
                                </div>
                            </li>
                            <li>
                                <div>
                                    Рельеф участка
                                </div>
                                <div>
                                    <?if($complex->getField('landscape_type')){?>
                                        <?$landscape = new Post($complex->getField('landscape_type'))?>
                                        <?$landscape->getTable('l_landscape')?>
                                        <?=$landscape->title()?>
                                    <?}else{?>
                                        -
                                    <?}?>
                                </div>
                            </li>
                            <li>
                                <div>
                                    Ограничения
                                </div>
                                <div>
                                    <?if($complex->getField('land_use_restrictions')){?>
                                        есть
                                    <?}else{?>
                                        -
                                    <?}?>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="object-about-section object-params-list col-2 one-fourth-flex box-small">
                        <div class="box"><b>Коммуникации</b></div>
                        <ul>
                            <li>
                                <div>
                                    Электричество
                                </div>
                                <div>
                                    <?=$complex->getField('power')?> <span>кВт</span>
                                </div>
                            </li>
                            <li>
                                <div>
                                    Отопление
                                </div>
                                <div>
                                    <?/*if($object->heatType()){?>
                                        <?=$object->heatType()?>
                                    <?}else{?>
                                        -
                                    <?}*/?>
                                </div>
                            </li>
                            <li>
                                <div>
                                    Вид отопления
                                </div>
                                <div>

                                </div>
                            </li>
                            <li>
                                <div>
                                    Водоснабжение -
                                </div>
                                <div>
                                    <?/*if($object->waterType()){?>
                                        <?=$object->waterType()?>
                                    <?}else{?>
                                        -
                                    <?}*/?>
                                </div>
                            </li>
                            <li>
                                <div>
                                    Городская канализация
                                </div>
                                <div>
                                    <?= ($complex->getField('sewage_central')) ? 'есть' : '-'?>
                                </div>
                            </li>
                            <li>
                                <div>
                                    Ливневая канализация
                                </div>
                                <div>
                                    <?= ($complex->getField('sewage_rain')) ? 'есть' : '-'?>
                                </div>
                            </li>
                            <li>
                                <div>
                                    Газ
                                </div>
                                <div>
                                    <?= ($complex->getField('gas')) ? 'есть' : '-'?>
                                    <?=$complex->getField('gas_value')?> <span class="degree-fix">м<sup>3</sup>/час</span>
                                </div>
                            </li>
                            <li>
                                <div>
                                    Пар
                                </div>
                                <div>
                                    <?= ($complex->getField('steam')) ? 'есть' : '-'?>
                                    <?//=$complex->showObjectStat('steam_value' , '<span>бар</span>' , '') ?>
                                </div>
                            </li>
                            <li>
                                <div>
                                    Телефония
                                </div>
                                <div>
                                    <?= ($complex->getField('phone_line')) ? 'есть' : '-'?>
                                </div>
                            </li>
                            <li>
                                <div>
                                    Интернет
                                </div>
                                <div>
                                    <?= ($complex->getField('internet_type')) ? '' : '-'?>
                                </div>
                            </li>
                            <li>
                                <div>
                                    &#160;
                                </div>
                                <div>

                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="object-about-section object-params-list col-3 one-fourth-flex box-small">
                        <div class="box"><b>Безопасность</b></div>
                        <ul>
                            <li>
                                <div>
                                    Охрана объекта
                                </div>
                                <div>
                                    <?/*if($object->guardType()){?>
                                        <?=$object->guardType()?>
                                    <?}else{?>
                                        -
                                    <?}*/?>
                                </div>
                            </li>
                            <li>
                                <div>
                                    Видеонаблюдение
                                </div>
                                <div>
                                    <?= ($complex->getField('video_control')) ? 'есть' : '-'?>
                                </div>
                            </li>
                            <li>
                                <div>
                                    Контроль доступа
                                </div>
                                <div>
                                    <?= ($complex->getField('access_control')) ? 'есть' : '-'?>
                                </div>
                            </li>
                            <li>
                                <div>
                                    Охранная сигнализация
                                </div>
                                <div>
                                    <?= ($complex->getField('security_alert')) ? 'есть' : '-'?>
                                </div>
                            </li>
                            <li>
                                <div>
                                    Шлагбаум
                                </div>
                                <div>
                                    <?= ($complex->getField('barrier')) ? 'есть' : '-'?>
                                </div>
                            </li>
                            <li>
                                <div>
                                    Забор по периметру
                                </div>
                                <div>
                                    <?= ($complex->getField('fence')) ? 'есть' : '-'?>
                                </div>
                            </li>
                            <li>
                                <div>
                                    &#160;
                                </div>
                                <div>

                                </div>
                            </li>
                            <li>
                                <div>
                                    &#160;
                                </div>
                                <div>

                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="object-about-section object-params-list col-4 one-fourth-flex box-small">
                        <div class="box"><b>Ж/Д на территории</b></div>
                        <ul>
                            <?
                            $cranes = ['cranes_railway'=>'Ж/Д краны', 'cranes_gantry'=>'Козловые краны'];

                            foreach($cranes as $key=>$value){
                                $items = $complex->getJsonField($key);
                                $types = [];
                                $sorted_arr = [];

                                for($i = 0; $i < count($items); $i = $i+2) {
                                    if (!in_array($items[$i+1], $types) && $items[$i+1]!=0) {
                                        array_push($types, $items[$i+1]);
                                    }
                                }

                                //var_dump($types);

                                //подсчитываем колво каждого типа
                                foreach($types as $elem_unique){
                                    for($i = 0; $i < count($items); $i = $i+2) {
                                        if ($items[$i+1] == $elem_unique) {
                                            $sorted_arr[$elem_unique] += $items[$i];
                                        }
                                    }
                                }
                                ?>

                                <li>
                                    <div>
                                        <?=$value?>
                                    </div>
                                    <div>
                                        <?if($sorted_arr){?>
                                            <?foreach($sorted_arr as $key2=>$value2){?>
                                                <div class="flex-box">
                                                    <div class="ghost"><?=$value2?> шт /</div>  <div><?=$key2?> т.</div>
                                                </div>
                                            <?}?>
                                        <?}else{?>
                                            -
                                        <?}?>

                                    </div>
                                </li>
                            <?}?>
                            <li>
                                <div>
                                    Ж/Д ветка
                                </div>
                                <div>
                                    <?=($complex->getField('railway')) ? 'есть' : '-'?>
                                    <?=$complex->getField('railway_value')?> <span>м</span>
                                </div>
                            </li>
                            <li>
                                <div>
                                    &#160;
                                </div>
                                <div>

                                </div>
                            </li>
                            <li>
                                <div>
                                    <b>Инфраструктура</b>
                                </div>

                            </li>
                            <li>
                                <div>
                                    Вьезд
                                </div>
                                <div>
                                    <?/*if($object->getField('entry_territory')){?>
                                        <?=$object->entranceType()?>
                                    <?}else{?>
                                        <span>не указано</span>
                                    <?}*/?>
                                </div>
                            </li>
                            <li>
                                <div>
                                    &#171;P&#187; легковая
                                </div>
                                <div>
                                    <?=($complex->getField('parking_car')) ? 'есть' : '-'?>
                                    <?if($complex->getField('parking_car_value')){?>
                                        <?
                                        $car_parking_type = new Post($complex->getField('parking_car_value'));
                                        $car_parking_type->getTable('l_parking_type');
                                        ?>
                                        <?= ', '.$car_parking_type->title()?>
                                    <?}?>
                                </div>
                            </li>
                            <li>
                                <div>
                                    &#171;P&#187; 3-10 тонн
                                </div>
                                <div>
                                    <?=($complex->getField('parking_lorry')) ? 'есть' : '-'?>
                                    <?if($complex->getField('parking_lorry_value') != NULL){?>
                                        <?
                                        $car_parking_type = new Post($complex->getField('parking_lorry_value'));
                                        $car_parking_type->getTable('l_parking_type');
                                        ?>
                                        <?= ', '.$car_parking_type->title()?>
                                    <?}?>
                                </div>
                            </li>
                            <li>
                                <div>
                                    &#171;P&#187; от 10 тонн
                                </div>
                                <div>
                                    <?=($complex->getField('parking_truck')) ? 'есть' : '-'?>
                                    <?if($complex->getField('parking_truck_value')){?>
                                        <?
                                        $car_parking_type = new Post($complex->getField('parking_truck_value'));
                                        $car_parking_type->getTable('l_parking_type');
                                        ?>
                                        <?= ', '.$car_parking_type->title()?>
                                    <?}?>
                                </div>
                            </li>
                            <li>
                                <div>
                                    Столовая/кафе
                                </div>
                                <div>
                                    <?= ($complex->getField('canteen')) ? 'есть' : '-'?>
                                </div>
                            </li>
                            <li>
                                <div>
                                    Общежитие
                                </div>
                                <div>
                                    <?= ($complex->getField('hostel')) ? 'есть' : '-'?>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="box-small full-width" >
                    <div class="box-small" style="background: #f4f4f4;">
                        <span class="ghost">В.Р.И. :</span>  <?=$complex->getField('field_allow_usage')?>
                    </div>
                </div>
            </div>
            <div  class="flex-box flex-center box full-width object-stats-toggle" title="Развернуть основные характеристики">
                <div class="icon-round">
                    <i class="fas fa-angle-up"></i>
                </div>
            </div>
            <script>
                $(document).ready(function(){
                    $('body').on('click','.object-stats-toggle',function(){
                        $(this).toggleClass('rotate-180');
                        $('.object-stats-block').slideToggle();
                    });
                });
            </script>
        </div>
        <div class="tab-content">

        </div>
        <div class="tab-content">

        </div>
        <div class="tab-content">

        </div>
        <div class="tab-content">

        </div>
        <div class="tab-content">

        </div>
        <div class="tab-content">

        </div>
    </div>
</div>

<div class="box">

</div>
<div class="box">

</div>
<div class="widget-title flex-box" >
    <div>
        Строения и участки
    </div>
    <div class="to-end flex-box">
        <div class="icon-round  modal-call-btn" data-modal="edit-all" data-id="" data-form="building" data-table="<?=(new Building())->setTableId()?>"    data-modal-size="modal-very-big" data-names='["is_land","complex_id"]' data-values='[0,<?=$complex->getField('id')?>]' >
            <div title="Создать обьект"><i class="fas fa-warehouse"></i></div>
        </div>
        <div class="icon-round  modal-call-btn" data-modal="edit-all" data-id="" data-form="land" data-table="<?=(new Building())->setTableId()?>"  data-modal-size="modal-very-big" data-names='["is_land","complex_id","form_title"]' data-values='[1,<?=$complex->getField('id')?>,"Участок"]'  >
            <div title="Создать участок"><i class="fas fa-tree"></i></div>
        </div>
    </div>
</div>

<div class="objects-list">

    <? $sql = $pdo->prepare("SELECT id FROM c_industry WHERE complex_id=$complex_id AND deleted!=1");
    $sql->execute();

    while($obj = $sql->fetch(PDO::FETCH_LAZY)){
        echo $obj['deleted'];
        //echo '<br>';?>
        <div style="border: 2px dashed grey; margin-bottom: 20px;">
            <?include( PROJECT_ROOT.'/templates/objects/index/index_time.php');?>
        </div>
    <?}?>
</div>

    <script>

        Array.prototype.remove = function(value) {
            var idx = this.indexOf(value);
            if (idx != -1) {
                // Второй параметр - число элементов, которые необходимо удалить
                return this.splice(idx, 1);
            }
        }



        $('body').on('click','.offer-tab',function(){
            let id = $(this).attr('id');


            //получаем строку параметров
            let par_str = window.location.search;

            //отрезаем знак вопроса впереди
            par_str = par_str.substr(1);

            //разбиваем строку по параметрам
            let pars = par_str.split('&');

            //считаем количество параметров
            let pars_num = pars.length;

            //alert(pars);

            var pars_assoc = {};

            //собирает ассоциативны $_GET массив
            for(let i = 0; i < pars_num; i++){
                let elem = pars[i].split('=');
                pars_assoc[elem[0]] = elem[1];
            }

            //меняем значение для параметра

            let offers = pars_assoc['offer_id'];

            //alert(offers);
            if(offers == null){
                offers = [];
            }else{
                offers = JSON.parse(offers);
            }

            //смотрим соседей и вырезаем их
            let row_items = JSON.parse($(this).attr('row-ids'));
            for(let i = 0; i < row_items.length; i++){
                console.log(row_items[i]);
                offers.remove(row_items[i]);
            }

            //Добавляем то что тыкнули
            offers.push(parseInt(id));
            pars_assoc['offer_id'] = JSON.stringify(offers);

            //собираем строку праметров из массива
            var str = '';
            for(let i = 0; i < pars_assoc.length; i++){
                let elem = pars[i].split('=');
                pars_assoc[elem[0]] = elem[1];
            }

            for(key in pars_assoc){
                if(pars_assoc[key] != undefined){
                    let part = key + "=" + pars_assoc[key];
                    str = str+part+'&';
                }
            }

            //alert(str);

            str = str.substring(0, str.length - 1);

            let url = 'https://pennylane.pro/complex/<?=$complex->postId()?>?'+str;

            //значение урла
            //let url = 'https://pennylane.pro/object/10248/?offer_id='+id;

            //меняем URL без перезагрузки
            history.pushState(null, null, url);

            //alert(str);

        });
    </script>


<style>
    .floor-info{
        min-width: 150px;
    }

    .floor-blocks{
        box-sizing: border-box;
        padding: 0 3px;
    }

    .acc-unit{
        width: 100%;
    }

    .acc-content{
        display: none;
        color: #000;
    }

    .blocks-stats > div:nth-child(2n){
        background: #f2f2f2;
    }

</style>


<script>
    $('body').on('click','.acc-tab',function(){
        if($(this).closest('.acc-unit').find('.acc-content').css('display') == 'block'){
            $(this).closest('.acc-unit').find('.acc-content').slideUp(300);
        }else{
            $(this).closest('.accordion').find('.acc-content').slideUp(300);
            $(this).closest('.acc-unit').find('.acc-content').slideToggle(300);
        }

    });
</script>

<script>
    $(document).ready(function(){
        $('body').on('click','.object-stats-toggle',function(){
            $(this).toggleClass('rotate-180');
            $('.object-stats-block').slideToggle();
        });
    });
</script>




