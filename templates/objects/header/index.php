<style>

    .tabs > .tab {
        padding: 10px;
        box-sizing: border-box;
        cursor: pointer;
    }

</style>
<?php
$actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$furl = parse_url($actual_link);

if($router->getPageId() == 54){
    $object_id = $obj['id'];
}else{
    $object_id = $router->getPath()[1];
}


$object = new Building($object_id);

$favourites = $logedUser->getJsonField('favourites');


//include_once($_SERVER['DOCUMENT_ROOT'].'/errors.php');
?>

<?//$deal_forms_arr = ['rent','sale','safe','rent'];?>
<?$deal_forms_offers_arr = [['rent','sale','safe','subrent'],['rent_land','sale_land','safe_land','rent_land']];?>
<?$deal_forms_blocks_arr = [['rent','sale','safe','subrent'],['land','land','land','land']];?>

<div class="card-title-area box">
    <div class="flex-box">
        <div>
            <p><a href="<?=PROJECT_URL?>/edit-card/<?=$object->itemId()?>"><b>ID-<?=$object->itemId()?></b></a>, <span class="ghost">поступление <?=$object->publTime()?>, обновление <?=$object->lastUpdate()?></span></p>
        </div>
        <?if($logedUser->isAdmin()){?>
            <div class="icon-round to-end modal-call-btn" data-form="<?=($object->getField('is_land')) ? 'land' : 'building'?>" data-id="<?=$object->postId()?>" data-table="<?=$object->setTableId()?>" data-names='["redirect"]' data-values="[1]" data-modal="edit-all" data-modal-size="modal-big"   >
                <span title="Редактировать"><i class="fas fa-pencil-alt"></i></span>
            </div>
        <?}?>
    </div>
    <?if($object->getJsonField('photos_360') != NULL &&  arrayIsNotEmpty($object->getJsonField('photos_360'))){?>
        <div class="icon-round to-end">
            <a href="/tour-360/<?=$object->setTableId()?>/<?=$object->postId()?>/photos_360" target="_blank"><span title="Панорама"><i class="fas fa-globe"></i></span></a>
        </div>
    <?}?>
    <?if($object->getField('cadastral_number')){?>
        <div class="icon-round to-end" title="ссылка на кадастр">
            <a href="https://pkk5.rosreestr.ru/#x=4034393.888696498&y=6756994.231129&z=20&text=<?=$object->getField('cadastral_number')?>&type=1&app=search&opened=1" target="_blank">
                <i class="fas fa-hand-point-down"></i>
            </a>
        </div>
    <?}?>
    <div class="icon-round to-end" title="ссылка на кадастр">
        <a href="https://pennylane.pro/uploads/objects/<?=$object->postId()?>" target="_blank">
            Фото
        </a>
    </div>
    <div>
        <h1>
            <?= ($object->title()) ? $object->title() : 'Название комплекса'?>
            <?= ($object->getField('deleted')) ? ' (УДАЛЕН)' : ''?>
            <?if($object->getField('status') == 2 ){?>
                <span style="color: red;">
                    <?php
                    $status = new Post($object->getField('status'));
                    $status->getTable('l_statuses_all');
                    ?>
                    <?=$status->title();?>
                </span>
            <?}?>
        </h1>
    </div>
    <div class="card-top-pictograms ghost box-vertical">
        <ul>
            Тип объекта
            <?if(arrayIsNotEmpty($obj_types = $object->getJsonField('object_type'))){?>
                <?foreach($obj_types as $obj_type){?>
                    <?
                    $type = new Post((int)$obj_type);
                    $type->getTable('l_object_types');
                    ?>
                    <li class="icon-square" style="border: 1px dashed black;">
                        <a href="#" title="<?=$type->title()?>"><?=$type->getField('icon')?></a>
                    </li>
                <?}?>
            <?}?>


        </ul>
        <br>
        <ul>
            Назначения
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
</div>
<div class="card-search-area box">
    <div class="card-search-line">
        <div>
            <input disabled  type="text" name="" value="<?=$object->getField('address')?>" placeholder="" />
            <div id="open-object-map"><i class="fas fa-map-marker-alt"></i></div>
        </div>
    </div>


    <script src="https://api-maps.yandex.ru/2.1/?apikey=2b6763cf-cc99-48c7-81f1-f4ceb162502a&lang=ru_RU" type="text/javascript">
    </script>
    <script async defer type="text/javascript">
        ymaps.ready(init);
        function init(){
            let coords = [<?=$object->getField("latitude")?>,<?=$object->getField("longitude")?>]

            let myMap = new ymaps.Map("map", {
                center: coords,
                controls: ['zoomControl'],
                zoom: 10
            });


            let myPlacemark = new ymaps.Placemark(coords, {

                balloonContentHeader: "<?=$object->title()?>",
                balloonContentBody: "<?=$object->getField('address')?>",
                balloonContentFooter: "ID-<?=$object->postId()?>",
                hintContent: "ID-<?=$object->postId()?>"
            });

            myMap.geoObjects.add(myPlacemark);
        }


        $('body').on('click','#open-object-map',function () {
            if($('.map-container').css('height') === '0px'){
                $('.map-container').css('height','auto');
            }else{
                $('.map-container').css('height','0');
            }

        });
    </script>

    <div class="map-container" style="overflow: hidden; height: 0;">
        <div id="map" class="" style=" height: 400px; ">


        </div>
    </div>



    <div class="card-search-tags box-vertical">
        <ul style="text-transform: capitalize">
            <?if($object->getField('location_id')){?>
                <? $location = new Location($object->getField('location_id'))?>

                <li class="button btn-transparent isBold isUnderline"><?=$location->getLocationRegion()?></li>

                <?if($location->getField('district') || $location->getField('district_moscow')){?><li class="button btn-transparent isBold isUnderline"><?=$location->getLocationDistrictType()?> <?=$location->getLocationDistrict()?></li><?}?>

                <?if($location->getLocationDirection()){?><li class="button btn-transparent isBold isUnderline"><?=$location->getLocationDirection()?></li><?}?>

                <?if($location->getField('town')){?><li class="button btn-transparent isBold isUnderline"><?=$location->getLocationTownType()?> <?=$location->getLocationTown()?></li><?}?>

                <?if($location->getLocationHighway()){?><li class="button btn-transparent isBold isUnderline">Шоссе: <?=$location->getLocationHighway()?></li><?}?>
                <?if($location->getLocationHighwayMoscow()){?><li class="button btn-transparent isBold isUnderline">Шоссе: <?=$location->getLocationHighwayMoscow()?></li><?}?>

                <?if($object->fromMkad()){?><li class="button btn-transparent isBold"><?=$object->fromMkad()?> км. от МКАД</li><?}?>
                <?if($object->getField('mkad_ttk_between')){?><li class="button btn-transparent isBold">между МКАД и ТТК</li><?}?>
                <?if($location->getField('metro')){?><li class="button"><i class="fab fa-monero"></i> <a href="https://metro.yandex.ru/moscow?from=11&to=&route=0" target="_blank"><?=$location->getLocationMetro()?></a></li><?}?>
            <?}?>
            <?if($object->getField('railway_station')){?>
                <?$station = new Post($object->getField('railway_station'))?>
                <?$station->getTable('l_railway_stations') ?>
                <li class="button btn-transparent isBold isUnderline"><i class="fas fa-subway"></i> <?=$station->title()?></li>
            <?}?>
            <li>
                <div  class="flex-box flex-center full-width object-location-toggle" title="Развернуть локацию">
                    <div class="icon-round">
                        <i class="fas fa-angle-down"></i>
                    </div>
                </div>
                <script>
                    $(document).ready(function(){
                        $('body').on('click','.object-location-toggle',function(){
                            $(this).toggleClass('rotate-180');
                            $('.object-location-secondary').slideToggle();
                        });
                    });
                </script>
            </li>
        </ul>
        <?if($object->getField('location_id')){?>
            <div class="object-location-secondary hidden">
                <div class=" text_left box-vertical flex-box flex-vertical-top flex-wrap">
                    <div class="half">
                        <div>
                            Находится в пределах МКАД
                            <b><?=($location->getField('outside_mkad')) ? 'нет' :'да';?></b>
                        </div>
                        <div>
                            Показывать в пределах МКАД
                            <b><?=($location->getField('show_inside_mkad')) ? 'да' :'нет';?></b>
                        </div>
                        <div>
                            Показывать в МО
                            <b>
                                <?=($location->getField('show_in_mo')) ? 'да' :'нет';?>
                            </b>
                        </div>
                        <div>
                            Прилежащий к МО
                            <b>
                                <?=($location->getField('near_mo')) ? 'да' :'нет';?>
                            </b>
                        </div>
                        <div>
                            Регион ЦИАН
                            <b>
                                <?if($location->getField('cian_region')){?>
                                    <?$cian_region = new Post($location->getField('cian_region'))?>
                                    <?$cian_region->getTable('l_cian_regions')?>
                                    <?=$cian_region->title()?>
                                <?}?>
                            </b>

                        </div>
                        <div class="box">

                        </div>
                    </div>

                    <div class="half">
                        <div>
                            Смежное направление
                            <?if($location->getField('direction_relevant')){?>
                                <?$townMain = new Post($location->getField('direction_relevant'))?>
                                <?$townMain->getTable('l_directions')?>
                                <?=$townMain->title()?>
                            <?}?>
                        </div>
                        <div>
                            Показывать в округе Москвы
                            <?if($location->getField('district_moscow')){?>
                                <?$townMain = new Post($location->getField('district_moscow'))?>
                                <?$townMain->getTable('l_districts_moscow')?>
                                <?=$townMain->title()?>
                            <?}?>
                        </div>
                        <div>
                            Показывать в смежном округе Москвы
                            <?if($location->getField('district_moscow_relevant')){?>
                                <?$townMain = new Post($location->getField('district_moscow_relevant'))?>
                                <?$townMain->getTable('l_districts_moscow')?>
                                <?=$townMain->title()?>
                            <?}?>
                        </div>

                    </div>
                    <div class="half">
                        <div>
                            Основа
                            <b>
                                <?$townMain = new Post($location->getField('town_central'))?>
                                <?$townMain->getTable('l_towns')?>
                                <?=$townMain->title()?>
                            </b>
                        </div>
                        <div>
                            <?$relevant = $location->getJsonField('towns_relevant');?>
                            <? foreach($relevant as $city){?>
                                Показывать в
                                <?if($city){?>
                                    <?$town = new Post($city)?>
                                    <?$town->getTable('l_towns')?>
                                    <b>
                                        <?=$town->title()?>
                                    </b>
                                <?}else{?>
                                    <?$city = 0?>
                                <?}?>

                                <br>
                            <?}?>
                        </div>
                    </div>
                    <div class="half">
                        <div>
                            Старый район
                            <?if($location->getField('district_former') ){?>
                                <?$item = new Post($location->getField('district_former'))?>
                                <?$item->getTable('l_districts_former')?>
                                <b>
                                    <?=$item->title()?>
                                </b>

                            <?}?>
                        </div>
                        <div>
                            <?$relevant = $location->getJsonField('highways_relevant');?>
                            <? foreach($relevant as $city){?>
                                Смежное шоссе
                                <?if($city){?>
                                    <?$town = new Post($city)?>
                                    <?$town->getTable('l_highways')?>
                                    <b>
                                        <?=$town->title()?>
                                    </b>


                                <?}else{?>
                                    <?$city = 0;?>
                                <?}?>
                                <br>
                            <?}?>
                        </div>
                        <div>
                            Основное шоссе Москва
                            <?if($location->getField('highway_moscow')){?>
                                <?$townMain = new Post($location->getField('highway_moscow'))?>
                                <?$townMain->getTable('l_highways_moscow')?>
                                <b>
                                    <?=$townMain->title()?>
                                </b>
                            <?}?>
                        </div>
                        <div>
                            <?$relevant = $location->getJsonField('highways_moscow_relevant');?>
                            <? foreach($relevant as $city){?>
                                Смежное шоссе Москва
                                <?if($city){?>
                                    <?$town = new Post($city)?>
                                    <?$town->getTable('l_highways_moscow')?>
                                    <b>
                                        <?=$town->title()?>
                                    </b>
                                <?}else{?>
                                    <?$city = 0;?>
                                <?}?>
                                <br>
                            <?}?>
                        </div>
                    </div>

                    <div>
                        <?if($location->getField('district_moscow_relevant')){?>
                            Смежный округ
                            <?$townMain = new Post($location->getField('district_moscow_relevant'))?>
                            <?$townMain->getTable('l_districts_moscow')?>
                            <?=$townMain->title()?>
                        <?}?>
                    </div>

                    <div>
                        <?$relevant = $location->getJsonField('district_relevant');?>
                        <? foreach($relevant as $city){?>
                            <?if($city){?>
                                Смежный район
                                <?$town = new Post($city)?>
                                <?$town->getTable('l_districts')?>
                                <?=$town->title()?>
                            <?}?>
                        <?}?>
                    </div>

                </div>
            </div>


        <?}?>

    </div>
</div>
