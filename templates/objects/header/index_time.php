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
        <div class="flex-box to-end">
            <?if($logedUser->isAdmin()){?>
                <div class="icon-round to-end modal-call-btn" data-form="<?=($object->getField('is_land')) ? 'land' : 'building'?>" data-id="<?=$object->postId()?>" data-table="<?=$object->setTableId()?>" data-names='["redirect"]' data-values="[1]" data-modal="edit-all" data-modal-size="modal-big"   >
                    <span title="Редактировать"><i class="fas fa-pencil-alt"></i></span>
                </div>
            <?}?>
            <?if($object->getJsonField('photos_360') != NULL &&  arrayIsNotEmpty($object->getJsonField('photos_360'))){?>
                <div class="icon-round ">
                    <a href="/tour-360/<?=$object->setTableId()?>/<?=$object->postId()?>/photos_360" target="_blank"><span title="Панорама"><i class="fas fa-globe"></i></span></a>
                </div>
            <?}?>
            <?if($object->getField('cadastral_number')){?>
                <div class="icon-round " title="ссылка на кадастр">
                    <a href="https://pkk5.rosreestr.ru/#x=4034393.888696498&y=6756994.231129&z=20&text=<?=$object->getField('cadastral_number')?>&type=1&app=search&opened=1" target="_blank">
                        <i class="fas fa-hand-point-down"></i>
                    </a>
                </div>
            <?}?>
            <div class="icon-round" title="ссылка на кадастр">
                <a href="https://pennylane.pro/uploads/objects/<?=$object->postId()?>" target="_blank">
                    Фото
                </a>
            </div>
        </div>
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




</div>
