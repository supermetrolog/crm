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
                <a href="/request/<?=$request->postId()?>" class="a-classic"><?=$request->postId()?></a>
            </div>
        </div>
        <div class="obj-col-2">
            <div class="">
                <?
                $requestType = new Post($request->getField('deal_type'));
                $requestType->getTable('c_deal_types');
                echo $requestType->title();
                ?>
            </div>
            <div>
                <?=$request->getField('dt_insert')?>
            </div>
        </div>
        <div class="for-region obj-col-3">
            <b>
                <?=$request->getField('area_min')?> - <?=$request->getField('area_max')?> м<sup>2</sup>
            </b>
        </div>
        <div class="for-disdivict obj-col-4">
            <?if($request->getField('price')){?>
                <div class="isBold">
                    <?= $request->getField('price')?> <i class="fas fa-ruble-sign"></i>  <span style="font-size: 10px;"> м<sup>2</sup>/год</span>
                </div>
            <?}else{?>

            <?}?>
        </div>
        <div class="for-otmkad obj-col-5">
                <?//=$request->showField('description')?>
        </div>
        <div class="for-area obj-col-6">
                <?if($company_id = $request->showField('company_id')){?>
                    <?$company = new Company($company_id);?>
                    <div>
                        <a href="/company/<?=$company->postId()?>">
                            <b>
                                <?=$company->title()?>
                            </b>
                        </a>
                    </div>
                <?}?>
                <?if($contact_id = $request->getField('contact_id')){?>
                    <?$contact = new Contact($contact_id);?>
                    <div class="for-customer-label">
                        <div>
                            <a href="/contact/<?=$contact->postId()?>">
                                <?=$contact->getField('title')?>
                            </a>
                        </div>
                        <div>
                            <?=$contact->getField('phone')?>
                        </div>
                    </div>
                <?}?>
        </div>
        <div class="for-agent obj-col-7">
            <?
            $agent = new Member($request->showField('agent_id'));
            echo $agent->showField('title');
            ?>
        </div>
        <div class="for-result obj-col-8 ">
            <div class="<?=(in_array($request->showField('result'), [2,3,4])) ? 'unactive' : '';?>">
                <?if(in_array($request->showField('result'), [2,3,4])){?>
                    Пассив
                <?}?>
                <?=$request->showField('result')?>
            </div>
        </div>
        <div class="for-dt obj-col-9">
            <?//=$object->lastUpdate()?>
            <!--<nobr><?// $object->timeFormat($object->lastUpdate())?></nobr>-->
            <div class="flex-box flex-wrap">
                <!--
                <div class="icon-round icon-star <? //($logedUser->inFavourites($object->itemId())) ? 'icon-hl' : '' ?>" data-object-id="<? //$object->itemId()?>">
                    <i class="fas fa-star"></i>
                </div>
                -->
                <?=$request->showField('dt_update_full')?>
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




