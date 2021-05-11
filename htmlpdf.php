<?php
//require_once($_SERVER['DOCUMENT_ROOT'].'/errors.php');

require_once($_SERVER['DOCUMENT_ROOT'].'/global_pass.php');

($router = Bitkit\Core\Routing\Router::getInstance())->setURL();

$original_id = $router->getPath()[1];
$original_type = $router->getPath()[2];
$user_id = $router->getPath()[3];

function photoHelper($file){
    //echo $file;
    if(($file)){
        //echo $file;
        $file = str_replace('//', '/', $file);
        $parts = explode('/',$file);
        $name = array_pop($parts);
        $post = array_pop($parts);
        return PROJECT_URL.'/system/controllers/photos/watermark.php/1200/'.$post.'/'.$name;
        //return PROJECT_URL.'/system/controllers/photos/watermark_all.php?width=1200&photo='.PROJECT_URL.$file;
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


$longitude = $offer->getField('longitude');
$latitude = $offer->getField('latitude');

//echo $latitude;
//echo "<br>";
//echo $longitude;


$test =  file_get_contents("https://static-maps.yandex.ru/1.x/?ll=$longitude,$latitude&size=275,450&z=9&l=map&pt=$longitude,$latitude,vkbkm");

$map_name = '/export/maps-tmp/map_'.$offer->getField('object_id').'.png';
file_put_contents(PROJECT_ROOT.$map_name,$test);


$offer_mix_id =  $offer->postId();
//echo $offer->postId();

$object = new Building($offer->getField('object_id'));

//изменит на агента по предложению
$agent = new Member($object->getField('agent_id'));


?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="<?=PROJECT_URL?>/css/fontawesome/css/all.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>



    <style>
        @font-face {
            font-family: "PF_DinDisplay_Pro";
            src: url("<?=PROJECT_URL?>/fonts/PFDinDisplayPro.eot");
            src: url("<?=PROJECT_URL?>/fonts/PFDinDisplayPro.eot?#iefix")format("embedded-opentype"),
            url("<?=PROJECT_URL?>/fonts/PFDinDisplayPro.ttf") format("woff"),
            url("<?=PROJECT_URL?>/fonts/PFDinDisplayPro.ttf") format("truetype");
            font-style: normal;
            font-weight: normal;
        }
        @font-face {
            font-family: "PF_DinText_Cond_Pro";
            src: url("<?=PROJECT_URL?>/fonts/PFDinTextCondPro.eot");
            src: url("<?=PROJECT_URL?>/fonts/PFDinTextCondPro.eot?#iefix")format("embedded-opentype"),
            url("<?=PROJECT_URL?>/fonts/PFDinTextCondPro.woff") format("woff"),
            url("<?=PROJECT_URL?>/fonts/PFDinTextCondPro.ttf") format("truetype");
            font-style: normal;
            font-weight: normal;
        }
        @font-face {
            font-family: "PF_DinText_Cond_Pro_Bold";
            src: url("<?=PROJECT_URL?>/fonts/PFDinTextCondPro-Bold.eot");
            src: url("<?=PROJECT_URL?>/fonts/PFDinTextCondPro-Bold.eot?#iefix")format("embedded-opentype"),
            url("<?=PROJECT_URL?>/fonts/PFDinTextCondPro-Bold.woff") format("woff"),
            url("<?=PROJECT_URL?>/fonts/PFDinTextCondPro-Bold.ttf") format("truetype");
            font-style: normal;
            font-weight: normal;
        }
        body{
            /*background: #282828;*/
            font-family: 'PF_DinText_Cond_Pro';
        }
        .font-cond-pro-bold{
            font-family: "PF_DinText_Cond_Pro_Bold";
        }
        .font-display-pro{
            font-family: "PF_DinDisplay_Pro";
        }
        ul{
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 2480px;
            margin: 0 auto;
            background: #ffffff;
        }

        .inline-block > div{
            display: inline-block;
        }

        .pdf-container-hidden{
            /*display: none;*/
            /*border-bottom: 1px solid black;*/
        }

        .pdf-header{
            padding: 72px 57px;
            box-sizing: border-box;

        }

        .pdf-content{
            height: 1610px;
            /*background: red;*/
        }

        .pdf-footer{
            /*margin: auto 0 0 0;*/
            height: 64px;
            font-family: 'PF_DinText_Cond_Pro';

        }
        .bg-fix{
            background-size: cover;
            background-position: center center;
            background-repeat: no-repeat;

        }

        .pdf-page{
            font-family: 'PF_DinDisplay_Pro';
            /*height: 1188px;*/
            display: flex;
            flex-direction: column;
            position: relative;
            padding: 0 10px;
            box-sizing: border-box;
            /*border-bottom: 1px solid red;*/
        }

        .pdf-block{
            /*background: grey;*/
        }

        .half-flex{
            width: 50%;
        }

        .box-small{
            padding: 20px;
            box-sizing: border-box;
        }



        .box-wide{
            padding: 0 20px;
            box-sizing: border-box;
        }

        .box-small-wide{
            padding: 0 57px;
            box-sizing: border-box;
        }





        .pdf-photo-row{
            width: 775px;
            height: 580px;
        }

        .flex-box{
            display: -webkit-box;
            display: -webkit-flex;
            display: flex;

        }

        .flex-box > div{
            flex-shrink: 0;
            flex-grow: 0;
        }

        .no-shrink{
            flex-shrink: 1;
        }

        .no-grow{
            flex-grow: 0;
        }

        .offer-options div ul li{
            display: -webkit-box;
            display: -webkit-flex;
            display: flex;
            list-style-type: none;
        }

        .offer-options div ul li > div{
            width: 50%;
        }

        .offer-options div ul li > div{
            padding: 0 20px;
            line-height: 70px;
            box-sizing: border-box;
            height: 70px;
        }

        .offer-options div ul li > div sup{
            line-height: 0px;

        }

        .offer-options div ul li:nth-child(2n+1){
            background: #f4f4f4;
        }


        .flex-between{
            justify-content:  space-between;
            -webkit-justify-content: space-between;
        }

        .pdf-subitem{
            font-size: 16px;
        }
        .pdf-subitem:nth-child(2n+1){
            background: #c9cfff;
        }
        .pdf-subitem > div > div{
            padding-top: 30px;
            padding-bottom: 30px;
        }

        .flex-wrap{
            -webkit-flex-wrap: wrap;
            flex-wrap: wrap;
            -ms-flex-wrap: wrap;
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
            padding: 40px;
            box-sizing: border-box;
        }



        .box-small-vertical{
            padding: 10px 0;
            box-sizing: border-box;
        }

        .pdf-button{
            background: #c9cfff;
            margin-right: 20px;
            padding: 20px 30px;
            color: #000000;
            font-size: 44px;
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
            font-size: 40px;
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

        .ftr a{
            text-decoration: none;
            color: black;
        }

        .isBold{
            font-weight: bold;
        }

        .ghost{
            color: #9E9E9E;
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
            left: 300px; bottom: 0px;
            border: 44px solid transparent;
            border-left: 44px solid #b02b00;
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
            -webkit-box-shadow: inset 0px 0px 300px 305px rgba(0,0,0,0.85);
            -moz-box-shadow: inset 0px 0px 300px 305px rgba(0,0,0,0.85);
            box-shadow: inset 0px 0px 300px 305px rgba(0,0,0,0.85);
        }

        .pdf-more{
            padding-bottom: 20px;
        }

        .pdf-more-card{
            width :350px;
            background: #FFFFFF;
        }

        .pdf-more-card > div:first-child{
            width: 100%;
            height: 300px;
        }

        sup{
            line-height: 0;
        }

    </style>

</head>
<body>


<div class="container">



    <div class="pdf-pages">

    </div>





    <div class="pdf-container-hidden">

        <?include PROJECT_ROOT.'/templates/presentations/header.php';?>
        <div class="pdf-block box-small-wide">
            <div class="flex-box flex-vertical-top">
                <div class=" background-fix pdf_photo-big text_left " style=" width: 1530px; height: 1180px; position: relative;  background: url('<?=photoHelper((($offer->getJsonField('photos'))[0]))?>')">
                    <div class="box-small object-id uppercase" style="font-size: 40px; color: white; width: 300px">
                        Объект <?=$object->postId()?>
                    </div>

                    <div class="box " style=" color: white; position: absolute; bottom:0; left: 0;">
                        <div class="font-cond-pro-bold" style="font-size: 140px; " >
                            <?=$offer->getField('title')?>
                        </div>
                        <div class="purple-color box-small-vertical" style="font-size: 56px;">
                            <?=$offer->getField('object_type_name')?>
                        </div>
                        <div class="flex-box" font-size: 48px;>
                            <?if($offer->getField('town')){?>
                                <div class="pdf-button box-small">
                                    <?=$offer->getField('town_name')?>
                                </div>
                            <?}?>
                            <?if ($offer->getField('highway')) {?>
                                <div class="pdf-button box-small">
                                    <?=$offer->getField('highway_name')?>
                                </div>
                            <?} elseif($offer->getField('highway_moscow')) {?>
                                <div class="pdf-button box-small">
                                    <?=$offer->getField('highway_moscow_name')?>
                                </div>
                            <? } else { ?>

                            <? } ?>
                            <?if($offer->getField('from_mkad')){?>
                                <div class="pdf-button box-small">
                                    <?=$offer->getField('from_mkad')?> км от МКАД
                                </div>
                            <?}?>
                        </div>
                    </div>
                </div>
                <div  style="height: 1180px; width: 21px;">

                </div>
                <div class="bg-fix"  style="border:1px solid #e7e5f2;  height: 1178px; width: 753px; max-width: 755px; min-width: 755px;  background-image: url('<?=PROJECT_URL?><?=$map_name?>'); " >

                </div>
            </div>
        </div>
        <div class="pdf-block" style="height: 62px;">

        </div>
        <div class="pdf-block">
            <div class="box-small-wide flex-box flex-between" >
                <div class="flex-box font-cond-pro-bold"  >
                    <div class="box" style="background: #e7e5f2; height: 350px; width: 650px;">
                        <div class="isBold uppercase " style="font-size: 40px;">
                            <div class="box-small">

                            </div>
                            площади
                            <?
                            if($offer->getField('type_id') != 3){
                                $deal_type = $offer->getField('deal_type');
                                if($deal_type == '2'){
                                    $val = 'на продажу';
                                    $area = $offer->getField('area_max');
                                    $smallest = $offer->getField('area_min');
                                    $price_min = $offer->getField('price_sale_min');
                                    $price_max = $offer->getField('price_sale_max');

                                }elseif($deal_type == '3'){
                                    $val = 'в отв. хранение';
                                    $area = $offer->getField('area_max');
                                    $smallest = $offer->getField('area_min');
                                    $price_min = $offer->getField('price_floor_min');
                                    $price_max = $offer->getField('price_floor_max');
                                }else{
                                    $val = 'в аренду';
                                    $area = $offer->getField('area_floor_max') + $offer->getField('area_mezzanine_max');
                                    $smallest = $offer->getField('area_min');
                                    $price_min = $offer->getField('price_floor_min');
                                    $price_max = $offer->getField('price_floor_max');
                                }
                            }else{
                                $val = 'объекта';
                                $area = $object->getField('area_building');
                            }
                            ?>
                            <?=$val?>
                        </div>
                        <div class="isBold box-small-vertical" style="font-size: 96px; font-family: 'PF_DinText_Cond_Pro_Bold'">
                            <?= numFormat($area)?> <span >м<sup>2</sup></span>
                        </div>
                        <div class="font-display-pro" style="font-size: 40px;">
                            <? if ($offer->getField('type_id') != 3) { ?>
                                <?if($smallest < $area){?>
                                    Деление от <span class="attention isBold"><?= numFormat($smallest)?> м<sup>2</sup></span>
                                <?}else{?>
                                    Деление не предполагается
                                <?}?>
                            <? } ?>
                        </div>
                    </div>
                    <div class=" box" style="width: 901px;  height: 350px; font-size: 40px;  border: 2px solid  #e7e5f2; ">
                        <? if ($offer->getField('type_id') != 3) { ?>
                        <div class="isBold uppercase">
                            <div class="box-small">

                            </div>
                            ставка за <span style="">м<sup>2</sup>
                                    <?if(in_array($offer->getField('deal_type'),[1,4])){?>
                                        /год
                                    <?}?>
                                </span>
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
                        <div class="attention isBold box-small-vertical" style="font-size: 96px; font-family: 'PF_DinText_Cond_Pro_Bold'">
                            <?if($price_min < $price_max){?>
                                от
                            <?}?>
                            <?if(!$price_min){
                                $price_min = $price_max;
                            }?>
                            <?= numFormat($price_min)?> руб.
                        </div>
                        <? } ?>
                        <div class="font-display-pro">
                            <?
                            $offer_stat = '';
                            if($offer->getField('tax_form') ){
                                if($offer->getField('tax_form') == 'triple net' && ($offer->getField('deal_type') == 1 || $offer->getField('deal_type') == 2) ){
                                    $offer_stat.= 'дополнительно OPEX и КУ';
                                }else{
                                    if(in_array($offer->getField('deal_type'),[1,4])){
                                        if(in_array($offer->getField('price_opex'),[2,3]) || in_array($offer->getField('price_public_services_inc'),[2,3])){
                                            $offer_stat.= 'дополнительно';
                                            if(in_array($offer->getField('price_opex_inc'),[2,3])){
                                                $offer_stat.= ' OPEX ';
                                            }
                                            if(in_array($offer->getField('price_public_services_inc'),[2,3])){
                                                $offer_stat.= ', КУ ';
                                            }
                                        }
                                    }

                                }
                            }

                            ?>
                            <?=$offer_stat?>
                        </div>
                    </div>
                </div>
                <div  style="height: 350px; width: 21px;">

                </div>
                <div class=" text-center font-display-pro" style="width: 775px; height:  350px; ">
                    <div class="flex-box flex-wrap">
                        <div class="box-small-vertical object-option" style="width: 257px; height: 175px;">
                            <div class="box-small" >
                                <img style="width: 55px;" src="<?=PROJECT_URL?>/img/pdf/icons/floors.png" />
                            </div>
                            <div>
                                <?= valuesCompare($offer->getfield('floor_min'),$offer->getField('floor_max'))?> этажи
                            </div>
                        </div>
                        <div class=" box-small-vertical object-option" style="width: 257px; height: 175px;">
                            <div class="box-small">
                                <img style="width: 70px;" src="<?=PROJECT_URL?>/img/pdf/icons/gates.png" />
                            </div>
                            <div>
                                <?=$offer->getField('gate_num')?> ворот
                            </div>
                        </div>
                        <div class=" box-small-vertical object-option" style="width: 257px; height: 175px;">
                            <div class="box-small">
                                <img style="width: 35px;" src="<?=PROJECT_URL?>/img/pdf/icons/power.png" />
                            </div>
                            <div>
                                <?if($object->getField('power')){?>
                                    <?= floor($object->getField('power'))?> кВТ
                                <?}else{?>
                                    -
                                <?}?>
                            </div>
                        </div>
                    </div>
                    <div class="flex-box flex-wrap">
                        <div class="box-small-vertical object-option" style="width: 257px; height: 175px;">
                            <div class="box-small">
                                <img style="width: 50px;" src="<?=PROJECT_URL?>/img/pdf/icons/height.png" />
                            </div>
                            <div>
                                <?= valuesCompare($offer->getField('ceiling_height_min'),$offer->getField('ceiling_height_max'))?>
                                м
                            </div>
                        </div>
                        <div class="one-third box-small object-option" style="width: 257px; height: 175px;">
                            <div class="box-small">
                                <img style="width: 35px;" src="<?=PROJECT_URL?>/img/pdf/icons/floor.png" />
                            </div>
                            <div>
                                <?=$offer->getField('floor_type')?>
                            </div>
                        </div>
                        <div class="one-third box-small object-option" style="width: 257px; height: 175px;">

                            <?if($offer->getField('cranes_min')){?>       м
                                <div class="box-small">
                                    <i class="fas fa-truck-loading"></i>
                                </div>
                                <div>
                                    <?= valuesCompare($offer->getField('cranes_min'),$offer->getField('cranes_max'))?> т.
                                </div>
                            <?}?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="pdf-block" style="height: 62px;">

        </div>
        <div class="pdf-block box-small-wide">
            <div class="flex-box flex-between">
                <?if(is_file(PROJECT_ROOT.$offer->getJsonField('photos')[1])){?>
                    <?//$photos = [1,2,3];?>
                    <?$photos = [1,2,3];?>
                    <?foreach($photos as $photo){?>
                        <div class="background-fix pdf_photo-small pdf-photo-row" style="width: 755px; background-image: url('<?=photoHelper($offer->getJsonField('photos')[$photo])?>');">

                        </div>
                        <?if($photo !=3){?>
                            <div  style="height: 150px; width: 21px;">

                            </div>
                        <?}?>
                    <?}?>
                <?}?>
            </div>
        </div>
        <?$blocks = $offer->getJsonField('blocks')?>

        <?$blocks_active =[]?>
        <?foreach($blocks as $block){?>
            <?$blockMix = new OfferMix($block); ?>
            <?if($blockMix->getField('status') == 1){
                $blocks_active[] = $block;
            }?>
        <?}?>
        <div class="pdf-block" style="height: 62px;">

        </div>
        <?if(count($blocks_active) > 1){?>
            <div class="pdf-block ">
                <div class=" text-center isBold uppercase">
                    <div class=" text-center inline-block"  style="border-bottom: 2px solid #9c2b09; width: 460px; font-size: 40px;">
                        Варианты деления
                    </div>
                </div>
            </div>
            <div class="pdf-block">
                <div class="blocks-header box-small-wide  flex-box " style="font-size: 32px;">
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
                    <div class="box-small" style=" width:17%;">Ставка <b><?=$area_tax?></b>   <span> м<sup>2</sup>/год</span></div>
                    <div class="box-small" style=" width:18%;">Итого, цена в месяц</div>
                </div>
            </div>

            <?if(count($blocks_active) > 1){?>
                <?$block_num = 0?>
                <?foreach($blocks_active as $block){?>
                    <?$blockMix = new OfferMix($block); ?>
                    <?if($blockMix->getField('status') == 1){?>
                        <?$block_num++?>
                        <div class="pdf-block pdf-subitem box-small-wide" style="font-size: 32px;">
                            <div class="flex-box">
                                <div class="box-small" style=" width: 10%;">
                                    <?=$object->postId()?>-<?=preg_split('//u',$offer->getOfferDealType(),-1,PREG_SPLIT_NO_EMPTY)[0]?>-<?=$block_num?>
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
                                        <?= $blockMix->getField('floor_types')?>
                                    </div>
                                    <div class="box-small" style=" width:15%;">
                                        <?= $blockMix->getField('sewage')?>
                                    </div>
                                <?}?>
                                <div class="box-small" style=" width:15%;">
                                    <span class="isBold"><?= valuesCompare(numFormat($blockMix->getField('area_min')),numFormat($blockMix->getField('area_max')))?></span>  м<sup>2</sup>
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
                                    <?=($blockMix->getField('heated')) ? 'теплый' : 'холодный'?>
                                    <div>
                                        <?if($blockMix->getField('temperature_min')){?>
                                            <?=valuesCompare($blockMix->getField('temperature_min'),$blockMix->getField('temperature_max'))?>  °С
                                        <?}else{?>
                                            --
                                        <?}?>
                                    </div>
                                </div>
                                <div class="box-small" style=" width:17%;">
                                    <?
                                    if($deal_type == '2'){
                                        $price_min = $blockMix->getField('price_sale_min');
                                        $price_max = $blockMix->getField('price_sale_max');
                                    }elseif($deal_type == '3'){
                                        $price_min = $blockMix->getField('price_floor_min');
                                        $price_max = $blockMix->getField('price_floor_max');
                                    }else{
                                        $price_min = $blockMix->getField('price_floor_min');
                                        $price_max = $blockMix->getField('price_floor_max');
                                    }
                                    ?>
                                    <?$price = $blockMix->getField('price_floor_min')?>
                                    <?if($price_min < $price_max){
                                        $range = 'от ';
                                    }else{
                                        $range = '';
                                    }?>
                                    <span class="isBold"><?=$range?><?= numFormat($price_min)?></span> руб.
                                </div>
                                <div class="box-small " style=" width:18%;">
                                    <?if($blockMix->getField('price_min_month_all') < $blockMix->getField('price_max_month_all')){
                                        $range = 'от ';
                                    }else{
                                        $range = '';
                                    }?>
                                    <?=$range?>
                                    <?= numFormat(ceil($blockMix->getField('price_min_month_all')))?> руб
                                </div>
                            </div>
                        </div>
                    <?}?>

                <?}?>
            <?}?>
        <?}else{?>
            <? $desc_yet = 1?>
            <div class="pdf-block box-small">
                <div class="text-center isBold uppercase" >
                    <div class="box-small-vertical text-center inline-block" style="border-bottom: 2px solid #9c2b09; width: 600px; font-size: 40px;">
                        Описание предложения
                    </div>
                </div>
                <br>
                <div class="box-small-wide text_left" style="font-size: 40px; line-height: 60px;">
                    <?$no_id = 1?>
                    <? if ($offer->getField('type_id') == 3) { ?>
                        <?=$offer->getField('description')?>
                    <? } else {?>
                        <? include ($_SERVER['DOCUMENT_ROOT']."/autodesc.php")?>
                    <? } ?>
                </div>
            </div>
        <?}?>



        <div style="page-break-before: always;">

        </div>

        <?include PROJECT_ROOT.'/templates/presentations/header.php';?>
        <div class="pdf-block box-small-wide">
            <div class="flex-box flex-between">
                <?if(is_file(PROJECT_ROOT.$offer->getJsonField('photos')[4])){?>
                    <?$photos = [4,5,6];?>
                    <?foreach($photos as $photo){?>
                        <div class="background-fix pdf_photo-small pdf-photo-row" style=" background-image: url('<?=photoHelper($offer->getJsonField('photos')[$photo])?>');">

                        </div>
                        <?if($photo !=3){?>
                            <div  style="height: 150px; width: 21px;">

                            </div>
                        <?}?>
                    <?}?>
                <?}?>
            </div>
        </div>
        <div class="pdf-block" style="height: 62px;">

        </div>
        <?if(!$desc_yet){?>
            <div class="pdf-block box-small-wide">
                <div class="text-center isBold uppercase" >
                    <div class=" text-center inline-block" style="border-bottom: 2px solid #9c2b09; width: 600px; font-size: 40px;">
                        Описание предложения
                    </div>
                </div>
                <br>
                <div class="box-small-vertical text_left" style="font-size: 40px; line-height: 60px;">
                    <?$no_id = 1?>
                    <? if ($offer->getField('type_id') == 3) { ?>
                        <?=$offer->getField('description')?>
                    <? } else {?>
                        <? include ($_SERVER['DOCUMENT_ROOT']."/autodesc.php")?>
                    <? } ?>
                </div>
            </div>
        <?}?>
        <div class="pdf-block" style="height: 62px;">

        </div>


        <div class="text-center background-fix box-shadow-strong" style="height: 420px; padding-top: 100px; box-sizing: border-box; color: white; background: url('<?=photoHelper(PROJECT_URL.(($offer->getJsonField('photos'))[0]))?>');  ">
            <div class="" style="font-size:  40px">
                Узнайте первым о новом, подходящем Вам предложении
            </div>
            <div class="box-small-vertical ghost" style="font-size:  30px">
                Настройте параметры поиска подходящего Вам объекта и как только он появится на рынке система ватоматически пришлет его Вам на эл.почту
            </div>
            <div class="uppercase isUnderline box-small-vertical">
                <a href="http://industry.realtor.ru" style="color: white; font-size: 50px">
                    industry.realtor.ru
                </a>
            </div>
        </div>
        <div class="pdf-block" style="height: 62px;">

        </div>
        <div style="page-break-before: always;">

        </div>
        <?include PROJECT_ROOT.'/templates/presentations/header.php';?>
        <div class="pdf-block box-small-wide">
            <div class="offer-options">
                <div class="text-center isBold uppercase" >
                    <div class="box-small-vertical text-center inline-block" style="border-bottom: 2px solid #9c2b09; width: 600px; font-size: 40px;">
                        Подробные параметры
                    </div>
                </div>
                <div class="flex-box flex-vertical-top" style="font-size: 40px;">
                    <div class="object-about-section object-params-list col-2 half-flex " style="padding-right: 40px; box-sizing: border-box;" >
                        <div>
                            <div class="box-small  ghost">
                                <?if($offer->getField('deal_type') == 2){?>
                                    Площади в аренду
                                <?}elseif($offer->getField('deal_type') == 3){?>
                                    Площади на продажу
                                <?}elseif($offer->getField('deal_type') == 1 || $offer->getField('deal_type') == 4){?>
                                    Площади в аренду
                                <?}else{?>
                                    Площади
                                <?}?>
                            </div>
                            <ul>
                                <li>
                                    <div>
                                        Свободная площадь:
                                    </div>
                                    <div>
                                        <?=valuesCompare(numFormat($offer->getField('area_min')),numFormat($offer->getField('area_max')))?>
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
                                            <?if($offer->getField('area_mezzanine_min')){?>
                                                <?=valuesCompare(numFormat($offer->getField('area_mezzanine_min')),numFormat($offer->getField('area_mezzanine_max')))?>
                                                <span>
                                                м<sup>2</sup>
                                             </span>
                                            <?}else{?>
                                                -
                                            <?}?>

                                        </div>
                                    </li>
                                    <li>
                                        <div>
                                            Из них офисов:
                                        </div>
                                        <div>
                                            <?if($offer->getField('area_office_min')){?>
                                                <?=valuesCompare(numFormat($offer->getField('area_office_min')),numFormat($offer->getField('area_office_max')))?>
                                                <span>
                                                м<sup>2</sup>
                                            </span>
                                            <?}else{?>
                                                -
                                            <?}?>
                                        </div>
                                    </li>
                                    <?if($offer->getField('pallet_place_min')){?>
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
                                    <?}?>
                                    <?if($offer->getField('area_field_min')){?>
                                        <li>
                                            <div>
                                                Уличное храненние:
                                            </div>
                                            <div>
                                                <?=valuesCompare(numFormat($offer->getField('area_field_min')),numFormat($offer->getField('area_field_max')))?>
                                                <span>
                                            м<sup>2</sup>
                                        </span>
                                            </div>
                                        </li>
                                    <?}?>
                                    <li>
                                        <div>

                                        </div>
                                        <div>

                                        </div>
                                    </li>
                                <?}?>
                            </ul>
                        </div>
                        <div>
                            <div class="box-small  ghost">Характеристики</div>
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
                                    <?if($offer->getField('class')){?>
                                        <li>
                                            <div>
                                                Класс объекта:
                                            </div>
                                            <div>
                                                <?=$offer->getField('class_name') ?>
                                            </div>
                                        </li>
                                    <?}?>
                                    <li>
                                        <div>
                                            Высота потолков:
                                        </div>
                                        <div>
                                            <?if($offer->getField('ceiling_height_min')){?>
                                            <?=valuesCompare($offer->getField('ceiling_height_min'),$offer->getField('ceiling_height_max'))?>
                                            <span>
                                            м
                                        <?}else{?>
                                            -
                                        <?}?>
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
                                            <?if($floor_type = $offer->getField('floor_type')){?>
                                                <?=$floor_type?>
                                            <?}else{?>
                                                -
                                            <?}?>
                                        </div>
                                    </li>
                                    <li>
                                        <div>
                                            Стеллажи:
                                        </div>
                                        <div>
                                            <?if($racks = $offer->getField('racks')){?>
                                                есть
                                            <?}else{?>
                                                -
                                            <?}?>
                                        </div>
                                    </li>
                                    <?if($offer->getField('load_floor_min')){?>
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
                                    <?}?>
                                    <?if($offer->getField('load_mezzanine_min')){?>
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
                                    <?}?>
                                    <?if($offer->getField('temperature_min')){?>
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
                                    <?}?>
                                    <li>
                                        <div>
                                            Шаг колон
                                        </div>
                                        <div>
                                            <?=$offer->getField('column_grid') ? $offer->getField('column_grid') : '-'?>
                                        </div>
                                    </li>
                                    <?if($offer->getField('elevators_num')){?>
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
                                    <?}?>
                                    <li>
                                        <div>
                                            Внешняя отделка:
                                        </div>
                                        <div>
                                            <?=($offer->getField('facing')!=0 ) ? $offer->getField('facing') :  '-'?>
                                        </div>
                                    </li>
                                    <li>
                                        <div>

                                        </div>
                                        <div>

                                        </div>
                                    </li>
                                <?}?>
                            </ul>
                        </div>
                        <div>
                            <div class="box-small ghost">Безопасность</div>
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
                                    <li>
                                        <div>

                                        </div>
                                        <div>

                                        </div>
                                    </li>
                                <?}?>
                            </ul>
                        </div>
                    </div>
                    <div class="object-about-section object-params-list col-2 half-flex" style="padding-left: 40px; box-sizing: border-box;">
                        <div>
                            <div class="box-small d ghost">Коммуникации</div>
                            <ul>
                                <li>
                                    <div>
                                        Электричество:
                                    </div>
                                    <div>
                                        <?if(($item = $object->getField('power')) != 0){?>
                                            <?= floor($item)?> <span> кВт</span>
                                        <?}else{?>
                                            -
                                        <?}?>
                                    </div>
                                </li>
                                <?if(!$offer->getField('is_land')){?>
                                    <li>
                                        <div>
                                            Отопление:
                                        </div>
                                        <div>
                                            <?if($offer->getField('heated')){?>
                                                Теплый
                                            <?}else{?>
                                                Холодный
                                            <?}?>
                                        </div>
                                    </li>
                                <?}?>
                                <li>
                                    <div>
                                        Водоснабжение:
                                    </div>
                                    <div>
                                        <?=($offer->getField('water')) ? $offer->getField('water') : ''?>
                                        <?if($water_value = $offer->getField('water_value')){?>
                                            <?=$water_value?>
                                            <span>
                                        м<sup>3</sup>/сут.
                                    </span>
                                        <?}?>
                                    </div>
                                </li>
                                <li>
                                    <div>
                                        Канализация центральная:
                                    </div>
                                    <div>
                                        <?=($offer->getField('sewage_central')) ? 'есть' : 'нет'?>
                                        <?if($water_value = $offer->getField('sewage_central_value')){?>
                                            <?=$water_value?>
                                            <span>
                                            м<sup>3</sup>/сут.
                                        </span>
                                        <?}?>
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
                                            <?= $offer->getField('ventilation')  ? $offer->getField('ventilation') :  '-'?>
                                        </div>
                                    </li>
                                <?}?>
                                <?if(!$offer->getField('gas')){?>
                                    <li>
                                        <div>
                                            Газ:
                                        </div>
                                        <div>
                                            <?if($offer->getField('gas')){?>
                                                <?=($offer->getField('gas')) ? 'есть' : ''?>
                                                <?= $offer->getField('gas_value')? $offer->getField('gas_value') : ''?>
                                                <span>
                                            м<sup>3</sup>/час.
                                        </span>
                                            <?}else{?>
                                                -
                                            <?}?>
                                        </div>
                                    </li>
                                <?}?>
                                <?if(!$offer->getField('steam')){?>
                                    <li>
                                        <div>
                                            Пар:
                                        </div>
                                        <div>
                                            <?if($offer->getField('steam')){?>
                                                <?=($offer->getField('steam')) ? 'есть' : ''?>
                                                <?= $offer->getField('steam_value')? $offer->getField('steam_value') : ''?>
                                                <span>
                                                бар.
                                            </span>
                                            <?}else{?>
                                                -
                                            <?}?>
                                        </div>
                                    </li>
                                <?}?>
                                <li>
                                    <div>
                                        Телефония:
                                    </div>
                                    <div>
                                        <?=($offer->getField('phone')) ? 'есть' : '-'?>
                                    </div>
                                </li>
                                <li>
                                    <div>
                                        Интернет:
                                    </div>
                                    <div>
                                        <?//=( ( $item = $offer->getField('internet')) !=0 ) ? $item :  '-'?>
                                        <?= $offer->getField('internet') ? 'да' : '-'    ?>
                                    </div>
                                </li>
                                <li>
                                    <div>

                                    </div>
                                    <div>

                                    </div>
                                </li>
                            </ul>
                        </div>
                        <div>
                            <?
                            $cranes_arr = [
                                'railway',
                                'cranes_gantry_num',
                                'cranes_railway_num',
                                'cranes_overhead_num',
                                'cranes_cathead_num',
                                'telphers_num',
                            ];

                            $has_cranes = 0;
                            foreach ($cranes_arr as $elem){
                                if($offer->getField($elem)){
                                    $has_cranes = 1;
                                    break;
                                }
                            }
                            ?>

                            <?if($has_cranes){?>
                                <ul>
                                    <div class="box-small  ghost">Ж/Д и крановые устройства</div>
                                    <?if($offer->getField('railway')){?>
                                        <li>
                                            <div>
                                                Ж/Д ветка:
                                            </div>
                                            <div>
                                                <?=($offer->getField('railway') == 1) ? 'есть' : 'нет'?>
                                                <?if($offer->getField('railway_value')){?>
                                                    <?=$offer->getField('railway_value')?>
                                                    <span>м.</span>
                                                <?}?>
                                            </div>
                                        </li>
                                    <?}?>
                                    <?if($offer->getField('cranes_min') > 0){?>
                                        <li>
                                            <div>
                                                Краны
                                            </div>
                                            <div>
                                                <?= valuesCompare($offer->getField('cranes_min'),$offer->getField('cranes_max'))  ?> т
                                            </div>
                                        </li>
                                    <?}?>
                                    <?/*if($offer->getField('cranes_gantry_num')){?>
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
                                    <?}?>
                                    <?if($offer->getField('cranes_railway_num')){?>
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
                                    <?}?>
                                    <?if(!$offer->getField('is_land')){?>
                                        <?if($offer->getField('cranes_overhead_num')){?>
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
                                        <?}?>
                                        <?if($offer->getField('cranes_cathead_num')){?>
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
                                        <?}?>
                                        <?if($offer->getField('telphers_num')){?>
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
                                    <?}*/?>
                                </ul>

                            <?}?>

                        </div>
                        <?
                        $infra_arr = [
                            'entry_territory',
                            'parking_car',
                            'parking_lorry',
                            'parking_truck',
                            'canteen',
                            'hostel',
                        ];

                        $has_infra = 0;
                        foreach ($infra_arr as $elem){
                            if($offer->getField($elem)){
                                $has_infra = 1;
                                break;
                            }
                        }
                        ?>
                        <?if($has_infra){?>
                            <div>
                                <div class="box-small  ghost">Инфраструктура</div>
                                <ul>
                                    <?if($offer->getField('entry_territory')){?>
                                        <li>
                                            <div>
                                                Въезд на территорию
                                            </div>
                                            <div>
                                                <?=$offer->getField('entry_territory')?>
                                            </div>
                                        </li>
                                    <?}?>
                                    <?if($offer->getField('parking_car')){?>
                                        <li>
                                            <div>
                                                Парковка легковая
                                            </div>
                                            <div>
                                                <?=($offer->getField('parking_car')) ? 'есть' : '-'?>
                                                <?if($offer->getField('parking_car_value')>0){?>
                                                    ,
                                                    <?= $offer->getField('parking_car_value')?>
                                                <?}?>

                                            </div>
                                        </li>
                                    <?}?>
                                    <?if($offer->getField('parking_lorry')){?>
                                        <li>
                                            <div>
                                                Парковка 3-10т
                                            </div>
                                            <div>
                                                <?=($offer->getField('parking_lorry')) ? 'есть' : '-'?>
                                                <?if($offer->getField('parking_lorry_value')>0){?>
                                                    ,
                                                    <?= $offer->getField('parking_lorry_value')?>
                                                <?}?>
                                            </div>
                                        </li>
                                    <?}?>
                                    <?if($offer->getField('parking_truck')){?>
                                        <li>
                                            <div>
                                                Парковка грузовая
                                            </div>
                                            <div>
                                                <?=($offer->getField('parking_truck')) ? 'есть' : '-'?>
                                                <?if($offer->getField('parking_truck_value')>0){?>
                                                    ,
                                                    <?=$offer->getField('parking_truck_value')?>
                                                <?}?>
                                            </div>
                                        </li>
                                    <?}?>
                                    <?if($offer->getField('canteen')){?>
                                        <li>
                                            <div>
                                                Столовая/кафе
                                            </div>
                                            <div>
                                                <?=($offer->getField('canteen')) ? 'есть' : ''?>
                                            </div>
                                        </li>
                                    <?}?>
                                    <?if($offer->getField('hostel')){?>
                                        <li>
                                            <div>
                                                Общежитие
                                            </div>
                                            <div>
                                                <?=($offer->getField('hostel')) ? 'есть' : ''?>
                                            </div>
                                        </li>
                                    <?}?>
                                </ul>
                            </div>
                        <?}?>
                    </div>
                </div>
            </div>
        </div>








        <!--
    <div class="pdf-block">
        <div class="pdf-more background-fix box  box-shadow-strong" style="background-image: url('<?=$offer->getJsonField('photos')[0]?>'); ">
            <div class="full-width flex-box  flex-around " style="text-align: center; ">
                <div class="box isBold  uppercase" style="width: 100%; color: #FFFFFF; font-size: 25px; font-family: 'PF_DinText_Cond_Pro_Bold' ">
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
                                    <?=$offer->getField('region_name')?>,
                                </span>
                                <span class="capitalized">
                                    <?=$offer->getField('highway_name')?>,
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
                    <?if($item != $offer_mix_id+3){?>
                        <div style="width: 20px;">

                        </div>
                    <?}?>
                <?}?>
            </div>

        </div>
    </div>
    -->

    </div>





</div>












<script>


    /*


    function sendAjaxRequestPost(url,params,async){
        var xhr = new XMLHttpRequest();
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



    function test(){
        var page_height = 1610;

        var blocks_sum = 0;

        var blocks = document.getElementsByClassName('pdf-block');

        for(var i = 0; i < blocks.length; i++ ){
            blocks_sum = blocks_sum + parseInt($(blocks[i]).css('height'));
            //alert(parseInt($(blocks[i]).css('height')));
        }
        //alert(blocks_sum);

        var page_num = Math.ceil(blocks_sum/page_height);

        //alert(page_num);
        var params = [];
        params.push('test=1');
        params.push('test1=1');
        for(var j = 0; j< page_num; j++){
            var res = sendAjaxRequestPost('https://pennylane.pro/templates/presentations/page.php',params,false);
            //alert(res);
            $('.pdf-pages').prepend(res);
        }

        var contents = document.getElementsByClassName('pdf-content');

        var curr_height = 0;
        var curr_page = 1;
        //alert(blocks.length);

        for(var k = 0; k < blocks.length; k++ ){
            //console.log('fgffgf');
            var curr_block_height = parseInt($(blocks[k]).css('height'));


            if(curr_block_height > 600 ){
               curr_block_height = 600;
            }
            curr_height = curr_height + curr_block_height;

            if(curr_height >= curr_page*page_height){
                curr_page++;
            }

            $(contents[curr_page - 1]).append(blocks[k]);
            $(contents[curr_page - 1]).append(curr_block_height+'-- ');
            //$(contents[curr_page - 1]).append(curr_height+'-- ');
            //$(contents[curr_page - 1]).append('Текущ страница='+curr_page);
        }



        $('.pdf-container-hidden').hide();
        //$('.pdf-pages').html(page_num);

    }

    test();

    */










</script>

<?
unlink(PROJECT_URL.$map_name);
?>

</body>
</html>
