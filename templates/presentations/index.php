<?

//ini_set('error_reporting', E_ALL);ini_set('display_errors', 1);ini_set('display_startup_errors', 1);
$original_id = $router->getPath()[1];
$original_type = $router->getPath()[2];

function photoHelper($file){
    //echo $file;
    if(($file)){
        //echo $file;
        $parts = explode('/',$file);
        $name = array_pop($parts);
        $post = array_pop($parts);
        return PROJECT_URL.'/system/controllers/photos/watermark.php/1200/'.$post.'/'.$name;
    }else{
        return 'http://www.tinybirdgames.com/wp-content/uploads/2017/04/tinybirdgames_telegram_background_02.jpg';
    }

}


//echo $original_id;
//echo '<br>';
//echo $original_type;
//echo '<br>';


$offer = new OfferMix(0);
$offer->getRealId((int)$original_id,(int)$original_type);


$offer_mix_id =  $offer->postId();
//echo $offer->postId();

$object = new Building($offer->getField('object_id'));

//изменит на агента по предложению
$agent = new Member($object->getField('agent_id'));


?>



<div class="container">



    <div class="pdf-pages">

    </div>





    <div class="pdf-container-hidden">
        <div class="pdf-block">
            <div class="flex-box flex-vertical-top">
                <div class=" background-fix pdf_photo-big text_left" style=" width: 513px; height: 400px; position: relative;  background: url('<?=photoHelper(PROJECT_URL.(($offer->getJsonField('photos'))[0]))?>')">
                    <div class="box-small object-id uppercase" style=" color: white; width: 120px">
                        Обьект <?=$object->postId()?>
                    </div>
                    <div style="height: 220px">

                    </div>
                    <div class="box" style=" color: white;">
                        <div class="uppercase" style="font-size: 40px; font-weight: bold;">
                            <?=$offer->getField('title')?>
                        </div>
                        <div class="purple-color box-small-vertical">
                            Производственно-складской комплекс
                        </div>
                        <div class="flex-box">
                            <?if($offer->getField('town')){?>
                                <div class="pdf-button box-small">
                                    <?=$offer->getField('town')?>
                                </div>
                            <?}?>
                            <?if($offer->getField('highway')){?>
                                <div class="pdf-button box-small">
                                    <?=$offer->getField('highway')?>
                                </div>
                            <?}?>
                            <?if($offer->getField('from_mkad')){?>
                                <div class="pdf-button box-small">
                                    <?=$offer->getField('from_mkad')?> км от МКАД
                                </div>
                            <?}?>
                        </div>
                    </div>
                </div>
                <div class="to-end"  style="height: 400px; width: 250px; overflow: hidden;" >
                    <div id="map">
                        <img src="https://static-maps.yandex.ru/1.x/?ll=35.620070,55.753630&size=275,450&z=13&l=map&pt=35.620070,55.753630,vkbkm"  />
                    </div>
                </div>
            </div>
        </div>
        <div class="pdf-block">
            <div class="box-small-vertical flex-box flex-between" >
                <div class="flex-box "  style=" border: 2px solid  #e7e5f2; width: 510px ">
                    <div class="box" style="background: #e7e5f2; height: 120px; width: 200px;">
                        <div class="isBold uppercase" style="font-size: 10px;">
                            площади
                            <?
                            if(1){
                                $deal_type = $offer->getField('deal_type');
                                if($deal_type == '2'){
                                    $val = 'на продажу';
                                    $area = $offer->getOfferBlocksMaxSumValue('area_max');
                                    $price = $offer->getOfferBlocksMaxSumValue('price');
                                }elseif($deal_type == '3'){
                                    $val = 'в отв. хранение';
                                    $area = $offer->getOfferBlocksMaxSumValue('area_max');
                                    $smallest = $offer->getOfferBlocksMinValue('area_min');
                                    $price = 'от '.$offer->getOfferBlocksMinValue('price');
                                }else{
                                    $val = 'в аренду';
                                    $area = $offer->getField('area_max');
                                    $smallest = $offer->getField('area_min');
                                    $price = 'от '.$offer->getOfferBlocksMinValue('price');
                                }
                            }else{
                                $val = 'объекта';
                                $area = $object->getField('area_building');
                            }
                            ?>
                            <?=$val?>
                        </div>
                        <div class="isBold box-small-vertical" style="font-size: 24px">
                            <?=$area?> <span style="line-height: 10px;">м<sup>2</sup></span>
                        </div>
                        <div>
                            <?if($smallest){?>
                                Деление от <span class="attention isBold"><?=$smallest?> м<sup>2</sup></span>
                            <?}?>
                        </div>
                    </div>
                    <div class="two-third box" style="height: 120px;" >
                        <div class="isBold">
                            ставка за <span style="line-height: 10px;">м<sup>2</sup>/год</span>
                            <?if($offer->getField('tax_form')){?>
                                <?
                                if($offer->getField('tax_form') == 'triple net'){
                                $area_tax = ', без НДС';
                                }else{
                                $area_tax = ', '.$offer->getField('tax_form');
                                }
                                ?>
                                <span class="attention "><?=$area_tax?></span>
                            <?}?>

                        </div>
                        <div class="attention isBold box-small-vertical" style="font-size: 24px">
                            <?= valuesCompare($offer->getField('price_floor_min'), $offer->getField('price_floor_max'))?> руб.
                        </div>
                        <div>
                            <?
                            $offer_stat = '';
                            if($offer->getField('tax_form') == 'triple net' ){
                                $offer_stat.= 'дополнительно OPEX и КУ';
                            }else{
                                if($offer->getField('tax_form') == 'c ндс'){
                                    $offer_stat.= 'c НДС';
                                }else{
                                    $offer_stat.= 'без НДС';
                                }
                                if($offer->getField('price_opex_inc') == 0 || $offer->getField('price_public_services_inc') == 0){
                                    $offer_stat.= ', дополнительно';
                                    if($offerMix->getField('price_opex_inc') == 0){
                                        $offer_stat.= ' OPEX ';
                                    }
                                    if($offerMix->getField('price_public_services_inc') == 0){
                                        $offer_stat.= ', КУ ';
                                    }
                                }
                            }
                            ?>
                            <?=$offer_stat?>
                        </div>
                    </div>
                </div>
                <div class="flex-box flex-wrap text-center " style="width: 250px">
                    <div class="one-third box-small-vertical object-option">
                        <div>
                            <i class="fas fa-signal"></i>
                        </div>
                        <div>
                            <?= valuesCompare($offer->getfield('floor_min'),$offer->getField('floor_max'))?> этажи
                        </div>
                    </div>
                    <div class="one-third box-small-vertical object-option">
                        <div>
                            <i class="fas fa-sign-in-alt"></i>
                        </div>
                        <div>
                            <?=$offer->getField('gate_num')?> ворот
                        </div>
                    </div>
                    <div class="one-third box-small-vertical object-option">
                        <div>
                            <i class="fas fa-bolt"></i>
                        </div>
                        <div>
                            <?=$object->getField('power')?>кВТ
                        </div>
                    </div>
                    <div class="one-third box-small-vertical object-option">
                        <div>
                            <i class="fas fa-arrows-alt-v"></i>
                        </div>
                        <div>
                            <?= valuesCompare($offer->getField('ceiling_height_min'),$offer->getField('ceiling_height_max'))?>
                            метров
                        </div>
                    </div>
                    <div class="one-third box-small object-option">
                        <div>
                            <i class="rotate-45 fas fa-arrows-alt"></i>
                        </div>
                        <div>
                            <?=$offer->getField('floor_type')?>
                        </div>
                    </div>
                    <div class="one-third box-small object-option">
                        <div>
                            <i class="fas fa-truck-loading"></i>
                        </div>
                        <div>


                            <?
                            $cap_arr = [];
                            $offer->getField('cranes_railway_min') ? $cap_arr[] = $offer->getField('cranes_railway_min') : '';
                            $offer->getField('cranes_gantry_min') ? $cap_arr[] = $offer->getField('cranes_gantry_min') : '';
                            $offer->getField('cranes_overhead_min') ? $cap_arr[] = $offer->getField('cranes_overhead_min') : '';
                            $offer->getField('cranes_cathead_min') ? $cap_arr[] = $offer->getField('cranes_cathead_min') : '';
                            $offer->getField('telphers_min') ? $cap_arr[] = $offer->getField('telphers_min') : '';
                            $capacity_all_min = min($cap_arr);



                            $cap_arr = [];
                            $offer->getField('cranes_railway_max') ? $cap_arr[] = $offer->getField('cranes_railway_max') : '';
                            $offer->getField('cranes_gantry_max') ? $cap_arr[] = $offer->getField('cranes_gantry_max') : '';
                            $offer->getField('cranes_overhead_max') ? $cap_arr[] = $offer->getField('cranes_overhead_max') : '';
                            $offer->getField('cranes_cathead_max') ? $cap_arr[] = $offer->getField('cranes_cathead_max') : '';
                            $offer->getField('telphers_max') ? $cap_arr[] = $offer->getField('telphers_max') : '';

                            $capacity_all_max = max($cap_arr);


                            ?>
                            <?= valuesCompare($capacity_all_min,$capacity_all_max)?> тонн
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="pdf-block">
            <div class="flex-box flex-between">
                <?if(is_file(PROJECT_ROOT.$offer->getJsonField('photos')[1])){?>
                    <?$photos = [1,2,3];?>
                    <?foreach($photos as $photo){?>
                        <div class="pdf-photo-row" >
                            <div class="background-fix pdf_photo-small" style="background-image: url('<?=photoHelper($offer->getJsonField('photos')[$photo])?>');">

                            </div>
                        </div>
                    <?}?>
                <?}?>
            </div>
        </div>
        <?if($offer->getJsonField('blocks')){?>
            <div class="pdf-block">
                <div class=" text-center isBold uppercase">
                    <div class="box-small-vertical text-center inline-block" style="border-bottom: 2px solid #9c2b09; width: 180px">
                        Варианты деления
                    </div>
                </div>
            </div>
            <div class="pdf-block">
                <div class="blocks-header  flex-box box-small-vertical " style="font-size: 10px;">
                    <div class="box-small" style=" width: 10%;">ID блока</div>
                    <?if(!$offer->getField('is_land')){?>
                        <div class="box-small" style=" width:5%;">Этаж</div>
                    <?}?>
                    <div class="box-small" style=" width:15%;">Площадь</div>
                    <?if($offer->getField('is_land')){?>
                        <div class="box-small" style=" width:15%;">Покрытие</div>
                        <div class="box-small" style=" width:10%;">Газ</div>
                        <div class="box-small" style=" width:10%;">Эл-во</div>
                        <div class="box-small" style=" width:10%;">Вода</div>
                        <div class="box-small" style=" width:10%;">Канализация</div>
                    <?}else{?>
                        <div class="box-small" style=" width:7%;">Высота</div>
                        <div class="box-small" style=" width:10%;">Тип пола</div>
                        <div class="box-small" style=" width:8%;">Ворота</div>
                        <div class="box-small" style=" width:10%;">Отопление</div>
                    <?}?>
                    <div class="box-small" style=" width:17%;">Ставка <b><?=$offer->getField('tax_form')?></b>   <span> м<sup>2</sup>/год</span></div>
                    <div class="box-small" style=" width:18%;">Итого, цена в месяц</div>
                </div>
            </div>
            <?$blocks = $offer->getJsonField('blocks')?>
            <?if($blocks){?>
                <?foreach($blocks as $block){?>
                    <?$blockMix = new OfferMix($block); ?>
                    <div class="pdf-block pdf-subitem">
                        <div class="flex-box">
                            <div class="box-small" style=" width: 10%;">
                                <?=$object->postId()?>-?
                            </div>
                            <?if(!$offer->getField('is_land')){?>
                                <div class="box-small" style=" width:5%;">
                                    <?=$blockMix->getField('floor_min')?>
                                </div>
                            <?}?>
                            <?if($offer->getField('is_land')){?>
                                <div class="box-small" style=" width:15%;">
                                    <?= $blockMix->getField('floor_type')?>
                                </div>
                                <div class="box-small" style=" width:5%;">
                                    <?= $blockMix->getField('gas')?>
                                </div>
                                <div class="box-small" style=" width:10%;">
                                    <?= $blockMix->getField('power')?> кВт
                                </div>
                                <div class="box-small" style=" width:5%;">
                                    <?= $blockMix->getField('floor_type')?>
                                </div>
                                <div class="box-small" style=" width:15%;">
                                    <?= $blockMix->getField('sewage')?>
                                </div>
                            <?}?>
                            <div class="box-small" style=" width:15%;">
                                <span class="isBold"><?= valuesCompare($blockMix->getField('area_min'),$blockMix->getField('area_max'))?></span>  м<sup>2</sup>
                            </div>
                            <div class="box-small" style=" width:7%;">
                                <?= valuesCompare($blockMix->getField('ceiling_height_min'),$blockMix->getField('ceiling_height_max'))?> м.
                            </div>
                            <div class="box-small" style=" width:10%;">
                                <?= $blockMix->getField('floor_type')?>
                            </div>
                            <div class="box-small" style=" width:8%;">
                                <?= explode(' ',$blockMix->getField('gate_type'))[0]?>
                            </div>
                            <div class="box-small" style=" width:10%;">
                                <?//=($blockMix->getField('heated')) ? 'теплый' : 'холодный'?>
                                <div>
                                    <?if($blockMix->getField('temperature_min')){?>
                                        <?=valuesCompare($blockMix->getField('temperature_min'),$blockMix->getField('temperature_max'))?>  °С
                                    <?}else{?>
                                        --
                                    <?}?>
                                </div>
                            </div>
                            <div class="box-small" style=" width:17%;">
                                <?$price = $blockMix->getField('price_floor_min')?>
                                <span class="isBold"><?=$price?></span> руб.
                            </div>
                            <div class="box-small " style=" width:18%;">
                                от <?=ceil($blockMix->getField('area_min')*$price/12)?> руб м<sup>2</sup>/мес
                            </div>
                        </div>
                    </div>
                <?}?>
            <?}?>
        <?}?>
        <?if($offer->getJsonField('blocks')){?>
            <?if($offer->getJsonField('photos')[4]){?>
                <?$photos = [4,5,6];?>
                <div class="pdf-block flex-box flex-between box-small-vertical">
                    <?foreach($photos as $photo){?>
                        <div class="pdf-photo-row">
                            <div class="background-fix pdf_photo-small" style="background-image: url('<?=photoHelper($offer->getJsonField('photos')[$photo])?>');">

                            </div>
                        </div>
                    <?}?>
                </div>
            <?}?>
        <?}?>
        <div class="pdf-block">
            <div class="text-center isBold uppercase" >
                <div class="box-small-vertical text-center inline-block" style="border-bottom: 2px solid #9c2b09; width: 300px">
                    Описание предложения
                </div>
            </div>
        </div>
        <div class="pdf-block">
            <div class="box-small-vertical text_left" style="font-size: 12px;">
                <?=$offer->getField('description')?>
            </div>
        </div>
        <div class="pdf-block">
            <?if($original_type == 1){?>
                <?if($offer->getJsonField('photos')[4]){?>
                    <?$photos = [4,5,6];?>
                    <div class="pdf-block flex-box flex-between">
                        <?foreach($photos as $photo){?>
                            <div class="pdf-photo-row">
                                <div class="background-fix pdf_photo-small" style="background-image: url('<?=photoHelper($offer->getJsonField('photos')[$photo])?>');">

                                </div>
                            </div>
                        <?}?>
                    </div>
                <?}?>
            <?}else{?>
                <div class="text-center background-fix box-shadow-strong" style="padding: 20px; color: white; background-image: url('<?=$offer->getJsonField('photos')[0]?>');  ">

                    <div class="" style="font-size:  15px">
                        Узнайте первым о новом, подходящем Вам предложении
                    </div>
                    <div class="box-small-vertical ghost" style="font-size:  10px">
                        Настройте параметры поиска подходящего Вам объекта и как только он появится на рынке система ватоматически пришлет его Вам на эл.почту
                    </div>
                    <div class="uppercase isUnderline box-small-vertical">
                        <a href="http://industry.realtor.ru" style="color: white; font-size: 20px">
                            industry.realtor.ru
                        </a>
                    </div>

                </div>
            <?}?>
        </div>
        <div class="pdf-block">
            <div class="offer-options">
                <div class="text-center isBold uppercase" >
                    <div class="box-small-vertical text-center inline-block" style="border-bottom: 2px solid #9c2b09; width: 300px">
                        Подробные параметры
                    </div>
                </div>
                <div class="flex-box flex-vertical-top">
                    <div class="object-about-section object-params-list col-2 half-flex box-small">
                        <div>
                            <div class="box-small isBold ghost">
                                <?if($offer->getField('deal_type') == 2){?>
                                    Площади в аренду
                                <?}elseif($offer->getField('deal_type') == 3){?>
                                    Площади на продажу
                                <?}else{?>
                                    Площади в аренду
                                <?}?>
                            </div>
                            <ul>
                                <li>
                                    <div>
                                        Свободная площадь:
                                    </div>
                                    <div>
                                        <?=valuesCompare($offer->getField('area_min'),$offer->getField('area_max'))?>
                                        <span>
                                    м<sup>2</sup>
                                </span>
                                    </div>
                                </li>
                                <?if(!$offer->getField('is_land')){?>
                                    <li>
                                        <div>
                                            Из них мезонин:
                                        </div>
                                        <div>
                                            <?=valuesCompare($offer->getField('area_mezzanine_min'),$offer->getField('area_mezzanine_max'))?>
                                            <span>
                                    м<sup>2</sup>
                                </span>
                                        </div>
                                    </li>
                                    <li>
                                        <div>
                                            Из них офисов:
                                        </div>
                                        <div>
                                            <?=valuesCompare($offer->getField('area_office_min'),$offer->getField('area_office_max'))?>
                                            <span>
                                    м<sup>2</sup>
                                </span>
                                        </div>
                                    </li>
                                    <li>
                                        <div>
                                            Вместимость:
                                        </div>
                                        <div>
                                            <?=valuesCompare($offer->getField('pallet_place_min'),$offer->getField('pallet_place_max'))?>
                                            <span>
                                    паллет-мест
                                </span>
                                        </div>
                                    </li>
                                    <li>
                                        <div>
                                            Уличное храненние:
                                        </div>
                                        <div>
                                            <?=valuesCompare($offer->getField('area_field_min'),$offer->getField('area_field_max'))?>
                                            <span>
                                    м<sup>2</sup>
                                </span>
                                        </div>
                                    </li>
                                <?}?>
                            </ul>
                        </div>
                        <div>
                            <div class="box-small isBold ghost">Характеристики</div>
                            <ul>
                                <?if($offer->getField('is_land')){?>
                                    <li>
                                        <div>
                                            Габариты участка:
                                        </div>
                                        <div>
                                            <?=$offer->getField('land_length')?><i class="fal fa-times"></i><?=$offer->getField('land_width')?>
                                            <span>
                                        м
                                    </span>
                                        </div>
                                    </li>
                                    <li>
                                        <div>
                                            Правовой статус земли:
                                        </div>
                                        <div>
                                            <?=$offer->getField('own_type_land')?>
                                        </div>
                                    </li>
                                    <li>
                                        <div>
                                            Категория:
                                        </div>
                                        <div>
                                            <?=$offer->getField('land_category')?>
                                        </div>
                                    </li>
                                    <li>
                                        <div>
                                            ВРИ:
                                        </div>
                                        <div>
                                            <?=$offer->getField('field_allow_usage')?>
                                        </div>
                                    </li>
                                <?}else{?>
                                    <li>
                                        <div>
                                            Этажность:
                                        </div>
                                        <div>
                                            <?=valuesCompare($offer->getField('floor_min'),$offer->getField('floor_max'))?>
                                            <span>
                                    этаж
                                </span>
                                        </div>
                                    </li>
                                    <li>
                                        <div>
                                            Класс объекта:
                                        </div>
                                        <div>
                                            <?=$object->showObjectStat('power' , '<span>кВт</span>' , '-') ?>
                                        </div>
                                    </li>
                                    <li>
                                        <div>
                                            Высота потолков:
                                        </div>
                                        <div>
                                            <?=valuesCompare($offer->getField('ceiling_height_min'),$offer->getField('ceiling_height_max'))?>
                                            <span>
                                    м
                                </span>
                                        </div>
                                    </li>
                                    <li>
                                        <div>
                                            Тип ворот:
                                        </div>
                                        <div>
                                            <?=$offer->getField('gate_type')?>
                                        </div>
                                    </li>
                                    <li>
                                        <div>
                                            Количество ворот:
                                        </div>
                                        <div>
                                            <?=$offer->getField('gate_num')?>
                                            <span>
                                    шт.
                                </span>
                                        </div>
                                    </li>
                                    <li>
                                        <div>
                                            Тип пола:
                                        </div>
                                        <div>
                                            <?=$offer->getField('floor_type')?>
                                        </div>
                                    </li>
                                    <li>
                                        <div>
                                            Стеллажи:
                                        </div>
                                        <div>
                                            (в процессе....)
                                        </div>
                                    </li>
                                    <li>
                                        <div>
                                            Нагрузка на пол:
                                        </div>
                                        <div>
                                            <?=valuesCompare($offer->getField('load_floor_min'),$offer->getField('load_floor_max'))?>
                                            <span>
                                    т/м<sup>2</sup>
                                </span>
                                        </div>
                                    </li>
                                    <li>
                                        <div>
                                            Нагрузка на мезонин:
                                        </div>
                                        <div>
                                            <?=valuesCompare($offer->getField('load_mezzanine_min'),$offer->getField('load_mezzanine_max'))?>
                                            <span>
                                    т/м<sup>2</sup>
                                </span>
                                        </div>
                                    </li>
                                    <li>
                                        <div>
                                            Температурный режим:
                                        </div>
                                        <div>
                                            <?=valuesCompare($offer->getField('temperature_min'),$offer->getField('temperature_max'))?>
                                            <span>
                                    C
                                </span>
                                        </div>
                                    </li>
                                    <li>
                                        <div>
                                            Шаг колон
                                        </div>
                                        <div>
                                            <?=$offer->getField('column_grid')?>
                                        </div>
                                    </li>
                                    <li>
                                        <div>
                                            Лифты/подъемники:
                                        </div>
                                        <div>
                                            <?=$offer->getField('elevators_num')?>
                                            <span>шт,</span>
                                            <?=valuesCompare($offer->getField('elevators_min'),$offer->getField('elevators_max'))?>
                                            <span>
                                    т.
                                </span>
                                        </div>
                                    </li>
                                    <li>
                                        <div>
                                            Внешняя отделка:
                                        </div>
                                        <div>
                                            <?=$offer->getField('facing')?>
                                        </div>
                                    </li>
                                <?}?>
                            </ul>
                        </div>
                        <div>
                            <div class="box-small isBold ghost">Безопасность</div>
                            <ul>
                                <li>
                                    <div>
                                        Охрана объекта:
                                    </div>
                                    <div>
                                        <?=($offer->getField('guard')) ? 'есть' : '-'?>
                                    </div>
                                </li>
                                <?if(!$offer->getField('is_land')){?>
                                    <li>
                                        <div>
                                            Пожаротушение:
                                        </div>
                                        <div>
                                            <?=($offer->getField('firefighting')) ? 'есть' : '-'?>
                                        </div>
                                    </li>
                                <?}?>
                                <li>
                                    <div>
                                        Видеонаблюдение:
                                    </div>
                                    <div>
                                        <?=($offer->getField('video_control')) ? 'есть' : '-'?>
                                    </div>
                                </li>
                                <li>
                                    <div>
                                        Контроль доступа:
                                    </div>
                                    <div>
                                        <?=($offer->getField('access_control')) ? 'есть' : '-'?>
                                    </div>
                                </li>
                                <?if(!$offer->getField('is_land')){?>
                                    <li>
                                        <div>
                                            Охранная сигнализация:
                                        </div>
                                        <div>
                                            <?=($offer->getField('security_alert')) ? 'есть' : '-'?>
                                        </div>
                                    </li>
                                    <li>
                                        <div>
                                            Пожарная сигнализация:
                                        </div>
                                        <div>
                                            <?=($offer->getField('fire_alert')) ? 'есть' : '-'?>
                                        </div>
                                    </li>
                                    <li>
                                        <div>
                                            Дымоудаление:
                                        </div>
                                        <div>
                                            <?=($offer->getField('smoke_exhaust')) ? 'есть' : '-'?>
                                        </div>
                                    </li>
                                <?}?>
                            </ul>
                        </div>
                    </div>
                    <div class="object-about-section object-params-list col-2 half-flex box-small">
                        <div>
                            <div class="box-small isBold ghost">Коммуникации</div>
                            <ul>
                                <li>
                                    <div>
                                        Электричество:
                                    </div>
                                    <div>
                                        <?=$object->showObjectStat('power' , '<span>кВт</span>' , '-') ?>
                                    </div>
                                </li>
                                <?if(!$offer->getField('is_land')){?>
                                    <li>
                                        <div>
                                            Отопление:
                                        </div>
                                        <div>
                                            <?=$offer->getField('heating')?>
                                        </div>
                                    </li>
                                <?}?>
                                <li>
                                    <div>
                                        Водоснабжение:
                                    </div>
                                    <div>
                                        <?=($offer->getField('water')) ? $offer->getField('water') : ''?>
                                        <?=$offer->getField('water_value')?>
                                        <span>
                                    м<sup>3</sup>/сут.
                                </span>
                                    </div>
                                </li>
                                <li>
                                    <div>
                                        Канализация центральная:
                                    </div>
                                    <div>
                                        <?=($offer->getField('sewage_central')) ? 'есть' : '-'?>
                                        <?=$offer->getField('sewage_central_value')?>
                                        <span>
                                    м<sup>3</sup>/сут.
                                </span>
                                    </div>
                                </li>
                                <li>
                                    <div>
                                        Канализация ливневая:
                                    </div>
                                    <div>
                                        <?=($offer->getField('sewage_rain')) ? 'есть' : '-'?>
                                    </div>
                                </li>
                                <?if(!$offer->getField('is_land')){?>
                                    <li>
                                        <div>
                                            Вентиляция:
                                        </div>
                                        <div>
                                            <?=$offer->getField('ventilation')?>
                                        </div>
                                    </li>
                                <?}?>
                                <li>
                                    <div>
                                        Газ:
                                    </div>
                                    <div>
                                        <?=($offer->getField('gas')) ? 'есть' : ''?>
                                        <?=$offer->getField('gas_value')?>
                                        <span>
                                    м<sup>3</sup>/час.
                                </span>
                                    </div>
                                </li>
                                <?if(!$offer->getField('is_land')){?>
                                    <li>
                                        <div>
                                            Пар:
                                        </div>
                                        <div>
                                            <?=($offer->getField('steam')) ? 'есть' : ''?>
                                            <?=$offer->getField('steam_value')?>
                                            <span>
                                    бар.
                                </span>
                                        </div>
                                    </li>
                                <?}?>
                                <li>
                                    <div>
                                        Телефония:
                                    </div>
                                    <div>
                                        <?=($offer->getField('gas')) ? 'есть' : ''?>
                                    </div>
                                </li>
                                <li>
                                    <div>
                                        Интернет:
                                    </div>
                                    <div>
                                        <?=$offer->getField('internet')?>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <div>
                            <div class="box-small isBold ghost">Ж/Д и крановые устройства</div>
                            <ul>
                                <li>
                                    <div>
                                        Ж/Д ветка:
                                    </div>
                                    <div>
                                        <?=($offer->getField('railway')) ? 'есть' : ''?>
                                        <?=$offer->getField('railway_value')?>
                                        <span>
                                    м.
                                </span>
                                    </div>
                                </li>
                                <li>
                                    <div>
                                        Козловые краны:
                                    </div>
                                    <div>
                                        <?=$offer->getField('cranes_gantry_num')?>
                                        <span>шт,</span>
                                        <?=valuesCompare($offer->getField('cranes_gantry_min'),$offer->getField('cranes_gantry_max'))?>
                                        <span>
                                    т.
                                </span>
                                    </div>
                                </li>
                                <li>
                                    <div>
                                        Ж/Д краны:
                                    </div>
                                    <div>
                                        <?=$offer->getField('cranes_railway_num')?>
                                        <span>шт,</span>
                                        <?=valuesCompare($offer->getField('cranes_railway_min'),$offer->getField('cranes_railway_max'))?>
                                        <span>
                                    т.
                                </span>
                                    </div>
                                </li>
                                <?if(!$offer->getField('is_land')){?>
                                    <li>
                                        <div>
                                            Мостовые краны:
                                        </div>
                                        <div>
                                            <?=$offer->getField('cranes_overhead_num')?>
                                            <span>шт,</span>
                                            <?=valuesCompare($offer->getField('cranes_overhead_min'),$offer->getField('cranes_overhead_max'))?>
                                            <span>
                                    т.
                                </span>
                                        </div>
                                    </li>
                                    <li>
                                        <div>
                                            Кран-балки:
                                        </div>
                                        <div>
                                            <?=$offer->getField('cranes_cathead_num')?>
                                            <span>шт,</span>
                                            <?=valuesCompare($offer->getField('cranes_cathead_min'),$offer->getField('cranes_cathead_max'))?>
                                            <span>
                                    т.
                                </span>
                                        </div>
                                    </li>
                                    <li>
                                        <div>
                                            Тельферы:
                                        </div>
                                        <div>
                                            <?=$offer->getField('telphers_num')?>
                                            <span>шт,</span>
                                            <?=valuesCompare($offer->getField('telphers_min'),$offer->getField('telphers_max'))?>
                                            <span>
                                    т.
                                </span>
                                        </div>
                                    </li>
                                <?}?>
                            </ul>
                        </div>
                        <div>
                            <div class="box-small isBold ghost">Инфраструктура</div>
                            <ul>
                                <li>
                                    <div>
                                        Въезд на территорию
                                    </div>
                                    <div>
                                        <?=$offer->getField('entry_territory')?>
                                    </div>
                                </li>
                                <li>
                                    <div>
                                        Парковка легковая
                                    </div>
                                    <div>
                                        <?=($offer->getField('parking_car')) ? 'есть' : '-'?>,
                                        <?=$offer->getField('parking_car_value')?>
                                    </div>
                                </li>
                                <li>
                                    <div>
                                        Парковка грузовая
                                    </div>
                                    <div>
                                        <?=($offer->getField('parking_truck')) ? 'есть' : '-'?>,
                                        <?=$offer->getField('parking_truck_value')?>
                                    </div>
                                </li>
                                <li>
                                    <div>
                                        Столовая/кафе
                                    </div>
                                    <div>
                                        <?=($offer->getField('canteen')) ? 'есть' : ''?>
                                    </div>
                                </li>
                                <li>
                                    <div>
                                        Общежитие
                                    </div>
                                    <div>
                                        <?=($offer->getField('hostel')) ? 'есть' : ''?>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="pdf-block">
            <div class="pdf-more background-fix  box-shadow-strong" style="background-image: url('<?=$offer->getJsonField('photos')[0]?>'); ">
                <div class="full-width flex-box  flex-around">
                    <div class="box isBold" style="color: #FFFFFF; font-size: 25px;">
                        Похожие предложения
                    </div>
                </div>
                <div class="flex-box flex-around flex-vertical-top" style="align-items: stretch">
                    <?$arr = [$offer_mix_id+1,$offer_mix_id+2,$offer_mix_id+3]?>
                    <?foreach($arr as $item){?>
                        <? $offer = new OfferMix($item)?>
                        <div class="pdf-more-card">
                            <div class="background-fix" style="background-image: url('<?=photoHelper(($offer->getJsonField('photos'))[0])?>')">

                            </div>
                            <div class="box-small">
                                <div>
                                    ID <?=$offer->getField('object_id')?>-9
                                </div>
                                <div class="isBold box-vertical">
                                    СК Лыткарино
                                </div>
                                <div class="ghost">
                            <span class="capitalized">
                                <?=$offer->getField('region')?>,
                            </span>
                                    <span class="capitalized">
                                <?=$offer->getField('highway')?>,
                            </span>
                                    <span>
                                 <?=$offer->getField('from_mkad')?>км
                            </span>
                                </div>
                                <div>
                                    <?=$offer->getField('area_max')?> м кв
                                </div>
                                <div>
                                    .
                                </div>
                                <div>
                                    от  <?=$offer->getField('price_min_month_all')?> р/ мес.
                                </div>
                                <div class="ghost">
                                    с НДС, дополнительно КУ
                                </div>
                            </div>
                        </div>
                    <?}?>
                </div>

            </div>
        </div>
    </div>





    <!-- not needed
    <div class="flex-box " style="border: 1px solid red; position: relative;">
        <div class="half-flex background-fix"  style="position: absolute; top: 0; right: 50%; bottom: 0; left :0; background-image: url('<?=$object->getJsonField('photo')[0]?>'); ">

        </div>
        <div class="half-flex box to-end" style="background: orange;">
            Аренда помещения под склад 56 000 кв.м по Каширское шоссе, Домодедово в 11 км от МКАД. Из них 9 780 кв.м на мезонине. Возможно деление площади от 10 000 кв.м. Высота потолков от 12 м. Полы - антипыль. Доступные ворота в блоке: 101 шт – докового типа. Свободные к аренде офисы в блоке: 4 757 кв.мпо цене 6000 руб за кв.м в год. Блок находится на 1 эт. Нагрузка на пол 6.00 т/м2. Сетка колонн: 12x24 м. Отапливаемый, приточно-вытяжная вентиляция, канализация, 10 000 кВт, объект под охраной. Помещение подходит под: алкогольный склад, фармацевтический склад, овощехранилище. Без комиссии. ID 2478-8.
        </div>
    </div>
    -->

</div>






</body>
</html>


<style>
    body{
        background: #282828;

    }
    .container {
        max-width: 840px;
        margin: 0 auto;
        font-family: DejaVu Sans, sans-serif;
        background: #ffffff;
    }

    .pdf-container-hidden{
        /*border-bottom: 1px solid black;*/
    }

    .pdf-header{
        height: 64px;

    }

    .pdf-content{
        height: 980px;
    }

    .pdf-footer{
        /*margin: auto 0 0 0;*/
        height: 64px;
        font-family: 'PF_DinText_Cond_Pro';

    }

    .pdf-page{
        font-family: 'PF_DinDisplay_Pro';
        /*height: 1188px;*/
        display: flex;
        flex-direction: column;
        height: 1120px;
        position: relative;
        padding: 0 10px;
        box-sizing: border-box;
        /*border-bottom: 1px solid red;*/
    }



    .pdf-photo-row{
        width: 250px;
    }

    .flex-box{
        display: flex;
    }

    .offer-options div ul li div:first-child{
        padding: 0 10px;
        box-sizing: border-box;
    }



    .flex-between{
        justify-content:  space-between;
    }

    .pdf-subitem{
        font-size: 10px;
    }
    .pdf-subitem:nth-child(2n+1){
        background: #c9cfff;
    }

    .flex-wrap{
        flex-wrap: wrap;
    }

    .one-third{
        box-sizing: border-box;
        width: 33.33%;
    }

    .two-third{
        box-sizing: border-box;
        width: 66.66%;
    }

    .background-fix{
        background-position: center center !important ;
        background-size: cover !important;
        background-repeat: no-repeat !important;
    }

    .inline-block{
        display: inline-block;
    }

    .full-width{
        width: 100%
    }

    .full-height{
        height: 100%;
    }

    .box{
        padding: 20px;
        box-sizing: border-box;
    }

    .box-small{
        padding: 10px;
        box-sizing: border-box;
    }

    .box-small-vertical{
        padding: 10px 0;
        box-sizing: border-box;
    }

    .pdf-button{
        background: #c9cfff;
        margin-right: 10px;
        color: #000000;
        text-transform: capitalize;
    }

    .purple-background{
        background: #c9cfff;
    }

    .purple-color{
        color: #c9cfff;
    }

    .object-option{
        height: 50%;
        border: 1px solid #e7e5f2;
    }

    .object-about-section ul > li >div:last-child{
        font-weight: bold;
    }

    .uppercase{
        text-transform: uppercase;
    }

    .to-end{
        margin-left: auto;
    }

    .isBold{
        font-weight: bold;
    }

    .text-center{
        text-align: center;
    }

    .capitalized{
        text-transform: capitalize;
    }

    .attention{
        color: #9c2b09;
    }

    .pdf_photo-big{
        -webkit-box-shadow: inset 0px 0px 218px 96px rgba(0,0,0,0.75);
        -moz-box-shadow: inset 0px 0px 218px 96px rgba(0,0,0,0.75);
        box-shadow: inset 0px 0px 218px 96px rgba(0,0,0,0.75);
    }

    .pdf_photo-small{
        height: 210px;
    }

    #map{
        height: 450px;
        background: #e1e1e1;
    }

    .controller{
        display: none !important;
    }
    .object-id{
        position: relative;
        background: #b02b00;
    }
    .object-id::after {
        content: '';
        position: absolute;
        left: 120px; bottom: 0px;
        border: 19px solid transparent;
        border-left: 19px solid #b02b00;
    }
    .blocks-body > div:nth-child(2n + 1){
        background: #c9cfff;
    }

    .blocks-body > div > div{
        /*border: 1px solid gainsboro;*/
    }

    .box-shadow-full{
        -webkit-box-shadow: inset 0px 0px 300px 0px rgba(0,0,0,0.75);
        -moz-box-shadow: inset 0px 0px 300px 0px rgba(0,0,0,0.75);
        box-shadow: inset 0px 0px 300px 0px rgba(0,0,0,0.75);
    }

    .box-shadow-strong{
        -webkit-box-shadow: inset 0px 0px 300px 105px rgba(0,0,0,0.75);
        -moz-box-shadow: inset 0px 0px 300px 105px rgba(0,0,0,0.75);
        box-shadow: inset 0px 0px 300px 105px rgba(0,0,0,0.75);
    }

    .pdf-more{
        padding-bottom: 20px;
    }

    .pdf-more-card{
        width :250px;
        background: #FFFFFF;
    }

    .pdf-more-card > div:first-child{
        width: 100%;
        height: 200px;
    }

</style>


<script>
    $(document).ready(function(){
        //alert('dfdfdfd');
        let page_height = 980;

        let blocks_sum = 0;

        let blocks = document.getElementsByClassName('pdf-block');

        for(let i = 0; i < blocks.length; i++ ){
            blocks_sum = blocks_sum + parseInt($(blocks[i]).css('height'));
        }
        //alert(blocks_sum);

        let page_num = Math.ceil(blocks_sum/page_height);

        //alert(page_num);
        let params = [];
        params.push('test=1');
        params.push('test1=1');
        for(let j = 0; j< page_num; j++){
            let res = sendAjaxRequestPost('https://pennylane.pro/templates/presentations/page.php',params,false);
            //alert(res);
            $('.pdf-pages').prepend(res);
        }

        let contents = document.getElementsByClassName('pdf-content');



        let curr_height = 0;
        let curr_page = 1;
        //alert(blocks.length);
        for(let i = 0; i < blocks.length; i++ ){
            //console.log('fgffgf');
            curr_height = curr_height + parseInt($(blocks[i]).css('height'));
            if(curr_height >= curr_page*page_height){
                curr_page++;
            }
            $(contents[curr_page - 1]).append(blocks[i]);


        }

        //alert('dfddf');





    });


    function sendAjaxRequestPost(url,params,async){
        let xhr = new XMLHttpRequest();
        xhr.open('POST', url, async);
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

        xhr.onreadystatechange = function() {
            if(xhr.readyState === 4 && xhr.status === 200){
                //alert(xhr.responseText + 'ответ от файла');
            }
        };
        xhr.send(params.join('&'));

        //!!!!!!!!если async TRUE то не возвращает значение (не успевает)
        return xhr.responseText;

    }
</script>