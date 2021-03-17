<?php
/**
 * Created by PhpStorm.
 * User: Zhitkov
 * Date: 24.07.2018
 * Time: 13:16
 */
?>
<div class="object-item">
    <div class="object-grid object-list-template ">
        <div class="obj-col-1" style="position: relative;">
            <div>
                <a href="/contact/<?=$contact->postId()?>" class="a-classic"><?=$contact->postId()?></a>
            </div>
        </div>
        <div class="obj-col-2">
            <div class="">
                <?
                    $contactGroup = new Post($contact->showField('contact_group'));
                    $contactGroup->getTable('c_industry_contact_groups');
                    echo $contactGroup->title();
                ?>
            </div>
        </div>
        <div class="for-region obj-col-3">
            <?= date('Y-m-d',$contact->showField('publ_time'))?>
        </div>
        <div class="for-disdivict obj-col-4">
            <b>
                <?=$contact->showField('company_name')?>
            </b>
        </div>
        <div class="for-otmkad obj-col-5">
            <a href="<?=$contact->showField('site')?>">
                <?=$contact->showField('site')?>
            </a>
        </div>
        <div class="for-area obj-col-6">
            <a href="<?=$contact->postId()?>">
                <?=$contact->title()?>
            </a>
        </div>
        <div class="for-price obj-col-7">
            <div class="ghost" style="font-size: 12px; position: absolute; top: 15px;">
                <?//=$offer->getOfferDealType()?>
            </div>
            <div class="isBold">

            </div>
        </div>
        <div class="for-customer obj-col-8">
            <div class="for-customer-label">
                <?
                $agent = new Member($contact->showField('agent_id'));
                echo $agent->showField('title');
                ?>
            </div>
        </div>
        <div class="for-agent obj-col-9">
            Актив
        </div>
        <div class="for-result obj-col-10 ">
            <div class="<?//=(in_array($offer->showField('offer_status'), [2,3,4])) ? 'unactive' : '';?>">
                <?= date('Y-m-d',$contact->showField('last_update'))?><br>
                <?= date('H:i',$contact->showField('last_update'))?>
            </div>
        </div>
        <div class="for-dt obj-col-11">
            <?//=$object->lastUpdate()?>
            <!--<nobr><?// $object->timeFormat($object->lastUpdate())?></nobr>-->
            <div class="flex-box flex-wrap">
                <!--
                <div class="icon-round icon-star <? //($logedUser->inFavourites($object->itemId())) ? 'icon-hl' : '' ?>" data-object-id="<? //$object->itemId()?>">
                    <i class="fas fa-star"></i>
                </div>
                -->
                <div class="icon-round">
                    <a href="/favor/" class="">
                        <i class="fas fa-envelope"></i>
                    </a>
                </div>
                <div class="icon-round">
                    <a href="/favor/" class="">
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
</div>




