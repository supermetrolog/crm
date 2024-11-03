<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/global_pass.php';
//include_once $_SERVER['DOCUMENT_ROOT'].'/errors.php';




if($_POST['location_id']){
    $location_id = (int)$_POST['location_id'];
}else{
    $location_id = $src['location_id'];
}



?>
<div class="card-search-tags box-vertical">
    <ul style="text-transform: capitalize">
        <?if($location_id){?>
            <? $location = new Location($location_id)?>
            <?if($location->getLocationDirection()){?><li class="button btn-transparent isBold isUnderline"></li><?}?>
        <?}?>
    </ul>
    <?if($location_id){?>
        <div class="object-location-secondary ">
            <div class=" text_left box-vertical flex-box flex-vertical-top flex-wrap">
                <div class="attention full-width box-vertical">
                    Правило № <?=$location_id?> подключено
                </div>
                <div class="half">
                    <div class="flex-box" >
                        <div class="ghost one-line" style="width: 250px;" >
                            Москва/МО/Область/Регион................................
                        </div>
                        <div class="box-wide">
                            <?=$location->getLocationRegion()?>
                        </div>
                    </div>
                    <div class="flex-box" >
                        <div class="ghost one-line" style="width: 250px;" >
                            Область смежная с МО................................
                        </div>
                        <div class="box-wide">
                            <?=($location->getField('near_mo')) ? 'Да' : 'Нет' ?>
                        </div>
                    </div>
                    <div class="flex-box" >
                        <div class="ghost one-line" style="width: 250px;" >
                            Район населенного пункта................................
                        </div>
                        <div class="box-wide">
                            <?if($location->getField('district') ){?>
                                <?$item = new Post($location->getField('district'))?>
                                <?$item->getTable('l_districts')?>
                                <?=$item->title()?>
                                <a class="attention" href="<?=PROJECT_URL?>/location/?type=district&id=<?=$item->postId()?>" target="_blank">
                                    <i class="fas fa-pencil-alt"></i>
                                </a>
                            <?}?>
                        </div>
                    </div>
                    <div class="flex-box" >
                        <div class="ghost one-line" style="width: 250px;" >
                            Старый район нас пункта................................
                        </div>
                        <div class="box-wide">
                            <?if($location->getField('district_former') ){?>
                                <?$item = new Post($location->getField('district_former'))?>
                                <?$item->getTable('l_districts_former')?>
                                <?=$item->title()?>
                                <a class="attention" href="<?=PROJECT_URL?>/location/?type=district_former&id=<?=$item->postId()?>" target="_blank">
                                    <i class="fas fa-pencil-alt"></i>
                                </a>
                            <?}?>
                        </div>
                    </div>
                    <div class="flex-box isBold" >
                        <div class="ghost one-line"  style="width: 250px;" >
                            Населенный пункт**................................
                        </div>
                        <div class="box-wide">
                            <?$town = new Post($location->getField('town'))?>
                            <?$town->getTable('l_towns')?>
                            <?=$town->title()?>
                            <a class="attention" href="<?=PROJECT_URL?>/location/?type=town&id=<?=$town->postId()?>" target="_blank">
                                <i class="fas fa-pencil-alt"></i>
                            </a>
                        </div>
                    </div>
                    <div class="flex-box " >
                        <div class="ghost one-line" style="width: 250px;" >
                            ОСНОВА Населенный пункт................................
                        </div>
                        <div class="box-wide">
                            <?$townMain = new Post($location->getField('town_central'))?>
                            <?$townMain->getTable('l_towns')?>
                            <?=$townMain->title()?>
                        </div>
                    </div>
                    <div>
                        <?$relevant = $location->getJsonField('towns_relevant');?>
                        <? foreach($relevant as $city){?>
                            <div class="flex-box " >
                                <div class="ghost one-line" class="ghost" style="width: 250px;" >
                                    Показывать в нас пункт................................
                                </div>
                                <div class="box-wide">
                                    <?if($city){?>
                                        <?$town = new Post($city)?>
                                        <?$town->getTable('l_towns')?>
                                        <?=$town->title()?>
                                    <?}else{?>
                                        <?$city = 0?>
                                    <?}?>
                                </div>
                            </div>
                        <?}?>
                    </div>
                    <div class="box-small " >
                    </div>
                    <div class="flex-box" >
                        <div class="ghost one-line" style="width: 250px;" >
                            Находится в пределах МКАД................................
                        </div>
                        <div class="box-wide">
                            <?=($location->getField('outside_mkad')) ? 'Нет' :'Да';?>
                        </div>
                    </div>
                    <div class="flex-box" >
                        <div class="ghost one-line" style="width: 250px;" >
                            Показывать в пределах МКАД................................
                        </div>
                        <div class="box-wide">
                            <?=($location->getField('show_inside_mkad')) ? 'Да' :'Нет';?>
                        </div>
                    </div>
                    <div class="flex-box" >
                        <div class="ghost one-line" style="width: 250px;" >
                            Показывать в МО............................................
                        </div>
                        <div class="box-wide">
                            <?=($location->getField('show_in_mo')) ? 'Да' :'Нет';?>
                        </div>
                    </div>
                    <div class="flex-box" >
                        <div class="ghost one-line" style="width: 250px;" >
                            Прилежащий к МО...............................................
                        </div>
                        <div class="box-wide">
                            <?=($location->getField('near_mo')) ? 'да' :'нет';?>
                        </div>
                    </div>
                    <div class="flex-box" >
                        <div class="ghost one-line" style="width: 250px;" >
                            Регион ЦИАН...................................................
                        </div>
                        <div class="box-wide">
                            <?if($location->getField('cian_region')){?>
                                <?$cian_region = new Post($location->getField('cian_region'))?>
                                <?$cian_region->getTable('l_cian_regions')?>
                                <?=$cian_region->title()?>
                            <?}?>
                        </div>
                    </div>
                </div>
                <div class="half">
                    <div class="flex-box isBold" >
                        <div class="ghost one-line"  style="width: 250px;" >
                            Метро**................................................................
                        </div>
                        <div class="box-wide">
                            <?if($location->getField('metro')){?>
                                <?$metro = new Post($location->getField('metro'))?>
                                <?$metro->getTable('l_metros')?>
                                <?=$metro->title()?>
                            <?}else{?>
                                -
                            <?}?>
                        </div>
                    </div>
                    <div class="flex-box isBold" >
                        <div class="ghost"  style="width: 250px;" >
                            &#160;
                        </div>
                        <div class="">

                        </div>
                    </div>
                    <div class="flex-box " >
                        <div class="ghost one-line"  style="width: 250px;" >
                            Округ москвы..............................................
                        </div>
                        <div class="box-wide">
                            <?if($location->getField('district_moscow') ){?>
                                <?$item = new Post($location->getField('district_moscow'))?>
                                <?$item->getTable('l_districts_moscow')?>
                                <?=$item->title()?>
                            <?}?>
                        </div>
                    </div>
                    <div class="flex-box" >
                        <div class="ghost one-line"  style="width: 250px;" >
                            Показывать в округе Москвы ................................
                        </div>
                        <div class="box-wide">
                            <?/*if($location->getField('district_moscow_relevant')){?>
                                <?$metro = new Post($location->getField('district_moscow_relevant'))?>
                                <?$metro->getTable('l_districts_moscow')?>
                                <?=$metro->title()?>
                            <?}else{?>
                                -
                            <?}*/?>
                        </div>
                    </div>
                    <div class="flex-box " >
                        <div class="ghost one-line"  style="width: 250px;" >
                            Основное шоссе Москвы.......................................
                        </div>
                        <div class="box-wide">
                            <?= $location->getLocationHighway() != null ? $location->getLocationHighway() : ''?>
                            <?= $location->getLocationHighwayMoscow() != null ? $location->getLocationHighwayMoscow() :  ''?>
                        </div>
                    </div>
                    <?$relevant = $location->getJsonField('highways_moscow_relevant');?>
                    <? foreach($relevant as $city){?>
                        <div class="flex-box ghost" >
                            <div class="one-line"  style="width: 250px;" >
                                Прилегающее шоссе Москвы................................
                            </div>
                            <div class="box-wide">
                                <?if($city){?>
                                    <?$town = new Post($city)?>
                                    <?$town->getTable('l_highways_moscow')?>
                                    <?=$town->title()?>
                                <?}else{?>
                                    Регион или МО
                                <?}?>
                            </div>
                        </div>
                    <?}?>
                    <div class="box-small">

                    </div>
                    <div class="flex-box " >
                        <div class="ghost one-line"  style="width: 250px;" >
                            Направление МО......................................
                        </div>
                        <div class="box-wide">
                            <?=$location->getLocationDirection()?>
                        </div>
                    </div>
                    <div class="flex-box " >
                            <?if(arrayIsNotEmpty($directions = $location->getJsonField('direction_relevant'))){
                                foreach($directions as $direction){
                                    if($direction != null){?>
                                        <div class="flex-box " >
                                            <div class="ghost one-line"  style="width: 250px;" >
                                                Смежное направление....................................
                                            </div>
                                            <div class="box-wide">
                                                <?=getPostTitle($direction,'l_directions')?>
                                            </div>
                                        </div>
                                    <?}
                                }
                            }?>
                    </div>
                    <div class="flex-box " >
                        <div class="ghost one-line"  style="width: 250px;" >
                            Основное шоссе МО................................................................
                        </div>
                        <div class="box-wide">
                            <?= $location->getLocationHighway() != null ? $location->getLocationHighway() : ''?>
                            <?= $location->getLocationHighwayMoscow() ?? ''?>
                        </div>
                    </div>
                    <?$relevant = $location->getJsonField('highways_relevant');?>
                    <? foreach($relevant as $city){?>
                        <div class="flex-box " >
                            <div class="ghost one-line"  style="width: 250px;" >
                                Прилегающее шоссе МО................................................................
                            </div>
                            <div class="box-wide">
                                <?if($city){?>
                                    <?$town = new Post($city)?>
                                    <?$town->getTable('l_highways')?>
                                    <?=$town->title()?>
                                <?}else{?>
                                    <?$city = 0;?>
                                <?}?>
                            </div>
                        </div>
                    <?}?>
                    <div class="box">

                    </div>
                    <div class="flex-box">
                        <div class="ghost one-line" style="width: 250px;" >
                            .....................................................................
                        </div>
                        <div class="underlined isBold ">
                            <a class="attention" href="<?=PROJECT_URL?>/location/?type=location&id=<?=$location->postId()?>" target="_blank">
                                Исправить
                            </a>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    <?}?>

</div>
