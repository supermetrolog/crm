<?php
//require_once($_SERVER['DOCUMENT_ROOT'].'/errors.php');
$request = new Request($router->getPath()[1]);
?>
<div class="profile-card">
    <? require_once ($_SERVER['DOCUMENT_ROOT'].'/templates/requests/header/index.php');?>
    <div class="flex-box flex-wrap flex-vertical-top">
        <div class='widget one-fourth-flex box-small'>
            <div class='widget-title isBold'>
                Основная информация
            </div>
            <div class="widget-body">
                <ul>
                        <?$request_obj= new Request($request->postId())?>
                        <li>
                            <div class="flex-box flex-between">
                                <div class="underlined">
                                    Тип сделки:
                                </div>
                                <div>
                                    <div class="isBold">
                                        <a href="/request/<?=$request_obj->postId()?>">
                                            <?=$request_obj->getRequestDealTypeName()?> (<?=$request_obj->getRequestStatus()?>)
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="flex-box flex-between">
                                <div class="underlined">
                                    Назначение:
                                </div>
                                <div class="isBold">
                                    <?//var_dump($request->getJsonField('purposes'))?>
                                    <?if(($purposes = $request->getJsonField('purposes'))[0] != NULL){?>
                                        <?foreach ($purposes as $purpose){
                                            $purpose_obj = new Post($purpose);
                                            $purpose_obj->getTable('l_purposes');?>
                                            <div><?=$purpose_obj->title()?></div>
                                        <?}?>
                                    <?}?>
                                </div>
                            </div>
                            <div class="flex-box flex-between">
                                <div class="underlined">
                                    Площадь:
                                </div>
                                <div class="isBold">
                                    <?=valuesCompare($request_obj->getField('area_floor_min'),$request_obj->getField('area_floor_max'))?> м<sup>2</sup>
                                </div>
                            </div>
                            <div class="flex-box flex-between">
                                <div class="underlined">
                                    Бюджет:
                                </div>
                                <div><?=$request_obj->getField('price')?> руб/м <sup>2</sup></div>
                            </div>
                            <div class="flex-box flex-vertical-top flex-between">
                                <div class="underlined">
                                    Регионы:
                                </div>
                                <div>
                                    <?if(($regions = $request_obj->getRequestRegions())[0] != NULL){?>
                                        <?foreach ($regions as $region){
                                            $region_obj = new Post($region['id']);
                                            $region_obj->getTable('l_regions');?>
                                            <div><?=$region_obj->title()?></div>
                                        <?}?>
                                    <?}?>
                                </div>

                            </div>
                            <div class="flex-box flex-vertical-top  flex-between">
                                <div class="underlined">
                                    Направления:
                                </div>
                                <div>
                                    <?if(($directions = $request_obj->getRequestDirections())[0] != NULL){?>
                                        <?foreach ($directions as $direction){?>
                                            <?
                                            $direction_obj = new Post($direction['id']);
                                            $direction_obj->getTable('directions');
                                            ?>
                                            <div><?//=$direction_obj->title()?></div>
                                        <?}?>
                                    <?}?>
                                </div>
                            </div>
                        </li>
                </ul>
            </div>
        </div>
        <div class='widget one-fourth-flex box-small'>
            <div class='widget-title'>
                Основной контакт
            </div>
            <div class="widget-body">
                <ul>
                    <?
                    $selected_contact = $company->getField('contact_id');
                    $contact = new Contact($selected_contact);
                    ?>
                    <li>
                        <div>
                            <a href="/contact/<?=$contact->postId()?>">
                                <b>
                                    <?=$contact->title()?>
                                </b>
                            </a>
                        </div>
                        <div class="ghost">
                            <?$contact_group = new Post($contact->getField('contact_group'));
                            $contact_group->getTable('c_industry_contact_groups');
                            ?>
                            <?=$contact_group->title()?>
                        </div>
                        <div>
                            <?=$contact->getField('phone')?>
                        </div>
                        <div>
                            <?=$contact->getField('email')?>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
        <div class='widget one-fourth-flex box-small'>
            <div class='widget-title'>
                Компания
            </div>
            <div class="widget-body">
                <ul>
                    <?
                    $company = new Company($request->getField('company_id'));
                    ?>
                    <li>
                        <div>
                            <a href="/company/<?=$company->postId()?>">
                                <b>
                                    <?=$company->title()?>
                                </b>
                            </a>
                        </div>
                        <div>
                            <a href="/company/<?=$company->postId()?>">
                                <?=$company->getField('address')?>
                            </a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
        <div class="one-fourth-flex box-small">
            <div class='widget-title'>
                Описание
            </div>
            <div class="widget-body text_left box-small">
                <?=$request->description()?>
            </div>
        </div>
        <div class="one-fourth-flex box-small">
            <div class='widget-title '>
                Комментарии (<?=count($comments = $request->getPostComments())?>)
            </div>
            <div class="widget-body text_left box-small">
                <div>
                    <ul>
                        <?
                        foreach($comments as $comment){?>
                            <?$comment_obj = new Comment($comment['id']);?>
                            <li style="<?=($comment_obj->getField('is_important')) ? 'border: 3px solid red;' : ''?>">
                                <div class="flex-box box-vertical">
                                    <div>
                                        <?=$comment_obj->getAuthorName()?>
                                    </div>
                                    <div class="to-end ghost">
                                        <?=$comment_obj->publTime()?>
                                    </div>
                                </div>
                                <div>
                                    <?=$comment_obj->description()?>
                                </div>
                            </li>
                        <?}?>
                    </ul>
                </div>
                <div>
                    <form action="<?=PROJECT_URL?>/system/controllers/comments/create.php" method="post">
                        <input type="hidden" name="post_id_referrer" value="<?=$request->postId()?>"/>
                        <input type="hidden" name="table_id_referrer" value="<?=$request->setTableId()?>"/>
                        <textarea name="description" placeholder="Напишите..." class="textarea textarea-small box-small"></textarea>
                        <button>
                            Отправить
                        </button>
                        <input type="checkbox" name="is_important" value="1"/>Важный комментарий
                    </form>
                </div>
            </div>
        </div>
    </div>


</div>
<? include_once($_SERVER["DOCUMENT_ROOT"].'/templates/modals/edit-all/index.php')?>
