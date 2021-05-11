
<?php

$complex_id = $router->getPath()[1];
$complex = new Complex($complex_id);

$favourites = $logedUser->getJsonField('favourites');


//include_once($_SERVER['DOCUMENT_ROOT'].'/errors.php');

?>
<div class="card-title-area box">
    <div class="flex-box">
        <div>
            <h1>
                <?= ($complex->title()) ? $complex->title() : 'Название комплекса'?>
                <?= ($complex->getField('deleted')) ? ' (УДАЛЕН)' : ''?>
                <?if($complex->getField('status') == 2 ){?>
                    <span style="color: red;">
                    <?php
                    $status = new Post($complex->getField('status'));
                    $status->getTable('l_statuses_all');
                    ?>
                    <?=$status->title();?>
                </span>
                <?}?>
            </h1>
        </div>
        <div class="to-end flex-box">
            <?if($logedUser->isAdmin()){?>
                <div class="icon-round  modal-call-btn" data-form="<?=($complex->getField('is_land')) ? 'land' : 'building'?>" data-id="<?=$complex->postId()?>" data-table="<?=$complex->setTableId()?>" data-names='["redirect"]' data-values="[1]" data-modal="edit-all" data-modal-size="modal-big"   >
                    <span title="Редактировать"><i class="fas fa-pencil-alt"></i></span>
                </div>
            <?}?>
            <?if($complex->getJsonField('photos_360') != NULL &&  arrayIsNotEmpty($complex->getJsonField('photos_360'))){?>
                <div class="icon-round to-end">
                    <a href="/tour-360/<?=$complex->setTableId()?>/<?=$complex->postId()?>/photos_360" target="_blank"><span title="Панорама"><i class="fas fa-globe"></i></span></a>
                </div>
            <?}?>
            <?if($complex->getField('cadastral_number_land')){?>
                <div class="icon-round to-end" title="ссылка на кадастр">
                    <a href="https://pkk5.rosreestr.ru/#x=4034393.888696498&y=6756994.231129&z=20&text=<?=$complex->getField('cadastral_number_land')?>&type=1&app=search&opened=1" target="_blank">
                        <i class="fas fa-hand-point-down"></i>
                    </a>
                </div>
            <?}?>
        </div>
    </div>
    <div>
        <p><b class="ghost">ID комплекса - <?=$complex->postId()?></b>, <span class="ghost">поступление <?=$complex->publTime()?>, обновление <?=$complex->lastUpdate()?></span></p>
    </div>
</div>



<div class="card-search-area box">
    <div class="card-search-tags box-vertical">
        <ul style="text-transform: capitalize">

            <?if($location_id = $complex->getField('location_id')){?>
                <? $location = new Location($location_id)?>

                <li class="button btn-transparent isBold isUnderline"><?=$location->getLocationRegion()?></li>

                <?if($location->getField('district') || $location->getField('district_moscow')){?><li class="button btn-transparent isBold isUnderline"><?=$location->getLocationDistrictType()?> <?=$location->getLocationDistrict()?></li><?}?>

                <?if($location->getLocationDirection()){?><li class="button btn-transparent isBold isUnderline"><?=$location->getLocationDirection()?></li><?}?>

                <?if($location->getField('town')){?><li class="button btn-transparent isBold isUnderline"><?=$location->getLocationTownType()?> <?=$location->getLocationTown()?></li><?}?>

                <?if($location->getLocationHighway()){?><li class="button btn-transparent isBold isUnderline">Шоссе: <?=$location->getLocationHighway()?></li><?}?>
                <?if($location->getLocationHighwayMoscow()){?><li class="button btn-transparent isBold isUnderline">Шоссе: <?=$location->getLocationHighwayMoscow()?></li><?}?>

                <?if($complex->getField('from_mkad')){?><li class="button btn-transparent isBold"><?=$complex->getField('from_mkad')?> км. от МКАД</li><?}?>
                <?if($complex->getField('mkad_ttk_between')){?><li class="button btn-transparent isBold">между МКАД и ТТК</li><?}?>
                <?if($location->getField('metro')){?><li class="button"><i class="fab fa-monero"></i> <a href="https://metro.yandex.ru/moscow?from=11&to=&route=0" target="_blank"><?=$location->getLocationMetro()?></a></li><?}?>
            <?}?>
            <?if($complex->getField('railway_station')){?>
                <?$station = new Post($complex->getField('railway_station'))?>
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


            <?if($location_id = $complex->getField('location_id')){?>
                <?if($logedUser->isAdmin()){?>
                    <li>
                        <div class="box-wide pointer modal-call-btn" data-form="" data-id="<?=$location->postId()?>" data-table="<?=$location->setTableId()?>" data-names='' data-values="" data-modal="edit-all" data-modal-size="modal-very-big"   >
                            <span title="Редактировать"><i class="fas fa-pencil-alt"></i></span>
                        </div>
                    </li>

                <?}?>

            <?}?>
            <li>
                <div class="box-wide pointer modal-call-btn" data-form="" data-id="" data-table="<?=(new Location())->setTableId()?>" data-names='' data-values="" data-modal="edit-all" data-modal-size="modal-very-big"   >
                    <span title="Создать локацию"><i class="fas fa-plus-circle"></i></span>
                </div>
            </li>

        </ul>
        <?if($location_id){?>
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
                            <?
                            if(arrayIsNotEmpty($directions = $location->getJsonField('direction_relevant'))){
                                foreach($directions as $direction){
                                    if($direction != null){
                                        echo getPostTitle($direction,'l_directions');
                                    }
                                }
                            }
                            ?>
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
                            <?/*if($location->getField('district_moscow_relevant')){?>
                                <?$townMain = new Post($location->getField('district_moscow_relevant'))?>
                                <?$townMain->getTable('l_districts_moscow')?>
                                <?=$townMain->title()?>
                            <?}*/?>
                        </div>

                    </div>
                    <div class="half">
                        <div>
                            Основа
                            <b>
                                <? if( $location->getField('town_central')) {?>
                                    <?$townMain = new Post($location->getField('town_central'))?>
                                    <?$townMain->getTable('l_towns')?>
                                    <?=$townMain->title()?>
                                <? } ?>

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
                            <?/*if($location->getField('highway_moscow')){?>
                                <?$townMain = new Post($location->getField('highway_moscow'))?>
                                <?$townMain->getTable('l_highways_moscow')?>
                                <b>
                                    <?=$townMain->title()?>
                                </b>
                            <?}*/?>
                        </div>
                        <div>
                            <?/*$relevant = $location->getJsonField('highways_moscow_relevant');?>
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
                            <?}*/?>
                        </div>
                    </div>

                    <div>
                        <?/*if($location->getField('district_moscow_relevant')){?>
                            Смежный округ
                            <?$townMain = new Post($location->getField('district_moscow_relevant'))?>
                            <?$townMain->getTable('l_districts_moscow')?>
                            <?=$townMain->title()?>
                        <?}*/?>
                    </div>

                    <div>
                        <?/*$relevant = $location->getJsonField('district_relevant');?>
                        <? foreach($relevant as $city){?>
                            <?if($city){?>
                                Смежный район
                                <?$town = new Post($city)?>
                                <?$town->getTable('l_districts')?>
                                <?=$town->title()?>
                            <?}?>
                        <?}*/?>
                    </div>

                </div>

            </div>
        <?}?>

    </div>


    <div class="">

        <div class="card-search-line">
            <div>
                <div id="open-object-map">
                    <i class="fas fa-map-marker-alt"></i>
                </div>
            </div>
        </div>


        <script src="https://api-maps.yandex.ru/2.1/?apikey=2b6763cf-cc99-48c7-81f1-f4ceb162502a&lang=ru_RU" type="text/javascript">
        </script>
        <?
        $sql = $pdo->prepare("SELECT id,address,latitude,longitude FROM c_industry WHERE complex_id=".$complex->getField('id'));
        //echo "SELECT id,address,latitude,longitude FROM c_industry WHERE complex_id=".$complex->getField('id');
        $sql->execute();
        $points = [];
        while($item = $sql->fetch(PDO::FETCH_LAZY)){
            $points[] = new Building($item->id);
        }
        ?>
        <?if($points != null){?>
            <?
            $lat = ($points[0])->getField('latitude');
            $lon = ($points[0])->getField('longitude');
            ?>
            <script async defer type="text/javascript">
                ymaps.ready(init);
                function init(){
                    //let coords = [<?=$complex->getField("latitude")?>,<?=$complex->getField("longitude")?>]
                    let coords = [<?=$lat?>,<?=$lon?>];

                    let myMap = new ymaps.Map("map", {
                        center: coords,
                        controls: ['zoomControl'],
                        zoom: 10
                    });

                    //let point = '<?=json_encode()?>'

                    //let coords1 = [37.333333,57.333333];
                    let pos = 0;
                    let placemark = 0;



                    <?foreach($points as $point){?>
                        pos = [<?=$point->getField('latitude')?>,<?=$point->getField('longitude')?>];

                        console.log("myPlacemark_"+'<?=$i?>');

                        placemark = new ymaps.Placemark(pos, {
                            balloonContentHeader: "ID-<?=$point->postId()?>",
                            balloonContentBody: "<?=$point->getField('address')?>",
                            balloonContentFooter: "ID-<?=$point->postId()?>",
                            hintContent: "ID-<?=$point->postId()?>"
                        });

                        myMap.geoObjects.add(placemark);

                    <?}?>

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
        <?}?>
    </div>
</div>






