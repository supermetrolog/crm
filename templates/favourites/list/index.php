<?php
//include_once($_SERVER['DOCUMENT_ROOT'].'/errors.php');


//echo $offer->postId();


/**
 * Created by PhpStorm.
 * User: Zhitkov
 * Date: 24.07.2018
 * Time: 13:16
 */


//echo $offer->getField('object_id');




$object = new Building($offer->getField('object_id'));
if($object->getField('location_id')){
    $location = new Location($object->getField('location_id'));
}
$offer_status = $offer->getField('status');


?>


<div class="object-item <?=( $object->getField('status') == 2)? 'ghost-double' : ''?>" style="position: relative;" >
    <div class="pres-overlay <?if(!$pres){?> hidden  <?}?>">
        <div class="flex-box flex-center-center " style="background: rgba(0,0,0, 0.5);position: absolute; z-index: 10; top: 0; left: 0; right: 0; bottom: 0;">
            <div style="font-size: 70px; color: lime;" class="icon-send text_center" data-offer-id="[<?=$offer->getField('original_id')?>,<?=$offer->getField('type_id')?>]">
                <div>
                    <i class="fas fa-file-pdf"></i>
                </div>
                <br>

                <div>к отправке</div>
            </div>
        </div>
    </div>
    <div class="<?=($offer_status == 1) ? '' : 'ghost';?>">
        <div class="object-grid object-list-template">
            <div class="obj-col-1" style="position: relative;">
                <div>
                    <a href="/complex/<?=$object->getField('complex_id')?>?offer_id=[<?=$offer->getField('original_id')?>]" class="a-classic" target="_blank"><?=$object->itemId()?></a>-<?=preg_split('//u',$offer->getOfferDealType(),-1,PREG_SPLIT_NO_EMPTY)[0]?>
                </div>
            </div>
            <div class="obj-col-2">
                <div class="ghost" style="font-size: 12px;">
                    <?if($object->getField('area_building')){?>
                        <?=$object->getField('area_building')?>
                    <?}else{?>
                        <?=$object->getField('area_field')?>
                    <?}?>
                    <span style="font-size: 10px;">м<sup>2</sup></span> , <?=$object->classType()?> класс
                </div>
                <div class="">
                    <i class=""></i>
                    <b><?=$object->title()?></b>
                </div>
                <div class="">
                    <i class=""></i>
                    <?=$object->getField('address')?>
                </div>
                <div>
                    <!--<a href="/object/<?=$object->itemId()?>?offer_id=<?=$offer->getField('original_id')?>#offers" target="_blank">-->
                    <a href="/complex/<?=$object->getField('complex_id')?>?offer_id=[<?=$offer->getField('original_id')?>]#offers" target="_blank">
                        <? $photo = array_pop(explode('/',$object->getJsonField('photo')[0]))?>
                        <img src="<?=PROJECT_URL.'/system/controllers/photos/thumb.php/300/'.$object->postId().'/'.$photo ?>" class="full-width" />
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
                <?if($object->getField('location_id')){?>
                    <?=$location->getLocationRegion()?>
                <?}?>
            </div>
            <div class="for-disdivict obj-col-4">
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
                    <div class="ghost">
                        <?if($location->getLocationHighway()){?><?=$location->getLocationHighway()?><?}?>
                        <?if($location->getLocationHighwayMoscow()){?><?=$location->getLocationHighwayMoscow()?><?}?>
                    </div>

                <?}?>
            </div>
            <div class="for-otmkad obj-col-5">
                <?if($object->getField('from_mkad')){?>
                    <?=$object->getField('from_mkad')?> км
                <?}?>
            </div>
            <div class="for-area obj-col-6">
                <div class="box-vertical" style="position: relative">
                    <div class="ghost" style="font-size: 12px; position: absolute; top: -5px;">
                        <?=$offer->getOfferDealType()?>
                    </div>
                    <div class="isBold">
                        <?if($offer->getField('area_floor_min')){?>
                            <?=valuesCompare($offer->getField('area_min'), $offer->getField('area_max'))?>
                            <span style="font-size: 10px;">м<sup>2</sup></span>
                        <?}else{?>
                            -
                        <?}?>
                    </div>
                    <?if($offer->getField('area_mezzanine_min')){?>
                        <div class="ghost" style="font-size: 12px;">
                            <?=valuesCompare($offer->getField('area_mezzanine_min'), $offer->getField('area_mezzanine_max'))?>
                            <span style="font-size: 10px;">м<sup>2</sup></span> - мезанин
                        </div>
                    <?}?>
                    <?if($offer->getOfferBlocksMinValue('area_office_min')){?>
                        <div class="ghost" style="font-size: 12px;">
                            <?=$offer->getOfferBlocksMaxSumValue('area_office_max')?> <span style="font-size: 10px;">м<sup>2</sup></span> - офисы
                        </div>
                    <?}?>
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
                            <?if($offer->getField('built_to_suit_plan')){?>
                                <div>
                                    проект имеется
                                </div>
                            <?}?>
                        </div>
                    <?}?>
                </div>
            </div>
            <div class="for-price obj-col-7">

                <div class="box-vertical" style="position: relative">
                    <div class="isBold">
                        <?if($offer->getField('deal_type') == 1 || $offer->getField('deal_type') == 4){?>
                            <?=valuesCompare($offer->getField('price_floor_min'),$offer->getField('price_floor_max'))?> <i class="far fa-ruble-sign"></i> за м<sup>2</sup>/год
                        <?}elseif($offer->getField('deal_type') == 2){?>
                            <?=valuesCompare($offer->getField('price_sale_min'),$offer->getField('price_sale_max'))?> <i class="far fa-ruble-sign"></i> за м<sup>2</sup>
                        <?}elseif($offer->getField('deal_type') == 3){?>
                            <?=valuesCompare($offer->getField('price_safe_pallet_min'),$offer->getField('price_safe_pallet_max'))?> <i class="far fa-ruble-sign"></i> за п.м./сут
                        <?}?>



                    </div>

                </div>

            </div>
            <div class="for-customer obj-col-8">
                <div class="for-customer-label">
                    <div class="box-vertical" style="position: relative">
                        <?if($offer->getField('company_id') != NULL ){?>
                            <?$offer_company = new Company($offer->getField('company_id'))?>
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
                                <?=$offer_company->title()?>
                            </div>
                            <div>
                                <a target="_blank" href="/company/<?=$offer_company->postId()?>/"><?=$offer_company->getField('title')?></a>
                            </div>
                            <div class="flex-column">
                                <?if(($units_amount = $offer_company->countCompanyAreaUnits('Contact')) > 0){?>
                                    <div class="button-transparent">
                                        Контакты: <?=$units_amount?>
                                    </div>
                                <?}?>
                                <?if(($units_amount = $offer_company->countCompanyAreaUnits('Building')) > 0){?>
                                    <div class="button-transparent">
                                        Объекты: <?=$units_amount?>
                                    </div>
                                <?}?>
                                <?if(($units_amount = $offer_company->countCompanyAreaUnits('Offer')) > 0){?>
                                    <div class="button-transparent">
                                        Предложения: <?=$units_amount?>
                                    </div>
                                <?}?>
                                <?if(($units_amount = $offer_company->countCompanyAreaUnits('Request')) > 0){?>
                                    <div class="button-transparent">
                                        Запросы: <?=$units_amount?>
                                    </div>
                                <?}?>
                            </div>
                            <div class="box-small">

                            </div>
                            <?if($offer_company->getField('contact_id')){?>
                                <?$contact = new Contact($offer_company->getField('contact_id'))?>
                                <div>
                                    <a href="/contact/<?=$contact->postId()?>" target="_blank">
                                        <?=$contact->title()?>
                                    </a>
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
                                <?if(($obj_amount = (count($offer_company->getCompanyContacts()) - 1)) > 0){?>
                                    <div class="button-transparent">
                                        Еще контакты: +<?=$obj_amount?>
                                    </div>
                                <?}?>
                            <?}?>
                        <?}?>
                    </div>
                </div>
            </div>
            <div class="for-agent obj-col-9">
                <div class="box-vertical" style="position: relative">
                    <?if($offer->getField('agent_id')){?>
                        <div class="isBold">
                            <?$offer_agent = new Member($offer->getField('agent_id'))?>
                            <?=$offer_agent->getField('title')?>
                        </div>
                    <?}?>
                </div>
            </div>
            <div class="for-dt obj-col-10">
                <div class="ghost">
                    <?= date('d.m.Y  в  H:i',$offer->getField('last_update'))?>
                </div>
                <!--<nobr><?// $object->timeFormat($object->lastUpdate())?></nobr>-->
                <div class="flex-box flex-wrap">
                    <div class="icon-round icon-star icon-star-active" data-offer-id="[<?=$offer->getField('original_id')?>,<?=$offer->getField('type_id')?>]">
                        <i class="fas fa-star"></i>
                    </div>
                    <?if($offer_status == 1){?>
                        <div style="position: relative;" class="icon-round <? if (arrayIsNotEmpty($offer->getJsonField('photos'))) { ?> icon-send icon-send-check <? } ?>" data-offer-id="[<?=$offer->getField('original_id')?>,<?=$offer->getField('type_id')?>]">
                            <i class="fas fa-envelope"></i>
                            <? if (!arrayIsNotEmpty($offer->getJsonField('photos'))) { ?>
                                <div class="overlay-over" title="презентация недоступна так нету фото в блоке" style="background: red; ">

                                </div>
                            <? } ?>
                        </div>
                        <div class="icon-round" style="position: relative;">
                            <a href="/pdf-test.php?original_id=<?=$offer->getField('original_id')?>&type_id=<?=$offer->getField('type_id')?>&member_id=<?=$logedUser->member_id()?>" target="_blank">
                                <i class="fas fa-file-pdf"></i>
                            </a>
                            <? if (!arrayIsNotEmpty($offer->getJsonField('photos'))) { ?>
                                <div class="overlay-over" title="презентация недоступна так нету фото в блоке" style="background: red; ">

                                </div>
                            <? } ?>
                        </div>
                    <?}?>
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
        </div>
    </div>

</div>






