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
                <?if($request->getField('deal_type')){?>
                    <?
                    $requestType = new Post($request->getField('deal_type'));
                    $requestType->getTable('l_deal_types');
                    echo $requestType->title();
                    ?>
                <?}?>

            </div>
            <div>
                <?=date('Y-m-d',$request->getField('publ_time'))?>
            </div>
        </div>
        <div class="for-region obj-col-3">
            <b>
                <?= valuesCompare($request->getField('area_floor_min'),$request->getField('area_floor_max'))?> м<sup>2</sup>
            </b>
        </div>
        <div class="for-disdivict obj-col-4">
            <?if($request->getField('price_min') || $request->getField('price_max')){?>
                <div class="isBold">
                    <?= valuesCompare($request->getField('price_min'),$request->getField('price_max'))?> <i class="fas fa-ruble-sign"></i>  <span style="font-size: 10px;"> м<sup>2</sup>/год</span>
                </div>
            <?}else{?>

            <?}?>
        </div>
        <div class="for-otmkad obj-col-5">
            <?if(arrayIsNotEmpty($arr = $request->showJsonField('regions'))){?>
                <?foreach($arr as $item){?>
                    <?php
                    $opt = new Post($item);
                    $opt->getTable('l_regions');
                    ?>
                    <?=$opt->title();?>
                <?}?>
            <?}?>
            <?if(arrayIsNotEmpty($arr = $request->showJsonField('directions'))){?>
                <?foreach($arr as $item){?>
                    <?php
                    $opt = new Post($item);
                    $opt->getTable('l_directions');
                    ?>
                    <?=$opt->title();?>
                <?}?>
            <?}?>
            <?if(arrayIsNotEmpty($arr = $request->showJsonField('highways'))){?>
                <?foreach($arr as $item){?>
                    <?php
                    $opt = new Post($item);
                    $opt->getTable('l_highways');
                    ?>
                    <?=$opt->title();?>
                <?}?>
            <?}?>
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
            <?
            $status = new Post($company->getField('status'));
            $status->getTable('l_statuses_all');
            echo $status->getField('title');
            ?>
            <?/*if($request->showField('request_status')){?>
                <div class="<?=(in_array($request->showField('request_status'), [2,3,4])) ? 'unactive' : '';?>">
                    <?
                    $req_status = new Post($request->showField('request_status'));
                    $req_status->getTable('l_request_results');
                    echo $req_status->title();
                    ?>
                </div>
            <?}*/?>
        </div>
        <div class="for-dt obj-col-9">
            <div class="flex-box flex-wrap">
                <?=date('Y-m-d H:i',$request->showField('last_update'))?>
                <!--
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
                -->
            </div>
        </div>
    </div>
</div>




