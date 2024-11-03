<?include($_SERVER['DOCUMENT_ROOT'].'/templates/objects/header/index_new.php')?>
<div class="box-small object-card" style="border: 2px dashed #9E9E9E; margin-bottom: 20px; position: relative; background: #e8e8e8">


    <div style="">

        <div class="flex-box box-small"  style="position: absolute; z-index: 9; left: -5px; top: 0px;  background: #982e06; width: 140px; color: white">
            <div class="box-wide">

            </div>
            <div class="isBold">
                <b>ID <?=$object_id?></b>
            </div>
            <?if($logedUser->isAdmin()){?>
                <div class="box-wide pointer modal-call-btn" data-form="<?=($object->getField('is_land')) ? 'land' : 'building'?>" data-id="<?=$object->postId()?>" data-table="<?=$object->setTableId()?>" data-names='["redirect"]' data-values="[1]" data-modal="edit-all" data-modal-size="modal-big"   >
                    <span title="Редактировать"><i class="fas fa-pencil-alt"></i></span>
                </div>
            <?}?>
        </div>

        <div class="card-photo-area box-vertical" >
            <div class="flex-box flex-wrap files-grid">
                <? $i = 1;

                $obj_photos = $object->getJsonField('photo');
                $photo_num = 0;
                foreach($obj_photos as $thumb){?>
                    <?$photo = array_pop(explode('/',str_replace('//','/',$thumb)))?>
                    <div class="flex-box files-grid-unit">
                        <div class="flex-box modal-call-btn flex-around background-fix photo-container"  data-modal="photo-slider" data-names='["post_id","table_id","photo_field" ]' data-values='[<?=$object->postId()?>,<?=$object->setTableId()?>,"photo"]' data-table="1" data-id="<?=$thumb?>" data-modal-size="modal-big"   style=" background-image: url('<?//=PROJECT_URL.'/system/controllers/photos/thumb_all.php?width=300&photo='.PROJECT_URL.$thumb*/ ?><?=PROJECT_URL.'/system/controllers/photos/thumb.php/300/'.$object->postId().'/'.$photo ?>') " >
                            <?/*if($i > 14){?>
                                <div class="isBold" style="font-size: 30px; color: white; cursor: pointer; text-shadow: 1px 1px 2px black, 0 0 1em #000000;  ">
                                    +<?=(count($obj_photos) - $i)?>
                                    <!--+<?=$object->photoCount() - $i?>-->
                                </div>
                            <?}*/?>
                        </div>
                    </div>
                    <?$i++;
                }?>
                <?

                $videos = $object->getJsonField('videos');
                ?>
                <?if(arrayIsNotEmpty($videos) ){?>
                    <?foreach($videos as $video){?>
                        <div class="files-grid-unit">
                            <iframe width="100%" height="100%"  src="https://www.youtube.com/embed/<?=getYoutubeId($video)?>" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                        </div>
                    <?}?>
                <?}?>
            </div>
        </div>


        <div class="flex-box flex-vertical-top box-wide full-width">
            <div class="half box-small no-shrink" style="background: #ffffff">
                <div class="isBold" style="font-size: 20px;">
                    <?if(!$object->getField('is_land')){?>
                        <?=$object->getField('area_building')?> <span>м <sup>2</sup></span>
                    <?}else{?>
                        <?=$object->getField('area_field_full')?> <span>м <sup>2</sup></span>
                    <?}?>
                </div>
                <div class="box-small-vertical">
                    <?=$object->getField('address')?>
                </div>
                <div>
                    <ul>
                        <?if(arrayIsNotEmpty($object->purposes())){?>
                            <?foreach($object->purposes() as $purpose){?>
                                <?
                                $purpose = new Post((int)$purpose);
                                $purpose->getTable('l_purposes');
                                ?>
                                <li class="icon-square">
                                    <a href="#" title="<?=$purpose->title()?>"><?=$purpose->getField('icon')?></a>
                                </li>
                            <?}?>
                        <?}?>
                    </ul>
                </div>
                <div class="flex-box flex-wrap box-small-vertical">
                    <?if($object->getField('is_land') != 1){?>
                        <div class="box-small ghost isBold text_center" style="border: 2px solid lightgray; width: 150px">
                            <i class="fas fa-arrows-alt-v"></i>
                            <?= valuesCompare($object->getObjectBlocksMinValue('ceiling_height_min'),$object->getObjectBlocksMaxValue('ceiling_height_max')) ?> метров
                        </div>
                    <?}?>
                    <?if($object->getField('is_land') != 1){?>
                        <div class="box-small ghost isBold text_center" style="border: 2px solid lightgray; width: 150px">
                            <i class="fad fa-road"></i>
                            Антипыль
                        </div>
                    <?}?>
                    <?if($object->getField('is_land') != 1){?>
                        <div class="box-small ghost isBold text_center" style="border: 2px solid lightgray; width: 150px">
                            <i class="fas fa-bolt"></i>
                            <?= ($object->getField('power')) ?>
                        </div>
                    <?}?>
                    <?if($object->getField('is_land') != 1){?>
                        <div class="box-small ghost isBold text_center" style="border: 2px solid lightgray; width: 150px">
                            <i class="fas fa-temperature-hot"></i>
                            Отопление
                        </div>
                    <?}?>
                    <?if($object->getField('is_land') != 1){?>
                        <div class="box-small ghost isBold text_center" style="border: 2px solid lightgray; width: 150px">
                            <i class="fas fa-burn"></i>
                            Газ
                        </div>
                    <?}?>
                    <?if($object->getField('is_land') != 1){?>
                        <div class="box-small ghost isBold text_center" style="border: 2px solid lightgray; width: 150px">
                            <i class="fas fa-parking"></i>
                            Парковка
                        </div>
                    <?}?>
                    <?if($object->getField('is_land') != 1){?>
                        <div class="box-small ghost isBold text_center" style="border: 2px solid lightgray; width: 150px">
                            <i class="fas fa-truck-loading"></i>
                            Кран-балка
                        </div>
                    <?}?>
                    <?if($object->getField('is_land') != 1){?>
                        <div class="box-small ghost isBold text_center" style="border: 2px solid lightgray; width: 150px">
                            <i class="fas fa-dungeon"></i>
                            8 ворот
                        </div>
                    <?}?>
                </div>
            </div>
            <div class="one_fourth box " >
                <?if($logedUser->isAdmin()){?>
                    <div>
                        <div class="flex-box flex-wrap" >
                            <?

                            $floors_exist = $object->getJsonField('floors_building');
                            ?>
                            <?foreach($floors_exist as $floor){?>
                                <?
                                $floor_obj = new Post($floor);
                                $floor_obj->getTable('l_floor_nums');
                                ?>
                                <?if(in_array($floor_obj->getField('title'),$object->getFloorsTitle())){?>
                                    <div class="icon-orthogonal"  title="Этаж уже добавлен" style="background: #ffffff; border: 1px solid green">
                                        <?
                                        $floor_obj = new Post($floor);
                                        $floor_obj->getTable('l_floor_nums');
                                        echo $floor_obj->getField('title');
                                        ?>
                                    </div>
                                <?}else{?>
                                    <div class=" modal-call-btn icon-orthogonal " style="background: #ffffff; color: red; border: 1px solid green"  title="Добавить этаж" data-form="" data-id=""  data-table="<?=(new Floor())->setTableId()?>" data-names='["redirect","object_id","floor_num_id"]' data-values="[1,<?=$object->postId()?>,<?=$floor?>]" data-modal="edit-all" data-modal-size="modal-middle" >
                                        +
                                        <?
                                        $floor_obj = new Post($floor);
                                        $floor_obj->getTable('l_floor_nums');
                                        echo $floor_obj->getField('title');
                                        ?>
                                    </div>
                                <?}?>
                            <?}?>
                        </div>
                    </div>
                <?}?>
            </div>
            <div class="one_fourth no-shrink">
                <div class="card-contacts-area-inner flex-box box text_left flex-box-verical flex-between flex-box-to-left" style="background: #e6eedd;">
                    <? $owners = $object->getJsonField('owners')?>
                    <?foreach($owners as $owner){?>
                        <?$company = new Company($owner ); ?>
                        <div>
                            <?if($company->getField('company_group_id')){?>
                                <div>
                                    <b>
                                        <?
                                        $company_group = new Post($company->getField('company_group_id'));
                                        $company_group->getTable('c_industry_companies_groups');
                                        ?>
                                        <?=$company_group->title()?>
                                    </b>
                                </div>
                            <?}?>
                            <div>
                                <a href="/company/<?=$company->postId()?>" target="_blank">
                                    <?if($company->postId() == $company->title()){?>
                                        <span class="attention ">NONAME <?=$company->postId()?></span>
                                    <?}else{?>
                                        <?=$company->title()?>
                                    <?}?>
                                </a>
                            </div>
                            <?if($company->getField('company_group_id')){?>
                                <div class="ghost">
                                    <?=(new CompanyGroup($company->getField('company_group_id')))->title()?>
                                </div>
                            <?}?>
                            <?if($company->getField('rating')){?>
                                <div class="ghost">
                                    тут рейтинг
                                </div>
                            <?}?>
                            <div class="flex-box flex-wrap">
                                <?if(count($company->getCompanyContacts())){?>
                                    <div class="underlined pointer">
                                        контакты (<?=(count($company->getCompanyContacts()))?>) ,
                                    </div>
                                <?}?>
                                <?if(count($company->getCompanyRequests())){?>
                                    <div class="underlined pointer">
                                        запросы (<?=(count($company->getCompanyRequests()))?>),
                                    </div>
                                <?}?>
                                <?if(count($company->getCompanyObjects())){?>
                                    <div class="underlined pointer">
                                        объекты (<?=(count($company->getCompanyObjects()))?>)
                                    </div>
                                <?}?>
                            </div>
                            <div>
                                &#160;
                            </div>
                        </div>
                    <?}?>
                </div>
            </div>
        </div>

        <div class="object-info-sections" >

            <div class="tabs-block tabs-active-free">
                <div class="tabs flex-box">
                    <div class="tab box-small obj-part" id="<?=$object->postId()?>.1">
                        Характеристики
                    </div>
                    <div class="tab box-small obj-part">
                        Сделки
                    </div>
                    <div class="tab box-small obj-part">
                        Планировки
                    </div>
                    <div class="tab box-small obj-part">
                        Презентации
                    </div>
                    <div class="tab box-small obj-part">
                        Договора
                    </div>
                    <div class="tab box-small obj-part">
                        Документы
                    </div>
                    <div class="tab box-small obj-part">
                        Панорамы
                    </div>
                    <div class="tab box-small obj-part">
                        Описание
                    </div>
                </div>
                <div class="tabs-content tabs-content-overline" style="background: #ffffff">
                    <div class="tab-content obj-part-content" >
                        <div class="full-width object-stats-block " >
                            <div class="flex-box flex-vertical-top full-width">
                                <div class="object-about-section object-params-list col-1 one-fourth-flex box-small">
                                    <div class="box"><b>Основное</b></div>
                                    <ul>
                                        <?if(!$object->getField('is_land')){?>
                                            <li>
                                                <div>
                                                    Общая площадь
                                                </div>
                                                <div>
                                                    <?=$object->showObjectStat('area_building' , '<span class="degree-fix">м<sup>2</sup></span>' , '-') ?>
                                                </div>
                                            </li>
                                            <li>
                                                <div>
                                                    S - пола
                                                </div>
                                                <div>
                                                    <?=$object->showObjectStat('area_floor_full' , '<span class="degree-fix">м<sup>2</sup></span>' , '-') ?>
                                                </div>
                                            </li>
                                            <li>
                                                <div>
                                                    S - мезонина
                                                </div>
                                                <div>
                                                    <?=$object->showObjectStat('area_mezzanine_full' , '<span class="degree-fix">м<sup>2</sup></span>' , '-') ?>
                                                </div>
                                            </li>
                                            <li>
                                                <div>
                                                    S - офисов
                                                </div>
                                                <div>
                                                    <?=$object->showObjectStat('area_office_full' , '<span class="degree-fix">м<sup>2</sup></span>' , '-') ?>
                                                </div>
                                            </li>
                                            <li>
                                                <div>
                                                    S - техническая
                                                </div>
                                                <div>
                                                    <?=$object->showObjectStat('area_tech_full' , '<span class="degree-fix">м<sup>2</sup></span>' , '-') ?>
                                                </div>
                                            </li>
                                            <li>
                                                <div>
                                                    Этажность склада
                                                </div>
                                                <div>
                                                    <?= $object->showObjectStat('floors' , '<span class="degree-fix">этаж(а)</span>' , '-') ?>
                                                </div>
                                            </li>
                                            <li>
                                                <div>
                                                    Класс объекта
                                                </div>
                                                <div>
                                                    <?if($object->classType()){?>
                                                        <?=$object->classType()?>
                                                    <?}else{?>
                                                        -
                                                    <?}?>
                                                </div>
                                            </li>
                                            <li>
                                                <div>
                                                    Внешняя отделка
                                                </div>
                                                <div>
                                                    <?if($object->facingType()){?>
                                                        <?=$object->facingType()?>
                                                    <?}else{?>
                                                        -
                                                    <?}?>
                                                </div>
                                            </li>
                                            <li>
                                                <div>
                                                    Год постройки
                                                </div>
                                                <div>
                                                    <?=$object->showObjectStat('year_build' , '<span class="degree-fix">год</span>' , '-') ?>
                                                </div>
                                            </li>
                                            <li>
                                                <div>
                                                    Год последнего ремонта
                                                </div>
                                                <div>
                                                    <?=$object->showObjectStat('year_repair' , '<span class="degree-fix">год</span>' , '-') ?>
                                                </div>
                                            </li>
                                        <?}?>
                                        <li>
                                            <div>
                                                Площадь участка
                                            </div>
                                            <div>
                                                <?=$object->showObjectStat('area_field_full' , '<span class="degree-fix">м<sup>2</sup></span>' , '-') ?>
                                            </div>
                                        </li>
                                        <li>
                                            <div>
                                                Габариты участка
                                            </div>
                                            <div>
                                                <?if($object->getField('land_length') && $object->getField('land_width')){?>
                                                    <?=$object->getField('land_length')?> x <?=$object->getField('land_width')?> м
                                                <?}else{?>
                                                    -
                                                <?}?>
                                            </div>
                                        </li>
                                        <?if(!$object->getField('is_land')){?>
                                            <li>
                                                <div>
                                                    Правовой статус строения
                                                </div>
                                                <div>
                                                    <?if($object->getObjectOwnLawType()){?>
                                                        <?=$object->getObjectOwnLawType()?>
                                                    <?}else{?>
                                                        -
                                                    <?}?>
                                                </div>
                                            </li>
                                        <?}?>
                                        <?if(!$object->getField('is_land')){?>
                                            <li>
                                                <div>
                                                    Кадастровый №
                                                </div>
                                                <div>
                                                    <?= $object->getField('cadastral_number') ? $object->getField('cadastral_number') : '-' ?>
                                                </div>
                                            </li>
                                        <?}?>
                                        <?if($object->getField('is_land')){?>
                                            <li>
                                                <div>
                                                    Кадастровый № участка
                                                </div>
                                                <div>
                                                    <?= $object->getField('cadastral_number_land') ? $object->getField('cadastral_number_land') : '-' ?>
                                                </div>
                                            </li>
                                        <?}?>
                                        <li>
                                            <div>
                                                Правовой статус зем. уч.
                                            </div>
                                            <div>
                                                <?if($object->getObjectOwnLawTypeLand()){?>
                                                    <?=$object->getObjectOwnLawTypeLand()?>
                                                <?}else{?>
                                                    -
                                                <?}?>
                                            </div>
                                        </li>
                                        <li>
                                            <div>
                                                Категория земли
                                            </div>
                                            <div>
                                                <?if($object->getObjectCategoryLand()){?>
                                                    <?=$object->getObjectCategoryLand()?>
                                                <?}else{?>
                                                    -
                                                <?}?>
                                            </div>
                                        </li>
                                        <li>
                                            <div>
                                                Рельеф участка
                                            </div>
                                            <div>
                                                <?if($object->getField('landscape_type')){?>
                                                    <?$landscape = new Post($object->getField('landscape_type'))?>
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
                                                <?if($object->getField('land_use_restrictions')){?>
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
                                                <?=$object->showObjectStat('power' , '<span>кВт</span>' , '-') ?>
                                            </div>
                                        </li>
                                        <?if(!$object->getField('is_land')){?>
                                            <li>
                                                <div>
                                                    Отопление
                                                </div>
                                                <div>
                                                    <?if($object->heatType()){?>
                                                        <?=$object->heatType()?>
                                                    <?}else{?>
                                                        -
                                                    <?}?>
                                                </div>
                                            </li>
                                        <?}?>
                                        <li>
                                            <div>
                                                Водоснабжение
                                            </div>
                                            <div>
                                                <?if($object->waterType()){?>
                                                    <?=$object->waterType()?>
                                                <?}else{?>
                                                    -
                                                <?}?>
                                            </div>
                                        </li>
                                        <li>
                                            <div>
                                                Городская канализация
                                            </div>
                                            <div>
                                                <?= ($object->getField('sewage_central')) ? 'есть' : '-'?>
                                            </div>
                                        </li>
                                        <li>
                                            <div>
                                                Ливневая канализация
                                            </div>
                                            <div>
                                                <?= ($object->getField('sewage_rain')) ? 'есть' : '-'?>
                                            </div>
                                        </li>
                                        <?if(!$object->getField('is_land')){?>
                                            <li>
                                                <div>
                                                    Вентиляция
                                                </div>
                                                <div>
                                                    <?= ($object->getField('ventilation')) ? $object->ventilationType() : '-'?>
                                                </div>
                                            </li>
                                        <?}?>
                                        <li>
                                            <div>
                                                Газ
                                            </div>
                                            <div>
                                                <?= ($object->getField('gas')) ? 'есть' : '-'?>
                                                <?=$object->showObjectStat('gas_value' , '<span class="degree-fix">м<sup>3</sup>/час</span>' , '') ?>
                                            </div>
                                        </li>
                                        <?if(!$object->getField('is_land')){?>
                                            <li>
                                                <div>
                                                    Пар
                                                </div>
                                                <div>
                                                    <?= ($object->getField('steam')) ? 'есть' : '-'?>
                                                    <?=$object->showObjectStat('steam_value' , '<span>бар</span>' , '') ?>
                                                </div>
                                            </li>
                                        <?}?>
                                        <li>
                                            <div>
                                                Телефония
                                            </div>
                                            <div>
                                                <?= ($object->getField('phone_line')) ? 'есть' : '-'?>
                                            </div>
                                        </li>
                                        <li>
                                            <div>
                                                Интернет
                                            </div>
                                            <div>
                                                <?= ($object->getField('internet_type')) ? $object->internetType() : '-'?>
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
                                                <?if($object->guardType()){?>
                                                    <?=$object->guardType()?>
                                                <?}else{?>
                                                    -
                                                <?}?>
                                            </div>
                                        </li>
                                        <?if(!$object->getField('is_land')){?>
                                            <li>
                                                <div>
                                                    Пожаротушение
                                                </div>
                                                <div>
                                                    <?if($object->firefightingType()){?>
                                                        <?=$object->firefightingType()?>
                                                    <?}else{?>
                                                        -
                                                    <?}?>
                                                </div>
                                            </li>
                                        <?}?>
                                        <li>
                                            <div>
                                                Видеонаблюдение
                                            </div>
                                            <div>
                                                <?= ($object->getField('video_control')) ? 'есть' : '-'?>
                                            </div>
                                        </li>
                                        <li>
                                            <div>
                                                Контроль доступа
                                            </div>
                                            <div>
                                                <?= ($object->getField('access_control')) ? 'есть' : '-'?>
                                            </div>
                                        </li>
                                        <?if(!$object->getField('is_land')){?>
                                            <li>
                                                <div>
                                                    Охранная сигнализация
                                                </div>
                                                <div>
                                                    <?= ($object->getField('security_alert')) ? 'есть' : '-'?>
                                                </div>
                                            </li>
                                            <li>
                                                <div>
                                                    Пожарная сигнализация
                                                </div>
                                                <div>
                                                    <?= ($object->getField('fire_alert')) ? 'есть' : '-'?>
                                                </div>
                                            </li>
                                            <li>
                                                <div>
                                                    Дымоудаление
                                                </div>
                                                <div>
                                                    <?= ($object->getField('smoke_exhaust')) ? 'есть' : '-'?>
                                                </div>
                                            </li>
                                        <?}?>
                                        <li>
                                            <div>
                                                Шлагбаум
                                            </div>
                                            <div>
                                                <?= ($object->getField('barrier')) ? 'есть' : '-'?>
                                            </div>
                                        </li>
                                        <li>
                                            <div>
                                                Забор по периметру
                                            </div>
                                            <div>
                                                <?= ($object->getField('fence')) ? 'есть' : '-'?>
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
                                            $items = $object->getJsonField($key);
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
                                                <?=($object->getField('railway')) ? 'есть' : '-'?>
                                                <?=$object->showObjectStat('railway_value' , '<span>м</span>' , '') ?>
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
                                                <?if($object->getField('entry_territory')){?>
                                                    <?=$object->entranceType()?>
                                                <?}else{?>
                                                    <span>не указано</span>
                                                <?}?>
                                            </div>
                                        </li>
                                        <?if(!$object->getField('is_land')){?>
                                            <li>
                                                <div>
                                                    &#171;P&#187; легковая
                                                </div>
                                                <div>
                                                    <?=($object->getField('parking_car')) ? 'есть' : '-'?>
                                                    <?if($object->getField('parking_car_value')){?>
                                                        <?
                                                        $car_parking_type = new Post($object->getField('parking_car_value'));
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
                                                    <?=($object->getField('parking_lorry')) ? 'есть' : '-'?>
                                                    <?if($object->getField('parking_lorry_value') != NULL){?>
                                                        <?
                                                        $car_parking_type = new Post($object->getField('parking_lorry_value'));
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
                                                    <?=($object->getField('parking_truck')) ? 'есть' : '-'?>
                                                    <?if($object->getField('parking_truck_value')){?>
                                                        <?
                                                        $car_parking_type = new Post($object->getField('parking_truck_value'));
                                                        $car_parking_type->getTable('l_parking_type');
                                                        ?>
                                                        <?= ', '.$car_parking_type->title()?>
                                                    <?}?>
                                                </div>
                                            </li>
                                        <?}?>
                                        <li>
                                            <div>
                                                Столовая/кафе
                                            </div>
                                            <div>
                                                <?= ($object->getField('canteen')) ? 'есть' : '-'?>
                                            </div>
                                        </li>
                                        <li>
                                            <div>
                                                Общежитие
                                            </div>
                                            <div>
                                                <?= ($object->getField('hostel')) ? 'есть' : '-'?>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="box-small full-width" >
                                <div class="box-small" style="background: #f4f4f4;">
                                    <span class="ghost">В.Р.И. :</span>  <?=$object->getField('field_allow_usage')?>
                                </div>
                            </div>
                        </div>
                        <div  class="flex-box flex-center box full-width object-stats-toggle" title="Развернуть основные характеристики">
                            <div class="icon-round">
                                <i class="fas fa-angle-up"></i>
                            </div>
                        </div>
                    </div>
                    <div class="tab-content obj-part-content">
                        <div class="card-body">
                            <div id="offers"></div>
                            <div class="tabs-block ">
                                <?$offers_all = $object->getObjectOffersId();?>
                                <?$offers =[]?>
                                <?foreach($offers_all as $offer_item) {
                                    $offers[] = (int)$offer_item;
                                }?>
                                <div class="tabs flex-box">
                                    <?foreach($offers as $offer_item){?>
                                        <?$offer = new Offer($offer_item)?>

                                        <? $tabs = json_decode($_GET['offer_id'])?>
                                        <div row-ids='<?=json_encode($offers)?>' id="<?=$offer->postId()?>" class="tab offer-tab <?=(in_array($offer_item, $tabs)) ? 'tab-active' :''?> ">

                                            <div class="offer-header box-small text_left" style="background: #f3f3f3">
                                                <?/*<a href="?offer_id=<?=$offer_item?>#offers">*/?>
                                                <div class="flex-box">
                                                    <div>
                                                        <? $deal_sign = preg_split('//u',$offer->getOfferDealType(),-1,PREG_SPLIT_NO_EMPTY)[0]?>
                                                        <?=$offer->getOfferDealType()?> <?=$object->itemId()?>-<?=$deal_sign?>
                                                    </div>
                                                    <div class="to-end">
                                                        <i class="fas fa-check"></i>
                                                    </div>
                                                </div>
                                                <div>
                                                    <?if($offer->getField('company_id')){?>
                                                        <?$company = new Company($offer->getField('company_id'))?>
                                                        <?=$company->title()?>
                                                    <?}else{?>
                                                        -
                                                    <?}?>
                                                </div>
                                                <div>
                                                    <b>
                                                        <?if($offer->getOfferBlocksMinValue('area_floor_min')){?>
                                                            <?= valuesCompare($offer->getOfferSumAreaMin(), $offer->getOfferSumAreaMax())?> м<sup>2</sup>
                                                        <?}else{?>
                                                            -
                                                        <?}?>

                                                        <?if($offer->getField('deal_type') == 3 ){?>
                                                            / <?= valuesCompare($offer->getOfferBlocksMinValue('pallet_place_min'), $offer->getOfferBlocksMaxSumValue('pallet_place_max'))?> п. м.
                                                        <?}?>
                                                    </b>
                                                </div>
                                                <?/*</a>*/?>
                                            </div>
                                        </div>
                                    <?}?>



                                    <?if($logedUser->isAdmin()){?>
                                        <div class="box-small">
                                            <div class=" text_left pointer ">
                                                <div class="" style="border: 1px  solid grey">
                                                    <ul>
                                                        <li>
                                                            <div class=" modal-call-btn" data-form="<?=$deal_forms_offers_arr[$object->getField('is_land')][0]?>" data-id=""  data-table="<?=(new Offer(0))->setTableId()?>"  data-show-name="company_id" data-modal="edit-all" data-modal-size="modal-small" data-names='["object_id","deal_type"]'   data-values='[<?=$object->getField('id')?>,1]'>
                                                                Аренда <i class="fas fa-plus-circle"></i>
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <div class=" modal-call-btn" data-form="<?=$deal_forms_offers_arr[$object->getField('is_land')][1]?>" data-id=""  data-table="<?=(new Offer(0))->setTableId()?>"  data-show-name="company_id" data-modal="edit-all" data-modal-size="modal-small" data-names='["object_id","deal_type"]' data-values='[<?=$object->getField('id')?>,2]'>
                                                                Продажа <i class="fas fa-plus-circle"></i>
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <div class=" modal-call-btn" data-form="<?=$deal_forms_offers_arr[$object->getField('is_land')][2]?>" data-id=""  data-table="<?=(new Offer(0))->setTableId()?>"   data-show-name="company_id" data-modal="edit-all" data-modal-size="modal-small" data-names='["object_id","deal_type"]' data-values='[<?=$object->getField('id')?>,3]'>
                                                                Ответ хранение <i class="fas fa-plus-circle"></i>
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <div class=" modal-call-btn" data-form="<?=$deal_forms_offers_arr[$object->getField('is_land')][3]?>" data-id=""  data-table="<?=(new Offer(0))->setTableId()?>"  data-show-name="company_id" data-modal="edit-all" data-modal-size="modal-small" data-names='["object_id","deal_type"]' data-values='[<?=$object->getField('id')?>,4]'>
                                                                Субаренда <i class="fas fa-plus-circle"></i>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    <?}?>
                                </div>
                                <div class="tabs-content">
                                    <?foreach($offers as $offer_item){?>
                                        <?$offer = new Offer($offer_item)?>

                                        <div class="tab-content offer-tab-content <?=(in_array($offer_item,$tabs)) ? 'tab-content-active' :''?>">
                                            <div class="offer_container full-width box-wide">
                                                <div class="offer-summary flex-box flex-wrap flex-vertical-top full-width  " style="background: #ffffff">
                                                    <div class="half text_left one-third-flex  box">
                                                        <div class="flex-box box">
                                                            <div>
                                                                <h1 style="line-height: 35px;">
                                                                    <?= $offer->showOfferCalcStat(valuesCompare(numFormat($offer->getOfferSumAreaMin()), numFormat($offer->getOfferSumAreaMax())), '<span style="line-height: 20px;">м<sup style="font-size: 15px;">2</sup></span>', '-')?>
                                                                </h1>
                                                            </div>
                                                            <?if($offer->getField('built_to_suit')){?>
                                                                <div class="box-wide isBold" style="color: red;">
                                                                    <div class="flex-box">
                                                                        <div>
                                                                            BTS
                                                                        </div>
                                                                        <?if($offer->getField('built_to_suit_time')){?>
                                                                            <div>
                                                                                / <?=$offer->getField('built_to_suit_time')?> мес
                                                                            </div>
                                                                        <?}?>
                                                                    </div>
                                                                    <?if($offer->getField('built_to_suit_plan')){?>
                                                                        <div>
                                                                            проект имеется
                                                                        </div>
                                                                    <?}?>
                                                                </div>
                                                            <?}?>
                                                        </div>
                                                        <div class="object-params-list">
                                                            <ul>
                                                                <?if(!$object->getField('is_land')){?>
                                                                    <li>
                                                                        <div>
                                                                            S - пола
                                                                        </div>
                                                                        <div>
                                                                            <?= $offer->showOfferCalcStat(valuesCompare($offer->getOfferBlocksMinValue('area_floor_min'), $offer->getOfferBlocksMaxSumValue('area_floor_max')), '<span class="ghost">м<sup>2</sup></span>', '-')?>
                                                                        </div>
                                                                    </li>
                                                                    <li>
                                                                        <div>
                                                                            S - мезонина
                                                                        </div>
                                                                        <div>
                                                                            <?= $offer->showOfferCalcStat(valuesCompare($offer->getOfferBlocksMinValue('area_mezzanine_min'), $offer->getOfferBlocksMaxSumValue('area_mezzanine_max')), '<span class="ghost">м<sup>2</sup></span>', '-')?>
                                                                        </div>
                                                                    </li>
                                                                    <li>
                                                                        <div>
                                                                            S - офисов
                                                                        </div>
                                                                        <div>
                                                                            <?= $offer->showOfferCalcStat(valuesCompare($offer->getOfferBlocksMinValue('area_office_min'), $offer->getOfferBlocksMaxSumValue('area_office_max')), '<span class="ghost">м<sup>2</sup></span>', '-')?>
                                                                        </div>
                                                                    </li>
                                                                    <li>
                                                                        <div>
                                                                            S - уличная
                                                                        </div>
                                                                        <div>
                                                                            <?= $offer->showOfferCalcStat(valuesCompare($offer->getOfferBlocksMinValue('area_field_min'), $offer->getOfferBlocksMaxSumValue('area_field_max')), '<span class="ghost">м<sup>2</sup></span>', '-')?>
                                                                        </div>
                                                                    </li>
                                                                    <li>
                                                                        <div>
                                                                            S - техническая
                                                                        </div>
                                                                        <div>
                                                                            <?= $offer->showOfferCalcStat(valuesCompare($offer->getOfferBlocksMinValue('area_tech_min'), $offer->getOfferBlocksMaxSumValue('area_tech_max')), '<span class="ghost">м<sup>2</sup></span>', '-')?>
                                                                        </div>
                                                                    </li>
                                                                    <li>
                                                                        <div>
                                                                            Кол-во палет-мест
                                                                        </div>
                                                                        <div>
                                                                            <?= $offer->showOfferCalcStat(valuesCompare($offer->getOfferBlocksMinValue('pallet_place_min'), $offer->getOfferBlocksMaxSumValue('pallet_place_max')), '<span class="ghost">п.м.</span>', '-')?>
                                                                        </div>
                                                                    </li>
                                                                    <li>
                                                                        <div>
                                                                            Стеллажи
                                                                        </div>
                                                                        <div>
                                                                            <?$racks = $offer->getOfferBlocksMaxSumValue('racks')?>
                                                                            <?=($racks) ? 'есть' : '-' ?> <?=($racks && (($racks/$offer->subItemsCount()) < 1)) ? ', частично' : ''?>
                                                                        </div>
                                                                    </li>
                                                                    <li>
                                                                        <div>
                                                                            Типы стеллажей
                                                                        </div>
                                                                        <div>
                                                                            <?$racks_types = []?>
                                                                            <?foreach($offer->getOfferBlocksValues('rack_types') as $item){?>
                                                                                <?foreach(json_decode($item) as $type){?>
                                                                                    <?if(!in_array($type,$racks_types)){?>
                                                                                        <?array_push($racks_types,$type) ?>
                                                                                    <?}?>
                                                                                <?}?>
                                                                            <?}?>
                                                                            <?if($racks_types) {?>
                                                                                <?foreach($racks_types  as $type){?>
                                                                                    <? $rack = new Post($type)?>
                                                                                    <? $rack->getTable('l_racks_types')?>
                                                                                    <?=$rack->title()?>
                                                                                <?}?>
                                                                            <?}else{?>
                                                                                -
                                                                            <?}?>
                                                                        </div>
                                                                    </li>
                                                                    <li>
                                                                        <div>
                                                                            Типы хранения
                                                                        </div>
                                                                        <div>
                                                                            <?$safe_types = []?>
                                                                            <?foreach($offer->getOfferBlocksValues('safe_type') as $item){?>
                                                                                <?foreach(json_decode($item) as $type){?>
                                                                                    <?if(!in_array($type,$safe_types)){?>
                                                                                        <?array_push($safe_types,$type) ?>
                                                                                    <?}?>
                                                                                <?}?>
                                                                            <?}?>
                                                                            <?if($safe_types) {?>
                                                                                <?foreach($safe_types  as $type){?>
                                                                                    <? $safe_type = new Post($type)?>
                                                                                    <? $safe_type->getTable('l_safe_types')?>
                                                                                    <?=$safe_type->title()?>
                                                                                <?}?>
                                                                            <?}else{?>
                                                                                -
                                                                            <?}?>
                                                                        </div>
                                                                    </li>
                                                                    <li>
                                                                        <div>
                                                                            Ячейки
                                                                        </div>
                                                                        <div>
                                                                            <?$cells = $offer->getOfferBlocksMaxSumValue('cells')?>
                                                                            <?=($cells) ? 'есть' : '-' ?> <?=($cells && (($cells/$offer->subItemsActiveCount()) < 1)) ? ', частично' : ''?>
                                                                        </div>
                                                                    </li>
                                                                    <li>
                                                                        <div>
                                                                            Высота, рабочая
                                                                        </div>
                                                                        <div>
                                                                            <?= $offer->showOfferCalcStat(valuesCompare($offer->getOfferBlocksMinValue('ceiling_height_min'), $offer->getOfferBlocksMaxValue('ceiling_height_max')), '<span>м</span>', '-')?>
                                                                        </div>
                                                                    </li>

                                                                    <?
                                                                    $gates = $offer->getOfferBlocksValues('gates');
                                                                    $gate_types = [];
                                                                    $gate_amount = [];
                                                                    $glued_arr = [];
                                                                    $calculated_arr = [];
                                                                    foreach($gates as $gate){
                                                                        $block_gates = json_decode($gate);
                                                                        $glued_arr = array_merge($glued_arr,$block_gates);
                                                                        for($i = 0; $i < count($block_gates); $i = $i+2) {
                                                                            if (!in_array($block_gates[$i], $gate_types) && $block_gates[$i]!=0) {
                                                                                array_push($gate_types, $block_gates[$i]);
                                                                            }
                                                                            array_push($gate_amount, $block_gates[$i+1]);
                                                                        }
                                                                    }
                                                                    //var_dump($glued_arr);

                                                                    //подсчитываем колво ворот каждого типа
                                                                    foreach($gate_types as $elem_unique){
                                                                        for($i = 0; $i < count($glued_arr); $i = $i+2) {
                                                                            if ($glued_arr[$i] == $elem_unique) {
                                                                                $calculated_arr[$elem_unique] += $glued_arr[$i+1];
                                                                            }
                                                                        }
                                                                    }
                                                                    //var_dump($calculated_arr);

                                                                    ?>
                                                                    <li>
                                                                        <div>
                                                                            Тип/кол-во ворот
                                                                        </div>
                                                                        <div>
                                                                            <?if($calculated_arr){?>
                                                                                <?foreach($calculated_arr as $key=>$value){
                                                                                    $gate = new Post($key);
                                                                                    $gate->getTable('l_gates_types');
                                                                                    ?>
                                                                                    <div class="flex-box">
                                                                                        <div><?=$value?> шт </div>/<div  class="box-wide"> <?=$gate->title()?></div>
                                                                                    </div>
                                                                                <?}?>
                                                                            <?}else{?>
                                                                                -
                                                                            <?}?>
                                                                        </div>
                                                                    </li>
                                                                    <li>
                                                                        <div>
                                                                            Кросс-докинг
                                                                        </div>
                                                                        <div>
                                                                            <?$cross = $offer->getOfferBlocksMaxSumValue('enterance_block')?>
                                                                            <?=($cross) ? 'есть' : '-' ?> <?=($cross && (($cross/$offer->subItemsActiveCount()) < 1)) ? ', частично' : ''?>
                                                                        </div>
                                                                    </li>
                                                                    <li>
                                                                        <div>
                                                                            Тип пола
                                                                        </div>
                                                                        <div>
                                                                            <?$grids = $offer->getOfferBlocksValuesUnique('floor_type');?>
                                                                            <?if(count($grids)){?>
                                                                                <?foreach($grids as $grid){
                                                                                    $grid = new Post($grid);
                                                                                    $grid->getTable('l_floor_types');
                                                                                    ?>
                                                                                    <?=$grid->title()?> ,
                                                                                <?}?>
                                                                            <?}else{?>
                                                                                -
                                                                            <?}?>
                                                                        </div>
                                                                    </li>
                                                                    <li>
                                                                        <div>
                                                                            Нагрузка на пол
                                                                        </div>
                                                                        <div>
                                                                            <?= $offer->showOfferCalcStat(valuesCompare($offer->getOfferBlocksMinValue('load_floor'), $offer->getOfferBlocksMaxValue('load_floor')), '<span>т/м<sup>2</sup></span>', '-')?>
                                                                        </div>
                                                                    </li>
                                                                    <li>
                                                                        <div>
                                                                            Нагрузка на мезонин
                                                                        </div>
                                                                        <div>
                                                                            <?= $offer->showOfferCalcStat(valuesCompare($offer->getOfferBlocksMinValue('load_mezzanine'), $offer->getOfferBlocksMaxValue('load_mezzanine')), '<span>т/м<sup>2</sup></span>', '-')?>
                                                                        </div>
                                                                    </li>
                                                                    <li>
                                                                        <div>
                                                                            Шаг колонн
                                                                        </div>
                                                                        <div>
                                                                            <?$grids = $offer->getOfferBlocksValuesUnique('column_grid');?>
                                                                            <?if(count($grids)){?>
                                                                                <?foreach($grids as $grid){
                                                                                    $grid = new Post($grid);
                                                                                    $grid->getTable('l_pillars_grid');
                                                                                    ?>
                                                                                    <?=$grid->title()?> ,
                                                                                <?}?>
                                                                            <?}else{?>
                                                                                -
                                                                            <?}?>
                                                                        </div>
                                                                    </li>
                                                                    <li>
                                                                        <div>
                                                                            Мощность
                                                                        </div>
                                                                        <div>
                                                                            <?if($power_offer = $offer->getOfferBlocksMaxSumValue('power')){?>
                                                                                <?=$power_offer?> кВт
                                                                            <?}else{?>
                                                                                -
                                                                            <?}?>
                                                                        </div>
                                                                    </li>
                                                                    <li>
                                                                        <div>
                                                                            Температурный режим
                                                                        </div>
                                                                        <div>
                                                                            <?if($temp_min = $offer->getOfferBlocksMinValue('temperature_min')){?>
                                                                                <?=($temp_min > 0) ? '+' : ''?>
                                                                                <?=$temp_min?>
                                                                            <?}?>
                                                                            <?if($temp_max = $offer->getOfferBlocksMaxValue('temperature_max')){?>
                                                                                /
                                                                                <?=($temp_max > 0) ? '+' : ''?>
                                                                                <?=$temp_max?>
                                                                            <?}?>
                                                                            <?//= valuesCompare($offer->getOfferBlocksMinValue('temperature_min'), $offer->getOfferBlocksMaxValue('temperature_max'))?> <span>градусов</span>
                                                                        </div>
                                                                    </li>
                                                                    <li>
                                                                        <?
                                                                        $elevators = $offer->getOfferBlocksValues('elevators');
                                                                        $elevators_types = [];
                                                                        $elevators_amount = [];
                                                                        foreach($elevators as $elevator){
                                                                            $block_elevators = json_decode($elevator);
                                                                            for($i = 0; $i < count($block_elevators); $i = $i+2) {
                                                                                if (!in_array($block_elevators[$i+1], $elevators_types) && $block_elevators[$i+1]!=0) {
                                                                                    array_push($elevators_types, $block_elevators[$i+1]);
                                                                                }
                                                                                array_push($elevators_amount, $block_elevators[$i]);
                                                                            }
                                                                        }
                                                                        ?>
                                                                        <div>
                                                                            Лифты/подъемники
                                                                        </div>
                                                                        <div>
                                                                            <?if(count($elevators)){?>
                                                                                <span class="ghost"><?=array_sum($elevators_amount)?> шт.,</span> <?=valuesCompare(min($elevators_types), max($elevators_types))?> т
                                                                            <?}else{?>
                                                                                -
                                                                            <?}?>
                                                                        </div>
                                                                    </li>
                                                                    <li>
                                                                        <?
                                                                        $elevators = $offer->getOfferBlocksValues('cranes_cathead');
                                                                        $elevators_types = [];
                                                                        $elevators_amount = [];
                                                                        foreach($elevators as $elevator){
                                                                            $block_elevators = json_decode($elevator);
                                                                            for($i = 0; $i < count($block_elevators); $i = $i+2) {
                                                                                if (!in_array($block_elevators[$i+1], $elevators_types) && $block_elevators[$i+1]!=0) {
                                                                                    array_push($elevators_types, $block_elevators[$i+1]);
                                                                                }
                                                                                array_push($elevators_amount, $block_elevators[$i]);
                                                                            }
                                                                        }
                                                                        ?>
                                                                        <div>
                                                                            Кран-балки
                                                                        </div>
                                                                        <div>
                                                                            <?if(count($elevators)){?>
                                                                                <span class="ghost"><?=array_sum($elevators_amount)?> шт.,</span> <?=valuesCompare(min($elevators_types), max($elevators_types))?> т
                                                                            <?}else{?>
                                                                                -
                                                                            <?}?>
                                                                        </div>
                                                                    </li>
                                                                    <li>
                                                                        <?
                                                                        $elevators = $offer->getOfferBlocksValues('cranes_overhead');
                                                                        $elevators_types = [];
                                                                        $elevators_amount = [];
                                                                        foreach($elevators as $elevator){
                                                                            $block_elevators = json_decode($elevator);
                                                                            for($i = 0; $i < count($block_elevators); $i = $i+2) {
                                                                                if (!in_array($block_elevators[$i+1], $elevators_types) && $block_elevators[$i+1]!=0) {
                                                                                    array_push($elevators_types, $block_elevators[$i+1]);
                                                                                }
                                                                                array_push($elevators_amount, $block_elevators[$i]);
                                                                            }
                                                                        }
                                                                        ?>
                                                                        <div>
                                                                            Мостовые краны
                                                                        </div>
                                                                        <div>
                                                                            <?if(count($elevators)){?>
                                                                                <span class="ghost"><?=array_sum($elevators_amount)?> шт.,</span> <?=valuesCompare(min($elevators_types), max($elevators_types))?> т
                                                                            <?}else{?>
                                                                                -
                                                                            <?}?>
                                                                        </div>
                                                                    </li>
                                                                    <li>
                                                                        <?
                                                                        $elevators = $offer->getOfferBlocksValues('telphers');
                                                                        $elevators_types = [];
                                                                        $elevators_amount = [];
                                                                        foreach($elevators as $elevator){
                                                                            $block_elevators = json_decode($elevator);
                                                                            for($i = 0; $i < count($block_elevators); $i = $i+2) {
                                                                                if (!in_array($block_elevators[$i+1], $elevators_types) && $block_elevators[$i+1]!=0) {
                                                                                    array_push($elevators_types, $block_elevators[$i+1]);
                                                                                }
                                                                                array_push($elevators_amount, $block_elevators[$i]);
                                                                            }
                                                                        }
                                                                        ?>
                                                                        <div>
                                                                            Тельферы
                                                                        </div>
                                                                        <div>
                                                                            <?if(count($elevators)){?>
                                                                                <span class="ghost"><?=array_sum($elevators_amount)?> шт.,</span> <?=valuesCompare(min($elevators_types), max($elevators_types))?> т
                                                                            <?}else{?>
                                                                                -
                                                                            <?}?>
                                                                        </div>
                                                                    </li>
                                                                    <li>
                                                                        <div>
                                                                            Подкрановые пути
                                                                        </div>
                                                                        <div>
                                                                            <?$warehouse_equipment = $offer->getOfferBlocksMaxSumValue('cranes_runways')?>
                                                                            <?=($warehouse_equipment) ? 'есть' : '-' ?> <?=($warehouse_equipment && (($warehouse_equipment/$offer->subItemsActiveCount()) < 1)) ? ', частично' : ''?>
                                                                        </div>
                                                                    </li>
                                                                    <li>
                                                                        <div>
                                                                            Зарядная комната
                                                                        </div>
                                                                        <div>
                                                                            <?$charging_room = $offer->getOfferBlocksMaxSumValue('charging_room')?>
                                                                            <?=($charging_room) ? 'есть' : '-' ?> <?=($charging_room && (($charging_room/$offer->subItemsActiveCount()) < 1)) ? ', частично' : ''?>
                                                                        </div>
                                                                    </li>
                                                                    <li>
                                                                        <div>
                                                                            Складская техника
                                                                        </div>
                                                                        <div>
                                                                            <?$warehouse_equipment = $offer->getOfferBlocksMaxSumValue('warehouse_equipment')?>
                                                                            <?=($warehouse_equipment) ? 'есть' : '-' ?> <?=($warehouse_equipment && (($warehouse_equipment/$offer->subItemsActiveCount()) < 1)) ? ', частично' : ''?>
                                                                        </div>
                                                                    </li>
                                                                <?}else{?>
                                                                    <li>
                                                                        <div>
                                                                            S - участка
                                                                        </div>
                                                                        <div>
                                                                            <?= $offer->showOfferCalcStat(valuesCompare($offer->getOfferBlocksMinValue('area_floor_min'), $offer->getOfferBlocksMaxSumValue('area_floor_max')), '<span class="ghost">м<sup>2</sup></span>', '-')?>
                                                                        </div>
                                                                    </li>
                                                                    <li>
                                                                        <div>
                                                                            Тип покрытия
                                                                        </div>
                                                                        <div>

                                                                        </div>
                                                                    </li>
                                                                    <li>
                                                                        <div>
                                                                            Габариты участка
                                                                        </div>
                                                                        <div>

                                                                        </div>
                                                                    </li>
                                                                    <li>
                                                                        <div>
                                                                            Рельефы участка
                                                                        </div>
                                                                        <div>

                                                                        </div>
                                                                    </li>
                                                                <?}?>
                                                            </ul>
                                                        </div>

                                                    </div>
                                                    <div class="half text_left one-third-flex box">
                                                        <div class="box ">
                                                            <div>
                                                                <h1 style="line-height: 35px;">
                                                                    <?if($offer->getField('deal_type') == 2){?>
                                                                        <?if(!$object->getField('is_land')){?>
                                                                            <?= valuesCompare(numFormat($offer->getOfferBlocksMinValue('price_sale_min')*$offer->getOfferSumAreaMin()), numFormat($offer->getOfferBlocksMaxValue('price_sale_max')*$offer->getOfferSumAreaMax()))?> <i class="fas fa-ruble-sign ghost"></i>
                                                                        <?}else{?>
                                                                            <?= valuesCompare(numFormat($offer->getOfferBlocksMinValue('price_floor_min')*$offer->getOfferSumAreaMin()), numFormat($offer->getOfferBlocksMaxValue('price_floor_max')*$offer->getOfferSumAreaMax())) ?>  <i class="fas fa-ruble-sign ghost"></i>
                                                                        <?}?>
                                                                    <?}elseif($offer->getField('deal_type') == 3){?>
                                                                        <?
                                                                        $fields_arr_min = [
                                                                            'price_safe_pallet_eu_min',
                                                                            'price_safe_pallet_fin_min',
                                                                            'price_safe_pallet_us_min',
                                                                            'price_safe_pallet_oversized_min',
                                                                            'price_safe_cell_small_min',
                                                                            'price_safe_cell_middle_min',
                                                                            'price_safe_cell_big_min',
                                                                            'price_floor_min',
                                                                        ];

                                                                        $fields_arr_max= [
                                                                            'price_safe_pallet_eu_max',
                                                                            'price_safe_pallet_fin_max',
                                                                            'price_safe_pallet_us_max',
                                                                            'price_safe_pallet_oversized_max',
                                                                            'price_safe_cell_small_max',
                                                                            'price_safe_cell_middle_max',
                                                                            'price_safe_cell_big_max',
                                                                            'price_floor_max',
                                                                        ];
                                                                        ?>
                                                                        <?= valuesCompare(numFormat($offer->getOfferBlocksMinValueMultiple($fields_arr_min)), numFormat($offer->getOfferBlocksMaxValueMultiple($fields_arr_max)))?> <i class="fas fa-ruble-sign ghost"></i>
                                                                    <?}else{?>
                                                                        <?= $offer->showOfferCalcStat(valuesCompare(numFormat($offer->getOfferBlocksMinValue('price_floor_min')), numFormat($offer->getOfferBlocksMaxValue('price_floor_max'))), '<i class="fas fa-ruble-sign ghost"></i>', '-')?>
                                                                    <?}?>
                                                                </h1>
                                                            </div>
                                                            <?if($_COOKIE['member_id'] == 141){?>
                                                                <?$price_format = $_GET['format']?>
                                                                <?if($price_format == 1){?>
                                                                    <?
                                                                    $price_min = $offer->getOfferBlocksMinValue('price_floor_min');
                                                                    $price_max = $offer->getOfferBlocksMaxValue('price_floor_max');
                                                                    $dim = '<i class="far fa-ruble-sign"></i> за м<sup>2</sup>';
                                                                    ?>
                                                                <?}elseif($price_format == 2){?>
                                                                    <?
                                                                    $price_min = $offer->getOfferBlocksMinValue('price_floor_min')/12;
                                                                    $price_max = $offer->getOfferBlocksMaxValue('price_floor_max')/12;
                                                                    $dim = '<i class="far fa-ruble-sign"></i> за м<sup>2</sup>/мес';
                                                                    ?>
                                                                <?}elseif($price_format == 3){?>
                                                                    <?
                                                                    $price_min = $offer->getOfferBlocksMinValue('price_floor_min')/12*$offer->getOfferSumAreaMin();
                                                                    $price_max = $offer->getOfferBlocksMaxValue('price_floor_max')/12*$offer->getOfferSumAreaMax();
                                                                    $dim = '<i class="far fa-ruble-sign"></i> в месяц';
                                                                    ?>
                                                                <?}elseif($price_format == 4){?>
                                                                    <?
                                                                    $price_min = $offer->getOfferBlocksMinValue('price_sale_min');
                                                                    $price_max = $offer->getOfferBlocksMaxValue('price_sale_max');
                                                                    $dim = '<i class="far fa-ruble-sign"></i> за м<sup>2</sup>';
                                                                    ?>
                                                                <?}elseif($price_format == 5){?>
                                                                    <?
                                                                    //$price_min = $offer->getOfferBlocksMinValue('price_sale_min')*$subItem->getBlockSumAreaMin();
                                                                    //$price_max = $offer->getOfferBlocksMinValue('price_sale_max')*$subItem->getBlockSumAreaMax();
                                                                    $dim = '<i class="far fa-ruble-sign"></i> за все';
                                                                    ?>
                                                                <?}elseif($price_format == 6){?>
                                                                    <?
                                                                    $price_min = $offer->getOfferBlocksMinValue('price_sale_min')*100;
                                                                    $price_max = $offer->getOfferBlocksMaxValue('price_sale_max')*100;
                                                                    $dim = '<i class="far fa-ruble-sign"></i> за сотку';
                                                                    ?>
                                                                <?}elseif($price_format == 7){?>
                                                                    <?
                                                                    $price_min = $offer->getOfferBlocksMinValue('price_safe_pallet_eu_min');
                                                                    $price_max = $offer->getOfferBlocksMaxValue('price_safe_pallet_eu_max');
                                                                    $dim = '<i class="far fa-ruble-sign"></i> за п.м./сут';
                                                                    ?>
                                                                <?}elseif($price_format == 8){?>
                                                                    <?
                                                                    $price_min = $offer->getOfferBlocksMinValue('price_safe_volume_min');
                                                                    $price_max = $offer->getOfferBlocksMaxValue('price_safe_volume_max');
                                                                    $dim = '<i class="far fa-ruble-sign"></i> за м<sup>3</sup>/сут';
                                                                    ?>
                                                                <?}elseif($price_format == 9){?>
                                                                    <?
                                                                    $price_min = $offer->getOfferBlocksMinValue('price_safe_floor_min');
                                                                    $price_max = $offer->getOfferBlocksMaxValue('price_safe_floor_max');
                                                                    $dim = '<i class="far fa-ruble-sign"></i> за м<sup>2</sup>/сут';
                                                                    ?>
                                                                <?}else{?>
                                                                    <?if($object->getField('is_land')){?>
                                                                        <?
                                                                        $price_min = $offer->getOfferBlocksMinValue('price_floor_min');
                                                                        $price_max = $offer->getOfferBlocksMaxValue('price_floor_max');
                                                                        $dim = '<i class="far fa-ruble-sign"></i> за м<sup>2</sup>';
                                                                        ?>
                                                                    <?}else{?>
                                                                        <?if($offer->getField('deal_type') == 2){?>
                                                                            <?
                                                                            $price_min = $offer->getOfferBlocksMinValue('price_sale_min');
                                                                            $price_max = $offer->getOfferBlocksMaxValue('price_sale_max');
                                                                            $dim = '<i class="far fa-ruble-sign"></i> за м<sup>2</sup>';
                                                                            ?>
                                                                        <?}elseif($offer->getField('deal_type') == 3){?>
                                                                            <?
                                                                            $price_min = $offer->getOfferBlocksMinValue('price_safe_pallet_eu_min');
                                                                            $price_max = $offer->getOfferBlocksMaxValue('price_safe_pallet_eu_max');
                                                                            $dim = '<i class="far fa-ruble-sign"></i> за п.м./сут';
                                                                            ?>
                                                                        <?}else{?>
                                                                            <?
                                                                            $price_min = $offer->getOfferBlocksMinValue('price_floor_min');
                                                                            $price_max = $offer->getOfferBlocksMaxValue('price_floor_max');
                                                                            $dim = '<i class="far fa-ruble-sign"></i> за м<sup>2</sup>/год';
                                                                            ?>
                                                                        <?}?>
                                                                    <?}?>
                                                                <?}?>

                                                                <?= valuesCompare(numFormat($price_min), numFormat($price_max))?>
                                                                <?= $dim?>
                                                                <div class="box-wide">
                                                                    <?
                                                                    $formats = new Post();
                                                                    $formats->getTable('l_price_formats');
                                                                    $formats_info = $formats->getAllUnits();
                                                                    foreach($formats_info as $info){
                                                                        if(in_array($offer->getField('deal_type'),json_decode($info['deal_type'])) && array_intersect($object->getJsonField('object_type'),json_decode($info['object_type']))){?>
                                                                            <a class="link-underline" href="<?=$router->getURL()?>&format=<?=$info['id']?>#offers" ><?=$info['title']?></a><br>
                                                                        <?}
                                                                    }
                                                                    ?>
                                                                </div>
                                                            <?}?>
                                                        </div>

                                                        <div class="object-params-list">
                                                            <ul>
                                                                <?if(!$object->getField('is_land')){?>
                                                                    <?if($offer->getField('deal_type') == 1 || $offer->getField('deal_type') == 4){?>
                                                                        <?foreach ($offer->getOfferFloors() as $floor){?>
                                                                            <li>
                                                                                <div>
                                                                                    Пол, <?=$floor?> этаж:
                                                                                </div>
                                                                                <div>
                                                                                    <?= $offer->showOfferCalcStat(valuesCompare($offer->getOfferFloorBlocksMinValue($floor, 'price_floor_min'), $offer->getOfferFloorBlocksMaxValue($floor, 'price_floor_max')), '<span class="ghost"><i class="fas fa-ruble-sign "></i> м<sup>2</sup>/год</span>', '-')?>
                                                                                </div>
                                                                            </li>
                                                                        <?}?>
                                                                    <?}?>
                                                                    <?if($offer->getField('deal_type') == 2){?>
                                                                        <li>
                                                                            <div>
                                                                                Ставка за 1 м. кв.
                                                                            </div>
                                                                            <div>
                                                                                <?= $offer->showOfferCalcStat(valuesCompare($offer->getOfferBlocksMinValue('price_sale_min'), $offer->getOfferBlocksMaxValue('price_sale_max')),  '<i class="fas fa-ruble-sign ghost"></i>', '-')?>
                                                                            </div>
                                                                        </li>
                                                                    <?}?>
                                                                    <?if($offer->getField('deal_type') ==1 || $offer->getField('deal_type') ==4){?>
                                                                        <li>
                                                                            <div>
                                                                                Мезонин
                                                                            </div>
                                                                            <div>
                                                                                <?= valuesCompare($offer->getOfferBlocksMinValue('price_mezzanine_min'), $offer->getOfferBlocksMaxValue('price_mezzanine_max')) ?> <span class="ghost"><i class="fas fa-ruble-sign "></i> м<sup>2</sup>/год</span>
                                                                            </div>
                                                                        </li>
                                                                        <li>
                                                                            <div>
                                                                                Офисный блок
                                                                            </div>
                                                                            <div>
                                                                                <?= valuesCompare($offer->getOfferBlocksMinValue('price_office_min'), $offer->getOfferBlocksMaxValue('price_office_max'))?> <span class="ghost"><i class="fas fa-ruble-sign "></i> м<sup>2</sup>/год</span>
                                                                            </div>
                                                                        </li>
                                                                    <?}?>
                                                                <?}?>
                                                                <?if($offer->getField('deal_type') == 3 && !$object->getField('is_land')){?>
                                                                    <div class="tabs-block">
                                                                        <div class="tabs flex-box" style="background: #f4f4f4">
                                                                            <div class="tab" style="padding: 5px 10px">
                                                                                Хранение
                                                                            </div>
                                                                            <div class="tab" style="padding: 5px 10px">
                                                                                Приемка
                                                                            </div>
                                                                            <div class="tab" style="padding: 5px 10px">
                                                                                Отгрузка/комплект
                                                                            </div>
                                                                            <div class="tab" style="padding: 5px 10px">
                                                                                Доп. услуги.
                                                                            </div>
                                                                        </div>
                                                                        <div  style="height: 32px;">

                                                                        </div>
                                                                        <div class="tabs-content"  style="background: #f4f4f4; border: 1px solid lightblue;">
                                                                            <div class="tab-content">
                                                                                <ul class="full-width">
                                                                                    <?
                                                                                    $arr = [
                                                                                        ['EU  паллет 1.2*0.8*1.75','price_safe_pallet_eu','Р п.м/сут.'],
                                                                                        ['FIN паллет 1.2*1*1.75','price_safe_pallet_fin','Р п.м/сут.'],
                                                                                        ['US  паллет 1.2*1.2*1.75','price_safe_pallet_us','Р п.м/сут.'],
                                                                                        ['Негаб паллет/груз до 2т','price_safe_pallet_oversized','Р за ед.'],
                                                                                        ['Ячейки 30x40 ','price_safe_cell_small','яч./сут.'],
                                                                                        ['Ячейки 60x40','price_safe_cell_middle','яч./сут.'],
                                                                                        ['Ячейки 60x80','price_safe_cell_big','яч./сут.'],
                                                                                        ['Напольное','price_safe_floor','Р за м.кв./сут'],
                                                                                        ['Объемное','price_safe_volume','Р за м.куб./сут'],
                                                                                    ]
                                                                                    ?>
                                                                                    <?foreach($arr as $item){?>
                                                                                        <li>
                                                                    <span class="flex-box">
                                                                        <div style="width: 200px ;">
                                                                            <?=$item[0]?>
                                                                        </div>
                                                                        <div style="width: 100px">
                                                                            <?=valuesCompare($offer->getOfferBlocksMinValue($item[1].'_min'), $offer->getOfferBlocksMaxValue($item[1].'_max'))?>
                                                                        </div>
                                                                        <div class="ghost to-end">
                                                                            <?=$item[2]?>
                                                                        </div>
                                                                    </span>
                                                                                        </li>
                                                                                    <?}?>
                                                                                </ul>
                                                                            </div>
                                                                            <div class="tab-content">
                                                                                <ul class="full-width">
                                                                                    <?
                                                                                    $arr_1 = [
                                                                                        ['EU  паллет 1.2*0.8*1.75','price_safe_pallet_eu_in','Р за ед.'],
                                                                                        ['FIN паллет 1.2*1*1.75','price_safe_pallet_fin_in','Р за ед.'],
                                                                                        ['US  паллет 1.2*1.2*1.75','price_safe_pallet_us_in','Р за ед.'],
                                                                                        ['Негаб паллет/груз до 2т','price_safe_pallet_oversized_in','Р за ед.'],
                                                                                        ['Нагаб паллет/ 2-5т','price_safe_pallet_oversized_middle_in','Р за ед.'],
                                                                                        ['Негаб паллет / 5-8т','price_safe_pallet_oversized_big_in','Р за ед.'],
                                                                                    ];

                                                                                    $arr_2 = [
                                                                                        ['Короб/ мешок до 10кг ','price_safe_pack_small_in','Р за ед'],
                                                                                        ['Короб/мешок до 25кг','price_safe_pack_middle_in','Р за ед'],
                                                                                        ['Короб/мешок до 40кг','price_safe_pack_big_in','Р за ед'],
                                                                                    ];
                                                                                    ?>
                                                                                    <li><u>Механизированная погрузка</u></li>
                                                                                    <?foreach($arr_1 as $item){?>
                                                                                        <li>
                                                                    <span class="flex-box">
                                                                        <div style="width: 200px;">
                                                                            <?=$item[0]?>
                                                                        </div>
                                                                        <div style="width: 100px">
                                                                            <?=valuesCompare($offer->getOfferBlocksMinValue($item[1]), $offer->getOfferBlocksMaxValue($item[1]))?>
                                                                        </div>
                                                                        <div class="ghost">
                                                                            <?=$item[2]?>
                                                                        </div>
                                                                    </span>
                                                                                        </li>
                                                                                    <?}?>
                                                                                    <li><u>Ручная погрузка</u></li>
                                                                                    <?foreach($arr_2 as $item){?>
                                                                                        <li>
                                                                    <span class="flex-box">
                                                                        <div style="width: 200px;">
                                                                            <?=$item[0]?>
                                                                        </div>
                                                                        <div style="width: 100px">
                                                                            <?=valuesCompare($offer->getOfferBlocksMinValue($item[1]), $offer->getOfferBlocksMaxValue($item[1]))?>
                                                                        </div>
                                                                        <div class="ghost">
                                                                            <?=$item[2]?>
                                                                        </div>
                                                                    </span>
                                                                                        </li>
                                                                                    <?}?>
                                                                                </ul>
                                                                            </div>
                                                                            <div class="tab-content">
                                                                                <ul class="full-width">
                                                                                    <?
                                                                                    $arr_1 = [
                                                                                        ['EU  паллет 1.2*0.8*1.75','price_safe_pallet_eu_out','Р за ед.'],
                                                                                        ['FIN паллет 1.2*1*1.75','price_safe_pallet_fin_out','Р за ед.'],
                                                                                        ['US  паллет 1.2*1.2*1.75','price_safe_pallet_us_out','Р за ед.'],
                                                                                        ['Негаб паллет/груз до 2т','price_safe_pallet_oversized_out','Р за ед.'],
                                                                                        ['Нагаб паллет/ 2-5т','price_safe_pallet_oversized_middle_out','Р за ед.'],
                                                                                        ['Негаб паллет / 5-8т','price_safe_pallet_oversized_big_out','Р за ед.'],
                                                                                    ];

                                                                                    $arr_2 = [
                                                                                        ['Короб/ мешок до 10кг ','price_safe_pack_small_out','Р за ед'],
                                                                                        ['Короб/мешок до 25кг','price_safe_pack_middle_out','Р за ед'],
                                                                                        ['Короб/мешок до 40кг','price_safe_pack_big_out','Р за ед'],
                                                                                    ];
                                                                                    ?>
                                                                                    <li><u>Механизированная погрузка</u></li>
                                                                                    <?foreach($arr_1 as $item){?>
                                                                                        <li>
                                                                    <span class="flex-box">
                                                                        <div style="width: 200px;">
                                                                            <?=$item[0]?>
                                                                        </div>
                                                                        <div style="width: 100px">
                                                                            <?=valuesCompare($offer->getOfferBlocksMinValue($item[1]), $offer->getOfferBlocksMaxValue($item[1]))?>
                                                                        </div>
                                                                        <div class="ghost">
                                                                            <?=$item[2]?>
                                                                        </div>
                                                                    </span>
                                                                                        </li>
                                                                                    <?}?>
                                                                                    <li><u>Ручная погрузка</u></li>
                                                                                    <?foreach($arr_2 as $item){?>
                                                                                        <li>
                                                                    <span class="flex-box">
                                                                        <div style="width: 200px;">
                                                                            <?=$item[0]?>
                                                                        </div>
                                                                        <div style="width: 100px">
                                                                            <?=valuesCompare($offer->getOfferBlocksMinValue($item[1]), $offer->getOfferBlocksMaxValue($item[1]))?>
                                                                        </div>
                                                                        <div class="ghost">
                                                                            <?=$item[2]?>
                                                                        </div>
                                                                    </span>
                                                                                        </li>
                                                                                    <?}?>
                                                                                    <li>
                                                                                        <div class="underlined">
                                                                                            Подбор в заказ
                                                                                        </div>
                                                                                    </li>
                                                                                    <?
                                                                                    $arr = [
                                                                                        ['Короб/ мешок до 10кг ','price_safe_pack_small_complement','Р за ед'],
                                                                                        ['Короб/мешок до 25кг','price_safe_pack_middle_complement','Р за ед'],
                                                                                        ['Короб/мешок до 40кг','price_safe_pack_big_complement','Р за ед'],
                                                                                    ]
                                                                                    ?>
                                                                                    <?foreach($arr as $item){?>
                                                                                        <li>
                                                                    <span class="flex-box">
                                                                        <div style="width: 200px;">
                                                                            <?=$item[0]?>
                                                                        </div>
                                                                        <div style="width: 100px">
                                                                            <?=valuesCompare($offer->getOfferBlocksMinValue($item[1]), $offer->getOfferBlocksMaxValue($item[1]))?>
                                                                        </div>
                                                                        <div class="ghost">
                                                                            <?=$item[2]?>
                                                                        </div>
                                                                    </span>
                                                                                        </li>
                                                                                    <?}?>
                                                                                </ul>
                                                                            </div>
                                                                            <div class="tab-content">
                                                                                <ul class="full-width">
                                                                                    <?
                                                                                    $arr = [
                                                                                        ['Выборочная инвентаризация','price_safe_service_inventory','Р за ед.'],
                                                                                        ['Обмотка стретч пленкой 2-3 слоя','price_safe_service_winding','Р за ед.'],
                                                                                        ['Подготовка сопроводительных документов','price_safe_service_document','Р за ед.'],
                                                                                        ['Предоставление отчетов','price_safe_service_report','Р за ед.'],
                                                                                        ['Предоставление поддонов','price_safe_service_pallet','Р за ед.'],
                                                                                        ['Стикеровка','price_safe_service_stickers','Р за ед.'],
                                                                                        ['Формирование паллет','price_safe_service_packing_pallet','Р за ед'],
                                                                                        ['Формирование коробов','price_safe_service_packing_pack','Р за ед'],
                                                                                        ['Утилизация мусора','price_safe_service_recycling','Р за ед'],
                                                                                        ['Опломбирование авто','price_safe_service_sealing','Р за ед'],
                                                                                    ]
                                                                                    ?>
                                                                                    <?foreach($arr as $item){?>
                                                                                        <li>
                                                                    <span class="flex-box">
                                                                        <div style="width: 250px;">
                                                                            <?=$item[0]?>
                                                                        </div>
                                                                        <div style="width: 100px">
                                                                            <?=valuesCompare($offer->getOfferBlocksMinValue($item[1]), $offer->getOfferBlocksMaxValue($item[1]))?>
                                                                        </div>
                                                                        <div class="ghost">
                                                                            <?=$item[2]?>
                                                                        </div>
                                                                    </span>
                                                                                        </li>
                                                                                    <?}?>
                                                                                </ul>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                <?}?>
                                                                <li>
                                                                    <div>
                                                                        &#160;
                                                                    </div>
                                                                    <div>

                                                                    </div>
                                                                </li>
                                                                <li>
                                                                    <div>
                                                                        <b>Налоги / что включено</b>
                                                                    </div>
                                                                    <div>

                                                                    </div>
                                                                </li>
                                                                <li>
                                                                    <div style="padding: 0 20px 12px 20px">
                                                                        <ul class="flex-box icon-row">
                                                                            <?if($offer->getField('tax_form')){?>
                                                                                <? $inc_obj = new Post($offer->getField('tax_form'))?>
                                                                                <? $inc_obj->getTable('l_tax_form')?>
                                                                                <li>
                                                                                    <div class="icon-orthogonal full-width" title="<?=$inc_obj->title()?>">
                                                                                        <?=$inc_obj->getField('title_short')?>
                                                                                    </div>
                                                                                </li>
                                                                            <?}?>
                                                                            <?if($offer->getField('tax_form') != 1){?>
                                                                                <?if(arrayIsNotEmpty($offer->getJsonField('inc_services'))){?>
                                                                                    <?foreach($offer->getJsonField('inc_services') as $inc){?>
                                                                                        <?if($inc !='triplenet'  && $inc !='opex' && $inc !='nds' && $inc !=''){?>
                                                                                            <? $inc_obj = new Post($inc)?>
                                                                                            <? $inc_obj->getTable('l_inc_services')?>
                                                                                            <li>
                                                                                                <div class="icon-orthogonal full-width" title="<?=$inc_obj->title()?>">
                                                                                                    <?=$inc_obj->getField('title_short')?>
                                                                                                </div>
                                                                                            </li>
                                                                                        <?}?>
                                                                                    <?}?>
                                                                                <?}?>
                                                                            <?}?>
                                                                            <?if($offer->getField('deal_type') == 2 && $offer->getField('sale_company')){?>
                                                                                <li>
                                                                                    <div class="icon-orthogonal" title="готов продать компанию">
                                                                                        Продается путем<br> продажи доли в юр лице
                                                                                    </div>
                                                                                </li>
                                                                            <?}?>
                                                                        </ul>
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
                                                                <?if($offer->getField('deal_type') == 2 && $offer->getField('rent_business')){?>
                                                                    <li>
                                                                        <div class="flex-box">
                                                                            <div>
                                                                                <i class="fas fa-shopping-basket"></i>
                                                                            </div>
                                                                            <div class="isBold box-wide"  style="color: red;">
                                                                                Арендный бизнес
                                                                            </div>
                                                                        </div>
                                                                        <div>

                                                                        </div>
                                                                    </li>
                                                                    <?
                                                                $arr = [
                                                                    ['rent_business_fill','% заполненности объекта','%'],
                                                                    ['rent_business_price','Средняя ставка аренды','Р м кв/год'],
                                                                    ['rent_business_long_contracts','% долгих контрактов',''],
                                                                    ['rent_business_last_repair','Год последнего капремонта','год'],
                                                                    ['rent_business_payback','Срок окупаемости','лет'],
                                                                    ['rent_business_income','EBITDA','Р м кв/год'],
                                                                    ['rent_business_profit','Чистая прибыль','Р м кв/год'],
                                                                ]

                                                                    ?>
                                                                    <?foreach ($arr as $item){?>
                                                                        <?if($offer->getField($item[0])){?>
                                                                            <li>
                                                                                <div>
                                                                                    <?=$item[1]?>
                                                                                </div>
                                                                                <div>
                                                                                    <?=$offer->getField($item[0])?> <span class="ghost"><?=$item[2]?></span>
                                                                                </div>
                                                                            </li>
                                                                        <?}?>
                                                                    <?}?>


                                                                    <li>
                                                                        <div>

                                                                        </div>
                                                                        <div>
                                                                            &#160;
                                                                        </div>
                                                                    </li>
                                                                <?}?>
                                                                <?if(($offer->getField('deal_type') == 1 || $offer->getField('deal_type') == 4) && $offer->getField('tax_form')==1){?>
                                                                    <li>
                                                                        <div>
                                                                            <b>
                                                                                Дополнителнительные расходы
                                                                            </b>
                                                                        </div>
                                                                        <div>

                                                                        </div>
                                                                    </li>
                                                                    <li>
                                                                        <div>
                                                                            OPEX
                                                                        </div>
                                                                        <div>
                                                                            <?if($offer->getField('price_opex_min')){?>
                                                                                <?= $offer->getField('price_opex_min')?> -  <?= $offer->getField('price_opex_max')?> <i class="fas fa-ruble-sign "></i> м<sup>2</sup>/год</span>
                                                                            <?}else{?>
                                                                                -
                                                                            <?}?>
                                                                            <?//= ($offer->getField('price_opex_min')) ?  $offer->getField('price_opex').' <span class="ghost"><i class="fas fa-ruble-sign "></i> м<sup>2</sup>/год</span>' : '-' ?>
                                                                        </div>
                                                                    </li>
                                                                    <li>
                                                                        <div>
                                                                            Ком. платежи
                                                                        </div>
                                                                        <div>
                                                                            <?if($offer->getField('price_public_services_min')){?>
                                                                                <?= $offer->getField('price_public_services_min')?> -  <?= $offer->getField('price_public_services_max')?> <i class="fas fa-ruble-sign "></i> м<sup>2</sup>/год</span>
                                                                            <?}else{?>
                                                                                -
                                                                            <?}?>
                                                                            <?//= ($offer->getField('price_public_services')) ?  '~'.$offer->getField('price_public_services').' <span class="ghost"><i class="fas fa-ruble-sign "></i> м<sup>2</sup>/год</span>' : '-' ?>
                                                                        </div>
                                                                    </li>
                                                                    <li>
                                                                        <div>
                                                                            &#160;
                                                                        </div>
                                                                        <div>

                                                                        </div>
                                                                    </li>
                                                                <?}?>
                                                                <?if($offer->getField('deal_type') == 1 ||  $offer->getField('deal_type') == 4){?>
                                                                    <li>
                                                                        <div>
                                                                            <b>
                                                                                Особые условия
                                                                            </b>
                                                                        </div>
                                                                        <div>

                                                                        </div>
                                                                    </li>
                                                                    <li>
                                                                        <div>
                                                                            Каникулы
                                                                        </div>
                                                                        <div>
                                                                            <?if($offer->getField('holidays_min')){?>
                                                                                <?= $offer->getField('holidays_min')?> -  <?= $offer->getField('holidays_max')?> <span> месяца </span>
                                                                            <?}else{?>
                                                                                -
                                                                            <?}?>
                                                                        </div>
                                                                    </li>
                                                                    <li>
                                                                        <div>
                                                                            Депозит
                                                                        </div>
                                                                        <div>
                                                                            <?if($offer->getField('deposit')){?>
                                                                                <?= $offer->getField('deposit')?> <span>мес</span>
                                                                            <?}else{?>
                                                                                -
                                                                            <?}?>
                                                                        </div>
                                                                    </li>
                                                                    <li>
                                                                        <div>
                                                                            Залоговый пл.
                                                                        </div>
                                                                        <div>
                                                                            <?if($offer->getField('pledge')){?>
                                                                                <?= $offer->getField('pledge')?> <span>мес</span>
                                                                            <?}else{?>
                                                                                -
                                                                            <?}?>
                                                                        </div>
                                                                    </li>
                                                                <?}?>
                                                                <?if($offer->getField('deal_type') == 3 ){?>
                                                                    <li>
                                                                        <div class="pointer isBold">
                                                                            Оказываемые услуги
                                                                        </div>
                                                                        <div>

                                                                        </div>
                                                                    </li>
                                                                <?}?>

                                                                <?
                                                                $all_fields = $offer->getTableColumnsNames();
                                                                $services =[];
                                                                foreach($all_fields as $field_item){
                                                                    if(stristr($field_item,'safe_service') !== false && $offer->getField($field_item)){
                                                                        $services[] = $field_item;
                                                                    }
                                                                }
                                                                //var_dump($services);

                                                                ?>
                                                                <?foreach($services as $service){?>
                                                                    <?$service_field = new Field()?>
                                                                    <?$service_field->getFieldByName($service)?>
                                                                    <li>
                                                                        <div>
                                                                            <?=$service_field->description()?>
                                                                        </div>
                                                                        <div>

                                                                        </div>
                                                                    </li>
                                                                <?}?>

                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <div style="padding-top: 20px;" class="card-contacts-area full-height one-third-flex">
                                                        <div class="flex-box box">
                                                            <div>
                                                                <?
                                                                $status = new Post($offer->getOfferStatus());
                                                                $status->getTable('l_statuses_all');?>
                                                                <?=$status->title()?>
                                                            </div>
                                                            <div class="ghost box-wide">
                                                                (обновл. <?= date('d-m-Y в H:i',$offer->getOfferLastUpdate())?>)
                                                            </div>
                                                            <div class=" flex-box to-end">
                                                                <?if($logedUser->isAdmin()){?>
                                                                    <div class="icon-round ad-panel-call modal-call-btn1" data-id="" data-table="" data-modal="panel-ad"  data-modal-size="modal-middle" ><i class="fas fa-rocket"></i></div>
                                                                    <div class="icon-round modal-call-btn" data-form="<?=$deal_forms_offers_arr[$object->getField('is_land')][$offer->getField('deal_type')-1]?>" data-id="<?=$offer->offerId()?>" data-table="<?=$offer->setTableId()?>" data-show-name="company_id" data-modal="edit-all" data-modal-size="modal-middle"><i class="fas fa-pencil-alt"></i></div>
                                                                    <div class="icon-round modal-call-btn"  data-modal="edit-all" data-modal-size="modal-middle" data-id="0" data-table="<?=$offer->setTableId()?>" data-names='["email_offers"]' data-values='["<?=json_encode([[$offer->offerId(),2]])?>"]'><i class="fas fa-envelope" ></i></div>
                                                                <?}?>
                                                                <div class="icon-round"><a href="/pdf-test.php?original_id=<?=$offer->postId()?>&type_id=2&member_id=<?=$logedUser->member_id()?>" target="_blank"><i class="fas fa-file-pdf"></i></a></div>
                                                                <!--
                                        <div class="icon-round"><a href="/create_pdf.php?id=<?=$offer->postId()?>&type_id=2" target="_blank"><i class="far fa-file-pdf"></i></a></div>
                                        -->
                                                                <div class="icon-round icon-star <?=(in_array([$offer->postId(),2],$favourites)) ? 'icon-star-active' : ''?>" data-offer-id="[<?=$offer->postId()?>,2]"><i class="fas fa-star"></i></div>
                                                                <div class="icon-round"><a class="icon-bell" href=""><i class="fas fa-bell"></i></a></div>
                                                                <div class="icon-round"><a class="icon-thumbs-down" href=""><i class="fas fa-thumbs-down"></i></a></div>
                                                            </div>
                                                        </div>
                                                        <div class="card-contacts-area-inner flex-box box text_left flex-box-verical flex-between flex-box-to-left" style="background: #e6eedd;">
                                                            <?if($offer->getField('company_id')){?>
                                                                <?$company = new Company($offer->getField('company_id')); ?>
                                                                <div>
                                                                    <?if($company->getField('company_group_id')){?>
                                                                        <div>
                                                                            <b>
                                                                                <?
                                                                                $company_group = new Post($company->getField('company_group_id'));
                                                                                $company_group->getTable('c_industry_companies_groups');
                                                                                ?>
                                                                                <?=$company_group->title()?>
                                                                            </b>
                                                                        </div>
                                                                    <?}?>
                                                                    <div>
                                                                        <a href="/company/<?=$company->postId()?>" target="_blank">
                                                                            <?if($company->postId() == $company->title()){?>
                                                                                <span class="attention ">NONAME <?=$company->postId()?></span>
                                                                            <?}else{?>
                                                                                <?=$company->title()?>
                                                                            <?}?>
                                                                        </a>
                                                                    </div>
                                                                    <?if($company->getField('company_group_id')){?>
                                                                        <div class="ghost">
                                                                            <?=(new CompanyGroup($company->getField('company_group_id')))->title()?>
                                                                        </div>
                                                                    <?}?>
                                                                    <?if($company->getField('rating')){?>
                                                                        <div class="ghost">
                                                                            тут рейтинг
                                                                        </div>
                                                                    <?}?>
                                                                    <div class="flex-box flex-wrap">
                                                                        <?if(count($company->getCompanyContacts())){?>
                                                                            <div>
                                                                                контакты (<?=(count($company->getCompanyContacts()))?>) ,
                                                                            </div>
                                                                        <?}?>
                                                                        <?if(count($company->getCompanyRequests())){?>
                                                                            <div>
                                                                                запросы (<?=(count($company->getCompanyRequests()))?>),
                                                                            </div>
                                                                        <?}?>
                                                                        <?if(count($company->getCompanyObjects())){?>
                                                                            <div>
                                                                                объекты (<?=(count($company->getCompanyObjects()))?>)
                                                                            </div>
                                                                        <?}?>
                                                                    </div>
                                                                    <div>
                                                                        &#160;
                                                                    </div>
                                                                    <?if($offer->getField('contact_id')){?>
                                                                        <div>
                                                                            <?
                                                                            $contact = new Contact($offer->getField('contact_id'));
                                                                            ?>
                                                                            <a href="/contact/<?=$contact->postId()?>"><?=$contact->title()?></a>
                                                                        </div>
                                                                        <div>
                                                                            <div class="ghost">
                                                                                <?$contact_group = new Post($contact->getField('contact_group'));
                                                                                $contact_group->getTable('c_industry_contact_groups');
                                                                                ?>
                                                                                <?=$contact_group->title()?>
                                                                            </div>
                                                                            <div >
                                                                                <?=$contact->phone()?>
                                                                            </div>
                                                                            <div>
                                                                                <?=$contact->email()?>
                                                                            </div>
                                                                        </div>
                                                                    <?}?>
                                                                </div>
                                                            <?}?>
                                                        </div>
                                                        <div class="card-brocker-area">
                                                            <div class="card-brocker-area-inner box text_left flex-box flex-vertical-top ">
                                                                <div>
                                                                    <div>
                                                                        <div>
                                                                            <b>
                                                                                Консультант Penny Lane
                                                                            </b>
                                                                        </div>
                                                                        <div>
                                                                            <?if($offer->getField('agent_id')){?>
                                                                                <?= (new Member($offer->getField('agent_id')))->title();?>
                                                                            <?}?>
                                                                        </div>
                                                                        <div class="card-agent-history">
                                                                            <ul>
                                                                                <?if($offer->agentVisited()){?>
                                                                                    <li>
                                                                                        <div class="calm flex-box-inline">
                                                                                            был на обьекте
                                                                                        </div>
                                                                                    </li>
                                                                                <?}?>
                                                                                <?if($offer->getField('contract_is_signed')){?>
                                                                                    <li>
                                                                                        <div class="calm flex-box-inline">
                                                                                            контракт подписан
                                                                                        </div>
                                                                                    </li>
                                                                                <?}?>
                                                                            </ul>
                                                                        </div>
                                                                    </div>
                                                                    <div class="box">

                                                                    </div>
                                                                    <div>

                                                                        <?if(!$offer->getField('dont_pay')){?>
                                                                            <?if($offer->getField('commission_owner') || $offer->getField('commission_client')){?>
                                                                                <div>
                                                                                    <b>
                                                                                        Комиссия
                                                                                    </b>
                                                                                </div>
                                                                            <?}?>
                                                                            <div class="card-agent-history">
                                                                                <ul>
                                                                                    <?if($offer->getField('commission_owner')){?>
                                                                                        <li>
                                                                                            <div class="attention flex-box-inline">
                                                                                                комиссия для собственника <?=$offer->getField('commission_owner')?>%
                                                                                                <?if($offer->getField('pay_guarantee')){?>
                                                                                                    , гарантировано
                                                                                                <?}?>
                                                                                                <?//=($offer->payCommissionThroughHolidays()) ? ',через каникулы' : ''?>
                                                                                                <?if($offer->getField('holidays_pay')){?>
                                                                                                    , каникулами
                                                                                                <?}?>
                                                                                            </div>
                                                                                        </li>
                                                                                    <?}?>
                                                                                    <?if($offer->getField('commission_client')){?>
                                                                                        <li>
                                                                                            <div class="attention flex-box-inline">
                                                                                                комиссия для клиента <?=$offer->getField('commission_client')?>%
                                                                                            </div>
                                                                                        </li>
                                                                                    <?}?>
                                                                                    <?if($offer->getField('commission_agent')){?>
                                                                                        <li>
                                                                                            <div class="attention flex-box-inline">
                                                                                                комиссия агенту <?=$offer->getField('commission_agent')?>%
                                                                                            </div>
                                                                                        </li>
                                                                                    <?}?>
                                                                                    <?if($offer->getField('site_show')){?>
                                                                                        <li> показывается на сайте</li>
                                                                                    <?}?>
                                                                                    <?if($offer->getField('site_show_top')){?>
                                                                                        <li> спецпредложение</li>
                                                                                    <?}?>
                                                                                    <?if($offer->getField('site_price_hide')){?>
                                                                                        <li> скрыл цену</li>
                                                                                    <?}?>
                                                                                </ul>
                                                                            </div>
                                                                        <?}else{?>
                                                                            <div class="attention">
                                                                                НЕ ПЛАТИТ !!!!!!
                                                                            </div>
                                                                        <?}?>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div>
                                                    <?$table = $offer->setTableId()?>
                                                    <?$id = $offer->postId()?>
                                                    <? include($_SERVER['DOCUMENT_ROOT'].'/templates/forms/panel-description/index.php')?>
                                                </div>
                                                <div >
                                                    <?$table = $offer->setTableId()?>
                                                    <?$id = $offer->offerId()?>
                                                    <? include($_SERVER['DOCUMENT_ROOT'].'/templates/forms/panel-ad/index.php')?>
                                                </div>
                                                <div class="box">

                                                </div>

                                                <?if($logedUser->isAdmin()){?>
                                                    <div>
                                                        <div class="tab-content accordion" style="overflow-x: scroll; max-width: 1550px;">
                                                            <form action="<?=PROJECT_URL?>/system/controllers/subitems/merge.php" method="get">
                                                                <?
                                                                //куски
                                                                //include_once  $_SERVER['DOCUMENT_ROOT'].'/errors.php';
                                                                $floors = $object->getFloors();
                                                                $sorted = [];
                                                                $sorted_key = [];
                                                                foreach($floors as $floor){
                                                                    $floor = new Floor($floor);
                                                                    $floor_obj = new Post($floor->getField('floor_num_id'));
                                                                    $floor_obj->getTable('l_floor_nums');
                                                                    $sorted[] = $floor_obj->getField('order_row');
                                                                    $sorted_key[$floor_obj->getField('order_row')] = $floor->postId() ;
                                                                }
                                                                rsort($sorted);
                                                                //var_dump($sorted);
                                                                foreach($sorted as $value){
                                                                    //echo $value;
                                                                    $floor = new Floor($sorted_key[$value]);
                                                                    $floor_obj = new Post($floor->getField('floor_num_id'));
                                                                    $floor_obj->getTable('l_floor_nums');?>
                                                                    <div class="acc-unit box-small" style=" background: #e7e7e7; margin: 10px 0; ">
                                                                        <div class="full-width  acc-tab flex-vertical-top " style="box-sizing: border-box; padding: 3px;">
                                                                            <div class="floor-info  flex-box" >
                                                                                <div class="isBold box-wide flex-box" style=" min-width: 150px; background: #e25822; color: white; ">
                                                                                    <div>
                                                                                        <?=$floor_obj->getField('title')?>
                                                                                    </div>
                                                                                    <div class="to-end flex-box floor-actions">
                                                                                        <div class="pointer box-small-wide modal-call-btn" data-form="" data-id="<?=$floor->postId()?>" data-table="<?=$floor->setTableId()?>" data-show-name="company_id" data-modal="edit-all" data-modal-size="modal-middle"><i class="fas fa-pencil-alt"></i></div>
                                                                                        <div title="создать блок на этаже" class="pointer modal-call-btn" data-form="<?=$deal_forms_blocks_arr[$object->getField('is_land')][$offer->getField('deal_type')-1]?>" data-id="" data-table="<?=(new Part())->setTableId()?>" data-names='["floor_id","offer_id","is_land"]' data-values='[<?=$floor->getField('id')?>,<?=$offer->getField('id')?>,<?=$object->getField('is_land')?>]'    data-modal="edit-all" data-modal-size="modal-middle"><i class="fas fa-plus-circle"></i></div>
                                                                                    </div>
                                                                                </div>
                                                                                <?if($floor_area = $floor->getField('area_floor_full')){?>
                                                                                    <div class="box-wide">
                                                                                        <?= numFormat($floor_area)?> м <sup>2</sup>
                                                                                    </div>
                                                                                <?}?>
                                                                                <div class="flex-box">

                                                                                </div>
                                                                            </div>
                                                                            <div class="flex-box floor-blocks" style="min-height: 60px;  ">
                                                                                <?

                                                                                require_once($_SERVER['DOCUMENT_ROOT'].'/global_pass.php');
                                                                                $floor_id = $floor->postId();
                                                                                $offer_id = $offer->postId();
                                                                                //$sql_bl = $pdo->prepare("SELECT * FROM c_industry_blocks WHERE offer_id=$offer_id AND floor_id=$floor_id  ");
                                                                                $sql_bl = $pdo->prepare("SELECT * FROM c_industry_parts WHERE offer_id=$offer_id AND floor_id=$floor_id  ");
                                                                                $sql_bl->execute();
                                                                                $floor_blocks = [];
                                                                                while($floor_block = $sql_bl->fetch(PDO::FETCH_LAZY)){?>
                                                                                    <?$floor_blocks[] = $floor_block->id?>
                                                                                    <?//$obj_block = new Subitem($floor_block->id)?>
                                                                                    <?$obj_block = new Part($floor_block->id)?>
                                                                                    <?//$block_status = $obj_block->gf('status')?>
                                                                                    <div class="box-small no-shrink floor-block"   style="height: 100%; width: 200px;  <?if($block_status == 1){?>background: #56a03c; color: #ffffff; border: 1px solid #56a03c;<?}else{?>  border-left: 10px solid #4c50f5;<?}?>">
                                                                                        <div class="isBold">
                                                                                            <span ><?=numFormat($floor_block->area_floor_max)?> м <sup>2</sup></span>
                                                                                        </div>
                                                                                        <?if($block_status == 1){?>
                                                                                            <div>
                                                                                                Актив
                                                                                            </div>
                                                                                        <?}else{?>
                                                                                            <div class="isBold attention">
                                                                                                Сдано
                                                                                            </div>
                                                                                        <?}?>

                                                                                        <div class="flex-box">
                                                                                            <?if($block_status != 1){?>
                                                                                                <div>
                                                                                                    DACHSER
                                                                                                </div>
                                                                                            <?}?>
                                                                                            <div class="to-end flex-box">
                                                                                                <div>
                                                                                                    <div class="pointer modal-call-btn" data-form="<?=$deal_forms_blocks_arr[$object->getField('is_land')][$offer->getField('deal_type')-1]?>" data-id="<?=$floor_block->id?>" data-table="<?=(new Part())->setTableId()?>" data-show-name="company_id" data-modal="edit-all" data-modal-size="modal-middle"><i class="fas fa-pencil-alt"></i></div>
                                                                                                </div>
                                                                                                <?//if(!$obj_block->hasStacksStrict()){?>
                                                                                                <?if(1){?>
                                                                                                    <input class="block-check" name="blocks[]" type="checkbox" value="<?=$obj_block->postId()?>"  />
                                                                                                <?}?>
                                                                                            </div>
                                                                                        </div>

                                                                                    </div>
                                                                                <?}?>
                                                                                <div class="box-small floor-block" style="height: 100%; width: 100%;    min-width: 200px; border-left: 10px solid #9f9f9f;">
                                                                                    <div >
                                                                                        <span class="isBold"><?=numFormat($floor->getField('area_floor_full') - $floor->getFloorOfferBlocksSumArea($offer_id))?> м <sup>2</sup></span>
                                                                                    </div>
                                                                                    <div>
                                                                                        нераспред. площадь
                                                                                    </div>
                                                                                    <div class="flex-box">
                                                                                        <div>
                                                                                            _
                                                                                        </div>
                                                                                        <div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="acc-content">
                                                                            <div>

                                                                            </div>
                                                                            <div>

                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                <?}?>
                                                                <button>Собрать</button>
                                                            </form>
                                                        </div>

                                                    </div>
                                                <?}?>



                                                <!--БЛОКИ НОРМАЛЬНЫЕ -->
                                                <div class="card-blocks-area text_left  tabs-block ">
                                                    <div class="flex-box flex-vertical-top">
                                                        <div class="card-blocks-base " style=" width: 250px">
                                                            <div class="box" style="background: #e1e1e1">
                                                                <b>Деление: <?=count($offer->subItems())?> блок(ов)</b>
                                                            </div>
                                                            <div style="border: 1px solid #ffffff">
                                                                <div class="block-header flex-box  flex-vertical-center box-wide " style="height: 70px; border-bottom: 1px dashed #b5b5b5">
                                                                    № блока
                                                                </div>
                                                                <div class="box obj-block-stats" style="border-bottom: 1px solid #cfcfcf;" >
                                                                    <ul>
                                                                        <?if(!$object->getField('is_land')){?>
                                                                            <li><b>S - складская</b></li>
                                                                        <?}?>
                                                                        <?if($object->getField('is_land')){?>
                                                                            <li>S - участка <span> *</span></li>
                                                                            <li>Тип покрытия: <span> *</span></li>
                                                                            <li>Габариты участка</li>
                                                                            <li>Рельеф участка</li>
                                                                        <?}else{?>
                                                                            <li>S - пола <span> *</span></li>
                                                                            <li>S - мезонина</li>
                                                                            <li>S - офиснов</li>
                                                                            <li>S - уличное</li>
                                                                            <li>S - техническая</li>
                                                                            <li>Кол-во палет-мест</li>
                                                                            <li>Стеллажи</li>
                                                                            <li class="block-info-racks">Тип стеллажей</li>
                                                                            <li class="block-info-safe-types">Тип хранения</li>
                                                                            <li>Ячейки</li>
                                                                            <li>Высота рабочая<span> *</span></li>
                                                                            <li class="block-info-gates">Тип/кол-во ворот<span> *</span></li>
                                                                            <li>Вход в блок</li>
                                                                            <li>Кросс-докинг</li>
                                                                            <li>Тип пола: <span> *</span></li>
                                                                            <li>Нагрузка на пол:</li>
                                                                            <li>Нагрузка на мезонин</li>
                                                                            <li>Сетка колонн</li>
                                                                            <li>Темперетурный режим</li>
                                                                            <li>Доступная мощность</li>
                                                                            <li class="block-info-elevators">Лифты/подъемники</li>
                                                                            <li class="block-info-cranes_cathead">Кран-балки</li>
                                                                            <li class="block-info-cranes_overhead">Мостовые краны</li>
                                                                            <li class="block-info-telphers">Тельферы</li>
                                                                            <li>Подкрановые пути </li>
                                                                            <li>Зарядная комната </li>
                                                                            <li>Складская техника </li>
                                                                        <?}?>
                                                                    </ul>
                                                                </div>
                                                                <div class="box obj-block-stats" style="border-bottom: 1px solid #cfcfcf;">
                                                                    <ul>
                                                                        <?if($offer->getField('deal_type') == 2){?>
                                                                            <li><b>Цена продажи</b></li>
                                                                        <?}elseif($offer->getField('deal_type') == 3){?>
                                                                            <li><b>Цена храненния</b> <span>в сут</span></li>
                                                                        <?}else{?>
                                                                            <li><b>Цена пола,</b> <span>в месяц</span></li>
                                                                            <?if(!$object->getField('is_land')){?>
                                                                                <li>Цена мезонина:</li>
                                                                                <li>Цена офиса:</li>
                                                                            <?}?>
                                                                        <?}?>
                                                                    </ul>
                                                                </div>
                                                                <div class="box" style="border-bottom: 1px solid #cfcfcf;">
                                                                    Подходящие клиенты
                                                                </div>
                                                                <div class="flex-box box" style="height: 51px; border-bottom: 1px solid grey">

                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="full-width">
                                                            <div class="tabs">
                                                                <div class="card-blocks-list flex-box flex-vertical-top" style="  overflow-x: scroll;  max-width: 1350px;">
                                                                    <?$block_num = 1?>
                                                                    <?foreach ($offer->subItemsIdFloors() as $obj_block){?>
                                                                        <?$obj_block = new Subitem($obj_block)?>
                                                                        <?
                                                                        $color_arr = [
                                                                            '-3'=>'',
                                                                            '-2'=>'#ec7b7b',
                                                                            '-1'=>'#03c1eb',
                                                                            '1'=>'#0370eb',
                                                                            '2'=>'#ec8d7b',
                                                                            '3'=>'#97bfad',
                                                                            '4'=>'#edaa70',
                                                                            '5'=>'#12f91c',
                                                                            '6'=>'#9900CC',
                                                                            '7'=>'#3399FF',
                                                                            '8'=>'#FF3399',
                                                                            '9'=>'#339933',
                                                                            '10'=>'#33CCFF',
                                                                        ];

                                                                        ?>
                                                                        <div class="flex-box flex-vertical-top tab <?=($obj_block->getField('status') == 2 ) ? 'ghost' : ''?>">
                                                                            <div id="subitem-<?=$obj_block->postId()?>" class="object-block " style="width: 200px ;">
                                                                                <div class="box " style="background: <?=$color_arr[$obj_block->floorNum()]?>; color: #FFFFFF;">
                                                                                    <?if(!$object->getField('is_land')){?>
                                                                                        <?=$obj_block->floorNum()?> этаж
                                                                                    <?}else{?>
                                                                                        -
                                                                                    <?}?>
                                                                                </div>
                                                                                <div class="block_stats" style="border: 1px solid #79a768">
                                                                                    <div class="block-header box-small" style="border-bottom: 1px dashed #b5b5b5; min-height: 70px;">
                                                                                        <div class="isBold">
                                                                                            <?if(!$obj_block->hasStacksStrict()){?>
                                                                                                <input class="block-check" type="checkbox" value="<?=$obj_block->postId()?>"  />
                                                                                            <?}?>
                                                                                            ID <?=$obj_block->getVisualId()?>
                                                                                            <?if($_COOKIE['member_id'] == 941){

                                                                                                var_dump($obj_block->getBlockStacks());
                                                                                            }?>

                                                                                        </div>
                                                                                        <div>
                                                                                            <?/*foreach($obj_block->getJsonField('purposes_block') as $purpose_item){
                                                                                                $purpose = new Post($purpose_item);
                                                                                                $purpose->getTable('l_purposes');?>
                                                                                                <span class="icon-square" title="<?=$purpose->title()?>">
                                                                            <?=$purpose->getField('icon');?>
                                                                        </span>

                                                                                            <?}*/?>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="box obj-block-stats" style="border-bottom: 1px solid #cfcfcf; position: relative;">
                                                                                        <ul>
                                                                                            <?if(!$object->getField('is_land')){?>
                                                                                                <li>
                                                                                                    <b>
                                                                                                        <?= valuesCompare($obj_block->getBlockSumAreaMin(),$obj_block->getBlockSumAreaMax()) ?> <span>м<sup>2</sup></span>
                                                                                                    </b>
                                                                                                </li>
                                                                                            <?}?>
                                                                                            <li><?= valuesCompare($obj_block->getField('area_floor_min'),$obj_block->getField('area_floor_max')) ?> <span>м<sup>2</sup></span></li>
                                                                                            <?if($object->getField('is_land')){?>
                                                                                                <li><?= ($obj_block->getField('floor_type_land')) ? $obj_block->floorType() :  '-'?></li>
                                                                                                <li>
                                                                                                    <?if($obj_block->getField('land_length') && $obj_block->getField('land_width')){?>
                                                                                                        <?=$obj_block->getField('land_length')?><i class="fal fa-times"></i><?=$obj_block->getField('land_width')?>  м.
                                                                                                    <?}?>
                                                                                                </li>
                                                                                                <li>
                                                                                                    <?= ($obj_block->getField('landscape_type')) ? $obj_block->landscapeType() :  '-'?>
                                                                                                </li>
                                                                                            <?}else{?>
                                                                                                <li>
                                                                                                    <?if($obj_block->getField('area_mezzanine_min')){?>
                                                                                                        <?= valuesCompare($obj_block->getField('area_mezzanine_min'),$obj_block->getField('area_mezzanine_max')) ?> <span>м<sup>2</sup> <?=($obj_block->getField('area_mezzanine_add'))? '<span style="color: red;">вмен.</span>' : ''?></span>
                                                                                                    <?}else{?>
                                                                                                        -
                                                                                                    <?}?>
                                                                                                </li>
                                                                                                <li>
                                                                                                    <?if($obj_block->getField('area_office_min')){?>
                                                                                                        <?= valuesCompare($obj_block->getField('area_office_min'),$obj_block->getField('area_office_max')) ?> <span>м<sup>2</sup> <?=($obj_block->getField('area_office_add'))? '<span style="color: red;">вмен.</span>' : ''?></span>
                                                                                                    <?}else{?>
                                                                                                        -
                                                                                                    <?}?>
                                                                                                </li>
                                                                                                <li>
                                                                                                    <?if($obj_block->getField('area_field_min')){?>
                                                                                                        <?= valuesCompare($obj_block->getField('area_field_min'),$obj_block->getField('area_field_max')) ?> <span>м<sup>2</sup> <?=($obj_block->getField('area_office_add'))? '<span style="color: red;">вмен.</span>' : ''?></span>
                                                                                                    <?}else{?>
                                                                                                        -
                                                                                                    <?}?>
                                                                                                </li>
                                                                                                <li>
                                                                                                    <?if($obj_block->getField('area_tech_min')){?>
                                                                                                        <?= valuesCompare($obj_block->getField('area_tech_min'),$obj_block->getField('area_tech_max')) ?> <span>м<sup>2</sup> <?=($obj_block->getField('area_office_add'))? '<span style="color: red;">вмен.</span>' : ''?></span>
                                                                                                    <?}else{?>
                                                                                                        -
                                                                                                    <?}?>
                                                                                                </li>
                                                                                                <li>
                                                                                                    <?if($obj_block->getField('pallet_place_min')){?>
                                                                                                        <?= valuesCompare($obj_block->getField('pallet_place_min'),$obj_block->getField('pallet_place_max')) ?>  п.м.
                                                                                                    <?}else{?>
                                                                                                        -
                                                                                                    <?}?>
                                                                                                </li>
                                                                                                <li><?= ($obj_block->getField('racks')) ? 'есть' : '-'?></li>
                                                                                                <li class="block-info-racks">
                                                                                                    <?if($obj_block->getField('rack_types')) {?>
                                                                                                        <?foreach($obj_block->getJsonField('rack_types') as $type){?>
                                                                                                            <? $rack = new Post($type)?>
                                                                                                            <? $rack->getTable('l_racks_types')?>
                                                                                                            <div>
                                                                                                                <?=$rack->title()?>
                                                                                                            </div>
                                                                                                        <?}?>
                                                                                                    <?}else{?>
                                                                                                        -
                                                                                                    <?}?>
                                                                                                </li>
                                                                                                <li class="block-info-safe-types">
                                                                                                    <?if($obj_block->getField('safe_type')) {?>
                                                                                                        <?foreach($obj_block->getJsonField('safe_type') as $type){?>
                                                                                                            <? $safe_type = new Post($type)?>
                                                                                                            <? $safe_type->getTable('l_safe_types')?>
                                                                                                            <div>
                                                                                                                <?=$safe_type->title()?>
                                                                                                            </div>
                                                                                                        <?}?>
                                                                                                    <?}else{?>
                                                                                                        -
                                                                                                    <?}?>
                                                                                                </li>
                                                                                                <li><?= ($obj_block->getField('cells')) ? 'есть' : '-'?></li>
                                                                                                <li>
                                                                                                    <?if($obj_block->getField('ceiling_height_min')){?>
                                                                                                        <?= valuesCompare($obj_block->getField('ceiling_height_min'),$obj_block->getField('ceiling_height_max')) ?> м
                                                                                                    <?}else{?>
                                                                                                        -
                                                                                                    <?}?>

                                                                                                </li>
                                                                                                <?
                                                                                                $gates = $obj_block->getJsonField('gates');
                                                                                                $gate_types = [];
                                                                                                $sorted_arr = [];

                                                                                                for($i = 0; $i < count($gates); $i = $i+2) {
                                                                                                    if (!in_array($gates[$i], $gate_types) && $gates[$i]!=0) {
                                                                                                        array_push($gate_types, $gates[$i]);
                                                                                                    }
                                                                                                }

                                                                                                //var_dump($glued_arr);

                                                                                                //подсчитываем колво ворот каждого типа
                                                                                                foreach($gate_types as $elem_unique){
                                                                                                    for($i = 0; $i < count($gates); $i = $i+2) {
                                                                                                        if ($gates[$i] == $elem_unique) {
                                                                                                            $sorted_arr[$elem_unique] += $gates[$i+1];
                                                                                                        }
                                                                                                    }
                                                                                                }
                                                                                                ///var_dump($sorted_arr);

                                                                                                ?>
                                                                                                <li class="block-info-gates">
                                                                                                    <?if($sorted_arr){?>
                                                                                                        <?foreach($sorted_arr as $key=>$value){?>
                                                                                                            <?
                                                                                                            $gate = new Post($key);
                                                                                                            $gate->getTable('l_gates_types');
                                                                                                            ?>
                                                                                                            <div class="flex-box">
                                                                                                                <div class="ghost"><?=$value?> шт /</div>  <div><?=$gate->title()?></div>
                                                                                                            </div>
                                                                                                        <?}?>
                                                                                                    <?}else{?>
                                                                                                        -
                                                                                                    <?}?>

                                                                                                </li>
                                                                                                <li>
                                                                                                    <?if($obj_block->getField('enterance_block')){?>
                                                                                                        <?
                                                                                                        $enterance_block = new Post($obj_block->getField('enterance_block'));
                                                                                                        $enterance_block->getTable('l_enterances');
                                                                                                        ?>
                                                                                                        <?=$enterance_block->title()?>
                                                                                                    <?}else{?>
                                                                                                        -
                                                                                                    <?}?>
                                                                                                </li>

                                                                                                <li><?= ($obj_block->getField('cross_docking')) ? 'есть' : '-'?></li>
                                                                                                <li><?= ($obj_block->getField('floor_type')) ? $obj_block->floorType() :  '-'?></li>
                                                                                                <li><?= $obj_block->showObjectBlockStat('load_floor' , ' <span class="degree-fix">т/м<sup>2</sup></span>' , '-') ?> </li>
                                                                                                <li><?= $obj_block->showObjectBlockStat('load_mezzanine' , ' <span class="degree-fix">т/м<sup>2</sup></span>' , '-') ?> </li>
                                                                                                <li><?=($obj_block->getField('column_grid')) ? $obj_block->columnGrid().' м' :  '-'?></li>
                                                                                                <li>
                                                                                                    <?if($obj_block->getField('heated') == 1){?>
                                                                                                        тёплый
                                                                                                    <?}else{?>
                                                                                                        -
                                                                                                    <?}?>
                                                                                                    <?if($temp_min = $obj_block->getField('temperature_min')){?>
                                                                                                        <?=($temp_min > 0) ? '+' : ''?>
                                                                                                        <?=$temp_min?>
                                                                                                        &#176;С
                                                                                                    <?}?>

                                                                                                    <?if($temp_max = $obj_block->getField('temperature_max')){?>
                                                                                                        /
                                                                                                        <?=($temp_max > 0) ? '+' : ''?>
                                                                                                        <?=$temp_max?>
                                                                                                        &#176;С
                                                                                                    <?}?>
                                                                                                </li>
                                                                                                <li>
                                                                                                    <?if($power = $obj_block->getField('power')){?>
                                                                                                        <?=$power?> кВт
                                                                                                    <?}else{?>
                                                                                                        -
                                                                                                    <?}?>
                                                                                                </li>

                                                                                                <?
                                                                                                $cranes = ['elevators','cranes_cathead','cranes_overhead','telphers'];

                                                                                                foreach($cranes as $crane){
                                                                                                    $items = $obj_block->getJsonField($crane);
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

                                                                                                    <li class="block-info-<?=$crane?>">
                                                                                                        <?if($sorted_arr){?>
                                                                                                            <?foreach($sorted_arr as $key=>$value){?>
                                                                                                                <div class="flex-box">
                                                                                                                    <div class="ghost"><?=$value?> шт /</div>  <div><?=$key?> т.</div>
                                                                                                                </div>
                                                                                                            <?}?>
                                                                                                        <?}else{?>
                                                                                                            -
                                                                                                        <?}?>
                                                                                                    </li>

                                                                                                <?}?>

                                                                                                <li><?= ($obj_block->getField('cranes_runways')) ? 'есть' : '-'?></li>
                                                                                                <li><?= ($obj_block->getField('charging_room')) ? 'есть' : '-'?></li>
                                                                                                <li><?= ($obj_block->getField('warehouse_equipment')) ? 'есть' : '-'?></li>

                                                                                            <?}?>

                                                                                        </ul>
                                                                                    </div>
                                                                                    <div class="box obj-block-stats" style="border-bottom: 1px solid #cfcfcf;">
                                                                                        <ul>
                                                                                            <?if($offer->getField('deal_type') == 2){?>
                                                                                                <li>
                                                                                                    <b>
                                                                                                        <?if(!$object->getField('is_land')){?>
                                                                                                            <?= valuesCompare(numFormat($obj_block->getField('price_sale_min')),numFormat($obj_block->getField('price_sale_max'))) ?>
                                                                                                        <?}else{?>
                                                                                                            <?= valuesCompare(numFormat($obj_block->getField('price_floor_min')),numFormat($obj_block->getField('price_floor_max'))) ?>
                                                                                                        <?}?>
                                                                                                        <i class="fal fa-ruble-sign"></i>
                                                                                                    </b>
                                                                                                    <span>м<sup>2</sup></span>   </span>
                                                                                                </li>

                                                                                            <?}elseif($offer->getField('deal_type') == 3){?>
                                                                                                <?
                                                                                                $fields_arr_min = [
                                                                                                    'price_safe_pallet_eu_min',
                                                                                                    'price_safe_pallet_fin_min',
                                                                                                    'price_safe_pallet_us_min',
                                                                                                    'price_safe_pallet_oversized_min',
                                                                                                    'price_safe_cell_small_min',
                                                                                                    'price_safe_cell_middle_min',
                                                                                                    'price_safe_cell_big_min',
                                                                                                    'price_floor_min',
                                                                                                ];

                                                                                                $fields_arr_max= [
                                                                                                    'price_safe_pallet_eu_max',
                                                                                                    'price_safe_pallet_fin_max',
                                                                                                    'price_safe_pallet_us_max',
                                                                                                    'price_safe_pallet_oversized_max',
                                                                                                    'price_safe_cell_small_max',
                                                                                                    'price_safe_cell_middle_max',
                                                                                                    'price_safe_cell_big_max',
                                                                                                    'price_floor_max',
                                                                                                ];
                                                                                                ?>

                                                                                                <li><b><?= valuesCompare(numFormat($obj_block->getBlockMinValueMultiple($fields_arr_min)), numFormat($obj_block->getBlockMaxValueMultiple($fields_arr_max)))?> <i class="fas fa-ruble-sign ghost"></i> п.м.</b></li>
                                                                                            <?}else{?>
                                                                                                <li><b><?= valuesCompare($obj_block->getField('price_floor_min'),$obj_block->getField('price_floor_max')) ?> </b>  <i class="fal fa-ruble-sign"></i> <span>м<sup>2</sup>/год</span></li>
                                                                                                <?if(!$object->getField('is_land')){?>
                                                                                                    <li><?= valuesCompare($obj_block->getField('price_mezzanine_min'),$obj_block->getField('price_mezzanine_max')) ?> <i class="fal fa-ruble-sign"></i> <span>м<sup>2</sup>/год</span> </li>
                                                                                                    <li><?= valuesCompare($obj_block->getField('price_office_min'),$obj_block->getField('price_office_max')) ?> <i class="fal fa-ruble-sign"></i> <span>м<sup>2</sup>/год</span></li>
                                                                                                <?}?>
                                                                                            <?}?>
                                                                                        </ul>
                                                                                    </div>
                                                                                    <div class="ghost flex-box flex-center-center" style="height: 60px; border-bottom: 1px solid grey">
                                                                                        обновл. <?=date('d-m-Y в H:i',$obj_block->getField('last_update'))?>
                                                                                    </div>
                                                                                    <div class="flex-box box-small">
                                                                                        <?if($logedUser->isAdmin()){?>
                                                                                            <div class="icon-round modal-call-btn" data-form="<?=$deal_forms_blocks_arr[$object->getField('is_land')][$offer->getField('deal_type')-1]?>" data-id="<?=$obj_block->postId()?>" data-table="<?=$obj_block->setTableId()?>"  data-modal="edit-all" data-modal-size="modal-middle"><i class="fas fa-pencil-alt"></i></div>
                                                                                        <?}?>
                                                                                        <?if(count($offer->subItemsId()) > 1){?>

                                                                                            <?if(!$obj_block->hasStacksStrict()){?>
                                                                                                <?if($logedUser->isAdmin()){?>
                                                                                                    <div class="icon-round ad-panel-call modal-call-btn1"  data-id="" data-table="" data-modal="panel-ad" data-modal-size="modal-middle" ><i class="fas fa-rocket"></i></div>
                                                                                                <?}?>
                                                                                                <div class="icon-round"><a target="_blank" href="/pdf-test.php?original_id=<?=$obj_block->postId()?>&type_id=1&member_id=<?=$logedUser->member_id()?>"><i class="fas fa-file-pdf"></i></a></div>
                                                                                                <!--
                                                                        <div class="icon-round modal-call-btn"  data-modal="edit-all" data-modal-size="modal-middle" data-id="0" data-table="<?=$obj_block->setTableId()?>" data-names='["email_offers"]' data-values='["<?=json_encode([[$obj_block->postId(),2]])?>"]'><i class="fas fa-envelope" ></i></div>
                                                                        <div class="icon-round"><a href="/create_pdf.php?id=<?=$obj_block->postId()?>&type_id=1" target="_blank"><i class="far fa-file-pdf"></i></a></div>
                                                                        -->

                                                                                                <div class="icon-round icon-star <?=(in_array([$obj_block->postId(),1],$favourites)) ? 'icon-star-active' : ''?>" data-offer-id="[<?=$obj_block->postId()?>,1]"><i class="fas fa-star"></i></div>
                                                                                                <?if($obj_block->getJsonField('photos_360_block') != NULL &&  arrayIsNotEmpty($obj_block->getJsonField('photos_360_block'))){?>
                                                                                                    <div class="icon-round to-end">
                                                                                                        <a href="/tour-360/<?=$obj_block->setTableId()?>/<?=$obj_block->postId()?>/photos_360_block" target="_blank"><span title="Панорама"><i class="fas fa-globe"></i></span></a>
                                                                                                    </div>
                                                                                                <?}?>
                                                                                            <?}?>

                                                                                        <?}?>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div style="max-width: 200px; height: 100vh">
                                                                                <?$table = $obj_block->setTableId()?>
                                                                                <?$id = $obj_block->postId()?>
                                                                                <? include($_SERVER['DOCUMENT_ROOT'].'/templates/forms/panel-ad/index.php')?>
                                                                            </div>
                                                                        </div>
                                                                        <?$block_num++?>
                                                                    <?}?>

                                                                    <?foreach ($offer->subItemsIdFake() as $obj_block){?>
                                                                        <?$obj_block = new Subitem($obj_block)?>
                                                                        <?
                                                                        $color_arr = [
                                                                            '-3'=>'',
                                                                            '-2'=>'#ec7b7b',
                                                                            '-1'=>'#03c1eb',
                                                                            '1'=>'#0370eb',
                                                                            '2'=>'#ec8d7b',
                                                                            '3'=>'#97bfad',
                                                                            '4'=>'#edaa70',
                                                                            '5'=>'#12f91c',
                                                                            '6'=>'#9900CC',
                                                                            '7'=>'#3399FF',
                                                                            '8'=>'#FF3399',
                                                                            '9'=>'#339933',
                                                                            '10'=>'#33CCFF',
                                                                        ];

                                                                        ?>
                                                                        <div class="flex-box flex-vertical-top tab <?=($obj_block->getField('status') == 2 ) ? 'ghost' : ''?>">
                                                                            <div class="object-block stack-block " style="width: 200px ;">
                                                                                <div>
                                                                                    <input class="blocks-parts-info" type="hidden"  value='<?=$obj_block->getField('parts')?>'/>
                                                                                </div>
                                                                                <div class="box " style="background: <?=($obj_block->getField('stack_strict')) ? '#a51a00' : '#2a4d00' ;?>; color: #FFFFFF;">
                                                                                    Связь смежных блоков
                                                                                </div>
                                                                                <div class="block_stats" style="border: 1px solid #79a768">
                                                                                    <div class="block-header box-small" style="border-bottom: 1px dashed #b5b5b5; min-height: 70px;">
                                                                                        <div class="">
                                                                                            <?$blocks_parts = '';?>
                                                                                            <?foreach ($obj_block->getJsonField('parts') as $part){?>
                                                                                                <?$part_obj = new Subitem($part)?>
                                                                                                <?//$blocks_parts .= $part_obj->getVisualId()?>
                                                                                                <?$blocks_parts .= ', '?>
                                                                                            <?}?>
                                                                                            <?=trim($blocks_parts,',')?>

                                                                                        </div>
                                                                                        <div>
                                                                                            <?foreach($obj_block->getJsonField('purposes_block') as $purpose_item){
                                                                                                $purpose = new Post($purpose_item);
                                                                                                $purpose->getTable('l_purposes');?>
                                                                                                <span class="icon-square" title="<?=$purpose->title()?>">
                                                                            <?=$purpose->getField('icon');?>
                                                                        </span>

                                                                                            <?}?>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="box obj-block-stats" style="border-bottom: 1px solid #cfcfcf; position: relative;">
                                                                                        <ul>

                                                                                            <?if(!$object->getField('is_land')){?>
                                                                                                <li>
                                                                                                    <b>
                                                                                                        <?= valuesCompare($obj_block->getBlockSumAreaMin(),$obj_block->getBlockSumAreaMax()) ?> <span>м<sup>2</sup></span>
                                                                                                    </b>
                                                                                                </li>
                                                                                            <?}?>
                                                                                            <li><?= valuesCompare($obj_block->getField('area_floor_min'),$obj_block->getField('area_floor_max')) ?> <span>м<sup>2</sup></span></li>
                                                                                            <?if($object->getField('is_land')){?>
                                                                                                <li><?= ($obj_block->getField('floor_type_land')) ? $obj_block->floorType() :  '-'?></li>
                                                                                                <li>
                                                                                                    <?if($obj_block->getField('land_length') && $obj_block->getField('land_width')){?>
                                                                                                        <?=$obj_block->getField('land_length')?><i class="fal fa-times"></i><?=$obj_block->getField('land_width')?>  м.
                                                                                                    <?}?>
                                                                                                </li>
                                                                                                <li>
                                                                                                    <?= ($obj_block->getField('landscape_type')) ? $obj_block->landscapeType() :  '-'?>
                                                                                                </li>
                                                                                            <?}else{?>
                                                                                                <li>
                                                                                                    <?if($obj_block->getField('area_mezzanine_min')){?>
                                                                                                        <?= valuesCompare($obj_block->getField('area_mezzanine_min'),$obj_block->getField('area_mezzanine_max')) ?> <span>м<sup>2</sup> <?=($obj_block->getField('area_mezzanine_add'))? '<span style="color: red;">вмен.</span>' : ''?></span>
                                                                                                    <?}else{?>
                                                                                                        -
                                                                                                    <?}?>
                                                                                                </li>
                                                                                                <li>
                                                                                                    <?if($obj_block->getField('area_office_min')){?>
                                                                                                        <?= valuesCompare($obj_block->getField('area_office_min'),$obj_block->getField('area_office_max')) ?> <span>м<sup>2</sup> <?=($obj_block->getField('area_office_add'))? '<span style="color: red;">вмен.</span>' : ''?></span>
                                                                                                    <?}else{?>
                                                                                                        -
                                                                                                    <?}?>
                                                                                                </li>
                                                                                                <li>
                                                                                                    <?if($obj_block->getField('area_field_min')){?>
                                                                                                        <?= valuesCompare($obj_block->getField('area_field_min'),$obj_block->getField('area_field_max')) ?> <span>м<sup>2</sup> <?=($obj_block->getField('area_office_add'))? '<span style="color: red;">вмен.</span>' : ''?></span>
                                                                                                    <?}else{?>
                                                                                                        -
                                                                                                    <?}?>
                                                                                                </li>
                                                                                                <li>
                                                                                                    <?if($obj_block->getField('area_tech_min')){?>
                                                                                                        <?= valuesCompare($obj_block->getField('area_tech_min'),$obj_block->getField('area_tech_max')) ?>  <span>м<sup>2</sup> <?=($obj_block->getField('area_office_add'))? '<span style="color: red;">вмен.</span>' : ''?></span>
                                                                                                    <?}else{?>
                                                                                                        -
                                                                                                    <?}?>
                                                                                                </li>
                                                                                                <li>
                                                                                                    <?if($obj_block->getField('pallet_place_min')){?>
                                                                                                        <?= valuesCompare($obj_block->getField('pallet_place_min'),$obj_block->getField('pallet_place_max')) ?>  п.м.
                                                                                                    <?}else{?>
                                                                                                        -
                                                                                                    <?}?>
                                                                                                </li>
                                                                                                <li><?= ($obj_block->getField('racks')) ? 'есть' : '-'?></li>
                                                                                                <li class="block-info-racks">
                                                                                                    <?if($obj_block->getField('rack_types')) {?>
                                                                                                        <?foreach($obj_block->getJsonField('rack_types') as $type){?>
                                                                                                            <? $rack = new Post($type)?>
                                                                                                            <? $rack->getTable('l_racks_types')?>
                                                                                                            <div>
                                                                                                                <?=$rack->title()?>
                                                                                                            </div>
                                                                                                        <?}?>
                                                                                                    <?}else{?>
                                                                                                        -
                                                                                                    <?}?>
                                                                                                </li>
                                                                                                <li class="block-info-safe-types">
                                                                                                    <?if($obj_block->getField('safe_type')) {?>
                                                                                                        <?foreach($obj_block->getJsonField('safe_type') as $type){?>
                                                                                                            <? $safe_type = new Post($type)?>
                                                                                                            <? $safe_type->getTable('l_safe_types')?>
                                                                                                            <div>
                                                                                                                <?=$safe_type->title()?>
                                                                                                            </div>
                                                                                                        <?}?>
                                                                                                    <?}else{?>
                                                                                                        -
                                                                                                    <?}?>
                                                                                                </li>
                                                                                                <li><?= ($obj_block->getField('cells')) ? 'есть' : '-'?></li>
                                                                                                <li>
                                                                                                    <?if($obj_block->getField('ceiling_height_min')){?>
                                                                                                        <?= valuesCompare($obj_block->getField('ceiling_height_min'),$obj_block->getField('ceiling_height_max')) ?> м
                                                                                                    <?}else{?>
                                                                                                        -
                                                                                                    <?}?>

                                                                                                </li>
                                                                                                <?
                                                                                                $gates = $obj_block->getJsonField('gates');
                                                                                                $gate_types = [];
                                                                                                $sorted_arr = [];

                                                                                                for($i = 0; $i < count($gates); $i = $i+2) {
                                                                                                    if (!in_array($gates[$i], $gate_types) && $gates[$i]!=0) {
                                                                                                        array_push($gate_types, $gates[$i]);
                                                                                                    }
                                                                                                }

                                                                                                //var_dump($glued_arr);

                                                                                                //подсчитываем колво ворот каждого типа
                                                                                                foreach($gate_types as $elem_unique){
                                                                                                    for($i = 0; $i < count($gates); $i = $i+2) {
                                                                                                        if ($gates[$i] == $elem_unique) {
                                                                                                            $sorted_arr[$elem_unique] += $gates[$i+1];
                                                                                                        }
                                                                                                    }
                                                                                                }
                                                                                                ///var_dump($sorted_arr);

                                                                                                ?>
                                                                                                <li class="block-info-gates">
                                                                                                    <?if($sorted_arr){?>
                                                                                                        <?foreach($sorted_arr as $key=>$value){?>
                                                                                                            <?
                                                                                                            $gate = new Post($key);
                                                                                                            $gate->getTable('l_gates_types');
                                                                                                            ?>
                                                                                                            <div class="flex-box">
                                                                                                                <div class="ghost"><?=$value?> шт /</div>  <div><?=$gate->title()?></div>
                                                                                                            </div>
                                                                                                        <?}?>
                                                                                                    <?}else{?>
                                                                                                        -
                                                                                                    <?}?>

                                                                                                </li>
                                                                                                <li>
                                                                                                    <?if($obj_block->getField('enterance_block')){?>
                                                                                                        <?
                                                                                                        $enterance_block = new Post($obj_block->getField('enterance_block'));
                                                                                                        $enterance_block->getTable('l_enterances');
                                                                                                        ?>
                                                                                                        <?=$enterance_block->title()?>
                                                                                                    <?}else{?>
                                                                                                        -
                                                                                                    <?}?>
                                                                                                </li>

                                                                                                <li><?= ($obj_block->getField('cross_docking')) ? 'есть' : '-'?></li>
                                                                                                <li><?= ($obj_block->getField('floor_type')) ? $obj_block->floorType() :  '-'?></li>
                                                                                                <li><?= $obj_block->showObjectBlockStat('load_floor' , ' <span class="degree-fix">т/м<sup>2</sup></span>' , '-') ?> </li>
                                                                                                <li><?= $obj_block->showObjectBlockStat('load_mezzanine' , ' <span class="degree-fix">т/м<sup>2</sup></span>' , '-') ?> </li>
                                                                                                <li><?=($obj_block->getField('column_grid')) ? $obj_block->columnGrid().' м' :  '-'?></li>
                                                                                                <li>
                                                                                                    <?if($temp_min = $obj_block->getField('temperature_min')){?>
                                                                                                        <?=($temp_min > 0) ? '+' : ''?>
                                                                                                        <?=$temp_min?>
                                                                                                        &#176;С
                                                                                                    <?}?>
                                                                                                    <?if($obj_block->getField('heated') == 1){?>
                                                                                                        тёплый
                                                                                                    <?}else{?>
                                                                                                        -
                                                                                                    <?}?>


                                                                                                    <?if($temp_max = $obj_block->getField('temperature_max')){?>
                                                                                                        /
                                                                                                        <?=($temp_max > 0) ? '+' : ''?>
                                                                                                        <?=$temp_max?>
                                                                                                        &#176;С
                                                                                                    <?}?>
                                                                                                </li>
                                                                                                <li>
                                                                                                    <?if($power = $obj_block->getField('power')){?>
                                                                                                        <?=$power?> кВт
                                                                                                    <?}else{?>
                                                                                                        -
                                                                                                    <?}?>
                                                                                                </li>

                                                                                                <?
                                                                                                $cranes = ['elevators','cranes_cathead','cranes_overhead','telphers'];

                                                                                                foreach($cranes as $crane){
                                                                                                    $items = $obj_block->getJsonField($crane);
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

                                                                                                    <li class="block-info-<?=$crane?>">
                                                                                                        <?if($sorted_arr){?>
                                                                                                            <?foreach($sorted_arr as $key=>$value){?>
                                                                                                                <div class="flex-box">
                                                                                                                    <div class="ghost"><?=$value?> шт /</div>  <div><?=$key?> т.</div>
                                                                                                                </div>
                                                                                                            <?}?>
                                                                                                        <?}else{?>
                                                                                                            -
                                                                                                        <?}?>
                                                                                                    </li>

                                                                                                <?}?>

                                                                                                <li><?= ($obj_block->getField('cranes_runways')) ? 'есть' : '-'?></li>
                                                                                                <li><?= ($obj_block->getField('charging_room')) ? 'есть' : '-'?></li>
                                                                                                <li><?= ($obj_block->getField('warehouse_equipment')) ? 'есть' : '-'?></li>

                                                                                            <?}?>

                                                                                        </ul>
                                                                                    </div>
                                                                                    <div class="box obj-block-stats" style="border-bottom: 1px solid #cfcfcf;">
                                                                                        <ul>
                                                                                            <?if($offer->getField('deal_type') == 2){?>
                                                                                                <li>
                                                                                                    <b>
                                                                                                        <?if(!$object->getField('is_land')){?>
                                                                                                            <?= valuesCompare(numFormat($obj_block->getField('price_sale_min')),numFormat($obj_block->getField('price_sale_max'))) ?>
                                                                                                        <?}else{?>
                                                                                                            <?= valuesCompare(numFormat($obj_block->getField('price_floor_min')),numFormat($obj_block->getField('price_floor_max'))) ?>
                                                                                                        <?}?>
                                                                                                        <i class="fal fa-ruble-sign"></i>
                                                                                                    </b>
                                                                                                    <span>м<sup>2</sup></span>   </span>
                                                                                                </li>

                                                                                            <?}elseif($offer->getField('deal_type') == 3){?>
                                                                                                <?
                                                                                                $fields_arr_min = [
                                                                                                    'price_safe_pallet_eu_min',
                                                                                                    'price_safe_pallet_fin_min',
                                                                                                    'price_safe_pallet_us_min',
                                                                                                    'price_safe_pallet_oversized_min',
                                                                                                    'price_safe_cell_small_min',
                                                                                                    'price_safe_cell_middle_min',
                                                                                                    'price_safe_cell_big_min',
                                                                                                    'price_floor_min',
                                                                                                ];

                                                                                                $fields_arr_max= [
                                                                                                    'price_safe_pallet_eu_max',
                                                                                                    'price_safe_pallet_fin_max',
                                                                                                    'price_safe_pallet_us_max',
                                                                                                    'price_safe_pallet_oversized_max',
                                                                                                    'price_safe_cell_small_max',
                                                                                                    'price_safe_cell_middle_max',
                                                                                                    'price_safe_cell_big_max',
                                                                                                    'price_floor_max',
                                                                                                ];
                                                                                                ?>

                                                                                                <li><b><?= valuesCompare(numFormat($obj_block->getBlockMinValueMultiple($fields_arr_min)), numFormat($obj_block->getBlockMaxValueMultiple($fields_arr_max)))?> <i class="fas fa-ruble-sign ghost"></i> п.м.</b></li>
                                                                                            <?}else{?>
                                                                                                <li><b><?= valuesCompare($obj_block->getField('price_floor_min'),$obj_block->getField('price_floor_max')) ?> </b>  <i class="fal fa-ruble-sign"></i> <span>м<sup>2</sup>/год</span></li>
                                                                                                <?if(!$object->getField('is_land')){?>
                                                                                                    <li><?= valuesCompare($obj_block->getField('price_mezzanine_min'),$obj_block->getField('price_mezzanine_max')) ?> <i class="fal fa-ruble-sign"></i> <span>м<sup>2</sup>/год</span> </li>
                                                                                                    <li><?= valuesCompare($obj_block->getField('price_office_min'),$obj_block->getField('price_office_max')) ?> <i class="fal fa-ruble-sign"></i> <span>м<sup>2</sup>/год</span></li>
                                                                                                <?}?>
                                                                                            <?}?>
                                                                                        </ul>
                                                                                    </div>
                                                                                    <div class="ghost flex-box flex-center-center" style="height: 60px; border-bottom: 1px solid grey">
                                                                                        обновл. <?=date('d-m-Y в H:i',$obj_block->getField('last_update'))?>
                                                                                    </div>
                                                                                    <div class="flex-box box-small">
                                                                                        <?if($logedUser->isAdmin()){?>
                                                                                            <div class="icon-round modal-call-btn" data-form="<?=$deal_forms_blocks_arr[$object->getField('is_land')][$offer->getField('deal_type')-1]?>" data-id="<?=$obj_block->postId()?>" data-table="<?=$obj_block->setTableId()?>"  data-modal="edit-all" data-modal-size="modal-middle"><i class="fas fa-pencil-alt"></i></div>
                                                                                        <?}?>
                                                                                        <?if(count($offer->subItemsId()) > 1){?>
                                                                                            <?if($logedUser->isAdmin()){?>
                                                                                                <div class="icon-round ad-panel-call modal-call-btn1"  data-id="" data-table="" data-modal="panel-ad" data-modal-size="modal-middle" ><i class="fas fa-rocket"></i></div>
                                                                                            <?}?>
                                                                                            <div class="icon-round"><a target="_blank" href="/pdf-test.php?original_id=<?=$obj_block->postId()?>&type_id=1&member_id=<?=$logedUser->member_id()?>"><i class="fas fa-file-pdf"></i></a></div>
                                                                                            <!--
                                                                    <div class="icon-round modal-call-btn"  data-modal="edit-all" data-modal-size="modal-middle" data-id="0" data-table="<?=$obj_block->setTableId()?>" data-names='["email_offers"]' data-values='["<?=json_encode([[$obj_block->postId(),2]])?>"]'><i class="fas fa-envelope" ></i></div>
                                                                    <div class="icon-round"><a href="/create_pdf.php?id=<?=$obj_block->postId()?>&type_id=1" target="_blank"><i class="far fa-file-pdf"></i></a></div>
                                                                    -->

                                                                                            <div class="icon-round icon-star <?=(in_array([$obj_block->postId(),1],$favourites)) ? 'icon-star-active' : ''?>" data-offer-id="[<?=$obj_block->postId()?>,1]"><i class="fas fa-star"></i></div>
                                                                                            <?if($obj_block->getJsonField('photos_360_block') != NULL &&  arrayIsNotEmpty($obj_block->getJsonField('photos_360_block'))){?>
                                                                                                <div class="icon-round to-end">
                                                                                                    <a href="/tour-360/<?=$obj_block->setTableId()?>/<?=$obj_block->postId()?>/photos_360_block" target="_blank"><span title="Панорама"><i class="fas fa-globe"></i></span></a>
                                                                                                </div>
                                                                                            <?}?>
                                                                                            <?if($logedUser->isAdmin()){?>
                                                                                                <div class="icon-round modal-call-btn to-end" data-form="<?=$deal_forms_blocks_arr[$object->getField('is_land')][$offer->getField('deal_type')-1]?>" data-id="<?=$obj_block->postId()?>" data-table="<?=$obj_block->setTableId()?>"  data-modal="delete" data-modal-size="modal-small" title="Разорвать связь"><i class="far fa-trash-alt"></i></div>
                                                                                            <?}?>
                                                                                        <?}?>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div style="max-width: 200px; height: 100vh">
                                                                                <?$table = $obj_block->setTableId()?>
                                                                                <?$id = $obj_block->postId()?>
                                                                                <? include($_SERVER['DOCUMENT_ROOT'].'/templates/forms/panel-ad/index.php')?>
                                                                            </div>
                                                                        </div>
                                                                        <?$block_num++?>
                                                                    <?}?>


                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <br>
                                                    <div class="tabs-content">
                                                        <?foreach ($offer->subItemsIdFloors() as $obj_block){?>
                                                            <?$obj_block = new Subitem($obj_block)?>
                                                            <div class="tab-content " style="background: #f3f7ef">
                                                                <div class="offer-description box-small full-width">
                                                                    <div class="flex-box" style="overflow-x: scroll">
                                                                        <?foreach ($obj_block->getJsonField('photo_block') as $photo){?>
                                                                            <?$photo = array_pop(explode('/',str_replace('//','/',$photo)))?>
                                                                            <div class="box-small">
                                                                                <div class="background-fix modal-call-btn" data-modal="photo-slider" data-modal-size="modal-big" data-id="<?=$photo?>"  data-table=""  data-names='["post_id","table_id","photo_field"]' data-values='[<?=$obj_block->postId()?>,<?=$obj_block->setTableId()?>,"photo_block"]' style="width: 140px; height: 70px; background: url('<?=PROJECT_URL.'/system/controllers/photos/thumb.php/300/'.$object->postId().'/'.$photo ?>')">

                                                                                </div>
                                                                            </div>
                                                                        <?}?>
                                                                    </div>
                                                                    <div>
                                                                        <?$table = $obj_block->setTableId()?>
                                                                        <?$id = $obj_block->postId()?>
                                                                        <? include($_SERVER['DOCUMENT_ROOT'].'/templates/forms/panel-description/index.php')?>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        <?}?>
                                                        <?foreach ($offer->subItemsIdFake() as $obj_block){?>
                                                            <?$obj_block = new Subitem($obj_block)?>
                                                            <div class="tab-content " style="background: #f3f7ef">
                                                                <div class="offer-description box-small full-width">
                                                                    <div class="flex-box" style="overflow-x: scroll">
                                                                        <?foreach ($obj_block->getJsonField('photo_block') as $photo){?>
                                                                            <?$photo = array_pop(explode('/',str_replace('//','/',$photo)))?>
                                                                            <div class="box-small">
                                                                                <div class="background-fix modal-call-btn" data-modal="photo-slider" data-modal-size="modal-big" data-id="<?=$photo?>"  data-table=""  data-names='["post_id","table_id","photo_field"]' data-values='[<?=$obj_block->postId()?>,<?=$obj_block->setTableId()?>,"photo_block"]' style="width: 140px; height: 70px; background: url('<?=PROJECT_URL.'/system/controllers/photos/thumb.php/300/'.$object->postId().'/'.$photo ?>')">

                                                                                </div>
                                                                            </div>
                                                                        <?}?>
                                                                    </div>
                                                                    <div>
                                                                        <?$table = $obj_block->setTableId()?>
                                                                        <?$id = $obj_block->postId()?>
                                                                        <? include($_SERVER['DOCUMENT_ROOT'].'/templates/forms/panel-description/index.php')?>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        <?}?>
                                                    </div>
                                                </div>



                                                <div class="box">

                                                </div>

                                            </div>
                                        </div>
                                    <?}?>
                                </div>

                            </div>

                            <div class="card-history-area">
                                <div class="card-history-form">

                                </div>
                                <div class="card-history-events">
                                    <div class="card-history-event">

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-content obj-part-content">
                        <div class="files-grid flex-box full-width">
                            <?if($object->itemId()){?>
                                <? if($object->showJsonField('building_layouts') != NULL){?>
                                    <?foreach($object->showJsonField('building_layouts') as $file_unit){?>
                                        <div class='files-grid-unit' data-src="<?=$file_unit?>" >
                                            <?$ext = getFileExtension($file_unit)?>
                                            <div class="text_center full-height flex-box flex-box-vertical grey-border">
                                                <div class="box">

                                                </div>
                                                <div style="font-size: 60px;" title="<?=getFilePureName($file_unit)?> <?=$ext?>">
                                                    <?=getFileIcon($file_unit)?>
                                                </div>
                                                <div title="<?=getFilePureName($file_unit)?>" class="box-small text_center full-width to-end-vertical grey-background" >
                                                    <a href="<?=$file_unit?>" target="_blank" class="text_center">
                                                        <div class="flex-box flex-center">
                                                            <div class="box-wide" style="font-size: 20px;">
                                                                <?=getFileIcon($file_unit)?>
                                                            </div>
                                                            <div>
                                                                <?=getFileNameShort($file_unit)?> <?=$ext?>
                                                            </div>
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="file-delete icon-round"  >
                                                <i class='fa fa-times' aria-hidden='true'></i>
                                            </div>
                                        </div>
                                    <?}?>
                                <?}?>
                            <?}?>
                        </div>
                    </div>
                    <div class="tab-content obj-part-content">
                        <div class="files-grid flex-box full-width">
                            <?if($object->itemId()){?>
                                <? if($object->showJsonField('building_presentations') != NULL){?>
                                    <?foreach($object->showJsonField('building_presentations') as $file_unit){?>
                                        <div class='files-grid-unit' data-src="<?=$file_unit?>" >
                                            <?$ext = getFileExtension($file_unit)?>
                                            <div class="text_center full-height flex-box flex-box-vertical grey-border">
                                                <div class="box">

                                                </div>
                                                <div style="font-size: 60px;" title="<?=getFilePureName($file_unit)?> <?=$ext?>">
                                                    <?=getFileIcon($file_unit)?>
                                                </div>
                                                <div title="<?=getFilePureName($file_unit)?>" class="box-small text_center full-width to-end-vertical grey-background" >
                                                    <a href="<?=$file_unit?>" target="_blank" class="text_center">
                                                        <div class="flex-box flex-center">
                                                            <div class="box-wide" style="font-size: 20px;">
                                                                <?=getFileIcon($file_unit)?>
                                                            </div>
                                                            <div>
                                                                <?=getFileNameShort($file_unit)?> <?=$ext?>
                                                            </div>
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="file-delete icon-round"  >
                                                <i class='fa fa-times' aria-hidden='true'></i>
                                            </div>
                                        </div>
                                    <?}?>
                                <?}?>
                            <?}?>
                        </div>
                    </div>
                    <div class="tab-content obj-part-content">
                        <div class="files-grid flex-box full-width">
                            <?if($object->itemId()){?>
                                <? if($object->showJsonField('building_contracts') != NULL){?>
                                    <?foreach($object->showJsonField('building_contracts') as $file_unit){?>
                                        <div class='files-grid-unit' data-src="<?=$file_unit?>" >
                                            <?$ext = getFileExtension($file_unit)?>
                                            <div class="text_center full-height flex-box flex-box-vertical grey-border">
                                                <div class="box">

                                                </div>
                                                <div style="font-size: 60px;" title="<?=getFilePureName($file_unit)?> <?=$ext?>">
                                                    <?=getFileIcon($file_unit)?>
                                                </div>
                                                <div title="<?=getFilePureName($file_unit)?>" class="box-small text_center full-width to-end-vertical grey-background" >
                                                    <a href="<?=$file_unit?>" target="_blank" class="text_center">
                                                        <div class="flex-box flex-center">
                                                            <div class="box-wide" style="font-size: 20px;">
                                                                <?=getFileIcon($file_unit)?>
                                                            </div>
                                                            <div>
                                                                <?=getFileNameShort($file_unit)?> <?=$ext?>
                                                            </div>
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="file-delete icon-round"  >
                                                <i class='fa fa-times' aria-hidden='true'></i>
                                            </div>
                                        </div>
                                    <?}?>
                                <?}?>
                            <?}?>
                        </div>
                    </div>
                    <div class="tab-content obj-part-content">
                        <div class="files-grid flex-box full-width">
                            <?if($object->itemId()){?>
                                <? if($object->showJsonField('building_property_documents') != NULL){?>
                                    <?foreach($object->showJsonField('building_property_documents') as $file_unit){?>
                                        <div class='files-grid-unit' data-src="<?=$file_unit?>" >
                                            <?$ext = getFileExtension($file_unit)?>
                                            <div class="text_center full-height flex-box flex-box-vertical grey-border">
                                                <div class="box">

                                                </div>
                                                <div style="font-size: 60px;" title="<?=getFilePureName($file_unit)?> <?=$ext?>">
                                                    <?=getFileIcon($file_unit)?>
                                                </div>
                                                <div title="<?=getFilePureName($file_unit)?>" class="box-small text_center full-width to-end-vertical grey-background" >
                                                    <a href="<?=$file_unit?>" target="_blank" class="text_center">
                                                        <div class="flex-box flex-center">
                                                            <div class="box-wide" style="font-size: 20px;">
                                                                <?=getFileIcon($file_unit)?>
                                                            </div>
                                                            <div>
                                                                <?=getFileNameShort($file_unit)?> <?=$ext?>
                                                            </div>
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="file-delete icon-round"  >
                                                <i class='fa fa-times' aria-hidden='true'></i>
                                            </div>
                                        </div>
                                    <?}?>
                                <?}?>
                            <?}?>
                        </div>


                        <?

                        $id = $object->postId();
                        $table_name = 'objects';

                        $files = array_diff( scandir(PROJECT_ROOT."/uploads/files_old/$table_name/$id/"), ['..', '.']); //иначе scandir() дает точки
                        $files_list = [];

                        //echo 'лот номер'. "<b>$id</b>";
                        //echo 'его фотки далее<br>';
                        foreach ($files as $file) {
                            $files_list[] = PROJECT_ROOT."/uploads/files_old/$table_name/$id/".$file;
                        }

                        //var_dump($files_list);
                        ?>

                        <?if(count($files_list) > 0){?>
                            <div class="form-files  files-list   " style="min-width :300px;">
                                Документы старой базы
                                <div class=" flex-box flex-wrap files-grid" >
                                    <?if($object->postId()){?>
                                        <? if($files != NULL){?>
                                            <?foreach($files_list as $file_unit){?>
                                                <div class='files-grid-unit' data-src="<?=$file_unit?>" >
                                                    <?$ext = getFileExtension($file_unit)?>
                                                    <div class="text_center full-height flex-box flex-box-vertical grey-border">
                                                        <div class="box">

                                                        </div>
                                                        <div style="font-size: 60px;" title="<?=getFilePureName($file_unit)?> <?=$ext?>">
                                                            <?=getFileIcon($file_unit)?>
                                                        </div>
                                                        <div title="<?=getFilePureName($file_unit)?>" class="box-small text_center full-width to-end-vertical grey-background" >
                                                            <a href="<?=$file_unit?>" target="_blank" class="text_center">
                                                                <div class="flex-box flex-center">
                                                                    <div class="box-wide" style="font-size: 20px;">
                                                                        <?=getFileIcon($file_unit)?>
                                                                    </div>
                                                                    <div>
                                                                        <a href="<?= "/uploads/files_old/$table_name/$id/".array_pop(explode('/',$file_unit))?>" target="_blank">
                                                                            <?=array_pop(explode('/',$file_unit))?> <?//=$ext?>
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?}?>
                                        <?}?>
                                    <?}?>
                                </div>
                            </div>
                        <?}?>

                    </div>
                    <div class="tab-content obj-part-content">
                        <?if($object->itemId()){?>
                            <? if($object->showJsonField('photos_360') != NULL){?>
                                <?foreach($object->showJsonField('photos_360') as $file_unit){?>
                                    <div class='files-grid-unit' data-src="<?=$file_unit?>" >
                                        <?$ext = getFileExtension($file_unit)?>
                                        <div class="text_center full-height flex-box flex-box-vertical grey-border">
                                            <div class="box">

                                            </div>
                                            <div style="font-size: 60px;" title="<?=getFilePureName($file_unit)?> <?=$ext?>">
                                                <?=getFileIcon($file_unit)?>
                                            </div>
                                            <div title="<?=getFilePureName($file_unit)?>" class="box-small text_center full-width to-end-vertical grey-background" >
                                                <a href="<?=$file_unit?>" target="_blank" class="text_center">
                                                    <div class="flex-box flex-center">
                                                        <div class="box-wide" style="font-size: 20px;">
                                                            <?=getFileIcon($file_unit)?>
                                                        </div>
                                                        <div>
                                                            <?=getFileNameShort($file_unit)?> <?=$ext?>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="file-delete icon-round"  >
                                            <i class='fa fa-times' aria-hidden='true'></i>
                                        </div>
                                    </div>
                                <?}?>
                            <?}?>
                        <?}?>

                    </div>
                    <div class="tab-content obj-part-content">
                        <div class="full-width">
                            <?$table = $object->setTableId()?>
                            <?$id = $object->postId()?>
                            <? include($_SERVER['DOCUMENT_ROOT'].'/templates/forms/panel-description/index.php')?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>


