<? include($_SERVER['DOCUMENT_ROOT'] . '/templates/objects/header/index_new.php') ?>
<? if ($logedUser->member_id() == 941) { ?>
    <? include($_SERVER['DOCUMENT_ROOT'] . '/errors.php') ?>
<? } ?>



<div class="box-small object-card" style="border: 2px dashed #9E9E9E; margin-bottom: 20px; position: relative; background: #e8e8e8">


    <div>
        <div class="object-id flex-box box-small isBold" style="position: absolute; z-index: 9; left: 18px; top: 24px;  background: #982e06; width: 160px; font-size: 16px; color: white; ">
            <div class="box-wide">

            </div>
            <div class="isBold">
                <b>
                    <div style="color: white;">
                        ID <?= $object_id ?>
                    </div>
                </b>
            </div>
            <? if ($logedUser->isAdmin()) { ?>
                <div class="box-wide pointer modal-call-btn" data-form="<?= ($object->getField('is_land')) ? 'land' : 'building' ?>" data-id="<?= $object->postId() ?>" data-table="<?= $object->setTableId() ?>" data-names='["redirect"]' data-values="[1]" data-modal="edit-all" data-modal-size="modal-big">
                    <span title="Редактировать"><i class="fas fa-pencil-alt"></i></span>
                </div>
            <? } ?>
        </div>

        <div class="card-photo-area box-vertical">
            <div class="flex-box flex-wrap files-grid">
                <? $i = 1;

                $obj_photos = $object->getJsonField('photo');
                $photo_amount = count($obj_photos);
                $photo_num = 0;
                for ($i = 0; $i < 4; $i++) { ?>
                    <? $thumb = $obj_photos[$i] ?>
                    <? $photo = array_pop(explode('/', str_replace('//', '/', $thumb))) ?>
                    <div class="flex-box files-grid-unit">
                        <div class="flex-box modal-call-btn flex-around background-fix photo-container" data-modal="photo-slider" data-names='["post_id","table_id","photo_field","slide_num" ]' data-values='[<?= $object->postId() ?>,<?= $object->setTableId() ?>,"photo",<?= $i + 1 ?>]' data-table="1" data-id="<?= $thumb ?>" data-modal-size="modal-big" style=" background-image: url('<? //=PROJECT_URL.'/system/controllers/photos/thumb_all.php?width=300&photo='.PROJECT_URL.$thumb*/ 
                                                                                                                                                                                                                                                                                                                                                                                                ?><?= PROJECT_URL . '/system/controllers/photos/thumb.php/300/' . $object->postId() . '/' . $photo ?>') ">

                        </div>
                    </div>
                <? } ?>
                <? if ($photo_amount > 4) { ?>
                    <div class="flex-box files-grid-unit flex-wrap">
                        <? for ($i = 4; $i < $photo_amount; $i++) { ?>
                            <? $thumb = $obj_photos[$i] ?>
                            <? $photo = array_pop(explode('/', str_replace('//', '/', $thumb))) ?>
                            <? $small_more = $photo_amount - 4; ?>
                            <?
                            $width = 100;
                            $height = 100;
                            ?>
                            <? if ($small_more == 2) {
                                $height = 50;
                            } elseif ($small_more > 2) {
                                $width = 50;
                                $height = 50;
                            } else {
                            } ?>
                            <div class="flex-box modal-call-btn flex-around background-fix photo-container" data-modal="photo-slider" data-names='["post_id","table_id","photo_field","slide_num"  ]' data-values='[<?= $object->postId() ?>,<?= $object->setTableId() ?>,"photo",<?= $i + 1 ?>]' data-table="1" data-id="<?= $thumb ?>" data-modal-size="modal-big" style=" background-image: url('<?= PROJECT_URL . '/system/controllers/photos/thumb.php/300/' . $object->postId() . '/' . $photo ?>'); width: <?= $width ?>%; height: <?= $height ?>%; ">
                                <? if ($i > 6) { ?>
                                    <div class="isBold photos-more-count" style="font-size: 30px; color: white; cursor: pointer; text-shadow: 1px 1px 2px black, 0 0 1em #000000;  ">
                                        +<?= (count($obj_photos) - $i) ?> фото
                                    </div>
                                <? } ?>
                            </div>
                            <? if ($i > 6) {
                                break;
                            } ?>
                        <? } ?>
                    </div>
                <? } ?>
            </div>
            <div class="flex-box hidden flex-wrap files-grid ">
                <?
                $videos = $object->getJsonField('videos');
                ?>
                <? if (arrayIsNotEmpty($videos)) { ?>
                    <? foreach ($videos as $video) { ?>
                        <div class="files-grid-unit">
                            <iframe width="100%" height="100%" src="https://www.youtube.com/embed/<?= getYoutubeId($video) ?>" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                        </div>
                    <? } ?>
                <? } ?>
            </div>
        </div>


        <div class="flex-box flex-vertical-top box-wide full-width" style="border: 1px solid #efd4d6; align-items: stretch;">
            <div class="three_fourth  no-shrink" style="background: #e0e0e0">
                <div class="box" style="background: #f0f2f4">
                    <div class="flex-box">
                        <div class="isBold" style="font-size: 20px;">
                            <? if (!$object->getField('is_land')) { ?>
                                <?= $object->getField('area_building') ?> <span>м <sup>2</sup></span>
                            <? } else { ?>
                                <?= $object->getField('area_field_full') ?> <span>м <sup>2</sup></span>
                            <? } ?>
                            <? if (1) { ?>
                                (по этажам: <?= numFormat($object->getFloorsAreaSum()) ?> <span>м <sup>2</sup></span> )
                            <? } ?>
                        </div>
                    </div>
                    <div class="box-small-vertical isBold">
                        <?= $object->getField('address') ?>
                    </div>
                    <div>
                        <ul>
                            <? if (arrayIsNotEmpty($object->purposes())) { ?>
                                <? foreach ($object->purposes() as $purpose) { ?>
                                    <?
                                    $purpose = new Post((int)$purpose);
                                    $purpose->getTable('l_purposes');
                                    ?>
                                    <li class="icon-square">
                                        <a href="#" title="<?= $purpose->title() ?>"><?= $purpose->getField('icon') ?></a>
                                    </li>
                                <? } ?>
                            <? } ?>
                        </ul>
                    </div>
                    <?
                    $objMix = new OfferMix(0);
                    $objMix->getRealId($object->postId(), 3);
                    ?>
                    <div class="flex-box box-vertical flex-wrap">
                        <? if ($power = $objMix->getField('power')) { ?>
                            <div class="box-small isBold flex-box flex-center-center" style="width: 170px; border: 2px solid #e0e0e0; background: rgb(245,245,245);">
                                <div>
                                    <span class="box-wide ghost"><i class="fas fa-bolt"></i></span><?= $power ?> кВт
                                </div>
                            </div>
                        <? } ?>
                        <? if ($gas = $objMix->getField('gas')) { ?>
                            <div class="box-small isBold flex-box flex-center-center" style="width: 170px; border: 2px solid #e0e0e0; background: rgb(245,245,245);">
                                <div>
                                    <span class="box-wide ghost"><i class="fas fa-burn"></i></span> Газ в цеху
                                </div>
                            </div>
                        <? } ?>
                        <? if ($objMix->getField('heated')) { ?>
                            <div class="box-small isBold flex-box flex-center-center" style="width: 170px; border: 2px solid #e0e0e0; background: rgb(245,245,245);">
                                <div>
                                    <span class="box-wide ghost"><i class="far fa-temperature-hot"></i></span> Отопление
                                </div>
                            </div>
                        <? } ?>
                        <? if ($sum = $objMix->getField('gate_num')) { ?>
                            <div class="box-small isBold" style="width: 170px; border: 2px solid #e0e0e0; background: rgb(245,245,245);">
                                <div>
                                    <span class="box-wide ghost"><i class="far fa-dungeon"></i></span>
                                    <?= $sum ?>
                                    Ворот
                                </div>
                            </div>
                        <? } ?>
                        <? if (in_array(2, $object->getObjectFloorsArrayValuesUnique('floor_types'))) { ?>
                            <div class="box-small isBold" style="width: 170px; border: 2px solid #e0e0e0; background: rgb(245,245,245);">
                                <div>
                                    <span class="box-wide ghost"><i class="fas fa-arrow-alt-to-bottom"></i></span>
                                    Антипыль
                                </div>
                            </div>
                        <? } ?>
                        <? if ($height_min = $objMix->getField('ceiling_height_min')) { ?>
                            <div class="box-small isBold flex-box flex-center-center" style="width: 170px; border: 2px solid #e0e0e0; background: rgb(245,245,245);">
                                <div>
                                    <span class="box-wide ghost"><i class="fas fa-arrow-to-top"></i></span> <?= valuesCompare($height_min, $objMix->getField('ceiling_height_max')) ?> м.
                                </div>
                            </div>
                        <? } ?>
                        <? if ($temp_min = $objMix->getField('temperature_min')) { ?>
                            <div class="box-small isBold flex-box flex-center-center" style="width: 170px; border: 2px solid #e0e0e0; background: rgb(245,245,245);">
                                <div>
                                    <span class="box-wide ghost"><i class="fas fa-temperature-low"></i></span> <?= valuesCompare($temp_min, $objMix->getField('temperature_max')) ?> град
                                </div>
                            </div>
                        <? } ?>
                        <? if ($cranes_min = min($object->getObjectFloorsArrayValuesEvenMultiple(['cranes_overhead', 'cranes_cathead', 'telphers']))) { ?>
                            <div class="box-small isBold" style="width: 170px; border: 2px solid #e0e0e0; background: rgb(245,245,245);">
                                <div>
                                    <span class="box-wide ghost"><i class="far fa-truck-loading"></i></span>

                                    Краны <?= valuesCompare($cranes_min, max($object->getObjectFloorsArrayValuesEvenMultiple(['cranes_overhead', 'cranes_cathead', 'telphers']))) ?> т.
                                </div>
                            </div>
                        <? } ?>
                    </div>
                    <div>
                        <? if (1) { ?>
                            <div class="flex-box flex-wrap">
                                <? if ($cranes = $object->getCranes()) { ?>
                                    <div class="box-small">
                                        Краны:
                                    </div>
                                    <? foreach ($cranes as $crane) { ?>
                                        <? $crane = new Crane($crane) ?>
                                        <div class="isBold icon-orthogonal modal-call-btn " style="" data-form="" data-id="<?= $crane->postId() ?>" data-table="<?= $crane->setTableId() ?>" data-names='["object_id"]' data-values='[<?= $object->postId() ?>]' data-modal="edit-all" data-modal-size="modal-middle">
                                            <?= ($item = $crane->getCraneType()) ?  $item . ' /' : '' ?>
                                            <?= $crane->getCraneCapacity() ?> тонн /
                                            <?= $crane->getCraneLocation() ?> /
                                            <?= ($item = $crane->getCraneSpan()) ?  'пролёт ' . $item . ' м /' : '' ?>
                                            <?= ($item = $crane->getCraneHookHeight()) ?  'до крюка ' . $item . ' м /' : '' ?>
                                            <?= ($item = $crane->getCraneCondition()) ?  $item . ' /' : '' ?>
                                        </div>
                                    <? } ?>
                                <? } ?>
                                <div class="box-small-wide" title="Добавить крановое устройство">
                                    <div class="icon-orthogonal modal-call-btn" data-form="" data-id="" data-table="<?= (new Crane())->setTableId() ?>" data-names='["object_id"]' data-values='[<?= $object->postId() ?>]' data-modal="edit-all" data-modal-size="modal-middle"> + Добавить кран</div>
                                </div>
                            </div>
                            <div class="flex-box flex-wrap">
                                <? if ($elevators = $object->getElevators()) { ?>
                                    <div class="box-small">
                                        Подъемные устройства:
                                    </div>
                                    <? foreach ($elevators as $elevator) { ?>
                                        <? $elevator = new Elevator($elevator) ?>
                                        <div class="isBold icon-orthogonal modal-call-btn " style="" data-form="" data-id="<?= $elevator->postId() ?>" data-table="<?= $elevator->setTableId() ?>" data-names='["object_id"]' data-values='[<?= $object->postId() ?>]' data-modal="edit-all" data-modal-size="modal-middle">
                                            <?= ($item = $elevator->getElevatorType()) ?  $item . ' /' : '' ?>
                                            <?= $elevator->getElevatorCapacity() ?> тонн /
                                            <?= $elevator->getElevatorLocation() ?> /
                                            <?= ($item = $elevator->getElevatorVolume()) ?  $item . ' п.м. /' : '' ?>
                                            <?= ($item = $elevator->getElevatorCondition()) ?  $item . ' /' : '' ?>
                                        </div>
                                    <? } ?>
                                <? } ?>
                                <div class="box-small-wide" title="Добавить подъемное устройство">
                                    <div class="icon-orthogonal modal-call-btn" data-form="" data-id="" data-table="<?= (new Elevator())->setTableId() ?>" data-names='["object_id"]' data-values='[<?= $object->postId() ?>]' data-modal="edit-all" data-modal-size="modal-middle">+ Добавить подъемник</div>
                                </div>
                            </div>
                        <? } ?>
                    </div>
                </div>

                <div class=" box-wide " style="padding-top: 10px; padding-bottom: 10px;">
                    <? if ($logedUser->isAdmin()) { ?>
                        <div>
                            <div class="flex-box flex-wrap">
                                <? $floors_exist = $object->getJsonField('floors_building'); ?>
                                <? foreach ($floors_exist as $floor) { ?>
                                    <?
                                    $floor_obj = new Post($floor);
                                    $floor_obj->getTable('l_floor_nums');
                                    $floor_item = new Floor();
                                    $floor_item->findFloorByTypeId($object->postId(), $floor_obj->postId());
                                    ?>
                                    <?
                                    if (in_array($floor_obj->postId(), [2, 3, 4, 5])) {
                                        $form = 'mezzanine';
                                    } elseif (in_array($floor_obj->postId(), [16])) {
                                        $form = 'field';
                                    } elseif (in_array($floor_obj->postId(), [1, 11])) {
                                        $form = 'first';
                                    } else {
                                        $form = 'main';
                                    }
                                    ?>
                                    <? if (in_array($floor_obj->getField('title'), $object->getFloorsTitle())) { ?>
                                        <div class=" modal-call-btn icon-orthogonal " style="background: #ffffff;  border: 1px solid green; margin-right: 5px" title="Редактировать этаж" data-form="<?= $form ?>" data-id="<?= $floor_item->postId() ?>" data-table="<?= (new Floor())->setTableId() ?>" data-names='["redirect","object_id","floor_num_id"]' data-values="[1,<?= $object->postId() ?>,<?= $floor ?>]" data-modal="edit-all" data-modal-size="modal-middle">
                                            <?= $floor_obj->getField('title'); ?>
                                        </div>
                                    <? } else { ?>
                                        <div class=" modal-call-btn icon-orthogonal " style="background: #ffffff; color: red;  border: 1px solid green; margin-right: 5px" title="Добавить этаж" data-form="<?= $form ?>" data-id="" data-table="<?= (new Floor())->setTableId() ?>" data-names='["redirect","object_id","floor_num_id","complex_id"]' data-values="[1,<?= $object->postId() ?>,<?= $floor ?>,<?= $object->getField('complex_id') ?>]" data-modal="edit-all" data-modal-size="modal-middle">
                                            <?= $floor_obj->getField('title'); ?>
                                        </div>
                                    <? } ?>
                                <? } ?>
                            </div>
                        </div>
                    <? } ?>
                </div>
            </div>
            <div class="one_fourth no-shrink ">
                <div data-company_id="<?= $object->getField('company_id') ?>" class="company-injector-container card-contacts-area-inner full-height flex-box box text_left flex-box-verical flex-between flex-box-to-left" style="background: #e6eedd;">

                </div>
            </div>
        </div>

        <div class="object-info-sections">

            <div class="tabs-block tabs-active-free">
                <div class="tabs flex-box">
                    <div class="tab box-small obj-part" id="<?= $object->postId() ?>.1">
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
                    <div class="to-end flex-box box-small-wide">
                        <? if ($object->getJsonField('photos_360') != NULL &&  arrayIsNotEmpty($object->getJsonField('photos_360'))) { ?>
                            <div class="icon-round ">
                                <a href="/tour-360/<?= $object->setTableId() ?>/<?= $object->postId() ?>/photos_360" target="_blank"><span title="Панорама"><i class="fas fa-globe"></i></span></a>
                            </div>
                        <? } ?>
                        <div class="icon-round ">
                            <a target="_blank" href="/pdf-test.php?original_id=<?= $object->postId() ?>&type_id=3&member_id=<?= $logedUser->member_id() ?>"><i class="fas fa-file-pdf"></i></a>
                        </div>
                        <? if ($object->getField('cadastral_number')) { ?>
                            <div class="icon-round " title="ссылка на кадастр">
                                <a href="https://pkk5.rosreestr.ru/#x=4034393.888696498&y=6756994.231129&z=20&text=<?= $object->getField('cadastral_number') ?>&type=1&app=search&opened=1" target="_blank">
                                    <i class="fas fa-hand-point-down"></i>
                                </a>
                            </div>
                        <? } ?>
                        <div class="icon-round " title="скачать фото">
                            <a href="https://pennylane.pro/uploads/objects/<?= $object->postId() ?>" target="_blank">
                                <i class="far fa-camera"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="tabs-content tabs-content-overline" style="background: #ffffff">
                    <div class="tab-content obj-part-content">
                        <div class="full-width object-stats-block ">
                            <div class="flex-box flex-vertical-top full-width">
                                <div class="object-about-section object-params-list col-1 one-fourth-flex box-small">
                                    <ul>
                                        <? if (!$object->getField('is_land')) { ?>
                                            <li>
                                                <div>
                                                    Общая площадь
                                                </div>
                                                <div>
                                                    <?= $object->showObjectStat('area_building', '<span class="degree-fix">м<sup>2</sup></span>', '-') ?>
                                                </div>
                                            </li>
                                            <li>
                                                <div>
                                                    S - пола
                                                </div>
                                                <div>
                                                    <?= $object->showObjectStat('area_floor_full', '<span class="degree-fix">м<sup>2</sup></span>', '-') ?>
                                                </div>
                                            </li>
                                            <li>
                                                <div>
                                                    S - мезонина
                                                </div>
                                                <div>
                                                    <?= $object->showObjectStat('area_mezzanine_full', '<span class="degree-fix">м<sup>2</sup></span>', '-') ?>
                                                </div>
                                            </li>
                                    </ul>
                                </div>
                                <div class="object-about-section object-params-list col-1 one-fourth-flex box-small">
                                    <ul>
                                        <li>
                                            <div>
                                                S - офисов
                                            </div>
                                            <div>
                                                <?= $object->showObjectStat('area_office_full', '<span class="degree-fix">м<sup>2</sup></span>', '-') ?>
                                            </div>
                                        </li>
                                        <li>
                                            <div>
                                                S - техническая
                                            </div>
                                            <div>
                                                <?= $object->showObjectStat('area_tech_full', '<span class="degree-fix">м<sup>2</sup></span>', '-') ?>
                                            </div>
                                        </li>

                                        <li>
                                            <div>
                                                Этажность склада
                                            </div>
                                            <div>
                                                <?
                                                $floors_all = $object->getJsonField('floors_building');
                                                $floor_formal = [];
                                                foreach ($floors_all as $floor) {
                                                    if (!in_array($floor, [2, 3, 4, 5, 16])) {
                                                        $floor_formal[] = $floor;
                                                    }
                                                }
                                                ?>
                                                <?= count($floor_formal) ?> <span class="degree-fix"> этаж(а)</span>
                                            </div>
                                        </li>
                                        <li>
                                            <div>
                                                Класс объекта
                                            </div>
                                            <div>
                                                <? if ($object->classType()) { ?>
                                                    <?= $object->classType() ?>
                                                <? } else { ?>
                                                    -
                                                <? } ?>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                                <div class="object-about-section object-params-list col-1 one-fourth-flex box-small">
                                    <ul>
                                        <li>
                                            <div>
                                                Внешняя отделка
                                            </div>
                                            <div>
                                                <? if ($object->facingType()) { ?>
                                                    <?= $object->facingType() ?>
                                                <? } else { ?>
                                                    -
                                                <? } ?>
                                            </div>
                                        </li>
                                        <li>
                                            <div>
                                                Год постройки
                                            </div>
                                            <div>
                                                <?= $object->showObjectStat('year_build', '<span class="degree-fix">год</span>', '-') ?>
                                            </div>
                                        </li>
                                        <li>
                                            <div>
                                                Год последнего ремонта
                                            </div>
                                            <div>
                                                <?= $object->showObjectStat('year_repair', '<span class="degree-fix">год</span>', '-') ?>
                                            </div>
                                        </li>
                                    <? } ?>

                                    </ul>
                                </div>
                                <div class="object-about-section object-params-list col-1 one-fourth-flex box-small">
                                    <ul>
                                        <? if (!$object->getField('is_land')) { ?>
                                            <li>
                                                <div>
                                                    Кадастровый №
                                                </div>
                                                <div>
                                                    <?= $object->getField('cadastral_number') ? $object->getField('cadastral_number') : '-' ?>
                                                </div>
                                            </li>
                                        <? } ?>
                                        <? if (!$object->getField('is_land')) { ?>
                                            <li>
                                                <div>
                                                    Правовой статус строения
                                                </div>
                                                <div>
                                                    <? if ($object->getObjectOwnLawType()) { ?>
                                                        <?= $object->getObjectOwnLawType() ?>
                                                    <? } else { ?>
                                                        -
                                                    <? } ?>
                                                </div>
                                            </li>
                                        <? } ?>
                                        <? if ($object->getField('is_land')) { ?>
                                            <li>
                                                <div>
                                                    Площадь участка
                                                </div>
                                                <div>
                                                    <?= $object->showObjectStat('area_field_full', '<span class="degree-fix">м<sup>2</sup></span>', '-') ?>
                                                </div>
                                            </li>
                                            <li>
                                                <div>
                                                    Габариты участка
                                                </div>
                                                <div>
                                                    <? if ($object->getField('land_length') && $object->getField('land_width')) { ?>
                                                        <?= $object->getField('land_length') ?> x <?= $object->getField('land_width') ?> м
                                                    <? } else { ?>
                                                        -
                                                    <? } ?>
                                                </div>
                                            </li>
                                            <li>
                                                <div>
                                                    Кадастровый № участка
                                                </div>
                                                <div>
                                                    <?= $object->getField('cadastral_number_land') ? $object->getField('cadastral_number_land') : '-' ?>
                                                </div>
                                            </li>
                                            <li>
                                                <div>
                                                    Правовой статус зем. уч.
                                                </div>
                                                <div>
                                                    <? if ($object->getObjectOwnLawTypeLand()) { ?>
                                                        <?= $object->getObjectOwnLawTypeLand() ?>
                                                    <? } else { ?>
                                                        -
                                                    <? } ?>
                                                </div>
                                            </li>
                                            <li>
                                                <div>
                                                    Категория земли
                                                </div>
                                                <div>
                                                    <? if ($object->getObjectCategoryLand()) { ?>
                                                        <?= $object->getObjectCategoryLand() ?>
                                                    <? } else { ?>
                                                        -
                                                    <? } ?>
                                                </div>
                                            </li>
                                            <li>
                                                <div>
                                                    Рельеф участка
                                                </div>
                                                <div>
                                                    <? if ($object->getField('landscape_type')) { ?>
                                                        <? $landscape = new Post($object->getField('landscape_type')) ?>
                                                        <? $landscape->getTable('l_landscape') ?>
                                                        <?= $landscape->title() ?>

                                                    <? } else { ?>
                                                        -
                                                    <? } ?>
                                                </div>
                                            </li>
                                        <? } ?>
                                        <li>
                                            <div>
                                                Ограничения
                                            </div>
                                            <div>
                                                <? if ($object->getField('land_use_restrictions')) { ?>
                                                    есть
                                                <? } else { ?>
                                                    -
                                                <? } ?>
                                            </div>
                                        </li>

                                    </ul>
                                </div>
                            </div>
                            <div class="box-small full-width">
                                <div class="box-small" style="background: #f4f4f4;">
                                    <span class="ghost">В.Р.И. :</span> <?= $object->getField('field_allow_usage') ?>
                                </div>
                            </div>
                        </div>
                        <div class="flex-box flex-center box full-width object-stats-toggle" title="Развернуть основные характеристики">
                            <div class="icon-round">
                                <i class="fas fa-angle-up"></i>
                            </div>
                        </div>
                    </div>

                    <div class="tab-content obj-part-content">
                        <div class="flex-box full-width">
                            <div class="flex-box full-width">
                                <div class="flex-box to-end">
                                    <? if ($logedUser->isAdmin()) { ?>
                                        <div class="box-small">
                                            <div class=" text_left pointer ">
                                                <div class="flex-box">
                                                    <div>
                                                        Создать сделку:
                                                    </div>
                                                    <div>
                                                        <div class=" modal-call-btn underlined href-blue box-small-wide" data-form="<?= $deal_forms_offers_arr[$object->getField('is_land')][0] ?>" data-id="" data-table="<?= (new Offer(0))->setTableId() ?>" data-show-name="company_id" data-modal="edit-all" data-modal-size="modal-middle" data-names='["complex_id","object_id","deal_type"]' data-values='[<?= $complex->postId() ?>,<?= $object->getField('id') ?>,1]'>
                                                            аренда
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <div class=" modal-call-btn underlined href-blue" data-form="<?= $deal_forms_offers_arr[$object->getField('is_land')][1] ?>" data-id="" data-table="<?= (new Offer(0))->setTableId() ?>" data-show-name="company_id" data-modal="edit-all" data-modal-size="modal-middle" data-names='["complex_id","object_id","deal_type"]' data-values='[<?= $complex->postId() ?>,<?= $object->getField('id') ?>,2]'>
                                                            продажа
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <div class=" modal-call-btn underlined href-blue  box-wide" data-form="<?= $deal_forms_offers_arr[$object->getField('is_land')][2] ?>" data-id="" data-table="<?= (new Offer(0))->setTableId() ?>" data-show-name="company_id" data-modal="edit-all" data-modal-size="modal-middle" data-names='["complex_id","object_id","deal_type"]' data-values='[<?= $complex->postId() ?>,<?= $object->getField('id') ?>,3]'>
                                                            ответ хранение
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <div class=" modal-call-btn underlined href-blue" data-form="<?= $deal_forms_offers_arr[$object->getField('is_land')][3] ?>" data-id="" data-table="<?= (new Offer(0))->setTableId() ?>" data-show-name="company_id" data-modal="edit-all" data-modal-size="modal-middle" data-names='["complex_id","object_id","deal_type"]' data-values='[<?= $complex->postId() ?>,<?= $object->getField('id') ?>,4]'>
                                                            субаренда
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <? } ?>
                                </div>
                            </div>
                        </div>
                        <div class="card-body full-width">
                            <div id="offers"></div>
                            <div class="tabs-block ">
                                <? $offers_all = $object->getObjectOffersId(); ?>
                                <? $offers = [] ?>
                                <? foreach ($offers_all as $offer_item) {
                                    $offers[] = (int)$offer_item;
                                } ?>

                                <div class="tabs flex-box" style="max-width: 1600px; overflow-x: auto; ">
                                    <? foreach ($offers as $offer_item) { ?>
                                        <? $offer = new Offer($offer_item) ?>
                                        <? $tabs = json_decode($_GET['offer_id']) ?>
                                        <div row-ids='<?= json_encode($offers) ?>' id="<?= $offer->postId() ?>" class="tab offer-tab <?= (in_array($offer_item, $tabs)) ? 'tab-active' : '' ?> " style="min-width: 250px;">

                                            <div class="offer-header box-small text_left" style="background: #f3f3f3">
                                                <?/*<a href="?offer_id=<?=$offer_item?>#offers">*/ ?>
                                                <div class="flex-box">
                                                    <div>
                                                        <? if ($offer->getField('hide_from_market')) { ?>
                                                            <span title="Скрытая от рынка сделка" class="ghost">
                                                                <i class="fas fa-eye-slash"></i>
                                                            </span>
                                                        <? } ?>
                                                        <? $deal_sign = preg_split('//u', $offer->getOfferDealType(), -1, PREG_SPLIT_NO_EMPTY)[0] ?>
                                                        <?= $offer->getOfferDealType() ?> <?= $object->itemId() ?>-<?= $deal_sign ?>
                                                    </div>
                                                    <? if ($logedUser->isAdmin()) { ?>
                                                        <div class="to-end box-small-wide">
                                                            <div class="icon-round modal-call-btn" data-form="<?= $deal_forms_offers_arr[$object->getField('is_land')][$offer->getField('deal_type') - 1] ?>" data-id="<?= $offer->offerId() ?>" data-table="<?= $offer->setTableId() ?>" data-show-name="company_id" data-modal="edit-all" data-modal-size="modal-middle"><i class="fas fa-pencil-alt"></i></div>
                                                        </div>
                                                    <? } ?>
                                                </div>
                                                <div>
                                                    <? if ($offer->getField('company_id')) { ?>
                                                        <? //$company = new Company($offer->getField('company_id')) 
                                                        ?>
                                                        <? //= $company->title() 
                                                        ?>
                                                    <? } else { ?>
                                                        -
                                                    <? } ?>
                                                </div>
                                                <div>
                                                    <b>
                                                        <? if ($offer->getField('deal_type') == 3) { ?>
                                                            <?= valuesCompare($offer->getOfferBlocksMinValue('pallet_place_min'), $offer->getOfferBlocksRealAreaSum('pallet_place_max')) ?> <span>п.м.</span>
                                                        <? } elseif ($offer->getField('deal_type') == 2) { ?>
                                                            <?= $offer->showOfferCalcStat(valuesCompare(numFormat($offer->getOfferBlocksMinValue('area_min')), numFormat($offer->getOfferBlocksRealAreaSum('area_floor_max') + $offer->getOfferBlocksRealAreaSum('area_mezzanine_max') +  $offer->getOfferBlocksRealAreaSum('area_office_max') +  $offer->getOfferBlocksRealAreaSum('area_tech_max'))),  '<span style="line-height: 20px;">м<sup style="font-size: 15px;">2</sup></span>', '-') ?>
                                                        <? } else { ?>
                                                            <?= $offer->showOfferCalcStat(valuesCompare(numFormat($offer->getOfferBlocksMinValue('area_min')), numFormat($offer->getOfferBlocksRealAreaSum('area_floor_max') + $offer->getOfferBlocksRealAreaSum('area_mezzanine_max'))), '<span style="line-height: 20px;">м<sup style="font-size: 15px;">2</sup></span>', '-') ?>
                                                        <? } ?>

                                                        <? if ($offer->getField('deal_type') == 3) { ?>
                                                            / <?= valuesCompare($offer->getOfferBlocksMinValue('area_min'), $offer->getOfferBlocksRealAreaSum('area_floor_max') + $offer->getOfferBlocksRealAreaSum('area_mezzanine_max')) ?> <span style="line-height: 20px;">м<sup style="font-size: 15px;">2</sup></span>
                                                        <? } ?>
                                                    </b>
                                                </div>
                                                <?/*</a>*/ ?>
                                            </div>
                                        </div>
                                    <? } ?>
                                </div>
                                <div class="tabs-content">
                                    <? foreach ($offers as $offer_item) { ?>
                                        <? $offer = new Offer($offer_item) ?>

                                        <div class="tab-content offer-tab-content <?= (in_array($offer_item, $tabs)) ? 'tab-content-active' : '' ?>">
                                            <div class="offer_container full-width box-wide">


                                                <? //if($logedUser->isAdmin() && ($_COOKIE['member_id'] == 141 || $_COOKIE['member_id'] == 150)){
                                                ?>
                                                <? if (1) { ?>
                                                    <div class="flex-box flex-vertical-top">
                                                        <div class="no-shrink" style="width: 180px;">
                                                            <?
                                                            //куски
                                                            //include_once  $_SERVER['DOCUMENT_ROOT'].'/errors.php';
                                                            //include_once $_SERVER['DOCUMENT_ROOT'].'/errors.php';

                                                            $floors = $object->getFloors();
                                                            $sorted = [];
                                                            $sorted_key = [];
                                                            foreach ($floors as $floor) {
                                                                $floor = new Floor($floor);
                                                                //$floor_obj = new Post($floor->getField('floor_num_id'));
                                                                $floor_obj = new Post((int)$floor->getField('floor_num_id'));
                                                                $floor_obj->getTable('l_floor_nums');
                                                                $sorted[] = $floor_obj->getField('order_row');
                                                                $sorted_key[$floor_obj->getField('order_row')] = $floor->postId();
                                                            }
                                                            rsort($sorted);
                                                            //var_dump($sorted);
                                                            foreach ($sorted as $value) { ?>
                                                                <?
                                                                $floor = new Floor($sorted_key[$value]);
                                                                $floor_obj = new Post((int)$floor->getField('floor_num_id'));
                                                                $floor_obj->getTable('l_floor_nums');
                                                                ?>
                                                                <?
                                                                if (in_array($floor_obj->postId(), [2, 3, 4, 5])) {
                                                                    $form = 'mezzanine';
                                                                } elseif (in_array($floor_obj->postId(), [16])) {
                                                                    $form = 'field';
                                                                } elseif (in_array($floor_obj->postId(), [1, 11])) {
                                                                    $form = 'first';
                                                                } else {
                                                                    $form = 'main';
                                                                }
                                                                ?>
                                                                <div style="padding: 5px 0">
                                                                    <div style="width: 130px; height: 80px;  border: 1px solid blue;  box-sizing: border-box; position: relative;">
                                                                        <div class="box-small" style="background: #544e4a; color: #ffffff; padding: 5px;">
                                                                            <div class="isBold">
                                                                                <?= $floor_obj->title() ?>
                                                                            </div>
                                                                            <? if (in_array($floor_obj->getField('id'), [2, 3, 4, 5])) { ?>
                                                                                <div class="">
                                                                                    <? $floor_area = $floor->getField('area_mezzanine_full') ?>
                                                                                    <?= numFormat($floor_area) ?> м <sup>2</sup>
                                                                                </div>
                                                                            <? } elseif (in_array($floor_obj->getField('id'), [16])) { ?>
                                                                                <div class="">
                                                                                    <? $floor_area = $floor->getField('area_field_full') ?>
                                                                                    <?= numFormat($floor_area) ?> м <sup>2</sup>
                                                                                </div>
                                                                            <? } else { ?>
                                                                                <div class="">
                                                                                    <? $floor_area = $floor->getField('area_floor_full') ?>
                                                                                    <?= numFormat($floor_area) ?> м <sup>2</sup>
                                                                                </div>
                                                                            <? } ?>
                                                                        </div>
                                                                        <div title="создать блок на этаже" style="position: absolute; bottom: 5px; right: 5px;" class="pointer modal-call-btn" data-form="<?= $form ?>" data-id="" data-table="<?= (new Part())->setTableId() ?>" data-names='["floor_id","offer_id","floor","is_land"]' data-values='[<?= $floor->gF('id') ?>,<?= $offer->getField('id') ?>,"<?= $floor_obj->gF('sign') ?>",<?= $object->getField('is_land') ?>]' data-modal="edit-all" data-modal-size="modal-big"><i class="fas fa-plus-circle"></i></div>
                                                                    </div>
                                                                </div>
                                                            <? } ?>
                                                        </div>
                                                        <div class="tab-content accordion" style="overflow-x: auto; max-width: 1550px;">
                                                            <form action="<?= PROJECT_URL ?>/system/controllers/subitems/merge.php" method="get">
                                                                <?
                                                                //куски
                                                                //include_once  $_SERVER['DOCUMENT_ROOT'].'/errors.php';
                                                                //include_once $_SERVER['DOCUMENT_ROOT'].'/errors.php';

                                                                $floors = $object->getFloors();
                                                                $sorted = [];
                                                                $sorted_key = [];
                                                                foreach ($floors as $floor) {
                                                                    $floor = new Floor($floor);
                                                                    //$floor_obj = new Post($floor->getField('floor_num_id'));
                                                                    $floor_obj = new Post((int)$floor->getField('floor_num_id'));
                                                                    $floor_obj->getTable('l_floor_nums');
                                                                    $sorted[] = $floor_obj->getField('order_row');
                                                                    $sorted_key[$floor_obj->getField('order_row')] = $floor->postId();
                                                                }
                                                                rsort($sorted);
                                                                //var_dump($sorted);
                                                                foreach ($sorted as $value) {
                                                                    //echo $value;
                                                                    $floor = new Floor($sorted_key[$value]);
                                                                    $floor_obj = new Post((int)$floor->getField('floor_num_id'));
                                                                    $floor_obj->getTable('l_floor_nums'); ?>
                                                                    <div class="acc-unit " style=" ">
                                                                        <div class="full-width  acc-tab flex-vertical-top " style="box-sizing: border-box; ">
                                                                            <div class="floor-info  flex-box">
                                                                                <div class="isBold box-wide flex-box" style=" min-width: 150px; background: #e25822; color: white; ">
                                                                                    <!--
                                                                                    <div>
                                                                                        <?= $floor_obj->getField('title') ?>
                                                                                    </div>
                                                                                    <div class="to-end flex-box floor-actions">
                                                                                        <?
                                                                                        if (in_array($floor_obj->postId(), [2, 3, 4, 5])) {
                                                                                            $form = 'mezzanine';
                                                                                        } elseif (in_array($floor_obj->postId(), [16])) {
                                                                                            $form = 'field';
                                                                                        } elseif (in_array($floor_obj->postId(), [1])) {
                                                                                            $form = 'first';
                                                                                        } else {
                                                                                            $form = 'main';
                                                                                        }
                                                                                        ?>
                                                                                        --
                                                                                        <div class="pointer box-small-wide modal-call-btn" data-form="" data-id="<?= $floor->postId() ?>" data-table="<?= $floor->setTableId() ?>" data-show-name="company_id" data-modal="edit-all" data-modal-size="modal-middle"><i class="fas fa-pencil-alt"></i></div>
                                                                                        --
                                                                                        <div title="создать блок на этаже" class="pointer modal-call-btn" data-form="<?= $form ?>" data-id=""  data-table="<?= (new Part())->setTableId() ?>" data-names='["floor_id","offer_id","is_land"]' data-values='[<?= $floor->getField('id') ?>,<?= $offer->getField('id') ?>,<?= $object->getField('is_land') ?>]'    data-modal="edit-all" data-modal-size="modal-middle"><i class="fas fa-plus-circle"></i></div>
                                                                                    </div>
                                                                                    -->
                                                                                </div>
                                                                            </div>
                                                                            <div style="padding: 5px 0">

                                                                                <div class="flex-box floor-blocks" style="height: 80px; ">
                                                                                    <?


                                                                                    $floor_id = $floor->postId();
                                                                                    $offer_id = $offer->postId();
                                                                                    //$sql_bl = $pdo->prepare("SELECT * FROM c_industry_blocks WHERE offer_id=$offer_id AND floor_id=$floor_id  ");
                                                                                    $sql_bl = $pdo->prepare("SELECT * FROM c_industry_parts WHERE offer_id=$offer_id AND floor_id=$floor_id AND deleted!=1  ");
                                                                                    $sql_bl->execute();
                                                                                    $floor_blocks = [];
                                                                                    while ($floor_block = $sql_bl->fetch(PDO::FETCH_LAZY)) { ?>
                                                                                        <? $floor_blocks[] = $floor_block->id ?>
                                                                                        <? //$obj_block = new Subitem($floor_block->id)
                                                                                        ?>
                                                                                        <? $obj_block = new Part($floor_block->id) ?>
                                                                                        <? //$block_status = $obj_block->gf('status')
                                                                                        ?>
                                                                                        <div class="box-small no-shrink floor-block" id="subitem-<?= $obj_block->postId() ?>" style="height: 100%; width: 200px;  <? if ($obj_block->isActivePart()) { ?>background: #56a03c; color: #ffffff; border: 1px solid #56a03c;<? } else { ?>  border-left: 10px solid #4c50f5;<? } ?>">
                                                                                            <div class="isBold">
                                                                                                <span>
                                                                                                    <? if (in_array($floor_obj->postId(), [2, 3, 4, 5])) {
                                                                                                        $area_min = $floor_block->area_mezzanine_min;
                                                                                                        $area_max = $floor_block->area_mezzanine_max;
                                                                                                    } elseif (in_array($floor_obj->postId(), [16])) {
                                                                                                        $area_min = $floor_block->area_field_min;
                                                                                                        $area_max = $floor_block->area_field_max;
                                                                                                    } else {
                                                                                                        $area_min = $floor_block->area_floor_min;
                                                                                                        $area_max = $floor_block->area_floor_max;
                                                                                                    } ?>
                                                                                                    <?= valuesCompare(numFormat($area_min), numFormat($area_max)) ?>
                                                                                                    м <sup>2</sup>
                                                                                                </span>
                                                                                            </div>
                                                                                            <? if ($obj_block->isActivePart()) { ?>
                                                                                                <div>
                                                                                                    Актив
                                                                                                </div>
                                                                                            <? } else { ?>
                                                                                                <div class="isBold attention">
                                                                                                    Сдано
                                                                                                </div>
                                                                                            <? } ?>

                                                                                            <div class="flex-box">
                                                                                                <? if (!$obj_block->isActivePart()) { ?>
                                                                                                    <div>
                                                                                                        СНЯЛИ
                                                                                                    </div>
                                                                                                <? } ?>
                                                                                                <div class="to-end flex-box">
                                                                                                    <div>
                                                                                                        <div class="pointer modal-call-btn" data-form="<?= $form ?>" data-id="<?= $floor_block->id ?>" data-table="<?= (new Part())->setTableId() ?>" data-show-name="company_id" data-modal="edit-all" data-modal-size="modal-big"><i class="fas fa-pencil-alt"></i></div>
                                                                                                    </div>
                                                                                                    <? if ($obj_block->isActivePart()) { ?>
                                                                                                        <? //if(1){
                                                                                                        ?>
                                                                                                        <input class="block-check" name="blocks[]" <? if (in_array($obj_block->postId(), $complex->getJsonField('mixer_parts'))) { ?>checked <? } ?> type="checkbox" value="<?= $obj_block->postId() ?>" />
                                                                                                    <? } ?>
                                                                                                </div>
                                                                                            </div>

                                                                                        </div>
                                                                                        <? if (1  == 541) { ?>
                                                                                            <div>
                                                                                                Площадь этажа <?= $floor->getField('area_floor_full') ?>
                                                                                            </div>
                                                                                            <div>
                                                                                                Площадь суммы кусков <?= $floor->getFloorOfferBlocksSumArea($offer_id) ?>
                                                                                            </div>
                                                                                        <? } ?>
                                                                                    <? } ?>


                                                                                    <? $free_space = 0 ?>
                                                                                    <? if (in_array($floor_obj->postId(), [2, 3, 4, 5])) { ?>
                                                                                        <? $free_space = $floor->getFloorOfferFreeSpace('area_mezzanine', $offer_id) ?>
                                                                                    <? } elseif (in_array($floor_obj->postId(), [16])) { ?>
                                                                                        <? $free_space = $floor->getFloorOfferFreeSpace('area_field', $offer_id) ?>
                                                                                    <? } else { ?>
                                                                                        <? $free_space = $floor->getFloorOfferFreeSpace('area_floor', $offer_id) ?>
                                                                                    <? } ?>
                                                                                    <? if ($free_space) { ?>
                                                                                        <div class="box-small floor-block" style="height: 100%; width: 100%;    min-width: 200px; border-left: 10px solid #9f9f9f;">
                                                                                            <div>
                                                                                                <span class="isBold">
                                                                                                    <?= $free_space ?>
                                                                                                    м <sup>2</sup>
                                                                                                </span>
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
                                                                                    <? } ?>
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
                                                                <? } ?>
                                                                <!--<button>Собрать</button>-->
                                                            </form>
                                                        </div>

                                                    </div>
                                                <? } ?>



                                                <div class="flex-box" style="background: #cfe0db;">
                                                    <div class="three_fourth no-shrink">
                                                        <div class="half no-shrink  box">
                                                            <? if ($offer->getField('built_to_suit') == 1) { ?>
                                                                <i class="fal fa-paint-roller"></i>
                                                                <span class="isBold box-small-wide">
                                                                    <? if ($offer->getField('deal_type') == 2) { ?>
                                                                        BTS
                                                                    <? } else { ?>
                                                                        BTR
                                                                    <? } ?>
                                                                </span>
                                                                <? if ($offer->getField('built_to_suit_time')) { ?>
                                                                    / <?= $offer->getField('built_to_suit_time') ?> мес
                                                                <? } ?>
                                                                <? if ($offer->getField('built_to_suit_plan')) { ?>
                                                                    - проект имеется
                                                                <? } ?>
                                                            <? } ?>
                                                        </div>
                                                        <div class="half no-shrink  box">
                                                            <? if ($offer->getField('deal_type') != 2) { ?>
                                                                <div class=" flex-box flex-vertical-bottom">
                                                                    <div>
                                                                        <i class="fas fa-ruble-sign"></i>
                                                                    </div>
                                                                    <?

                                                                    $formats = new Post();
                                                                    $formats->getTable('l_price_formats');
                                                                    $formats_info = $formats->getAllUnits();
                                                                    foreach ($formats_info as $info) {
                                                                        $parts_url = explode('?', $router->getURL());
                                                                        $url_main = $parts_url[0] . '?offer_id=[' . $offer->postId() . ']';
                                                                        if (in_array($offer->getField('deal_type'), json_decode($info['deal_type'])) && array_intersect($object->getJsonField('object_type'), json_decode($info['object_type']))) { ?>
                                                                            <div class="icon-orthogonal-ghost <? if ($_GET['format'] == $info['id']) { ?> isBold   <? } ?>" ">
                                                                                <a class=" link-underline" href="<?= $url_main ?>&format=<?= $info['id'] ?>#offers" style="<? if ($_GET['format'] == $info['id']) { ?> color: black; text-decoration: none;  <? } ?>"><?= $info['title'] ?></a>
                                                                            </div>
                                                                    <? }
                                                                    }
                                                                    ?>
                                                                </div>
                                                            <? } ?>
                                                        </div>
                                                    </div>
                                                    <div class="one_fourth no-shrink  box">
                                                        <? if ($offer->getField('agent_id')) { ?>
                                                            <span class="isBold">
                                                                <i class="fas fa-walking"></i> <?= (new Member($offer->getField('agent_id')))->title(); ?>
                                                            </span>
                                                        <? } ?>
                                                        <? if ($offer->getField('agent_visited') == 1) { ?>
                                                            / личное посещение
                                                        <? } ?>
                                                    </div>
                                                </div>




                                                <div class="offer-summary flex-box  flex-vertical-top full-width  " style="background: #ffffff">
                                                    <div class="three_fourth ">
                                                        <div>
                                                            <? $table = $offer->setTableId() ?>
                                                            <? $id = $offer->postId() ?>
                                                            <? // include($_SERVER['DOCUMENT_ROOT'].'/templates/forms/panel-ad/index.php')
                                                            ?>
                                                        </div>
                                                        <div>
                                                            <div class="flex-box flex-vertical-top">
                                                                <div class="half text_left half  box">
                                                                    <div class="flex-box box">
                                                                        <div>
                                                                            <h1 style="line-height: 35px;">
                                                                                <? if ($offer->getField('deal_type') == 3) { ?>
                                                                                    <?= valuesCompare($offer->getOfferBlocksMinValue('pallet_place_min'), $offer->getOfferBlocksRealAreaSum('pallet_place_max')) ?> <span>п.м.</span> / <?= $offer->showOfferCalcStat(valuesCompare(numFormat($offer->getOfferBlocksMinValue('area_min')), numFormat($offer->getOfferBlocksRealAreaSum('area_floor_max') + $offer->getOfferBlocksRealAreaSum('area_mezzanine_max'))), '<span style="line-height: 20px;">м<sup style="font-size: 15px;">2</sup></span>', '-') ?>
                                                                                <? } elseif ($offer->getField('deal_type') == 2) { ?>
                                                                                    <?= $offer->showOfferCalcStat(valuesCompare(numFormat($offer->getOfferBlocksMinValue('area_min')), numFormat($offer->getOfferBlocksRealAreaSum('area_floor_max') + $offer->getOfferBlocksRealAreaSum('area_mezzanine_max') +  $offer->getOfferBlocksRealAreaSum('area_office_max') +  $offer->getOfferBlocksRealAreaSum('area_tech_max'))),  '<span style="line-height: 20px;">м<sup style="font-size: 15px;">2</sup></span>', '-') ?>
                                                                                <? } else { ?>
                                                                                    <?= $offer->showOfferCalcStat(valuesCompare(numFormat($offer->getOfferBlocksMinValue('area_min')), numFormat($offer->getOfferBlocksRealAreaSum('area_floor_max') + $offer->getOfferBlocksRealAreaSum('area_mezzanine_max') + $offer->getOfferBlocksRealAreaSum('area_office_max')  + $offer->getOfferBlocksRealAreaSum('area_tech_max'))), '<span style="line-height: 20px;">м<sup style="font-size: 15px;">2</sup></span>', '-') ?>
                                                                                <? } ?>
                                                                            </h1>
                                                                        </div>
                                                                    </div>
                                                                    <div class="object-params-list">
                                                                        <ul>
                                                                            <? if (!$object->getField('is_land')) { ?>
                                                                                <?

                                                                                $parts_line = implode(',', $offer->getOfferBlocksValuesUnique('parts'));
                                                                                if (!$parts_line) {
                                                                                    $parts_line = 0;
                                                                                }
                                                                                //$sql = $pdo->prepare("SELECT * FROM c_industry_parts WHERE id IN($parts_line)");
                                                                                $sql = $pdo->prepare("SELECT * FROM c_industry_parts p LEFT JOIN c_industry_floors f ON p.floor_id=f.id LEFT JOIN l_floor_nums n ON f.floor_num_id=n.id WHERE p.id IN($parts_line) ORDER BY n.order_row ");
                                                                                $sql->execute();


                                                                                $parts = [];
                                                                                $floors_unique = [];
                                                                                while ($part = $sql->fetch(PDO::FETCH_LAZY)) {
                                                                                    $floor = $part->floor;
                                                                                    if (isset($floors_unique[$floor])) {
                                                                                        $arr = $floors_unique[$floor];
                                                                                        $arr[] = $part->id;
                                                                                        $floors_unique[$floor] = $arr;
                                                                                    } else {
                                                                                        $arr = [$part->id];
                                                                                        $floors_unique[$floor] = $arr;
                                                                                    }
                                                                                }
                                                                                //var_dump($floors_unique);

                                                                                $array_floor_new  = [];

                                                                                foreach ($floors_unique as $key => $value) {

                                                                                    $test_part = new Part($value[0]);
                                                                                    $floor_name = $test_part->getFloorName();

                                                                                    $areas = [];
                                                                                    foreach ($value as $part_id) {
                                                                                        $part = new Part($part_id);

                                                                                        if (in_array((string)$key, ['1f'])) {
                                                                                            $areas['min'][] = $part->getField('area_field_min');
                                                                                            $areas['max'][] = $part->getField('area_field_max');
                                                                                        } elseif (in_array((string)$key, ['1m', '2m', '3m', '4m'])) {
                                                                                            $areas['min'][] = $part->getField('area_mezzanine_min');
                                                                                            $areas['max'][] = $part->getField('area_mezzanine_max');
                                                                                        } else {
                                                                                            $areas['min'][] = $part->getField('area_floor_min');
                                                                                            $areas['max'][] = $part->getField('area_floor_max');
                                                                                        }
                                                                                    }
                                                                                    $array_floor_new[$floor_name] = $areas;
                                                                                }

                                                                                //var_dump($array_floor_new);


                                                                                ?>
                                                                                <? if ($offer->getField('deal_type')) { ?>
                                                                                    <li class="isBold">
                                                                                        <div>
                                                                                            S - складская
                                                                                        </div>
                                                                                        <div>
                                                                                            <?= $offer->showOfferCalcStat(valuesCompare(numFormat($offer->getOfferBlocksMinValue('area_warehouse_min')), numFormat($offer->getOfferBlocksRealAreaSum('area_floor_max') + $offer->getOfferBlocksRealAreaSum('area_mezzanine_max'))), '<span style="line-height: 20px;">м<sup style="font-size: 15px;">2</sup></span>', '-') ?>
                                                                                        </div>
                                                                                    </li>
                                                                                <? } ?>

                                                                                <? foreach ($array_floor_new as $key => $value) { ?>
                                                                                    <li>
                                                                                        <div>по этажам
                                                                                            S - <?= $key ?>
                                                                                        </div>
                                                                                        <div>
                                                                                            <?= valuesCompare(numFormat(min($value['min'])), numFormat(array_sum($value['max']))) ?> м<sup>2</sup>
                                                                                        </div>
                                                                                    </li>
                                                                                <? } ?>
                                                                                <li>
                                                                                    <div>
                                                                                        S - офисов
                                                                                    </div>
                                                                                    <div>
                                                                                        <?= $offer->showOfferCalcStat(valuesCompare($offer->getOfferBlocksMinValue('area_office_min'), $offer->getOfferBlocksRealAreaSum('area_office_max')), '<span class="ghost">м<sup>2</sup></span>', '-') ?>
                                                                                    </div>
                                                                                </li>
                                                                                <? if ($offer->getOfferBlocksMinValue('area_tech_min')) { ?>
                                                                                    <li>
                                                                                        <div>
                                                                                            S - техническая
                                                                                        </div>
                                                                                        <div>
                                                                                            <?= $offer->showOfferCalcStat(valuesCompare($offer->getOfferBlocksMinValue('area_tech_min'), $offer->getOfferBlocksRealAreaSum('area_tech_max')), '<span class="ghost">м<sup>2</sup></span>', '-') ?>
                                                                                        </div>
                                                                                    </li>
                                                                                <? } ?>
                                                                            <? } else { ?>
                                                                                <li>
                                                                                    <div>
                                                                                        S - участка
                                                                                    </div>
                                                                                    <div>
                                                                                        <?= $offer->showOfferCalcStat(valuesCompare($offer->getOfferBlocksMinValue('area_floor_min'), $offer->getOfferBlocksMaxSumValue('area_floor_max')), '<span class="ghost">м<sup>2</sup></span>', '-') ?>
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
                                                                            <? } ?>
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                                <div class="half text_left half box">
                                                                    <div class="box ">
                                                                        <div>
                                                                            <h1 style="line-height: 35px;">
                                                                                <? if (1) { ?>
                                                                                    <?
                                                                                    $arr_fields_prices_rent = [
                                                                                        'price_floor',
                                                                                        'price_floor_two',
                                                                                        'price_floor_three',
                                                                                        'price_floor_four',
                                                                                        'price_floor_five',
                                                                                        'price_floor_six',
                                                                                        'price_mezzanine',
                                                                                        'price_mezzanine_two',
                                                                                        'price_mezzanine_three',
                                                                                        'price_mezzanine_four',
                                                                                        'price_sub',
                                                                                        'price_sub_two',
                                                                                        'price_sub_three',
                                                                                    ];


                                                                                    ?>
                                                                                    <? $price_format = $_GET['format'] ?>
                                                                                    <? if ($price_format == 1) { ?>
                                                                                        <?
                                                                                        $prices_min = [];
                                                                                        $prices_max = [];

                                                                                        foreach ($arr_fields_prices_rent as $price) {
                                                                                            $prices_min[] = $offer->getOfferBlocksMinValue($price . '_min');
                                                                                            $prices_max[] = $offer->getOfferBlocksMaxValue($price . '_max');
                                                                                        }

                                                                                        $price_min = getArrayMin($prices_min);
                                                                                        $price_max = max($prices_max);
                                                                                        $dim = '<i class="far fa-ruble-sign"></i> за м<sup>2</sup>/год';
                                                                                        ?>
                                                                                    <? } elseif ($price_format == 2) { ?>
                                                                                        <?
                                                                                        $areas_min = [];
                                                                                        if ($area_min = $offer->getOfferBlocksMinValue('price_floor_min')) {
                                                                                            $areas_min[] = $area_min;
                                                                                        }
                                                                                        if ($area_min = $offer->getOfferBlocksMinValue('price_mezzanine_min')) {
                                                                                            $areas_min[] = $area_min;
                                                                                        }

                                                                                        $price_min = min($areas_min) / 12;
                                                                                        $price_max = $offer->getOfferBlocksMaxValue('price_floor_max') / 12;
                                                                                        $dim = '<i class="far fa-ruble-sign"></i> за м<sup>2</sup>/мес';
                                                                                        ?>
                                                                                    <? } elseif ($price_format == 3) { ?>
                                                                                        <?
                                                                                        $prices_min = [];
                                                                                        $prices_max = [];

                                                                                        foreach ($arr_fields_prices_rent as $price) {
                                                                                            $prices_min[] = $offer->getOfferBlocksMinValue($price . '_min');
                                                                                            $prices_max[] = $offer->getOfferBlocksMaxValue($price . '_max');
                                                                                        }

                                                                                        $price_min = getArrayMin($prices_min);
                                                                                        $price_max = max($prices_max);
                                                                                        $dim = '<i class="far fa-ruble-sign"></i> за м<sup>2</sup>/год';
                                                                                        //$price_min = $offer->getOfferBlocksMinValue('price_floor_min')/12*$offer->getOfferSumAreaMin();
                                                                                        //$price_max = $offer->getOfferBlocksMaxValue('price_floor_max')/12*$offer->getOfferSumAreaMax();
                                                                                        //$dim = '<i class="far fa-ruble-sign"></i> в месяц';
                                                                                        ?>
                                                                                    <? } elseif ($price_format == 4) { ?>
                                                                                        <?
                                                                                        $price_min = $offer->getOfferBlocksMinValue('price_sale_min');
                                                                                        $price_max = $offer->getOfferBlocksMaxValue('price_sale_max');
                                                                                        $dim = '<i class="far fa-ruble-sign"></i> за м<sup>2</sup>';
                                                                                        ?>
                                                                                    <? } elseif ($price_format == 5) { ?>
                                                                                        <?
                                                                                        $price_min = $offer->getOfferBlocksMinValue('price_sale_min') * $offer->getOfferSumAreaMin();
                                                                                        $price_max = $offer->getOfferBlocksMinValue('price_sale_max') * $offer->getOfferSumAreaMax();
                                                                                        $dim = '<i class="far fa-ruble-sign"></i> за все';
                                                                                        ?>
                                                                                    <? } elseif ($price_format == 6) { ?>
                                                                                        <?
                                                                                        $price_min = $offer->getOfferBlocksMinValue('price_sale_min') * 100;
                                                                                        $price_max = $offer->getOfferBlocksMaxValue('price_sale_max') * 100;
                                                                                        $dim = '<i class="far fa-ruble-sign"></i> за сотку';
                                                                                        ?>
                                                                                    <? } elseif ($price_format == 7) { ?>
                                                                                        <?
                                                                                        $price_min = $offer->getOfferBlocksMinValue('price_safe_pallet_eu_min');
                                                                                        $price_max = $offer->getOfferBlocksMaxValue('price_safe_pallet_eu_max');
                                                                                        $dim = '<i class="far fa-ruble-sign"></i> ';
                                                                                        ?>
                                                                                    <? } elseif ($price_format == 8) { ?>
                                                                                        <?
                                                                                        $price_min = $offer->getOfferBlocksMinValue('price_safe_volume_min');
                                                                                        $price_max = $offer->getOfferBlocksMaxValue('price_safe_volume_max');
                                                                                        $dim = '<i class="far fa-ruble-sign"></i> за м<sup>3</sup>/сут';
                                                                                        ?>
                                                                                    <? } elseif ($price_format == 9) { ?>
                                                                                        <?
                                                                                        $price_min = $offer->getOfferBlocksMinValue('price_safe_floor_min');
                                                                                        $price_max = $offer->getOfferBlocksMaxValue('price_safe_floor_max');
                                                                                        $dim = '<i class="far fa-ruble-sign"></i> за м<sup>2</sup>/сут';
                                                                                        ?>
                                                                                    <? } else { ?>
                                                                                        <? if ($object->getField('is_land')) { ?>
                                                                                            <?
                                                                                            $price_min = $offer->getOfferBlocksMinValue('price_field_min');
                                                                                            $price_max = $offer->getOfferBlocksMaxValue('price_field_max');
                                                                                            $dim = '<i class="far fa-ruble-sign"></i> за м<sup>2</sup>';
                                                                                            ?>

                                                                                        <? } else { ?>
                                                                                            <? if ($offer->getField('deal_type') == 2) { ?>
                                                                                                <?
                                                                                                //$price_min = $offer->getOfferBlocksMinValue('price_sale_min')*$offer->getOfferSumAreaMin();
                                                                                                //$price_max = $offer->getOfferBlocksMinValue('price_sale_max')*$offer->getOfferSumAreaMax();
                                                                                                $price_min = $offer->getOfferBlocksMinValue('price_sale_min');
                                                                                                $price_max = $offer->getOfferBlocksMaxValue('price_sale_max');
                                                                                                $dim = '<i class="far fa-ruble-sign"></i> за м<sup>2</sup>';
                                                                                                ?>
                                                                                            <? } elseif ($offer->getField('deal_type') == 3) { ?>
                                                                                                <?
                                                                                                $price_min = $offer->getOfferBlocksMinValue('price_safe_pallet_eu_min');
                                                                                                $price_max = $offer->getOfferBlocksMaxValue('price_safe_pallet_eu_max');
                                                                                                $dim = '<i class="far fa-ruble-sign"></i> ';
                                                                                                ?>
                                                                                            <? } else { ?>
                                                                                                <?
                                                                                                $prices_min = [];
                                                                                                $prices_max = [];

                                                                                                foreach ($arr_fields_prices_rent as $price) {
                                                                                                    $prices_min[] = $offer->getOfferBlocksMinValue($price . '_min');
                                                                                                    $prices_max[] = $offer->getOfferBlocksMaxValue($price . '_max');
                                                                                                }

                                                                                                $price_min = getArrayMin($prices_min);
                                                                                                $price_max = max($prices_max);
                                                                                                $dim = '<i class="far fa-ruble-sign"></i> за м<sup>2</sup>/год';
                                                                                                ?>
                                                                                            <? } ?>
                                                                                        <? } ?>
                                                                                    <? } ?>

                                                                                    <?= valuesCompare(numFormat($price_min), numFormat($price_max)) ?>
                                                                                    <?= $dim ?>

                                                                                <? } ?>
                                                                            </h1>
                                                                        </div>
                                                                    </div>

                                                                    <div class="object-params-list">
                                                                        <ul>
                                                                            <? if ($offer->getField('deal_type') == 3) { ?>
                                                                                <?
                                                                                $arr = [
                                                                                    'price_safe_pallet_eu' => 'EU паллет',
                                                                                    'price_safe_pallet_fin' => 'FIN паллет',
                                                                                    'price_safe_pallet_us' => 'US паллет',
                                                                                    'price_safe_floor' => 'Напольное',
                                                                                ];

                                                                                ?>
                                                                                <?
                                                                                $price_min = $offer->getOfferBlocksMinValue('pallet_place_min') * $offer->getOfferBlocksMaxValue('price_safe_pallet_eu_max') * 30 * 12 / ($offer->getOfferBlocksMinValue('area_floor_min'));
                                                                                $price_max = $offer->getOfferBlocksMaxSumValue('pallet_place_max') * $offer->getOfferBlocksMaxValue('price_safe_pallet_eu_max') * 30 * 12 / ($offer->getOfferBlocksMaxSumValue('area_floor_max') + $offer->getOfferBlocksMaxSumValue('area_mezzanine_max'));
                                                                                ?>
                                                                                <? if ($price_min > 1) { ?>
                                                                                    <li>
                                                                                        <div class="isBold">
                                                                                            ~E аренды
                                                                                        </div>
                                                                                        <div class="to-end isBold">

                                                                                            <?= valuesCompare(numFormat($price_min), numFormat($price_max)) ?> <i class="fas fa-ruble-sign ghost"></i>
                                                                                        </div>
                                                                                    </li>
                                                                                <? } ?>
                                                                                <? foreach ($arr as $field => $name) { ?>
                                                                                    <? if ($offer->getOfferBlocksMinValue($field . '_min')) { ?>
                                                                                        <li>
                                                                                            <div><?= $name ?></div>
                                                                                            <div class="to-end"><?= valuesCompare(numFormat($offer->getOfferBlocksMinValue($field . '_min')), numFormat($offer->getOfferBlocksMaxValue($field . '_max'))) ?> <i class="fas fa-ruble-sign ghost"></i></div>
                                                                                        </li>
                                                                                    <? } ?>
                                                                                <? } ?>
                                                                            <? } ?>
                                                                            <li class="isBold">
                                                                                <?
                                                                                $prices = [

                                                                                    '-3' => ['price_sub_three', 'E- -3эт'],
                                                                                    '-2' => ['price_sub_two', 'E- -2эт'],
                                                                                    '-1' => ['price_sub', 'E-подвал -1эт'],
                                                                                    '1f' => ['price_field', 'E-уличного'],
                                                                                    '1' => ['price_floor', 'E-пола 1эт'],
                                                                                    '1m' => ['price_mezzanine', 'E-мезонина 1ур'],
                                                                                    '2m' => ['price_mezzanine_two', 'E-мезонина 2ур'],
                                                                                    '3m' => ['price_mezzanine_three', 'E-мезонина 3ур'],
                                                                                    '4m' => ['price_mezzanine_four', 'E-мезонина 4ур'],
                                                                                    '2' => ['price_floor_two', 'E-пола 2 эт.'],
                                                                                    '3' => ['price_floor_three', 'E-пола 3 эт.'],
                                                                                    '4' => ['price_floor_four', 'E-пола 4 эт.'],
                                                                                    '5' => ['price_floor_five', 'E-пола 5 эт.'],
                                                                                    '6' => ['price_floor_six', 'E-пола 6 эт.'],
                                                                                ];

                                                                                $prices_warehouse_min = [];
                                                                                $prices_warehouse_max = [];

                                                                                foreach ($prices as $key => $value) {
                                                                                    $prices_warehouse_min[] = $offer->getOfferBlocksMinValue($value[0] . '_min');
                                                                                    $prices_warehouse_max[] = $offer->getOfferBlocksMaxValue($value[0] . '_max');
                                                                                }


                                                                                ?>
                                                                                <div>Е - складская</div>
                                                                                <div class="to-end"><?= valuesCompare(min($prices_warehouse_min), max($prices_warehouse_max)) ?> <span class="ghost">руб/м<sup>2</sup>/год</span></div>
                                                                            </li>
                                                                            <? if (!$object->getField('is_land')) { ?>
                                                                                <? if ($offer->getField('deal_type') == 1 || $offer->getField('deal_type') == 4) { ?>
                                                                                    <?
                                                                                    $prices = [

                                                                                        '-3' => ['price_sub_three', 'E- -3эт'],
                                                                                        '-2' => ['price_sub_two', 'E- -2эт'],
                                                                                        '-1' => ['price_sub', 'E-подвал -1эт'],
                                                                                        '1f' => ['price_field', 'E-уличного'],
                                                                                        '1' => ['price_floor', 'E-пола 1эт'],
                                                                                        '1m' => ['price_mezzanine', 'E-мезонина 1ур'],
                                                                                        '2m' => ['price_mezzanine_two', 'E-мезонина 2ур'],
                                                                                        '3m' => ['price_mezzanine_three', 'E-мезонина 3ур'],
                                                                                        '4m' => ['price_mezzanine_four', 'E-мезонина 4ур'],
                                                                                        '2' => ['price_floor_two', 'E-пола 2 эт.'],
                                                                                        '3' => ['price_floor_three', 'E-пола 3 эт.'],
                                                                                        '4' => ['price_floor_four', 'E-пола 4 эт.'],
                                                                                        '5' => ['price_floor_five', 'E-пола 5 эт.'],
                                                                                        '6' => ['price_floor_six', 'E-пола 6 эт.'],
                                                                                    ];

                                                                                    ?>
                                                                                    <? foreach ($prices as $key => $value) { ?>
                                                                                        <? if ($price_min = $offer->getOfferBlocksMinValue($value[0] . '_min')) { ?>
                                                                                            <li>
                                                                                                <div><?= $value[1] ?></div>
                                                                                                <div class="to-end"><?= valuesCompare($price_min, $offer->getOfferBlocksMaxValue($value[0] . '_max')) ?> <span class="ghost">руб/м<sup>2</sup>/год</span></div>
                                                                                            </li>
                                                                                        <? } ?>
                                                                                    <? } ?>
                                                                                <? } ?>
                                                                                <? if ($offer->getField('deal_type') == 2) { ?>
                                                                                    <li>
                                                                                        <div>
                                                                                            Ставка за 1 м. кв.
                                                                                        </div>
                                                                                        <div>
                                                                                            <?= $offer->showOfferCalcStat(valuesCompare($offer->getOfferBlocksMinValue('price_sale_min'), $offer->getOfferBlocksMaxValue('price_sale_max')),  '<i class="fas fa-ruble-sign ghost"></i>', '-') ?>
                                                                                        </div>
                                                                                    </li>
                                                                                <? } ?>
                                                                                <? if ($offer->getField('deal_type') == 1 || $offer->getField('deal_type') == 4) { ?>
                                                                                    <? if ($offer->getOfferBlocksMinValue('price_mezzanine_min')) { ?>
                                                                                        <li>
                                                                                            <div>
                                                                                                Мезонин
                                                                                            </div>
                                                                                            <div>
                                                                                                <?= valuesCompare($offer->getOfferBlocksMinValue('price_mezzanine_min'), $offer->getOfferBlocksMaxValue('price_mezzanine_max')) ?> <span class="ghost"><i class="fas fa-ruble-sign "></i> м<sup>2</sup>/год</span>
                                                                                            </div>
                                                                                        </li>
                                                                                    <? } ?>
                                                                                    <? if ($offer->getOfferBlocksMinValue('price_office_min')) { ?>
                                                                                        <li>
                                                                                            <div>
                                                                                                E-офисов
                                                                                            </div>
                                                                                            <div>
                                                                                                <?= valuesCompare($offer->getOfferBlocksMinValue('price_office_min'), $offer->getOfferBlocksMaxValue('price_office_max')) ?> <span class="ghost"><i class="fas fa-ruble-sign "></i> м<sup>2</sup>/год</span>
                                                                                            </div>
                                                                                        </li>
                                                                                    <? } ?>
                                                                                    <? if ($offer->getOfferBlocksMinValue('price_tech_min')) { ?>
                                                                                        <li>
                                                                                            <div>
                                                                                                E-техническая
                                                                                            </div>
                                                                                            <div>
                                                                                                <?= valuesCompare($offer->getOfferBlocksMinValue('price_tech_min'), $offer->getOfferBlocksMaxValue('price_tech_max')) ?> <span class="ghost"><i class="fas fa-ruble-sign "></i> м<sup>2</sup>/год</span>
                                                                                            </div>
                                                                                        </li>
                                                                                    <? } ?>
                                                                                <? } ?>
                                                                            <? } ?>
                                                                            <li>
                                                                                <div>
                                                                                    &#160;
                                                                                </div>
                                                                                <div>

                                                                                </div>
                                                                            </li>

                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="flex-box box-wide flex-wrap">
                                                                <? if ($object->getField('is_land') != 1) { ?>
                                                                    <? if (arrayIsNotEmpty($offer->getOfferBlocksArrayValuesUnique('floor_types')) && count($offer->getOfferBlocksArrayValuesUnique('floor_types')) > 1) { ?>
                                                                        <div title="Тип пола" class="box-small isBold" style="width: 170px; border: 2px solid #e0e0e0; background: rgb(245,245,245);">
                                                                            <div>
                                                                                <span class="box-wide ghost-double"><i class="fas fa-arrow-alt-to-bottom"></i></span>
                                                                                Разные
                                                                            </div>
                                                                        </div>
                                                                    <? } else { ?>
                                                                        <?
                                                                        $type_id = (int)$offer->getOfferBlocksArrayValuesUnique('floor_types')[0];
                                                                        $table = 'l_floor_types';
                                                                        ?>
                                                                        <div class="box-small isBold" style="width: 170px; border: 2px solid #e0e0e0; background: rgb(245,245,245);">
                                                                            <div>
                                                                                <span class="box-wide ghost-double"><i class="fas fa-arrow-alt-to-bottom"></i></span>
                                                                                <?= getPostTitle($type_id, $table) ?>
                                                                            </div>
                                                                        </div>
                                                                    <? } ?>
                                                                <? } else { ?>
                                                                    <? if (arrayIsNotEmpty($offer->getOfferBlocksArrayValuesUnique('floor_types_land')) && count($offer->getOfferBlocksArrayValuesUnique('floor_types')) > 1) { ?>
                                                                        <div title="Тип пола" class="box-small isBold" style="width: 170px; border: 2px solid #e0e0e0; background: rgb(245,245,245);">
                                                                            <div>
                                                                                <span class="box-wide ghost-double"><i class="fas fa-arrow-alt-to-bottom"></i></span>
                                                                                Разные
                                                                            </div>
                                                                        </div>
                                                                    <? } else { ?>
                                                                        <?
                                                                        $type_id = (int)$offer->getOfferBlocksArrayValuesUnique('floor_types_land')[0];
                                                                        $table = 'l_floor_types_land';
                                                                        ?>
                                                                        <div class="box-small isBold" style="width: 170px; border: 2px solid #e0e0e0; background: rgb(245,245,245);">
                                                                            <div>
                                                                                <span class="box-wide ghost-double"><i class="fas fa-arrow-alt-to-bottom"></i></span>
                                                                                <?= getPostTitle($type_id, $table) ?>
                                                                            </div>
                                                                        </div>
                                                                    <? } ?>
                                                                <? } ?>
                                                                <? if ($offer->getOfferBlocksMinValue('ceiling_height_min')) { ?>
                                                                    <div class="box-small isBold flex-box flex-center-center" style="width: 170px; border: 2px solid #e0e0e0; background: rgb(245,245,245);">
                                                                        <div>
                                                                            <span class="box-wide ghost-double"><i class="fas fa-arrow-to-top"></i></span> <?= valuesCompare($offer->getOfferBlocksMinValue('ceiling_height_min'), $offer->getOfferBlocksMaxValue('ceiling_height_max')) ?> м.
                                                                        </div>
                                                                    </div>
                                                                <? } ?>
                                                                <? if ($power = $object->getField('power')) { ?>
                                                                    <div class="box-small isBold flex-box flex-center-center" style="width: 150px; border: 2px solid #e0e0e0; background: rgb(245,245,245);">
                                                                        <div>
                                                                            <span class="box-wide ghost-double"><i class="fas fa-bolt"></i></span><?= $power ?> кВт
                                                                        </div>
                                                                    </div>
                                                                <? } ?>
                                                                <? if ($offer->getOfferBlocksMinValue('heated') == 1) { ?>
                                                                    <div class="box-small isBold flex-box flex-center-center" style="width: 150px; border: 2px solid #e0e0e0; background: rgb(245,245,245);">
                                                                        <div>
                                                                            <span class="box-wide ghost-double"><i class="fas fa-temperature-hot"></i></span>
                                                                            Отопление
                                                                        </div>
                                                                    </div>
                                                                <? } ?>
                                                                <? if ($temp_min = $offer->getOfferBlocksMinValue('temperature_min')) { ?>
                                                                    <div class="box-small isBold flex-box flex-center-center" style="width: 150px; border: 2px solid #e0e0e0; background: rgb(245,245,245);">
                                                                        <div>
                                                                            <span class="box-wide ghost-double"><i class="fas fa-temperature-low"></i></span> <?= valuesCompare($temp_min, $offer->getOfferBlocksMaxValue('temperature_max')) ?> град.
                                                                        </div>
                                                                    </div>
                                                                <? } ?>
                                                                <? if ($offer->getOfferBlocksMinValue('racks') == 1) { ?>
                                                                    <div class="box-small isBold flex-box flex-center-center" style="width: 150px; border: 2px solid #e0e0e0; background: rgb(245,245,245);">
                                                                        <div>
                                                                            <span class="box-wide ghost-double"><i class="fas fa-inventory"></i></span>
                                                                            Стеллажи
                                                                        </div>
                                                                    </div>
                                                                <? } ?>
                                                                <? if ($offer->getOfferBlocksMinValue('charging_room') == 1) { ?>
                                                                    <div class="box-small isBold flex-box flex-center-center" style="width: 200px; border: 2px solid #e0e0e0; background: rgb(245,245,245);">
                                                                        <div>
                                                                            <span class="box-wide ghost-double"><i class="fas fa-charging-station"></i></span>
                                                                            Зарядная команта
                                                                        </div>
                                                                    </div>
                                                                <? } ?>
                                                                <? if ($offer->getOfferBlocksMinValue('gas') == 1) { ?>
                                                                    <div class="box-small isBold flex-box flex-center-center" style="width: 150px; border: 2px solid #e0e0e0; background: rgb(245,245,245);">
                                                                        <div>
                                                                            <span class="box-wide ghost-double"><i class="fas fa-burn"></i></span>
                                                                            Газ
                                                                        </div>
                                                                    </div>
                                                                <? } ?>
                                                                <? if ($offer->getOfferBlocksMinValue('steam') == 1) { ?>
                                                                    <div class="box-small isBold flex-box flex-center-center" style="width: 150px; border: 2px solid #e0e0e0; background: rgb(245,245,245);">
                                                                        <div>
                                                                            <span class="box-wide ghost-double"><i class="fab fa-steam ghost-double"></i></span>
                                                                            Пар
                                                                        </div>
                                                                    </div>
                                                                <? } ?>
                                                                <? if ($offer->getOfferBlocksMinValue('cross_docking') == 1) { ?>
                                                                    <div class="box-small isBold flex-box flex-center-center" style="width: 150px; border: 2px solid #e0e0e0; background: rgb(245,245,245);">
                                                                        <div>
                                                                            <span class="box-wide ghost-double"><i class="fad fa-dungeon"></i></span>
                                                                            Кросс докинг
                                                                        </div>
                                                                    </div>
                                                                <? } ?>
                                                                <?/*if(in_array(2,$offer->getOfferBlocksValuesUnique('floor_type'))){?>
                                                                        <div class="box-small isBold" style="width: 150px; border: 2px solid #e0e0e0; background: rgb(245,245,245);">
                                                                            <div>
                                                                                <span class="box-wide ghost-double"><i class="fas fa-arrow-alt-to-bottom"></i></span>
                                                                                Антипыль
                                                                            </div>
                                                                        </div>
                                                                    <?}*/ ?>
                                                                <? if ($sum = array_sum($offer->getOfferBlocksArrayValuesEven('gates'))) { ?>
                                                                    <div class="box-small isBold" style="width: 150px; border: 2px solid #e0e0e0; background: rgb(245,245,245);">
                                                                        <div>
                                                                            <span class="box-wide ghost-double"><i class="far fa-dungeon"></i></span>
                                                                            <?= $sum ?>
                                                                            Ворот ---
                                                                        </div>
                                                                    </div>
                                                                <? } ?>
                                                                <? if ($offer->getOfferBlocksMaxValue('cranes_num') > 0) { ?>
                                                                    <div class="box-small isBold" style="width: 230px; border: 2px solid #e0e0e0; background: rgb(245,245,245);">
                                                                        <div>
                                                                            <span class="box-wide ghost-double"><i class="far fa-truck-loading"></i></span>

                                                                            Краны <?= count(getArrReal($offer->getOfferBlocksArrayValuesUnique('cranes'))) ?>шт <?= valuesCompare($offer->getOfferBlocksMinValue('cranes_min'), $offer->getOfferBlocksMaxValue('cranes_max')) ?> т.
                                                                        </div>
                                                                    </div>
                                                                <? } ?>
                                                                <? if ($offer->getOfferBlocksMaxValue('elevators_num') > 0) { ?>
                                                                    <div class="box-small isBold" style="width: 230px; border: 2px solid #e0e0e0; background: rgb(245,245,245);">
                                                                        <div>
                                                                            <span class="box-wide ghost-double "><i class="fas fa-angle-double-up"></i></span>

                                                                            Подъемники <?= count(getArrReal($offer->getOfferBlocksArrayValuesUnique('elevators'))) ?>шт <?= valuesCompare($offer->getOfferBlocksMinValue('elevators_min'), $offer->getOfferBlocksMaxValue('elevators_max')) ?> т.
                                                                        </div>
                                                                    </div>
                                                                <? } ?>

                                                            </div>
                                                            <div class="tabs-block tabs-active-free  full-width">
                                                                <div class="tabs flex-box">
                                                                    <? if ($offer->getField('deal_type') == 3 && !$object->getField('is_land')) { ?>
                                                                        <div class="tab box-small isBold">
                                                                            Цены +
                                                                        </div>
                                                                        <div class="tab box-small">
                                                                            Услуги О/Х
                                                                        </div>
                                                                    <? } ?>
                                                                    <div class="tab box-small">
                                                                        Сводка
                                                                    </div>
                                                                    <div class="tab box-small">
                                                                        По блокам
                                                                    </div>
                                                                    <div class="tab box-small">
                                                                        Клиенты
                                                                    </div>
                                                                    <div class="tab box-small">
                                                                        Задачи
                                                                    </div>
                                                                    <div class="flex-box box to-end ">
                                                                        <div class="ghost box-wide">
                                                                            <?= date('d-m-Y в H:i', $offer->getOfferLastUpdate()) ?>
                                                                        </div>
                                                                        <div class=" flex-box to-end">
                                                                            <? if ($logedUser->isAdmin() && false) { ?>
                                                                                <div class="icon-round ad-panel-call modal-call-btn1" data-id="" data-table="" data-modal="panel-ad" data-modal-size="modal-big"><i class="fas fa-rocket"></i></div>
                                                                                <div class="icon-round modal-call-btn" data-modal="edit-all" data-modal-size="modal-middle" data-id="0" data-table="<?= $offer->setTableId() ?>" data-names='["email_offers"]' data-values='["<?= json_encode([[$offer->offerId(), 2]]) ?>"]'><i class="fas fa-envelope"></i></div>
                                                                            <? } ?>
                                                                            <div class="icon-round " style="position: relative;">
                                                                                <a href="/pdf-test.php?original_id=<?= $offer->postId() ?>&type_id=2&member_id=<?= $logedUser->member_id() ?>" target="_blank"><i class="fas fa-file-pdf"></i></a>
                                                                                <? if (!arrayIsNotEmpty($offer->getOfferBlocksArrayValuesUnique('photo_block'))) { ?>
                                                                                    <div class="overlay-over" title="презентация недоступна так нету фото в блоке" style="background: red; ">

                                                                                    </div>
                                                                                <? } ?>
                                                                            </div>

                                                                            <div class="icon-round icon-star <?= (in_array([$offer->postId(), 2], $favourites)) ? 'icon-star-active' : '' ?>" data-offer-id="[<?= $offer->postId() ?>,2]"><i class="fas fa-star"></i></div>
                                                                            <div class="icon-round"><a class="icon-bell" href=""><i class="fas fa-bell"></i></a></div>
                                                                            <div class="icon-round"><a class="icon-thumbs-down" href=""><i class="fas fa-thumbs-down"></i></a></div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="tabs-content full-width">
                                                                    <? if ($offer->getField('deal_type') == 3 && !$object->getField('is_land')) { ?>
                                                                        <div class="tab-content">
                                                                            <? if ($offer->getField('deal_type') == 3 && !$object->getField('is_land')) { ?>
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
                                                                                    <div style="height: 32px;">

                                                                                    </div>
                                                                                    <div class="tabs-content" style="background: #f4f4f4; border: 1px solid lightblue;">
                                                                                        <div class="tab-content">
                                                                                            <ul class="full-width">
                                                                                                <?
                                                                                                $arr = [
                                                                                                    ['EU  паллет 1.2*0.8*1.75', 'price_safe_pallet_eu', 'Р п.м/сут.'],
                                                                                                    ['FIN паллет 1.2*1*1.75', 'price_safe_pallet_fin', 'Р п.м/сут.'],
                                                                                                    ['US  паллет 1.2*1.2*1.75', 'price_safe_pallet_us', 'Р п.м/сут.'],
                                                                                                    ['Негаб паллет/груз до 2т', 'price_safe_pallet_oversized', 'Р за ед.'],
                                                                                                    ['Ячейки 30x40 ', 'price_safe_cell_small', 'яч./сут.'],
                                                                                                    ['Ячейки 60x40', 'price_safe_cell_middle', 'яч./сут.'],
                                                                                                    ['Ячейки 60x80', 'price_safe_cell_big', 'яч./сут.'],
                                                                                                    ['Напольное', 'price_safe_floor', 'Р за м.кв./сут'],
                                                                                                    ['Объемное', 'price_safe_volume', 'Р за м.куб./сут'],
                                                                                                ]
                                                                                                ?>
                                                                                                <? foreach ($arr as $item) { ?>
                                                                                                    <li>
                                                                                                        <span class="flex-box">
                                                                                                            <div style="width: 200px ;">
                                                                                                                <?= $item[0] ?>
                                                                                                            </div>
                                                                                                            <div style="width: 100px">
                                                                                                                <?= valuesCompare($offer->getOfferBlocksMinValue($item[1] . '_min'), $offer->getOfferBlocksMaxValue($item[1] . '_max')) ?>
                                                                                                            </div>
                                                                                                            <div class="ghost to-end">
                                                                                                                <?= $item[2] ?>
                                                                                                            </div>
                                                                                                        </span>
                                                                                                    </li>
                                                                                                <? } ?>
                                                                                            </ul>
                                                                                        </div>
                                                                                        <div class="tab-content">
                                                                                            <ul class="full-width">
                                                                                                <?
                                                                                                $arr_1 = [
                                                                                                    ['EU  паллет 1.2*0.8*1.75', 'price_safe_pallet_eu_in', 'Р за ед.'],
                                                                                                    ['FIN паллет 1.2*1*1.75', 'price_safe_pallet_fin_in', 'Р за ед.'],
                                                                                                    ['US  паллет 1.2*1.2*1.75', 'price_safe_pallet_us_in', 'Р за ед.'],
                                                                                                    ['Негаб паллет/груз до 2т', 'price_safe_pallet_oversized_in', 'Р за ед.'],
                                                                                                    ['Нагаб паллет/ 2-5т', 'price_safe_pallet_oversized_middle_in', 'Р за ед.'],
                                                                                                    ['Негаб паллет / 5-8т', 'price_safe_pallet_oversized_big_in', 'Р за ед.'],
                                                                                                ];

                                                                                                $arr_2 = [
                                                                                                    ['Короб/ мешок до 10кг ', 'price_safe_pack_small_in', 'Р за ед'],
                                                                                                    ['Короб/мешок до 25кг', 'price_safe_pack_middle_in', 'Р за ед'],
                                                                                                    ['Короб/мешок до 40кг', 'price_safe_pack_big_in', 'Р за ед'],
                                                                                                ];
                                                                                                ?>
                                                                                                <li><u>Механизированная погрузка</u></li>
                                                                                                <? foreach ($arr_1 as $item) { ?>
                                                                                                    <li>
                                                                                                        <span class="flex-box">
                                                                                                            <div style="width: 200px;">
                                                                                                                <?= $item[0] ?>
                                                                                                            </div>
                                                                                                            <div style="width: 100px">
                                                                                                                <?= valuesCompare($offer->getOfferBlocksMinValue($item[1]), $offer->getOfferBlocksMaxValue($item[1])) ?>
                                                                                                            </div>
                                                                                                            <div class="ghost">
                                                                                                                <?= $item[2] ?>
                                                                                                            </div>
                                                                                                        </span>
                                                                                                    </li>
                                                                                                <? } ?>
                                                                                                <li><u>Ручная погрузка</u></li>
                                                                                                <? foreach ($arr_2 as $item) { ?>
                                                                                                    <li>
                                                                                                        <span class="flex-box">
                                                                                                            <div style="width: 200px;">
                                                                                                                <?= $item[0] ?>
                                                                                                            </div>
                                                                                                            <div style="width: 100px">
                                                                                                                <?= valuesCompare($offer->getOfferBlocksMinValue($item[1]), $offer->getOfferBlocksMaxValue($item[1])) ?>
                                                                                                            </div>
                                                                                                            <div class="ghost">
                                                                                                                <?= $item[2] ?>
                                                                                                            </div>
                                                                                                        </span>
                                                                                                    </li>
                                                                                                <? } ?>
                                                                                            </ul>
                                                                                        </div>
                                                                                        <div class="tab-content">
                                                                                            <ul class="full-width">
                                                                                                <?
                                                                                                $arr_1 = [
                                                                                                    ['EU  паллет 1.2*0.8*1.75', 'price_safe_pallet_eu_out', 'Р за ед.'],
                                                                                                    ['FIN паллет 1.2*1*1.75', 'price_safe_pallet_fin_out', 'Р за ед.'],
                                                                                                    ['US  паллет 1.2*1.2*1.75', 'price_safe_pallet_us_out', 'Р за ед.'],
                                                                                                    ['Негаб паллет/груз до 2т', 'price_safe_pallet_oversized_out', 'Р за ед.'],
                                                                                                    ['Нагаб паллет/ 2-5т', 'price_safe_pallet_oversized_middle_out', 'Р за ед.'],
                                                                                                    ['Негаб паллет / 5-8т', 'price_safe_pallet_oversized_big_out', 'Р за ед.'],
                                                                                                ];

                                                                                                $arr_2 = [
                                                                                                    ['Короб/ мешок до 10кг ', 'price_safe_pack_small_out', 'Р за ед'],
                                                                                                    ['Короб/мешок до 25кг', 'price_safe_pack_middle_out', 'Р за ед'],
                                                                                                    ['Короб/мешок до 40кг', 'price_safe_pack_big_out', 'Р за ед'],
                                                                                                ];
                                                                                                ?>
                                                                                                <li><u>Механизированная погрузка</u></li>
                                                                                                <? foreach ($arr_1 as $item) { ?>
                                                                                                    <li>
                                                                                                        <span class="flex-box">
                                                                                                            <div style="width: 200px;">
                                                                                                                <?= $item[0] ?>
                                                                                                            </div>
                                                                                                            <div style="width: 100px">
                                                                                                                <?= valuesCompare($offer->getOfferBlocksMinValue($item[1]), $offer->getOfferBlocksMaxValue($item[1])) ?>
                                                                                                            </div>
                                                                                                            <div class="ghost">
                                                                                                                <?= $item[2] ?>
                                                                                                            </div>
                                                                                                        </span>
                                                                                                    </li>
                                                                                                <? } ?>
                                                                                                <li><u>Ручная погрузка</u></li>
                                                                                                <? foreach ($arr_2 as $item) { ?>
                                                                                                    <li>
                                                                                                        <span class="flex-box">
                                                                                                            <div style="width: 200px;">
                                                                                                                <?= $item[0] ?>
                                                                                                            </div>
                                                                                                            <div style="width: 100px">
                                                                                                                <?= valuesCompare($offer->getOfferBlocksMinValue($item[1]), $offer->getOfferBlocksMaxValue($item[1])) ?>
                                                                                                            </div>
                                                                                                            <div class="ghost">
                                                                                                                <?= $item[2] ?>
                                                                                                            </div>
                                                                                                        </span>
                                                                                                    </li>
                                                                                                <? } ?>
                                                                                                <li>
                                                                                                    <div class="underlined">
                                                                                                        Подбор в заказ
                                                                                                    </div>
                                                                                                </li>
                                                                                                <?
                                                                                                $arr = [
                                                                                                    ['Короб/ мешок до 10кг ', 'price_safe_pack_small_complement', 'Р за ед'],
                                                                                                    ['Короб/мешок до 25кг', 'price_safe_pack_middle_complement', 'Р за ед'],
                                                                                                    ['Короб/мешок до 40кг', 'price_safe_pack_big_complement', 'Р за ед'],
                                                                                                ]
                                                                                                ?>
                                                                                                <? foreach ($arr as $item) { ?>
                                                                                                    <li>
                                                                                                        <span class="flex-box">
                                                                                                            <div style="width: 200px;">
                                                                                                                <?= $item[0] ?>
                                                                                                            </div>
                                                                                                            <div style="width: 100px">
                                                                                                                <?= valuesCompare($offer->getOfferBlocksMinValue($item[1]), $offer->getOfferBlocksMaxValue($item[1])) ?>
                                                                                                            </div>
                                                                                                            <div class="ghost">
                                                                                                                <?= $item[2] ?>
                                                                                                            </div>
                                                                                                        </span>
                                                                                                    </li>
                                                                                                <? } ?>
                                                                                            </ul>
                                                                                        </div>
                                                                                        <div class="tab-content">
                                                                                            <ul class="full-width">
                                                                                                <?
                                                                                                $arr = [
                                                                                                    ['Выборочная инвентаризация', 'price_safe_service_inventory', 'Р за ед.'],
                                                                                                    ['Обмотка стретч пленкой 2-3 слоя', 'price_safe_service_winding', 'Р за ед.'],
                                                                                                    ['Подготовка сопроводительных документов', 'price_safe_service_document', 'Р за ед.'],
                                                                                                    ['Предоставление отчетов', 'price_safe_service_report', 'Р за ед.'],
                                                                                                    ['Предоставление поддонов', 'price_safe_service_pallet', 'Р за ед.'],
                                                                                                    ['Стикеровка', 'price_safe_service_stickers', 'Р за ед.'],
                                                                                                    ['Формирование паллет', 'price_safe_service_packing_pallet', 'Р за ед'],
                                                                                                    ['Формирование коробов', 'price_safe_service_packing_pack', 'Р за ед'],
                                                                                                    ['Утилизация мусора', 'price_safe_service_recycling', 'Р за ед'],
                                                                                                    ['Опломбирование авто', 'price_safe_service_sealing', 'Р за ед'],
                                                                                                ]
                                                                                                ?>
                                                                                                <? foreach ($arr as $item) { ?>
                                                                                                    <li>
                                                                                                        <span class="flex-box">
                                                                                                            <div style="width: 250px;">
                                                                                                                <?= $item[0] ?>
                                                                                                            </div>
                                                                                                            <div style="width: 100px">
                                                                                                                <?= valuesCompare($offer->getOfferBlocksMinValue($item[1]), $offer->getOfferBlocksMaxValue($item[1])) ?>
                                                                                                            </div>
                                                                                                            <div class="ghost">
                                                                                                                <?= $item[2] ?>
                                                                                                            </div>
                                                                                                        </span>
                                                                                                    </li>
                                                                                                <? } ?>
                                                                                            </ul>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            <? } ?>
                                                                        </div>
                                                                        <div class="tab-content">
                                                                            <? if ($offer->getField('deal_type') == 3) { ?>
                                                                                <div class="object-params-list">
                                                                                    <ul class="full-width box-wide">
                                                                                        <?
                                                                                        $all_fields = $offer->getTableColumnsNames();
                                                                                        $services = [];
                                                                                        foreach ($all_fields as $field_item) {
                                                                                            if (stristr($field_item, 'safe_service') !== false && $offer->getField($field_item)) {
                                                                                                $services[] = $field_item;
                                                                                            }
                                                                                        }
                                                                                        //var_dump($services);

                                                                                        ?>
                                                                                        <? foreach ($services as $service) { ?>
                                                                                            <? $service_field = new Field() ?>
                                                                                            <? $service_field->getFieldByName($service) ?>
                                                                                            <li>
                                                                                                <div class="full-width">
                                                                                                    <?= $service_field->description() ?>
                                                                                                </div>
                                                                                            </li>
                                                                                        <? } ?>
                                                                                    </ul>
                                                                                </div>
                                                                            <? } ?>
                                                                        </div>
                                                                    <? } ?>
                                                                    <div class="tab-content">
                                                                        <div class="flex-box flex-vertical-top">
                                                                            <div class="object-params-list">
                                                                                <ul>
                                                                                    <li>
                                                                                        <div class="isBold">
                                                                                            Характеристики
                                                                                        </div>
                                                                                        <div>
                                                                                            &#160;
                                                                                        </div>
                                                                                    </li>
                                                                                    <li>
                                                                                        <div>
                                                                                            Тип пола
                                                                                        </div>
                                                                                        <div>
                                                                                            <? $grids = $offer->getOfferBlocksValuesUnique('floor_types'); ?>
                                                                                            <? if (count($grids)) { ?>
                                                                                                <? foreach ($grids as $grid) {
                                                                                                    $grid = new Post($grid);
                                                                                                    $grid->getTable('l_floor_types');
                                                                                                ?>
                                                                                                    <?= $grid->title() ?> ,
                                                                                                <? } ?>
                                                                                            <? } else { ?>
                                                                                                -
                                                                                            <? } ?>
                                                                                        </div>
                                                                                    </li>
                                                                                    <li>
                                                                                        <div>
                                                                                            Высота, рабочая
                                                                                        </div>
                                                                                        <div>
                                                                                            <?= $offer->showOfferCalcStat(valuesCompare($offer->getOfferBlocksMinValue('ceiling_height_min'), $offer->getOfferBlocksMaxValue('ceiling_height_max')), '<span>м</span>', '-') ?>
                                                                                        </div>
                                                                                    </li>
                                                                                    <li>
                                                                                        <div>
                                                                                            Нагрузка на пол
                                                                                        </div>
                                                                                        <div>
                                                                                            <?= $offer->showOfferCalcStat(valuesCompare($offer->getOfferBlocksMinValue('load_floor_min'), $offer->getOfferBlocksMaxValue('load_floor_max')), '<span>т/м<sup>2</sup></span>', '-') ?>
                                                                                        </div>
                                                                                    </li>
                                                                                    <li>
                                                                                        <div>
                                                                                            Нагрузка на мезонин
                                                                                        </div>
                                                                                        <div>
                                                                                            <?= $offer->showOfferCalcStat(valuesCompare($offer->getOfferBlocksMinValue('load_mezzanine_min'), $offer->getOfferBlocksMaxValue('load_mezzanine_max')), '<span>т/м<sup>2</sup></span>', '-') ?>
                                                                                        </div>
                                                                                    </li>
                                                                                    <li>
                                                                                        <div>
                                                                                            Шаг колонн
                                                                                        </div>
                                                                                        <div>
                                                                                            <? $grids = $offer->getOfferBlocksValuesUnique('column_grids'); ?>
                                                                                            <? if (count($grids)) { ?>
                                                                                                <? foreach ($grids as $grid) {
                                                                                                    $grid = new Post($grid);
                                                                                                    $grid->getTable('l_pillars_grid');
                                                                                                ?>
                                                                                                    <?= $grid->title() ?> ,
                                                                                                <? } ?>
                                                                                            <? } else { ?>
                                                                                                -
                                                                                            <? } ?>
                                                                                        </div>
                                                                                    </li>
                                                                                    <?
                                                                                    $gates = $offer->getOfferBlocksArrayValues('gates');
                                                                                    $gate_types = [];
                                                                                    $amount = count($gates);
                                                                                    for ($i = 0; $i < $amount; $i = $i + 2) {
                                                                                        if ($gate_types[$gates[$i]]) {
                                                                                            $gate_types[$gates[$i]] += $gates[$i + 1];
                                                                                        } else {
                                                                                            $gate_types[$gates[$i]] = $gates[$i + 1];
                                                                                        }
                                                                                    }
                                                                                    ?>
                                                                                    <li>
                                                                                        <div>
                                                                                            Тип/кол-во ворот
                                                                                        </div>
                                                                                        <div>
                                                                                            <? if ($gate_types) { ?>
                                                                                                <? foreach ($gate_types as $key => $value) {
                                                                                                    $gate = new Post($key);
                                                                                                    $gate->getTable('l_gates_types');
                                                                                                ?>
                                                                                                    <div class="flex-box">
                                                                                                        <div><?= $value ?> шт </div>/<div class="box-wide"> <?= $gate->title() ?></div>
                                                                                                    </div>
                                                                                                <? } ?>
                                                                                            <? } else { ?>
                                                                                                -
                                                                                            <? } ?>
                                                                                        </div>
                                                                                    </li>
                                                                                    <li>
                                                                                        <div>
                                                                                            Температурный режим
                                                                                        </div>
                                                                                        <div>
                                                                                            <? if ($temp_min = $offer->getOfferBlocksMinValue('temperature_min')) { ?>
                                                                                                <?= ($temp_min > 0) ? '+' : '' ?>
                                                                                                <?= $temp_min ?>
                                                                                            <? } ?>
                                                                                            <? if ($temp_max = $offer->getOfferBlocksMaxValue('temperature_max')) { ?>
                                                                                                /
                                                                                                <?= ($temp_max > 0) ? '+' : '' ?>
                                                                                                <?= $temp_max ?>
                                                                                            <? } ?>
                                                                                            <? //= valuesCompare($offer->getOfferBlocksMinValue('temperature_min'), $offer->getOfferBlocksMaxValue('temperature_max'))
                                                                                            ?> <span>градусов</span>
                                                                                        </div>
                                                                                    </li>
                                                                                    <li>
                                                                                        <div>
                                                                                            Кол-во палет-мест
                                                                                        </div>
                                                                                        <div>
                                                                                            <?= $offer->showOfferCalcStat(valuesCompare($offer->getOfferBlocksMinValue('pallet_place_min'), $offer->getOfferBlocksMaxSumValue('pallet_place_max')), '<span class="ghost">п.м.</span>', '-') ?>
                                                                                        </div>
                                                                                    </li>

                                                                                    <li>
                                                                                        <div>
                                                                                            &#160;
                                                                                        </div>
                                                                                        <div>
                                                                                            &#160;
                                                                                        </div>
                                                                                    </li>
                                                                                    <li>
                                                                                        <div class="isBold">
                                                                                            Оборудование
                                                                                        </div>
                                                                                        <div>
                                                                                            &#160;
                                                                                        </div>
                                                                                    </li>
                                                                                    <li>
                                                                                        <div>
                                                                                            Стеллажи
                                                                                        </div>
                                                                                        <div>
                                                                                            <? $racks = $offer->getOfferBlocksMaxSumValue('racks') ?>
                                                                                            <?= ($racks) ? 'есть' : '-' ?> <?= ($racks && (($racks / $offer->subItemsCount()) < 1)) ? ', частично' : '' ?>
                                                                                        </div>
                                                                                    </li>
                                                                                    <li>
                                                                                        <div>
                                                                                            Типы стеллажей
                                                                                        </div>
                                                                                        <div>
                                                                                            <? $racks_types = [] ?>
                                                                                            <? foreach ($offer->getOfferBlocksValues('rack_types') as $item) { ?>
                                                                                                <? foreach (json_decode($item) as $type) { ?>
                                                                                                    <? if (!in_array($type, $racks_types)) { ?>
                                                                                                        <? array_push($racks_types, $type) ?>
                                                                                                    <? } ?>
                                                                                                <? } ?>
                                                                                            <? } ?>
                                                                                            <? if ($racks_types) { ?>
                                                                                                <? foreach ($racks_types  as $type) { ?>
                                                                                                    <? $rack = new Post($type) ?>
                                                                                                    <? $rack->getTable('l_racks_types') ?>
                                                                                                    <?= $rack->title() ?>
                                                                                                <? } ?>
                                                                                            <? } else { ?>
                                                                                                -
                                                                                            <? } ?>
                                                                                        </div>
                                                                                    </li>
                                                                                    <li>
                                                                                        <div>
                                                                                            Типы хранения
                                                                                        </div>
                                                                                        <div>
                                                                                            <? $safe_types = [] ?>
                                                                                            <? foreach ($offer->getOfferBlocksValues('safe_type') as $item) { ?>
                                                                                                <? foreach (json_decode($item) as $type) { ?>
                                                                                                    <? if (!in_array($type, $safe_types)) { ?>
                                                                                                        <? array_push($safe_types, $type) ?>
                                                                                                    <? } ?>
                                                                                                <? } ?>
                                                                                            <? } ?>
                                                                                            <? if ($safe_types) { ?>
                                                                                                <? foreach ($safe_types  as $type) { ?>
                                                                                                    <? $safe_type = new Post($type) ?>
                                                                                                    <? $safe_type->getTable('l_safe_types') ?>
                                                                                                    <?= $safe_type->title() ?>
                                                                                                <? } ?>
                                                                                            <? } else { ?>
                                                                                                -
                                                                                            <? } ?>
                                                                                        </div>
                                                                                    </li>
                                                                                    <li>
                                                                                        <div>
                                                                                            Зарядная комната
                                                                                        </div>
                                                                                        <div>
                                                                                            <? $charging_room = $offer->getOfferBlocksMaxSumValue('charging_room') ?>
                                                                                            <?= ($charging_room) ? 'есть' : '-' ?> <?= ($charging_room && (($charging_room / $offer->subItemsActiveCount()) < 1)) ? ', частично' : '' ?>
                                                                                        </div>
                                                                                    </li>
                                                                                    <li>
                                                                                        <div>
                                                                                            Складская техника
                                                                                        </div>
                                                                                        <div>
                                                                                            <? $warehouse_equipment = $offer->getOfferBlocksMaxSumValue('warehouse_equipment') ?>
                                                                                            <?= ($warehouse_equipment) ? 'есть' : '-' ?> <?= ($warehouse_equipment && (($warehouse_equipment / $offer->subItemsActiveCount()) < 1)) ? ', частично' : '' ?>
                                                                                        </div>
                                                                                    </li>
                                                                                    <li>
                                                                                        <div>
                                                                                            Ячейки
                                                                                        </div>
                                                                                        <div>
                                                                                            <? $cells = $offer->getOfferBlocksMaxSumValue('cells') ?>
                                                                                            <?= ($cells) ? 'есть' : '-' ?> <?= ($cells && (($cells / $offer->subItemsActiveCount()) < 1)) ? ', частично' : '' ?>
                                                                                        </div>
                                                                                    </li>
                                                                                    <li>
                                                                                        <div>
                                                                                            &#160;
                                                                                        </div>
                                                                                        <div>
                                                                                            &#160;
                                                                                        </div>
                                                                                    </li>
                                                                                    <li>
                                                                                        <div class="isBold">
                                                                                            Коммуникации
                                                                                        </div>
                                                                                        <div>
                                                                                            &#160;
                                                                                        </div>
                                                                                    </li>
                                                                                    <li>
                                                                                        <div>
                                                                                            Мощность
                                                                                        </div>
                                                                                        <div>
                                                                                            <? if ($power_offer = $object->getField('power')) { ?>
                                                                                                <?= $power_offer ?> кВт
                                                                                            <? } else { ?>
                                                                                                -
                                                                                            <? } ?>
                                                                                        </div>
                                                                                    </li>


                                                                                    <li>
                                                                                        <div>
                                                                                            &#160;
                                                                                        </div>
                                                                                        <div>
                                                                                            &#160;
                                                                                        </div>
                                                                                    </li>
                                                                                    <li>
                                                                                        <div class="isBold">
                                                                                            Системы безопасности
                                                                                        </div>
                                                                                        <div>
                                                                                            &#160;
                                                                                        </div>
                                                                                    </li>
                                                                                    <li>
                                                                                        <div>
                                                                                            Кросс-докинг
                                                                                        </div>
                                                                                        <div>
                                                                                            <? $cross = $offer->getOfferBlocksMaxSumValue('enterance_block') ?>
                                                                                            <?= ($cross) ? 'есть' : '-' ?> <?= ($cross && (($cross / $offer->subItemsActiveCount()) < 1)) ? ', частично' : '' ?>
                                                                                        </div>
                                                                                    </li>
                                                                                    <li>
                                                                                        <div>
                                                                                            &#160;
                                                                                        </div>
                                                                                        <div>
                                                                                            &#160;
                                                                                        </div>
                                                                                    </li>
                                                                                    <li>
                                                                                        <div class="isBold">
                                                                                            Подъемные устройства
                                                                                        </div>
                                                                                        <div>
                                                                                            &#160;
                                                                                        </div>
                                                                                    </li>
                                                                                    <li>
                                                                                        <?
                                                                                        $elevators = $offer->getOfferBlocksValues('elevators');
                                                                                        $elevators_types = [];
                                                                                        $elevators_amount = [];
                                                                                        foreach ($elevators as $elevator) {
                                                                                            $block_elevators = json_decode($elevator);
                                                                                            for ($i = 0; $i < count($block_elevators); $i = $i + 2) {
                                                                                                if (!in_array($block_elevators[$i + 1], $elevators_types) && $block_elevators[$i + 1] != 0) {
                                                                                                    array_push($elevators_types, $block_elevators[$i + 1]);
                                                                                                }
                                                                                                array_push($elevators_amount, $block_elevators[$i]);
                                                                                            }
                                                                                        }
                                                                                        ?>
                                                                                        <div>
                                                                                            Лифты/подъемники
                                                                                        </div>
                                                                                        <div>
                                                                                            <? if (count($elevators)) { ?>
                                                                                                <span class="ghost"><?= array_sum($elevators_amount) ?> шт.,</span> <?= valuesCompare(min($elevators_types), max($elevators_types)) ?> т
                                                                                            <? } else { ?>
                                                                                                -
                                                                                            <? } ?>
                                                                                        </div>
                                                                                    </li>

                                                                                    <li>
                                                                                        <?
                                                                                        $elevators = $offer->getOfferBlocksValues('cranes_cathead');
                                                                                        $elevators_types = [];
                                                                                        $elevators_amount = [];
                                                                                        foreach ($elevators as $elevator) {
                                                                                            $block_elevators = json_decode($elevator);
                                                                                            for ($i = 0; $i < count($block_elevators); $i = $i + 2) {
                                                                                                if (!in_array($block_elevators[$i + 1], $elevators_types) && $block_elevators[$i + 1] != 0) {
                                                                                                    array_push($elevators_types, $block_elevators[$i + 1]);
                                                                                                }
                                                                                                array_push($elevators_amount, $block_elevators[$i]);
                                                                                            }
                                                                                        }
                                                                                        ?>
                                                                                        <div>
                                                                                            Кран-балки
                                                                                        </div>
                                                                                        <div>
                                                                                            <? if (count($elevators)) { ?>
                                                                                                <span class="ghost"><?= array_sum($elevators_amount) ?> шт.,</span> <?= valuesCompare(min($elevators_types), max($elevators_types)) ?> т
                                                                                            <? } else { ?>
                                                                                                -
                                                                                            <? } ?>
                                                                                        </div>
                                                                                    </li>
                                                                                    <li>
                                                                                        <?
                                                                                        $elevators = $offer->getOfferBlocksValues('cranes_overhead');
                                                                                        $elevators_types = [];
                                                                                        $elevators_amount = [];
                                                                                        foreach ($elevators as $elevator) {
                                                                                            $block_elevators = json_decode($elevator);
                                                                                            for ($i = 0; $i < count($block_elevators); $i = $i + 2) {
                                                                                                if (!in_array($block_elevators[$i + 1], $elevators_types) && $block_elevators[$i + 1] != 0) {
                                                                                                    array_push($elevators_types, $block_elevators[$i + 1]);
                                                                                                }
                                                                                                array_push($elevators_amount, $block_elevators[$i]);
                                                                                            }
                                                                                        }
                                                                                        ?>
                                                                                        <div>
                                                                                            Мостовые краны
                                                                                        </div>
                                                                                        <div>
                                                                                            <? if (count($elevators)) { ?>
                                                                                                <span class="ghost"><?= array_sum($elevators_amount) ?> шт.,</span> <?= valuesCompare(min($elevators_types), max($elevators_types)) ?> т
                                                                                            <? } else { ?>
                                                                                                -
                                                                                            <? } ?>
                                                                                        </div>
                                                                                    </li>
                                                                                    <li>
                                                                                        <?
                                                                                        $elevators = $offer->getOfferBlocksValues('telphers');
                                                                                        $elevators_types = [];
                                                                                        $elevators_amount = [];
                                                                                        foreach ($elevators as $elevator) {
                                                                                            $block_elevators = json_decode($elevator);
                                                                                            for ($i = 0; $i < count($block_elevators); $i = $i + 2) {
                                                                                                if (!in_array($block_elevators[$i + 1], $elevators_types) && $block_elevators[$i + 1] != 0) {
                                                                                                    array_push($elevators_types, $block_elevators[$i + 1]);
                                                                                                }
                                                                                                array_push($elevators_amount, $block_elevators[$i]);
                                                                                            }
                                                                                        }
                                                                                        ?>
                                                                                        <div>
                                                                                            Тельферы
                                                                                        </div>
                                                                                        <div>
                                                                                            <? if (count($elevators)) { ?>
                                                                                                <span class="ghost"><?= array_sum($elevators_amount) ?> шт.,</span> <?= valuesCompare(min($elevators_types), max($elevators_types)) ?> т
                                                                                            <? } else { ?>
                                                                                                -
                                                                                            <? } ?>
                                                                                        </div>
                                                                                    </li>
                                                                                    <li>
                                                                                        <div>
                                                                                            Подкрановые пути
                                                                                        </div>
                                                                                        <div>
                                                                                            <? $warehouse_equipment = $offer->getOfferBlocksMaxSumValue('cranes_runways') ?>
                                                                                            <?= ($warehouse_equipment) ? 'есть' : '-' ?> <?= ($warehouse_equipment && (($warehouse_equipment / $offer->subItemsActiveCount()) < 1)) ? ', частично' : '' ?>
                                                                                        </div>
                                                                                    </li>
                                                                                </ul>
                                                                            </div>
                                                                            <div>
                                                                                <div>
                                                                                    <div class="isBold box-wide">
                                                                                        Фото
                                                                                    </div>
                                                                                    <div>
                                                                                        <div class="flex-box flex-wrap">
                                                                                            <? $i = 0 ?>
                                                                                            <? foreach ($offer->getOfferBlocksArrayValuesUnique('photo_block') as $photo) { ?>
                                                                                                <? $photo = array_pop(explode('/', str_replace('//', '/', $photo))) ?>
                                                                                                <div class="box-small">
                                                                                                    <div class="background-fix modal-call-btn" data-modal="photo-slider" data-modal-size="modal-big" data-id="<?= $photo ?>" data-table="" data-names='["post_id","table_id","photo_field","slide_num"]' data-values='[<?= $offer->postId() ?>,<?= $offer->setTableId() ?>,"photo_block",<?= $i + 1 ?>]' style="width: 140px; height: 70px; background: url('<?= PROJECT_URL . '/system/controllers/photos/thumb.php/300/' . $object->postId() . '/' . $photo ?>')">

                                                                                                    </div>
                                                                                                </div>
                                                                                                <? $i++ ?>
                                                                                            <? } ?>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="box-small">
                                                                                    <div class="isBold">
                                                                                        Описание
                                                                                    </div>
                                                                                    <div>
                                                                                        <?= $offer->getField('description') ?? $offer->getField('description_auto') ?>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                    </div>
                                                                    <div class="tab-content">
                                                                        <div class="card-blocks-area text_left  tabs-block " style="max-width: 1600px;">
                                                                            <div class="flex-box flex-vertical-top" style="align-items: stretch;">
                                                                                <div class="card-blocks-base " style=" width: 250px">
                                                                                    <?
                                                                                    $parts_all = $offer->getOfferBlocksArrayValues('parts');
                                                                                    $parts_free = [];

                                                                                    foreach ($parts_all as $part_id) {
                                                                                        $part = new Part($part_id);

                                                                                        if (!$part->hasDeal() && $part->isOnMarket() && $part->getField('deleted') != 1) {
                                                                                            if (!in_array($part_id, $parts_free)) {
                                                                                                $parts_free[] = $part_id;
                                                                                            }
                                                                                        }
                                                                                    }
                                                                                    ?>
                                                                                    <div class="box" style="background: #e1e1e1">
                                                                                        <b>Куски: <?= count($parts_free) ?> части(ей)</b>
                                                                                    </div>
                                                                                    <div style="border: 1px solid #ffffff">
                                                                                        <div class="obj-block-stats" style="border-bottom: 1px solid #cfcfcf;">
                                                                                            <ul>
                                                                                                <li><b>Площади</b></li>
                                                                                                <li>S - пола <span> *</span></li>
                                                                                                <li>S - офиснов</li>
                                                                                                <li>S - техническая</li>
                                                                                                <li>Кол-во палет-мест</li>
                                                                                            </ul>
                                                                                            <ul>
                                                                                                <li><b>Назначения</b></li>
                                                                                                <li>---</li>
                                                                                            </ul>
                                                                                            <ul>
                                                                                                <li><b>Характеристики</b></li>
                                                                                                <li>Высота рабочая<span> *</span></li>
                                                                                                <li class="block-info-floor-types">Тип пола: <span> *</span></li>
                                                                                                <li>Нагрузка на пол:</li>
                                                                                                <li class="block-info-grid-types">Сетка колонн</li>
                                                                                                <li class="block-info-gates">Тип/кол-во ворот<span> *</span></li>
                                                                                                <li>Вход в блок</li>
                                                                                                <li>Темперетурный режим</li>




                                                                                                <li>Габариты участка</li>
                                                                                                <li>Рельеф участка</li>
                                                                                            </ul>
                                                                                            <ul>
                                                                                                <li><b>Оборудование</b></li>
                                                                                                <li>Стеллажи</li>
                                                                                                <li class="block-info-racks">Тип стеллажей</li>
                                                                                                <li class="block-info-safe-types">Тип хранения</li>
                                                                                                <li>Ячейки</li>
                                                                                                <li>Зарядная комната </li>
                                                                                                <li>Складская техника </li>
                                                                                            </ul>
                                                                                            <ul>
                                                                                                <li><b>Коммуникации</b></li>
                                                                                                <li>Доступная мощность</li>
                                                                                                <li>Освещение</li>
                                                                                                <li>Отопление</li>
                                                                                                <li>Вид отопления</li>
                                                                                                <li>Водоснабжение</li>
                                                                                                <li>Канализация</li>
                                                                                                <li>Вентиляция</li>
                                                                                                <li>Климат-контроль</li>
                                                                                                <li>Газа для производства</li>
                                                                                                <li>Пар для производства</li>
                                                                                                <li>Интернет</li>
                                                                                                <li>Телефония</li>
                                                                                            </ul>
                                                                                            <ul>
                                                                                                <li><b>Подъемные устройства</b></li>
                                                                                                <li class="block-info-elevators">Лифты/подъемники</li>
                                                                                                <li class="block-info-cranes_cathead">Кран-балки</li>
                                                                                                <li class="block-info-cranes_overhead">Мостовые краны</li>
                                                                                                <li class="block-info-telphers">Тельферы</li>
                                                                                                <li>Подкрановые пути </li>

                                                                                            </ul>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="" style="width: 100%;  max-width: 900px; overflow-x: scroll; overflow-y: hidden;">
                                                                                    <div class="card-blocks-list flex-box flex-vertical-top">
                                                                                        <?




                                                                                        $parts_line = implode(',', $parts_free);
                                                                                        if (!$parts_line) {
                                                                                            $parts_line = 0;
                                                                                        }
                                                                                        $sql1 = $pdo->prepare("SELECT p.id FROM c_industry_parts p LEFT JOIN c_industry_floors f ON p.floor_id=f.id LEFT JOIN l_floor_nums n ON f.floor_num_id=n.id WHERE p.id IN($parts_line) ORDER BY n.order_row  ");
                                                                                        $sql1->execute();
                                                                                        while ($part_free = $sql1->fetch(PDO::FETCH_LAZY)) { ?>
                                                                                            <? $part = new Part($part_free->id) ?>

                                                                                            <div class="flex-box flex-vertical-top tab stack-block ">
                                                                                                <div id="subitem-" class="object-block " style="width: 200px ;">
                                                                                                    <div class="box " style="background: <?= $part->getFloorColor() ?>; color: #FFFFFF;">
                                                                                                        <?= $part->getFloorName() ?>
                                                                                                    </div>
                                                                                                    <div class="block_stats" style="border: 1px solid #79a768">
                                                                                                        <div class="wer obj-block-stats" style="border-bottom: 1px solid #cfcfcf; position: relative;">
                                                                                                            <ul>
                                                                                                                <li>
                                                                                                                    &#160;
                                                                                                                </li>
                                                                                                                <li>
                                                                                                                    <? if (in_array($part->getFloorNumId(), [16])) {
                                                                                                                        $area_min = $part->getField('area_field_min');
                                                                                                                        $area_max = $part->getField('area_field_max');
                                                                                                                    } elseif (in_array($part->getFloorNumId(), [2, 3, 4, 5])) {
                                                                                                                        $area_min = $part->getField('area_mezzanine_min');
                                                                                                                        $area_max = $part->getField('area_mezzanine_max');
                                                                                                                    } else {
                                                                                                                        $area_min = $part->getField('area_floor_min');
                                                                                                                        $area_max = $part->getField('area_floor_max');
                                                                                                                    } ?>
                                                                                                                    <b>
                                                                                                                        <?= valuesCompare($area_min, $area_max) ?> <span>м<sup>2</sup></span>
                                                                                                                    </b>
                                                                                                                </li>

                                                                                                                <li>
                                                                                                                    <? if ($part->getField('area_office_min')) { ?>
                                                                                                                        <?= valuesCompare($part->getField('area_office_min'), $part->getField('area_office_max')) ?> <span>м<sup>2</sup>
                                                                                                                        <? } else { ?>
                                                                                                                            -
                                                                                                                        <? } ?>
                                                                                                                </li>
                                                                                                                <li>
                                                                                                                    <? if ($part->getField('area_tech_min')) { ?>
                                                                                                                        <?= valuesCompare($part->getField('area_tech_min'), $part->getField('area_tech_max')) ?> <span>м<sup>2</sup>
                                                                                                                        <? } else { ?>
                                                                                                                            -
                                                                                                                        <? } ?>
                                                                                                                </li>
                                                                                                                <li>
                                                                                                                    <? if ($part->getField('pallet_place_min')) { ?>
                                                                                                                        <?= valuesCompare($part->getField('pallet_place_min'), $part->getField('pallet_place_max')) ?> п.м.
                                                                                                                    <? } else { ?>
                                                                                                                        -
                                                                                                                    <? } ?>
                                                                                                                </li>
                                                                                                            </ul>
                                                                                                            <ul>
                                                                                                                <li style="height: 47px;">
                                                                                                                    <div>
                                                                                                                        <? if (arrayIsNotEmpty($part->getJsonField('purposes_block'))) { ?>
                                                                                                                            <? foreach ($part->getJsonField('purposes_block') as $purpose) { ?>
                                                                                                                                <?
                                                                                                                                $purpose = new Post((int)$purpose);
                                                                                                                                $purpose->getTable('l_purposes');
                                                                                                                                ?>
                                                                                                                                <div class="icon-square">
                                                                                                                                    <a href="#" title="<?= $purpose->title() ?>"><?= $purpose->getField('icon') ?></a>
                                                                                                                                </div>
                                                                                                                            <? } ?>
                                                                                                                        <? } ?>
                                                                                                                    </div>
                                                                                                                </li>
                                                                                                            </ul>
                                                                                                            <ul>
                                                                                                                <li>&#160;</li>
                                                                                                                <li>
                                                                                                                    <? if ($part->getField('ceiling_height_min')) { ?>
                                                                                                                        <?= valuesCompare($part->getField('ceiling_height_min'), $part->getField('ceiling_height_max')) ?> м
                                                                                                                    <? } else { ?>
                                                                                                                        -
                                                                                                                    <? } ?>
                                                                                                                </li>
                                                                                                                <li class="block-info-floor-types">
                                                                                                                    <? if ($part->getField('floor_types')) {
                                                                                                                        $floor_type = 'floor_types';
                                                                                                                        $floor_type_table = 'l_floor_types';
                                                                                                                    } elseif ($part->getField('floor_types_land')) {
                                                                                                                        $floor_type = 'floor_types_land';
                                                                                                                        $floor_type_table = 'l_floor_types_land';
                                                                                                                    } else {
                                                                                                                        $floor_type = 0;
                                                                                                                        $floor_type_table = '';
                                                                                                                    } ?>
                                                                                                                    <? if ($floor_type) { ?>
                                                                                                                        <? foreach ($part->getJsonField($floor_type) as $type) { ?>
                                                                                                                            <? $rack = new Post($type) ?>
                                                                                                                            <? $rack->getTable($floor_type_table) ?>
                                                                                                                            <div>
                                                                                                                                <?= $rack->title() ?>
                                                                                                                            </div>
                                                                                                                        <? } ?>
                                                                                                                    <? } else { ?>
                                                                                                                        -
                                                                                                                    <? } ?>
                                                                                                                </li>
                                                                                                                <li>
                                                                                                                    <? if (in_array($part->getFloorNumId(), [2, 3, 4, 5])) {
                                                                                                                        $load = valuesCompare($part->getField('load_mezzanine_min'), $part->getField('load_mezzanine_max'));
                                                                                                                    } else {
                                                                                                                        $load = valuesCompare($part->getField('load_floor_min'), $part->getField('load_floor_max'));
                                                                                                                    } ?>

                                                                                                                    <? if ($load) { ?>
                                                                                                                        <?= $load ?> <span class="degree-fix">т/м<sup>2</sup></span>
                                                                                                                    <? } else { ?>
                                                                                                                        -
                                                                                                                    <? } ?>
                                                                                                                </li>
                                                                                                                <li class="block-info-grid-types">
                                                                                                                    <? if (arrayIsNotEmpty($part->getJsonField('column_grids'))) { ?>
                                                                                                                        <? foreach ($part->getJsonField('column_grids') as $type) { ?>
                                                                                                                            <? $rack = new Post($type) ?>
                                                                                                                            <? $rack->getTable('l_pillars_grid') ?>
                                                                                                                            <div>
                                                                                                                                <?= $rack->title() ?>
                                                                                                                            </div>
                                                                                                                        <? } ?>
                                                                                                                    <? } else { ?>
                                                                                                                        -
                                                                                                                    <? } ?>
                                                                                                                </li>
                                                                                                                <?
                                                                                                                $gates = $part->getJsonField('gates');
                                                                                                                $gate_types = [];
                                                                                                                $amount = count($gates);
                                                                                                                for ($i = 0; $i < $amount; $i = $i + 2) {
                                                                                                                    if ($gate_types[$gates[$i]]) {
                                                                                                                        $gate_types[$gates[$i]] += $gates[$i + 1];
                                                                                                                    } else {
                                                                                                                        $gate_types[$gates[$i]] = $gates[$i + 1];
                                                                                                                    }
                                                                                                                }
                                                                                                                ?>
                                                                                                                <li class="block-info-gates">
                                                                                                                    <? if ($gate_types) { ?>
                                                                                                                        <? foreach ($gate_types as $key => $value) { ?>
                                                                                                                            <?
                                                                                                                            $gate = new Post($key);
                                                                                                                            $gate->getTable('l_gates_types');
                                                                                                                            ?>
                                                                                                                            <div class="flex-box">
                                                                                                                                <div class="ghost"><?= $value ?> шт /</div>
                                                                                                                                <div><?= $gate->title() ?></div>
                                                                                                                            </div>
                                                                                                                        <? } ?>
                                                                                                                    <? } else { ?>
                                                                                                                        -
                                                                                                                    <? } ?>
                                                                                                                </li>
                                                                                                                <li>
                                                                                                                    <? if ($part->getField('enterance_block')) { ?>
                                                                                                                        <?
                                                                                                                        $enterance_block = new Post($part->getField('enterance_block'));
                                                                                                                        $enterance_block->getTable('l_enterances');
                                                                                                                        ?>
                                                                                                                        <?= $enterance_block->title() ?>
                                                                                                                    <? } else { ?>
                                                                                                                        -
                                                                                                                    <? } ?>
                                                                                                                </li>

                                                                                                                <li>
                                                                                                                    <? if ($part->getField('heated') == 1) { ?>
                                                                                                                        тёплый
                                                                                                                    <? } else { ?>
                                                                                                                        -
                                                                                                                    <? } ?>
                                                                                                                    <? if ($temp_min = $part->getField('temperature_min')) { ?>
                                                                                                                        <?= ($temp_min > 0) ? '+' : '' ?>
                                                                                                                        <?= $temp_min ?>
                                                                                                                        &#176;С
                                                                                                                    <? } ?>

                                                                                                                    <? if ($temp_max = $part->getField('temperature_max')) { ?>
                                                                                                                        /
                                                                                                                        <?= ($temp_max > 0) ? '+' : '' ?>
                                                                                                                        <?= $temp_max ?>
                                                                                                                        &#176;С
                                                                                                                    <? } ?>
                                                                                                                </li>
                                                                                                                <li>
                                                                                                                    <? if ($part->getField('land_length') && $part->getField('land_width')) { ?>
                                                                                                                        <?= $part->getField('land_length') ?><i class="fal fa-times"></i><?= $part->getField('land_width') ?> м.
                                                                                                                    <? } else { ?>
                                                                                                                        -
                                                                                                                    <? } ?>
                                                                                                                </li>
                                                                                                                <li>
                                                                                                                    <?= ($part->getField('landscape_type')) ? $part->landscapeType() :  '-' ?>
                                                                                                                </li>
                                                                                                            </ul>
                                                                                                            <ul>
                                                                                                                <li>&#160;</li>
                                                                                                                <li><?= ($part->getField('racks')) ? 'есть' : '-' ?></li>
                                                                                                                <li class="block-info-racks">
                                                                                                                    <? if ($part->getField('rack_types')) { ?>
                                                                                                                        <? foreach ($part->getJsonField('rack_types') as $type) { ?>
                                                                                                                            <? $rack = new Post($type) ?>
                                                                                                                            <? $rack->getTable('l_racks_types') ?>
                                                                                                                            <div>
                                                                                                                                <?= $rack->title() ?>
                                                                                                                            </div>
                                                                                                                        <? } ?>
                                                                                                                    <? } else { ?>
                                                                                                                        -
                                                                                                                    <? } ?>
                                                                                                                </li>
                                                                                                                <li class="block-info-safe-types">
                                                                                                                    <? if ($part->getField('safe_type')) { ?>
                                                                                                                        <? foreach ($part->getJsonField('safe_type') as $type) { ?>
                                                                                                                            <? $safe_type = new Post($type) ?>
                                                                                                                            <? $safe_type->getTable('l_safe_types') ?>
                                                                                                                            <div>
                                                                                                                                <?= $safe_type->title() ?>
                                                                                                                            </div>
                                                                                                                        <? } ?>
                                                                                                                    <? } else { ?>
                                                                                                                        -
                                                                                                                    <? } ?>
                                                                                                                </li>
                                                                                                                <li><?= ($part->getField('cells')) ? 'есть' : '-' ?></li>
                                                                                                                <li><?= ($part->getField('charging_room')) ? 'есть' : '-' ?></li>
                                                                                                                <li><?= ($part->getField('warehouse_equipment')) ? 'есть' : '-' ?></li>
                                                                                                            </ul>
                                                                                                            <ul>
                                                                                                                <li>&#160;</li>
                                                                                                                <li>
                                                                                                                    <? if ($power = $part->getField('power')) { ?>
                                                                                                                        <?= $power ?> кВт
                                                                                                                    <? } else { ?>
                                                                                                                        -
                                                                                                                    <? } ?>
                                                                                                                </li>
                                                                                                                <li><?= ($part->getField('cells1')) ? 'есть' : '-' ?></li>
                                                                                                                <li><?= ($part->getField('cells1')) ? 'есть' : '-' ?></li>
                                                                                                                <li><?= ($part->getField('cells1')) ? 'есть' : '-' ?></li>
                                                                                                                <li><?= ($part->getField('cells1')) ? 'есть' : '-' ?></li>
                                                                                                                <li><?= ($part->getField('cells1')) ? 'есть' : '-' ?></li>
                                                                                                                <li><?= ($part->getField('cells1')) ? 'есть' : '-' ?></li>
                                                                                                                <li><?= ($part->getField('climate_control')) ? 'есть' : '-' ?></li>
                                                                                                                <li><?= ($part->getField('gas')) ? 'есть' : '-' ?></li>
                                                                                                                <li><?= ($part->getField('steam')) ? 'есть' : '-' ?></li>
                                                                                                                <li><?= ($part->getField('internet')) ? 'есть' : '-' ?></li>
                                                                                                                <li><?= ($part->getField('phone_line')) ? 'есть' : '-' ?></li>
                                                                                                            </ul>
                                                                                                            <ul>
                                                                                                                <li>&#160;</li>
                                                                                                                <?
                                                                                                                $cranes = ['elevators', 'cranes_cathead', 'cranes_overhead', 'telphers'];

                                                                                                                foreach ($cranes as $crane) {
                                                                                                                    $items = $part->getJsonField($crane);
                                                                                                                    $types = [];
                                                                                                                    $sorted_arr = [];

                                                                                                                    for ($i = 0; $i < count($items); $i = $i + 2) {
                                                                                                                        if (!in_array($items[$i + 1], $types) && $items[$i + 1] != 0) {
                                                                                                                            array_push($types, $items[$i + 1]);
                                                                                                                        }
                                                                                                                    }

                                                                                                                    //var_dump($types);

                                                                                                                    //подсчитываем колво каждого типа
                                                                                                                    foreach ($types as $elem_unique) {
                                                                                                                        for ($i = 0; $i < count($items); $i = $i + 2) {
                                                                                                                            if ($items[$i + 1] == $elem_unique) {
                                                                                                                                $sorted_arr[$elem_unique] += $items[$i];
                                                                                                                            }
                                                                                                                        }
                                                                                                                    }
                                                                                                                ?>

                                                                                                                    <li class="block-info-<?= $crane ?>">
                                                                                                                        <? if ($sorted_arr) { ?>
                                                                                                                            <? foreach ($sorted_arr as $key => $value) { ?>
                                                                                                                                <div class="flex-box">
                                                                                                                                    <div class="ghost"><?= $value ?> шт /</div>
                                                                                                                                    <div><?= $key ?> т.</div>
                                                                                                                                </div>
                                                                                                                            <? } ?>
                                                                                                                        <? } else { ?>
                                                                                                                            -
                                                                                                                        <? } ?>
                                                                                                                    </li>

                                                                                                                <? } ?>
                                                                                                                <li><?= ($part->getField('cranes_runways')) ? 'есть' : '-' ?></li>
                                                                                                            </ul>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        <? } ?>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="tab-content">
                                                                        <div class="box">
                                                                            <div class="flex-box box-small-vertical isBold">
                                                                                <div style="width: 100px;">
                                                                                    #ID
                                                                                </div>
                                                                                <div style="width: 200px;">
                                                                                    Площадь
                                                                                </div>
                                                                                <div style="width: 200px;">
                                                                                    Локации
                                                                                </div>
                                                                                <div style="width: 200px;">
                                                                                    Компания
                                                                                </div>
                                                                                <div style="width: 200px;">
                                                                                    Консультант
                                                                                </div>
                                                                                <div style="width: 200px;">
                                                                                    Дата поступления запроса
                                                                                </div>
                                                                            </div>
                                                                            <?
                                                                            $offerMix = new OfferMix();
                                                                            $offerMix->getRealId($offer->postId(), 2);
                                                                            ?>

                                                                            <? if ($offerMix->postId()) { ?>

                                                                                <?
                                                                                $requestsSql = $pdo->prepare("SELECT * FROM c_industry_requests 
                                                                                                                                      WHERE deal_type=" . $offerMix->getField('deal_type') . "   
                                                                                                                                      AND  (regions LIKE '%" . $offerMix->getField('region') . "%'  OR regions='[]')
                                                                                                                                      AND  (directions LIKE '%" . $offerMix->getField('direction') . "%' OR directions='[]')
                                                                                                                                      AND  (highways LIKE '%" . $offerMix->getField('highway') . "%'  OR highways='[]'  )
                                                                                                                                      AND  (object_classes LIKE '%" . $offerMix->getField('class') . "%' OR object_classes='[]')
                                                                                                                                      AND area_floor_min>" . $offerMix->getField('area_min') . "   
                                                                                                                                      AND area_floor_max<" . $offerMix->getField('area_max') . "                                                                        
                                                                                                                                      AND ( ceiling_height_min>" . $offerMix->getField('ceiling_height_min') . " OR ceiling_height_min=0 OR ceiling_height_min IS NULL )
                                                                                                                                      AND ( ceiling_height_max<" . $offerMix->getField('ceiling_height_max') . " OR ceiling_height_max=0 OR ceiling_height_max IS NULL ) 
                                                                                                                                      AND (heated=" . $offerMix->getField('heated') . " OR heated IS NULL)     
                                                                                                                                      AND  deleted!=1 ORDER BY publ_time DESC LIMIT 20 ");
                                                                                $requestsSql->execute();
                                                                                while ($request = $requestsSql->fetch(PDO::FETCH_LAZY)) { ?>
                                                                                    <div class="flex-box box-small-vertical">
                                                                                        <div style="width: 100px;">
                                                                                            #<?= $request->id ?>
                                                                                        </div>
                                                                                        <div class="isBold" style="width: 200px;">
                                                                                            <?= valuesCompare($request->area_floor_min, $request->area_floor_max) ?>
                                                                                        </div>
                                                                                        <div style="width: 200px;">
                                                                                            <?
                                                                                            foreach (json_decode($request->regions) as $regionsId) {
                                                                                                echo getPostTitle($regionsId, 'l_regions') . ', ';
                                                                                            }
                                                                                            ?>
                                                                                        </div>
                                                                                        <div style="width: 200px; " class="isBold underlined">
                                                                                            <? $comp = new Company($request->company_id) ?>
                                                                                            <a href="/company/<?= $comp->postId() ?>/" target="_blank">
                                                                                                <?= $comp->title() ?>
                                                                                            </a>
                                                                                        </div>
                                                                                        <div style="width: 200px;">
                                                                                            <?= (new Member($request->agent_id))->getField('title') ?>
                                                                                        </div>
                                                                                        <div style="width: 200px;">
                                                                                            <?= date('d-m-Y', $request->publ_time) ?>
                                                                                        </div>
                                                                                    </div>
                                                                                <? } ?>
                                                                            <? } ?>
                                                                        </div>
                                                                    </div>
                                                                    <div class="tab-content">
                                                                        <div class="box">
                                                                            Loadinnn.....
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <? //if($_COOKIE['member_id'] == 141 || $_COOKIE['member_id'] == 150){
                                                        ?>
                                                        <? if (1) { ?>
                                                            <!--работа-->
                                                            <div class="offers-complected box">
                                                                <? $blocks = $offer->subItemsIdFloors() ?>
                                                                <? $blocks_old = $offer->subItemsIdFloorsOld() ?>
                                                                <div class="flex-box flex-center box">
                                                                    <div class="underlined">
                                                                        Торговых предложений:
                                                                    </div>
                                                                </div>
                                                                <div class="tabs-block full-width">
                                                                    <div class="tabs flex-box">
                                                                        <div class="tab tab-active box">
                                                                            Активные ( <?= count($blocks) ?> шт. )
                                                                        </div>
                                                                        <div class="tab box">
                                                                            Архив ( <?= count($blocks_old) ?> шт. )
                                                                        </div>
                                                                    </div>
                                                                    <div class="tabs-content full-width">
                                                                        <div class="tab-content tab-content-active full-width">
                                                                            <? foreach ($blocks as $obj_block) { ?>
                                                                                <? $obj_block = new Subitem($obj_block) ?>

                                                                                <div>
                                                                                    <? $table = $obj_block->setTableId() ?>
                                                                                    <? $id = $obj_block->postId() ?>
                                                                                    <? if ($_COOKIE['member_id'] = 141  || $_COOKIE['member_id'] == 150) { ?>
                                                                                        <? include($_SERVER['DOCUMENT_ROOT'] . '/templates/forms/panel-ad/index.php') ?>
                                                                                    <? } ?>
                                                                                </div>
                                                                                <div class="box full-width <? if ($obj_block->gf('status') != 1 || $obj_block->getField('deal_id') != 0 /*$obj_block->hasDeal()*/) { ?>ghost<? } ?>" style="background: rgb(245,245,245); margin-bottom: 20px; position: relative;">
                                                                                    <div style="position: absolute; top: 5px; right: 10px;">
                                                                                        <div class="flex-box">
                                                                                            <div class="box-wide isBold">
                                                                                                ID <?= $obj_block->getVisualId() ?>,
                                                                                            </div>
                                                                                            <div class="ghost" title="последнее обновление">
                                                                                                <i class="fas fa-undo-alt"></i> <?= date('d-m-Y в H:i', $obj_block->getField('last_update')) ?>
                                                                                            </div>

                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="ghost" title="создано" style="position: absolute; bottom: 5px; right: 5px;">
                                                                                        Создано <?= date('d-m-Y в H:i', $obj_block->getField('publ_time')) ?>
                                                                                    </div>
                                                                                    <div class="flex-box">
                                                                                        <div class="three_fourth flex-box" style="align-items: stretch;">
                                                                                            <div class="half box" style="border: 1px solid #76a665">
                                                                                                <div>
                                                                                                    <div>
                                                                                                        <? if ($obj_block->dealType() == 2) { ?>
                                                                                                            S-предложения
                                                                                                        <? } elseif ($obj_block->dealType() == 3) { ?>
                                                                                                            N - паллет мест
                                                                                                        <? } else { ?>
                                                                                                            S-предложения
                                                                                                        <? } ?>
                                                                                                    </div>
                                                                                                    <div class="isBold" style="font-size: 20px;">
                                                                                                        <? if ($obj_block->dealType() == 2) { ?>
                                                                                                            <?= valuesCompare($obj_block->getField('area_min'), $obj_block->getField('area_max')) ?>
                                                                                                            <span>м<sup>2</sup></span>
                                                                                                        <? } elseif ($obj_block->dealType() == 3) { ?>
                                                                                                            <?= valuesCompare($obj_block->getField('pallet_place_min'), $obj_block->getField('pallet_place_max')) ?>
                                                                                                            <span>п.м.</span>
                                                                                                        <? } else { ?>
                                                                                                            <?= valuesCompare($obj_block->getField('area_min'), $obj_block->getField('area_max')) ?>
                                                                                                            <span>м<sup>2</sup></span>
                                                                                                        <? } ?>
                                                                                                        <? if ($obj_block->dealType() == 3) { ?>
                                                                                                            / <?= valuesCompare($obj_block->getField('area_min'), $obj_block->getField('area_max')) ?>
                                                                                                            <span>м<sup>2</sup></span>
                                                                                                        <? } ?>
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="box-vertical">
                                                                                                    <?





                                                                                                    $parts_line = implode(',', $obj_block->getJsonField('parts'));
                                                                                                    //$sql = $pdo->prepare("SELECT * FROM c_industry_parts WHERE id IN($parts_line)");
                                                                                                    if (!$parts_line) {
                                                                                                        $parts_line = 0;
                                                                                                    }
                                                                                                    $sql = $pdo->prepare("SELECT * FROM c_industry_parts p LEFT JOIN c_industry_floors f ON p.floor_id=f.id LEFT JOIN l_floor_nums n ON f.floor_num_id=n.id WHERE p.id IN($parts_line) ORDER BY n.order_row ");
                                                                                                    $sql->execute();


                                                                                                    $parts = [];
                                                                                                    $floors_unique = [];
                                                                                                    while ($part = $sql->fetch(PDO::FETCH_LAZY)) {
                                                                                                        $floor = $part->floor;
                                                                                                        if (isset($floors_unique[$floor])) {
                                                                                                            $arr = $floors_unique[$floor];
                                                                                                            $arr[] = $part->id;
                                                                                                            $floors_unique[$floor] = $arr;
                                                                                                        } else {
                                                                                                            $arr = [$part->id];
                                                                                                            $floors_unique[$floor] = $arr;
                                                                                                        }
                                                                                                    }
                                                                                                    //var_dump($floors_unique);

                                                                                                    $array_floor_new  = [];

                                                                                                    foreach ($floors_unique as $key => $value) {

                                                                                                        $test_part = new Part($value[0]);
                                                                                                        $floor_name = $test_part->getFloorName();

                                                                                                        $areas = [];
                                                                                                        foreach ($value as $part_id) {
                                                                                                            $part = new Part($part_id);

                                                                                                            if (in_array((string)$key, ['1f'])) {
                                                                                                                $areas['min'][] = $part->getField('area_field_min');
                                                                                                                $areas['max'][] = $part->getField('area_field_max');
                                                                                                            } elseif (in_array((string)$key, ['1m', '2m', '3m', '4m'])) {
                                                                                                                $areas['min'][] = $part->getField('area_mezzanine_min');
                                                                                                                $areas['max'][] = $part->getField('area_mezzanine_max');
                                                                                                            } else {
                                                                                                                $areas['min'][] = $part->getField('area_floor_min');
                                                                                                                $areas['max'][] = $part->getField('area_floor_max');
                                                                                                            }

                                                                                                            $min = min($areas['min']);
                                                                                                            $max = array_sum($areas['max']);

                                                                                                            $areas['min'] = [];
                                                                                                            $areas['max'] = [];

                                                                                                            $areas['min'][] =  $min;
                                                                                                            $areas['max'][] = $max;
                                                                                                        }
                                                                                                        $array_floor_new[$floor_name] = $areas;
                                                                                                    }

                                                                                                    if (1 == 2) {
                                                                                                        echo '<pre>';
                                                                                                        print_r($array_floor_new);
                                                                                                        echo '</pre>';
                                                                                                        echo 1111111;
                                                                                                    }

                                                                                                    //var_dump($array_floor_new);


                                                                                                    ?>
                                                                                                    <? if (!$obj_block->isLand()) { ?>
                                                                                                        <div class="flex-box isBold">
                                                                                                            <div>S-складская</div>
                                                                                                            <div class="to-end"><?= (valuesCompare($obj_block->getField('area_warehouse_min') ?  $obj_block->getField('area_warehouse_min') : $obj_block->getField('area_min'),  $obj_block->getField('area_warehouse_max') ?   $obj_block->getField('area_warehouse_max')  :  $obj_block->getField('area_max'))) ?> м<sup>2</sup></div>
                                                                                                        </div>
                                                                                                        <? foreach ($array_floor_new as $key => $value) { ?>
                                                                                                            <div class="flex-box">
                                                                                                                <div>S-<?= $key ?></div>
                                                                                                                <div class="to-end"><?= valuesCompare(numFormat(min($value['min'])), numFormat(array_sum($value['max']))) ?> м<sup>2</sup></div>
                                                                                                            </div>
                                                                                                        <? } ?>
                                                                                                    <? } ?>
                                                                                                    <? if ($obj_block->getField('area_office_min') || $obj_block->getField('area_office_max')) { ?>
                                                                                                        <div class="flex-box">
                                                                                                            <div>S-офисов</div>
                                                                                                            <div class="to-end">
                                                                                                                <?= valuesCompare($obj_block->getField('area_office_min'), $obj_block->getField('area_office_max')) ?> м<sup>2</sup>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    <? } ?>
                                                                                                    <? if ($obj_block->getField('area_tech_min') || $obj_block->getField('area_tech_max')) { ?>
                                                                                                        <div class="flex-box">
                                                                                                            <div>S-техническая</div>
                                                                                                            <div class="to-end">
                                                                                                                <?= valuesCompare($obj_block->getField('area_tech_min'), $obj_block->getField('area_tech_max')) ?> м<sup>2</sup>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    <? } ?>

                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="half box" style="border: 1px solid #76a665">
                                                                                                <div>
                                                                                                    <div>
                                                                                                        <? if ($obj_block->dealType() == 2) { ?>
                                                                                                            E - предложения
                                                                                                        <? } elseif ($obj_block->dealType() == 3) { ?>
                                                                                                            E - паллет мест
                                                                                                        <? } else { ?>
                                                                                                            E-предложения
                                                                                                        <? } ?>
                                                                                                    </div>
                                                                                                    <div class="isBold" style="font-size: 20px;">
                                                                                                        <? if ($obj_block->dealType() == 2) { ?>
                                                                                                            <?

                                                                                                            /* если все ок и к этому давно не возвращался - удалить нахуй
                                                                                                        $area_sum = 0;
                                                                                                        $area_pars = [
                                                                                                                'area_floor',
                                                                                                                'area_mezzanine',
                                                                                                                'area_office',
                                                                                                                'area_tech',
                                                                                                        ];
                                                                                                        foreach ($area_pars as $area){
                                                                                                            $area_sum += $obj_block->getField($area.'_max');
                                                                                                        }
                                                                                                        $area_min = $area_sum;
                                                                                                        foreach ($area_pars as $area){
                                                                                                            if($obj_block->getField($area.'_min') < $area_min ){
                                                                                                                $area_min = $obj_block->getField($area.'_min');
                                                                                                            }
                                                                                                        }
                                                                                                        */

                                                                                                            $area_min = $obj_block->getField('area_min');
                                                                                                            $area_max = $obj_block->getField('area_max');


                                                                                                            $price_min = numFormat(($obj_block->getField('price_sale_min') ? $obj_block->getField('price_sale_min')  : $obj_block->getField('price_field_min')) * $area_min);
                                                                                                            $price_max = numFormat(($obj_block->getField('price_sale_max') ?  $obj_block->getField('price_sale_max') :  $obj_block->getField('price_field_max')) * $area_max);

                                                                                                            if (in_array($price_min, [0, 999999999]) || in_array($price_max, [999999999])) {
                                                                                                                $price_max = '<b class="attention">??????</b>';
                                                                                                                $price_min = $price_max;
                                                                                                            }
                                                                                                            ?>

                                                                                                            <?= valuesCompare($price_min, $price_max) ?> <i class="fal fa-ruble-sign"></i>
                                                                                                        <? } elseif ($obj_block->dealType() == 3) { ?>
                                                                                                            <?
                                                                                                            $price_min = $obj_block->getField('price_safe_pallet_eu_min');
                                                                                                            $price_max = $obj_block->getField('price_safe_pallet_eu_max');



                                                                                                            if (in_array($price_min, [0, 999999999])   || $price_max == 999999999) {
                                                                                                                $price_max = '<b class="attention">??????</b>';
                                                                                                                $price_min = $price_max;
                                                                                                            }


                                                                                                            ?>
                                                                                                            <?= valuesCompare($price_min, $price_max) ?> <i class="fal fa-ruble-sign"></i>
                                                                                                        <? } else { ?>
                                                                                                            <?
                                                                                                            $areas_min = [];
                                                                                                            $prices = [
                                                                                                                'price_sub_three',
                                                                                                                'price_sub_two',
                                                                                                                'price_sub',

                                                                                                                'price_floor',
                                                                                                                'price_field',
                                                                                                                'price_mezzanine',
                                                                                                                'price_mezzanine_two',
                                                                                                                'price_mezzanine_three',
                                                                                                                'price_mezzanine_four',


                                                                                                                'price_floor_two',
                                                                                                                'price_floor_three',
                                                                                                                'price_floor_four',
                                                                                                                'price_floor_five',
                                                                                                                'price_floor_six',



                                                                                                            ];
                                                                                                            $price_sum_min = 999999999;
                                                                                                            $price_sum_max = 0;

                                                                                                            foreach ($prices as $price_field) {
                                                                                                                if ($obj_block->getField($price_field . '_min') && $obj_block->getField($price_field . '_min') < $price_sum_min) {
                                                                                                                    $price_sum_min  = $obj_block->getField($price_field . '_min');
                                                                                                                }
                                                                                                                if ($obj_block->getField($price_field . '_max') && $obj_block->getField($price_field . '_max') > $price_sum_max) {
                                                                                                                    $price_sum_max  = $obj_block->getField($price_field . '_max');
                                                                                                                }
                                                                                                            }

                                                                                                            if ($area_min = $obj_block->getField('price_floor_min')) {
                                                                                                                $areas_min[] = $area_min;
                                                                                                            }
                                                                                                            if ($area_min = $obj_block->getField('price_mezzanine_min')) {
                                                                                                                $areas_min[] = $area_min;
                                                                                                            }

                                                                                                            if (in_array($price_sum_min, [0, 999999999]) || $price_sum_max == 999999999) {
                                                                                                                $price_sum_max = '<b class="attention">??????</b>';
                                                                                                                $price_sum_min = $price_sum_max;
                                                                                                            }


                                                                                                            $prices_all_names = [
                                                                                                                'price_sub_three',
                                                                                                                'price_sub_two',
                                                                                                                'price_sub',
                                                                                                                'price_field',
                                                                                                                'price_floor',
                                                                                                                'price_mezzanine',
                                                                                                                'price_mezzanine_two',
                                                                                                                'price_mezzanine_three',
                                                                                                                'price_mezzanine_four',
                                                                                                                'price_floor_two',
                                                                                                                'price_floor_three',
                                                                                                                'price_floor_four',
                                                                                                                'price_floor_five',
                                                                                                                'price_floor_six',
                                                                                                                'price_office',
                                                                                                                'price_tech',
                                                                                                            ];

                                                                                                            if (1) {
                                                                                                                $prices_all = [];

                                                                                                                foreach ($prices_all_names as $price) {
                                                                                                                    $prices_all[] = $obj_block->getField($price . '_min');
                                                                                                                    $prices_all[] = $obj_block->getField($price . '_max');
                                                                                                                }
                                                                                                            }

                                                                                                            ?>
                                                                                                            <?
                                                                                                            $prices = [
                                                                                                                '-3' => ['price_sub_tree', 'E- подвал -3эт'],
                                                                                                                '-2' => ['price_sub_two', 'E- подвал -2эт'],
                                                                                                                '-1' => ['price_sub', 'E- подвал -1эт'],
                                                                                                                '1f' => ['price_field', 'E-уличного'],
                                                                                                                '1' => ['price_floor', 'E-пола 1эт'],
                                                                                                                '1m' => ['price_mezzanine', 'E-мезонина 1ур'],
                                                                                                                '2m' => ['price_mezzanine_two', 'E-мезонина 2ур'],
                                                                                                                '3m' => ['price_mezzanine_three', 'E-мезонина 3ур'],
                                                                                                                '4m' => ['price_mezzanine_four', 'E-мезонина 4ур'],
                                                                                                                '2' => ['price_floor_two', 'E-пола 2 эт.'],
                                                                                                                '3' => ['price_floor_three', 'E-пола 3 эт.'],
                                                                                                                '4' => ['price_floor_four', 'E-пола 4 эт.'],
                                                                                                                '5' => ['price_floor_five', 'E-пола 5 эт.'],
                                                                                                                '6' => ['price_floor_six', 'E-пола 6 эт.'],
                                                                                                            ];



                                                                                                            $arr_floors_areas = [];
                                                                                                            foreach ($array_floor_new as $key => $value) {
                                                                                                                $arr_floors_areas[] = $value;
                                                                                                            }



                                                                                                            $arr_floors_areas_fixed = [];
                                                                                                            foreach ($arr_floors_areas as $key => $value) {
                                                                                                                $arr_floors_areas_fixed[$key]['min'][0] = min($arr_floors_areas[$key]['min']);
                                                                                                                $arr_floors_areas_fixed[$key]['max'][0] = max($arr_floors_areas[$key]['max']) + max($arr_floors_areas[$key]['min']);
                                                                                                            }


                                                                                                            $prices_on_floors_sklad_min = [];
                                                                                                            $prices_on_floors_sklad_max = [];

                                                                                                            //echo '<pre>';
                                                                                                            //print_r($arr_floors_areas);
                                                                                                            //echo '</pre>';

                                                                                                            //echo '<pre>';
                                                                                                            //print_r($arr_floors_areas_fixed);
                                                                                                            //echo '</pre>';


                                                                                                            //$arr_floors_areas = $arr_floors_areas_fixed;


                                                                                                            $i = 0;
                                                                                                            foreach ($prices as $key => $value) {
                                                                                                                if ($price_min_lol = $obj_block->getField($value[0] . '_min')) {
                                                                                                                    $price_max_lol = $obj_block->getField($value[0] . '_max');

                                                                                                                    $price_min_lol = ceil($price_min_lol / 12) * $arr_floors_areas[$i]['min'][0];
                                                                                                                    $price_max_lol = ceil($price_max_lol / 12) * $arr_floors_areas[$i]['max'][0];

                                                                                                                    $prices_on_floors_sklad_min[] = $price_min_lol;
                                                                                                                    $prices_on_floors_sklad_max[] = $price_max_lol;

                                                                                                                    $i++;
                                                                                                                }
                                                                                                            }

                                                                                                            $prices_on_floors_offer_min = $prices_on_floors_sklad_min;
                                                                                                            $prices_on_floors_offer_max = $prices_on_floors_sklad_max;


                                                                                                            $prices_on_floors_offer_max[] = ceil($obj_block->getField('price_office_max') / 12) * $obj_block->getField('area_office_max');
                                                                                                            $prices_on_floors_offer_max[] = ceil($obj_block->getField('price_tech_max') / 12) * $obj_block->getField('area_tech_max');

                                                                                                            ?>
                                                                                                            <? if ($_GET['format'] == 2) {
                                                                                                                $prices_all_min = ceil(getArrayMin($prices_all) / 12);
                                                                                                                $prices_all_max = ceil(max($prices_all) / 12);
                                                                                                                $dim = 'руб/м<sup>2</sup> мес';
                                                                                                            } elseif ($_GET['format'] == 3) {
                                                                                                                $prices_all_min = min($prices_on_floors_offer_min);
                                                                                                                $prices_all_max = array_sum($prices_on_floors_offer_max);

                                                                                                                if ($obj_block->getField('is_solid')) {
                                                                                                                    $prices_all_min = $prices_all_max;
                                                                                                                }

                                                                                                                $dim = 'руб/мес';
                                                                                                            } else {
                                                                                                                $prices_all_min = getArrayMin($prices_all);
                                                                                                                $prices_all_max = max($prices_all);
                                                                                                                $dim = 'руб/м<sup>2</sup> год';
                                                                                                            } ?>
                                                                                                            <?= valuesCompare(numFormat($prices_all_min), numFormat($prices_all_max)) ?> <?= $dim ?>
                                                                                                        <? } ?>
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="box-vertical">
                                                                                                    <? if ($obj_block->dealType() == 2) { ?>
                                                                                                        <div class="flex-box">
                                                                                                            <div>Цена за м кв</div>
                                                                                                            <div class="to-end"><?= valuesCompare(numFormat($obj_block->getField('price_sale_min')), numFormat($obj_block->getField('price_sale_max'))) ?> руб/м<sup>2</sup></div>
                                                                                                        </div>
                                                                                                    <? } ?>

                                                                                                    <?

                                                                                                    if ($_COOKIE['member_id']) {
                                                                                                        //var_dump($prices_on_floors);
                                                                                                    }



                                                                                                    ?>
                                                                                                    <? if (!$obj_block->isLand() && $obj_block->dealType() != 2 && $obj_block->dealType() != 3) { ?>
                                                                                                        <div class=" isBold flex-box ">
                                                                                                            <div class="">Е-складская</div>
                                                                                                            <div class="to-end">
                                                                                                                <? if ($_GET['format'] == 2) {
                                                                                                                    $price_sum_min = ceil($price_sum_min / 12);
                                                                                                                    $price_sum_max = ceil($price_sum_max / 12);
                                                                                                                    $dim = 'руб/м<sup>2</sup> мес';
                                                                                                                } elseif ($_GET['format'] == 3) {
                                                                                                                    $price_sum_min = ceil(min($prices_on_floors_sklad_min)) - ceil(min($prices_on_floors_sklad_min)) % 100;
                                                                                                                    $price_sum_max = ceil(array_sum($prices_on_floors_sklad_max)) - ceil(array_sum($prices_on_floors_sklad_max)) % 100;

                                                                                                                    if ($obj_block->getField('is_solid')) {
                                                                                                                        $price_sum_min = $price_sum_max;
                                                                                                                    }

                                                                                                                    $dim = 'руб/мес';
                                                                                                                } else {
                                                                                                                    $dim = 'руб/м<sup>2</sup> год';
                                                                                                                } ?>
                                                                                                                <?= valuesCompare(numFormat($price_sum_min), numFormat($price_sum_max)) ?> <?= $dim ?>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    <? } ?>
                                                                                                    <?
                                                                                                    //$prices_on_floors[] = $obj_block->getField('price_office_min');
                                                                                                    //$prices_on_floors[] =


                                                                                                    ?>
                                                                                                    <? if (!$obj_block->isLand()) { ?>
                                                                                                        <? $i = 0 ?>
                                                                                                        <? foreach ($prices as $key => $value) { ?>
                                                                                                            <? if ($price_min = $obj_block->getField($value[0] . '_min')) { ?>
                                                                                                                <? $price_max = $obj_block->getField($value[0] . '_max')  ?>
                                                                                                                <div class="flex-box" style="line-height: 23px;">
                                                                                                                    <div><?= $value[1] ?></div>
                                                                                                                    <div class="to-end">
                                                                                                                        <? if ($_GET['format'] == 2) {
                                                                                                                            $price_min = ceil($price_min / 12);
                                                                                                                            $price_max = ceil($price_max / 12);
                                                                                                                            $dim = ' руб/м<sup>2</sup> мес';
                                                                                                                        } elseif ($_GET['format'] == 3) {
                                                                                                                            $price_min = ceil(($price_max / 12) * $arr_floors_areas[$i]['min'][0]) - ceil(($price_max / 12) * $arr_floors_areas[$i]['min'][0]) % 100;
                                                                                                                            $price_max = ceil(($price_max / 12) * $arr_floors_areas[$i]['max'][0]) - ceil(($price_max / 12) * $arr_floors_areas[$i]['max'][0]) % 100;
                                                                                                                            $dim = 'руб/мес';
                                                                                                                        } else {

                                                                                                                            $dim = 'руб/м<sup>2</sup> год';
                                                                                                                        } ?>
                                                                                                                        <?= valuesCompare(numFormat($price_min), numFormat($price_max)) . ' ' . $dim ?>
                                                                                                                    </div>
                                                                                                                </div>
                                                                                                            <? $i++;
                                                                                                            } ?>
                                                                                                        <? } ?>
                                                                                                    <? } ?>
                                                                                                    <? if ($price_min = $obj_block->getField('price_office_min')) { ?>
                                                                                                        <? $price_max = $obj_block->getField('price_office_max')  ?>
                                                                                                        <div class="flex-box" style="line-height: 23px;">
                                                                                                            <div>E-офисов</div>
                                                                                                            <div class="to-end">
                                                                                                                <? if ($_GET['format'] == 2) {
                                                                                                                    $price_min = ceil($price_min / 12);
                                                                                                                    $price_max = ceil($price_max / 12);
                                                                                                                    $dim = ' руб/м<sup>2</sup> мес';
                                                                                                                } elseif ($_GET['format'] == 3) {
                                                                                                                    $price_min = ceil(($price_max / 12) * $obj_block->getField('area_office_min')) - ceil(($price_max / 12) * $obj_block->getField('area_office_min')) % 100;
                                                                                                                    $price_max = ceil(($price_max / 12) * $obj_block->getField('area_office_max')) - ceil(($price_max / 12) * $obj_block->getField('area_office_max')) % 100;
                                                                                                                    $dim = 'руб/мес';
                                                                                                                } else {

                                                                                                                    $dim = ' руб/м<sup>2</sup> год';
                                                                                                                } ?>

                                                                                                                <?= valuesCompare(numFormat($price_min), numFormat($price_max)) . ' ' . $dim ?>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    <? } ?>
                                                                                                    <? if ($price_min = $obj_block->getField('price_tech_min')) { ?>
                                                                                                        <? $price_max = $obj_block->getField('price_tech_max')  ?>
                                                                                                        <div class="flex-box" style="line-height: 23px;">
                                                                                                            <div>E-техническая</div>
                                                                                                            <div class="to-end">
                                                                                                                <? if ($_GET['format'] == 2) {
                                                                                                                    $price_min = ceil($price_min / 12);
                                                                                                                    $price_max = ceil($price_max / 12);
                                                                                                                    $dim = ' руб/м<sup>2</sup> мес';
                                                                                                                } elseif ($_GET['format'] == 3) {
                                                                                                                    $price_min = ceil(($price_max / 12) * $obj_block->getField('area_tech_min')) - ceil(($price_max / 12) * $obj_block->getField('area_tech_min')) % 100;
                                                                                                                    $price_max = ceil(($price_max / 12) * $obj_block->getField('area_tech_max')) - ceil(($price_max / 12) * $obj_block->getField('area_tech_max')) % 100;
                                                                                                                    $dim = 'руб/мес';
                                                                                                                } else {

                                                                                                                    $dim = ' руб/м<sup>2</sup> год';
                                                                                                                } ?>
                                                                                                                <?= valuesCompare(numFormat($price_min), numFormat($price_max)) . ' ' . $dim ?>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    <? } ?>
                                                                                                    <? if ($obj_block->dealType() == 3) { ?>
                                                                                                        <? if ($obj_block->getField('price_safe_pallet_eu_min')) { ?>
                                                                                                            <div class="flex-box " style="line-height: 23px;">
                                                                                                                <div class="isBold">~ E-аренды</div>
                                                                                                                <div class="to-end">
                                                                                                                    <?
                                                                                                                    $price_min = $obj_block->gf('pallet_place_min') * $obj_block->gf('price_safe_pallet_eu_max') * 30 * 12 / ($obj_block->getField('area_floor_min'));
                                                                                                                    $price_max = $obj_block->gf('pallet_place_max') * $obj_block->gf('price_safe_pallet_eu_max') * 30 * 12 / ($obj_block->getField('area_floor_max') + $obj_block->getField('area_mezzanine_max'));

                                                                                                                    ?>
                                                                                                                    <span class="isBold"><?= valuesCompare(numFormat(ceil($price_max)), numFormat(ceil($price_max))) ?> Р</span>
                                                                                                                    <span class="ghost" style="width: 70px; text-align: right;">м<sup>2</sup>/год</span>
                                                                                                                </div>
                                                                                                            </div>
                                                                                                        <? } ?>
                                                                                                        <?
                                                                                                        $arr = [
                                                                                                            ['EU  паллет 1.2*0.8*1.75', 'price_safe_pallet_eu', ' п.м/сут.'],
                                                                                                            ['FIN паллет 1.2*1*1.75', 'price_safe_pallet_fin', ' п.м/сут.'],
                                                                                                            ['US  паллет 1.2*1.2*1.75', 'price_safe_pallet_us', ' п.м/сут.'],
                                                                                                            ['Напольное', 'price_safe_floor', ' м.кв./сут'],
                                                                                                        ]
                                                                                                        ?>
                                                                                                        <? foreach ($arr as $item) { ?>
                                                                                                            <? if ($obj_block->getField($item[1] . '_min')) { ?>
                                                                                                                <div>
                                                                                                                    <div class="flex-box">
                                                                                                                        <div style="width: 150px ;">
                                                                                                                            <?= $item[0] ?>
                                                                                                                        </div>
                                                                                                                        <div class="flex-box to-end">
                                                                                                                            <div>
                                                                                                                                <?= valuesCompare($obj_block->getField($item[1] . '_min'), $obj_block->getField($item[1] . '_max')) ?>
                                                                                                                                <span>Р</span>
                                                                                                                            </div>
                                                                                                                            <div class="ghost " style="width: 70px; text-align: right;">
                                                                                                                                <?= $item[2] ?>
                                                                                                                            </div>
                                                                                                                        </div>
                                                                                                                    </div>
                                                                                                                </div>
                                                                                                            <? } ?>

                                                                                                        <? } ?>
                                                                                                    <? } ?>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="one_fourth box">
                                                                                            <? if ($obj_block->hasDeal()) { ?>
                                                                                                <div class="attention isBold">
                                                                                                    Сделка завершена
                                                                                                </div>
                                                                                                <?
                                                                                                $deal = new Deal($obj_block->getDealId());
                                                                                                ?>
                                                                                                <div class="isBold">
                                                                                                    <?= (new Company($deal->getField('client_company_id')))->title() ?>
                                                                                                </div>
                                                                                                <div class="isBold">
                                                                                                    <?= date('d-m-Y', strtotime($deal->getField('start_time'))) ?>
                                                                                                </div>
                                                                                                <div class="isBold">
                                                                                                    <?= (new Member($deal->getField('agent_id')))->title() ?>
                                                                                                </div>

                                                                                            <? } else { ?>
                                                                                                <div class="good isBold">
                                                                                                    Активная сделка
                                                                                                </div>
                                                                                            <? } ?>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="flex-box box-vertical flex-wrap">
                                                                                        <? if (!$obj_block->isLand()) { ?>
                                                                                            <? if (arrayIsNotEmpty($obj_block->getJsonField('floor_types')) && count($obj_block->getJsonField('floor_types')) > 1) { ?>
                                                                                                <div title="Тип пола" class="box-small isBold">
                                                                                                    <div>
                                                                                                        <span class="box-wide ghost-double"><i class="fas fa-arrow-alt-to-bottom"></i></span>
                                                                                                        Разные
                                                                                                    </div>
                                                                                                </div>
                                                                                            <? } else { ?>
                                                                                                <?
                                                                                                $type_id = (int)$obj_block->getJsonField('floor_types')[0];
                                                                                                $table = 'l_floor_types';
                                                                                                ?>
                                                                                                <div class="box-small isBold">
                                                                                                    <div>
                                                                                                        <span class="box-wide ghost-double"><i class="fas fa-arrow-alt-to-bottom"></i></span>
                                                                                                        <?= getPostTitle($type_id, $table) ?>
                                                                                                    </div>
                                                                                                </div>
                                                                                            <? } ?>
                                                                                        <? } else { ?>
                                                                                            <? if (arrayIsNotEmpty($obj_block->getJsonField('floor_types_land')) && count($obj_block->getJsonField('floor_types')) > 1) { ?>
                                                                                                <div title="Тип пола" class="box-small isBold">
                                                                                                    <div>
                                                                                                        <span class="box-wide ghost-double"><i class="fas fa-arrow-alt-to-bottom"></i></span>
                                                                                                        Разные
                                                                                                    </div>
                                                                                                </div>
                                                                                            <? } else { ?>
                                                                                                <?
                                                                                                $type_id = (int)$obj_block->getJsonField('floor_types_land')[0];
                                                                                                $table = 'l_floor_types_land';
                                                                                                ?>
                                                                                                <div class="box-small isBold">
                                                                                                    <div>
                                                                                                        <span class="box-wide ghost-double"><i class="fas fa-arrow-alt-to-bottom"></i></span>
                                                                                                        <?= getPostTitle($type_id, $table) ?>
                                                                                                    </div>
                                                                                                </div>
                                                                                            <? } ?>
                                                                                        <? } ?>
                                                                                        <? if (($height_min = $obj_block->getField('ceiling_height_min')) > 0) { ?>
                                                                                            <div class="box-small isBold flex-box flex-center-center">
                                                                                                <div>
                                                                                                    <span class="box-wide ghost-double"><i class="fas fa-arrow-to-top"></i></span> <?= valuesCompare($height_min, $obj_block->getField('ceiling_height_max')) ?> м.
                                                                                                </div>
                                                                                            </div>
                                                                                        <? } ?>
                                                                                        <? if (($power = $obj_block->getField('power')) > 0) { ?>
                                                                                            <div class="box-small isBold flex-box flex-center-center">
                                                                                                <div>
                                                                                                    <span class="box-wide ghost-double"><i class="fas fa-bolt"></i></span><?= $power ?> кВт
                                                                                                </div>
                                                                                            </div>
                                                                                        <? } ?>
                                                                                        <? if ($obj_block->getField('heated') == 1) { ?>
                                                                                            <div class="box-small isBold flex-box flex-center-center">
                                                                                                <div>
                                                                                                    <span class="box-wide ghost-double"><i class="fas fa-temperature-hot"></i></span>
                                                                                                    Отопление
                                                                                                </div>
                                                                                            </div>
                                                                                        <? } ?>

                                                                                        <? if ($sum = array_sum($obj_block->getBlockArrayValueEven('gates'))) { ?>
                                                                                            <div class="box-small isBold flex-box flex-center-center">
                                                                                                <div>
                                                                                                    <span class="box-wide ghost-double"><i class="far fa-dungeon"></i></span>
                                                                                                    <?= $sum ?>
                                                                                                    Ворот
                                                                                                </div>
                                                                                            </div>
                                                                                        <? } ?>
                                                                                        <? if ($obj_block->getField('cranes_num') > 0) { ?>
                                                                                            <div class="box-small isBold flex-box flex-center-center">
                                                                                                <div>
                                                                                                    <span class="box-wide ghost-double"><i class="fas fa-angle-double-up"></i></span>
                                                                                                    Краны <?= $obj_block->getField('cranes_num') ?>шт <?= valuesCompare($obj_block->getField('cranes_min'), $obj_block->getField('cranes_max')) ?> т.
                                                                                                </div>
                                                                                            </div>
                                                                                        <? } ?>
                                                                                        <? if ($obj_block->getField('elevators_num') > 0) { ?>
                                                                                            <div class="box-small isBold flex-box flex-center-center">
                                                                                                <div>
                                                                                                    <span class="box-wide ghost-double"><i class="fas fa-angle-double-up"></i></span>
                                                                                                    --Подъемники <?= $obj_block->getField('elevators_num') ?>шт <?= valuesCompare($obj_block->getField('elevators_min'), $obj_block->getField('elevators_max')) ?> т.
                                                                                                </div>
                                                                                            </div>
                                                                                        <? } ?>
                                                                                        <? if ($temp_min = $obj_block->getField('temperature_min')) { ?>
                                                                                            <div class="box-small isBold flex-box flex-center-center">
                                                                                                <div>
                                                                                                    <span class="box-wide ghost-double"><i class="fas fa-temperature-low"></i></span> <?= valuesCompare($temp_min, $obj_block->getField('temperature_max')) ?> град.
                                                                                                </div>
                                                                                            </div>
                                                                                        <? } ?>
                                                                                        <? if ($obj_block->getField('racks') == 1) { ?>
                                                                                            <div class="box-small isBold flex-box flex-center-center">
                                                                                                <div>
                                                                                                    <span class="box-wide ghost-double"><i class="fas fa-inventory"></i></span>
                                                                                                    Стеллажи
                                                                                                </div>
                                                                                            </div>
                                                                                        <? } ?>
                                                                                        <? if ($obj_block->getField('cross_docking') == 1) { ?>
                                                                                            <div class="box-small isBold flex-box flex-center-center">
                                                                                                <div>
                                                                                                    Кросс-докинг
                                                                                                </div>
                                                                                            </div>
                                                                                        <? } ?>
                                                                                        <? if ($obj_block->getField('warehouse_equipment') == 1) { ?>
                                                                                            <div class="box-small isBold flex-box flex-center-center">
                                                                                                <div>
                                                                                                    <span class="box-wide ghost-double"><i class="fas fa-truck-loading"></i></span>
                                                                                                    Складская техника
                                                                                                </div>
                                                                                            </div>
                                                                                        <? } ?>
                                                                                        <? if ($obj_block->getField('charging_room') == 1) { ?>
                                                                                            <div class="box-small isBold flex-box flex-center-center">
                                                                                                <div>
                                                                                                    <span class="box-wide ghost-double"><i class="fas fa-charging-station"></i></span>
                                                                                                    Зарядная комната
                                                                                                </div>
                                                                                            </div>
                                                                                        <? } ?>
                                                                                        <? if ($obj_block->getField('gas') == 1) { ?>
                                                                                            <div class="box-small isBold flex-box flex-center-center">
                                                                                                <div>
                                                                                                    <span class="box-wide ghost-double">
                                                                                                        <i class="fas fa-burn"></i>
                                                                                                    </span>
                                                                                                    Газ
                                                                                                </div>
                                                                                            </div>
                                                                                        <? } ?>
                                                                                        <? if ($obj_block->getField('steam') == 1) { ?>
                                                                                            <div class="box-small isBold flex-box flex-center-center">
                                                                                                <div>
                                                                                                    <span class="box-wide ghost-double">
                                                                                                        <i class="fab fa-steam ghost-double"></i>
                                                                                                    </span>
                                                                                                    Пар
                                                                                                </div>
                                                                                            </div>
                                                                                        <? } ?>
                                                                                        <? if ($obj_block->getField('sewage') == 1) { ?>
                                                                                            <div class="box-small isBold flex-box flex-center-center">
                                                                                                <div>
                                                                                                    <span class="box-wide ghost-double">
                                                                                                        <i class="fas fa-shower"></i>
                                                                                                    </span>
                                                                                                    Центр. канализ
                                                                                                </div>
                                                                                            </div>
                                                                                        <? } ?>
                                                                                    </div>
                                                                                    <div>
                                                                                        <div class="tabs-block tabs-active-free  full-width">
                                                                                            <div class="tabs flex-box">
                                                                                                <? if ($offer->getField('deal_type') == 3 && !$object->getField('is_land')) { ?>
                                                                                                    <div class="tab box-small ">
                                                                                                        Цены +
                                                                                                    </div>
                                                                                                    <div class="tab box-small">
                                                                                                        Услуги О/Х
                                                                                                    </div>
                                                                                                <? } ?>
                                                                                                <div class="tab box-small">
                                                                                                    Сводка ---
                                                                                                </div>
                                                                                                <div class="tab box-small block-fix ">
                                                                                                    По блокам
                                                                                                </div>
                                                                                                <div class="tab box-small">
                                                                                                    Клиенты
                                                                                                </div>
                                                                                                <div class="tab box-small">
                                                                                                    Задачи
                                                                                                </div>
                                                                                                <? if ($obj_block->hasDeal()) { ?>
                                                                                                    <div class="tab box-small">
                                                                                                        Сделка
                                                                                                    </div>
                                                                                                <? } ?>
                                                                                                <div class="flex-box to-end ">
                                                                                                    <div class="flex-box box-small">
                                                                                                        <? if ($logedUser->isAdmin()) { ?>
                                                                                                            <div class="icon-round modal-call-btn <? if ($obj_block->hasNoPrice()) { ?> block-priceless <? } ?>" data-form="<?= $deal_forms_blocks_arr[$object->getField('is_land')][$offer->getField('deal_type') - 1] ?>" data-id="<?= $obj_block->postId() ?>" data-table="<?= $obj_block->setTableId() ?>" data-modal="edit-all" data-modal-size="modal-big"><i class="fas fa-pencil-alt"></i></div>
                                                                                                            <? if (!$obj_block->hasPartUnactive()) { ?>
                                                                                                                <div class="icon-round  modal-call-btn  " <? if ($obj_block->getField('deal_id') != 0/*$obj_block->hasDeal()*/) { ?> style="background: limegreen; color: white;" title="Редактировать сделку" <? } ?> title="Создать сделку" data-modal="edit-all" data-id="<?= (int)$obj_block->getField('deal_id')/*$obj_block->getDealId()*/ ?>" data-table="<?= (new Deal())->setTableId() ?>" data-names='["block_id"]' data-values='[<?= $obj_block->postId() ?>]' data-show-name="object_id" data-modal-size="modal-middle">
                                                                                                                    <div>
                                                                                                                        <i class="far fa-handshake"></i>
                                                                                                                    </div>
                                                                                                                </div>
                                                                                                            <? } ?>
                                                                                                        <? } ?>

                                                                                                        <? if (1) { ?>
                                                                                                            <? if ($logedUser->isAdmin()) { ?>
                                                                                                                <div class="icon-round ad-panel-call modal-call-btn1" data-id="" data-table="" data-modal="panel-ad" data-modal-size="modal-middle"><i class="fas fa-rocket"></i></div>
                                                                                                            <? } ?>
                                                                                                            <div class="icon-round" style="position: relative;">
                                                                                                                <a target="_blank" href="/pdf-test.php?original_id=<?= $obj_block->postId() ?>&type_id=1&member_id=<?= $logedUser->member_id() ?>"><i class="fas fa-file-pdf"></i></a>
                                                                                                                <? if (!arrayIsNotEmpty($obj_block->getJsonField('photo_block'))) { ?>
                                                                                                                    <div class="overlay-over" title="презентация недоступна так нету фото в блоке" style="background: red; ">

                                                                                                                    </div>
                                                                                                                <? } ?>
                                                                                                            </div>

                                                                                                            <div class="icon-round icon-star <?= (in_array([$obj_block->postId(), 1], $favourites)) ? 'icon-star-active' : '' ?>" data-offer-id="[<?= $obj_block->postId() ?>,1]"><i class="fas fa-star"></i></div>
                                                                                                            <? if ($obj_block->getJsonField('photos_360_block') != NULL &&  arrayIsNotEmpty($obj_block->getJsonField('photos_360_block'))) { ?>
                                                                                                                <div class="icon-round to-end">
                                                                                                                    <a href="/tour-360/<?= $obj_block->setTableId() ?>/<?= $obj_block->postId() ?>/photos_360_block" target="_blank"><span title="Панорама"><i class="fas fa-globe"></i></span></a>
                                                                                                                </div>
                                                                                                            <? } ?>
                                                                                                            <? if ($logedUser->isAdmin()) { ?>
                                                                                                                <div class="icon-round modal-call-btn to-end" data-form="<?= $deal_forms_blocks_arr[$object->getField('is_land')][$offer->getField('deal_type') - 1] ?>" data-id="<?= $obj_block->postId() ?>" data-table="<?= $obj_block->setTableId() ?>" data-modal="delete" data-modal-size="modal-small" title="Разорвать связь"><i class="far fa-trash-alt"></i></div>
                                                                                                            <? } ?>
                                                                                                        <? } ?>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="tabs-content full-width">
                                                                                                <? if ($offer->getField('deal_type') == 3 && !$object->getField('is_land')) { ?>
                                                                                                    <div class="tab-content">
                                                                                                        <? if ($offer->getField('deal_type') == 3 && !$object->getField('is_land')) { ?>
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
                                                                                                                <div style="height: 32px;">

                                                                                                                </div>
                                                                                                                <div class="tabs-content" style="background: #f4f4f4; border: 1px solid lightblue;">
                                                                                                                    <div class="tab-content">
                                                                                                                        <ul class="full-width">
                                                                                                                            <?
                                                                                                                            $arr = [
                                                                                                                                ['EU  паллет 1.2*0.8*1.75', 'price_safe_pallet_eu', 'Р п.м/сут.'],
                                                                                                                                ['FIN паллет 1.2*1*1.75', 'price_safe_pallet_fin', 'Р п.м/сут.'],
                                                                                                                                ['US  паллет 1.2*1.2*1.75', 'price_safe_pallet_us', 'Р п.м/сут.'],
                                                                                                                                ['Негаб паллет/груз до 2т', 'price_safe_pallet_oversized', 'Р за ед.'],
                                                                                                                                ['Ячейки 30x40 ', 'price_safe_cell_small', 'яч./сут.'],
                                                                                                                                ['Ячейки 60x40', 'price_safe_cell_middle', 'яч./сут.'],
                                                                                                                                ['Ячейки 60x80', 'price_safe_cell_big', 'яч./сут.'],
                                                                                                                                ['Напольное', 'price_safe_floor', 'Р за м.кв./сут'],
                                                                                                                                ['Объемное', 'price_safe_volume', 'Р за м.куб./сут'],
                                                                                                                            ]
                                                                                                                            ?>
                                                                                                                            <? foreach ($arr as $item) { ?>
                                                                                                                                <li>
                                                                                                                                    <span class="flex-box">
                                                                                                                                        <div style="width: 200px ;">
                                                                                                                                            <?= $item[0] ?>
                                                                                                                                        </div>
                                                                                                                                        <div style="width: 100px">
                                                                                                                                            <?= valuesCompare($offer->getOfferBlocksMinValue($item[1] . '_min'), $offer->getOfferBlocksMaxValue($item[1] . '_max')) ?>
                                                                                                                                        </div>
                                                                                                                                        <div class="ghost to-end">
                                                                                                                                            <?= $item[2] ?>
                                                                                                                                        </div>
                                                                                                                                    </span>
                                                                                                                                </li>
                                                                                                                            <? } ?>
                                                                                                                        </ul>
                                                                                                                    </div>
                                                                                                                    <div class="tab-content">
                                                                                                                        <ul class="full-width">
                                                                                                                            <?
                                                                                                                            $arr_1 = [
                                                                                                                                ['EU  паллет 1.2*0.8*1.75', 'price_safe_pallet_eu_in', 'Р за ед.'],
                                                                                                                                ['FIN паллет 1.2*1*1.75', 'price_safe_pallet_fin_in', 'Р за ед.'],
                                                                                                                                ['US  паллет 1.2*1.2*1.75', 'price_safe_pallet_us_in', 'Р за ед.'],
                                                                                                                                ['Негаб паллет/груз до 2т', 'price_safe_pallet_oversized_in', 'Р за ед.'],
                                                                                                                                ['Нагаб паллет/ 2-5т', 'price_safe_pallet_oversized_middle_in', 'Р за ед.'],
                                                                                                                                ['Негаб паллет / 5-8т', 'price_safe_pallet_oversized_big_in', 'Р за ед.'],
                                                                                                                            ];

                                                                                                                            $arr_2 = [
                                                                                                                                ['Короб/ мешок до 10кг ', 'price_safe_pack_small_in', 'Р за ед'],
                                                                                                                                ['Короб/мешок до 25кг', 'price_safe_pack_middle_in', 'Р за ед'],
                                                                                                                                ['Короб/мешок до 40кг', 'price_safe_pack_big_in', 'Р за ед'],
                                                                                                                            ];
                                                                                                                            ?>
                                                                                                                            <li><u>Механизированная погрузка</u></li>
                                                                                                                            <? foreach ($arr_1 as $item) { ?>
                                                                                                                                <li>
                                                                                                                                    <span class="flex-box">
                                                                                                                                        <div style="width: 200px;">
                                                                                                                                            <?= $item[0] ?>
                                                                                                                                        </div>
                                                                                                                                        <div style="width: 100px">
                                                                                                                                            <?= valuesCompare($offer->getOfferBlocksMinValue($item[1]), $offer->getOfferBlocksMaxValue($item[1])) ?>
                                                                                                                                        </div>
                                                                                                                                        <div class="ghost">
                                                                                                                                            <?= $item[2] ?>
                                                                                                                                        </div>
                                                                                                                                    </span>
                                                                                                                                </li>
                                                                                                                            <? } ?>
                                                                                                                            <li><u>Ручная погрузка</u></li>
                                                                                                                            <? foreach ($arr_2 as $item) { ?>
                                                                                                                                <li>
                                                                                                                                    <span class="flex-box">
                                                                                                                                        <div style="width: 200px;">
                                                                                                                                            <?= $item[0] ?>
                                                                                                                                        </div>
                                                                                                                                        <div style="width: 100px">
                                                                                                                                            <?= valuesCompare($offer->getOfferBlocksMinValue($item[1]), $offer->getOfferBlocksMaxValue($item[1])) ?>
                                                                                                                                        </div>
                                                                                                                                        <div class="ghost">
                                                                                                                                            <?= $item[2] ?>
                                                                                                                                        </div>
                                                                                                                                    </span>
                                                                                                                                </li>
                                                                                                                            <? } ?>
                                                                                                                        </ul>
                                                                                                                    </div>
                                                                                                                    <div class="tab-content">
                                                                                                                        <ul class="full-width">
                                                                                                                            <?
                                                                                                                            $arr_1 = [
                                                                                                                                ['EU  паллет 1.2*0.8*1.75', 'price_safe_pallet_eu_out', 'Р за ед.'],
                                                                                                                                ['FIN паллет 1.2*1*1.75', 'price_safe_pallet_fin_out', 'Р за ед.'],
                                                                                                                                ['US  паллет 1.2*1.2*1.75', 'price_safe_pallet_us_out', 'Р за ед.'],
                                                                                                                                ['Негаб паллет/груз до 2т', 'price_safe_pallet_oversized_out', 'Р за ед.'],
                                                                                                                                ['Нагаб паллет/ 2-5т', 'price_safe_pallet_oversized_middle_out', 'Р за ед.'],
                                                                                                                                ['Негаб паллет / 5-8т', 'price_safe_pallet_oversized_big_out', 'Р за ед.'],
                                                                                                                            ];

                                                                                                                            $arr_2 = [
                                                                                                                                ['Короб/ мешок до 10кг ', 'price_safe_pack_small_out', 'Р за ед'],
                                                                                                                                ['Короб/мешок до 25кг', 'price_safe_pack_middle_out', 'Р за ед'],
                                                                                                                                ['Короб/мешок до 40кг', 'price_safe_pack_big_out', 'Р за ед'],
                                                                                                                            ];
                                                                                                                            ?>
                                                                                                                            <li><u>Механизированная погрузка</u></li>
                                                                                                                            <? foreach ($arr_1 as $item) { ?>
                                                                                                                                <li>
                                                                                                                                    <span class="flex-box">
                                                                                                                                        <div style="width: 200px;">
                                                                                                                                            <?= $item[0] ?>
                                                                                                                                        </div>
                                                                                                                                        <div style="width: 100px">
                                                                                                                                            <?= valuesCompare($offer->getOfferBlocksMinValue($item[1]), $offer->getOfferBlocksMaxValue($item[1])) ?>
                                                                                                                                        </div>
                                                                                                                                        <div class="ghost">
                                                                                                                                            <?= $item[2] ?>
                                                                                                                                        </div>
                                                                                                                                    </span>
                                                                                                                                </li>
                                                                                                                            <? } ?>
                                                                                                                            <li><u>Ручная погрузка</u></li>
                                                                                                                            <? foreach ($arr_2 as $item) { ?>
                                                                                                                                <li>
                                                                                                                                    <span class="flex-box">
                                                                                                                                        <div style="width: 200px;">
                                                                                                                                            <?= $item[0] ?>
                                                                                                                                        </div>
                                                                                                                                        <div style="width: 100px">
                                                                                                                                            <?= valuesCompare($offer->getOfferBlocksMinValue($item[1]), $offer->getOfferBlocksMaxValue($item[1])) ?>
                                                                                                                                        </div>
                                                                                                                                        <div class="ghost">
                                                                                                                                            <?= $item[2] ?>
                                                                                                                                        </div>
                                                                                                                                    </span>
                                                                                                                                </li>
                                                                                                                            <? } ?>
                                                                                                                            <li>
                                                                                                                                <div class="underlined">
                                                                                                                                    Подбор в заказ
                                                                                                                                </div>
                                                                                                                            </li>
                                                                                                                            <?
                                                                                                                            $arr = [
                                                                                                                                ['Короб/ мешок до 10кг ', 'price_safe_pack_small_complement', 'Р за ед'],
                                                                                                                                ['Короб/мешок до 25кг', 'price_safe_pack_middle_complement', 'Р за ед'],
                                                                                                                                ['Короб/мешок до 40кг', 'price_safe_pack_big_complement', 'Р за ед'],
                                                                                                                            ]
                                                                                                                            ?>
                                                                                                                            <? foreach ($arr as $item) { ?>
                                                                                                                                <li>
                                                                                                                                    <span class="flex-box">
                                                                                                                                        <div style="width: 200px;">
                                                                                                                                            <?= $item[0] ?>
                                                                                                                                        </div>
                                                                                                                                        <div style="width: 100px">
                                                                                                                                            <?= valuesCompare($offer->getOfferBlocksMinValue($item[1]), $offer->getOfferBlocksMaxValue($item[1])) ?>
                                                                                                                                        </div>
                                                                                                                                        <div class="ghost">
                                                                                                                                            <?= $item[2] ?>
                                                                                                                                        </div>
                                                                                                                                    </span>
                                                                                                                                </li>
                                                                                                                            <? } ?>
                                                                                                                        </ul>
                                                                                                                    </div>
                                                                                                                    <div class="tab-content">
                                                                                                                        <ul class="full-width">
                                                                                                                            <?
                                                                                                                            $arr = [
                                                                                                                                ['Выборочная инвентаризация', 'price_safe_service_inventory', 'Р за ед.'],
                                                                                                                                ['Обмотка стретч пленкой 2-3 слоя', 'price_safe_service_winding', 'Р за ед.'],
                                                                                                                                ['Подготовка сопроводительных документов', 'price_safe_service_document', 'Р за ед.'],
                                                                                                                                ['Предоставление отчетов', 'price_safe_service_report', 'Р за ед.'],
                                                                                                                                ['Предоставление поддонов', 'price_safe_service_pallet', 'Р за ед.'],
                                                                                                                                ['Стикеровка', 'price_safe_service_stickers', 'Р за ед.'],
                                                                                                                                ['Формирование паллет', 'price_safe_service_packing_pallet', 'Р за ед'],
                                                                                                                                ['Формирование коробов', 'price_safe_service_packing_pack', 'Р за ед'],
                                                                                                                                ['Утилизация мусора', 'price_safe_service_recycling', 'Р за ед'],
                                                                                                                                ['Опломбирование авто', 'price_safe_service_sealing', 'Р за ед'],
                                                                                                                            ]
                                                                                                                            ?>
                                                                                                                            <? foreach ($arr as $item) { ?>
                                                                                                                                <li>
                                                                                                                                    <span class="flex-box">
                                                                                                                                        <div style="width: 250px;">
                                                                                                                                            <?= $item[0] ?>
                                                                                                                                        </div>
                                                                                                                                        <div style="width: 100px">
                                                                                                                                            <?= valuesCompare($offer->getOfferBlocksMinValue($item[1]), $offer->getOfferBlocksMaxValue($item[1])) ?>
                                                                                                                                        </div>
                                                                                                                                        <div class="ghost">
                                                                                                                                            <?= $item[2] ?>
                                                                                                                                        </div>
                                                                                                                                    </span>
                                                                                                                                </li>
                                                                                                                            <? } ?>
                                                                                                                        </ul>
                                                                                                                    </div>
                                                                                                                </div>
                                                                                                            </div>
                                                                                                        <? } ?>
                                                                                                    </div>
                                                                                                    <div class="tab-content">
                                                                                                        <div class="object-params-list">
                                                                                                            <ul class="full-width box-wide">
                                                                                                                <?
                                                                                                                $all_fields = $offer->getTableColumnsNames();
                                                                                                                $services = [];
                                                                                                                foreach ($all_fields as $field_item) {
                                                                                                                    if (stristr($field_item, 'safe_service') !== false && $offer->getField($field_item)) {
                                                                                                                        $services[] = $field_item;
                                                                                                                    }
                                                                                                                }
                                                                                                                //var_dump($services);

                                                                                                                ?>
                                                                                                                <? foreach ($services as $service) { ?>
                                                                                                                    <? $service_field = new Field() ?>
                                                                                                                    <? $service_field->getFieldByName($service) ?>
                                                                                                                    <li>
                                                                                                                        <div class="full-width">
                                                                                                                            <?= $service_field->description() ?>
                                                                                                                        </div>
                                                                                                                    </li>
                                                                                                                <? } ?>
                                                                                                            </ul>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                <? } ?>
                                                                                                <div class="tab-content box-vertical" style="background: white;">
                                                                                                    <div class="flex-box flex-vertical-top">
                                                                                                        <div class="object-params-list">
                                                                                                            <ul>
                                                                                                                <li>
                                                                                                                    <div class="isBold">
                                                                                                                        Характеристики
                                                                                                                    </div>
                                                                                                                    <div>
                                                                                                                        &#160;
                                                                                                                    </div>
                                                                                                                </li>
                                                                                                                <li>
                                                                                                                    <div>
                                                                                                                        Тип пола
                                                                                                                    </div>
                                                                                                                    <div>
                                                                                                                        <? if (!$obj_block->isLand()) { ?>
                                                                                                                            <? $grids = $obj_block->getJsonField('floor_types'); ?>
                                                                                                                            <? if (count($grids)) { ?>
                                                                                                                                <? foreach ($grids as $grid) {
                                                                                                                                    $grid = new Post($grid);
                                                                                                                                    $grid->getTable('l_floor_types');
                                                                                                                                ?>
                                                                                                                                    <?= $grid->title() ?> ,
                                                                                                                                <? } ?>
                                                                                                                            <? } else { ?>
                                                                                                                                -
                                                                                                                            <? } ?>
                                                                                                                        <? } else { ?>
                                                                                                                            <? $grids = $obj_block->getJsonField('floor_types_land'); ?>
                                                                                                                            <? if (count($grids)) { ?>
                                                                                                                                <? foreach ($grids as $grid) {
                                                                                                                                    $grid = new Post($grid);
                                                                                                                                    $grid->getTable('l_floor_types_land');
                                                                                                                                ?>
                                                                                                                                    <?= $grid->title() ?> ,
                                                                                                                                <? } ?>
                                                                                                                            <? } else { ?>
                                                                                                                                -
                                                                                                                            <? } ?>
                                                                                                                        <? } ?>
                                                                                                                    </div>
                                                                                                                </li>
                                                                                                                <? if (!$obj_block->isLand()) { ?>
                                                                                                                    <li>
                                                                                                                        <div>
                                                                                                                            Высота, рабочая
                                                                                                                        </div>
                                                                                                                        <div>
                                                                                                                            <?= valuesCompare($obj_block->getBlockPartsMinValue('ceiling_height_min'), $obj_block->getBlockPartsMaxValue('ceiling_height_max')) ?> <span>м</span>
                                                                                                                        </div>
                                                                                                                    </li>
                                                                                                                    <li>
                                                                                                                        <div>
                                                                                                                            Нагрузка на пол
                                                                                                                        </div>
                                                                                                                        <div>
                                                                                                                            <?= valuesCompare($obj_block->getField('load_floor_min'), $obj_block->getField('load_floor_max')) ?> <span>т/м<sup>2</sup></span>
                                                                                                                        </div>
                                                                                                                    </li>
                                                                                                                    <li>
                                                                                                                        <div>
                                                                                                                            Нагрузка на мезонин
                                                                                                                        </div>
                                                                                                                        <div>
                                                                                                                            <?= valuesCompare($obj_block->getField('load_mezzanine_min'), $obj_block->getField('load_mezzanine_max')) ?> <span>т/м<sup>2</sup></span>
                                                                                                                        </div>
                                                                                                                    </li>
                                                                                                                    <li>
                                                                                                                        <div>
                                                                                                                            Шаг колонн
                                                                                                                        </div>
                                                                                                                        <div>
                                                                                                                            <? $grids = $obj_block->getJsonField('column_grids'); ?>
                                                                                                                            <? if (count($grids)) { ?>
                                                                                                                                <? foreach ($grids as $grid) {
                                                                                                                                    $grid = new Post($grid);
                                                                                                                                    $grid->getTable('l_pillars_grid');
                                                                                                                                ?>
                                                                                                                                    <?= $grid->title() ?> ,
                                                                                                                                <? } ?>
                                                                                                                            <? } else { ?>
                                                                                                                                -
                                                                                                                            <? } ?>
                                                                                                                        </div>
                                                                                                                    </li>
                                                                                                                    <?
                                                                                                                    $gates = $obj_block->getBlockArrayValues('gates');
                                                                                                                    $gate_types = [];
                                                                                                                    $amount = count($gates);
                                                                                                                    for ($i = 0; $i < $amount; $i = $i + 2) {
                                                                                                                        if ($gate_types[$gates[$i]]) {
                                                                                                                            $gate_types[$gates[$i]] += $gates[$i + 1];
                                                                                                                        } else {
                                                                                                                            $gate_types[$gates[$i]] = $gates[$i + 1];
                                                                                                                        }
                                                                                                                    }
                                                                                                                    ?>
                                                                                                                    <li>
                                                                                                                        <div>
                                                                                                                            Тип/кол-во ворот
                                                                                                                        </div>
                                                                                                                        <div>
                                                                                                                            <? if ($gate_types) { ?>
                                                                                                                                <? foreach ($gate_types as $key => $value) {
                                                                                                                                    $gate = new Post($key);
                                                                                                                                    $gate->getTable('l_gates_types');
                                                                                                                                ?>
                                                                                                                                    <div class="flex-box">
                                                                                                                                        <div><?= $value ?> шт </div>/<div class="box-wide"> <?= $gate->title() ?></div>
                                                                                                                                    </div>
                                                                                                                                <? } ?>
                                                                                                                            <? } else { ?>
                                                                                                                                -
                                                                                                                            <? } ?>
                                                                                                                        </div>
                                                                                                                    </li>
                                                                                                                    <li>
                                                                                                                        <div>
                                                                                                                            Температурный режим
                                                                                                                        </div>
                                                                                                                        <div>
                                                                                                                            <? if ($temp_min = $obj_block->getBlockPartsMinValue('temperature_min')) { ?>
                                                                                                                                <?= ($temp_min > 0) ? '+' : '' ?>
                                                                                                                                <?= $temp_min ?>
                                                                                                                            <? } ?>
                                                                                                                            <? if ($temp_max = $obj_block->getBlockPartsMaxValue('temperature_max')) { ?>
                                                                                                                                /
                                                                                                                                <?= ($temp_max > 0) ? '+' : '' ?>
                                                                                                                                <?= $temp_max ?>
                                                                                                                            <? } ?>
                                                                                                                            <? //= valuesCompare($offer->getOfferBlocksMinValue('temperature_min'), $offer->getOfferBlocksMaxValue('temperature_max'))
                                                                                                                            ?> <span>градусов</span>
                                                                                                                        </div>
                                                                                                                    </li>
                                                                                                                    <li>
                                                                                                                        <div>
                                                                                                                            Вход в блок
                                                                                                                        </div>
                                                                                                                        <div>
                                                                                                                            <? if ($item = $obj_block->getField('enterance_block')) { ?>
                                                                                                                                <?= getPostTitle($item, 'l_enterances') ?>
                                                                                                                            <? } else { ?>
                                                                                                                                -
                                                                                                                            <? } ?>
                                                                                                                        </div>
                                                                                                                    </li>
                                                                                                                <? } ?>
                                                                                                                <li>
                                                                                                                    <div>
                                                                                                                        &#160;
                                                                                                                    </div>
                                                                                                                    <div>
                                                                                                                        &#160;
                                                                                                                    </div>
                                                                                                                </li>
                                                                                                                <? if (!$obj_block->isLand()) { ?>
                                                                                                                    <li>
                                                                                                                        <div class="isBold">
                                                                                                                            Оборудование
                                                                                                                        </div>
                                                                                                                        <div>
                                                                                                                            &#160;
                                                                                                                        </div>
                                                                                                                    </li>
                                                                                                                    <li>
                                                                                                                        <div>
                                                                                                                            Стеллажи
                                                                                                                        </div>
                                                                                                                        <div>
                                                                                                                            <? $racks = $obj_block->getBlockPartsMaxSumValue('racks') ?>
                                                                                                                            <?= ($racks) ? 'есть' : '-' ?> <?= ($racks && (($racks / count($obj_block->getBlockPartsId())) < 1)) ? ', частично' : '' ?>
                                                                                                                        </div>
                                                                                                                    </li>
                                                                                                                    <li>
                                                                                                                        <div>
                                                                                                                            Типы стеллажей
                                                                                                                        </div>
                                                                                                                        <div>
                                                                                                                            <? $racks_types = $obj_block->getJsonField('rack_types') ?>
                                                                                                                            <? if ($racks_types) { ?>
                                                                                                                                <? foreach ($racks_types  as $type) { ?>
                                                                                                                                    <? $rack = new Post($type) ?>
                                                                                                                                    <? $rack->getTable('l_racks_types') ?>
                                                                                                                                    <?= $rack->title() ?>
                                                                                                                                <? } ?>
                                                                                                                            <? } else { ?>
                                                                                                                                -
                                                                                                                            <? } ?>
                                                                                                                        </div>
                                                                                                                    </li>
                                                                                                                    <li>
                                                                                                                        <div>
                                                                                                                            Типы хранения
                                                                                                                        </div>
                                                                                                                        <div>
                                                                                                                            <? if ($safe_types = $obj_block->getJsonField('safe_type')) { ?>
                                                                                                                                <? foreach ($safe_types as $type) { ?>
                                                                                                                                    <? $safe_type = new Post($type) ?>
                                                                                                                                    <? $safe_type->getTable('l_safe_types') ?>
                                                                                                                                    <?= $safe_type->title() ?>
                                                                                                                                <? } ?>
                                                                                                                            <? } else { ?>
                                                                                                                                -
                                                                                                                            <? } ?>
                                                                                                                        </div>
                                                                                                                    </li>
                                                                                                                    <li>
                                                                                                                        <div>
                                                                                                                            Зарядная комната
                                                                                                                        </div>
                                                                                                                        <div>
                                                                                                                            <? $charging_room = $obj_block->getField('charging_room') ?>
                                                                                                                            <?= ($charging_room) ? 'есть' : '-' ?>
                                                                                                                        </div>
                                                                                                                    </li>
                                                                                                                    <li>
                                                                                                                        <div>
                                                                                                                            Складская техника
                                                                                                                        </div>
                                                                                                                        <div>
                                                                                                                            <? $warehouse_equipment = $obj_block->getField('warehouse_equipment') ?>
                                                                                                                            <?= ($warehouse_equipment) ? 'есть' : '-' ?> <?= ($warehouse_equipment && (($warehouse_equipment / count($obj_block->getBlockPartsId())) < 1)) ? ', частично' : '' ?>
                                                                                                                        </div>
                                                                                                                    </li>
                                                                                                                    <li>
                                                                                                                        <div>
                                                                                                                            Ячейки
                                                                                                                        </div>
                                                                                                                        <div>
                                                                                                                            <? $cells = $obj_block->getField('cells') ?>
                                                                                                                            <?= ($cells) ? 'есть' : '-' ?> <?= ($cells && (($cells / count($obj_block->getBlockPartsId())) < 1)) ? ', частично' : '' ?>
                                                                                                                        </div>
                                                                                                                    </li>
                                                                                                                <? } ?>
                                                                                                                <li>
                                                                                                                    <div>
                                                                                                                        &#160;
                                                                                                                    </div>
                                                                                                                    <div>
                                                                                                                        &#160;
                                                                                                                    </div>
                                                                                                                </li>
                                                                                                                <li>
                                                                                                                    <div class="isBold">
                                                                                                                        Коммуникации
                                                                                                                    </div>
                                                                                                                    <div>
                                                                                                                        &#160;
                                                                                                                    </div>
                                                                                                                </li>
                                                                                                                <li>
                                                                                                                    <div>
                                                                                                                        Мощность
                                                                                                                    </div>
                                                                                                                    <div>
                                                                                                                        <? if ($power_offer = $obj_block->getField('power')) { ?>
                                                                                                                            <?= $power_offer ?> кВт
                                                                                                                        <? } else { ?>
                                                                                                                            -
                                                                                                                        <? } ?>
                                                                                                                    </div>
                                                                                                                </li>
                                                                                                                <? if (!$obj_block->isLand()) { ?>
                                                                                                                    <li>
                                                                                                                        <div>
                                                                                                                            Освещение
                                                                                                                        </div>
                                                                                                                        <div>
                                                                                                                            <? $grids = $obj_block->getJsonField('lighting'); ?>
                                                                                                                            <? if (count($grids)) { ?>
                                                                                                                                <? foreach ($grids as $grid) {
                                                                                                                                    $grid = new Post($grid);
                                                                                                                                    $grid->getTable('l_lighting');
                                                                                                                                ?>
                                                                                                                                    <?= $grid->title() ?> ,
                                                                                                                                <? } ?>
                                                                                                                            <? } else { ?>
                                                                                                                                -
                                                                                                                            <? } ?>
                                                                                                                        </div>
                                                                                                                    </li>
                                                                                                                <? } ?>
                                                                                                                <? if (!$obj_block->isLand()) { ?>
                                                                                                                    <li>
                                                                                                                        <div>
                                                                                                                            Отопление
                                                                                                                        </div>
                                                                                                                        <div>
                                                                                                                            <? if ($item = $obj_block->getField('heated')) { ?>
                                                                                                                                <? if ($item == 1) { ?>
                                                                                                                                    есть
                                                                                                                                <? } else { ?>
                                                                                                                                    нет
                                                                                                                                <? } ?>
                                                                                                                            <? } else { ?>
                                                                                                                                -
                                                                                                                            <? } ?>
                                                                                                                        </div>
                                                                                                                    </li>
                                                                                                                <? } ?>
                                                                                                                <li>
                                                                                                                    <div>
                                                                                                                        Водоснабжение
                                                                                                                    </div>
                                                                                                                    <div>
                                                                                                                        <? if ($item = $obj_block->getField('water')) { ?>
                                                                                                                            <? if ($item == 1) { ?>
                                                                                                                                есть
                                                                                                                            <? } else { ?>
                                                                                                                                нет
                                                                                                                            <? } ?>
                                                                                                                        <? } else { ?>
                                                                                                                            -
                                                                                                                        <? } ?>
                                                                                                                    </div>
                                                                                                                </li>
                                                                                                                <li>
                                                                                                                    <div>
                                                                                                                        Канализация
                                                                                                                    </div>
                                                                                                                    <div>
                                                                                                                        <? if ($item = $obj_block->getField('sewage')) { ?>
                                                                                                                            <? if ($item == 1) { ?>
                                                                                                                                есть
                                                                                                                            <? } else { ?>
                                                                                                                                нет
                                                                                                                            <? } ?>
                                                                                                                        <? } else { ?>
                                                                                                                            -
                                                                                                                        <? } ?>
                                                                                                                    </div>
                                                                                                                </li>
                                                                                                                <? if (!$obj_block->isLand()) { ?>
                                                                                                                    <li>
                                                                                                                        <div>
                                                                                                                            Вентиляция
                                                                                                                        </div>
                                                                                                                        <div>
                                                                                                                            <? $grids = $obj_block->getJsonField('ventilation'); ?>
                                                                                                                            <? if (count($grids)) { ?>
                                                                                                                                <? foreach ($grids as $grid) {
                                                                                                                                    $grid = new Post($grid);
                                                                                                                                    $grid->getTable('l_ventilations');
                                                                                                                                ?>
                                                                                                                                    <?= $grid->title() ?> ,
                                                                                                                                <? } ?>
                                                                                                                            <? } else { ?>
                                                                                                                                -
                                                                                                                            <? } ?>
                                                                                                                        </div>
                                                                                                                    </li>
                                                                                                                    <li>
                                                                                                                        <div>
                                                                                                                            Климат контроль
                                                                                                                        </div>
                                                                                                                        <div>
                                                                                                                            <? if ($item = $obj_block->getField('climate_control')) { ?>
                                                                                                                                <? if ($item == 1) { ?>
                                                                                                                                    есть
                                                                                                                                <? } else { ?>
                                                                                                                                    нет
                                                                                                                                <? } ?>
                                                                                                                            <? } else { ?>
                                                                                                                                -
                                                                                                                            <? } ?>
                                                                                                                        </div>
                                                                                                                    </li>
                                                                                                                <? } ?>
                                                                                                                <li>
                                                                                                                    <div>
                                                                                                                        Газ для производства
                                                                                                                    </div>
                                                                                                                    <div>
                                                                                                                        <? if ($item = $obj_block->getField('gas')) { ?>
                                                                                                                            <? if ($item == 1) { ?>
                                                                                                                                есть
                                                                                                                            <? } else { ?>
                                                                                                                                нет
                                                                                                                            <? } ?>
                                                                                                                        <? } else { ?>
                                                                                                                            -
                                                                                                                        <? } ?>
                                                                                                                    </div>
                                                                                                                </li>
                                                                                                                <li>
                                                                                                                    <div>
                                                                                                                        Пар для производства
                                                                                                                    </div>
                                                                                                                    <div>
                                                                                                                        <? if ($item = $obj_block->getField('steam')) { ?>
                                                                                                                            <? if ($item == 1) { ?>
                                                                                                                                есть
                                                                                                                            <? } else { ?>
                                                                                                                                нет
                                                                                                                            <? } ?>
                                                                                                                        <? } else { ?>
                                                                                                                            -
                                                                                                                        <? } ?>
                                                                                                                    </div>
                                                                                                                </li>
                                                                                                                <li>
                                                                                                                    <div>
                                                                                                                        Интернет
                                                                                                                    </div>
                                                                                                                    <div>
                                                                                                                        <? if ($item = $obj_block->getField('internet')) { ?>
                                                                                                                            <? if ($item == 1) { ?>
                                                                                                                                есть
                                                                                                                            <? } else { ?>
                                                                                                                                нет
                                                                                                                            <? } ?>
                                                                                                                        <? } else { ?>
                                                                                                                            -
                                                                                                                        <? } ?>
                                                                                                                    </div>
                                                                                                                </li>
                                                                                                                <li>
                                                                                                                    <div>
                                                                                                                        Телефония
                                                                                                                    </div>
                                                                                                                    <div>
                                                                                                                        <? if ($item = $obj_block->getField('phone_line')) { ?>
                                                                                                                            <? if ($item == 1) { ?>
                                                                                                                                есть
                                                                                                                            <? } else { ?>
                                                                                                                                нет
                                                                                                                            <? } ?>
                                                                                                                        <? } else { ?>
                                                                                                                            -
                                                                                                                        <? } ?>
                                                                                                                    </div>
                                                                                                                </li>
                                                                                                                <li>
                                                                                                                    <div>
                                                                                                                        &#160;
                                                                                                                    </div>
                                                                                                                    <div>
                                                                                                                        &#160;
                                                                                                                    </div>
                                                                                                                </li>


                                                                                                                <li>
                                                                                                                    <div>
                                                                                                                        &#160;
                                                                                                                    </div>
                                                                                                                    <div>
                                                                                                                        &#160;
                                                                                                                    </div>
                                                                                                                </li>
                                                                                                                <li>
                                                                                                                    <div class="isBold">
                                                                                                                        Системы безопасности
                                                                                                                    </div>
                                                                                                                    <div>
                                                                                                                        &#160;
                                                                                                                    </div>
                                                                                                                </li>
                                                                                                                <? if (!$obj_block->isLand()) { ?>
                                                                                                                    <li>
                                                                                                                        <div>
                                                                                                                            Кросс-докинг
                                                                                                                        </div>
                                                                                                                        <div>
                                                                                                                            <? $cross = $obj_block->getField('cross_docking') ?>
                                                                                                                            <?= ($cross) ? 'есть' : '-' ?>
                                                                                                                        </div>
                                                                                                                    </li>
                                                                                                                <? } ?>
                                                                                                                <? if (!$obj_block->isLand()) { ?>
                                                                                                                    <li>
                                                                                                                        <div>
                                                                                                                            Пожаротушение
                                                                                                                        </div>
                                                                                                                        <div>
                                                                                                                            <? // include_once $_SERVER['DOCUMENT_ROOT'].'/errors.php'
                                                                                                                            ?>
                                                                                                                            <? $grids = $obj_block->getJsonField('firefighting_type'); ?>
                                                                                                                            <? if (count($grids)) { ?>
                                                                                                                                <? foreach ($grids as $grid) {
                                                                                                                                    $grid = new Post((int)2);
                                                                                                                                    $grid->getTable('l_firefighting');
                                                                                                                                ?>
                                                                                                                                    <?= $grid->title() ?> ,
                                                                                                                                <? } ?>
                                                                                                                            <? } else { ?>
                                                                                                                                -
                                                                                                                            <? } ?>
                                                                                                                        </div>
                                                                                                                    </li>
                                                                                                                    <li>
                                                                                                                        <div>
                                                                                                                            Дымоудаление
                                                                                                                        </div>
                                                                                                                        <div>
                                                                                                                            <? if ($item = $obj_block->getField('smoke_exhaust')) { ?>
                                                                                                                                <? if ($item == 1) { ?>
                                                                                                                                    есть
                                                                                                                                <? } else { ?>
                                                                                                                                    нет
                                                                                                                                <? } ?>
                                                                                                                            <? } else { ?>
                                                                                                                                -
                                                                                                                            <? } ?>
                                                                                                                        </div>
                                                                                                                    </li>
                                                                                                                <? } ?>
                                                                                                                <li>
                                                                                                                    <div>
                                                                                                                        Видеонаблюдение
                                                                                                                    </div>
                                                                                                                    <div>
                                                                                                                        <? if ($item = $obj_block->getField('video_control')) { ?>
                                                                                                                            <? if ($item == 1) { ?>
                                                                                                                                есть
                                                                                                                            <? } else { ?>
                                                                                                                                нет
                                                                                                                            <? } ?>
                                                                                                                        <? } else { ?>
                                                                                                                            -
                                                                                                                        <? } ?>
                                                                                                                    </div>
                                                                                                                </li>
                                                                                                                <li>
                                                                                                                    <div>
                                                                                                                        Контроль доступа
                                                                                                                    </div>
                                                                                                                    <div>
                                                                                                                        <? if ($item = $obj_block->getField('access_control')) { ?>
                                                                                                                            <? if ($item == 1) { ?>
                                                                                                                                есть
                                                                                                                            <? } else { ?>
                                                                                                                                нет
                                                                                                                            <? } ?>
                                                                                                                        <? } else { ?>
                                                                                                                            -
                                                                                                                        <? } ?>
                                                                                                                    </div>
                                                                                                                </li>
                                                                                                                <li>
                                                                                                                    <div>
                                                                                                                        Охранная сигнализация
                                                                                                                    </div>
                                                                                                                    <div>
                                                                                                                        <? if ($item = $obj_block->getField('security_alert')) { ?>
                                                                                                                            <? if ($item == 1) { ?>
                                                                                                                                есть
                                                                                                                            <? } else { ?>
                                                                                                                                нет
                                                                                                                            <? } ?>
                                                                                                                        <? } else { ?>
                                                                                                                            -
                                                                                                                        <? } ?>
                                                                                                                    </div>
                                                                                                                </li>
                                                                                                                <? if (!$obj_block->isLand()) { ?>
                                                                                                                    <li>
                                                                                                                        <div>
                                                                                                                            Пожарная сигнализация
                                                                                                                        </div>
                                                                                                                        <div>
                                                                                                                            <? if ($item = $obj_block->getField('fire_alert')) { ?>
                                                                                                                                <? if ($item == 1) { ?>
                                                                                                                                    есть
                                                                                                                                <? } else { ?>
                                                                                                                                    нет
                                                                                                                                <? } ?>
                                                                                                                            <? } else { ?>
                                                                                                                                -
                                                                                                                            <? } ?>
                                                                                                                        </div>
                                                                                                                    </li>
                                                                                                                <? } ?>
                                                                                                                <? if ($obj_block->isLand()) { ?>
                                                                                                                    <li>
                                                                                                                        <div>
                                                                                                                            Забор по периметру
                                                                                                                        </div>
                                                                                                                        <div>
                                                                                                                            <? if ($item = $obj_block->getField('fence')) { ?>
                                                                                                                                <? if ($item == 1) { ?>
                                                                                                                                    есть
                                                                                                                                <? } else { ?>
                                                                                                                                    нет
                                                                                                                                <? } ?>
                                                                                                                            <? } else { ?>
                                                                                                                                -
                                                                                                                            <? } ?>
                                                                                                                        </div>
                                                                                                                    </li>
                                                                                                                <? } ?>
                                                                                                                <? if ($obj_block->isLand()) { ?>
                                                                                                                    <li>
                                                                                                                        <div>
                                                                                                                            Шлагбаум
                                                                                                                        </div>
                                                                                                                        <div>
                                                                                                                            <? if ($item = $obj_block->getField('barrier')) { ?>
                                                                                                                                <? if ($item == 1) { ?>
                                                                                                                                    есть
                                                                                                                                <? } else { ?>
                                                                                                                                    нет
                                                                                                                                <? } ?>
                                                                                                                            <? } else { ?>
                                                                                                                                -
                                                                                                                            <? } ?>
                                                                                                                        </div>
                                                                                                                    </li>
                                                                                                                <? } ?>

                                                                                                                <li>
                                                                                                                    <div>
                                                                                                                        &#160;
                                                                                                                    </div>
                                                                                                                    <div>
                                                                                                                        &#160;
                                                                                                                    </div>
                                                                                                                </li>
                                                                                                                <li>
                                                                                                                    <div class="isBold">
                                                                                                                        Подъемные устройства
                                                                                                                    </div>
                                                                                                                    <div>
                                                                                                                        &#160;
                                                                                                                    </div>
                                                                                                                </li>
                                                                                                                <li>
                                                                                                                    <?
                                                                                                                    $elevators = $obj_block->getJsonField('elevators');
                                                                                                                    $amount = count($elevators);

                                                                                                                    $elevators_types = [];
                                                                                                                    $elevators_amount = [];

                                                                                                                    for ($i = 0; $i < $amount; $i = $i + 2) {
                                                                                                                        if (!in_array($elevators[$i + 1], $elevators_types) && $elevators[$i + 1] != 0) {
                                                                                                                            $elevators_types[] = $elevators[$i + 1];
                                                                                                                        }
                                                                                                                        $elevators_amount[] =  $elevators[$i];
                                                                                                                    }

                                                                                                                    ?>
                                                                                                                    <div>
                                                                                                                        Лифты/подъемники
                                                                                                                    </div>
                                                                                                                    <div>
                                                                                                                        <? if (count($elevators)) { ?>
                                                                                                                            <span class="ghost"><?= array_sum($elevators_amount) ?> шт.,</span> <?= valuesCompare(min($elevators_types), max($elevators_types)) ?> т
                                                                                                                        <? } else { ?>
                                                                                                                            -
                                                                                                                        <? } ?>
                                                                                                                    </div>
                                                                                                                </li>
                                                                                                                <li>
                                                                                                                    <?
                                                                                                                    $elevators = $obj_block->getJsonField('cranes_cathead');
                                                                                                                    $amount = count($elevators);

                                                                                                                    $elevators_types = [];
                                                                                                                    $elevators_amount = [];

                                                                                                                    for ($i = 0; $i < $amount; $i = $i + 2) {
                                                                                                                        if (!in_array($elevators[$i + 1], $elevators_types) && $elevators[$i + 1] != 0) {
                                                                                                                            $elevators_types[] = $elevators[$i + 1];
                                                                                                                        }
                                                                                                                        $elevators_amount[] =  $elevators[$i];
                                                                                                                    }

                                                                                                                    ?>
                                                                                                                    <div>
                                                                                                                        Кран-балки
                                                                                                                    </div>
                                                                                                                    <div>
                                                                                                                        <? if (count($elevators)) { ?>
                                                                                                                            <span class="ghost"><?= array_sum($elevators_amount) ?> шт.,</span> <?= valuesCompare(min($elevators_types), max($elevators_types)) ?> т
                                                                                                                        <? } else { ?>
                                                                                                                            -
                                                                                                                        <? } ?>
                                                                                                                    </div>
                                                                                                                </li>
                                                                                                                <li>
                                                                                                                    <?
                                                                                                                    $elevators = $obj_block->getJsonField('cranes_overhead');
                                                                                                                    $amount = count($elevators);

                                                                                                                    $elevators_types = [];
                                                                                                                    $elevators_amount = [];

                                                                                                                    for ($i = 0; $i < $amount; $i = $i + 2) {
                                                                                                                        if (!in_array($elevators[$i + 1], $elevators_types) && $elevators[$i + 1] != 0) {
                                                                                                                            $elevators_types[] = $elevators[$i + 1];
                                                                                                                        }
                                                                                                                        $elevators_amount[] =  $elevators[$i];
                                                                                                                    }

                                                                                                                    ?>
                                                                                                                    <div>
                                                                                                                        Мостовые краны
                                                                                                                    </div>
                                                                                                                    <div>
                                                                                                                        <? if (count($elevators)) { ?>
                                                                                                                            <span class="ghost"><?= array_sum($elevators_amount) ?> шт.,</span> <?= valuesCompare(min($elevators_types), max($elevators_types)) ?> т
                                                                                                                        <? } else { ?>
                                                                                                                            -
                                                                                                                        <? } ?>
                                                                                                                    </div>
                                                                                                                </li>
                                                                                                                <li>
                                                                                                                    <?
                                                                                                                    $elevators = $obj_block->getJsonField('telphers');
                                                                                                                    $amount = count($elevators);

                                                                                                                    $elevators_types = [];
                                                                                                                    $elevators_amount = [];

                                                                                                                    for ($i = 0; $i < $amount; $i = $i + 2) {
                                                                                                                        if (!in_array($elevators[$i + 1], $elevators_types) && $elevators[$i + 1] != 0) {
                                                                                                                            $elevators_types[] = $elevators[$i + 1];
                                                                                                                        }
                                                                                                                        $elevators_amount[] =  $elevators[$i];
                                                                                                                    }

                                                                                                                    ?>
                                                                                                                    <div>
                                                                                                                        Тельферы
                                                                                                                    </div>
                                                                                                                    <div>
                                                                                                                        <? if (count($elevators)) { ?>
                                                                                                                            <span class="ghost"><?= array_sum($elevators_amount) ?> шт.,</span> <?= valuesCompare(min($elevators_types), max($elevators_types)) ?> т
                                                                                                                        <? } else { ?>
                                                                                                                            -
                                                                                                                        <? } ?>
                                                                                                                    </div>
                                                                                                                </li>
                                                                                                                <li>
                                                                                                                    <div>
                                                                                                                        Подкрановые пути
                                                                                                                    </div>
                                                                                                                    <div>
                                                                                                                        <? $warehouse_equipment = $offer->getOfferBlocksMaxSumValue('cranes_runways') ?>
                                                                                                                        <?= ($warehouse_equipment) ? 'есть' : '-' ?> <?= ($warehouse_equipment && (($warehouse_equipment / $offer->subItemsActiveCount()) < 1)) ? ', частично' : '' ?>
                                                                                                                    </div>
                                                                                                                </li>
                                                                                                            </ul>
                                                                                                        </div>
                                                                                                        <div>
                                                                                                            <div>
                                                                                                                <div class="isBold box-wide">
                                                                                                                    Фото
                                                                                                                </div>
                                                                                                                <div>
                                                                                                                    <div class="flex-box flex-wrap">
                                                                                                                        <? $i = 1 ?>
                                                                                                                        <? foreach ($obj_block->getJsonField('photo_block') as $photo) { ?>
                                                                                                                            <? $photo = array_pop(explode('/', str_replace('//', '/', $photo))) ?>
                                                                                                                            <div class="box-small">
                                                                                                                                <div class="background-fix modal-call-btn" data-modal="photo-slider" data-modal-size="modal-big" data-id="<?= $photo ?>" data-table="" data-names='["post_id","table_id","photo_field","slide_num"]' data-values='[<?= $offer->postId() ?>,<?= $offer->setTableId() ?>,"photo_block",<?= $i ?>]' style="width: 140px; height: 70px; background: url('<?= PROJECT_URL . '/system/controllers/photos/thumb.php/300/' . $object->postId() . '/' . $photo ?>')">

                                                                                                                                </div>
                                                                                                                            </div>
                                                                                                                            <? $i++ ?>
                                                                                                                        <? } ?>
                                                                                                                    </div>
                                                                                                                </div>
                                                                                                            </div>
                                                                                                            <div class="box-small">
                                                                                                                <div class="isBold">
                                                                                                                    Описание
                                                                                                                </div>
                                                                                                                <div>
                                                                                                                    <?= $obj_block->getField('description') ?? $obj_block->getField('description_auto') ?>
                                                                                                                </div>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="tab-content" style="background: white;">
                                                                                                    <div class="card-blocks-area text_left  tabs-block box-vertical " style="max-width: 1600px;">
                                                                                                        <div class="flex-box flex-vertical-top">
                                                                                                            <div class="card-blocks-base " style=" width: 250px">
                                                                                                                <div class="box" style="background: #e1e1e1">
                                                                                                                    <b>Этаж</b>
                                                                                                                </div>
                                                                                                                <div style="border: 1px solid #ffffff">
                                                                                                                    <div class="obj-block-stats" style="border-bottom: 1px solid #cfcfcf;">
                                                                                                                        <ul>
                                                                                                                            <li><b>Площади</b></li>
                                                                                                                            <li>S - пола <span> *</span></li>
                                                                                                                            <li>S - офиснов</li>
                                                                                                                            <li>S - техническая</li>
                                                                                                                            <li>Кол-во палет-мест</li>
                                                                                                                        </ul>
                                                                                                                        <ul>
                                                                                                                            <li><b>Назначения</b></li>
                                                                                                                            <li>---</li>
                                                                                                                        </ul>
                                                                                                                        <ul>
                                                                                                                            <li><b>Характеристики</b></li>
                                                                                                                            <li class="block-info-floor-types">Тип пола: <span> *</span></li>
                                                                                                                            <? if (!$obj_block->isLand()) { ?>
                                                                                                                                <li>Высота рабочая<span> *</span></li>

                                                                                                                                <li>Нагрузка на пол:</li>
                                                                                                                                <li class="block-info-grid-types">Сетка колонн</li>
                                                                                                                                <li class="block-info-gates">Тип/кол-во ворот<span> *</span></li>
                                                                                                                                <li>Вход в блок</li>
                                                                                                                                <li>Темперетурный режим</li>
                                                                                                                            <? } ?>




                                                                                                                            <li>Габариты участка</li>
                                                                                                                            <li>Рельеф участка</li>
                                                                                                                        </ul>
                                                                                                                        <? if (!$obj_block->isLand()) { ?>
                                                                                                                            <ul>
                                                                                                                                <li><b>Оборудование</b></li>
                                                                                                                                <li>Стеллажи</li>
                                                                                                                                <li class="block-info-racks">Тип стеллажей</li>
                                                                                                                                <li class="block-info-safe-types">Тип хранения</li>
                                                                                                                                <li>Ячейки</li>
                                                                                                                                <li>Зарядная комната </li>
                                                                                                                                <li>Складская техника </li>
                                                                                                                            </ul>
                                                                                                                        <? } ?>
                                                                                                                        <ul>
                                                                                                                            <li><b>Коммуникации</b></li>
                                                                                                                            <li>Доступная мощность</li>

                                                                                                                            <? if (!$obj_block->isLand()) { ?>
                                                                                                                                <li>Освещение</li>
                                                                                                                                <li>Отопление</li>
                                                                                                                                <li>Вид отопления</li>
                                                                                                                            <? } ?>

                                                                                                                            <li>Водоснабжение</li>
                                                                                                                            <li>Канализация</li>
                                                                                                                            <? if (!$obj_block->isLand()) { ?>
                                                                                                                                <li>Вентиляция</li>
                                                                                                                                <li>Климат-контроль</li>
                                                                                                                            <? } ?>
                                                                                                                            <li>Газа для производства</li>
                                                                                                                            <li>Пар для производства</li>
                                                                                                                            <li>Интернет</li>
                                                                                                                            <li>Телефония</li>
                                                                                                                        </ul>
                                                                                                                        <ul>
                                                                                                                            <li><b>Подъемные устройства</b></li>
                                                                                                                            <li class="block-info-elevators">Лифты/подъемники</li>
                                                                                                                            <li class="block-info-cranes_cathead">Кран-балки</li>
                                                                                                                            <li class="block-info-cranes_overhead">Мостовые краны</li>
                                                                                                                            <li class="block-info-telphers">Тельферы</li>
                                                                                                                            <li>Подкрановые пути </li>

                                                                                                                        </ul>
                                                                                                                    </div>
                                                                                                                </div>
                                                                                                            </div>
                                                                                                            <div class="card-blocks-list flex-box flex-vertical-top">
                                                                                                                <? $parts = $obj_block->getJsonField('parts') ?>
                                                                                                                <?

                                                                                                                //инфо по включения/ исключениям
                                                                                                                $excluded_info = $obj_block->getJsonFieldArray('excluded_areas');


                                                                                                                $parts_line = implode(',', $parts);
                                                                                                                if (!$parts_line) {
                                                                                                                    $parts_line = 0;
                                                                                                                }
                                                                                                                $sql = $pdo->prepare("SELECT * FROM c_industry_parts p LEFT JOIN c_industry_floors f ON p.floor_id=f.id LEFT JOIN l_floor_nums n ON f.floor_num_id=n.id WHERE p.id IN($parts_line) ORDER BY n.order_row ");
                                                                                                                $sql->execute();
                                                                                                                while ($part = $sql->fetch(PDO::FETCH_LAZY)) { ?>
                                                                                                                    <? $part = new Part($part->id) ?>

                                                                                                                    <div class="flex-box flex-vertical-top tab stack-block <?= ($obj_block->getField('status') == 2) ? 'ghost' : '' ?>">
                                                                                                                        <div id="subitem-<?= $obj_block->postId() ?>" class="object-block " style="width: 200px ;">
                                                                                                                            <div class="box " style="background: <?= $part->getFloorColor() ?>; color: #FFFFFF;">
                                                                                                                                <?= $part->getFloorName() ?>
                                                                                                                            </div>
                                                                                                                            <div class="block_stats" style="border: 1px solid #79a768">
                                                                                                                                <div class="wer obj-block-stats" style="border-bottom: 1px solid #cfcfcf; position: relative;">
                                                                                                                                    <ul>
                                                                                                                                        <li>
                                                                                                                                            &#160;
                                                                                                                                        </li>
                                                                                                                                        <li>
                                                                                                                                            <? if (in_array($part->getFloorNumId(), [16])) {
                                                                                                                                                $area_min = $part->getField('area_field_min');
                                                                                                                                                $area_max = $part->getField('area_field_max');
                                                                                                                                            } elseif (in_array($part->getFloorNumId(), [2, 3, 4, 5])) {
                                                                                                                                                $area_min = $part->getField('area_mezzanine_min');
                                                                                                                                                $area_max = $part->getField('area_mezzanine_max');
                                                                                                                                            } else {
                                                                                                                                                $area_min = $part->getField('area_floor_min');
                                                                                                                                                $area_max = $part->getField('area_floor_max');
                                                                                                                                            } ?>
                                                                                                                                            <b>
                                                                                                                                                <?= valuesCompare($area_min, $area_max) ?> <span>м<sup>2</sup></span>
                                                                                                                                            </b>
                                                                                                                                            <? if ($part->getField('area_tech_min') && $obj_block->getField('is_solid') && in_array($part->getFloorNumId(), [2, 3, 4, 5]) && isset($excluded_info[$part->getField('id')]['mezz'])) { ?>
                                                                                                                                                <span class="ghost"><?= $excluded_info[$part->getField('id')]['mezz']  ? 'не вмен.' : '<span class="attention">вмен.</span>' ?> </span>
                                                                                                                                            <? } ?>
                                                                                                                                        </li>

                                                                                                                                        <li>
                                                                                                                                            <? if ($part->getField('area_office_min')) { ?>
                                                                                                                                                <?= valuesCompare($part->getField('area_office_min'), $part->getField('area_office_max')) ?> <span>м<sup>2</sup>
                                                                                                                                                <? } else { ?>
                                                                                                                                                    -
                                                                                                                                                <? } ?>
                                                                                                                                                <? if ($part->getField('area_office_min') && $obj_block->getField('is_solid') && isset($excluded_info[$part->getField('id')]['office'])) { ?>
                                                                                                                                                    <span class="ghost"><?= $excluded_info[$part->getField('id')]['office']  ? 'не вмен.' : '<span class="attention">вмен.</span>' ?> </span>
                                                                                                                                                <? } ?>
                                                                                                                                        </li>
                                                                                                                                        <li>
                                                                                                                                            <? if ($part->getField('area_tech_min')) { ?>
                                                                                                                                                <?= valuesCompare($part->getField('area_tech_min'), $part->getField('area_tech_max')) ?> <span>м<sup>2</sup> <?= ($obj_block->getField('area_office_add')) ? '<span style="color: red;">вмен.</span>' : '' ?></span>
                                                                                                                                            <? } else { ?>
                                                                                                                                                -
                                                                                                                                            <? } ?>
                                                                                                                                            <? if ($part->getField('area_tech_min') && $obj_block->getField('is_solid') && isset($excluded_info[$part->getField('id')]['tech'])) { ?>
                                                                                                                                                <span class="ghost"><?= $excluded_info[$part->getField('id')]['tech']  ? 'не вмен.' : '<span class="attention">вмен.</span>' ?> </span>
                                                                                                                                            <? } ?>
                                                                                                                                        </li>
                                                                                                                                        <li>
                                                                                                                                            <? if ($part->getField('pallet_place_min')) { ?>
                                                                                                                                                <?= valuesCompare($part->getField('pallet_place_min'), $part->getField('pallet_place_max')) ?> п.м.
                                                                                                                                            <? } else { ?>
                                                                                                                                                -
                                                                                                                                            <? } ?>
                                                                                                                                        </li>
                                                                                                                                    </ul>
                                                                                                                                    <ul>
                                                                                                                                        <li style="height: 47px;">
                                                                                                                                            <div>
                                                                                                                                                <? if (arrayIsNotEmpty($part->getJsonField('purposes_block'))) { ?>
                                                                                                                                                    <? foreach ($part->getJsonField('purposes_block') as $purpose) { ?>
                                                                                                                                                        <?
                                                                                                                                                        $purpose = new Post((int)$purpose);
                                                                                                                                                        $purpose->getTable('l_purposes');
                                                                                                                                                        ?>
                                                                                                                                                        <div class="icon-square">
                                                                                                                                                            <a href="#" title="<?= $purpose->title() ?>"><?= $purpose->getField('icon') ?></a>
                                                                                                                                                        </div>
                                                                                                                                                    <? } ?>
                                                                                                                                                <? } ?>
                                                                                                                                            </div>
                                                                                                                                        </li>
                                                                                                                                    </ul>
                                                                                                                                    <ul>
                                                                                                                                        <li>&#160;</li>
                                                                                                                                        <li class="block-info-floor-types">
                                                                                                                                            <? if ($part->getField('floor_types')) {
                                                                                                                                                $floor_type = 'floor_types';
                                                                                                                                                $floor_type_table = 'l_floor_types';
                                                                                                                                            } elseif ($part->getField('floor_types_land')) {
                                                                                                                                                $floor_type = 'floor_types_land';
                                                                                                                                                $floor_type_table = 'l_floor_types_land';
                                                                                                                                            } else {
                                                                                                                                                $floor_type = 0;
                                                                                                                                                $floor_type_table = '';
                                                                                                                                            } ?>
                                                                                                                                            <? if ($floor_type) { ?>
                                                                                                                                                <? foreach ($part->getJsonField($floor_type) as $type) { ?>
                                                                                                                                                    <? $rack = new Post($type) ?>
                                                                                                                                                    <? $rack->getTable($floor_type_table) ?>
                                                                                                                                                    <div>
                                                                                                                                                        <?= $rack->title() ?>
                                                                                                                                                    </div>
                                                                                                                                                <? } ?>
                                                                                                                                            <? } else { ?>
                                                                                                                                                -
                                                                                                                                            <? } ?>
                                                                                                                                        </li>
                                                                                                                                        <? if (!$obj_block->isLand()) { ?>
                                                                                                                                            <li>
                                                                                                                                                <? if ($part->getField('ceiling_height_min')) { ?>
                                                                                                                                                    <?= valuesCompare($part->getField('ceiling_height_min'), $part->getField('ceiling_height_max')) ?> м
                                                                                                                                                <? } else { ?>
                                                                                                                                                    -
                                                                                                                                                <? } ?>
                                                                                                                                            </li>

                                                                                                                                            <li>
                                                                                                                                                <? if (in_array($part->getFloorNumId(), [2, 3, 4, 5])) {
                                                                                                                                                    $load = valuesCompare($part->getField('load_mezzanine_min'), $part->getField('load_mezzanine_max'));
                                                                                                                                                } else {
                                                                                                                                                    $load = valuesCompare($part->getField('load_floor_min'), $part->getField('load_floor_max'));
                                                                                                                                                } ?>
                                                                                                                                                <? if ($load) { ?>
                                                                                                                                                    <?= $load ?> <span class="degree-fix">т/м<sup>2</sup></span>
                                                                                                                                                <? } else { ?>
                                                                                                                                                    -
                                                                                                                                                <? } ?>
                                                                                                                                            </li>
                                                                                                                                            <li class="block-info-grid-types">
                                                                                                                                                <? if (arrayIsNotEmpty($part->getJsonField('column_grids'))) { ?>
                                                                                                                                                    <? foreach ($part->getJsonField('column_grids') as $type) { ?>
                                                                                                                                                        <? $rack = new Post($type) ?>
                                                                                                                                                        <? $rack->getTable('l_pillars_grid') ?>
                                                                                                                                                        <div>
                                                                                                                                                            <?= $rack->title() ?>
                                                                                                                                                        </div>
                                                                                                                                                    <? } ?>
                                                                                                                                                <? } else { ?>
                                                                                                                                                    -
                                                                                                                                                <? } ?>
                                                                                                                                            </li>
                                                                                                                                            <?
                                                                                                                                            $gates = $part->getJsonField('gates');
                                                                                                                                            $gate_types = [];
                                                                                                                                            $amount = count($gates);
                                                                                                                                            for ($i = 0; $i < $amount; $i = $i + 2) {
                                                                                                                                                if ($gate_types[$gates[$i]]) {
                                                                                                                                                    $gate_types[$gates[$i]] += $gates[$i + 1];
                                                                                                                                                } else {
                                                                                                                                                    $gate_types[$gates[$i]] = $gates[$i + 1];
                                                                                                                                                }
                                                                                                                                            }
                                                                                                                                            ?>
                                                                                                                                            <li class="block-info-gates">
                                                                                                                                                <? if ($gates && $gate_types) { ?>
                                                                                                                                                    <? foreach ($gate_types as $key => $value) { ?>
                                                                                                                                                        <?
                                                                                                                                                        $gate = new Post($key);
                                                                                                                                                        $gate->getTable('l_gates_types');
                                                                                                                                                        ?>
                                                                                                                                                        <div class="flex-box">
                                                                                                                                                            <div class="ghost"><?= $value ?> шт /</div>
                                                                                                                                                            <div><?= $gate->title() ?></div>
                                                                                                                                                        </div>
                                                                                                                                                    <? } ?>
                                                                                                                                                <? } else { ?>
                                                                                                                                                    -
                                                                                                                                                <? } ?>
                                                                                                                                            </li>
                                                                                                                                            <li>
                                                                                                                                                <? if ($part->getField('enterance_block')) { ?>
                                                                                                                                                    <?
                                                                                                                                                    $enterance_block = new Post($part->getField('enterance_block'));
                                                                                                                                                    $enterance_block->getTable('l_enterances');
                                                                                                                                                    ?>
                                                                                                                                                    <?= $enterance_block->title() ?>
                                                                                                                                                <? } else { ?>
                                                                                                                                                    -
                                                                                                                                                <? } ?>
                                                                                                                                            </li>

                                                                                                                                            <li>
                                                                                                                                                <? if ($part->getField('heated') == 1) { ?>
                                                                                                                                                    тёплый
                                                                                                                                                <? } else { ?>
                                                                                                                                                    -
                                                                                                                                                <? } ?>
                                                                                                                                                <? if ($temp_min = $part->getField('temperature_min')) { ?>
                                                                                                                                                    <?= ($temp_min > 0) ? '+' : '' ?>
                                                                                                                                                    <?= $temp_min ?>
                                                                                                                                                    &#176;С
                                                                                                                                                <? } ?>

                                                                                                                                                <? if ($temp_max = $part->getField('temperature_max')) { ?>
                                                                                                                                                    /
                                                                                                                                                    <?= ($temp_max > 0) ? '+' : '' ?>
                                                                                                                                                    <?= $temp_max ?>
                                                                                                                                                    &#176;С
                                                                                                                                                <? } ?>
                                                                                                                                            </li>
                                                                                                                                        <? } ?>
                                                                                                                                        <li>
                                                                                                                                            <? if ($part->getField('land_length') && $part->getField('land_width')) { ?>
                                                                                                                                                <?= $part->getField('land_length') ?><i class="fal fa-times"></i><?= $part->getField('land_width') ?> м.
                                                                                                                                            <? } else { ?>
                                                                                                                                                -
                                                                                                                                            <? } ?>
                                                                                                                                        </li>
                                                                                                                                        <li>
                                                                                                                                            <?= ($part->getField('landscape_type')) ? $part->landscapeType() :  '-' ?>
                                                                                                                                        </li>
                                                                                                                                    </ul>
                                                                                                                                    <? if (!$obj_block->isLand()) { ?>
                                                                                                                                        <ul>
                                                                                                                                            <li>&#160;</li>
                                                                                                                                            <li><?= ($part->getField('racks') == 1) ? 'есть' : '-' ?></li>
                                                                                                                                            <li class="block-info-racks">
                                                                                                                                                <? if ($part->getField('rack_types')) { ?>
                                                                                                                                                    <? foreach ($part->getJsonField('rack_types') as $type) { ?>
                                                                                                                                                        <? $rack = new Post($type) ?>
                                                                                                                                                        <? $rack->getTable('l_racks_types') ?>
                                                                                                                                                        <div>
                                                                                                                                                            <?= $rack->title() ?>
                                                                                                                                                        </div>
                                                                                                                                                    <? } ?>
                                                                                                                                                <? } else { ?>
                                                                                                                                                    -
                                                                                                                                                <? } ?>
                                                                                                                                            </li>
                                                                                                                                            <li class="block-info-safe-types">
                                                                                                                                                <? if ($part->getField('safe_type')) { ?>
                                                                                                                                                    <? foreach ($part->getJsonField('safe_type') as $type) { ?>
                                                                                                                                                        <? $safe_type = new Post($type) ?>
                                                                                                                                                        <? $safe_type->getTable('l_safe_types') ?>
                                                                                                                                                        <div>
                                                                                                                                                            <?= $safe_type->title() ?>
                                                                                                                                                        </div>
                                                                                                                                                    <? } ?>
                                                                                                                                                <? } else { ?>
                                                                                                                                                    -
                                                                                                                                                <? } ?>
                                                                                                                                            </li>
                                                                                                                                            <li><?= ($part->getField('cells') == 1) ? 'есть' : '-' ?></li>
                                                                                                                                            <li><?= ($part->getField('charging_room') == 1) ? 'есть' : '-' ?></li>
                                                                                                                                            <li><?= ($part->getField('warehouse_equipment') == 1) ? 'есть' : '-' ?></li>
                                                                                                                                        </ul>
                                                                                                                                    <? } ?>
                                                                                                                                    <ul>
                                                                                                                                        <li>&#160;</li>
                                                                                                                                        <li>
                                                                                                                                            <? if ($power = $part->getField('power')) { ?>
                                                                                                                                                <?= $power ?> кВт
                                                                                                                                            <? } else { ?>
                                                                                                                                                -
                                                                                                                                            <? } ?>
                                                                                                                                        </li>
                                                                                                                                        <li><?= ($part->getField('water') == 1) ? 'есть' : '-' ?></li>
                                                                                                                                        <li><?= ($part->getField('sewage') == 1) ? 'есть' : '-' ?></li>
                                                                                                                                        <? if (!$obj_block->isLand()) { ?>
                                                                                                                                            <li><?= ($part->getField('ventilation')) ? 'есть' : '-' ?></li>
                                                                                                                                            <li><?= ($part->getField('climate_control')) ? 'есть' : '-' ?></li>
                                                                                                                                        <? } ?>
                                                                                                                                        <li><?= ($part->getField('gas') == 1) ? 'есть' : '-' ?></li>
                                                                                                                                        <li><?= ($part->getField('steam') == 1) ? 'есть' : '-' ?></li>
                                                                                                                                        <li><?= ($part->getField('internet') == 1) ? 'есть' : '-' ?></li>
                                                                                                                                        <li><?= ($part->getField('phone_line') == 1) ? 'есть' : '-' ?></li>
                                                                                                                                    </ul>
                                                                                                                                    <ul>
                                                                                                                                        <li>&#160;</li>
                                                                                                                                        <?
                                                                                                                                        $cranes = ['elevators', 'cranes_cathead', 'cranes_overhead', 'telphers'];

                                                                                                                                        foreach ($cranes as $crane) {
                                                                                                                                            $items = $part->getJsonField($crane);
                                                                                                                                            $types = [];
                                                                                                                                            $sorted_arr = [];

                                                                                                                                            for ($i = 0; $i < count($items); $i = $i + 2) {
                                                                                                                                                if (!in_array($items[$i + 1], $types) && $items[$i + 1] != 0) {
                                                                                                                                                    array_push($types, $items[$i + 1]);
                                                                                                                                                }
                                                                                                                                            }

                                                                                                                                            //var_dump($types);

                                                                                                                                            //подсчитываем колво каждого типа
                                                                                                                                            foreach ($types as $elem_unique) {
                                                                                                                                                for ($i = 0; $i < count($items); $i = $i + 2) {
                                                                                                                                                    if ($items[$i + 1] == $elem_unique) {
                                                                                                                                                        $sorted_arr[$elem_unique] += $items[$i];
                                                                                                                                                    }
                                                                                                                                                }
                                                                                                                                            }
                                                                                                                                        ?>

                                                                                                                                            <li class="block-info-<?= $crane ?>">
                                                                                                                                                <? if ($sorted_arr) { ?>
                                                                                                                                                    <? foreach ($sorted_arr as $key => $value) { ?>
                                                                                                                                                        <div class="flex-box">
                                                                                                                                                            <div class="ghost"><?= $value ?> шт /</div>
                                                                                                                                                            <div><?= $key ?> т.</div>
                                                                                                                                                        </div>
                                                                                                                                                    <? } ?>
                                                                                                                                                <? } else { ?>
                                                                                                                                                    -
                                                                                                                                                <? } ?>
                                                                                                                                            </li>

                                                                                                                                        <? } ?>
                                                                                                                                        <li><?= ($part->getField('cranes_runways')) ? 'есть' : '-' ?></li>
                                                                                                                                    </ul>
                                                                                                                                </div>
                                                                                                                            </div>
                                                                                                                        </div>
                                                                                                                    </div>
                                                                                                                <? } ?>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="tab-content">
                                                                                                    <div class="box">
                                                                                                        <div class="flex-box box-small-vertical isBold">
                                                                                                            <div style="width: 100px;">
                                                                                                                #ID
                                                                                                            </div>
                                                                                                            <div style="width: 200px;">
                                                                                                                Площадь
                                                                                                            </div>
                                                                                                            <div style="width: 200px;">
                                                                                                                Локации
                                                                                                            </div>
                                                                                                            <div style="width: 200px;">
                                                                                                                Компания
                                                                                                            </div>
                                                                                                            <div style="width: 200px;">
                                                                                                                Консультант
                                                                                                            </div>
                                                                                                            <div style="width: 200px;">
                                                                                                                Дата поступления запроса
                                                                                                            </div>
                                                                                                        </div>
                                                                                                        <?
                                                                                                        $offerMix = new OfferMix();
                                                                                                        $offerMix->getRealId($obj_block->postId(), 1);
                                                                                                        ?>

                                                                                                        <? if ($offerMix->postId()) { ?>
                                                                                                            <?

                                                                                                            $requestsSql = $pdo->prepare("SELECT * FROM c_industry_requests 
                                                                                                                                                                          WHERE deal_type=" . $offerMix->getField('deal_type') . "   
                                                                                                                                                                          AND  (regions LIKE '%" . $offerMix->getField('region') . "%'  OR regions='[]')
                                                                                                                                                                          AND  (directions LIKE '%" . $offerMix->getField('direction') . "%' OR directions='[]')
                                                                                                                                                                          AND  (highways LIKE '%" . $offerMix->getField('highway') . "%'  OR highways='[]'  )
                                                                                                                                                                          AND  (object_classes LIKE '%" . $offerMix->getField('class') . "%' OR object_classes='[]')
                                                                                                                                                                          AND area_floor_min>" . $offerMix->getField('area_min') . "
                                                                                                                                                                          AND area_floor_max<" . $offerMix->getField('area_max') . "  
                                                                                                                                                                          AND ( ceiling_height_min<" . $offerMix->getField('ceiling_height_min') . " OR ceiling_height_min=0 OR ceiling_height_min IS NULL )
                                                                                                                                                                          AND ( ceiling_height_max>" . $offerMix->getField('ceiling_height_max') . " OR ceiling_height_max=0 OR ceiling_height_max IS NULL )
                                                                                                                                                                          AND (heated=" . $offerMix->getField('heated') . " OR heated IS NULL)     
                                                                                                                                                                          AND  deleted!=1 ORDER BY publ_time DESC LIMIT 20 ");


                                                                                                            $requestsSql->execute();
                                                                                                            while ($request = $requestsSql->fetch(PDO::FETCH_LAZY)) { ?>
                                                                                                                <div class="flex-box box-small-vertical">
                                                                                                                    <div style="width: 100px;">
                                                                                                                        <?= $request->id ?>
                                                                                                                    </div>
                                                                                                                    <div style="width: 200px;" class="isBold">
                                                                                                                        <?= valuesCompare($request->area_floor_min, $request->area_floor_max) ?>
                                                                                                                    </div>
                                                                                                                    <div style="width: 200px;">
                                                                                                                        <?
                                                                                                                        foreach (json_decode($request->regions) as $regionsId) {
                                                                                                                            echo getPostTitle($regionsId, 'l_regions') . ', ';
                                                                                                                        }
                                                                                                                        ?>
                                                                                                                    </div>
                                                                                                                    <div style="width: 200px; " class="isBold underlined">
                                                                                                                        <? $comp = new Company($request->company_id) ?>
                                                                                                                        <a href="/company/<?= $comp->postId() ?>/" target="_blank">
                                                                                                                            <?= $comp->title() ?>
                                                                                                                        </a>
                                                                                                                    </div>
                                                                                                                    <div style="width: 200px;">
                                                                                                                        <?= (new Member($request->agent_id))->getField('title') ?>
                                                                                                                    </div>
                                                                                                                    <div style="width: 200px;">
                                                                                                                        <?= date('d-m-Y', $request->publ_time) ?>
                                                                                                                    </div>
                                                                                                                </div>
                                                                                                            <? } ?>
                                                                                                        <? } ?>


                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="tab-content">
                                                                                                    <div class="box">
                                                                                                        Loadinnn.....
                                                                                                    </div>
                                                                                                </div>
                                                                                                <? if ($obj_block->hasDeal()) { ?>
                                                                                                    <div class="tab-content">
                                                                                                        <div class="box">
                                                                                                            Loadinnn.....
                                                                                                        </div>
                                                                                                    </div>
                                                                                                <? } ?>

                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            <? } ?>
                                                                        </div>
                                                                        <div class="tab-content full-width">
                                                                            <? foreach ($blocks_old as $obj_block) { ?>
                                                                                <? $obj_block = new Subitem($obj_block) ?>
                                                                                <div>
                                                                                    <? $table = $obj_block->setTableId() ?>
                                                                                    <? $id = $obj_block->postId() ?>
                                                                                    <? if ($_COOKIE['member_id'] = 141  || $_COOKIE['member_id'] == 150) { ?>
                                                                                        <? include($_SERVER['DOCUMENT_ROOT'] . '/templates/forms/panel-ad/index.php') ?>
                                                                                    <? } ?>
                                                                                </div>
                                                                                <div class="full-width box  ghost" style="background: rgb(245,245,245); margin-bottom: 20px; position: relative;">
                                                                                    <div style="position: absolute; top: 5px; right: 10px;">
                                                                                        <div class="flex-box">
                                                                                            <div class="box-wide isBold">
                                                                                                ID <?= $obj_block->getVisualId() ?>,
                                                                                            </div>
                                                                                            <div class="ghost" title="последнее обновление">
                                                                                                <i class="fas fa-undo-alt"></i> <?= date('d-m-Y в H:i', $obj_block->getField('last_update')) ?>
                                                                                            </div>

                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="ghost" title="создано" style="position: absolute; bottom: 5px; right: 5px;">
                                                                                        Создано <?= date('d-m-Y в H:i', $obj_block->getField('publ_time')) ?>
                                                                                    </div>
                                                                                    <div class="flex-box">
                                                                                        <div class="three_fourth flex-box" style="align-items: stretch;">
                                                                                            <div class="half box" style="border: 1px solid #76a665">
                                                                                                <div>

                                                                                                    <div>
                                                                                                        <? if ($obj_block->dealType() == 2) { ?>
                                                                                                            S-предложения
                                                                                                        <? } elseif ($obj_block->dealType() == 3) { ?>
                                                                                                            N - паллет мест
                                                                                                        <? } else { ?>
                                                                                                            S-предложения
                                                                                                        <? } ?>
                                                                                                    </div>
                                                                                                    <div class="isBold" style="font-size: 20px;">
                                                                                                        <? if ($obj_block->dealType() == 2) { ?>
                                                                                                            <?= valuesCompare($obj_block->getField('area_min'), $obj_block->getField('area_max')) ?>
                                                                                                            <span>м<sup>2</sup></span>
                                                                                                        <? } elseif ($obj_block->dealType() == 3) { ?>
                                                                                                            <?= valuesCompare($obj_block->getField('pallet_place_min'), $obj_block->getField('pallet_place_max')) ?>
                                                                                                            <span>п.м.</span>
                                                                                                        <? } else { ?>
                                                                                                            <?= valuesCompare($obj_block->getField('area_min'), $obj_block->getField('area_max')) ?>
                                                                                                            <span>м<sup>2</sup></span>
                                                                                                        <? } ?>

                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="box-vertical">
                                                                                                    <?

                                                                                                    $parts_line = implode(',', $obj_block->getJsonField('parts'));
                                                                                                    //$sql = $pdo->prepare("SELECT * FROM c_industry_parts WHERE id IN($parts_line)");
                                                                                                    if (!$parts_line) {
                                                                                                        $parts_line = 0;
                                                                                                    }
                                                                                                    $sql = $pdo->prepare("SELECT * FROM c_industry_parts p LEFT JOIN c_industry_floors f ON p.floor_id=f.id LEFT JOIN l_floor_nums n ON f.floor_num_id=n.id WHERE p.id IN($parts_line) ORDER BY n.order_row ");
                                                                                                    $sql->execute();


                                                                                                    $parts = [];
                                                                                                    $floors_unique = [];
                                                                                                    while ($part = $sql->fetch(PDO::FETCH_LAZY)) {
                                                                                                        $floor = $part->floor;
                                                                                                        if (isset($floors_unique[$floor])) {
                                                                                                            $arr = $floors_unique[$floor];
                                                                                                            $arr[] = $part->id;
                                                                                                            $floors_unique[$floor] = $arr;
                                                                                                        } else {
                                                                                                            $arr = [$part->id];
                                                                                                            $floors_unique[$floor] = $arr;
                                                                                                        }
                                                                                                    }
                                                                                                    //var_dump($floors_unique);

                                                                                                    $array_floor_new  = [];

                                                                                                    foreach ($floors_unique as $key => $value) {

                                                                                                        $test_part = new Part($value[0]);
                                                                                                        $floor_name = $test_part->getFloorName();

                                                                                                        $areas = [];
                                                                                                        foreach ($value as $part_id) {
                                                                                                            $part = new Part($part_id);

                                                                                                            if (in_array((string)$key, ['1f'])) {
                                                                                                                $areas['min'][] = $part->getField('area_field_min');
                                                                                                                $areas['max'][] = $part->getField('area_field_max');
                                                                                                            } elseif (in_array((string)$key, ['1m', '2m', '3m', '4m'])) {
                                                                                                                $areas['min'][] = $part->getField('area_mezzanine_min');
                                                                                                                $areas['max'][] = $part->getField('area_mezzanine_max');
                                                                                                            } else {
                                                                                                                $areas['min'][] = $part->getField('area_floor_min');
                                                                                                                $areas['max'][] = $part->getField('area_floor_max');
                                                                                                            }
                                                                                                        }
                                                                                                        $array_floor_new[$floor_name] = $areas;
                                                                                                    }

                                                                                                    if ($_COOKIE['member_id'] == 141) {
                                                                                                        //var_dump($array_floor_new);
                                                                                                    }

                                                                                                    //var_dump($array_floor_new);


                                                                                                    ?>
                                                                                                    <div class="flex-box isBold">
                                                                                                        <div>S-складская</div>
                                                                                                        <div class="to-end"><?= (valuesCompare($obj_block->getField('area_warehouse_min') ?  $obj_block->getField('area_warehouse_min') : $obj_block->getField('area_min'),  $obj_block->getField('area_warehouse_max') ?   $obj_block->getField('area_warehouse_max')  :  $obj_block->getField('area_max'))) ?> м<sup>2</sup></div>
                                                                                                    </div>
                                                                                                    <? foreach ($array_floor_new as $key => $value) { ?>
                                                                                                        <div class="flex-box">
                                                                                                            <div>S-<?= $key ?></div>
                                                                                                            <div class="to-end"><?= valuesCompare(numFormat(min($value['min'])), numFormat(array_sum($value['max']))) ?> м<sup>2</sup></div>
                                                                                                        </div>
                                                                                                    <? } ?>
                                                                                                    <? if ($obj_block->getField('area_office_min') || $obj_block->getField('area_office_max')) { ?>
                                                                                                        <div class="flex-box">
                                                                                                            <div>S-офисов</div>
                                                                                                            <div class="to-end">
                                                                                                                <?= valuesCompare($obj_block->getField('area_office_min'), $obj_block->getField('area_office_max')) ?> м<sup>2</sup>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    <? } ?>
                                                                                                    <? if ($obj_block->getField('area_tech_min') || $obj_block->getField('area_tech_max')) { ?>
                                                                                                        <div class="flex-box">
                                                                                                            <div>S-техническая</div>
                                                                                                            <div class="to-end">
                                                                                                                <?= valuesCompare($obj_block->getField('area_tech_min'), $obj_block->getField('area_tech_max')) ?> м<sup>2</sup>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    <? } ?>

                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="half box" style="border: 1px solid #76a665">
                                                                                                <div>

                                                                                                    <div>
                                                                                                        <? if ($obj_block->dealType() == 2) { ?>
                                                                                                            E - предложения
                                                                                                        <? } elseif ($obj_block->dealType() == 3) { ?>
                                                                                                            E - паллет мест
                                                                                                        <? } else { ?>
                                                                                                            E-предложения
                                                                                                        <? } ?>
                                                                                                    </div>
                                                                                                    <div class="isBold" style="font-size: 20px;">
                                                                                                        <? if ($obj_block->dealType() == 2) { ?>
                                                                                                            <?

                                                                                                            /* если все ок и к этому давно не возвращался - удалить нахуй
                                                                                                        $area_sum = 0;
                                                                                                        $area_pars = [
                                                                                                                'area_floor',
                                                                                                                'area_mezzanine',
                                                                                                                'area_office',
                                                                                                                'area_tech',
                                                                                                        ];
                                                                                                        foreach ($area_pars as $area){
                                                                                                            $area_sum += $obj_block->getField($area.'_max');
                                                                                                        }
                                                                                                        $area_min = $area_sum;
                                                                                                        foreach ($area_pars as $area){
                                                                                                            if($obj_block->getField($area.'_min') < $area_min ){
                                                                                                                $area_min = $obj_block->getField($area.'_min');
                                                                                                            }
                                                                                                        }
                                                                                                        */

                                                                                                            $area_min = $obj_block->getField('area_min');
                                                                                                            $area_max = $obj_block->getField('area_max');

                                                                                                            $price_min = numFormat($obj_block->getField('price_sale_min') * $area_min);
                                                                                                            $price_max = numFormat($obj_block->getField('price_sale_max') * $area_max);

                                                                                                            if (in_array($price_min, [0, 999999999]) || in_array($price_max, [999999999])) {
                                                                                                                $price_max = '<b class="attention">??????</b>';
                                                                                                                $price_min = $price_max;
                                                                                                            }
                                                                                                            ?>

                                                                                                            <?= valuesCompare($price_min, $price_max) ?> <i class="fal fa-ruble-sign"></i>
                                                                                                        <? } elseif ($obj_block->dealType() == 3) { ?>
                                                                                                            <?
                                                                                                            $price_min = $obj_block->getField('price_safe_pallet_eu_min');
                                                                                                            $price_max = $obj_block->getField('price_safe_pallet_eu_max');



                                                                                                            if (in_array($price_min, [0, 999999999])   || $price_max == 999999999) {
                                                                                                                $price_max = '<b class="attention">??????</b>';
                                                                                                                $price_min = $price_max;
                                                                                                            }


                                                                                                            ?>
                                                                                                            <?= valuesCompare($price_min, $price_max) ?> <i class="fal fa-ruble-sign"></i>
                                                                                                        <? } else { ?>

                                                                                                            <?
                                                                                                            $areas_min = [];
                                                                                                            $prices = [
                                                                                                                'price_sub_three',
                                                                                                                'price_sub_two',
                                                                                                                'price_sub',

                                                                                                                'price_floor',
                                                                                                                'price_field',
                                                                                                                'price_mezzanine',
                                                                                                                'price_mezzanine_two',
                                                                                                                'price_mezzanine_three',
                                                                                                                'price_mezzanine_four',


                                                                                                                'price_floor_two',
                                                                                                                'price_floor_three',
                                                                                                                'price_floor_four',
                                                                                                                'price_floor_five',
                                                                                                                'price_floor_six',



                                                                                                            ];





                                                                                                            $price_sum_min = 999999999;
                                                                                                            $price_sum_max = 0;

                                                                                                            foreach ($prices as $price_field) {
                                                                                                                if ($obj_block->getField($price_field . '_min') && $obj_block->getField($price_field . '_min') < $price_sum_min) {
                                                                                                                    $price_sum_min  = $obj_block->getField($price_field . '_min');
                                                                                                                }
                                                                                                                if ($obj_block->getField($price_field . '_max') && $obj_block->getField($price_field . '_max') > $price_sum_max) {
                                                                                                                    $price_sum_max  = $obj_block->getField($price_field . '_max');
                                                                                                                }
                                                                                                            }

                                                                                                            if ($area_min = $obj_block->getField('price_floor_min')) {
                                                                                                                $areas_min[] = $area_min;
                                                                                                            }
                                                                                                            if ($area_min = $obj_block->getField('price_mezzanine_min')) {
                                                                                                                $areas_min[] = $area_min;
                                                                                                            }

                                                                                                            if (in_array($price_sum_min, [0, 999999999]) || $price_sum_max == 999999999) {
                                                                                                                $price_sum_max = '<b class="attention">??????</b>';
                                                                                                                $price_sum_min = $price_sum_max;
                                                                                                            }


                                                                                                            $prices_all_names = [
                                                                                                                'price_sub_three',
                                                                                                                'price_sub_two',
                                                                                                                'price_sub',
                                                                                                                'price_field',
                                                                                                                'price_floor',
                                                                                                                'price_mezzanine',
                                                                                                                'price_mezzanine_two',
                                                                                                                'price_mezzanine_three',
                                                                                                                'price_mezzanine_four',
                                                                                                                'price_floor_two',
                                                                                                                'price_floor_three',
                                                                                                                'price_floor_four',
                                                                                                                'price_floor_five',
                                                                                                                'price_floor_six',
                                                                                                                'price_office',
                                                                                                                'price_tech',
                                                                                                            ];

                                                                                                            if (1) {
                                                                                                                $prices_all = [];

                                                                                                                foreach ($prices_all_names as $price) {
                                                                                                                    $prices_all[] = $obj_block->getField($price . '_min');
                                                                                                                    $prices_all[] = $obj_block->getField($price . '_max');
                                                                                                                }
                                                                                                            }

                                                                                                            ?>
                                                                                                            <?
                                                                                                            $prices = [
                                                                                                                '-3' => ['price_sub_tree', 'E- подвал -3эт'],
                                                                                                                '-2' => ['price_sub_two', 'E- подвал -2эт'],
                                                                                                                '-1' => ['price_sub', 'E- подвал -1эт'],
                                                                                                                '1f' => ['price_field', 'E-уличного'],
                                                                                                                '1' => ['price_floor', 'E-пола 1эт'],
                                                                                                                '1m' => ['price_mezzanine', 'E-мезонина 1ур'],
                                                                                                                '2m' => ['price_mezzanine_two', 'E-мезонина 2ур'],
                                                                                                                '3m' => ['price_mezzanine_three', 'E-мезонина 3ур'],
                                                                                                                '4m' => ['price_mezzanine_four', 'E-мезонина 4ур'],
                                                                                                                '2' => ['price_floor_two', 'E-пола 2 эт.'],
                                                                                                                '3' => ['price_floor_three', 'E-пола 3 эт.'],
                                                                                                                '4' => ['price_floor_four', 'E-пола 4 эт.'],
                                                                                                                '5' => ['price_floor_five', 'E-пола 5 эт.'],
                                                                                                                '6' => ['price_floor_six', 'E-пола 6 эт.'],
                                                                                                            ];



                                                                                                            $arr_floors_areas = [];
                                                                                                            foreach ($array_floor_new as $key => $value) {
                                                                                                                $arr_floors_areas[] = $value;
                                                                                                            }

                                                                                                            $prices_on_floors_sklad_min = [];
                                                                                                            $prices_on_floors_sklad_max = [];



                                                                                                            $i = 0;
                                                                                                            foreach ($prices as $key => $value) {
                                                                                                                if ($price_min_lol = $obj_block->getField($value[0] . '_min')) {
                                                                                                                    $price_max_lol = $obj_block->getField($value[0] . '_max');

                                                                                                                    $price_min_lol = ceil($price_min_lol / 12) * $arr_floors_areas[$i]['min'][0];
                                                                                                                    $price_max_lol = ceil($price_max_lol / 12) * $arr_floors_areas[$i]['max'][0];

                                                                                                                    $prices_on_floors_sklad_min[] = $price_min_lol;
                                                                                                                    $prices_on_floors_sklad_max[] = $price_max_lol;

                                                                                                                    $i++;
                                                                                                                }
                                                                                                            }

                                                                                                            $prices_on_floors_offer_min = $prices_on_floors_sklad_min;
                                                                                                            $prices_on_floors_offer_max = $prices_on_floors_sklad_max;


                                                                                                            $prices_on_floors_offer_max[] = ceil($obj_block->getField('price_office_max') / 12) * $obj_block->getField('area_office_max');
                                                                                                            $prices_on_floors_offer_max[] = ceil($obj_block->getField('price_tech_max') / 12) * $obj_block->getField('area_tech_max');




                                                                                                            ?>
                                                                                                            <? if ($_GET['format'] == 2) {
                                                                                                                $prices_all_min = ceil(getArrayMin($prices_all) / 12);
                                                                                                                $prices_all_max = ceil(max($prices_all) / 12);
                                                                                                                $dim = 'руб/м<sup>2</sup> мес';
                                                                                                            } elseif ($_GET['format'] == 3) {
                                                                                                                $prices_all_min = min($prices_on_floors_offer_min);
                                                                                                                $prices_all_max = array_sum($prices_on_floors_offer_max);






                                                                                                                $dim = 'руб/мес';
                                                                                                            } else {
                                                                                                                $prices_all_min = getArrayMin($prices_all);
                                                                                                                $prices_all_max = max($prices_all);
                                                                                                                $dim = 'руб/м<sup>2</sup> год';
                                                                                                            } ?>
                                                                                                            <?= valuesCompare(numFormat($prices_all_min), numFormat($prices_all_max)) ?> <i class="fal fa-ruble-sign"></i> <span>м<sup>2</sup>/год</span>
                                                                                                        <? } ?>
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="box-vertical">
                                                                                                    <? if ($obj_block->dealType() == 2) { ?>
                                                                                                        <div class="flex-box">
                                                                                                            <div>Цена за м кв</div>
                                                                                                            <div class="to-end"><?= valuesCompare(numFormat($obj_block->getField('price_sale_min')), numFormat($obj_block->getField('price_sale_max'))) ?> руб/м<sup>2</sup></div>
                                                                                                        </div>
                                                                                                    <? } ?>

                                                                                                    <?

                                                                                                    if ($_COOKIE['member_id']) {
                                                                                                        //var_dump($prices_on_floors);
                                                                                                    }



                                                                                                    ?>
                                                                                                    <? if ($obj_block->dealType() != 2 && $obj_block->dealType() != 3) { ?>
                                                                                                        <div class=" isBold flex-box ">
                                                                                                            <div class="">Е-складская</div>
                                                                                                            <div class="to-end">
                                                                                                                <? if ($_GET['format'] == 2) {
                                                                                                                    $price_sum_min = ceil($price_sum_min / 12);
                                                                                                                    $price_sum_max = ceil($price_sum_max / 12);
                                                                                                                    $dim = 'руб/м<sup>2</sup> мес';
                                                                                                                } elseif ($_GET['format'] == 3) {
                                                                                                                    $price_sum_min = min($prices_on_floors_sklad_min);
                                                                                                                    $price_sum_max = array_sum($prices_on_floors_sklad_max);

                                                                                                                    $dim = 'руб/мес';
                                                                                                                } else {
                                                                                                                    $dim = 'руб/м<sup>2</sup> год';
                                                                                                                } ?>
                                                                                                                <?= valuesCompare(numFormat($price_sum_min), numFormat($price_sum_max)) ?> <?= $dim ?>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    <? } ?>
                                                                                                    <?
                                                                                                    //$prices_on_floors[] = $obj_block->getField('price_office_min');
                                                                                                    //$prices_on_floors[] =


                                                                                                    ?>
                                                                                                    <? $i = 0 ?>
                                                                                                    <? foreach ($prices as $key => $value) { ?>
                                                                                                        <? if ($price_min = $obj_block->getField($value[0] . '_min')) { ?>
                                                                                                            <? $price_max = $obj_block->getField($value[0] . '_max')  ?>
                                                                                                            <div class="flex-box" style="line-height: 23px;">
                                                                                                                <div><?= $value[1] ?></div>
                                                                                                                <div class="to-end">
                                                                                                                    <? if ($_GET['format'] == 2) {
                                                                                                                        $price_min = ceil($price_min / 12);
                                                                                                                        $price_max = ceil($price_max / 12);
                                                                                                                        $dim = ' руб/м<sup>2</sup> мес';
                                                                                                                    } elseif ($_GET['format'] == 3) {
                                                                                                                        $price_min = ceil($price_max / 12) * $arr_floors_areas[$i]['min'][0];
                                                                                                                        $price_max = ceil($price_max / 12) * $arr_floors_areas[$i]['max'][0];
                                                                                                                        $dim = 'руб/мес';
                                                                                                                    } else {

                                                                                                                        $dim = 'руб/м<sup>2</sup> год';
                                                                                                                    } ?>
                                                                                                                    <?= valuesCompare(numFormat($price_min), numFormat($price_max)) . ' ' . $dim ?>
                                                                                                                </div>
                                                                                                            </div>
                                                                                                        <? $i++;
                                                                                                        } ?>
                                                                                                    <? } ?>
                                                                                                    <? if ($price_min = $obj_block->getField('price_office_min')) { ?>
                                                                                                        <? $price_max = $obj_block->getField('price_office_max')  ?>
                                                                                                        <div class="flex-box" style="line-height: 23px;">
                                                                                                            <div>E-офисов</div>
                                                                                                            <div class="to-end">
                                                                                                                <? if ($_GET['format'] == 2) {
                                                                                                                    $price_min = ceil($price_min / 12);
                                                                                                                    $price_max = ceil($price_max / 12);
                                                                                                                    $dim = ' руб/м<sup>2</sup> мес';
                                                                                                                } elseif ($_GET['format'] == 3) {
                                                                                                                    $price_min = ceil($price_max / 12) * $obj_block->getField('area_office_min');
                                                                                                                    $price_max = ceil($price_max / 12) * $obj_block->getField('area_office_max');
                                                                                                                    $dim = 'руб/мес';
                                                                                                                } else {

                                                                                                                    $dim = ' руб/м<sup>2</sup> год';
                                                                                                                } ?>

                                                                                                                <?= valuesCompare(numFormat($price_min), numFormat($price_max)) . ' ' . $dim ?>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    <? } ?>
                                                                                                    <? if ($price_min = $obj_block->getField('price_tech_min')) { ?>
                                                                                                        <? $price_max = $obj_block->getField('price_tech_max')  ?>
                                                                                                        <div class="flex-box" style="line-height: 23px;">
                                                                                                            <div>E-техническая</div>
                                                                                                            <div class="to-end">
                                                                                                                <? if ($_GET['format'] == 2) {
                                                                                                                    $price_min = ceil($price_min / 12);
                                                                                                                    $price_max = ceil($price_max / 12);
                                                                                                                    $dim = ' руб/м<sup>2</sup> мес';
                                                                                                                } elseif ($_GET['format'] == 3) {
                                                                                                                    $price_min = ceil($price_max / 12) * $obj_block->getField('area_tech_min');
                                                                                                                    $price_max = ceil($price_max / 12) * $obj_block->getField('area_tech_max');
                                                                                                                    $dim = 'руб/мес';
                                                                                                                } else {

                                                                                                                    $dim = ' руб/м<sup>2</sup> год';
                                                                                                                } ?>
                                                                                                                <?= valuesCompare(numFormat($price_min), numFormat($price_max)) . ' ' . $dim ?>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    <? } ?>
                                                                                                    <? if ($obj_block->dealType() == 3) { ?>
                                                                                                        <? if ($obj_block->getField('price_safe_pallet_eu_min')) { ?>
                                                                                                            <div class="flex-box " style="line-height: 23px;">
                                                                                                                <div class="isBold">~ E-аренды</div>
                                                                                                                <div class="to-end">
                                                                                                                    <?
                                                                                                                    $price_min = $obj_block->gf('pallet_place_min') * $obj_block->gf('price_safe_pallet_eu_max') * 30 * 12 / ($obj_block->getField('area_floor_min'));
                                                                                                                    $price_max = $obj_block->gf('pallet_place_max') * $obj_block->gf('price_safe_pallet_eu_max') * 30 * 12 / ($obj_block->getField('area_floor_max') + $obj_block->getField('area_mezzanine_max'));

                                                                                                                    ?>
                                                                                                                    <span class="isBold"><?= valuesCompare(numFormat(ceil($price_max)), numFormat(ceil($price_max))) ?> Р</span>
                                                                                                                    <span class="ghost" style="width: 70px; text-align: right;">м<sup>2</sup>/год</span>
                                                                                                                </div>
                                                                                                            </div>
                                                                                                        <? } ?>
                                                                                                        <?
                                                                                                        $arr = [
                                                                                                            ['EU  паллет 1.2*0.8*1.75', 'price_safe_pallet_eu', ' п.м/сут.'],
                                                                                                            ['FIN паллет 1.2*1*1.75', 'price_safe_pallet_fin', ' п.м/сут.'],
                                                                                                            ['US  паллет 1.2*1.2*1.75', 'price_safe_pallet_us', ' п.м/сут.'],
                                                                                                            ['Напольное', 'price_safe_floor', ' м.кв./сут'],
                                                                                                        ]
                                                                                                        ?>
                                                                                                        <? foreach ($arr as $item) { ?>
                                                                                                            <? if ($obj_block->getField($item[1] . '_min')) { ?>
                                                                                                                <div>
                                                                                                                    <div class="flex-box">
                                                                                                                        <div style="width: 150px ;">
                                                                                                                            <?= $item[0] ?>
                                                                                                                        </div>
                                                                                                                        <div class="flex-box to-end">
                                                                                                                            <div>
                                                                                                                                <?= valuesCompare($obj_block->getField($item[1] . '_min'), $obj_block->getField($item[1] . '_max')) ?>
                                                                                                                                <span>Р</span>
                                                                                                                            </div>
                                                                                                                            <div class="ghost " style="width: 70px; text-align: right;">
                                                                                                                                <?= $item[2] ?>
                                                                                                                            </div>
                                                                                                                        </div>
                                                                                                                    </div>
                                                                                                                </div>
                                                                                                            <? } ?>

                                                                                                        <? } ?>
                                                                                                    <? } ?>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="one_fourth box">
                                                                                            <? if ($obj_block->hasDeal()) { ?>
                                                                                                <div class="attention isBold">
                                                                                                    Сделка завершена
                                                                                                </div>
                                                                                                <?
                                                                                                $deal = new Deal($obj_block->getDealId());
                                                                                                ?>
                                                                                                <div class="isBold">
                                                                                                    <?= (new Company($deal->getField('client_company_id')))->title() ?>
                                                                                                </div>
                                                                                                <div class="isBold">
                                                                                                    <?= date('d-m-Y', strtotime($deal->getField('start_time'))) ?>
                                                                                                </div>
                                                                                                <div class="isBold">
                                                                                                    <?= (new Member($deal->getField('agent_id')))->title() ?>
                                                                                                </div>

                                                                                            <? } else { ?>
                                                                                                <div class="good isBold">
                                                                                                    Активная сделка
                                                                                                </div>

                                                                                            <? } ?>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="flex-box box-vertical flex-wrap">
                                                                                        <? if ($height_min = $obj_block->getField('ceiling_height_min') > 0) { ?>
                                                                                            <div class="box-small isBold flex-box flex-center-center">
                                                                                                <div>
                                                                                                    <span class="box-wide ghost-double"><i class="fas fa-arrow-to-top"></i></span> <?= valuesCompare($height_min, $obj_block->getField('ceiling_height_max')) ?> м.
                                                                                                </div>
                                                                                            </div>
                                                                                        <? } ?>
                                                                                        <? if ($power = $obj_block->getField('power') > 0) { ?>
                                                                                            <div class="box-small isBold flex-box flex-center-center">
                                                                                                <div>
                                                                                                    <span class="box-wide ghost-double"><i class="fas fa-bolt"></i></span><?= $power ?> кВт
                                                                                                </div>
                                                                                            </div>
                                                                                        <? } ?>
                                                                                        <? if ($obj_block->getField('heated') == 1) { ?>
                                                                                            <div class="box-small isBold flex-box flex-center-center">
                                                                                                <div>
                                                                                                    <span class="box-wide ghost-double"><i class="fas fa-temperature-hot"></i></span>
                                                                                                    Отопление
                                                                                                </div>
                                                                                            </div>
                                                                                        <? } ?>
                                                                                        <? if ($obj_block->getField('floor_type') == 2) { ?>
                                                                                            <div class="box-small isBold">
                                                                                                <div>
                                                                                                    <span class="box-wide ghost-double"><i class="fas fa-arrow-alt-to-bottom"></i></span>
                                                                                                    Антипыль
                                                                                                </div>
                                                                                            </div>
                                                                                        <? } ?>
                                                                                        <? if ($sum = array_sum($obj_block->getBlockArrayValueEven('gates')) > 0) { ?>
                                                                                            <div class="box-small isBold flex-box flex-center-center">
                                                                                                <div>
                                                                                                    <span class="box-wide ghost-double"><i class="far fa-dungeon"></i></span>
                                                                                                    <?= $sum ?>
                                                                                                    Ворот
                                                                                                </div>
                                                                                            </div>
                                                                                        <? } ?>
                                                                                        <? if ($cranes_min = min($obj_block->getBlockArrayValuesEvenMultiple(['cranes_overhead', 'cranes_cathead', 'telphers']))) { ?>
                                                                                            <div class="box-small isBold flex-box flex-center-center">
                                                                                                <div>
                                                                                                    <span class="box-wide ghost-double"><i class="fas fa-angle-double-up"></i></span>
                                                                                                    Краны <?= valuesCompare($cranes_min, max($obj_block->getBlockArrayValuesEvenMultiple(['cranes_overhead', 'cranes_cathead', 'telphers']))) ?> т.
                                                                                                </div>
                                                                                            </div>
                                                                                        <? } ?>
                                                                                        <? if ($temp_min = $obj_block->getField('temperature_min')) { ?>
                                                                                            <div class="box-small isBold flex-box flex-center-center">
                                                                                                <div>
                                                                                                    <span class="box-wide ghost-double"><i class="fas fa-temperature-low"></i></span> <?= valuesCompare($temp_min, $obj_block->getField('temperature_max')) ?> град.
                                                                                                </div>
                                                                                            </div>
                                                                                        <? } ?>
                                                                                        <? if ($obj_block->getField('racks') == 1) { ?>
                                                                                            <div class="box-small isBold flex-box flex-center-center">
                                                                                                <div>
                                                                                                    <span class="box-wide ghost-double"><i class="fas fa-inventory"></i></span>
                                                                                                    Стеллажи
                                                                                                </div>
                                                                                            </div>
                                                                                        <? } ?>
                                                                                        <? if ($obj_block->getField('cross_docking') == 1) { ?>
                                                                                            <div class="box-small isBold flex-box flex-center-center">
                                                                                                <div>
                                                                                                    Кросс-докинг
                                                                                                </div>
                                                                                            </div>
                                                                                        <? } ?>
                                                                                        <? if ($obj_block->getField('warehouse_equipment') == 1) { ?>
                                                                                            <div class="box-small isBold flex-box flex-center-center">
                                                                                                <div>
                                                                                                    <span class="box-wide ghost-double"><i class="fas fa-truck-loading"></i></span>
                                                                                                    Складская техника
                                                                                                </div>
                                                                                            </div>
                                                                                        <? } ?>
                                                                                        <? if ($obj_block->getField('charging_room') == 1) { ?>
                                                                                            <div class="box-small isBold flex-box flex-center-center">
                                                                                                <div>
                                                                                                    <span class="box-wide ghost-double"><i class="fas fa-charging-station"></i></span>
                                                                                                    Зарядная комната
                                                                                                </div>
                                                                                            </div>
                                                                                        <? } ?>
                                                                                    </div>
                                                                                    <div>
                                                                                        <div class="tabs-block tabs-active-free  full-width">
                                                                                            <div class="tabs flex-box">
                                                                                                <? if ($offer->getField('deal_type') == 3 && !$object->getField('is_land')) { ?>
                                                                                                    <div class="tab box-small ">
                                                                                                        Цены +
                                                                                                    </div>
                                                                                                    <div class="tab box-small">
                                                                                                        Услуги О/Х
                                                                                                    </div>
                                                                                                <? } ?>
                                                                                                <div class="tab box-small">
                                                                                                    Сводка
                                                                                                </div>
                                                                                                <div class="tab box-small">
                                                                                                    По блокам
                                                                                                </div>
                                                                                                <div class="tab box-small">
                                                                                                    Клиенты
                                                                                                </div>
                                                                                                <div class="tab box-small">
                                                                                                    Задачи
                                                                                                </div>
                                                                                                <? if ($obj_block->hasDeal()) { ?>
                                                                                                    <div class="tab box-small">
                                                                                                        Сделка
                                                                                                    </div>
                                                                                                <? } ?>
                                                                                                <div class="flex-box to-end ">
                                                                                                    <div class="flex-box box-small">
                                                                                                        <? if ($logedUser->isAdmin()) { ?>
                                                                                                            <div class="icon-round">
                                                                                                                <a href="http://pennylane.pro/system/controllers/subitems/recover.php?id=<?= $obj_block->getField('id') ?>">
                                                                                                                    <i class="fas fa-trash-restore"></i>
                                                                                                                </a>
                                                                                                            </div>
                                                                                                            <div class="icon-round modal-call-btn " data-form="<?= $deal_forms_blocks_arr[$object->getField('is_land')][$offer->getField('deal_type') - 1] ?>" data-id="<?= $obj_block->postId() ?>" data-table="<?= $obj_block->setTableId() ?>" data-modal="edit-all" data-modal-size="modal-big"><i class="fas fa-pencil-alt"></i></div>
                                                                                                            <? if (!$obj_block->hasPartUnactive()) { ?>
                                                                                                                <div class="icon-round  modal-call-btn  " <? if ($obj_block->getField('deal_id') != 0/*$obj_block->hasDeal()*/) { ?> style="background: limegreen; color: white;" title="Редактировать сделку" <? } ?> title="Создать сделку" data-modal="edit-all" data-id="<?= (int)$obj_block->getField('deal_id')/*$obj_block->getDealId()*/ ?>" data-table="<?= (new Deal())->setTableId() ?>" data-names='["block_id"]' data-values='[<?= $obj_block->postId() ?>]' data-show-name="object_id" data-modal-size="modal-middle">
                                                                                                                    <div>
                                                                                                                        <i class="far fa-handshake"></i>
                                                                                                                    </div>
                                                                                                                </div>
                                                                                                            <? } ?>
                                                                                                        <? } ?>

                                                                                                        <? if (count($offer->subItemsId()) > 1) { ?>
                                                                                                            <? if ($logedUser->isAdmin()) { ?>
                                                                                                                <div class="icon-round ad-panel-call modal-call-btn1" data-id="" data-table="" data-modal="panel-ad" data-modal-size="modal-middle"><i class="fas fa-rocket"></i></div>
                                                                                                            <? } ?>
                                                                                                            <div class="icon-round" style="position: relative;">
                                                                                                                <a target="_blank" href="/pdf-test.php?original_id=<?= $obj_block->postId() ?>&type_id=1&member_id=<?= $logedUser->member_id() ?>"><i class="fas fa-file-pdf"></i></a>
                                                                                                                <? if (!arrayIsNotEmpty($obj_block->getJsonField('photo_block'))) { ?>
                                                                                                                    <div class="overlay-over" title="презентация недоступна так нету фото в блоке" style="background: red; ">

                                                                                                                    </div>
                                                                                                                <? } ?>
                                                                                                            </div>

                                                                                                            <div class="icon-round icon-star <?= (in_array([$obj_block->postId(), 1], $favourites)) ? 'icon-star-active' : '' ?>" data-offer-id="[<?= $obj_block->postId() ?>,1]"><i class="fas fa-star"></i></div>
                                                                                                            <? if ($obj_block->getJsonField('photos_360_block') != NULL &&  arrayIsNotEmpty($obj_block->getJsonField('photos_360_block'))) { ?>
                                                                                                                <div class="icon-round to-end">
                                                                                                                    <a href="/tour-360/<?= $obj_block->setTableId() ?>/<?= $obj_block->postId() ?>/photos_360_block" target="_blank"><span title="Панорама"><i class="fas fa-globe"></i></span></a>
                                                                                                                </div>
                                                                                                            <? } ?>
                                                                                                            <? if ($logedUser->isAdmin()) { ?>
                                                                                                                <div class="icon-round modal-call-btn to-end" data-form="<?= $deal_forms_blocks_arr[$object->getField('is_land')][$offer->getField('deal_type') - 1] ?>" data-id="<?= $obj_block->postId() ?>" data-table="<?= $obj_block->setTableId() ?>" data-modal="delete" data-modal-size="modal-small" title="Разорвать связь"><i class="far fa-trash-alt"></i></div>
                                                                                                            <? } ?>
                                                                                                        <? } ?>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="tabs-content full-width">
                                                                                                <? if ($offer->getField('deal_type') == 3 && !$object->getField('is_land')) { ?>
                                                                                                    <div class="tab-content">
                                                                                                        <? if ($offer->getField('deal_type') == 3 && !$object->getField('is_land')) { ?>
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
                                                                                                                <div style="height: 32px;">

                                                                                                                </div>
                                                                                                                <div class="tabs-content" style="background: #f4f4f4; border: 1px solid lightblue;">
                                                                                                                    <div class="tab-content">
                                                                                                                        <ul class="full-width">
                                                                                                                            <?
                                                                                                                            $arr = [
                                                                                                                                ['EU  паллет 1.2*0.8*1.75', 'price_safe_pallet_eu', 'Р п.м/сут.'],
                                                                                                                                ['FIN паллет 1.2*1*1.75', 'price_safe_pallet_fin', 'Р п.м/сут.'],
                                                                                                                                ['US  паллет 1.2*1.2*1.75', 'price_safe_pallet_us', 'Р п.м/сут.'],
                                                                                                                                ['Негаб паллет/груз до 2т', 'price_safe_pallet_oversized', 'Р за ед.'],
                                                                                                                                ['Ячейки 30x40 ', 'price_safe_cell_small', 'яч./сут.'],
                                                                                                                                ['Ячейки 60x40', 'price_safe_cell_middle', 'яч./сут.'],
                                                                                                                                ['Ячейки 60x80', 'price_safe_cell_big', 'яч./сут.'],
                                                                                                                                ['Напольное', 'price_safe_floor', 'Р за м.кв./сут'],
                                                                                                                                ['Объемное', 'price_safe_volume', 'Р за м.куб./сут'],
                                                                                                                            ]
                                                                                                                            ?>
                                                                                                                            <? foreach ($arr as $item) { ?>
                                                                                                                                <li>
                                                                                                                                    <span class="flex-box">
                                                                                                                                        <div style="width: 200px ;">
                                                                                                                                            <?= $item[0] ?>
                                                                                                                                        </div>
                                                                                                                                        <div style="width: 100px">
                                                                                                                                            <?= valuesCompare($offer->getOfferBlocksMinValue($item[1] . '_min'), $offer->getOfferBlocksMaxValue($item[1] . '_max')) ?>
                                                                                                                                        </div>
                                                                                                                                        <div class="ghost to-end">
                                                                                                                                            <?= $item[2] ?>
                                                                                                                                        </div>
                                                                                                                                    </span>
                                                                                                                                </li>
                                                                                                                            <? } ?>
                                                                                                                        </ul>
                                                                                                                    </div>
                                                                                                                    <div class="tab-content">
                                                                                                                        <ul class="full-width">
                                                                                                                            <?
                                                                                                                            $arr_1 = [
                                                                                                                                ['EU  паллет 1.2*0.8*1.75', 'price_safe_pallet_eu_in', 'Р за ед.'],
                                                                                                                                ['FIN паллет 1.2*1*1.75', 'price_safe_pallet_fin_in', 'Р за ед.'],
                                                                                                                                ['US  паллет 1.2*1.2*1.75', 'price_safe_pallet_us_in', 'Р за ед.'],
                                                                                                                                ['Негаб паллет/груз до 2т', 'price_safe_pallet_oversized_in', 'Р за ед.'],
                                                                                                                                ['Нагаб паллет/ 2-5т', 'price_safe_pallet_oversized_middle_in', 'Р за ед.'],
                                                                                                                                ['Негаб паллет / 5-8т', 'price_safe_pallet_oversized_big_in', 'Р за ед.'],
                                                                                                                            ];

                                                                                                                            $arr_2 = [
                                                                                                                                ['Короб/ мешок до 10кг ', 'price_safe_pack_small_in', 'Р за ед'],
                                                                                                                                ['Короб/мешок до 25кг', 'price_safe_pack_middle_in', 'Р за ед'],
                                                                                                                                ['Короб/мешок до 40кг', 'price_safe_pack_big_in', 'Р за ед'],
                                                                                                                            ];
                                                                                                                            ?>
                                                                                                                            <li><u>Механизированная погрузка</u></li>
                                                                                                                            <? foreach ($arr_1 as $item) { ?>
                                                                                                                                <li>
                                                                                                                                    <span class="flex-box">
                                                                                                                                        <div style="width: 200px;">
                                                                                                                                            <?= $item[0] ?>
                                                                                                                                        </div>
                                                                                                                                        <div style="width: 100px">
                                                                                                                                            <?= valuesCompare($offer->getOfferBlocksMinValue($item[1]), $offer->getOfferBlocksMaxValue($item[1])) ?>
                                                                                                                                        </div>
                                                                                                                                        <div class="ghost">
                                                                                                                                            <?= $item[2] ?>
                                                                                                                                        </div>
                                                                                                                                    </span>
                                                                                                                                </li>
                                                                                                                            <? } ?>
                                                                                                                            <li><u>Ручная погрузка</u></li>
                                                                                                                            <? foreach ($arr_2 as $item) { ?>
                                                                                                                                <li>
                                                                                                                                    <span class="flex-box">
                                                                                                                                        <div style="width: 200px;">
                                                                                                                                            <?= $item[0] ?>
                                                                                                                                        </div>
                                                                                                                                        <div style="width: 100px">
                                                                                                                                            <?= valuesCompare($offer->getOfferBlocksMinValue($item[1]), $offer->getOfferBlocksMaxValue($item[1])) ?>
                                                                                                                                        </div>
                                                                                                                                        <div class="ghost">
                                                                                                                                            <?= $item[2] ?>
                                                                                                                                        </div>
                                                                                                                                    </span>
                                                                                                                                </li>
                                                                                                                            <? } ?>
                                                                                                                        </ul>
                                                                                                                    </div>
                                                                                                                    <div class="tab-content">
                                                                                                                        <ul class="full-width">
                                                                                                                            <?
                                                                                                                            $arr_1 = [
                                                                                                                                ['EU  паллет 1.2*0.8*1.75', 'price_safe_pallet_eu_out', 'Р за ед.'],
                                                                                                                                ['FIN паллет 1.2*1*1.75', 'price_safe_pallet_fin_out', 'Р за ед.'],
                                                                                                                                ['US  паллет 1.2*1.2*1.75', 'price_safe_pallet_us_out', 'Р за ед.'],
                                                                                                                                ['Негаб паллет/груз до 2т', 'price_safe_pallet_oversized_out', 'Р за ед.'],
                                                                                                                                ['Нагаб паллет/ 2-5т', 'price_safe_pallet_oversized_middle_out', 'Р за ед.'],
                                                                                                                                ['Негаб паллет / 5-8т', 'price_safe_pallet_oversized_big_out', 'Р за ед.'],
                                                                                                                            ];

                                                                                                                            $arr_2 = [
                                                                                                                                ['Короб/ мешок до 10кг ', 'price_safe_pack_small_out', 'Р за ед'],
                                                                                                                                ['Короб/мешок до 25кг', 'price_safe_pack_middle_out', 'Р за ед'],
                                                                                                                                ['Короб/мешок до 40кг', 'price_safe_pack_big_out', 'Р за ед'],
                                                                                                                            ];
                                                                                                                            ?>
                                                                                                                            <li><u>Механизированная погрузка</u></li>
                                                                                                                            <? foreach ($arr_1 as $item) { ?>
                                                                                                                                <li>
                                                                                                                                    <span class="flex-box">
                                                                                                                                        <div style="width: 200px;">
                                                                                                                                            <?= $item[0] ?>
                                                                                                                                        </div>
                                                                                                                                        <div style="width: 100px">
                                                                                                                                            <?= valuesCompare($offer->getOfferBlocksMinValue($item[1]), $offer->getOfferBlocksMaxValue($item[1])) ?>
                                                                                                                                        </div>
                                                                                                                                        <div class="ghost">
                                                                                                                                            <?= $item[2] ?>
                                                                                                                                        </div>
                                                                                                                                    </span>
                                                                                                                                </li>
                                                                                                                            <? } ?>
                                                                                                                            <li><u>Ручная погрузка</u></li>
                                                                                                                            <? foreach ($arr_2 as $item) { ?>
                                                                                                                                <li>
                                                                                                                                    <span class="flex-box">
                                                                                                                                        <div style="width: 200px;">
                                                                                                                                            <?= $item[0] ?>
                                                                                                                                        </div>
                                                                                                                                        <div style="width: 100px">
                                                                                                                                            <?= valuesCompare($offer->getOfferBlocksMinValue($item[1]), $offer->getOfferBlocksMaxValue($item[1])) ?>
                                                                                                                                        </div>
                                                                                                                                        <div class="ghost">
                                                                                                                                            <?= $item[2] ?>
                                                                                                                                        </div>
                                                                                                                                    </span>
                                                                                                                                </li>
                                                                                                                            <? } ?>
                                                                                                                            <li>
                                                                                                                                <div class="underlined">
                                                                                                                                    Подбор в заказ
                                                                                                                                </div>
                                                                                                                            </li>
                                                                                                                            <?
                                                                                                                            $arr = [
                                                                                                                                ['Короб/ мешок до 10кг ', 'price_safe_pack_small_complement', 'Р за ед'],
                                                                                                                                ['Короб/мешок до 25кг', 'price_safe_pack_middle_complement', 'Р за ед'],
                                                                                                                                ['Короб/мешок до 40кг', 'price_safe_pack_big_complement', 'Р за ед'],
                                                                                                                            ]
                                                                                                                            ?>
                                                                                                                            <? foreach ($arr as $item) { ?>
                                                                                                                                <li>
                                                                                                                                    <span class="flex-box">
                                                                                                                                        <div style="width: 200px;">
                                                                                                                                            <?= $item[0] ?>
                                                                                                                                        </div>
                                                                                                                                        <div style="width: 100px">
                                                                                                                                            <?= valuesCompare($offer->getOfferBlocksMinValue($item[1]), $offer->getOfferBlocksMaxValue($item[1])) ?>
                                                                                                                                        </div>
                                                                                                                                        <div class="ghost">
                                                                                                                                            <?= $item[2] ?>
                                                                                                                                        </div>
                                                                                                                                    </span>
                                                                                                                                </li>
                                                                                                                            <? } ?>
                                                                                                                        </ul>
                                                                                                                    </div>
                                                                                                                    <div class="tab-content">
                                                                                                                        <ul class="full-width">
                                                                                                                            <?
                                                                                                                            $arr = [
                                                                                                                                ['Выборочная инвентаризация', 'price_safe_service_inventory', 'Р за ед.'],
                                                                                                                                ['Обмотка стретч пленкой 2-3 слоя', 'price_safe_service_winding', 'Р за ед.'],
                                                                                                                                ['Подготовка сопроводительных документов', 'price_safe_service_document', 'Р за ед.'],
                                                                                                                                ['Предоставление отчетов', 'price_safe_service_report', 'Р за ед.'],
                                                                                                                                ['Предоставление поддонов', 'price_safe_service_pallet', 'Р за ед.'],
                                                                                                                                ['Стикеровка', 'price_safe_service_stickers', 'Р за ед.'],
                                                                                                                                ['Формирование паллет', 'price_safe_service_packing_pallet', 'Р за ед'],
                                                                                                                                ['Формирование коробов', 'price_safe_service_packing_pack', 'Р за ед'],
                                                                                                                                ['Утилизация мусора', 'price_safe_service_recycling', 'Р за ед'],
                                                                                                                                ['Опломбирование авто', 'price_safe_service_sealing', 'Р за ед'],
                                                                                                                            ]
                                                                                                                            ?>
                                                                                                                            <? foreach ($arr as $item) { ?>
                                                                                                                                <li>
                                                                                                                                    <span class="flex-box">
                                                                                                                                        <div style="width: 250px;">
                                                                                                                                            <?= $item[0] ?>
                                                                                                                                        </div>
                                                                                                                                        <div style="width: 100px">
                                                                                                                                            <?= valuesCompare($offer->getOfferBlocksMinValue($item[1]), $offer->getOfferBlocksMaxValue($item[1])) ?>
                                                                                                                                        </div>
                                                                                                                                        <div class="ghost">
                                                                                                                                            <?= $item[2] ?>
                                                                                                                                        </div>
                                                                                                                                    </span>
                                                                                                                                </li>
                                                                                                                            <? } ?>
                                                                                                                        </ul>
                                                                                                                    </div>
                                                                                                                </div>
                                                                                                            </div>
                                                                                                        <? } ?>
                                                                                                    </div>
                                                                                                    <div class="tab-content">
                                                                                                        <div class="object-params-list">
                                                                                                            <ul class="full-width box-wide">
                                                                                                                <?
                                                                                                                $all_fields = $offer->getTableColumnsNames();
                                                                                                                $services = [];
                                                                                                                foreach ($all_fields as $field_item) {
                                                                                                                    if (stristr($field_item, 'safe_service') !== false && $offer->getField($field_item)) {
                                                                                                                        $services[] = $field_item;
                                                                                                                    }
                                                                                                                }
                                                                                                                //var_dump($services);

                                                                                                                ?>
                                                                                                                <? foreach ($services as $service) { ?>
                                                                                                                    <? $service_field = new Field() ?>
                                                                                                                    <? $service_field->getFieldByName($service) ?>
                                                                                                                    <li>
                                                                                                                        <div class="full-width">
                                                                                                                            <?= $service_field->description() ?>
                                                                                                                        </div>
                                                                                                                    </li>
                                                                                                                <? } ?>
                                                                                                            </ul>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                <? } ?>
                                                                                                <div class="tab-content box-vertical" style="background: white;">
                                                                                                    <div class="flex-box flex-vertical-top">
                                                                                                        <div class="object-params-list">
                                                                                                            <ul>
                                                                                                                <li>
                                                                                                                    <div class="isBold">
                                                                                                                        Характеристики
                                                                                                                    </div>
                                                                                                                    <div>
                                                                                                                        &#160;
                                                                                                                    </div>
                                                                                                                </li>
                                                                                                                <li>
                                                                                                                    <div>
                                                                                                                        Тип пола
                                                                                                                    </div>
                                                                                                                    <div>
                                                                                                                        <? $grids = $obj_block->getJsonField('floor_types'); ?>
                                                                                                                        <? if (count($grids)) { ?>
                                                                                                                            <? foreach ($grids as $grid) {
                                                                                                                                $grid = new Post($grid);
                                                                                                                                $grid->getTable('l_floor_types');
                                                                                                                            ?>
                                                                                                                                <?= $grid->title() ?> ,
                                                                                                                            <? } ?>
                                                                                                                        <? } else { ?>
                                                                                                                            -
                                                                                                                        <? } ?>
                                                                                                                    </div>
                                                                                                                </li>
                                                                                                                <li>
                                                                                                                    <div>
                                                                                                                        Высота, рабочая
                                                                                                                    </div>
                                                                                                                    <div>
                                                                                                                        <?= valuesCompare($obj_block->getBlockPartsMinValue('ceiling_height_min'), $obj_block->getBlockPartsMaxValue('ceiling_height_max')) ?> <span>м</span>
                                                                                                                    </div>
                                                                                                                </li>
                                                                                                                <li>
                                                                                                                    <div>
                                                                                                                        Нагрузка на пол
                                                                                                                    </div>
                                                                                                                    <div>
                                                                                                                        <?= valuesCompare($obj_block->getField('load_floor_min'), $obj_block->getField('load_floor_max')) ?> <span>т/м<sup>2</sup></span>
                                                                                                                    </div>
                                                                                                                </li>
                                                                                                                <li>
                                                                                                                    <div>
                                                                                                                        Нагрузка на мезонин
                                                                                                                    </div>
                                                                                                                    <div>
                                                                                                                        <?= valuesCompare($obj_block->getField('load_mezzanine_min'), $obj_block->getField('load_mezzanine_max')) ?> <span>т/м<sup>2</sup></span>
                                                                                                                    </div>
                                                                                                                </li>
                                                                                                                <li>
                                                                                                                    <div>
                                                                                                                        Шаг колонн
                                                                                                                    </div>
                                                                                                                    <div>
                                                                                                                        <? $grids = $obj_block->getJsonField('column_grids'); ?>
                                                                                                                        <? if (count($grids)) { ?>
                                                                                                                            <? foreach ($grids as $grid) {
                                                                                                                                $grid = new Post($grid);
                                                                                                                                $grid->getTable('l_pillars_grid');
                                                                                                                            ?>
                                                                                                                                <?= $grid->title() ?> ,
                                                                                                                            <? } ?>
                                                                                                                        <? } else { ?>
                                                                                                                            -
                                                                                                                        <? } ?>
                                                                                                                    </div>
                                                                                                                </li>
                                                                                                                <?
                                                                                                                $gates = $obj_block->getBlockArrayValues('gates');
                                                                                                                $gate_types = [];
                                                                                                                $amount = count($gates);
                                                                                                                for ($i = 0; $i < $amount; $i = $i + 2) {
                                                                                                                    if ($gate_types[$gates[$i]]) {
                                                                                                                        $gate_types[$gates[$i]] += $gates[$i + 1];
                                                                                                                    } else {
                                                                                                                        $gate_types[$gates[$i]] = $gates[$i + 1];
                                                                                                                    }
                                                                                                                }
                                                                                                                ?>
                                                                                                                <li>
                                                                                                                    <div>
                                                                                                                        Тип/кол-во ворот
                                                                                                                    </div>
                                                                                                                    <div>
                                                                                                                        <? if ($gate_types) { ?>
                                                                                                                            <? foreach ($gate_types as $key => $value) {
                                                                                                                                $gate = new Post($key);
                                                                                                                                $gate->getTable('l_gates_types');
                                                                                                                            ?>
                                                                                                                                <div class="flex-box">
                                                                                                                                    <div><?= $value ?> шт </div>/<div class="box-wide"> <?= $gate->title() ?></div>
                                                                                                                                </div>
                                                                                                                            <? } ?>
                                                                                                                        <? } else { ?>
                                                                                                                            -
                                                                                                                        <? } ?>
                                                                                                                    </div>
                                                                                                                </li>
                                                                                                                <li>
                                                                                                                    <div>
                                                                                                                        Температурный режим
                                                                                                                    </div>
                                                                                                                    <div>
                                                                                                                        <? if ($temp_min = $obj_block->getBlockPartsMinValue('temperature_min')) { ?>
                                                                                                                            <?= ($temp_min > 0) ? '+' : '' ?>
                                                                                                                            <?= $temp_min ?>
                                                                                                                        <? } ?>
                                                                                                                        <? if ($temp_max = $obj_block->getBlockPartsMinValue('temperature_max')) { ?>
                                                                                                                            /
                                                                                                                            <?= ($temp_max > 0) ? '+' : '' ?>
                                                                                                                            <?= $temp_max ?>
                                                                                                                        <? } ?>
                                                                                                                        <? //= valuesCompare($offer->getOfferBlocksMinValue('temperature_min'), $offer->getOfferBlocksMaxValue('temperature_max'))
                                                                                                                        ?> <span>градусов</span>
                                                                                                                    </div>
                                                                                                                </li>
                                                                                                                <li>
                                                                                                                    <div>
                                                                                                                        Кол-во палет-мест
                                                                                                                    </div>
                                                                                                                    <div>
                                                                                                                        <?= $offer->showOfferCalcStat(valuesCompare($obj_block->getBlockPartsMinValue('pallet_place_min'), $obj_block->getBlockPartsMaxSumValue('pallet_place_max')), '<span class="ghost">п.м.</span>', '-') ?>
                                                                                                                    </div>
                                                                                                                </li>

                                                                                                                <li>
                                                                                                                    <div>
                                                                                                                        &#160;
                                                                                                                    </div>
                                                                                                                    <div>
                                                                                                                        &#160;
                                                                                                                    </div>
                                                                                                                </li>
                                                                                                                <li>
                                                                                                                    <div class="isBold">
                                                                                                                        Оборудование
                                                                                                                    </div>
                                                                                                                    <div>
                                                                                                                        &#160;
                                                                                                                    </div>
                                                                                                                </li>
                                                                                                                <li>
                                                                                                                    <div>
                                                                                                                        Стеллажи
                                                                                                                    </div>
                                                                                                                    <div>
                                                                                                                        <? $racks = $obj_block->getBlockPartsMaxSumValue('racks') ?>
                                                                                                                        <?= ($racks) ? 'есть' : '-' ?> <?= ($racks && (($racks / count($obj_block->getBlockPartsId())) < 1)) ? ', частично' : '' ?>
                                                                                                                    </div>
                                                                                                                </li>
                                                                                                                <li>
                                                                                                                    <div>
                                                                                                                        Типы стеллажей
                                                                                                                    </div>
                                                                                                                    <div>
                                                                                                                        <? $racks_types = $obj_block->getJsonField('rack_types') ?>
                                                                                                                        <? if ($racks_types) { ?>
                                                                                                                            <? foreach ($racks_types  as $type) { ?>
                                                                                                                                <? $rack = new Post($type) ?>
                                                                                                                                <? $rack->getTable('l_racks_types') ?>
                                                                                                                                <?= $rack->title() ?>
                                                                                                                            <? } ?>
                                                                                                                        <? } else { ?>
                                                                                                                            -
                                                                                                                        <? } ?>
                                                                                                                    </div>
                                                                                                                </li>
                                                                                                                <li>
                                                                                                                    <div>
                                                                                                                        Типы хранения
                                                                                                                    </div>
                                                                                                                    <div>
                                                                                                                        <? if ($safe_types = $obj_block->getJsonField('safe_type')) { ?>
                                                                                                                            <? foreach ($safe_types as $type) { ?>
                                                                                                                                <? $safe_type = new Post($type) ?>
                                                                                                                                <? $safe_type->getTable('l_safe_types') ?>
                                                                                                                                <?= $safe_type->title() ?>
                                                                                                                            <? } ?>
                                                                                                                        <? } else { ?>
                                                                                                                            -
                                                                                                                        <? } ?>
                                                                                                                    </div>
                                                                                                                </li>
                                                                                                                <li>
                                                                                                                    <div>
                                                                                                                        Зарядная комната
                                                                                                                    </div>
                                                                                                                    <div>
                                                                                                                        <? $charging_room = $obj_block->getField('charging_room') ?>
                                                                                                                        <?= ($charging_room) ? 'есть' : '-' ?>
                                                                                                                    </div>
                                                                                                                </li>
                                                                                                                <li>
                                                                                                                    <div>
                                                                                                                        Складская техника
                                                                                                                    </div>
                                                                                                                    <div>
                                                                                                                        <? $warehouse_equipment = $obj_block->getField('warehouse_equipment') ?>
                                                                                                                        <?= ($warehouse_equipment) ? 'есть' : '-' ?> <?= ($warehouse_equipment && (($warehouse_equipment / count($obj_block->getBlockPartsId())) < 1)) ? ', частично' : '' ?>
                                                                                                                    </div>
                                                                                                                </li>
                                                                                                                <li>
                                                                                                                    <div>
                                                                                                                        Ячейки
                                                                                                                    </div>
                                                                                                                    <div>
                                                                                                                        <? $cells = $obj_block->getField('cells') ?>
                                                                                                                        <?= ($cells) ? 'есть' : '-' ?> <?= ($cells && (($cells / count($obj_block->getBlockPartsId())) < 1)) ? ', частично' : '' ?>
                                                                                                                    </div>
                                                                                                                </li>
                                                                                                                <li>
                                                                                                                    <div>
                                                                                                                        &#160;
                                                                                                                    </div>
                                                                                                                    <div>
                                                                                                                        &#160;
                                                                                                                    </div>
                                                                                                                </li>
                                                                                                                <li>
                                                                                                                    <div class="isBold">
                                                                                                                        Коммуникации
                                                                                                                    </div>
                                                                                                                    <div>
                                                                                                                        &#160;
                                                                                                                    </div>
                                                                                                                </li>
                                                                                                                <li>
                                                                                                                    <div>
                                                                                                                        Мощность
                                                                                                                    </div>
                                                                                                                    <div>
                                                                                                                        <? if ($power_offer = $obj_block->getField('power')) { ?>
                                                                                                                            <?= $power_offer ?> кВт
                                                                                                                        <? } else { ?>
                                                                                                                            -
                                                                                                                        <? } ?>
                                                                                                                    </div>
                                                                                                                </li>


                                                                                                                <li>
                                                                                                                    <div>
                                                                                                                        &#160;
                                                                                                                    </div>
                                                                                                                    <div>
                                                                                                                        &#160;
                                                                                                                    </div>
                                                                                                                </li>
                                                                                                                <li>
                                                                                                                    <div class="isBold">
                                                                                                                        Системы безопасности
                                                                                                                    </div>
                                                                                                                    <div>
                                                                                                                        &#160;
                                                                                                                    </div>
                                                                                                                </li>
                                                                                                                <li>
                                                                                                                    <div>
                                                                                                                        Кросс-докинг
                                                                                                                    </div>
                                                                                                                    <div>
                                                                                                                        <? $cross = $obj_block->getField('cross_docking') ?>
                                                                                                                        <?= ($cross) ? 'есть' : '-' ?>
                                                                                                                    </div>
                                                                                                                </li>
                                                                                                                <li>
                                                                                                                    <div>
                                                                                                                        &#160;
                                                                                                                    </div>
                                                                                                                    <div>
                                                                                                                        &#160;
                                                                                                                    </div>
                                                                                                                </li>
                                                                                                                <li>
                                                                                                                    <div class="isBold">
                                                                                                                        Подъемные устройства
                                                                                                                    </div>
                                                                                                                    <div>
                                                                                                                        &#160;
                                                                                                                    </div>
                                                                                                                </li>
                                                                                                                <li>
                                                                                                                    <?
                                                                                                                    $elevators = $obj_block->getJsonField('elevators');
                                                                                                                    $amount = count($elevators);

                                                                                                                    $elevators_types = [];
                                                                                                                    $elevators_amount = [];

                                                                                                                    for ($i = 0; $i < $amount; $i = $i + 2) {
                                                                                                                        if (!in_array($elevators[$i + 1], $elevators_types) && $elevators[$i + 1] != 0) {
                                                                                                                            $elevators_types[] = $elevators[$i + 1];
                                                                                                                        }
                                                                                                                        $elevators_amount[] =  $elevators[$i];
                                                                                                                    }

                                                                                                                    ?>
                                                                                                                    <div>
                                                                                                                        Лифты/подъемники
                                                                                                                    </div>
                                                                                                                    <div>
                                                                                                                        <? if (count($elevators)) { ?>
                                                                                                                            <span class="ghost"><?= array_sum($elevators_amount) ?> шт.,</span> <?= valuesCompare(min($elevators_types), max($elevators_types)) ?> т
                                                                                                                        <? } else { ?>
                                                                                                                            -
                                                                                                                        <? } ?>
                                                                                                                    </div>
                                                                                                                </li>
                                                                                                                <li>
                                                                                                                    <?
                                                                                                                    $elevators = $obj_block->getJsonField('cranes_cathead');
                                                                                                                    $amount = count($elevators);

                                                                                                                    $elevators_types = [];
                                                                                                                    $elevators_amount = [];

                                                                                                                    for ($i = 0; $i < $amount; $i = $i + 2) {
                                                                                                                        if (!in_array($elevators[$i + 1], $elevators_types) && $elevators[$i + 1] != 0) {
                                                                                                                            $elevators_types[] = $elevators[$i + 1];
                                                                                                                        }
                                                                                                                        $elevators_amount[] =  $elevators[$i];
                                                                                                                    }

                                                                                                                    ?>
                                                                                                                    <div>
                                                                                                                        Кран-балки
                                                                                                                    </div>
                                                                                                                    <div>
                                                                                                                        <? if (count($elevators)) { ?>
                                                                                                                            <span class="ghost"><?= array_sum($elevators_amount) ?> шт.,</span> <?= valuesCompare(min($elevators_types), max($elevators_types)) ?> т
                                                                                                                        <? } else { ?>
                                                                                                                            -
                                                                                                                        <? } ?>
                                                                                                                    </div>
                                                                                                                </li>
                                                                                                                <li>
                                                                                                                    <?
                                                                                                                    $elevators = $obj_block->getJsonField('cranes_overhead');
                                                                                                                    $amount = count($elevators);

                                                                                                                    $elevators_types = [];
                                                                                                                    $elevators_amount = [];

                                                                                                                    for ($i = 0; $i < $amount; $i = $i + 2) {
                                                                                                                        if (!in_array($elevators[$i + 1], $elevators_types) && $elevators[$i + 1] != 0) {
                                                                                                                            $elevators_types[] = $elevators[$i + 1];
                                                                                                                        }
                                                                                                                        $elevators_amount[] =  $elevators[$i];
                                                                                                                    }

                                                                                                                    ?>
                                                                                                                    <div>
                                                                                                                        Мостовые краны
                                                                                                                    </div>
                                                                                                                    <div>
                                                                                                                        <? if (count($elevators)) { ?>
                                                                                                                            <span class="ghost"><?= array_sum($elevators_amount) ?> шт.,</span> <?= valuesCompare(min($elevators_types), max($elevators_types)) ?> т
                                                                                                                        <? } else { ?>
                                                                                                                            -
                                                                                                                        <? } ?>
                                                                                                                    </div>
                                                                                                                </li>
                                                                                                                <li>
                                                                                                                    <?
                                                                                                                    $elevators = $obj_block->getJsonField('telphers');
                                                                                                                    $amount = count($elevators);

                                                                                                                    $elevators_types = [];
                                                                                                                    $elevators_amount = [];

                                                                                                                    for ($i = 0; $i < $amount; $i = $i + 2) {
                                                                                                                        if (!in_array($elevators[$i + 1], $elevators_types) && $elevators[$i + 1] != 0) {
                                                                                                                            $elevators_types[] = $elevators[$i + 1];
                                                                                                                        }
                                                                                                                        $elevators_amount[] =  $elevators[$i];
                                                                                                                    }

                                                                                                                    ?>
                                                                                                                    <div>
                                                                                                                        Тельферы
                                                                                                                    </div>
                                                                                                                    <div>
                                                                                                                        <? if (count($elevators)) { ?>
                                                                                                                            <span class="ghost"><?= array_sum($elevators_amount) ?> шт.,</span> <?= valuesCompare(min($elevators_types), max($elevators_types)) ?> т
                                                                                                                        <? } else { ?>
                                                                                                                            -
                                                                                                                        <? } ?>
                                                                                                                    </div>
                                                                                                                </li>
                                                                                                                <li>
                                                                                                                    <div>
                                                                                                                        Подкрановые пути
                                                                                                                    </div>
                                                                                                                    <div>
                                                                                                                        <? $warehouse_equipment = $offer->getOfferBlocksMaxSumValue('cranes_runways') ?>
                                                                                                                        <?= ($warehouse_equipment) ? 'есть' : '-' ?> <?= ($warehouse_equipment && (($warehouse_equipment / $offer->subItemsActiveCount()) < 1)) ? ', частично' : '' ?>
                                                                                                                    </div>
                                                                                                                </li>
                                                                                                            </ul>
                                                                                                        </div>
                                                                                                        <div>
                                                                                                            <div>
                                                                                                                <div class="isBold box-wide">
                                                                                                                    Фото
                                                                                                                </div>
                                                                                                                <div>
                                                                                                                    <div class="flex-box flex-wrap">
                                                                                                                        <? $i = 1 ?>
                                                                                                                        <? foreach ($obj_block->getJsonField('photo_block') as $photo) { ?>
                                                                                                                            <? $photo = array_pop(explode('/', str_replace('//', '/', $photo))) ?>
                                                                                                                            <div class="box-small">
                                                                                                                                <div class="background-fix modal-call-btn" data-modal="photo-slider" data-modal-size="modal-big" data-id="<?= $photo ?>" data-table="" data-names='["post_id","table_id","photo_field","slide_num"]' data-values='[<?= $offer->postId() ?>,<?= $offer->setTableId() ?>,"photo_block",<?= $i ?>]' style="width: 140px; height: 70px; background: url('<?= PROJECT_URL . '/system/controllers/photos/thumb.php/300/' . $object->postId() . '/' . $photo ?>')">

                                                                                                                                </div>
                                                                                                                            </div>
                                                                                                                            <? $i++ ?>
                                                                                                                        <? } ?>
                                                                                                                    </div>
                                                                                                                </div>
                                                                                                            </div>
                                                                                                            <div class="box-small">
                                                                                                                <div class="isBold">
                                                                                                                    Описание
                                                                                                                </div>
                                                                                                                <div>
                                                                                                                    <?= $obj_block->getField('description') ?? $obj_block->getField('description_auto') ?>
                                                                                                                </div>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="tab-content" style="background: white;">
                                                                                                    <div class="card-blocks-area text_left  tabs-block box-vertical " style="max-width: 1600px;">
                                                                                                        <div class="flex-box flex-vertical-top">
                                                                                                            <div class="card-blocks-base " style=" width: 250px">
                                                                                                                <div class="box" style="background: #e1e1e1">
                                                                                                                    <b>Этаж</b>
                                                                                                                </div>
                                                                                                                <div style="border: 1px solid #ffffff">
                                                                                                                    <div class="obj-block-stats" style="border-bottom: 1px solid #cfcfcf;">
                                                                                                                        <ul>
                                                                                                                            <li><b>Площади</b></li>
                                                                                                                            <li>S - пола <span> *</span></li>
                                                                                                                            <li>S - офиснов</li>
                                                                                                                            <li>S - техническая</li>
                                                                                                                            <li>Кол-во палет-мест</li>
                                                                                                                        </ul>
                                                                                                                        <ul>
                                                                                                                            <li><b>Назначения</b></li>
                                                                                                                            <li>---</li>
                                                                                                                        </ul>
                                                                                                                        <ul>
                                                                                                                            <li><b>Характеристики</b></li>
                                                                                                                            <li>Высота рабочая<span> *</span></li>
                                                                                                                            <li class="block-info-floor-types">Тип пола: <span> *</span></li>
                                                                                                                            <li>Нагрузка на пол:</li>
                                                                                                                            <li class="block-info-grid-types">Сетка колонн</li>
                                                                                                                            <li class="block-info-gates">Тип/кол-во ворот<span> *</span></li>
                                                                                                                            <li>Вход в блок</li>
                                                                                                                            <li>Темперетурный режим</li>




                                                                                                                            <li>Габариты участка</li>
                                                                                                                            <li>Рельеф участка</li>
                                                                                                                        </ul>
                                                                                                                        <ul>
                                                                                                                            <li><b>Оборудование</b></li>
                                                                                                                            <li>Стеллажи</li>
                                                                                                                            <li class="block-info-racks">Тип стеллажей</li>
                                                                                                                            <li class="block-info-safe-types">Тип хранения</li>
                                                                                                                            <li>Ячейки</li>
                                                                                                                            <li>Зарядная комната </li>
                                                                                                                            <li>Складская техника </li>
                                                                                                                        </ul>
                                                                                                                        <ul>
                                                                                                                            <li><b>Коммуникации</b></li>
                                                                                                                            <li>Доступная мощность</li>
                                                                                                                            <li>Освещение</li>
                                                                                                                            <li>Отопление</li>
                                                                                                                            <li>Вид отопления</li>
                                                                                                                            <li>Водоснабжение</li>
                                                                                                                            <li>Канализация</li>
                                                                                                                            <li>Вентиляция</li>
                                                                                                                            <li>Климат-контроль</li>
                                                                                                                            <li>Газа для производства</li>
                                                                                                                            <li>Пар для производства</li>
                                                                                                                            <li>Интернет</li>
                                                                                                                            <li>Телефония</li>
                                                                                                                        </ul>
                                                                                                                        <ul>
                                                                                                                            <li><b>Подъемные устройства</b></li>
                                                                                                                            <li class="block-info-elevators">Лифты/подъемники</li>
                                                                                                                            <li class="block-info-cranes_cathead">Кран-балки</li>
                                                                                                                            <li class="block-info-cranes_overhead">Мостовые краны</li>
                                                                                                                            <li class="block-info-telphers">Тельферы</li>
                                                                                                                            <li>Подкрановые пути </li>

                                                                                                                        </ul>
                                                                                                                    </div>
                                                                                                                </div>
                                                                                                            </div>
                                                                                                            <div class="card-blocks-list flex-box flex-vertical-top">
                                                                                                                <? $parts = $obj_block->getJsonField('parts') ?>
                                                                                                                <?




                                                                                                                $parts_line = implode(',', $parts);
                                                                                                                if (!$parts_line) {
                                                                                                                    $parts_line = 0;
                                                                                                                }
                                                                                                                $sql = $pdo->prepare("SELECT * FROM c_industry_parts p LEFT JOIN c_industry_floors f ON p.floor_id=f.id LEFT JOIN l_floor_nums n ON f.floor_num_id=n.id WHERE p.id IN($parts_line) ORDER BY n.order_row ");
                                                                                                                $sql->execute();
                                                                                                                while ($part = $sql->fetch(PDO::FETCH_LAZY)) { ?>
                                                                                                                    <? $part = new Part($part->id) ?>

                                                                                                                    <div class="flex-box flex-vertical-top tab stack-block <?= ($obj_block->getField('status') == 2) ? 'ghost' : '' ?>">
                                                                                                                        <div id="subitem-<?= $obj_block->postId() ?>" class="object-block " style="width: 200px ;">
                                                                                                                            <div class="box " style="background: <?= $part->getFloorColor() ?>; color: #FFFFFF;">
                                                                                                                                <?= $part->getFloorName() ?>
                                                                                                                            </div>
                                                                                                                            <div class="block_stats" style="border: 1px solid #79a768">
                                                                                                                                <div class="wer obj-block-stats" style="border-bottom: 1px solid #cfcfcf; position: relative;">
                                                                                                                                    <ul>
                                                                                                                                        <li>
                                                                                                                                            &#160;
                                                                                                                                        </li>
                                                                                                                                        <li>
                                                                                                                                            <? if (in_array($part->getFloorNumId(), [16])) {
                                                                                                                                                $area_min = $part->getField('area_field_min');
                                                                                                                                                $area_max = $part->getField('area_field_max');
                                                                                                                                            } elseif (in_array($part->getFloorNumId(), [2, 3, 4, 5])) {
                                                                                                                                                $area_min = $part->getField('area_mezzanine_min');
                                                                                                                                                $area_max = $part->getField('area_mezzanine_max');
                                                                                                                                            } else {
                                                                                                                                                $area_min = $part->getField('area_floor_min');
                                                                                                                                                $area_max = $part->getField('area_floor_max');
                                                                                                                                            } ?>
                                                                                                                                            <b>
                                                                                                                                                <?= valuesCompare($area_min, $area_max) ?> <span>м<sup>2</sup></span>
                                                                                                                                            </b>
                                                                                                                                        </li>

                                                                                                                                        <li>
                                                                                                                                            <? if ($part->getField('area_office_min')) { ?>
                                                                                                                                                <?= valuesCompare($part->getField('area_office_min'), $part->getField('area_office_max')) ?> <span>м<sup>2</sup>
                                                                                                                                                <? } else { ?>
                                                                                                                                                    -
                                                                                                                                                <? } ?>
                                                                                                                                        </li>
                                                                                                                                        <li>
                                                                                                                                            <? if ($part->getField('area_tech_min')) { ?>
                                                                                                                                                <?= valuesCompare($part->getField('area_tech_min'), $part->getField('area_tech_max')) ?> <span>м<sup>2</sup> <?= ($obj_block->getField('area_office_add')) ? '<span style="color: red;">вмен.</span>' : '' ?></span>
                                                                                                                                            <? } else { ?>
                                                                                                                                                -
                                                                                                                                            <? } ?>
                                                                                                                                        </li>
                                                                                                                                        <li>
                                                                                                                                            <? if ($part->getField('pallet_place_min')) { ?>
                                                                                                                                                <?= valuesCompare($part->getField('pallet_place_min'), $part->getField('pallet_place_max')) ?> п.м.
                                                                                                                                            <? } else { ?>
                                                                                                                                                -
                                                                                                                                            <? } ?>
                                                                                                                                        </li>
                                                                                                                                    </ul>
                                                                                                                                    <ul>
                                                                                                                                        <li style="height: 47px;">
                                                                                                                                            <div>
                                                                                                                                                <? if (arrayIsNotEmpty($part->getJsonField('purposes_block'))) { ?>
                                                                                                                                                    <? foreach ($part->getJsonField('purposes_block') as $purpose) { ?>
                                                                                                                                                        <?
                                                                                                                                                        $purpose = new Post((int)$purpose);
                                                                                                                                                        $purpose->getTable('l_purposes');
                                                                                                                                                        ?>
                                                                                                                                                        <div class="icon-square">
                                                                                                                                                            <a href="#" title="<?= $purpose->title() ?>"><?= $purpose->getField('icon') ?></a>
                                                                                                                                                        </div>
                                                                                                                                                    <? } ?>
                                                                                                                                                <? } ?>
                                                                                                                                            </div>
                                                                                                                                        </li>
                                                                                                                                    </ul>
                                                                                                                                    <ul>
                                                                                                                                        <li>&#160;</li>
                                                                                                                                        <li>
                                                                                                                                            <? if ($part->getField('ceiling_height_min')) { ?>
                                                                                                                                                <?= valuesCompare($part->getField('ceiling_height_min'), $part->getField('ceiling_height_max')) ?> м
                                                                                                                                            <? } else { ?>
                                                                                                                                                -
                                                                                                                                            <? } ?>
                                                                                                                                        </li>
                                                                                                                                        <li class="block-info-floor-types">
                                                                                                                                            <? if ($part->getField('floor_types')) {
                                                                                                                                                $floor_type = 'floor_types';
                                                                                                                                                $floor_type_table = 'l_floor_types';
                                                                                                                                            } elseif ($part->getField('floor_types_land')) {
                                                                                                                                                $floor_type = 'floor_types_land';
                                                                                                                                                $floor_type_table = 'l_floor_types_land';
                                                                                                                                            } else {
                                                                                                                                                $floor_type = 0;
                                                                                                                                                $floor_type_table = '';
                                                                                                                                            } ?>
                                                                                                                                            <? if ($floor_type) { ?>
                                                                                                                                                <? foreach ($part->getJsonField($floor_type) as $type) { ?>
                                                                                                                                                    <? $rack = new Post($type) ?>
                                                                                                                                                    <? $rack->getTable($floor_type_table) ?>
                                                                                                                                                    <div>
                                                                                                                                                        <?= $rack->title() ?>
                                                                                                                                                    </div>
                                                                                                                                                <? } ?>
                                                                                                                                            <? } else { ?>
                                                                                                                                                -
                                                                                                                                            <? } ?>
                                                                                                                                        </li>
                                                                                                                                        <li>
                                                                                                                                            <? if (in_array($part->getFloorNumId(), [2, 3, 4, 5])) {
                                                                                                                                                $load = valuesCompare($part->getField('load_mezzanine_min'), $part->getField('load_mezzanine_max'));
                                                                                                                                            } else {
                                                                                                                                                $load = valuesCompare($part->getField('load_floor_min'), $part->getField('load_floor_max'));
                                                                                                                                            } ?>
                                                                                                                                            <? if ($load) { ?>
                                                                                                                                                <?= $load ?> <span class="degree-fix">т/м<sup>2</sup></span>
                                                                                                                                            <? } else { ?>
                                                                                                                                                -
                                                                                                                                            <? } ?>
                                                                                                                                        </li>
                                                                                                                                        <li class="block-info-grid-types">
                                                                                                                                            <? if (arrayIsNotEmpty($part->getJsonField('column_grids'))) { ?>
                                                                                                                                                <? foreach ($part->getJsonField('column_grids') as $type) { ?>
                                                                                                                                                    <? $rack = new Post($type) ?>
                                                                                                                                                    <? $rack->getTable('l_pillars_grid') ?>
                                                                                                                                                    <div>
                                                                                                                                                        <?= $rack->title() ?>
                                                                                                                                                    </div>
                                                                                                                                                <? } ?>
                                                                                                                                            <? } else { ?>
                                                                                                                                                -
                                                                                                                                            <? } ?>
                                                                                                                                        </li>
                                                                                                                                        <?
                                                                                                                                        $gates = $part->getJsonField('gates');
                                                                                                                                        $gate_types = [];
                                                                                                                                        $amount = count($gates);
                                                                                                                                        for ($i = 0; $i < $amount; $i = $i + 2) {
                                                                                                                                            if ($gate_types[$gates[$i]]) {
                                                                                                                                                $gate_types[$gates[$i]] += $gates[$i + 1];
                                                                                                                                            } else {
                                                                                                                                                $gate_types[$gates[$i]] = $gates[$i + 1];
                                                                                                                                            }
                                                                                                                                        }
                                                                                                                                        ?>
                                                                                                                                        <li class="block-info-gates">
                                                                                                                                            <? if ($gates && $gate_types) { ?>
                                                                                                                                                <? foreach ($gate_types as $key => $value) { ?>
                                                                                                                                                    <?
                                                                                                                                                    $gate = new Post($key);
                                                                                                                                                    $gate->getTable('l_gates_types');
                                                                                                                                                    ?>
                                                                                                                                                    <div class="flex-box">
                                                                                                                                                        <div class="ghost"><?= $value ?> шт /</div>
                                                                                                                                                        <div><?= $gate->title() ?></div>
                                                                                                                                                    </div>
                                                                                                                                                <? } ?>
                                                                                                                                            <? } else { ?>
                                                                                                                                                -
                                                                                                                                            <? } ?>
                                                                                                                                        </li>
                                                                                                                                        <li>
                                                                                                                                            <? if ($part->getField('enterance_block')) { ?>
                                                                                                                                                <?
                                                                                                                                                $enterance_block = new Post($part->getField('enterance_block'));
                                                                                                                                                $enterance_block->getTable('l_enterances');
                                                                                                                                                ?>
                                                                                                                                                <?= $enterance_block->title() ?>
                                                                                                                                            <? } else { ?>
                                                                                                                                                -
                                                                                                                                            <? } ?>
                                                                                                                                        </li>

                                                                                                                                        <li>
                                                                                                                                            <? if ($part->getField('heated') == 1) { ?>
                                                                                                                                                тёплый
                                                                                                                                            <? } else { ?>
                                                                                                                                                -
                                                                                                                                            <? } ?>
                                                                                                                                            <? if ($temp_min = $part->getField('temperature_min')) { ?>
                                                                                                                                                <?= ($temp_min > 0) ? '+' : '' ?>
                                                                                                                                                <?= $temp_min ?>
                                                                                                                                                &#176;С
                                                                                                                                            <? } ?>

                                                                                                                                            <? if ($temp_max = $part->getField('temperature_max')) { ?>
                                                                                                                                                /
                                                                                                                                                <?= ($temp_max > 0) ? '+' : '' ?>
                                                                                                                                                <?= $temp_max ?>
                                                                                                                                                &#176;С
                                                                                                                                            <? } ?>
                                                                                                                                        </li>
                                                                                                                                        <li>
                                                                                                                                            <? if ($part->getField('land_length') && $part->getField('land_width')) { ?>
                                                                                                                                                <?= $part->getField('land_length') ?><i class="fal fa-times"></i><?= $part->getField('land_width') ?> м.
                                                                                                                                            <? } else { ?>
                                                                                                                                                -
                                                                                                                                            <? } ?>
                                                                                                                                        </li>
                                                                                                                                        <li>
                                                                                                                                            <?= ($part->getField('landscape_type')) ? $part->landscapeType() :  '-' ?>
                                                                                                                                        </li>
                                                                                                                                    </ul>
                                                                                                                                    <ul>
                                                                                                                                        <li>&#160;</li>
                                                                                                                                        <li><?= ($part->getField('racks')) ? 'есть' : '-' ?></li>
                                                                                                                                        <li class="block-info-racks">
                                                                                                                                            <? if ($part->getField('rack_types')) { ?>
                                                                                                                                                <? foreach ($part->getJsonField('rack_types') as $type) { ?>
                                                                                                                                                    <? $rack = new Post($type) ?>
                                                                                                                                                    <? $rack->getTable('l_racks_types') ?>
                                                                                                                                                    <div>
                                                                                                                                                        <?= $rack->title() ?>
                                                                                                                                                    </div>
                                                                                                                                                <? } ?>
                                                                                                                                            <? } else { ?>
                                                                                                                                                -
                                                                                                                                            <? } ?>
                                                                                                                                        </li>
                                                                                                                                        <li class="block-info-safe-types">
                                                                                                                                            <? if ($part->getField('safe_type')) { ?>
                                                                                                                                                <? foreach ($part->getJsonField('safe_type') as $type) { ?>
                                                                                                                                                    <? $safe_type = new Post($type) ?>
                                                                                                                                                    <? $safe_type->getTable('l_safe_types') ?>
                                                                                                                                                    <div>
                                                                                                                                                        <?= $safe_type->title() ?>
                                                                                                                                                    </div>
                                                                                                                                                <? } ?>
                                                                                                                                            <? } else { ?>
                                                                                                                                                -
                                                                                                                                            <? } ?>
                                                                                                                                        </li>
                                                                                                                                        <li><?= ($part->getField('cells')) ? 'есть' : '-' ?></li>
                                                                                                                                        <li><?= ($part->getField('charging_room')) ? 'есть' : '-' ?></li>
                                                                                                                                        <li><?= ($part->getField('warehouse_equipment')) ? 'есть' : '-' ?></li>
                                                                                                                                    </ul>
                                                                                                                                    <ul>
                                                                                                                                        <li>&#160;</li>
                                                                                                                                        <li>
                                                                                                                                            <? if ($power = $part->getField('power')) { ?>
                                                                                                                                                <?= $power ?> кВт
                                                                                                                                            <? } else { ?>
                                                                                                                                                -
                                                                                                                                            <? } ?>
                                                                                                                                        </li>
                                                                                                                                        <li><?= ($part->getField('cells1')) ? 'есть' : '-' ?></li>
                                                                                                                                        <li><?= ($part->getField('cells1')) ? 'есть' : '-' ?></li>
                                                                                                                                        <li><?= ($part->getField('cells1')) ? 'есть' : '-' ?></li>
                                                                                                                                        <li><?= ($part->getField('cells1')) ? 'есть' : '-' ?></li>
                                                                                                                                        <li><?= ($part->getField('cells1')) ? 'есть' : '-' ?></li>
                                                                                                                                        <li><?= ($part->getField('cells1')) ? 'есть' : '-' ?></li>
                                                                                                                                        <li><?= ($part->getField('climate_control')) ? 'есть' : '-' ?></li>
                                                                                                                                        <li><?= ($part->getField('gas')) ? 'есть' : '-' ?></li>
                                                                                                                                        <li><?= ($part->getField('steam')) ? 'есть' : '-' ?></li>
                                                                                                                                        <li><?= ($part->getField('internet')) ? 'есть' : '-' ?></li>
                                                                                                                                        <li><?= ($part->getField('phone_line')) ? 'есть' : '-' ?></li>
                                                                                                                                    </ul>
                                                                                                                                    <ul>
                                                                                                                                        <li>&#160;</li>
                                                                                                                                        <?
                                                                                                                                        $cranes = ['elevators', 'cranes_cathead', 'cranes_overhead', 'telphers'];

                                                                                                                                        foreach ($cranes as $crane) {
                                                                                                                                            $items = $part->getJsonField($crane);
                                                                                                                                            $types = [];
                                                                                                                                            $sorted_arr = [];

                                                                                                                                            for ($i = 0; $i < count($items); $i = $i + 2) {
                                                                                                                                                if (!in_array($items[$i + 1], $types) && $items[$i + 1] != 0) {
                                                                                                                                                    array_push($types, $items[$i + 1]);
                                                                                                                                                }
                                                                                                                                            }

                                                                                                                                            //var_dump($types);

                                                                                                                                            //подсчитываем колво каждого типа
                                                                                                                                            foreach ($types as $elem_unique) {
                                                                                                                                                for ($i = 0; $i < count($items); $i = $i + 2) {
                                                                                                                                                    if ($items[$i + 1] == $elem_unique) {
                                                                                                                                                        $sorted_arr[$elem_unique] += $items[$i];
                                                                                                                                                    }
                                                                                                                                                }
                                                                                                                                            }
                                                                                                                                        ?>

                                                                                                                                            <li class="block-info-<?= $crane ?>">
                                                                                                                                                <? if ($sorted_arr) { ?>
                                                                                                                                                    <? foreach ($sorted_arr as $key => $value) { ?>
                                                                                                                                                        <div class="flex-box">
                                                                                                                                                            <div class="ghost"><?= $value ?> шт /</div>
                                                                                                                                                            <div><?= $key ?> т.</div>
                                                                                                                                                        </div>
                                                                                                                                                    <? } ?>
                                                                                                                                                <? } else { ?>
                                                                                                                                                    -
                                                                                                                                                <? } ?>
                                                                                                                                            </li>

                                                                                                                                        <? } ?>
                                                                                                                                        <li><?= ($part->getField('cranes_runways')) ? 'есть' : '-' ?></li>
                                                                                                                                    </ul>
                                                                                                                                </div>
                                                                                                                            </div>
                                                                                                                        </div>
                                                                                                                    </div>
                                                                                                                <? } ?>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="tab-content">
                                                                                                    <div class="box">
                                                                                                        Loadinnn.....
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="tab-content">
                                                                                                    <div class="box">
                                                                                                        Loadinnn.....
                                                                                                    </div>
                                                                                                </div>
                                                                                                <? if ($obj_block->hasDeal()) { ?>
                                                                                                    <div class="tab-content">
                                                                                                        <div class="box">
                                                                                                            Loadinnn.....
                                                                                                        </div>
                                                                                                    </div>
                                                                                                <? } ?>

                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            <? } ?>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                        <? } ?>
                                                    </div>
                                                    <div style="padding-top: 20px; min-width: 350px;" class="card-contacts-area full-height one_fourth no-shrink">
                                                        <div class="box">
                                                            <? if ($offer->getField('tax_form')) { ?>
                                                                <h1>
                                                                    <?= getPostTitle($offer->getField('tax_form'), 'l_tax_form') ?>
                                                                </h1>
                                                            <? } ?>
                                                            <? if ($offer->getField('deal_type') == 2 && $offer->getField('sale_company')) { ?>
                                                                <div class="box-vertical">
                                                                    <div class="icon-orthogonal" title="готов продать компанию">
                                                                        <i class="fas fa-users"></i>
                                                                    </div>
                                                                </div>
                                                            <? } ?>
                                                        </div>
                                                        <div class="box">
                                                            <? if ($offer->getField('deal_type') == 1 || $offer->getField('deal_type') == 4) { ?>
                                                                <div>
                                                                    <b>
                                                                        Эксплуатация :
                                                                    </b>
                                                                    <b class="attention">
                                                                        <?= getPostTitle($offer->getField('price_opex'), 'l_taxes_info') ?>
                                                                    </b>
                                                                </div>
                                                                <? if ($offer->getField('price_opex') == 2) { ?>
                                                                    <div class="flex-box icon-rov">
                                                                        <? foreach ($offer->getJsonField('inc_opex') as $incOpex) { ?>
                                                                            <? $inc_obj = new Post($incOpex) ?>
                                                                            <? $inc_obj->getTable('l_inc_opex') ?>
                                                                            <div style="margin: 3px;">
                                                                                <div class="icon-orthogonal full-width" title="<?= $inc_obj->title() ?>">
                                                                                    <?= $inc_obj->getField('title_short') ?>
                                                                                </div>
                                                                            </div>
                                                                        <? } ?>
                                                                    </div>
                                                                <? } ?>

                                                                <div>
                                                                    <b>
                                                                        Коммуналка :
                                                                    </b>
                                                                    <b class="attention">
                                                                        <?= getPostTitle($offer->getField('public_services'), 'l_taxes_info') ?>
                                                                    </b>
                                                                </div>
                                                                <? if ($offer->getField('public_services') == 2) { ?>
                                                                    <div class="flex-box icon-rov">
                                                                        <? foreach ($offer->getJsonField('inc_services') as $incService) { ?>
                                                                            <? $inc_obj = new Post($incService) ?>
                                                                            <? $inc_obj->getTable('l_inc_services') ?>
                                                                            <div style="margin: 3px;">
                                                                                <div class="icon-orthogonal full-width" title="<?= $inc_obj->title() ?>">
                                                                                    <?= $inc_obj->getField('title_short') ?>
                                                                                </div>
                                                                            </div>
                                                                        <? } ?>
                                                                    </div>
                                                                <? } ?>
                                                            <? } ?>

                                                            <? if ((($offer->getField('deal_type') == 1 || $offer->getField('deal_type') == 4)) && ($offer->getField('price_opex') == 3 || $offer->getField('public_services') == 3)) { ?>
                                                                <div class="">
                                                                    <div>
                                                                        <b>
                                                                            Дополнителнительные расходы
                                                                        </b>
                                                                    </div>
                                                                    <div>

                                                                    </div>
                                                                    <? if ($offer->getField('price_opex') == 3) { ?>
                                                                        <div class="flex-box">
                                                                            <div>
                                                                                OPEX
                                                                            </div>
                                                                            <div class="to-end ">
                                                                                <? if ($offer->getField('price_opex_value')) { ?>
                                                                                    <?= $offer->getField('price_opex_value') ?> <span class="ghost"><i class="fas fa-ruble-sign "></i> м<sup>2</sup>/год</span>
                                                                                <? } else { ?>
                                                                                    -
                                                                                <? } ?>
                                                                            </div>
                                                                        </div>
                                                                    <? } ?>
                                                                    <? if ($offer->getField('public_services') == 3) { ?>
                                                                        <div class="flex-box">
                                                                            <div>
                                                                                Ком. платежи
                                                                            </div>
                                                                            <div class="to-end">
                                                                                <? if ($offer->getField('price_public_services')) { ?>
                                                                                    <?= $offer->getField('price_public_services') ?> <span class="ghost"> <i class="fas fa-ruble-sign "></i> м<sup>2</sup>/год</span>
                                                                                <? } else { ?>
                                                                                    -
                                                                                <? } ?>
                                                                            </div>
                                                                        </div>
                                                                    <? } ?>
                                                                </div>
                                                            <? } ?>
                                                            <? if ($offer->getField('deal_type') == 1 ||  $offer->getField('deal_type') == 4) { ?>
                                                                <div class="">
                                                                    <div>
                                                                        <b>
                                                                            Особые условия
                                                                        </b>
                                                                    </div>

                                                                    <div class="flex-box">
                                                                        <div>
                                                                            Каникулы
                                                                        </div>
                                                                        <div class="to-end">
                                                                            <? if ($offer->getField('holidays')) { ?>
                                                                                да
                                                                            <? } else { ?>
                                                                                -
                                                                            <? } ?>
                                                                            <? if ($offer->getField('holidays_value_min')) { ?>
                                                                                , <?= valuesCompare($offer->getField('holidays_value_min'), $offer->getField('holidays_value_max')) ?> <span> мес. </span>
                                                                            <? } ?>
                                                                        </div>
                                                                    </div>

                                                                    <div class="flex-box">
                                                                        <div>
                                                                            Депозит
                                                                        </div>
                                                                        <div class="to-end">
                                                                            <? if ($offer->getField('deposit')) { ?>
                                                                                да
                                                                            <? } else { ?>
                                                                                -
                                                                            <? } ?>
                                                                            <? if ($offer->getField('deposit_value')) { ?>
                                                                                , <?= $offer->getField('deposit_value') ?> <span>мес.</span>
                                                                            <? } ?>
                                                                        </div>
                                                                    </div>

                                                                    <div class="flex-box">
                                                                        <div>
                                                                            Залоговый пл.
                                                                        </div>
                                                                        <div class="to-end">
                                                                            <? if ($offer->getField('pledge') == 1) { ?>
                                                                                да
                                                                            <? } else { ?>
                                                                                -
                                                                            <? } ?>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            <? } ?>
                                                        </div>

                                                        <? if ($offer->getField('rent_business')) { ?>
                                                            <div class="box">
                                                                <div class="">
                                                                    <? if ($offer->getField('built_to_suit')) { ?>
                                                                        <div class="attention" style="font-size: 15px;">
                                                                            <div class="flex-box">
                                                                                <div>
                                                                                    <i class="fal fa-paint-roller"></i>
                                                                                    <span class="isBold box-small-wide">
                                                                                        Арендный бизнес
                                                                                    </span>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    <? } ?>
                                                                </div>
                                                                <div class="">
                                                                    <?
                                                                    $arr = [
                                                                        ['rent_business_fill', '% заполненности объекта', '%'],
                                                                        ['rent_business_price', 'средняя ставка аренды', 'Р м кв/год'],
                                                                        ['rent_business_long_contracts', '% долгих контрактов', ''],
                                                                        ['rent_business_last_repair', 'год последнего капремонта', 'год'],
                                                                        ['rent_business_payback', 'срок окупаемости', 'лет'],
                                                                        ['rent_business_income', 'EBITDA', 'Р м кв/год'],
                                                                        ['rent_business_profit', 'чистая прибыль', 'Р м кв/год'],
                                                                    ]

                                                                    ?>
                                                                    <? foreach ($arr as $item) { ?>
                                                                        <? if ($offer->getField($item[0])) { ?>
                                                                            <div class="flex-box">
                                                                                <div>
                                                                                    <?= $item[1] ?>
                                                                                </div>
                                                                                <div class="to-end">
                                                                                    <?= $offer->getField($item[0]) ?> <span class="ghost"><?= $item[2] ?></span>
                                                                                </div>
                                                                            </div>
                                                                        <? } ?>
                                                                    <? } ?>
                                                                </div>
                                                            </div>
                                                        <? } ?>
                                                        <div data-company_id="<?= $offer->getField('company_id') ?>" data-contact_id="<?= $offer->getField('contact_id') ?>" class="offer-company-injector-container card-contacts-area-inner flex-box box text_left flex-box-verical flex-between flex-box-to-left" style="background: #e6eedd;">

                                                        </div>
                                                        <div class="card-brocker-area">
                                                            <div class="card-brocker-area-inner  text_left flex-box flex-vertical-top ">
                                                                <div class="full-width">
                                                                    <? if ($offer->getField('contract_is_signed_type') == 2) { ?>
                                                                        <div class="box isBold attention" style="border-bottom: 1px solid #efd4d6; font-size: 16px;">
                                                                            <i class="fas fa-trophy"></i> Эксклюзив!!!
                                                                        </div>
                                                                    <? } ?>
                                                                    <? if ($offer->getField('contract_is_signed') == 1) { ?>
                                                                        <div class="calm box flex-box-inline">
                                                                            контракт подписан
                                                                        </div>
                                                                    <? } ?>
                                                                    <div class="box" style="border-bottom: 1px solid #efd4d6; background: #fcefef;">
                                                                        <? if (!$offer->getField('dont_pay')) { ?>
                                                                            <? if ($offer->getField('commission_owner') == 1 || $offer->getField('commission_client') == 1) { ?>
                                                                                <div>
                                                                                    <b>
                                                                                        Комиссия
                                                                                    </b>
                                                                                </div>
                                                                            <? } elseif ($offer->getField('commission_owner') == 2) { ?>
                                                                                <div>
                                                                                    <b>
                                                                                        Собственник не платит
                                                                                    </b>
                                                                                </div>
                                                                            <? } ?>
                                                                            <div class="card-agent-history">
                                                                                <ul>
                                                                                    <? if ($offer->getField('commission_owner') == 1) { ?>
                                                                                        <li>
                                                                                            <div class="attention flex-box-inline">
                                                                                                комиссия от собственника <?= $offer->getField('commission_owner_value') ?>%
                                                                                                <? if ($com_type = $offer->getField('commission_owner_type')) { ?>
                                                                                                    <span class="isBold">
                                                                                                        <?= getPostTitle($com_type, 'l_commission_types') ?>
                                                                                                    </span>
                                                                                                <? } ?>
                                                                                            </div>
                                                                                        </li>
                                                                                    <? } ?>
                                                                                    <? if ($com_client = $offer->getField('commission_client') == 1) { ?>
                                                                                        <li>
                                                                                            <div class="attention flex-box-inline">
                                                                                                комиссия для клиента <?= $offer->getField('commission_client_value') ?>%
                                                                                            </div>
                                                                                        </li>
                                                                                    <? } ?>
                                                                                    <? if ($com_agent = $offer->getField('commission_agent') == 1) { ?>
                                                                                        <li>
                                                                                            <div class="attention flex-box-inline">
                                                                                                комиссия агенту <?= $offer->getField('commission_agent_value') ?>%
                                                                                            </div>
                                                                                        </li>
                                                                                    <? } ?>
                                                                                    <? if ($offer->getField('site_show')) { ?>
                                                                                        <li> показывается на сайте</li>
                                                                                    <? } ?>
                                                                                    <? if ($offer->getField('site_show_top')) { ?>
                                                                                        <li> спецпредложение</li>
                                                                                    <? } ?>
                                                                                    <? if ($offer->getField('site_price_hide')) { ?>
                                                                                        <li> скрыл цену</li>
                                                                                    <? } ?>
                                                                                </ul>
                                                                            </div>
                                                                        <? } else { ?>
                                                                            <div class="attention">
                                                                                НЕ ПЛАТИТ !!!!!!
                                                                            </div>
                                                                        <? } ?>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <? //if ($logedUser->member_id() == 314) { 
                                                        ?>
                                                        <div class="box">
                                                            <?= $offer->getField('description') ? $offer->getField('description') : $offer->getField('description_auto') ?>
                                                        </div>
                                                        <? //} 
                                                        ?>
                                                    </div>
                                                </div>





                                                <!--БЛОКИ НОРМАЛЬНЫЕ -->
                                                <?/*
                                                <div class="card-blocks-area text_left  tabs-block " style="max-width: 1600px;">
                                                    <div class="flex-box flex-vertical-top">
                                                        <div class="card-blocks-base " style=" width: 250px">
                                                            <div class="box" style="background: #e1e1e1">
                                                                <b>Деление: <?=count($offer->subItems())?> блок(ов)</b>
                                                                <!--
                                                                <span style="color: #3b5998;" class="pointer modal-call-btn" data-form="<?=$deal_forms_blocks_arr[$object->getField('is_land')][$offer->getField('deal_type')-1]?>" data-id=""  data-modal="edit-all" data-table="<?=(new Subitem())->setTableId()?>"      data-names='["offer_id","object_id"]' data-values='[<?=$offer->getField('id')?>,<?=$offer->getField('object_id')?>]'  data-modal-size="modal-middle">
                                                                    <i class="fas fa-plus-circle"></i>
                                                                </span>
                                                                -->
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
                                                                            <li class="block-info-floor-types">Тип пола: <span> *</span></li>
                                                                            <li>Нагрузка на пол:</li>
                                                                            <li>Нагрузка на мезонин</li>
                                                                            <li class="block-info-grid-types">Сетка колонн</li>
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
                                                                        <div class="flex-box flex-vertical-top tab stack-block <?=($obj_block->getField('status') == 2 ) ? 'ghost' : ''?>">
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
                                                                                            <input class="parts-info" type="hidden" value='<?=$obj_block->getField('parts')?>'  />
                                                                                            ID <?=$obj_block->getVisualId()?>
                                                                                            <?if($_COOKIE['member_id'] == 941){

                                                                                                var_dump($obj_block->getBlockStacks());
                                                                                            }?>

                                                                                        </div>
                                                                                        <div>

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
                                                                                                <li><?= ($obj_block->getField('floor_type_land')) ? '-' :  '-'?></li>
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
                                                                                                <li class="block-info-floor-types">
                                                                                                    <?if($obj_block->getField('floor_type')) {?>
                                                                                                        <?foreach($obj_block->getJsonField('floor_type') as $type){?>
                                                                                                            <? $rack = new Post($type)?>
                                                                                                            <? $rack->getTable('l_floor_types')?>
                                                                                                            <div>
                                                                                                                <?=$rack->title()?>
                                                                                                            </div>
                                                                                                        <?}?>
                                                                                                    <?}else{?>
                                                                                                        -
                                                                                                    <?}?>
                                                                                                </li>
                                                                                                <li>
                                                                                                    <?if($obj_block->getField('load_floor_min')){?>
                                                                                                        <?= valuesCompare($obj_block->getField('load_floor_min'),$obj_block->getField('load_floor_max')) ?> <span class="degree-fix">т/м<sup>2</sup></span>
                                                                                                    <?}else{?>
                                                                                                        -
                                                                                                    <?}?>
                                                                                                </li>
                                                                                                <li>
                                                                                                    <?if($obj_block->getField('load_mezzanine_min')){?>
                                                                                                        <?= valuesCompare($obj_block->getField('load_mezzanine_min'),$obj_block->getField('load_mezzanine_max')) ?> <span class="degree-fix">т/м<sup>2</sup></span>
                                                                                                    <?}else{?>
                                                                                                        -
                                                                                                    <?}?>
                                                                                                </li>
                                                                                                <li class="block-info-grid-types">
                                                                                                    <?if(arrayIsNotEmpty($obj_block->getJsonField('column_grid'))) {?>
                                                                                                        <?foreach($obj_block->getJsonField('column_grid') as $type){?>
                                                                                                            <? $rack = new Post($type)?>
                                                                                                            <? $rack->getTable('l_pillars_grid')?>
                                                                                                            <div>
                                                                                                                <?=$rack->title()?>
                                                                                                            </div>
                                                                                                        <?}?>
                                                                                                    <?}else{?>
                                                                                                        -
                                                                                                    <?}?>
                                                                                                </li>
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
                                                                                                <?if(in_array($_COOKIE['member_id'],[141,150]) && !$obj_block->hasPartUnactive()){?>
                                                                                                    <div class="icon-round  modal-call-btn " <?if($obj_block->hasDeal()){?> style="background: limegreen; color: white;" title="Редактировать сделку"<?}?> title="Создать сделку" data-modal="edit-all" data-id="<?= $obj_block->getDealId()?>" data-table="<?=(new Deal())->setTableId()?>"  data-names='["block_id"]' data-values='[<?=$obj_block->postId()?>]'  data-show-name="object_id"   data-modal-size="modal-middle"  >
                                                                                                        <div>
                                                                                                            <i class="far fa-handshake"></i>
                                                                                                        </div>
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
                                                */ ?>



                                                <div class="box">

                                                </div>

                                            </div>
                                        </div>
                                    <? } ?>
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
                            <? if ($object->itemId()) { ?>
                                <? if ($object->showJsonField('building_layouts') != NULL) { ?>
                                    <? foreach ($object->showJsonField('building_layouts') as $file_unit) { ?>
                                        <div class='files-grid-unit' data-src="<?= $file_unit ?>">
                                            <? $ext = getFileExtension($file_unit) ?>
                                            <div class="text_center full-height flex-box flex-box-vertical grey-border">
                                                <div class="box">

                                                </div>
                                                <div style="font-size: 60px;" title="<?= getFilePureName($file_unit) ?> <?= $ext ?>">
                                                    <?= getFileIcon($file_unit) ?>
                                                </div>
                                                <div title="<?= getFilePureName($file_unit) ?>" class="box-small text_center full-width to-end-vertical grey-background">
                                                    <a href="<?= $file_unit ?>" target="_blank" class="text_center">
                                                        <div class="flex-box flex-center">
                                                            <div class="box-wide" style="font-size: 20px;">
                                                                <?= getFileIcon($file_unit) ?>
                                                            </div>
                                                            <div>
                                                                <?= getFileNameShort($file_unit) ?> <?= $ext ?>
                                                            </div>
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="file-delete icon-round">
                                                <i class='fa fa-times' aria-hidden='true'></i>
                                            </div>
                                        </div>
                                    <? } ?>
                                <? } ?>
                            <? } ?>
                        </div>
                    </div>
                    <div class="tab-content obj-part-content">
                        <div class="files-grid flex-box full-width">

                            <? if ($object->itemId()) { ?>
                                <? if ($object->showJsonField('building_presentations') != NULL) { ?>
                                    <? foreach ($object->showJsonField('building_presentations') as $file_unit) { ?>
                                        <div class='files-grid-unit' data-src="<?= $file_unit ?>">
                                            <? $ext = getFileExtension($file_unit) ?>
                                            <div class="text_center full-height flex-box flex-box-vertical grey-border">
                                                <div class="box">

                                                </div>
                                                <div style="font-size: 60px;" title="<?= getFilePureName($file_unit) ?> <?= $ext ?>">
                                                    <?= getFileIcon($file_unit) ?>
                                                </div>
                                                <div title="<?= getFilePureName($file_unit) ?>" class="box-small text_center full-width to-end-vertical grey-background">
                                                    <a href="<?= $file_unit ?>" target="_blank" class="text_center">
                                                        <div class="flex-box flex-center">
                                                            <div class="box-wide" style="font-size: 20px;">
                                                                <?= getFileIcon($file_unit) ?>
                                                            </div>
                                                            <div>
                                                                <?= getFileNameShort($file_unit) ?> <?= $ext ?>
                                                            </div>
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="file-delete icon-round">
                                                <i class='fa fa-times' aria-hidden='true'></i>
                                            </div>
                                        </div>
                                    <? } ?>
                                <? } ?>
                            <? } ?>
                        </div>
                    </div>
                    <div class="tab-content obj-part-content">
                        <div class="files-grid flex-box full-width">
                            <? if ($object->itemId()) { ?>
                                <? if ($object->showJsonField('building_contracts') != NULL) { ?>
                                    <? foreach ($object->showJsonField('building_contracts') as $file_unit) { ?>
                                        <div class='files-grid-unit' data-src="<?= $file_unit ?>">
                                            <? $ext = getFileExtension($file_unit) ?>
                                            <div class="text_center full-height flex-box flex-box-vertical grey-border">
                                                <div class="box">

                                                </div>
                                                <div style="font-size: 60px;" title="<?= getFilePureName($file_unit) ?> <?= $ext ?>">
                                                    <?= getFileIcon($file_unit) ?>
                                                </div>
                                                <div title="<?= getFilePureName($file_unit) ?>" class="box-small text_center full-width to-end-vertical grey-background">
                                                    <a href="<?= $file_unit ?>" target="_blank" class="text_center">
                                                        <div class="flex-box flex-center">
                                                            <div class="box-wide" style="font-size: 20px;">
                                                                <?= getFileIcon($file_unit) ?>
                                                            </div>
                                                            <div>
                                                                <?= getFileNameShort($file_unit) ?> <?= $ext ?>
                                                            </div>
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="file-delete icon-round">
                                                <i class='fa fa-times' aria-hidden='true'></i>
                                            </div>
                                        </div>
                                    <? } ?>
                                <? } ?>
                            <? } ?>
                        </div>
                    </div>
                    <div class="tab-content obj-part-content">
                        <div class="files-grid flex-box full-width">
                            <? if ($object->itemId()) { ?>
                                <? if ($object->showJsonField('building_property_documents') != NULL) { ?>
                                    <? foreach ($object->showJsonField('building_property_documents') as $file_unit) { ?>
                                        <div class='files-grid-unit' data-src="<?= $file_unit ?>">
                                            <? $ext = getFileExtension($file_unit) ?>
                                            <div class="text_center full-height flex-box flex-box-vertical grey-border">
                                                <div class="box">

                                                </div>
                                                <div style="font-size: 60px;" title="<?= getFilePureName($file_unit) ?> <?= $ext ?>">
                                                    <?= getFileIcon($file_unit) ?>
                                                </div>
                                                <div title="<?= getFilePureName($file_unit) ?>" class="box-small text_center full-width to-end-vertical grey-background">
                                                    <a href="<?= $file_unit ?>" target="_blank" class="text_center">
                                                        <div class="flex-box flex-center">
                                                            <div class="box-wide" style="font-size: 20px;">
                                                                <?= getFileIcon($file_unit) ?>
                                                            </div>
                                                            <div>
                                                                <?= getFileNameShort($file_unit) ?> <?= $ext ?>
                                                            </div>
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="file-delete icon-round">
                                                <i class='fa fa-times' aria-hidden='true'></i>
                                            </div>
                                        </div>
                                    <? } ?>
                                <? } ?>
                            <? } ?>
                        </div>


                        <?

                        $id = $object->postId();
                        $table_name = 'objects';

                        $files = array_diff(scandir(PROJECT_ROOT . "/uploads/files_old/$table_name/$id/"), ['..', '.']); //иначе scandir() дает точки
                        $files_list = [];

                        //echo 'лот номер'. "<b>$id</b>";
                        //echo 'его фотки далее<br>';
                        foreach ($files as $file) {
                            $files_list[] = PROJECT_ROOT . "/uploads/files_old/$table_name/$id/" . $file;
                        }

                        //var_dump($files_list);
                        ?>

                        <? if (count($files_list) > 0) { ?>
                            <div class="form-files  files-list   " style="min-width :300px;">
                                Документы старой базы
                                <div class=" flex-box flex-wrap files-grid">
                                    <? if ($object->postId()) { ?>
                                        <? if ($files != NULL) { ?>
                                            <? foreach ($files_list as $file_unit) { ?>
                                                <div class='files-grid-unit' data-src="<?= $file_unit ?>">
                                                    <? $ext = getFileExtension($file_unit) ?>
                                                    <div class="text_center full-height flex-box flex-box-vertical grey-border">
                                                        <div class="box">

                                                        </div>
                                                        <div style="font-size: 60px;" title="<?= getFilePureName($file_unit) ?> <?= $ext ?>">
                                                            <?= getFileIcon($file_unit) ?>
                                                        </div>
                                                        <div title="<?= getFilePureName($file_unit) ?>" class="box-small text_center full-width to-end-vertical grey-background">
                                                            <a href="<?= $file_unit ?>" target="_blank" class="text_center">
                                                                <div class="flex-box flex-center">
                                                                    <div class="box-wide" style="font-size: 20px;">
                                                                        <?= getFileIcon($file_unit) ?>
                                                                    </div>
                                                                    <div>
                                                                        <a href="<?= "/uploads/files_old/$table_name/$id/" . array_pop(explode('/', $file_unit)) ?>" target="_blank">
                                                                            <?= array_pop(explode('/', $file_unit)) ?> <? //=$ext
                                                                                                                        ?>
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            <? } ?>
                                        <? } ?>
                                    <? } ?>
                                </div>
                            </div>
                        <? } ?>

                    </div>
                    <div class="tab-content obj-part-content">
                        <? if ($object->itemId()) { ?>
                            <? if ($object->showJsonField('photos_360') != NULL) { ?>
                                <? foreach ($object->showJsonField('photos_360') as $file_unit) { ?>
                                    <div class='files-grid-unit' data-src="<?= $file_unit ?>">
                                        <? $ext = getFileExtension($file_unit) ?>
                                        <div class="text_center full-height flex-box flex-box-vertical grey-border">
                                            <div class="box">

                                            </div>
                                            <div style="font-size: 60px;" title="<?= getFilePureName($file_unit) ?> <?= $ext ?>">
                                                <?= getFileIcon($file_unit) ?>
                                            </div>
                                            <div title="<?= getFilePureName($file_unit) ?>" class="box-small text_center full-width to-end-vertical grey-background">
                                                <a href="<?= $file_unit ?>" target="_blank" class="text_center">
                                                    <div class="flex-box flex-center">
                                                        <div class="box-wide" style="font-size: 20px;">
                                                            <?= getFileIcon($file_unit) ?>
                                                        </div>
                                                        <div>
                                                            <?= getFileNameShort($file_unit) ?> <?= $ext ?>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="file-delete icon-round">
                                            <i class='fa fa-times' aria-hidden='true'></i>
                                        </div>
                                    </div>
                                <? } ?>
                            <? } ?>
                        <? } ?>

                    </div>
                    <div class="tab-content obj-part-content">
                        <div class="full-width">
                            <? $table = $object->setTableId() ?>
                            <? $id = $object->postId() ?>
                            <? include($_SERVER['DOCUMENT_ROOT'] . '/templates/forms/panel-description/index.php') ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>