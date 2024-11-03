<?php
/**
 * Created by PhpStorm.
 * User: Zhitkov
 * Date: 24.07.2018
 * Time: 13:16
 */
$offers = $object->getObjectOffers();
if($object->getField('location_id')){
    $location = new Location($object->getField('location_id'));
}

?>


<div class="object-item">
    <div class="object-grid object-list-template">
        <div class="obj-col-1" style="position: relative;">
            <div>
                <a href="/object/<?=$object->itemId()?>" class="a-classic" target="_blank"><?=$object->itemId()?></a>
            </div>
        </div>
        <div class="obj-col-2">
            <div class="">
                <a href="/object/<?=$object->itemId()?>" target="_blank">
                    <i class=""></i>
                    <b><?=$object->title()?></b>
                </a>
            </div>
            <div class="">
                <a href="/object/<?=$object->itemId()?>" target="_blank">
                    <i class=""></i>
                    <?=$object->getField('address')?>
                </a>
            </div>
            <div>
                <a href="/object/<?=$object->itemId()?>" target="_blank">
                    <? $photo = $object->getThumbs('photo')[0];?>
                    <div class="background-fix full-width" style="height: 200px; background: url('<?=$photo?>');">

                    </div>
                    <!--<img src="<?=PROJECT_URL?>//uploads/objects/<?=$object->itemId()?>/<?=$photos[4]?>" style="width: 100%">-->
                </a>
            </div>
            <div class="card-top-pictograms box-vertical">
                <ul>
                    <?
                    foreach($object->purposes() as $purpose){
                        $purpose = new Post($purpose);
                        $purpose->getTable('item_purposes');
                        ?>
                        <li class="icon-square"><a href="#" title="<?=$purpose->title()?>"><?=$purpose->getField('icon')?></a></li>
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
                <?=$location->getLocationDirection()?><br>
                <span class="ghost"><?=$location->getLocationHighway()?></span>
            <?}?>
        </div>
        <div class="for-otmkad obj-col-5">
                <?if($object->fromMkad()){?>
                    <?=$object->fromMkad()?> км
                <?}?>
        </div>
        <div class="for-area obj-col-6">
            <?foreach($offers as $offer_item){?>
                <?$offer = new Offer($offer_item['id'])?>
                <div class="box-vertical" style="position: relative">
                    <div class="ghost" style="font-size: 12px; position: absolute; top: -5px;">
                        <?=$offer->getOfferDealType()?>
                    </div>
                    <div class="isBold">
                        <?= valuesCompare($offer->getOfferBlocksMinValue('area_min'),$offer->getOfferBlocksMaxSumValue('area_max'))?> <span style="font-size: 10px;">м<sup>2</sup></span>
                    </div>
                </div>
            <?}?>
        </div>
        <div class="for-price obj-col-7">
            <?foreach($offers as $offer_item){?>
                <?$offer = new Offer($offer_item['id'])?>
                <div class="box-vertical" style="position: relative">
                    <div class="ghost" style="font-size: 12px; position: absolute; top: -5px;">
                        <?=$offer->getOfferDealType()?>
                    </div>
                    <div class="isBold">
                        <?= valuesCompare($offer->getOfferBlocksMinValue('price'),$offer->getOfferBlocksMaxValue('price'))?>  <i class="fas fa-ruble-sign"></i>  <span style="font-size: 10px;"> м<sup>2</sup>/год</span>
                    </div>
                </div>
            <?}?>
        </div>
        <div class="for-customer obj-col-8">
            <div class="for-customer-label">
                <?foreach($offers as $offer_item){?>
                    <?$offer = new Offer($offer_item['id'])?>
                    <div class="box-vertical" style="position: relative">
                        <div class="ghost" style="font-size: 12px; position: absolute; top: -5px;">
                            <?=$offer->getOfferDealType()?>
                        </div>
                        <div class="isBold">
                            <?$offer_company = new Company($offer->getField('company_id'))?>
                            <?=$offer_company->getField('title')?>
                        </div>
                    </div>
                <?}?>
            </div>
        </div>
        <div class="for-agent obj-col-9">
            <?foreach($offers as $offer_item){?>
                <?$offer = new Offer($offer_item['id'])?>
                <div class="box-vertical" style="position: relative">
                    <div class="ghost" style="font-size: 12px; position: absolute; top: -5px;">
                        <?=$offer->getOfferDealType()?>
                    </div>
                    <div class="isBold">
                        <?$offer_agent = new Member($offer->getField('agent_id'))?>
                        <?=$offer_agent->getField('title')?>
                    </div>
                </div>
            <?}?>
        </div>
        <div class="for-result obj-col-10">
            <?foreach($offers as $offer_item){?>
                <?$offer = new Offer($offer_item['id'])?>
                <div class="box-vertical" style="position: relative">
                    <div class="ghost" style="font-size: 12px; position: absolute; top: -5px;">
                        <?=$offer->getOfferDealType()?>
                    </div>
                    <div class="isBold">
                        <div class="<?=(in_array($offer->getField('status_id'), [2,3])) ? 'unactive' : '';?>">
                            <?=$offer->getOfferStatus()?>
                        </div>
                    </div>
                </div>
            <?}?>

        </div>
        <div class="for-dt obj-col-11">
            <?//=$object->lastUpdate()?>
            <!--<nobr><?// $object->timeFormat($object->lastUpdate())?></nobr>-->
            <div class="flex-box flex-wrap">
                <div class="icon-round icon-star <?//=($logedUser->inFavourites($object->itemId())) ? 'icon-hl' : '' ?>" data-object-id="<?=$object->itemId()?>">
                    <i class="fas fa-star"></i>
                </div>
                <div class="icon-round pointer modal-call-btn"  data-id="<?=$object->postId()?>" data-table="<?=$object->setTableId()?>" data-modal="edit-all"  data-modal-size="modal-big">
                    <i class="fas fa-pencil-alt"></i>
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
    </div>
    <div class="tabs-block">
        <div class="tabs flex-box">
            <?foreach($offers as $offer_item){?>
                <?$offer = new Offer($offer_item['id'])?>
                <div class="box text_left tab" >
                    <div class="flex-box">
                        <div class="ghost">
                            <?=$offer->getOfferDealType()?> <?=$object->itemId()?>-<?=preg_split('//u',$offer->getOfferDealType(),-1,PREG_SPLIT_NO_EMPTY)[0]?>
                        </div>
                    </div>
                    <div>
                        <b>
                            <?$company = new Company($offer->getField('company_id'))?>
                            <?= ($company->id) ? $company->title() : '--'?>
                        </b>
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
                        <?if($offer->getOfferBlocksMinValue('price')|| $offer->getOfferBlocksMaxValue('price')){?>
                            <?= valuesCompare($offer->getOfferBlocksMinValue('price'), $offer->getOfferBlocksMaxValue('price'))?> <i class="fas fa-ruble-sign"></i> м<sup>2</sup>/год
                        <?}else{?>
                            -
                        <?}?>
                    </div>
                    <div class="<?=(in_array($offer->getField('offer_status'), [2,3])) ? 'unactive' : '';?>">
                        <?//= $offer->getOfferStatus()?>
                    </div>
                </div>
            <?}?>
        </div>
        <div class="tabs-content">
            <?foreach($offers as $offer_item){?>
                <?$offer = new Offer($offer_item['id'])?>
                <?if($offer->subItems()){?>
                    <div class=" tab-content dropdown-blocks blocks_<?=$offer->offerId()?>" >
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
                                Цена блока
                            </div>
                            <div class="obj-col-9">
                                Включено в цену
                            </div>
                            <div class="obj-col-10">
                                Отопление
                            </div>
                            <div class="obj-col-11">
                                Статус
                            </div>
                            <div class="obj-col-12">
                                <div class="icon-round">
                                    <i class="fas fa-cog"></i>
                                </div>
                            </div>
                        </div>
                        <?foreach ($offer->subItems() as $block){
                            $subItem = new Subitem($block['id'])?>
                            <div class="dropdown-blocks-items object-blocks-grid object-blocks-list-template">
                                <div class="obj-col-1">
                                    *
                                </div>
                                <div class="obj-col-2">
                                    <?=$object->itemId().' - '.$subItem->getField('id_visual')?>
                                </div>
                                <div class="obj-col-3">
                                    <?=$subItem->floorNum()?> эт.
                                </div>
                                <div class="obj-col-4">
                                    <b>
                                        <?=$subItem->areaFrom()?><?=$subItem->areaHasRange()?><?=$subItem->areaUpTo()?> м<sup>2</sup>
                                    </b>
                                </div>
                                <div class="obj-col-5">
                                    <?=$subItem->ceilingFrom()?><?=$subItem->ceilingHasRange()?><?=$subItem->ceilingUpTo()?> м.
                                </div>
                                <div class="obj-col-6">
                                    <?=$subItem->floorType()?>
                                </div>
                                <div class="obj-col-7">
                                    <?=$subItem->gateType()?>
                                </div>
                                <div class="obj-col-8">
                                    <b><?=$subItem->price()?> РУБ</b> м<sup>2</sup>/год
                                </div>
                                <div class="obj-col-9">
                                    <div class="card-top-pictograms">
                                        <ul class="flex-box">

                                            <?/*foreach($offer->getJsonField('inc_services') as $item){?>
                                                <?
                                                    $item = new Post($item);
                                                    $item->getTable('inc_services');
                                                ?>
                                                <li class="icon-square"><?=$item->title()?></li>
                                            <?}*/?>
                                            <!--
                                            <?if($subItem->incNds()){?>

                                            <?}?>
                                            <?if($subItem->incOpex()){?>
                                                <li class="icon-square"><a href="#" title="OPEX включено">opex</a></li>
                                            <?}?>
                                            <?if($subItem->incHeat()){?>
                                                <li class="icon-square"><a href="#" title="Отопление включено"><i class="fas fa-fire"></i></a></li>
                                            <?}?>
                                            <?if($subItem->incWater()){?>
                                                <li class="icon-square"><a href="#" title="Вода включено"><i class="fas fa-tint"></i></a></li>
                                            <?}?>
                                            <?if($subItem->incElectricity()){?>
                                                <li class="icon-square"><a href="#" title="Электричсество включено"><i class="fas fa-bolt"></i>/a></li>
                                            <?}?>
                                            -->
                                        </ul>
                                    </div>
                                </div>
                                <div class="obj-col-10">
                                    <?=($subItem->isHeated())? 'Теплый' : 'Холодный';?>
                                </div>
                                <div class="obj-col-11 flex-box">
                                    <?php
                                    $status = new Post($subItem->showField('status_id'));
                                    $status->getTable('c_industry_status');
                                    ?>
                                    <?=$status->title()?>
                                    <div class="icon-round">
                                        <i class="fas fa-rocket"></i>
                                    </div>
                                </div>
                                <!--
                                <div class="obj-col-12">
                                    P
                                </div>
                                -->
                                <div class="obj-col-12 flex-box">
                                    <div class="icon-round">
                                        <i class="fas fa-star"></i>
                                    </div>
                                    <div class="icon-round">
                                        <i class="fas fa-envelope"></i>
                                    </div>
                                    <div class="icon-round">
                                        <a href="/favor/" class="">
                                            <i class="fas fa-file-pdf"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        <?}?>
                    </div>
                <?}?>
            <?}?>
        </div>
    </div>
    <!--
    <div class="card-buy-type-customer flex-box flex-vertical-top ">
        <?foreach($offers as $offer_item){?>
            <?$offer = new Offer($offer_item['id'])?>
            <div class="offer-preview box text_left">
                <div class="flex-box">
                    <div class="ghost">
                        <?=$offer->getOfferDealType()?> <?=$object->itemId()?>-<?=preg_split('//u',$offer->getOfferDealType(),-1,PREG_SPLIT_NO_EMPTY)[0]?>
                    </div>
                </div>
                <div>
                    <b>
                        <?$company = new Company($offer->getField('company_id'))?>
                        <?= ($company->id) ? $company->title() : '--'?>
                    </b>
                </div>
                <div>
                    <b>
                        <?= valuesCompare($offer->getOfferBlocksMinValue('area_min'), $offer->getOfferBlocksMaxSumValue('area_max'))?> м<sup>2</sup>
                    </b>
                </div>
                <div>
                    <?= valuesCompare($offer->getOfferBlocksMinValue('price'), $offer->getOfferBlocksMaxValue('price'))?> <i class="fas fa-ruble-sign"></i> м<sup>2</sup>/год
                </div>
                <div class="<?=(in_array($offer->getField('offer_status'), [2,3])) ? 'unactive' : '';?>">
                    <?//= $offer->getOfferStatus()?>
                </div>
            </div>
        <?}?>
    </div>
    -->
</div>



