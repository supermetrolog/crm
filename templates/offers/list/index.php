<?php
/**
 * Created by PhpStorm.
 * User: Zhitkov
 * Date: 24.07.2018
 * Time: 13:16
 */


$object = new Building($offer->getField('object_id'));
$offers_near = $offer->getOfferNeighbors();
$complex = new Complex($object->getField('complex_id'));
if($complex->getField('location_id')){
    $location = new Location($complex->getField('location_id'));
}
$offer_status = $offer->getOfferStatus();

//include_once($_SERVER['DOCUMENT_ROOT'].'/errors.php');

?>

<div class="object-item <?=( ! $offer->isActive()  )? 'ghost-double' : ''?>" >
    <div class="">
        <div class="object-grid object-list-template">
            <div class="obj-col-1 flex-column " style="position: relative; display: flex;  ">

                <div class="full-width flex-box flex-center">
                    <a href="/complex/<?=$object->getField('complex_id')?>?offer_id=[<?=$offer->postId()?>]" class="a-classic" target="_blank"><?=$object->itemId()?></a>-<?=preg_split('//u',$offer->getOfferDealType(),-1,PREG_SPLIT_NO_EMPTY)[0]?>
                </div>
                <!--
                <div class="full-width flex-box flex-center">
                    <a href="/object/<?=$object->itemId()?>?offer_id=<?=$offer->postId()?>" class="a-classic" target="_blank"><?=$object->itemId()?></a>-<?=preg_split('//u',$offer->getOfferDealType(),-1,PREG_SPLIT_NO_EMPTY)[0]?>
                </div>
                -->
                <?if($logedUser->member_id() == 142){?>
                    <div class="full-width flex-box flex-center">
                        <a href="/complex/<?=$object->getField('complex_id')?>?offer_id=[<?=$offer->postId()?>]" class="a-classic" target="_blank"><?=$object->getField('complex_id')?></a>-<?=preg_split('//u',$offer->getOfferDealType(),-1,PREG_SPLIT_NO_EMPTY)[0]?>
                    </div>
                <?}?>
                <?if(count($offer->subItemsId()) > 1){?>
                    <div class="flex-box flex-center to-end-vertical full-width">
                        <div class="catalog-blocks-switch pointer  icon-round " title="Показать/скрыть блоки">
                            <i class="fas fa-angle-down"></i>
                        </div>
                    </div>
                <?}?>
            </div>
            <div class="obj-col-2" >
                <div style=" font-size: 12px;">
                    <span class="isBold attention">
                        <?if($offer->getField('deal_type') == 2){?>
                            Продажа
                        <?}elseif($offer->getField('deal_type') == 3){?>
                            Ответ. хранение
                        <?}elseif($offer->getField('deal_type') == 4){?>
                            Субаренда
                        <?}else{?>
                            Прямая аренда
                        <?}?>
                    </span>
                    <span class="ghost" >
                        <?if(!$object->getField('is_land')){?>
                             , класс <?=$object->classType()?>
                        <?}?>
                    </span>
                </div>
                <div class="">
                    <i class=""></i>
                    <b><?=$complex->title()?></b>
                </div>
                <div class="">
                    <i class=""></i>
                    <?=$object->getField('address')?>
                </div>
                <div style="position: relative">
                    <?if($offer->gF('is_exclusive') || $offer->gF('rent_business')){?>
                        <div class="" style="position: absolute; top: 10px; ">
                            <?if($object->gF('test_only')){?>
                                <div style="background: #6bb93f; color: white; padding: 0 5px">
                                    ТЕСТОВЫЙ ЛОТ!!!!
                                </div>
                            <?}?>
                            <?if($offer->getField('contract_is_signed_type') == 2){?>
                                <div style="background: #d36f2c; color: white; padding: 0 5px">
                                    Эксклюзив
                                </div>

                            <?}?>
                            <?if($offer->gF('rent_business')){?>
                                <div style="background: #6c89cc; color: white; padding: 0 5px">
                                    Инвестпроект
                                </div>
                            <?}?>
                        </div>
                    <?}?>
                    <a href="/complex/<?=$object->getField('complex_id')?>?offer_id=[<?=$offer->postId()?>]" target="_blank">
                        <?$photo = explode('/',str_replace('//','/',$object->getJsonField('photo')[0]))?>
                        <? $name = urldecode(array_pop($photo))?>
                        <? $post = array_pop($photo)?>

                        <img class="full-width" src="<?=PROJECT_URL.'/system/controllers/photos/thumb.php/300/'.$post.'/'.$name?>" />

                        <?/*
                        <? $photo = array_pop(explode('/',$object->getJsonField('photo')[0]))?>
                        <img src="<?=PROJECT_URL.'/system/controllers/photos/thumb_all.php?width=300&photo='.PROJECT_ROOT.$object->getJsonField('photo')[0] ?>" class="full-width" />
                        */?>
                    </a>
                </div>
                <div class="card-top-pictograms box-vertical">
                    <ul>
                        <? if(arrayIsNotEmpty($object->purposes())){?>
                            <?//var_dump($object->purposes())?>
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
            <div class="for-region obj-col-3">
                <div class="ghost" style="font-size: 12px">
                    <?if($complex->getField('location_id')){?>
                        <?= $location->getLocationRegion()?>
                    <?}?>
                </div>
                <div>
                    <?if($complex->getField('location_id')){?>
                        <?if($location->getField('district_moscow')){?>
                            <?$townMain = new Post($location->getField('district_moscow'))?>
                            <?$townMain->getTable('l_districts_moscow')?>
                            <?=$townMain->title()?>
                            <br>
                        <?}?>
                        <?if($location->getField('direction')){?>
                            <?=$location->getLocationDirection()?><br>
                        <?}?>
                        <div class="ghost" style="font-size: 12px">
                            <?if($location->getLocationHighway()){?><?=$location->getLocationHighway()?><?}?>
                            <?if($location->getLocationHighwayMoscow()){?><?=$location->getLocationHighwayMoscow()?><?}?>
                        </div>

                    <?}?>
                </div>
            </div>
            <div class="for-otmkad obj-col-4">
                <div class="" style="height: 12px;">

                </div>
                <?if($complex->getField('from_mkad')){?>
                    <?=$complex->getField('from_mkad')?> км
                <?}?>
            </div>
            <div class="for-area obj-col-5">
                <div class="box-vertical" style="position: relative">
                    <?if($filters_arr->status == 0){?>
                        <div>
                            <div class="ghost" style="font-size: 12px; position: absolute; top: -5px;">
                                Площадь
                                <?if($object->getField('is_land')){?>
                                    участка
                                <?}else{?>
                                    объекта
                                <?}?>
                            </div>
                            <div class="isBold">
                                <?if($object->getField('area_building')){?>
                                    <?= numFormat($object->getField('area_building'))?>
                                <?}else{?>
                                    <?= numFormat($object->getField('area_field_full'))?>
                                <?}?>
                                <span style="font-size: 10px;">м<sup>2</sup></span>
                            </div>
                            <?if($offer->getOfferBlocksMinValue('area_mezzanine_min')){?>
                                <div class="ghost" style="font-size: 12px;">
                                    <?= numFormat($object->getField('area_mezzanine_full') )?> <span style="font-size: 10px;">м<sup>2</sup></span> - мезанин
                                </div>
                            <?}?>
                            <?if($offer->getOfferBlocksMinValue('area_office_min')){?>
                                <div class="ghost" style="font-size: 12px;">
                                    <?= numFormat($object->getField('area_office_full'))?> <span style="font-size: 10px;">м<sup>2</sup></span> - офисы
                                </div>
                            <?}?>
                        </div>
                        <div class="box-small">

                        </div>
                    <?}?>

                    <?if($filters_arr->status == 0 || $filters_arr->status == 1){?>
                        <div>
                            <div class="flex-box">
                                <div class="round-green">

                                </div>
                                <div class="box-wide" style="font-size: 12px;">
                                    <?if($offer->getField('built_to_suit') == 1){?>
                                        <div class="ghost" style="font-size: 12px;">
                                            <div class="flex-box">
                                                <div>
                                                    <?if($offer->getField('deal_type') == 2){?>
                                                        BTS
                                                    <?}else{?>
                                                        BTR
                                                    <?}?>
                                                </div>
                                                <?if($offer->getField('built_to_suit_time')){?>
                                                    <div>
                                                        / <?=$offer->getField('built_to_suit_time')?> мес
                                                    </div>
                                                <?}?>
                                            </div>
                                            <?/*if($offer->getField('built_to_suit_plan')){?>
                                                <div>
                                                    проект имеется
                                                </div>
                                            <?}*/?>
                                        </div>
                                    <?}else{?>
                                        <span class="ghost ">Актив</span>
                                    <?}?>
                                </div>
                            </div>
                            <div>
                                <div class="isBold">
                                    <?if($offer->getOfferBlocksMinValue('area_floor_min')){?>
                                        <?=valuesCompare(numFormat($offer->getOfferSumAreaMin()), numFormat($offer->getOfferSumAreaMax()))?>
                                        <span style="font-size: 10px;">м<sup>2</sup></span>
                                    <?}else{?>
                                        -
                                    <?}?>
                                </div>
                                <?if($offer->getOfferBlocksMinValue('area_mezzanine_min')){?>
                                    <div class="ghost" style="font-size: 12px;">
                                        <?= numFormat($offer->getOfferBlocksMaxSumValue('area_mezzanine_max'))?> <span style="font-size: 10px;">м<sup>2</sup></span> - мезанин
                                    </div>
                                <?}?>
                                <?if($offer->getOfferBlocksMinValue('area_office_min')){?>
                                    <div class="ghost" style="font-size: 12px;">
                                        <?= numFormat($offer->getOfferBlocksMaxSumValue('area_office_max'))?> <span style="font-size: 10px;">м<sup>2</sup></span> - офисы
                                    </div>
                                <?}?>
                            </div>
                        </div>
                        <div class="box-small">

                        </div>
                    <?}?>

                    <?//if($filters_arr->status == 0 || $filters_arr->status == 2){?>
                    <?if(0){?>
                        <div>
                            <div class="flex-box" style="font-size: 12px;">
                                <div class="round-red">

                                </div>
                                <div class="ghost box-wide">
                                    <?if($offer->getField('deal_type') == 2){?>
                                        Продано
                                    <?}else{?>
                                        Сдано
                                    <?}?>
                                </div>
                            </div>
                            <div>
                                <div class="isBold">
                                    <?if($offer->getOfferBlocksMinValue('area_floor_min')){?>
                                        <?=numFormat($object->getField('area_building') - $offer->getOfferSumAreaMax())?>
                                        <span style="font-size: 10px;">м<sup>2</sup></span>
                                    <?}else{?>
                                        -
                                    <?}?>
                                </div>
                                <?if($offer->getOfferBlocksMinValue('area_mezzanine_min')){?>
                                    <div class="ghost" style="font-size: 12px;">
                                        <?= numFormat($object->getField('area_mezzanine_full') -$offer->getOfferBlocksMaxSumValue('area_mezzanine_max'))?> <span style="font-size: 10px;">м<sup>2</sup></span> - мезанин
                                    </div>
                                <?}?>
                                <?if($offer->getOfferBlocksMinValue('area_office_min')){?>
                                    <div class="ghost" style="font-size: 12px;">
                                        <?= numFormat($object->getField('area_office_full') - $offer->getOfferBlocksMaxSumValue('area_office_max'))?> <span style="font-size: 10px;">м<sup>2</sup></span> - офисы
                                    </div>
                                <?}?>
                            </div>
                        </div>
                    <?}?>



                </div>
            </div>
            <div class="for-price obj-col-6">
                <div class="box-vertical" style="position: relative">
                    <?if($filters_arr->status == 1){?>
                        <?$price_min_func = 'getOfferBlocksMinValue';?>
                        <?$price_max_func = 'getOfferBlocksMaxValue';?>
                        <?$area_min_func = 'getOfferSumAreaMin';?>
                        <?$area_max_func = 'getOfferSumAreaMax';?>
                    <?}elseif ($filters_arr->status == 2){?>
                        <?$price_min_func = 'getOfferBlocksMinValuePassive';?>
                        <?$price_max_func = 'getOfferBlocksMaxValuePassive';?>
                        <?$area_min_func = 'getOfferSumAreaMinPassive';?>
                        <?$area_max_func = 'getOfferSumAreaMaxPassive';?>
                    <?}else{?>
                        <?$price_min_func = 'getOfferBlocksMinValueAll';?>
                        <?$price_max_func = 'getOfferBlocksMaxValueAll';?>
                        <?$area_min_func = 'getOfferSumAreaMinAll';?>
                        <?$area_max_func = 'getOfferSumAreaMaxAll';?>
                    <?}?>
                    <?if($filters_arr->price_format == 1){?>
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
                        ];

                        $prices_min = [];
                        $prices_max = [];

                        foreach($arr_fields_prices_rent as $price){
                            $prices_min[] = $offer->getOfferBlocksMinValue($price.'_min');
                            $prices_max[] = $offer->getOfferBlocksMaxValue($price.'_max');
                        }

                        $price_min = getArrayMin($prices_min);
                        $price_max = max($prices_max);
                        //$price_min = $offer->$price_min_func('price_floor_min');
                        //$price_max = $offer->$price_max_func('price_floor_max');
                        $dim = 'м<sup>2</sup>/год';
                        ?>
                    <?}elseif($filters_arr->price_format == 2){?>
                        <?
                        $price_min = $offer->$price_min_func('price_floor_min')/12;
                        $price_max = $offer->$price_max_func('price_floor_max')/12;
                        $dim = 'м<sup>2</sup>/мес';
                        ?>
                    <?}elseif($filters_arr->price_format == 3){?>
                        <?
                        $price_min = ($offer->$price_min_func('price_floor_min')/12)*$offer->$area_min_func();
                        $price_max = ($offer->$price_max_func('price_floor_max')/12)*$offer->$area_max_func();
                        $dim = 'в месяц';
                        ?>
                    <?}elseif($filters_arr->price_format == 4){?>
                        <?
                        $price_min = $offer->$price_min_func('price_sale_min');
                        $price_max = $offer->$price_max_func('price_sale_max');
                        $dim = 'м<sup>2';
                        ?>
                    <?}elseif($filters_arr->price_format == 5){?>
                        <?
                        $price_min = $offer->$price_min_func('price_sale_min')*$offer->$area_min_func();
                        $price_max = $offer->$price_max_func('price_sale_max')*$offer->$area_max_func();
                        $dim = 'все';
                        ?>
                    <?}elseif($filters_arr->price_format == 6){?>
                        <?
                        $price_min = $offer->$price_min_func('price_sale_min')*100;
                        $price_max = $offer->$price_max_func('price_sale_max')*100;
                        $dim = 'сотку';
                        ?>
                    <?}elseif($filters_arr->price_format == 7){?>
                        <?
                        $price_min = $offer->$price_min_func('price_safe_pallet_eu_min');
                        $price_max = $offer->$price_max_func('price_safe_pallet_eu_max');
                        $dim = 'п.м./сут';
                        ?>
                    <?}elseif($filters_arr->price_format == 8){?>
                        <?
                        $price_min = $offer->$price_min_func('price_safe_volume_min');
                        $price_max = $offer->$price_max_func('price_safe_volume_max');
                        $dim = 'м<sup >3</sup>/сут';
                        ?>
                    <?}elseif($filters_arr->price_format == 9){?>
                        <?
                        $price_min = $offer->$price_min_func('price_safe_floor_min');
                        $price_max = $offer->$price_max_func('price_safe_floor_max');
                        $dim = 'м<sup>2</sup>/сут';
                        ?>
                    <?}else{?>
                        <?if($object->getField('is_land')){?>
                            <?
                            $price_min = $offer->$price_min_func('price_floor_min');
                            $price_max = $offer->$price_max_func('price_floor_max');
                            $dim = 'м<sup>2</sup>';
                            ?>
                        <?}else{?>
                            <?if($offer->getField('deal_type') == 2){
                                $price_min = $offer->$price_min_func('price_sale_min');
                                $price_max = $offer->$price_max_func('price_sale_max');
                                $dim = 'м<sup>2</sup>';
                            }elseif($offer->getField('deal_type') == 3){
                                $price_min = $offer->$price_min_func('price_safe_pallet_eu_min');
                                $price_max = $offer->$price_max_func('price_safe_pallet_eu_max');
                                $dim = 'п.м./сут';
                            }else{

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

                                $prices_min = [];
                                $prices_max = [];

                                foreach($arr_fields_prices_rent as $price){
                                    $prices_min[] = $offer->getOfferBlocksMinValue($price.'_min');
                                    $prices_max[] = $offer->getOfferBlocksMaxValue($price.'_max');
                                }

                                $price_min = getArrayMin($prices_min);
                                $price_max = max($prices_max);


                                //$price_min = $offer->$price_min_func('price_floor_min');
                                //$price_max = $offer->$price_max_func('price_floor_max');
                                $dim = 'м<sup>2</sup>/год';
                            }?>
                        <?}?>

                    <?}?>
                    <div class="ghost" style="font-size: 12px; position: absolute; top: -8px;">
                        Цена  за <?= $dim?>
                    </div>
                    <div class="isBold">
                            <?= valuesCompare(numFormat($price_min), numFormat($price_max))?>
                            <i class="far fa-ruble-sign"></i>
                    </div>
                    <?if($offer->getField('deal_type') == 3){
                        $price_min = $offer->getOfferBlocksMinValue('pallet_place_min')*$offer->getOfferBlocksMaxValue('price_safe_pallet_eu_max')*30*12/($offer->getOfferBlocksMinValue('area_floor_max'));
                        $price_max = $offer->getOfferBlocksMaxSumValue('pallet_place_max')*$offer->getOfferBlocksMaxValue('price_safe_pallet_eu_max')*30*12/($offer->getOfferBlocksMaxSumValue('area_floor_max') + $offer->getOfferBlocksMaxSumValue('area_mezzanine_max')  );
                        $dim = 'м<sup>2</sup>/год';?>
                        <div class="ghost" style="font-size: 12px; ">
                            Цена  за <?= $dim?>
                        </div>
                        <div class="isBold">
                            <?= valuesCompare(numFormat($price_min), numFormat($price_max))?>
                            <i class="far fa-ruble-sign"></i>
                        </div>
                    <?}?>
                    <ul class="flex-box icon-row flex-wrap">
                        <?if($offer->getField('tax_form')){?>
                            <? $inc_obj = new Post($offer->getField('tax_form'))?>
                            <? $inc_obj->getTable('l_tax_form')?>
                            <li>
                                <div class="icon-orthogonal" title="<?=$inc_obj->title()?>">
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
                                            <div class="icon-orthogonal" title="<?=$inc_obj->title()?>">
                                                <?=$inc_obj->getField('title_short')?>
                                            </div>
                                        </li>
                                    <?}?>
                                <?}?>
                            <?}?>
                        <?}?>
                    </ul>
                </div>
            </div>
            <div class="for-customer obj-col-7">
                <div class="for-customer-label">
                    <div class="box-vertical" style="position: relative">
                        <?if($offer->getField('company_id') != NULL ){?>
                            <?$offer_company = new Company($offer->getField('company_id'))?>
                            <div class="ghost" style="font-size: 12px; position: absolute; top: -5px;">
                                <?if(($units_amount = $offer_company->countCompanyAreaUnits('Offer')) > 0){?>
                                    Собственник
                                <?}?>
                                <?if(($units_amount = $offer_company->countCompanyAreaUnits('Request')) > 0){?>
                                    клиент
                                <?}?>
                            </div>
                            <?if($offer_company->getField('company_group_id')){?>
                                <?
                                $company_group = new Post($offer_company->getField('company_group_id'));
                                $company_group->getTable('c_industry_companies_groups');
                                ?>
                                <b>
                                    <?=$company_group->title()?>
                                </b>
                            <?}?>
                            <div>
                                <a href="<?=PROJECT_URL?>/company/<?=$offer_company->postId()?>" target="_blank">
                                    <?if($offer_company->postId() == $offer_company->title()){?>
                                        <span class="attention ">NONAME <?=$offer_company->postId()?></span>
                                    <?}else{?>
                                        <?=$offer_company->title()?>
                                    <?}?>
                                </a>
                            </div>
                            <div class="flex-box">
                                <?if(($units_amount = $offer_company->countCompanyAreaUnits('Contact')) > 0){?>
                                    <div class="link-underline">
                                        <?=$units_amount?> контакты,
                                    </div>
                                <?}?>
                                <?if(($units_amount = $offer_company->countCompanyAreaUnits('Building')) > 0){?>
                                    <div class="link-underline">
                                        <?=$units_amount?> объекты
                                    </div>
                                <?}?>
                                <?if(($units_amount = $offer_company->countCompanyAreaUnits('Offer')) > 0){?>
                                    <div class="link-underline">
                                        <?=$units_amount?> Предложения,
                                    </div>
                                <?}?>
                                <?if(($units_amount = $offer_company->countCompanyAreaUnits('Request')) > 0){?>
                                    <div class="link-underline">
                                        <?=$units_amount?> запросы,
                                    </div>
                                <?}?>
                            </div>
                            <div class="box-small">

                            </div>
                            <?if($contact_id = $offer->getField('contact_id')){?>
                                <?$contact = new Contact($contact_id)?>
                                <div class="isBold ghost">
                                    <?=$contact->title()?>
                                </div>
                                <?if($contact->getField('contact_group')){?>
                                    <div class="ghost">
                                        <?
                                        $contact_group = new Post($contact->getField('contact_group'));
                                        $contact_group->getTable('c_industry_contact_groups');
                                        ?>
                                        <?=$contact_group->title()?>
                                    </div>
                                <?}?>

                                <div>
                                    <?=$contact->phone()?>
                                </div>
                                <div>
                                    <?=$contact->email()?>
                                </div>
                                <?/*if(($obj_amount = (count($offer_company->getCompanyContacts()) - 1)) > 0){?>
                                    <div class="button-transparent">
                                        Еще контакты: +<?=$obj_amount?>
                                    </div>
                                <?}*/?>
                            <?}?>
                        <?}?>
                    </div>
                </div>
            </div>
            <div class="for-agent obj-col-8">
                <div class="box-vertical" style="position: relative">
                    <?if($offer->getField('agent_visited') == 1){?>
                        <div class="attention" style="font-size: 12px; position: absolute; top: -5px;">
                            Был на объекте
                        </div>
                    <?}?>
                    <?if($offer->getField('agent_id')){?>
                        <div class="">
                            <?$offer_agent = new Member($offer->getField('agent_id'))?>
                            <?=$offer_agent->getField('title')?>
                        </div>
                    <?}?>
                </div>
            </div>
            <div class="for-dt obj-col-9">
                <div class="ghost">
                    <?if($filters_arr->status == 1){?>
                        <?= date('d.m.Y  в  H:i',$offer->lastUpdateActive())?>
                    <?}elseif($filters_arr->status == 2){?>
                        <?= date('d.m.Y  в  H:i',$offer->lastUpdatePassive())?>
                    <?}else{?>
                        <?= date('d.m.Y  в  H:i',$offer->getOfferLastUpdate())?>
                    <?}?>
                </div>
                <!--<nobr><?// $object->timeFormat($object->lastUpdate())?></nobr>-->
                <div >
                    <div class="flex-box flex-wrap">
                        <div class="icon-round icon-star <?=(in_array([$offer->postId(),2],$favourites)) ? 'icon-star-active' : ''?>" data-offer-id="[<?=$offer->postId()?>,2]">
                            <i class="fas fa-star"></i>
                        </div>
                        <div class="icon-round">
                            <a href="/favor/" class="icon-thumbs-down">
                                <i class="fas fa-thumbs-down"></i>
                            </a>
                        </div>
                    </div>
                    <div class="box-small">

                    </div>
                    <div>
                        <?if($offer->getField('ad_cian')){?>
                            <div class="flex-box flex-vertical-top">
                                <div class="icon-round-borderless" style="color: blue" title="Реклама ЦИАН">
                                    <i class="fas fa-rocket"></i>
                                </div>
                                <div class="ghost">
                                    <div>
                                        предлож.
                                    </div>
                                    <?if($blocks_ad_num = $offer->offerBlocksAdCount('ad_cian')){?>
                                        <div>
                                           + блоки <?=$blocks_ad_num?>шт.
                                        </div>
                                    <?}?>
                                </div>
                            </div>
                        <?}?>
                        <?if($offer->getField('ad_yandex')){?>
                            <div class="flex-box flex-vertical-top">
                                <div class="icon-round-borderless" style="color: #C0FF02" title="Реклама Яндекс">
                                    <i class="fas fa-rocket"></i>
                                </div>
                                <div class="ghost">
                                    <div>
                                        предлож.
                                    </div>
                                    <?if($blocks_ad_num = $offer->offerBlocksAdCount('ad_yandex')){?>
                                        <div>
                                            +  блоки <?=$blocks_ad_num?>шт.
                                        </div>
                                    <?}?>
                                </div>
                            </div>

                        <?}?>
                        <?if($offer->getField('ad_realtor') == 1){?>
                            <div class="flex-box flex-vertical-top">
                                <div class="icon-round-borderless" style="color: red"  title="Реклама на сайте">
                                    <i class="fas fa-rocket"></i>
                                </div>
                                <div class="ghost">
                                    <div>
                                        предлож.
                                    </div>
                                    <?if($blocks_ad_num = $offer->offerBlocksAdCount('ad_realtor')){?>
                                        <div>
                                            +  блоки <?=$blocks_ad_num?>шт.
                                        </div>
                                    <?}?>
                                </div>
                            </div>
                        <?}?>
                        <?if($offer->getField('ad_free') == 1){?>
                            <div class="flex-box flex-vertical-top">
                                <div class="icon-round-borderless" style="color: green"  title="Реклама на бесплатных">
                                    <i class="fas fa-rocket"></i>
                                </div>
                                <div class="ghost">
                                    <div>
                                        предлож.
                                    </div>
                                    <?if($blocks_ad_num = $offer->offerBlocksAdCount('ad_free')){?>
                                        <div>
                                            +  блоки <?=$blocks_ad_num?>шт.
                                        </div>
                                    <?}?>
                                </div>
                            </div>
                        <?}?>
                        <?if($offer->getField('ad_special') || $offer->offerBlocksAdCount('ad_special') > 0){?>
                            <div class="flex-box flex-vertical-top" style="color: red">
                                <div class="icon-round-borderless"   title="Спецпредложение">
                                    <i class="fas fa-bullseye-arrow"></i>
                                </div>
                                <div class="ghost">
                                    <div>
                                        спец<br>предлож.
                                    </div>
                                </div>
                            </div>
                        <?}?>
                    </div>


                    <!--
                    <div class="icon-round">
                        <a href="/favor/" class="">
                            <i class="fas fa-envelope"></i>
                        </a>
                    </div>
                    <div class="icon-round">
                        <a href="/presentation/<?=$object->postId()?>/" target="_blank">
                            <i class="fas fa-file-pdf"></i>
                        </a>
                    </div>
                    <div class="icon-round">
                        <a href="/favor/" class="icon-bell">
                            <i class="fas fa-bell"></i>
                        </a>
                    </div>
                    -->

                </div>
            </div>
        </div>
    </div>

    <div>

        <?if(count($blocks = $offer->subItemsIdFloors()) > 1){?>
            <div class="hidden  catalog-blocks">
                <div class=" dropdown-blocks-caption object-blocks-grid object-blocks-list-template"  >
                    <div class="obj-col-1">
                        <i class="fas fa-bars"></i>
                    </div>
                    <div class="obj-col-2">
                        ID блока
                    </div>
                    <div class="obj-col-3">
                        Этаж
                    </div>
                    <div class="obj-col-4">
                        Площадь
                    </div>
                    <div class="obj-col-5">
                        Высота
                    </div>
                    <div class="obj-col-6">
                        Тип пола
                    </div>
                    <div class="obj-col-7">
                        Тип ворот
                    </div>
                    <div class="obj-col-8">
                        Температура
                    </div>
                    <div class="obj-col-9">
                        Цена блока
                    </div>
                    <div class="obj-col-10">
                        <div class="icon-round">
                            <i class="fas fa-cog"></i>
                        </div>
                    </div>
                </div>
                <? $block_num = 0;?>
                <?foreach ($blocks as $block){

                    $subItem = new Subitem($block)?>
                    <div class="<?=($subItem->getField('status') == 2)? 'ghost-double' : ''?> dropdown-blocks-items object-blocks-grid object-blocks-list-template">
                        <div class="obj-col-1">
                            *
                        </div>
                        <div class="obj-col-2">
                            <?=$subItem->getVisualId()?>
                        </div>
                        <div class="obj-col-3">
                            <?=$subItem->floorNum()?> эт.
                        </div>
                        <div class="obj-col-4">
                            <b>
                                <?= valuesCompare(numFormat($subItem->getBlockSumAreaMin()),numFormat($subItem->getBlockSumAreaMax())) ?>
                                <?if($offer->getField('deal_type') == 3){?>
                                    п.м.
                                <?}else{?>
                                    м<sup>2</sup>
                                <?}?>
                            </b>
                        </div>
                        <div class="obj-col-5">
                            <?if($subItem->ceilingFrom()){?>
                                <?=valuesCompare($subItem->getField('ceiling_height_min'),$subItem->getField('ceiling_height_max'))?> м.
                            <?}else{?>
                                -
                            <?}?>

                        </div>
                        <div class="obj-col-6">
                            <?$grids = $subItem->getJsonField('floor_type');?>
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
                        <div class="obj-col-7">
                            <?
                            $gates = $subItem->getJsonField('gates');
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
                            <div class="block-info-gates">
                                <?foreach($sorted_arr as $key=>$value){?>
                                    <?
                                    $gate = new Post($key);
                                    $gate->getTable('l_gates_types');
                                    ?>
                                    <div class="flex-box">
                                        <div class="ghost"><?=$value?> шт /</div>  <div><?=$gate->title()?></div>
                                    </div>
                                <?}?>
                            </div>
                            <?//=$subItem->gateType()?>
                        </div>
                        <div class="obj-col-8">
                            <?$heat_type= new Post($subItem->getField('heated'))?>
                            <?$heat_type->getTable('l_blocks_heating')?>
                            <?=$heat_type->title()?>

                            <?if($subItem->getField('temperature_min')){?>
                                <div>
                                    <?=$subItem->getField('temperature_min')?> - <?=$subItem->getField('temperature_max')?> град.
                                </div>
                            <?}?>
                        </div>
                        <div class="obj-col-9">
                            <b>

                                <?if($filters_arr->price_format == 1){?>
                                    <?
                                    $price_min = $subItem->getField('price_floor_min');
                                    $price_max = $subItem->getField('price_floor_max');
                                    $dim = '<i class="far fa-ruble-sign"></i> за м<sup>2</sup>';
                                    ?>
                                <?}elseif($filters_arr->price_format == 2){?>
                                    <?
                                    $price_min = $subItem->getField('price_floor_min')/12;
                                    $price_max = $subItem->getField('price_floor_max')/12;
                                    $dim = '<i class="far fa-ruble-sign"></i> за м<sup>2</sup>/мес';
                                    ?>
                                <?}elseif($filters_arr->price_format == 3){?>
                                    <?
                                    $price_min = $subItem->getField('price_floor_min')/12*$subItem->getField('area_floor_min');
                                    $price_max = $subItem->getField('price_floor_max')/12*$subItem->getField('area_floor_max');
                                    $dim = '<i class="far fa-ruble-sign"></i> в месяц';
                                    ?>
                                <?}elseif($filters_arr->price_format == 4){?>
                                    <?
                                    $price_min = $subItem->getField('price_sale_min');
                                    $price_max = $subItem->getField('price_sale_max');
                                    $dim = '<i class="far fa-ruble-sign"></i> за м<sup>2</sup>';
                                    ?>
                                <?}elseif($filters_arr->price_format == 5){?>
                                    <?
                                    $price_min = $subItem->getField('price_sale_min')*$subItem->getBlockSumAreaMin();
                                    $price_max = $subItem->getField('price_sale_max')*$subItem->getBlockSumAreaMax();
                                    $dim = '<i class="far fa-ruble-sign"></i> за все';
                                    ?>
                                <?}elseif($filters_arr->price_format == 6){?>
                                    <?
                                    $price_min = $subItem->getField('price_sale_min')*100;
                                    $price_max = $subItem->getField('price_sale_max')*100;
                                    $dim = '<i class="far fa-ruble-sign"></i> за сотку';
                                    ?>
                                <?}elseif($filters_arr->price_format == 7){?>
                                    <?
                                    $price_min = $subItem->getField('price_safe_pallet_eu_min');
                                    $price_max = $subItem->getField('price_safe_pallet_eu_max');
                                    $dim = '<i class="far fa-ruble-sign"></i> за п.м./сут';
                                    ?>
                                <?}elseif($filters_arr->price_format == 8){?>
                                    <?
                                    $price_min = $subItem->getField('price_safe_volume_min');
                                    $price_max = $subItem->getField('price_safe_volume_max');
                                    $dim = '<i class="far fa-ruble-sign"></i> за м<sup>3</sup>/сут';
                                    ?>
                                <?}elseif($filters_arr->price_format == 9){?>
                                    <?
                                    $price_min = $subItem->getField('price_safe_floor_min');
                                    $price_max = $subItem->getField('price_safe_floor_max');
                                    $dim = '<i class="far fa-ruble-sign"></i> за м<sup>2</sup>/сут';
                                    ?>
                                <?}else{?>
                                    <?if($object->getField('is_land')){?>
                                        <?
                                        $price_min = $subItem->getField('price_floor_min');
                                        $price_max = $subItem->getField('price_floor_max');
                                        $dim = '<i class="far fa-ruble-sign"></i> за м<sup>2</sup>';
                                        ?>
                                    <?}else{?>
                                        <?if($offer->getField('deal_type') == 2){?>
                                            <?
                                            $price_min = $subItem->getField('price_sale_min');
                                            $price_max = $subItem->getField('price_sale_max');
                                            $dim = '<i class="far fa-ruble-sign"></i> за м<sup>2</sup>';
                                            ?>
                                        <?}elseif($offer->getField('deal_type') == 3){?>
                                            <?
                                            $price_min = $subItem->getField('price_safe_pallet_eu_min');
                                            $price_max = $subItem->getField('price_safe_pallet_eu_max');
                                            $dim = '<i class="far fa-ruble-sign"></i> за п.м./сут';
                                            ?>
                                        <?}else{?>
                                            <?
                                            $price_min = $subItem->getField('price_floor_min');
                                            $price_max = $subItem->getField('price_floor_max');
                                            $dim = '<i class="far fa-ruble-sign"></i> за м<sup>2</sup>/год';
                                            ?>
                                        <?}?>
                                    <?}?>
                                <?}?>

                                <?= valuesCompare(numFormat($price_min), numFormat($price_max))?>
                                <?= $dim?>

                            </b>

                        </div>
                        <div class="obj-col-10 flex-box">
                            <div class="icon-round icon-star <?=(in_array([$subItem->postId(),1],$favourites)) ? 'icon-star-active' : ''?>" data-offer-id="[<?=$subItem->postId()?>,1]">
                                <i class="fas fa-star"></i>
                            </div>
                            <div class="icon-round">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <?if($subItem->getField('ad_cian')){?>
                                <div class="icon-round" style="color: blue" title="Реклама ЦИАН">
                                    <i class="fas fa-rocket"></i>
                                </div>
                            <?}?>
                            <?if($subItem->getField('ad_yandex')){?>
                                <div class="icon-round" style="color: limegreen" title="Реклама Яндекс">
                                    <i class="fas fa-rocket"></i>
                                </div>
                            <?}?>
                            <div class="icon-round">
                                <a href="/favor/" class="">
                                    <i class="fas fa-file-pdf"></i>
                                </a>
                            </div>

                            <!--
                            <div class="icon-round">
                                <i class="fas fa-rocket"></i>
                            </div>
                            -->
                        </div>
                    </div>
                <?}?>
            </div>
        <?}?>
    </div>

    <div class="tabs-block tabs-active-free">
        <div class="tabs flex-box">
            <?foreach($offers_near as $offer_item){?>
                <?$offer = new Offer($offer_item)?>
                <div class="box text_left tab <?=($offer->getOfferStatus() == 2) ? 'ghost' : '';?>" >
                    <div class="flex-box">
                        <div class="ghost">
                            <?=$offer->getOfferDealType()?> <?=$object->itemId()?>-<?=preg_split('//u',$offer->getOfferDealType(),-1,PREG_SPLIT_NO_EMPTY)[0]?>
                        </div>
                    </div>
                    <div>
                        <?if($offer->getField('company_id')){?>
                            <b>
                                <?$company = new Company($offer->getField('company_id'))?>
                                <?= ($company->id) ? $company->title() : '--'?>
                            </b>
                        <?}?>
                    </div>
                    <div>
                        <?if($offer->getOfferBlocksMinValue('area_min') || $offer->getOfferBlocksMaxSumValue('area_max')){?>
                            <b>
                                <?= valuesCompare($offer->getOfferBlocksMinValue('area_min'), $offer->getOfferBlocksMaxSumValue('area_max'))?> м<sup>2</sup>
                            </b>
                        <?}else{?>
                            -
                        <?}?>
                    </div>
                    <div>
                        <?/*$price = $offer->getOfferBlocksMinValue($price_par);?>
                        <?//if($offer->getOfferBlocksMinValue('price')|| $offer->getOfferBlocksMaxValue('price')){?>
                        <?if($price){?>
                                <?$price_min = $offer->getOfferBlocksMinValue($price_par);?>
                                <?$price_max = $offer->getOfferBlocksMaxValue($price_par);?>

                                <?if($filters_arr->price_format == 1){?>
                                    <?$price_min = $price_min/12;?>
                                    <?$price_max = $price_max/12;?>
                                <?}elseif($filters_arr->price_format == 3){?>
                                    <?$price_min = ($price_min/12)*$offer->getOfferBlocksMinValue('area_min');?>
                                    <?$price_max = ($price_max/12)*$offer->getOfferBlocksMaxSumValue('area_max');?>
                                <?}else{?>

                                <?}?>



                                <?= valuesCompare(ceil($price_min),ceil($price_max))?>
                                <?=$format?>
                        <?}else{?>
                            -
                        <?}*/?>
                    </div>
                    <div class="<?=($offer->getOfferStatus() == 2) ? 'unactive' : '';?>">
                        <?
                        $status = new Post($offer->getOfferStatus());
                        $status->getTable('l_statuses_all');
                        ?>
                        <?=$status->title()?>
                    </div>
                </div>
            <?}?>
        </div>
        <div class="tabs-content tabs-active-free">
            <?foreach($offers_near as $offer_item){?>
                <?$offer = new Offer($offer_item)?>
                <div class="tab-content <?=($offer->getOfferStatus() == 2) ? 'ghost' : '';?>">
                    <div >
                        <div  class=" object-item <?=($offer_status == 2) ? 'ghost' : '';?>">
                            <div class="object-grid object-list-template">
                                <div class="obj-col-1 flex-column" style="position: relative; display: flex; ">
                                    <div>
                                        <a href="/object/<?=$object->itemId()?>?offer_id=<?=$offer->postId()?>" class="a-classic" target="_blank"><?=$object->itemId()?></a>-<?=preg_split('//u',$offer->getOfferDealType(),-1,PREG_SPLIT_NO_EMPTY)[0]?>
                                    </div>
                                    <?if(count($offer->subItemsId()) > 1){?>
                                        <div class="catalog-blocks-switch pointer icon-round to-end-vertical" title="Показать/скрыть блоки">
                                            <i class="fas fa-angle-down"></i>
                                        </div>
                                    <?}?>
                                </div>
                                <div class="obj-col-2">
                                    <div  style="font-size: 12px;">
                                    <span class="isBold attention">
                                        <?if($offer->getField('deal_type') == 2){?>
                                            Продажа
                                        <?}elseif($offer->getField('deal_type') == 3){?>
                                            Ответ. хранение
                                        <?}elseif($offer->getField('deal_type') == 4){?>
                                            Субаренда
                                        <?}else{?>
                                            Прямая аренда
                                        <?}?>
                                    </span>
                                    <span class="ghost" >
                                        <?if(!$object->getField('is_land')){?>
                                            , класс <?=$object->classType()?>
                                        <?}?>
                                    </span>
                                    </div>
                                    <div class="">
                                        <a href="/object/<?=$object->itemId()?>?offer_id=<?=$offer->postId()?>" target="_blank">
                                            <i class=""></i>
                                            <b><?=$object->title()?></b>
                                        </a>
                                    </div>
                                    <div class="">
                                        <a href="/object/<?=$object->itemId()?>?offer_id=<?=$offer->postId()?>" target="_blank">
                                            <i class=""></i>
                                            <?=$object->getField('address')?>
                                        </a>
                                    </div>
                                    <div>
                                        <a href="/object/<?=$object->itemId()?>?offer_id=<?=$offer->postId()?>" target="_blank">
                                            <?$photo = explode('/',str_replace('//','/',$object->getJsonField('photo')[0]))?>
                                            <? $name = urldecode(array_pop($photo))?>
                                            <? $post = array_pop($photo)?>

                                            <img class="full-width" src="<?=PROJECT_URL.'/system/controllers/photos/thumb.php/300/'.$post.'/'.$name?>" />




                                        </a>
                                    </div>
                                    <div class="card-top-pictograms box-vertical">
                                        <ul>
                                            <? if(arrayIsNotEmpty($object->purposes())){?>
                                                <?//var_dump($object->purposes())?>
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
                                <div class="for-region obj-col-2">
                                    <div class="ghost" style="font-size: 12px">
                                        <?if($object->getField('location_id')){?>
                                            <?= $location->getLocationRegion()?>
                                        <?}?>
                                    </div>
                                    <div>
                                        <?if($object->getField('location_id')){?>
                                            <?if($location->getField('district_moscow')){?>
                                                <?$townMain = new Post($location->getField('district_moscow'))?>
                                                <?$townMain->getTable('l_districts_moscow')?>
                                                <?=$townMain->title()?>
                                                <br>
                                            <?}?>
                                            <?if($location->getField('direction')){?>
                                                <?=$location->getLocationDirection()?><br>
                                            <?}?>
                                            <div class="ghost" style="font-size: 12px">
                                                <?if($location->getLocationHighway()){?><?=$location->getLocationHighway()?><?}?>
                                                <?if($location->getLocationHighwayMoscow()){?><?=$location->getLocationHighwayMoscow()?><?}?>
                                            </div>

                                        <?}?>
                                    </div>
                                </div>
                                <div class="for-disdivict obj-col-3">

                                </div>
                                <div class="for-otmkad obj-col-4">
                                    <?if($object->getField('from_mkad')){?>
                                        <?=$object->getField('from_mkad')?> км
                                    <?}?>
                                </div>
                                <div class="for-area obj-col-5">
                                    <div class="box-vertical" style="position: relative">
                                        <?if($filters_arr->status == 0){?>
                                            <div>
                                                <div class="ghost" style="font-size: 12px; position: absolute; top: -5px;">
                                                    Площадь
                                                    <?if($object->getField('is_land')){?>
                                                        участка
                                                    <?}else{?>
                                                        объекта
                                                    <?}?>
                                                </div>
                                                <div class="isBold">
                                                    <?if($object->getField('area_building')){?>
                                                        <?= numFormat($object->getField('area_building'))?>
                                                    <?}else{?>
                                                        <?= numFormat($object->getField('area_field_full'))?>
                                                    <?}?>
                                                    <span style="font-size: 10px;">м<sup>2</sup></span>
                                                </div>
                                                <?if($offer->getOfferBlocksMinValue('area_mezzanine_min')){?>
                                                    <div class="ghost" style="font-size: 12px;">
                                                        <?= numFormat($object->getField('area_mezzanine_full') )?> <span style="font-size: 10px;">м<sup>2</sup></span> - мезанин
                                                    </div>
                                                <?}?>
                                                <?if($offer->getOfferBlocksMinValue('area_office_min')){?>
                                                    <div class="ghost" style="font-size: 12px;">
                                                        <?= numFormat($object->getField('area_office_full'))?> <span style="font-size: 10px;">м<sup>2</sup></span> - офисы
                                                    </div>
                                                <?}?>
                                            </div>
                                            <div class="box-small">

                                            </div>
                                        <?}?>

                                        <?if($filters_arr->status == 0 || $filters_arr->status == 1){?>
                                            <div>
                                                <div class="flex-box">
                                                    <div class="round-green">

                                                    </div>
                                                    <div class="box-wide" style="font-size: 12px;">
                                                        <?if($offer->getField('built_to_suit')){?>
                                                            <div class="ghost" style="font-size: 12px;">
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
                                                                <?/*if($offer->getField('built_to_suit_plan')){?>
                                                <div>
                                                    проект имеется
                                                </div>
                                            <?}*/?>
                                                            </div>
                                                        <?}else{?>
                                                            <span class="ghost ">Актив</span>
                                                        <?}?>
                                                    </div>
                                                </div>
                                                <div>
                                                    <div class="isBold">
                                                        <?if($offer->getOfferBlocksMinValue('area_floor_min')){?>
                                                            <?=valuesCompare(numFormat($offer->getOfferSumAreaMin()), numFormat($offer->getOfferSumAreaMax()))?>
                                                            <span style="font-size: 10px;">м<sup>2</sup></span>
                                                        <?}else{?>
                                                            -
                                                        <?}?>
                                                    </div>
                                                    <?if($offer->getOfferBlocksMinValue('area_mezzanine_min')){?>
                                                        <div class="ghost" style="font-size: 12px;">
                                                            <?= numFormat($offer->getOfferBlocksMaxSumValue('area_mezzanine_max'))?> <span style="font-size: 10px;">м<sup>2</sup></span> - мезанин
                                                        </div>
                                                    <?}?>
                                                    <?if($offer->getOfferBlocksMinValue('area_office_min')){?>
                                                        <div class="ghost" style="font-size: 12px;">
                                                            <?= numFormat($offer->getOfferBlocksMaxSumValue('area_office_max'))?> <span style="font-size: 10px;">м<sup>2</sup></span> - офисы
                                                        </div>
                                                    <?}?>
                                                </div>
                                            </div>
                                            <div class="box-small">

                                            </div>
                                        <?}?>

                                        <?if($filters_arr->status == 0 || $filters_arr->status == 2){?>
                                            <div>
                                                <div class="flex-box" style="font-size: 12px;">
                                                    <div class="round-red">

                                                    </div>
                                                    <div class="ghost box-wide">
                                                        <?if($offer->getField('deal_type') == 2){?>
                                                            Продано
                                                        <?}else{?>
                                                            Сдано
                                                        <?}?>
                                                    </div>
                                                </div>
                                                <div>
                                                    <div class="isBold">
                                                        <?if($offer->getOfferBlocksMinValue('area_floor_min')){?>
                                                            <?=numFormat($object->getField('area_building') - $offer->getOfferSumAreaMax())?>
                                                            <span style="font-size: 10px;">м<sup>2</sup></span>
                                                        <?}else{?>
                                                            -
                                                        <?}?>
                                                    </div>
                                                    <?if($offer->getOfferBlocksMinValue('area_mezzanine_min')){?>
                                                        <div class="ghost" style="font-size: 12px;">
                                                            <?= numFormat($object->getField('area_mezzanine_full') -$offer->getOfferBlocksMaxSumValue('area_mezzanine_max'))?> <span style="font-size: 10px;">м<sup>2</sup></span> - мезанин
                                                        </div>
                                                    <?}?>
                                                    <?if($offer->getOfferBlocksMinValue('area_office_min')){?>
                                                        <div class="ghost" style="font-size: 12px;">
                                                            <?= numFormat($object->getField('area_office_full') - $offer->getOfferBlocksMaxSumValue('area_office_max'))?> <span style="font-size: 10px;">м<sup>2</sup></span> - офисы
                                                        </div>
                                                    <?}?>
                                                </div>
                                            </div>
                                        <?}?>



                                    </div>
                                </div>
                                <div class="for-price obj-col-6">
                                    <div class="box-vertical" style="position: relative">
                                        <div class="isBold">

                                            <?if($filters_arr->price_format == 1){?>
                                                <?= valuesCompare($offer->getOfferBlocksMinValue('price_floor_min'),$offer->getOfferBlocksMaxValue('price_floor_max'))?> <i class="far fa-ruble-sign"></i> за м<sup>2</sup>/год
                                            <?}elseif($filters_arr->price_format == 2){?>
                                                <?= valuesCompare($offer->getOfferBlocksMinValue('price_floor_min')/12,$offer->getOfferBlocksMaxValue('price_floor_max')/12)?> <i class="far fa-ruble-sign"></i> за м<sup>2</sup>/мес
                                            <?}elseif($filters_arr->price_format == 3){?>
                                                <?= valuesCompare(($offer->getOfferBlocksMinValue('price_floor_min')/12)*$offer->getOfferSumAreaMin(),($offer->getOfferBlocksMaxValue('price_floor_max')/12)*$offer->getOfferSumAreaMax())?> <i class="far fa-ruble-sign"></i> в месяц
                                            <?}elseif($filters_arr->price_format == 4){?>
                                            <?= valuesCompare($offer->getOfferBlocksMinValue('price_sale_min'),$offer->getOfferBlocksMaxValue('price_sale_max'))?> <i class="far fa-ruble-sign"></i> за м<sup>2
                                                <?}elseif($filters_arr->price_format == 5){?>
                                                    <?= valuesCompare(($offer->getOfferBlocksMinValue('price_sale_min'))*$offer->getOfferSumAreaMin(),($offer->getOfferBlocksMinValue('price_sale_max'))*$offer->getOfferSumAreaMax())?> <i class="far fa-ruble-sign"></i> за все
                                                <?}elseif($filters_arr->price_format == 6){?>
                                                    <?= valuesCompare($offer->getOfferBlocksMinValue('price_sale_min')*100,$offer->getOfferBlocksMaxValue('price_sale_max')*100)?> <i class="far fa-ruble-sign"></i> за сотку
                                                <?}elseif($filters_arr->price_format == 7){?>
                                                    <?= valuesCompare($offer->getOfferBlocksMinValue('price_safe_pallet_eu_min'),$offer->getOfferBlocksMaxValue('price_safe_pallet_eu_max'))?> <i class="far fa-ruble-sign"></i> за п.м./сут
                                                <?}elseif($filters_arr->price_format == 8){?>
                                                    <?= valuesCompare($offer->getOfferBlocksMinValue('price_safe_volume_min'),$offer->getOfferBlocksMaxValue('price_safe_volume_max'))?> <i class="far fa-ruble-sign"></i> за м<sup>3</sup>/сут
                                                <?}elseif($filters_arr->price_format == 9){?>
                                                    <?= valuesCompare($offer->getOfferBlocksMinValue('price_safe_floor_min'),$offer->getOfferBlocksMaxValue('price_safe_floor_max'))?> <i class="far fa-ruble-sign"></i> за м<sup>2</sup>/сут
                                                <?}else{?>
                                                <?if($offer->getField('deal_type') == 2){?>
                                                <?= valuesCompare($offer->getOfferBlocksMinValue('price_sale_min'),$offer->getOfferBlocksMaxValue('price_sale_max'))?> <i class="far fa-ruble-sign"></i> за м<sup>2
                                                    <?}elseif($offer->getField('deal_type') == 3){?>
                                                        <?= valuesCompare($offer->getOfferBlocksMinValue('price_safe_pallet_eu_min'),$offer->getOfferBlocksMaxValue('price_safe_pallet_eu_max'))?> <i class="far fa-ruble-sign"></i> за п.м./сут
                                                    <?}else{?>
                                                        <?= valuesCompare($offer->getOfferBlocksMinValue('price_floor_min'),$offer->getOfferBlocksMaxValue('price_floor_max'))?> <i class="far fa-ruble-sign"></i> за м<sup>2</sup>/год
                                                    <?}?>
                                                    <?}?>



                                        </div>
                                        <ul class="flex-box icon-row flex-wrap">
                                            <?if($offer->getField('tax_form')){?>
                                                <? $inc_obj = new Post($offer->getField('tax_form'))?>
                                                <? $inc_obj->getTable('l_tax_form')?>
                                                <li>
                                                    <div class="icon-orthogonal" title="<?=$inc_obj->title()?>">
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
                                                                <div class="icon-orthogonal" title="<?=$inc_obj->title()?>">
                                                                    <?=$inc_obj->getField('title_short')?>
                                                                </div>
                                                            </li>
                                                        <?}?>
                                                    <?}?>
                                                <?}?>
                                            <?}?>
                                        </ul>
                                    </div>
                                </div>
                                <div class="for-customer obj-col-7">
                                    <div class="for-customer-label">
                                        <div class="box-vertical" style="position: relative">
                                            <?if($offer->getField('company_id') != NULL ){?>
                                                <?$offer_company = new Company($offer->getField('company_id'))?>
                                                <div class="ghost" style="font-size: 12px; position: absolute; top: -5px;">
                                                    <?if(($units_amount = $offer_company->countCompanyAreaUnits('Offer')) > 0){?>
                                                        Собственник
                                                    <?}?>
                                                    <?if(($units_amount = $offer_company->countCompanyAreaUnits('Request')) > 0){?>
                                                        клиент
                                                    <?}?>
                                                </div>
                                                <?if($offer_company->getField('company_group_id')){?>
                                                    <?
                                                    $company_group = new Post($offer_company->getField('company_group_id'));
                                                    $company_group->getTable('c_industry_companies_groups');
                                                    ?>
                                                    <b>
                                                        <?=$company_group->title()?>
                                                    </b>
                                                <?}?>
                                                <div>
                                                    <a href="<?=PROJECT_URL?>/company/<?=$offer_company->postId()?>" target="_blank">
                                                        <?if($offer_company->postId() == $offer_company->title()){?>
                                                            <span class="attention ">NONAME <?=$offer_company->postId()?></span>
                                                        <?}else{?>
                                                            <?=$offer_company->title()?>
                                                        <?}?>
                                                    </a>
                                                </div>
                                                <div class="flex-column">
                                                    <?if(($units_amount = $offer_company->countCompanyAreaUnits('Contact')) > 0){?>
                                                        <div class="">
                                                            Контакты: <?=$units_amount?>
                                                        </div>
                                                    <?}?>
                                                    <?if(($units_amount = $offer_company->countCompanyAreaUnits('Building')) > 0){?>
                                                        <div class="">
                                                            Объекты: <?=$units_amount?>
                                                        </div>
                                                    <?}?>
                                                    <?if(($units_amount = $offer_company->countCompanyAreaUnits('Offer')) > 0){?>
                                                        <div class="">
                                                            Предложения: <?=$units_amount?>
                                                        </div>
                                                    <?}?>
                                                    <?if(($units_amount = $offer_company->countCompanyAreaUnits('Request')) > 0){?>
                                                        <div class="">
                                                            Запросы: <?=$units_amount?>
                                                        </div>
                                                    <?}?>
                                                </div>
                                                <div class="box-small">

                                                </div>
                                                <?if($contact_id = $offer->getField('contact_id')){?>
                                                    <?$contact = new Contact($contact_id)?>
                                                    <div class="isBold ghost">
                                                        <?=$contact->title()?>
                                                    </div>
                                                    <?if($contact->getField('contact_group')){?>
                                                        <div class="ghost">
                                                            <?
                                                            $contact_group = new Post($contact->getField('contact_group'));
                                                            $contact_group->getTable('c_industry_contact_groups');
                                                            ?>
                                                            <?=$contact_group->title()?>
                                                        </div>
                                                    <?}?>

                                                    <div>
                                                        <?=$contact->phone()?>
                                                    </div>
                                                    <div>
                                                        <?=$contact->email()?>
                                                    </div>

                                                <?}?>
                                            <?}?>
                                        </div>
                                    </div>
                                </div>
                                <div class="for-agent obj-col-8">
                                    <div class="box-vertical" style="position: relative">
                                        <?if($offer->getField('agent_visited')){?>
                                            <div class="attention" style="font-size: 12px; position: absolute; top: -5px;">
                                                Был на объекте
                                            </div>
                                        <?}?>
                                        <?if($offer->getField('agent_id')){?>
                                            <div class="isBold">
                                                <?$offer_agent = new Member($offer->getField('agent_id'))?>
                                                <?=$offer_agent->getField('title')?>
                                            </div>
                                        <?}?>
                                    </div>
                                </div>
                                <div class="for-dt obj-col-9">
                                    <div class="ghost">
                                        <?if($filters_arr->status == 1){?>
                                            <?= date('d.m.Y  в  H:i',$offer->lastUpdateActive())?>
                                        <?}elseif($filters_arr->status == 2){?>
                                            <?= date('d.m.Y  в  H:i',$offer->lastUpdatePassive())?>
                                        <?}else{?>
                                            <?= date('d.m.Y  в  H:i',$offer->getOfferLastUpdate())?>
                                        <?}?>
                                    </div>
                                    <!--<nobr><?// $object->timeFormat($object->lastUpdate())?></nobr>-->
                                    <div class="flex-box flex-wrap">
                                        <div class="icon-round icon-star <?=(in_array([$offer->postId(),2],$favourites)) ? 'icon-star-active' : ''?>" data-offer-id="[<?=$offer->postId()?>,2]">
                                            <i class="fas fa-star"></i>
                                        </div>
                                        <div class="icon-round">
                                            <a href="/favor/" class="">
                                                <i class="fas fa-envelope"></i>
                                            </a>
                                        </div>
                                        <div class="icon-round">
                                            <a href="/presentation/<?=$object->postId()?>/" target="_blank">
                                                <i class="fas fa-file-pdf"></i>
                                            </a>
                                        </div>
                                        <div class="icon-round">
                                            <a href="/favor/" class="icon-bell">
                                                <i class="fas fa-bell"></i>
                                            </a>
                                        </div>
                                        <div class="icon-round">
                                            <a href="/favor/" class="icon-thumbs-down">
                                                <i class="fas fa-thumbs-down"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="for-dt obj-col-10">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?}?>
        </div>
    </div>
</div>



