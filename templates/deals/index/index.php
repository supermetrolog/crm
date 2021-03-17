<?php
$deal = new Deal($router->getPath()[1]);
?>
<div class="profile-card">
    <? require_once ($_SERVER['DOCUMENT_ROOT'].'/templates/deals/header/index.php');?>
    <div class="flex-box flex-wrap flex-vertical-top">
        <div class='widget one-fourth-flex box-small'>
            <div class='widget-title isBold'>
                Основная информация
            </div>
            <div class="widget-body">
                <ul>
                    <?$deal_obj= new Deal($deal->postId())?>
                    <li>
                        <div class="flex-box flex-between">
                            <div class="underlined">
                                Тип сделки:
                            </div>
                            <div>
                                <div class="isBold">
                                    <a href="/request/<?=$deal_obj->postId()?>">
                                        <?
                                        $deal_type = new Post($deal_obj->getField('deal_type'));
                                        $deal_type->getTable('c_deal_types')
                                        ?>
                                        <?=$deal_type->title()?>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="flex-box flex-between">
                            <div class="underlined">
                                Назначение:
                            </div>
                            <div class="isBold">
                                <?/*if(($purposes = $deal_obj->getRequestPurposes())[0] != NULL){?>
                                    <?foreach ($purposes as $purpose){
                                        $purpose_obj = new Post($purpose['id']);
                                        $purpose_obj->getTable('item_purposes');?>
                                        <div><?=$purpose_obj->title()?></div>
                                    <?}?>
                                <?}*/?>
                            </div>
                        </div>
                        <div class="flex-box flex-between">
                            <div class="underlined">
                                Площадь:
                            </div>
                            <div class="isBold">
                                <?=$deal_obj->getField('area_building')?> м <sup>2</sup>
                            </div>
                        </div>
                        <div class="flex-box flex-between">
                            <div class="underlined">
                                Бюджет:
                            </div>
                            <div><?=$deal_obj->getField('price')?> руб/м <sup>2</sup></div>
                        </div>
                        <div class="flex-box flex-vertical-top flex-between">
                            <div class="underlined">
                                Регионы:
                            </div>
                            <div>
                                <?/*if(($regions = $deal_obj->getRequestRegions())[0] != NULL){?>
                                    <?foreach ($regions as $region){
                                        $region_obj = new Post($region['id']);
                                        $region_obj->getTable('l_regions');?>
                                        <div><?=$region_obj->title()?></div>
                                    <?}?>
                                <?}*/?>
                            </div>

                        </div>
                        <div class="flex-box flex-vertical-top  flex-between">
                            <div class="underlined">
                                Направления:
                            </div>
                            <div>
                                <?/*if(($directions = $deal_obj->getRequestDirections())[0] != NULL){?>
                                    <?foreach ($directions as $direction){?>
                                        <?
                                        $direction_obj = new Post($direction['id']);
                                        $direction_obj->getTable('directions');
                                        ?>
                                        <div><?=$direction_obj->title()?></div>
                                    <?}?>
                                <?}*/?>
                            </div>
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
                    $company = new Company($deal_obj->getField('company_id'));
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
                <?=$deal->description()?>
            </div>
        </div>
        <div class="one-fourth-flex box-small">
            <div class='widget-title '>
                Комментарии (<?=count($comments = $deal->getPostComments())?>)
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
                        <input type="hidden" name="post_id_referrer" value="<?=$deal->postId()?>"/>
                        <input type="hidden" name="table_id_referrer" value="<?=$deal->setTableId()?>"/>
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
