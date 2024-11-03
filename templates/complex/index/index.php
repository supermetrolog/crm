<?include_once($_SERVER['DOCUMENT_ROOT'].'/templates/complex/header/index.php')?>
<?if($_COOKIE['member_id'] == 142){?>
    <?include_once($_SERVER['DOCUMENT_ROOT'].'/errors.php')?>
<?}?>



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
            Документы
        </div>
        <div class="tab box-small">
            Панорамы
        </div>
    </div>
    <div class="tabs-content tabs-content-overline">
        <div class="tab-content">
            <div class="full-width object-stats-block ">
                <div class="flex-box flex-vertical-top full-width flex-wrap">
                    <div class="object-about-section object-params-list col-1 half box-small">
                        <div class="box"><b>Основное</b></div>
                        <ul>
                            <li>
                                <div>
                                    S - участка комплекса
                                </div>
                                <div>
                                    <?=$complex->getField('area_field_full')?> <span class="degree-fix">м<sup>2</sup></span>
                                </div>
                            </li>
                            <li>
                                <div>
                                    S - строений комплекса
                                </div>
                                <div>
                                    <?=$complex->getField('area_buildings_full')?> <span class="degree-fix">м<sup>2</sup></span>
                                </div>
                            </li>
                            <li>
                                <div>
                                    Кол-во администр. строений
                                </div>
                                <div>
                                    <?=$complex->getField('buildings_admin_num')?>
                                </div>
                            </li>
                            <li>
                                <div>
                                    Кол-во произв./складских. строений
                                </div>
                                <div>
                                    <?=$complex->getField('buildings_industry_num')?>
                                </div>
                            </li>
                            <li>
                                <div>
                                    Кол-во вспомогательных строений
                                </div>
                                <div>
                                    <?if($type = $complex->getField('buildings_help_num') ){?>
                                        <?
                                        $type = new Post($type);
                                        $type->getTable('l_complex_nums');
                                        echo $type->title();
                                        ?>
                                    <?}else{?>
                                        -
                                    <?}?>
                                </div>
                            </li>
                            <li>
                                <div>
                                    Собственников на комплексе
                                </div>
                                <div>
                                    <?if($type = $complex->getField('owners_num') ){?>
                                        <?
                                        $type = new Post($type);
                                        $type->getTable('l_complex_nums');
                                        echo $type->title();
                                        ?>
                                    <?}else{?>
                                        -
                                    <?}?>
                                </div>
                            </li>
                            <li>
                                <div>
                                    Управляющая компания
                                </div>
                                <div>
                                    <?=$complex->getField('managment_company') == 1 ? 'да' :  '-'?>
                                </div>
                            </li>
                        </ul>
                        <div class="box"><b>Коммуникации</b></div>
                        <ul>
                            <li>
                                <div>
                                    Электричество
                                </div>
                                <div>
                                    <?=$complex->getField('power_value')?> <span>кВт</span>
                                </div>
                            </li>
                            <li>
                                <div>
                                    Отопление центральное
                                </div>
                                <div>
                                    <?=$complex->getField('heating_central') == 1 ? 'да' : '-' ?>
                                </div>
                            </li>
                            <li>
                                <div>
                                    Отопление автон
                                </div>
                                <div>
                                    <?=$complex->getField('heating_autonomous') == 1 ? 'да' : '-' ?>
                                    <span>
                                        <?if(arrayIsNotEmpty($types = $complex->getJsonField('heating_autonomous_type')) ){?>
                                            <?
                                            foreach($types as $type) {
                                                $type = new Post($type);
                                                $type->getTable('l_heatings_autonomous');
                                                echo ', '.$type->title();
                                            }
                                            ?>
                                        <?}else{?>
                                            -
                                        <?}?>
                                    </span>
                                </div>
                            </li>
                            <li>
                                <div>
                                    Водоснабжение
                                </div>
                                <div>
                                    <?= ($complex->getField('water') == 1) ? 'есть' : '-'?>
                                    <?if(arrayIsNotEmpty($types = $complex->getJsonField('water_type'))){?>
                                        <span>
                                            <?
                                            foreach($types as $water_type) {
                                                $w_type = new Post($water_type);
                                                $w_type->getTable('l_waters');
                                                echo ', '.$w_type->getField('title');
                                            }
                                            ?>
                                        </span>
                                        <?= ($complex->getField('water_value')) ? ', '.$complex->getField('water_value').' <span class="degree-fix">м<sup>3</sup>/час</span>' : '' ?>
                                    <?}?>
                                </div>
                            </li>
                            <li>
                                <div>
                                    Центральная канализация
                                </div>
                                <div>
                                    <?= ($complex->getField('sewage') == 1) ? 'есть' : '-'?>
                                    <?= $complex->getField('sewage_value') ? ', '.$complex->getField('sewage_value').' <span class="degree-fix">м<sup>3</sup>/час</span>' : ''?>
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
                                    <?if($complex->getField('gas')){?>
                                        <span>
                                            <?php
                                            $gas_type = new Post($complex->getField('gas'));
                                            $gas_type->getTable('l_gas_types');
                                            ?>
                                            <?=$gas_type->title(); ?>
                                        </span>
                                        <?if($complex->getField('gas_value')){?>
                                            <?=$complex->getField('gas_value')?> <span class="degree-fix">м<sup>3</sup>/час</span>
                                        <?}?>
                                    <?}else{?>
                                        -
                                    <?}?>

                                </div>
                            </li>
                            <li>
                                <div>
                                    Пар
                                </div>
                                <div>
                                    <?= ($complex->getField('steam')) ? 'есть' : '-'?>
                                    <?if($complex->getField('steam_value')){?>
                                        <?=$complex->getField('steam_value')?> <span class="degree-fix">бар</span>
                                    <?}?>
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
                                    <?= ($complex->getField('internet')) ? 'есть' : '-'?>
                                    <span>
                                            <?
                                            $types = $complex->getJsonField('internet_type');
                                            foreach($types as $water_type) {
                                                $w_type = new Post($water_type);
                                                $w_type->getTable('l_internet');
                                                echo ', '.$w_type->getField('title');
                                            }
                                            ?>
                                    </span>
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

                    <div class="object-about-section object-params-list col-3 half box-small">
                        <div class="box"><b>Безопасность</b></div>
                        <ul>
                            <li>
                                <div>
                                    Охрана комплекса
                                </div>
                                <div>
                                    <?//= $complex->guardType() ?? '-'?>
                                    <?= ($complex->getField('guard')) ? 'есть' : '-'?>
                                    <span>
                                        <?
                                        $types = $complex->getJsonField('guard_type');
                                        foreach($types as $type) {
                                            $w_type = new Post($type);
                                            $w_type->getTable('l_guards_industry');
                                            echo ', '.$w_type->getField('title');
                                        }
                                        ?>
                                    </span>
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
                        <ul>

                            <li>
                                <div>
                                    <b>Инфраструктура</b>
                                </div>

                            </li>
                            <li>
                                <div>
                                    Въезд на территоррию
                                </div>
                                <div>
                                    <?
                                    if($type = $complex->getField('entry_territory_type')) {
                                        $w_type = new Post($type);
                                        $w_type->getTable('l_entry_territory_type');
                                        echo $w_type->getField('title');
                                    }
                                    ?>
                                </div>
                            </li>
                            <li>
                                <div>
                                    Плата за вьезд
                                </div>
                                <div>
                                    <?= $complex->entranceType() ?? '-'?>
                                </div>
                            </li>
                            <li>
                                <div>
                                    &#171;P&#187; легковая
                                </div>
                                <div>
                                    <?=($complex->getField('parking_car')) ? 'есть' : '-'?>
                                    <?if($complex->getField('parking_car_type')){?>
                                        <?
                                        $car_parking_type = new Post($complex->getField('parking_car_type'));
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
                                    <?if($complex->getField('parking_lorry_type')){?>
                                        <?
                                        $car_parking_type = new Post($complex->getField('parking_lorry_type'));
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
                                    <?if($complex->getField('parking_truck_type')){?>
                                        <?
                                        $car_parking_type = new Post($complex->getField('parking_truck_type'));
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
                        <div class="box"><b>Ж/Д на территории</b></div>
                        <ul>
                            <li>
                                <div>
                                    Ж/Д ветка
                                </div>
                                <div>
                                    <?if($complex->getField('railway')) {?>
                                        есть
                                    <?}else{?>
                                        -
                                    <?}?>
                                    <?= $complex->getField('railway_value') ?   $complex->getField('railway_value').' <span>м</span>' : ''  ?>
                                </div>
                            </li>
                        </ul>
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
            <? foreach ($complex->getJsonField('building_layouts') as $layout) { ?>
                <div class="box-small">
                    <div class="background-fix" style="width: 200px; height: 200px; background-image: url('<?=$layout?>')">
                        <a style="display: block; height: 100%" href="<?=$layout?>" target="_blank" >

                        </a>
                    </div>
                </div>
            <? } ?>
        </div>
        <div class="tab-content">
            <? foreach ($complex->getJsonField('building_presentations') as $item) { ?>
                <?
                    $name = explode('/presentations/',$item)[1];
                    $parts = explode('_',$name);
                    $hashAndExt = array_pop($parts);
                    $name = implode('_',$parts);
                    $ext = explode('.',$hashAndExt)[1];
                    $name = $name . '.' . $ext;

                ?>
                <div class="box-small">
                    <div class="text_center full-height flex-box flex-box-vertical grey-border" style="width: 200px; height: 200px;">
                        <div class="box">

                        </div>
                        <div style="font-size: 60px;" title="<?=$name?>">
                            <i class="far fa-file-image"></i>
                        </div>
                        <div class="box">

                        </div>
                        <div title="<?=$name?>" class="box-small text_center full-width to-end-vertical grey-background">
                            <a href="<?=$item?>" target="_blank" class="text_center">
                                <div class="flex-box flex-center">
                                    <div>
                                        <?=$name?>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>

            <? } ?>
        </div>
        <div class="tab-content">
            <div class="tab-content">
                <? foreach ($complex->getJsonField('building_property_documents') as $item) { ?>
                    <?
                    $name = explode('/property_documents/',$item)[1];
                    $parts = explode('_',$name);
                    $hashAndExt = array_pop($parts);
                    $name = implode('_',$parts);
                    $ext = explode('.',$hashAndExt)[1];
                    $name = $name . '.' . $ext;

                    ?>
                    <div class="box-small">
                        <div class="text_center full-height flex-box flex-box-vertical grey-border" style="width: 200px; height: 200px;">
                            <div class="box">

                            </div>
                            <div style="font-size: 60px;" title="<?=$name?>">
                                <i class="far fa-file-image"></i>
                            </div>
                            <div class="box">

                            </div>
                            <div title="<?=$name?>" class="box-small text_center full-width to-end-vertical grey-background">
                                <a href="<?=$item?>" target="_blank" class="text_center">
                                    <div class="flex-box flex-center">
                                        <div>
                                            <?=$name?>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>

                <? } ?>
            </div>
        </div>
        <div class="tab-content">
            <div class="tab-content">
                <? foreach ($complex->getJsonField('photos_360') as $item) { ?>
                    <?
                    $name = explode('/360/',$item)[1];
                    $parts = explode('_',$name);
                    $hashAndExt = array_pop($parts);
                    $name = implode('_',$parts);
                    $ext = explode('.',$hashAndExt)[1];
                    $name = $name . '.' . $ext;

                    ?>
                    <div class="box-small">
                        <div class="text_center full-height flex-box flex-box-vertical grey-border" style="width: 200px; height: 200px;">
                            <div class="box">

                            </div>
                            <div style="font-size: 60px;" title="<?=$name?>">
                                <i class="far fa-file-image"></i>
                            </div>
                            <div class="box">

                            </div>
                            <div title="<?=$name?>" class="box-small text_center full-width to-end-vertical grey-background">
                                <a href="<?=$item?>" target="_blank" class="text_center">
                                    <div class="flex-box flex-center">
                                        <div>
                                            <?=$name?>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>

                <? } ?>
            </div>
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
        <div class="icon-round  modal-call-btn" data-modal="edit-all" data-id="" data-form="building" data-table="<?=(new Building())->setTableId()?>"    data-modal-size="modal-big" data-names='["is_land","complex_id","form_title"]' data-values='[0,<?=$complex->getField('id')?>,"Строение"]' >
            <div title="Создать обьект"><i class="fas fa-warehouse"></i></div>
        </div>
        <div class="icon-round  modal-call-btn" data-modal="edit-all" data-id="" data-form="land" data-table="<?=(new Building())->setTableId()?>"  data-modal-size="modal-big" data-names='["is_land","complex_id","form_title"]' data-values='[1,<?=$complex->getField('id')?>,"Участок"]'  >
            <div title="Создать участок"><i class="fas fa-tree"></i></div>
        </div>
    </div>
</div>

<div class="objects-list">
    <?
    if($_GET['offer_id'] && count(json_decode($_GET['offer_id'])) == 1){?>

        <?
        $off_obj = new Offer(json_decode($_GET['offer_id'])[0]);

        $obj_id = $off_obj->getField('object_id');

        ?>

        <?
        //include_once $_SERVER['DOCUMENT_ROOT'].'/errors.php';
        $sql_obj = $pdo->prepare("(SELECT id FROM c_industry WHERE id=$obj_id ) UNION (SELECT id FROM c_industry WHERE complex_id=$complex_id AND deleted!=1 AND id!=$obj_id ORDER BY publ_time DESC)  ");
        $sql_obj->execute();

        while($obj = $sql_obj->fetch(PDO::FETCH_LAZY)){
            //echo $obj['id'];
            //echo '<br>';
            include( PROJECT_ROOT.'/templates/objects/index/index_new.php');
        }

        ?>
    <?}else{?>
        <?
        $sql_obj = $pdo->prepare("SELECT id FROM c_industry WHERE complex_id=$complex_id AND deleted!=1 ORDER BY publ_time DESC");
        $sql_obj->execute();

        while($obj = $sql_obj->fetch(PDO::FETCH_LAZY)){
            //echo $obj['id'];
            //echo '<br>';
            include( PROJECT_ROOT.'/templates/objects/index/index_new.php');

        }

        ?>
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

    //для автооткрывания вкладки с предложением
    let obj_cards = document.getElementsByClassName('object-card');
    for(let i=0; i < obj_cards.length; i++){
        let tabs_parts = obj_cards[i].querySelectorAll('.obj-part');
        let tabs_content_parts = obj_cards[i].querySelectorAll('.obj-part-content');
        for(let j=0; j < tabs_parts.length; j++){
            if($(tabs_content_parts[j]).find('.offer-tab').hasClass('tab-active')){
                //console.log(obj_cards.length);
                $(tabs_parts[j]).addClass('tab-active');
                $(tabs_content_parts[j]).addClass('tab-content-active');
            }
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

<?if($logedUser->isAdmin() ){?>
    <div class="mixer-container">

        <div class="mixer-header box-small isBold">
            <div class="mixer-call">

            </div>
            <div class="flex-box">
                <div>
                    Создание торгового предложения
                </div>
                <div class="to-end icon-round pointer mixer-clear" title="Удалить выбранные">
                    <i class="fas fa-trash-alt"></i>
                </div>
            </div>
        </div>
        <div  class="mixer-content box-small">
            <?include_once PROJECT_ROOT.'/templates/mixer/wall/index.php'?>
        </div>
    </div>
    <style>
        .mixer-call {
            position: absolute;
            top: 0;
            left: -50px;
            width: 50px;
            height: 20px;
            background: red;
            cursor: pointer;
        }
        .mixer-container{
            width: 350px;
            height: 600px;
            background: #ffffff;

            border: 1px dashed grey;
            position: fixed;
            bottom: 0;
            right: -350px;
        }
        .mixer-content{
            overflow-y: scroll;
            height: 580px;

        }
        .mixer-header{
            background: #a0c1b8;
            color: #000000;
            position: relative;
        }
        .mixer-building{
            border-top: 2px solid #e1e1e1;
            margin-bottom: 20px;
        }
        .mixer-building-block{
            background: #eeeeee;
            border: 1px solid #b2b2b2;
            margin: 5px 0;
        }
    </style>
    <script>
        $('body').on('click','.mixer-call',function(){
            if($('.mixer-container').css('right') == '-350px'){
                $('.mixer-container').animate({
                    right: 0
                },500);
            }else{
                $('.mixer-container').animate({
                    right: -350
                },500);
            }

        });

        $('body').on('click','.block-check',function(){
            let complex_id= '<?=$complex->postId()?>';
            let part_id= $(this).attr('value');
            let pars = [];
            pars.push('complex_id='+complex_id);
            pars.push('part_id='+part_id);
            //alert(pars);
            sendAjaxRequestPost('<?=PROJECT_URL?>/system/controllers/mixer/add.php',pars,false);
            mixerReload(pars);
        });

        $('body').on('click','.mixer-clear',function(){
            let complex_id= '<?=$complex->postId()?>';
            let pars = [];
            pars.push('complex_id='+complex_id);
            mixerClear(pars);
            $('.accordion').find('input').removeAttr('checked');
        });

        function mixerClear(pars){
            document.querySelector('.mixer-content').innerHTML = '';
            sendAjaxRequestPost('<?=PROJECT_URL?>/system/controllers/mixer/clear.php',pars,false);
        }

        function mixerReload(pars){
            document.querySelector('.mixer-content').innerHTML =  sendAjaxRequestPost('<?=PROJECT_URL?>/templates/mixer/wall/index.php',pars,false);
        }

    </script>

    <script>
        $('body').on('click','.stack-block',function() {
            $('.stack-block').removeClass('highlight-frame-yellow');
            $('.floor-block').removeClass('highlight-frame-yellow');

            $(this).addClass('highlight-frame-yellow');
            //alert($(this).find('.blocks-parts-info'));

            let floor_parts = JSON.parse($(this).find('.parts-info').val());
            //alert(floor_parts);
            for(let i=0; i < floor_parts.length; i++){
                let id = '#subitem-'+floor_parts[i];
                $(id).addClass('highlight-frame-yellow');
            }



        });
    </script>
<?}?>


