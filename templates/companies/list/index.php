<?php
/**
 * Created by PhpStorm.
 * User: Zhitkov
 * Date: 24.07.2018
 * Time: 13:16
 */
?>
<div class="object-item <?=($company->getField('processed') || $company->getField('status') == 2)? 'ghost-double' : ''?>">
    <div class="object-grid company-list-template">
        <div class="obj-col-1" style="position: relative;">
            <div>
                <a href="/company/<?=$company->postId()?>" target="_blank">
                    <?=$company->postId()?>
                </a>
            </div>
        </div>
        <div class="obj-col-2">
            <div class="isBold">
                <a href="/company/<?=$company->postId()?>/" target="_blank">
                    <?if($company->postId() == $company->title()){?>
                        <span class="attention ">NONAME <?=$company->postId()?></span>
                    <?}else{?>
                        <?=$company->title()?>
                    <?}?>
                    <?if($eng = $company->getField('title_eng')){?>
                        - <?=$eng?>
                    <?}?>
                </a>
            </div>

            <?if($company->getField('company_group_id')){?>
                <div class="ghost">
                    (<?=(new CompanyGroup($company->getField('company_group_id')))->title()?>)
                </div>
            <?}?>
            <div class="flex-column">
                <?if(($obj_amount = count($company->getCompanyAreaUnits('Building'))) > 0){?>
                    <div class="button-transparent">
                        Объекты: <?=$obj_amount?>
                    </div>
                <?}?>
                <?if(($obj_amount = count($company->getCompanyAreaUnits('Offer'))) > 0){?>
                    <div class="button-transparent">
                        Предложения: <?=$obj_amount?>
                    </div>
                <?}?>
                <?if(($obj_amount = count($company->getCompanyAreaUnits('Request'))) > 0){?>
                    <div class="button-transparent">
                        Запросы: <?=$obj_amount?>
                    </div>
                <?}?>
            </div>
        </div>
        <div class="for-disdivict obj-col-3">
            <ul>
                <?foreach($company->getJsonField('company_group') as $group){?>
                    <?$gr = new Post($group)?>
                    <?$gr->getTable('c_industry_company_groups')?>
                    <li class="icon-orthogonal "><a href="#" title=""><?=$gr->title()?></a></li>
                <?}?>
            </ul>
        </div>
        <div class="for-otmkad obj-col-4">
            <?if($sites = $company->getJsonField('sites_urls')){?>
                <?foreach($sites as $site){?>
                   <div>
                       <a href="<?=$site?>" target="_blank">
                           <?=$site?>
                       </a>
                   </div>
                <?}?>
            <?}else{?>
                <a href="<?=$company->getField('site_url')?>" target="_blank">
                    <?=$company->getField('site_url')?>
                </a>
            <?}?>

        </div>
        <div class="for-area obj-col-5">
            <?$contact = new Contact($company->getField('contact_id'))?>
            <?//$contact = new Contact($company->getCompanyAreaUnits('Contact')[]['id'])?>
            <div>
                <a href="/contact/<?=$contact->postId()?>" target="_blank">
                    <?=$contact->title()?>
                </a>
            </div>
            <div>
                <?=$contact->phone()?>
            </div>
            <div>
                <?=$contact->email()?>
            </div>
            <?if(($obj_amount = (count($company->getCompanyContacts()) - 1)) > 0){?>
                <div class="button-transparent">
                    Еще контакты: +<?=$obj_amount?>
                </div>
            <?}?>
        </div>
        <div class="obj-col-6">
            <div>
                <?if(($tasks = $company->getCompanyNewTasks()) > 0){?>
                    <div class="attention">
                        Новые задачи: <?=$tasks?>
                    </div>
                <?}?>
                <?if(($tasks = $company->getCompanyInprogressTasks()) > 0){?>
                    <div>
                        В работе: <?=$tasks?>
                    </div>
                <?}?>
                <?if(($tasks = $company->getCompanyCompletedTasks()) > 0){?>
                    <div class="good">
                        Завершенные: <?=$tasks?>
                    </div>
                <?}?>
            </div>
        </div>
        <div class="for-customer obj-col-7">
            <div class="for-customer-label">
                <?
                $agent = new Member($company->getField('agent_id'));
                echo $agent->getField('title');
                ?>
            </div>
        </div>
        <div class="for-agent obj-col-8">
            <?
            if($company->getField('status')){
            $status = new Post($company->getField('status'));
            $status->getTable('l_statuses_all');
            echo $status->getField('title');
            }
            ?>
        </div>
        <div class="for-result obj-col-9">
            <div class="<?//=(in_array($offer->getField('offer_status'), [2,3,4])) ? 'unactive' : '';?>">
                <?= date('d.m.Y',$company->getField('last_update'))?><br>
                <?= date('H:m',$company->getField('last_update'))?>
            </div>
        </div>
        <div class="for-dt obj-col-10">
            <?//=$object->lastUpdate()?>
            <!--<nobr><?// $object->timeFormat($object->lastUpdate())?></nobr>-->
            <div class="flex-box flex-wrap">
                <!--
                <div class="icon-round icon-star <? //($logedUser->inFavourites($object->itemId())) ? 'icon-hl' : '' ?>" data-object-id="<? //$object->itemId()?>">
                    <i class="fas fa-star"></i>
                </div>
                -->
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
                -->
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

                <form id="edit-all-form" style="margin: 0;"  onkeydown="if(event.keyCode===13){return false;}"  name="edit-all" enctype="multipart/form-data" method="POST" action='<?=PROJECT_URL?>/system/controllers/posts/create.php'>
                    <div class="form-content ">
                        <div class="anketa box text_left ad_panel"  style="color: #ffffff;">
                            <?

                                $post = new Post($company->postId());
                                $post->getTable($company->setTable());

                            $src = $post->getLine();
                            $photo = $post->photos();

                            ?>
                            <input type="hidden" name="id" value="<?=$company->postId()?>">
                            <input type="hidden" name="table" value="<?=$company->setTable()?>">

                            <div class="flex-box flex-vertical-top flex-between flex-wrap">
                                <div>
                                    <div class="box-vertical">
                                        <?
                                        $fields_arr = [288];
                                        foreach($fields_arr as $field){
                                            $field = new Field($field);?>
                                            <div class="flex-box box-vertical">
                                                <div class="form-element">
                                                    <? include ($_SERVER['DOCUMENT_ROOT'].'/templates/fields/templates/'.$field->getField('field_template').'/index.php');?>
                                                </div>
                                                <div class="box-wide">
                                                    <?=$field->titleToDisplay()?>
                                                </div>
                                            </div>
                                        <?}?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>




