<?php

/**
 * Created by PhpStorm.
 * User: Zhitkov
 * Date: 24.07.2018
 * Time: 13:16
 */


//include_once($_SERVER['DOCUMENT_ROOT'].'/errors.php');

?>

<div class="object-item <?= ($offer->getField('deal_id')) ? 'ghost' : '' ?>" style="position: relative; ">
    <div class="pres-overlay <? if (!$pres) { ?> hidden  <? } ?>">
        <div class="flex-box flex-center-center " style="background: rgba(0,0,0, 0.5);position: absolute; z-index: 10; top: 0; left: 0; right: 0; bottom: 0;">
            <div style="font-size: 70px; color: lime;" class="icon-send text_center" data-offer-id="[<?= $offer->getField('original_id') ?>,<?= $offer->getField('type_id') ?>]">
                <div>
                    <i class="fas fa-file-pdf"></i>
                </div>
                <br>
                <div>к отправке</div>
            </div>
        </div>
    </div>
    <div class="<? if ($offer->getField('type_id') == 3) { ?> ghost <? } ?>">
        <div class="object-grid object-list-template">
            <div class="obj-col-1 flex-column " style="position: relative; display: flex;  ">

                <div class="full-width flex-box flex-center">
                    <? if ($offer->getField('type_id') == 2) {
                        $link_offer_id = $offer->getField('original_id');
                    } elseif ($offer->getField('type_id') == 1) {
                        $link_offer_id = $offer->getField('parent_id');
                    } else {
                        $link_offer_id = '';
                    } ?>
                    <a href="/complex/<?= $offer->getField('complex_id') ?>?offer_id=[<?= $link_offer_id ?>]" class="a-classic" target="_blank"><?= $offer->getField('object_id') ?></a>-<?= preg_split('//u', $offer->getField('deal_type_name'), -1, PREG_SPLIT_NO_EMPTY)[0] ?>
                </div>
                <? if (count($offer->getJsonField('blocks')) > 1) { ?>
                    <div class="flex-box flex-center to-end-vertical full-width">
                        <div class="catalog-blocks-switch pointer  icon-round " title="Показать/скрыть блоки">
                            <i class="fas fa-angle-down"></i>
                        </div>
                    </div>
                <? } ?>
            </div>
            <div class="obj-col-2">
                <div style=" font-size: 12px;">
                    <span class="isBold attention">
                        <? if ($offer->getField('type_id') != 3) { ?>
                            <?= $offer->getField('deal_type_name') ?>
                        <? } else { ?>
                            Весь объект
                        <? } ?>
                    </span>
                    <span class="ghost">
                        <? if (!$offer->getField('is_land')) { ?>
                            , класс <?= $offer->getField('class_name') ?>
                        <? } ?>
                    </span>
                </div>
                <div class="">
                    <b><?= $offer->getField('title') ?></b>
                </div>
                <div class="">
                    <?= $offer->getField('address') ?>
                </div>
                <div style="position: relative">
                    <div class="" style="position: absolute; top: 10px; ">
                        <? if ($offer->getField('test_only')) { ?>
                            <div style="background: #6bb93f; color: white; padding: 0 5px">
                                ТЕСТОВЫЙ ЛОТ!!!!
                            </div>
                        <? } ?>
                        <? if ($offer->getField('is_exclusive') == 2) { ?>
                            <div style="background: #d36f2c; color: white; padding: 0 5px">
                                Эксклюзив
                            </div>
                        <? } ?>
                        <? if ($offer->gF('rent_business') == 1) { ?>
                            <div style="background: #6c89cc; color: white; padding: 0 5px">
                                Инвестпроект
                            </div>
                        <? } ?>
                        <? if ($offer->gF('hide_from_market')) { ?>
                            <div style="background: #e31e24; color: white; padding: 0 5px">
                                СКРЫТАЯ СДЕЛКА !!!
                            </div>
                        <? } ?>
                    </div>
                    <? if ($offer->gF('is_exclusive') || $offer->gF('rent_business')) { ?>

                    <? } ?>
                    <a href="/complex/<?= $offer->getField('complex_id') ?>?offer_id=[<?= $link_offer_id ?>]" target="_blank">
                        <? $photo = explode('/', str_replace('//', '/', $offer->getJsonField('photos')[0])) ?>


                        <?
                        $photos = $offer->getJsonField('photos');
                        if (!$photos || !is_array($photos) || count($photos) == 0 || mb_strlen($photos[0]) < 5) {
                            $object_id = $offer->gF("object_id");
                            $select_object_photo_sql = "SELECT photo FROM c_industry WHERE id = $object_id LIMIT 1";
                            /** @var \PDO $pdo */
                            $stmt = $pdo->prepare($select_object_photo_sql);
                            $stmt->execute();
                            $object_value = $stmt->fetch(\PDO::FETCH_ASSOC);
                            if ($object_value) {
                                $objectPhotos = json_decode($object_value['photo']);
                                $objectFirstPhoto = "";
                                if (is_array($objectPhotos) && count($objectPhotos) != 0) {
                                    $objectFirstPhoto = $objectPhotos[0];
                                    $photo = explode('/', str_replace('//', '/', $objectFirstPhoto));
                                }
                            }
                        }
                        $projectUrl = PROJECT_URL;

                        ?>


                        <? $name = urldecode(array_pop($photo)) ?>
                        <? $post = array_pop($photo) ?>

                        <img class="full-width" hui="suka" src="<?= $projectUrl . '/system/controllers/photos/thumb.php/300/' . $post . '/' . $name ?>" />

                    </a>
                </div>
                <div class="card-top-pictograms box-vertical">
                    <ul>
                        <? if (arrayIsNotEmpty($purposes = $offer->getJsonField('purposes'))) { ?>
                            <? foreach ($purposes as $purpose) { ?>
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
            </div>
            <div class="for-region obj-col-3">
                <div class="ghost" style="font-size: 12px">
                    <?= $offer->getField('region_name') ?>
                </div>
                <div>
                    <?= $offer->getField('town_name') ?>
                    <?= ($offer->getField('direction') != 0)  ? $offer->getField('direction_name') : '' ?>
                    <div class="ghost" style="font-size: 12px">
                        <?= $offer->getField('highway_name') ?>
                        <?= $offer->getField('district_name') ?>
                        <?= $offer->getField('highway_moscow_name') ?>
                        <?= $offer->getField('district_moscow_name') ?>
                    </div>
                </div>
            </div>
            <div class="for-otmkad obj-col-4">
                <div class="" style="height: 12px;">

                </div>
                <? if ($offer->getField('from_mkad')) { ?>
                    <?= $offer->getField('from_mkad') ?> км
                <? } ?>
            </div>
            <div class="for-area obj-col-5">
                <div class="box-vertical" style="position: relative">
                    <? if ($offer->getField('type_id') == 3) { ?>
                        <div>
                            <div class="ghost" style="font-size: 12px; position: absolute; top: -5px;">
                                Площадь
                                <? if ($offer->getField('is_land')) { ?>
                                    участка
                                <? } else { ?>
                                    объекта
                                <? } ?>
                            </div>
                            <div class="isBold ghost">
                                <? if ($offer->getField('area_building')) { ?>
                                    <?= numFormat($offer->getField('area_building')) ?>
                                <? } else { ?>
                                    <?= numFormat($offer->getField('area_field_max')) ?>
                                <? } ?>
                                <span style="font-size: 10px;">м<sup>2</sup></span>
                            </div>
                            <? if ($offer->getField('area_mezzanine_full')) { ?>
                                <div class="ghost" style="font-size: 12px;">
                                    <?= numFormat($offer->getField('area_mezzanine_full')) ?> <span style="font-size: 10px;">м<sup>2</sup></span> - мезанин
                                </div>
                            <? } ?>
                            <? if ($offer->getField('area_office_full')) { ?>
                                <div class="ghost" style="font-size: 12px;">
                                    <?= numFormat($offer->getField('area_office_full')) ?> <span style="font-size: 10px;">м<sup>2</sup></span> - офисы
                                </div>
                            <? } ?>
                        </div>
                        <div class="box-small">

                        </div>
                    <? } ?>

                    <? if ($filters_arr->status == 0 || $filters_arr->status == 1) { ?>
                        <div>
                            <div class="flex-box">
                                <? if ($offer->getField('type_id') != 3) { ?>
                                    <div class="round-green">

                                    </div>
                                <? } ?>
                                <div class="box-wide" style="font-size: 12px;">
                                    <? if ($offer->getField('built_to_suit') == 1) { ?>
                                        <div class="ghost" style="font-size: 12px;">
                                            <div class="flex-box">
                                                <div>
                                                    <? if ($offer->getField('deal_type') == 2) { ?>
                                                        BTS
                                                    <? } else { ?>
                                                        BTR
                                                    <? } ?>
                                                </div>
                                                <? if ($offer->getField('built_to_suit_time')) { ?>
                                                    <div>
                                                        / <?= $offer->getField('built_to_suit_time') ?> мес
                                                    </div>
                                                <? } ?>
                                            </div>
                                            <?/*if($offer->getField('built_to_suit_plan')){?>
                                                <div>
                                                    проект имеется
                                                </div>
                                            <?}*/ ?>
                                        </div>
                                    <? } else { ?>
                                        <? if ($offer->getField('type_id') != 3) { ?>
                                            <span class="ghost ">Актив</span>
                                        <? } ?>
                                    <? } ?>
                                </div>
                            </div>
                            <div>
                                <div class="isBold">
                                    <? if ($offer->getField('area_min')) { ?>
                                        <?= valuesCompare(numFormat($offer->getField('area_min')), numFormat($offer->getField('area_max'))) ?>
                                        <span style="font-size: 10px;">м<sup>2</sup></span>
                                    <? } else { ?>
                                        -
                                    <? } ?>
                                </div>
                                <? if ($offer->getField('area_mezzanine_min')) { ?>
                                    <div class="ghost" style="font-size: 12px;">
                                        <?= numFormat($offer->getField('area_mezzanine_max')) ?> <span style="font-size: 10px;">м<sup>2</sup></span> - мезанин
                                    </div>
                                <? } ?>
                                <? if ($offer->getField('area_office_min')) { ?>
                                    <div class="ghost" style="font-size: 12px;">
                                        <?= numFormat($offer->getField('area_office_max')) ?> <span style="font-size: 10px;">м<sup>2</sup></span> - офисы
                                    </div>
                                <? } ?>
                                <? if ($offer->getField('pallet_place_min')) { ?>
                                    <div class="ghost" style="font-size: 12px;">
                                        <?= (valuesCompare(numFormat($offer->getField('pallet_place_min')), numFormat($offer->getField('pallet_place_max')))) ?> <span style="font-size: 10px;">паллет мест</span>
                                    </div>
                                <? } ?>
                            </div>
                        </div>
                        <div class="box-small">

                        </div>
                    <? } ?>

                    <? //if($filters_arr->status == 0 || $filters_arr->status == 2){
                    ?>
                    <? if (0) { ?>
                        <div>
                            <div class="flex-box" style="font-size: 12px;">
                                <div class="round-red">

                                </div>
                                <div class="ghost box-wide">
                                    <? if ($offer->getField('deal_type') == 2) { ?>
                                        Продано
                                    <? } else { ?>
                                        Сдано
                                    <? } ?>
                                </div>
                            </div>
                            <div>
                                <div class="isBold">
                                    <? if ($offer->getField('area_floor_min')) { ?>
                                        <?= numFormat($offer->getField('area_building') - $offer->getOfferSumAreaMax()) ?>
                                        <span style="font-size: 10px;">м<sup>2</sup></span>
                                    <? } else { ?>
                                        -
                                    <? } ?>
                                </div>
                                <? if ($offer->getOfferBlocksMinValue('area_mezzanine_min')) { ?>
                                    <div class="ghost" style="font-size: 12px;">
                                        <?= numFormat($object->getField('area_mezzanine_full') - $offer->getOfferBlocksMaxSumValue('area_mezzanine_max')) ?> <span style="font-size: 10px;">м<sup>2</sup></span> - мезанин
                                    </div>
                                <? } ?>
                                <? if ($offer->getOfferBlocksMinValue('area_office_min')) { ?>
                                    <div class="ghost" style="font-size: 12px;">
                                        <?= numFormat($object->getField('area_office_full') - $offer->getOfferBlocksMaxSumValue('area_office_max')) ?> <span style="font-size: 10px;">м<sup>2</sup></span> - офисы
                                    </div>
                                <? } ?>
                            </div>
                        </div>
                    <? } ?>
                </div>
            </div>
            <div class="for-price obj-col-6">
                <? if ($offer->getField('type_id') != 3) { ?>
                    <div class="box-vertical" style="position: relative">
                        <?php
                        /*
                    if ($offer->getField('deal_type') == 2 ) {
                        $price_min = $offer->getField('price_sale_min');
                        $price_max = $offer->getField('price_sale_max');
                    } else {
                        $price_min = $offer->getField('price_floor_min');
                        $price_max = $offer->getField('price_floor_max');
                    }
                    */

                        $pricecFormatsArr = [
                            '1' => ['price_floor_min', 'price_floor_max'],
                            '2' => ['price_floor_min_month', 'price_floor_max_month'],
                            '3' => ['price_min_month_all', 'price_max_month_all'],
                            '4' => ['price_sale_min', 'price_sale_max'],
                            '5' => ['price_sale_min_all', 'price_sale_max_all'],
                            '6' => ['price_floor_100_min', 'price_floor_100_max'],
                            '7' => ['price_safe_pallet_min', 'price_safe_pallet_max'],
                            '8' => ['price_safe_volume_min', 'price_safe_volume_max'],
                            '9' => ['price_safe_floor_min', 'price_safe_floor_max'],
                        ];

                        $formatId = $filters_arr->price_format;
                        if ($offer->getField('deal_type') == 1 && $formatId == null) {
                            $formatId = 1;
                        } elseif ($offer->getField('deal_type') == 2 && $formatId == null) {
                            $formatId = 4;
                        } elseif ($offer->getField('deal_type') == 4 && $formatId == null) {
                            $formatId = 1;
                        } elseif ($offer->getField('deal_type') == 3 && $formatId == null) {
                            $formatId = 7;
                        } else {
                        }
                        $dim = getPostTitle($formatId, 'l_price_formats');

                        ?>
                        <? if (in_array($offer->getField('deal_type'), [1, 2, 4])) { ?>
                            <div class="ghost" style="font-size: 12px; position: absolute; top: -8px;">
                                Цена за <?= $dim ?>
                            </div>
                            <div class="isBold">
                                <?= valuesCompare(numFormat($offer->getField($pricecFormatsArr[$formatId][0])), numFormat($offer->getField($pricecFormatsArr[$formatId][0]))) ?>
                                <? //= valuesCompare(numFormat($price_min), numFormat($price_max))
                                ?>
                                <i class="far fa-ruble-sign"></i>
                            </div>
                        <? } ?>
                        <? if ($offer->getField('deal_type') == 3) { ?>

                            <div class="ghost" style="font-size: 12px; ">
                                Цена за <?= $dim ?>
                            </div>
                            <div class="isBold">
                                <?= valuesCompare(numFormat($offer->getField('price_safe_pallet_min')), numFormat($offer->getField('price_safe_pallet_max'))) ?>
                                <i class="far fa-ruble-sign"></i>
                            </div>
                        <? } ?>
                        <ul class="flex-box icon-row flex-wrap">
                            <? if ($offer->getField('tax_form')) { ?>
                                <li>
                                    <div class="icon-orthogonal" title="<?= $offer->getField('tax_form') ?>">
                                        <?= $offer->getField('tax_form') ?>
                                    </div>
                                </li>
                            <? } ?>
                            <?/* if($offer->getField('tax_form')){?>
                            <? $inc_obj = new Post($offer->getField('tax_form'))?>
                            <? $inc_obj->getTable('l_tax_form')?>

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
                        <?} */ ?>
                        </ul>
                    </div>
                <? } ?>
            </div>
            <div class="for-customer obj-col-7" data-company_id="<?= $offer->getField('company_id') ?>" data-contact='<?= json_encode(['contact_id' => $offer->getField('contact_id'), 'company_id' => $offer->getField('company_id')]) ?>'>
                <div class="for-customer-label">
                    <div class="box-vertical" style="position: relative">
                        <? if ($offer->getField('company_id') != NULL) { ?>
                            <? $offer_company = new Company($offer->getField('company_id')) ?>
                            <div class="ghost" style="font-size: 12px; position: absolute; top: -5px;">
                                <? if (($units_amount = $offer_company->countCompanyAreaUnits('Offer')) > 0) { ?>
                                    Собственник
                                <? } ?>
                                <? if (($units_amount = $offer_company->countCompanyAreaUnits('Request')) > 0) { ?>
                                    клиент
                                <? } ?>
                            </div>
                            <? if ($offer_company->getField('company_group_id')) { ?>
                                <?
                                $company_group = new Post($offer_company->getField('company_group_id'));
                                $company_group->getTable('c_industry_companies_groups');
                                ?>
                                <b>
                                    <?= $company_group->title() ?>
                                </b>
                            <? } ?>
                            <div>
                                <a href="<?= PROJECT_URL ?>/company/<?= $offer_company->postId() ?>" target="_blank">
                                    <? if ($offer_company->postId() == $offer_company->title()) { ?>
                                        <span class="attention ">NONAME <?= $offer_company->postId() ?></span>
                                    <? } else { ?>
                                        <?= $offer_company->title() ?>
                                    <? } ?>
                                </a>
                            </div>
                            <div class="flex-box">
                                <? if (($units_amount = $offer_company->countCompanyAreaUnits('Contact')) > 0) { ?>
                                    <div class="link-underline">
                                        <?= $units_amount ?> контакты,
                                    </div>
                                <? } ?>
                                <? if (($units_amount = $offer_company->countCompanyAreaUnits('Building')) > 0) { ?>
                                    <div class="link-underline">
                                        <?= $units_amount ?> объекты
                                    </div>
                                <? } ?>
                                <? if (($units_amount = $offer_company->countCompanyAreaUnits('Offer')) > 0) { ?>
                                    <div class="link-underline">
                                        <?= $units_amount ?> Предложения,
                                    </div>
                                <? } ?>
                                <? if (($units_amount = $offer_company->countCompanyAreaUnits('Request')) > 0) { ?>
                                    <div class="link-underline">
                                        <?= $units_amount ?> запросы,
                                    </div>
                                <? } ?>
                            </div>
                            <div class="box-small">

                            </div>
                            <? if ($contact_id = $offer->getField('contact_id')) { ?>
                                <? $contact = new Contact($contact_id) ?>
                                <div class="isBold ghost">
                                    <?= $contact->title() ?>
                                </div>
                                <? if ($contact->getField('contact_group')) { ?>
                                    <div class="ghost">
                                        <?
                                        $contact_group = new Post($contact->getField('contact_group'));
                                        $contact_group->getTable('c_industry_contact_groups');
                                        ?>
                                        <?= $contact_group->title() ?>
                                    </div>
                                <? } ?>

                                <div>
                                    <?= $contact->phone() ?>
                                </div>
                                <div>
                                    <?= $contact->email() ?>
                                </div>

                            <? } ?>
                        <? } ?>
                    </div>
                </div>
            </div>
            <div class="for-agent obj-col-8">
                <div class="box-vertical" style="position: relative">
                    <? if ($offer->getField('agent_visited') == 1) { ?>
                        <div class="attention" style="font-size: 12px; position: absolute; top: -5px;">
                            Был на объекте
                        </div>
                    <? } ?>
                    <? if ($offer->getField('agent_id')) { ?>
                        <div class="">
                            <? $offer_agent = new Member($offer->getField('agent_id')) ?>
                            <?= $offer_agent->getField('title') ?>
                        </div>
                    <? } ?>
                </div>
            </div>
            <div class="for-dt obj-col-9">
                <div class="ghost">
                    <?= date('d.m.Y  в  H:i', $offer->getField('last_update')) ?>
                </div>
                <div>
                    <div class="flex-box flex-wrap">
                        <? if ($offer->getField('type_id') != 3) { ?>
                            <div class="icon-round icon-star <?= (in_array([$offer->getField('original_id'), $offer->getField('type_id')], $favourites))  ? 'icon-star-active' : '' ?>" data-offer-id="[<?= $offer->getField('original_id') ?>,<?= $offer->getField('type_id') ?>]">
                                <i class="fas fa-star"></i>
                            </div>
                        <? } ?>
                        <div class="icon-round">
                            <a href="/favor/" class="icon-thumbs-down">
                                <i class="fas fa-thumbs-down"></i>
                            </a>
                        </div>
                        <? if (isset($router) && $offer->getField('status') == 1 && $router->getPageName() == 'favorites') { ?>
                            <div style="position: relative;" class="icon-round <? if (arrayIsNotEmpty($offer->getJsonField('photos'))) { ?> icon-send icon-send-check <? } ?>" data-offer-id="[<?= $offer->getField('original_id') ?>,<?= $offer->getField('type_id') ?>]">
                                <i class="fas fa-envelope"></i>
                                <? if ($offer->getField('photos') == '["[]"]' || !arrayIsNotEmpty($offer->getJsonField('photos'))) { ?>
                                    <div class="overlay-over" title="презентация недоступна так нету фото в блоке" style="background: red; ">

                                    </div>
                                <? } ?>
                            </div>
                            <div class="icon-round" style="position: relative;">
                                <a href="/pdf-test.php?original_id=<?= $offer->getField('original_id') ?>&type_id=<?= $offer->getField('type_id') ?>&member_id=<?= $logedUser->member_id() ?>" target="_blank">
                                    <i class="fas fa-file-pdf"></i>
                                </a>
                                <? if ($offer->getField('photos') == '["[]"]' || !arrayIsNotEmpty($offer->getJsonField('photos'))) { ?>
                                    <div class="overlay-over" title="презентация недоступна так нету фото в блоке" style="background: red; ">

                                    </div>
                                <? } ?>
                            </div>
                        <? } ?>
                    </div>
                    <div class="box-small">

                    </div>
                    <div>
                        <? if ($offer->getField('ad_cian')) { ?>
                            <div class="flex-box flex-vertical-top">
                                <div class="icon-round-borderless" style="color: blue" title="Реклама ЦИАН">
                                    <i class="fas fa-rocket"></i>
                                </div>
                                <div class="ghost">
                                    <div>
                                        предлож.
                                    </div>
                                    <? if ($blocks_ad_num = $offer->getField('ad_cian')) { ?>
                                        <div>
                                            + блоки <?= $blocks_ad_num ?>шт.
                                        </div>
                                    <? } ?>
                                </div>
                            </div>
                        <? } ?>
                        <? if ($offer->getField('ad_yandex')) { ?>
                            <div class="flex-box flex-vertical-top">
                                <div class="icon-round-borderless" style="color: #C0FF02" title="Реклама Яндекс">
                                    <i class="fas fa-rocket"></i>
                                </div>
                                <div class="ghost">
                                    <div>
                                        предлож.
                                    </div>
                                    <? if ($blocks_ad_num = $offer->getField('ad_yandex')) { ?>
                                        <div>
                                            + блоки <?= $blocks_ad_num ?>шт.
                                        </div>
                                    <? } ?>
                                </div>
                            </div>

                        <? } ?>
                        <? if ($offer->getField('ad_realtor') == 1) { ?>
                            <div class="flex-box flex-vertical-top">
                                <div class="icon-round-borderless" style="color: red" title="Реклама на сайте">
                                    <i class="fas fa-rocket"></i>
                                </div>
                                <div class="ghost">
                                    <div>
                                        предлож.
                                    </div>
                                    <? if ($blocks_ad_num = $offer->getField('ad_realtor')) { ?>
                                        <div>
                                            + блоки <?= $blocks_ad_num ?>шт.
                                        </div>
                                    <? } ?>
                                </div>
                            </div>
                        <? } ?>
                        <? if ($offer->getField('ad_free') == 1) { ?>
                            <div class="flex-box flex-vertical-top">
                                <div class="icon-round-borderless" style="color: green" title="Реклама на бесплатных">
                                    <i class="fas fa-rocket"></i>
                                </div>
                                <div class="ghost">
                                    <div>
                                        предлож.
                                    </div>
                                    <? if ($blocks_ad_num = $offer->getField('ad_free')) { ?>
                                        <div>
                                            + блоки <?= $blocks_ad_num ?>шт.
                                        </div>
                                    <? } ?>
                                </div>
                            </div>
                        <? } ?>
                        <? if ($offer->getField('ad_special') || $offer->getField('ad_special') > 0) { ?>
                            <div class="flex-box flex-vertical-top" style="color: red">
                                <div class="icon-round-borderless" title="Спецпредложение">
                                    <i class="fas fa-bullseye-arrow"></i>
                                </div>
                                <div class="ghost">
                                    <div>
                                        спец<br>предлож.
                                    </div>
                                </div>
                            </div>
                        <? } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div>

        <? if (!$is_favourites_catalog && count($blocks = $offer->getJsonField('blocks')) > 1) { ?>
            <div class="hidden  catalog-blocks">
                <div class=" dropdown-blocks-caption object-blocks-grid object-blocks-list-template">
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
                <? $block_num = 0; ?>
                <? foreach ($blocks as $block) {
                    $subItem = new OfferMix($block) ?>
                    <? $is_perfect_block = 0 ?>
                    <? if ($filters_arr->area__min && $filters_arr->area_max) {
                        $is_perfect_block = 0;
                        if ($subItem->getField('area_min') >= $filters_arr->area_floor_min && $subItem->getField('area_max') <= $filters_arr->area_floor_max) {
                            $is_perfect_block = 1;
                        }
                    } ?>
                    <? if ($filters_arr->ceiling_height_min && $filters_arr->ceiling_height_max) {
                        $is_perfect_block = 0;
                        if ($subItem->getField('ceiling_height_min') >= $filters_arr->ceiling_height_min && $subItem->getField('ceiling_height_max') <= $filters_arr->ceiling_height_max) {
                            $is_perfect_block = 1;
                        }
                    } ?>
                    <? if ($filters_arr->price_min && $filters_arr->price_max) {
                        $is_perfect_block = 0;
                        if ($subItem->getField('price_floor_min') >= $filters_arr->price_min && $subItem->getField('price_floor_max') <= $filters_arr->price_max) {
                            $is_perfect_block = 1;
                        }
                    } ?>

                    <div class="<?= ($subItem->getField('status') == 2) ? 'ghost-double' : '' ?> dropdown-blocks-items <? if ($is_perfect_block) { ?> dropdown-blocks-items-active   <? } ?> object-blocks-grid object-blocks-list-template">
                        <div class="obj-col-1">
                            *
                        </div>
                        <div class="obj-col-2">
                            <?= $subItem->getField('visual_id') ?>
                        </div>
                        <div class="obj-col-3">
                            <? // var_dump($subItem->getJsonField('floor'))
                            ?>
                            <? //=($subItem->getField('id'))
                            ?>
                            <? //=($subItem->getField('floor'))
                            ?>
                            <? // if (arrayIsNotEmpty($floors =  $subItem->getJsonField('floor'))) {
                            if (false) {
                                foreach ($floors as $floor) {
                                    $floor_sql = $pdo->prepare("SELECT title FROM l_floor_nums WHERE  sign='$floor' ");
                                    $floor_sql->execute();
                                    $info = $floor_sql->fetch(PDO::FETCH_LAZY);
                                    //echo $info->title;
                                }
                            } else { ?>
                                <?= valuesCompare($subItem->getField('floor_min'), $subItem->getField('floor_max')) ?> эт.
                            <? } ?>
                        </div>
                        <div class="obj-col-4">
                            <b>
                                <? if ($subItem->getField('deal_type') == 3) { ?>
                                    п.м.
                                <? } else { ?>
                                    <?= valuesCompare(numFormat($subItem->getField('area_min')), numFormat($subItem->getField('area_max'))) ?>
                                    м<sup>2</sup>
                                <? } ?>
                            </b>
                        </div>
                        <div class="obj-col-5">
                            <? if ($subItem->getField('ceiling_height_min')) { ?>
                                <?= valuesCompare($subItem->getField('ceiling_height_min'), $subItem->getField('ceiling_height_max')) ?> м.
                            <? } else { ?>
                                -
                            <? } ?>

                        </div>
                        <div class="obj-col-6">
                            <?= $subItem->getField('floor_type') ?>
                        </div>
                        <div class="obj-col-7">
                            <?

                            $gates = $subItem->getJsonField('gates');
                            $gate_types = [];
                            $sorted_arr = [];

                            for ($i = 0; $i < count($gates); $i = $i + 2) {
                                if (!in_array($gates[$i], $gate_types) && $gates[$i] != 0) {
                                    array_push($gate_types, $gates[$i]);
                                }
                            }

                            //var_dump($glued_arr);

                            //подсчитываем колво ворот каждого типа
                            foreach ($gate_types as $elem_unique) {
                                for ($i = 0; $i < count($gates); $i = $i + 2) {
                                    if ($gates[$i] == $elem_unique) {
                                        $sorted_arr[$elem_unique] += $gates[$i + 1];
                                    }
                                }
                            }
                            ///var_dump($sorted_arr);


                            ?>
                            <div class="block-info-gates">
                                <? foreach ($sorted_arr as $key => $value) { ?>
                                    <?
                                    $gate = new Post($key);
                                    $gate->getTable('l_gates_types');
                                    ?>
                                    <div class="flex-box">
                                        <div class="ghost"><?= $value ?> шт /</div>
                                        <div><?= $gate->title() ?></div>
                                    </div>
                                <? } ?>
                            </div>
                            <? //=$subItem->gateType()
                            ?>
                        </div>
                        <div class="obj-col-8">
                            <? $heat_type = new Post($subItem->getField('heated')) ?>
                            <? $heat_type->getTable('l_blocks_heating') ?>
                            <?= $heat_type->title() ?>

                            <? if ($subItem->getField('temperature_min')) { ?>
                                <div>
                                    <?= $subItem->getField('temperature_min') ?> - <?= $subItem->getField('temperature_max') ?> град.
                                </div>
                            <? } ?>
                        </div>
                        <div class="obj-col-9">
                            <b>

                                <? if ($filters_arr->price_format == 1) { ?>
                                    <?
                                    $price_min = $subItem->getField('price_floor_min');
                                    $price_max = $subItem->getField('price_floor_max');
                                    $dim = '<i class="far fa-ruble-sign"></i> за м<sup>2</sup>';
                                    ?>
                                <? } elseif ($filters_arr->price_format == 2) { ?>
                                    <?
                                    $price_min = $subItem->getField('price_floor_min') / 12;
                                    $price_max = $subItem->getField('price_floor_max') / 12;
                                    $dim = '<i class="far fa-ruble-sign"></i> за м<sup>2</sup>/мес';
                                    ?>
                                <? } elseif ($filters_arr->price_format == 3) { ?>
                                    <?
                                    $price_min = $subItem->getField('price_floor_min') / 12 * $subItem->getField('area_floor_min');
                                    $price_max = $subItem->getField('price_floor_max') / 12 * $subItem->getField('area_floor_max');
                                    $dim = '<i class="far fa-ruble-sign"></i> в месяц';
                                    ?>
                                <? } elseif ($filters_arr->price_format == 4) { ?>
                                    <?
                                    $price_min = $subItem->getField('price_sale_min');
                                    $price_max = $subItem->getField('price_sale_max');
                                    $dim = '<i class="far fa-ruble-sign"></i> за м<sup>2</sup>';
                                    ?>
                                <? } elseif ($filters_arr->price_format == 5) { ?>
                                    <?
                                    $price_min = $subItem->getField('price_sale_min') * $subItem->getField('area_floor_min');
                                    $price_max = $subItem->getField('price_sale_max') * $subItem->getField('area_floor_max');
                                    $dim = '<i class="far fa-ruble-sign"></i> за все';
                                    ?>
                                <? } elseif ($filters_arr->price_format == 6) { ?>
                                    <?
                                    $price_min = $subItem->getField('price_sale_min') * 100;
                                    $price_max = $subItem->getField('price_sale_max') * 100;
                                    $dim = '<i class="far fa-ruble-sign"></i> за сотку';
                                    ?>
                                <? } elseif ($filters_arr->price_format == 7) { ?>
                                    <?
                                    $price_min = $subItem->getField('price_safe_pallet_eu_min');
                                    $price_max = $subItem->getField('price_safe_pallet_eu_max');
                                    $dim = '<i class="far fa-ruble-sign"></i> за п.м./сут';
                                    ?>
                                <? } elseif ($filters_arr->price_format == 8) { ?>
                                    <?
                                    $price_min = $subItem->getField('price_safe_volume_min');
                                    $price_max = $subItem->getField('price_safe_volume_max');
                                    $dim = '<i class="far fa-ruble-sign"></i> за м<sup>3</sup>/сут';
                                    ?>
                                <? } elseif ($filters_arr->price_format == 9) { ?>
                                    <?
                                    $price_min = $subItem->getField('price_safe_floor_min');
                                    $price_max = $subItem->getField('price_safe_floor_max');
                                    $dim = '<i class="far fa-ruble-sign"></i> за м<sup>2</sup>/сут';
                                    ?>
                                <? } else { ?>
                                    <? if ($subItem->getField('is_land')) { ?>
                                        <?
                                        $price_min = $subItem->getField('price_floor_min');
                                        $price_max = $subItem->getField('price_floor_max');
                                        $dim = '<i class="far fa-ruble-sign"></i> за м<sup>2</sup>';
                                        ?>
                                    <? } else { ?>
                                        <? if ($subItem->getField('deal_type') == 2) { ?>
                                            <?
                                            $price_min = $subItem->getField('price_sale_min');
                                            $price_max = $subItem->getField('price_sale_max');
                                            $dim = '<i class="far fa-ruble-sign"></i> за м<sup>2</sup>';
                                            ?>
                                        <? } elseif ($subItem->getField('deal_type') == 3) { ?>
                                            <?
                                            $price_min = $subItem->getField('price_safe_pallet_eu_min');
                                            $price_max = $subItem->getField('price_safe_pallet_eu_max');
                                            $dim = '<i class="far fa-ruble-sign"></i> за п.м./сут';
                                            ?>
                                        <? } else { ?>
                                            <?
                                            $price_min = $subItem->getField('price_floor_min');
                                            $price_max = $subItem->getField('price_floor_max');
                                            $dim = '<i class="far fa-ruble-sign"></i> за м<sup>2</sup>/год';
                                            ?>
                                        <? } ?>
                                    <? } ?>
                                <? } ?>

                                <?= valuesCompare(numFormat($price_min), numFormat($price_max)) ?>
                                <?= $dim ?>

                            </b>

                        </div>
                        <div class="obj-col-10 flex-box">
                            <div class="icon-round icon-star <?= (in_array([$subItem->getField('original_id'), $subItem->getField('type_id')], $favourites))  ? 'icon-star-active' : '' ?>" data-offer-id="[<?= $subItem->getField('original_id') ?>,<?= $subItem->getField('type_id') ?>]">
                                <i class="fas fa-star"></i>
                            </div>

                            <? if ($subItem->getField('ad_cian')) { ?>
                                <div class="icon-round" style="color: blue" title="Реклама ЦИАН">
                                    <i class="fas fa-rocket"></i>
                                </div>
                            <? } ?>
                            <? if ($subItem->getField('ad_yandex')) { ?>
                                <div class="icon-round" style="color: limegreen" title="Реклама Яндекс">
                                    <i class="fas fa-rocket"></i>
                                </div>
                            <? } ?>
                            <!--
                            <div class="icon-round">
                                <i class="fas fa-rocket"></i>
                            </div>
                            -->
                        </div>
                    </div>
                <? } ?>
            </div>
        <? } ?>
    </div>

    <?



    $offers_near = $offer->getOfferNeighbors();
    if ($_COOKIE['member_id'] == 141) {
        //include_once($_SERVER['DOCUMENT_ROOT'].'/errors.php');
        //var_dump($offers_near);
    }
    ?>

    <? if (count($offers_near)) { ?>
        <div class="tabs-block tabs-active-free">
            <div class="tabs flex-box">
                <? foreach ($offers_near as $offer_item) { ?>
                    <? $offer = new OfferMix($offer_item) ?>
                    <div class="box text_left tab dope-offer-tab" style="border-right: 2px solid #e7e5f2 ">
                        <div class="flex-box">
                            <div class="ghost">
                                <? if ($offer->getField('type_id') == 3) { ?>
                                    <b class="attention">
                                        Весь объект
                                    </b>
                                <? } else { ?>
                                    <?= $offer->getField('deal_type_name') ?> <?= $offer->getField('object_id') ?>-<?= preg_split('//u', $offer->getField('deal_type_name'), -1, PREG_SPLIT_NO_EMPTY)[0] ?>
                                <? } ?>

                            </div>
                        </div>
                        <div>
                            <?/*if($offer->getField('company_id')){?>
                            <b>
                                <?$company = new Company($offer->getField('company_id'))?>
                                <?= ($company->id) ? $company->title() : '--'?>
                            </b>
                        <?}*/ ?>
                        </div>
                        <div>
                            <? if ($offer->getField('area_min') || $offer->getField('area_max')) { ?>
                                <b>
                                    <?= valuesCompare($offer->getField('area_min'), $offer->getField('area_max')) ?> м<sup>2</sup>
                                </b>
                            <? } else { ?>
                                -
                            <? } ?>
                        </div>
                    </div>
                <? } ?>
            </div>



        </div>
    <? } ?>
</div>