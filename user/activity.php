<?php
/**
 * Created by PhpStorm.
 * User: Zhitkov
 * Date: 25.05.2018
 * Time: 13:16
 */
?>
<div class='activity-list'>
    <?
    $actions = new Action(0);
    foreach ($actions->getAllUnitsReverse() as $action){
        $listAction = new Action($action['id']);

        $listActionType = new Post($listAction->actionType());
        $listActionType->getTable('actions_type');

        $author = new Member($listAction->author());

        $post = new Post($action['element_id']);
        $post->getTable($listActionType->showField('action_table'));
            ?>
            <div class="record-unit activity-unit">
                <div>
                    <div class="flex-box i-am-wide flex-vertical-center">
                        <div class="message-author-photo ">
                            <a href="<?=PROJECT_URL?>/user/<?=$author->member_id()?>/">
                                <img  src='<?=$author->avatar()?>'/>
                            </a>
                        </div>
                        <div>
                            <a href="<?=PROJECT_URL?>/user/<?=$author->member_id()?>/">
                                <?=$author->surName()?> <?=$author->name()?>
                            </a>
                        </div>
                        <div class="record-text">
                            <?=$listActionType->description()?>
                        </div>
                        <?if($post->postId()){?>
                        <div class="record-text">
                            <?if($listActionType->showField('action_table') == 'users'){?>
                                <a href="<?=PROJECT_URL?>/user/<?=$post->postId()?>/">
                                    <b>
                                        <?=$post->title()?>
                                    </b>
                                </a>
                            <?}elseif($listActionType->showField('action_table') == 'comments'){?>
                                <?$comment = new Comment($post->postId());?>
                                <?$comment_group = new Post($comment->groupId());?>
                                <?$comment_group->getTable('comment_groups');?>
                                <?$commentRecord = new Post($comment->toRecord());?>
                                <?$commentRecord->getTable($comment_group->title());?>
                                <?if($comment_group->title()=='database_records'){?>
                                    <?if($commentRecord->showField('original_id') != 0 ){?>
                                        <a href="<?=PROJECT_URL?>/<?=$comment_group->description()?>/<?=$commentRecord->title()?>/<?=$commentRecord->postId()?>/">
                                            <b>репост</b> к записи
                                        </a>
                                        <?$originalRecord = new Record($commentRecord->showField('original_id'));?>
                                        <a href="<?=PROJECT_URL?>/<?=$comment_group->description()?>/<?=$originalRecord->furl()?>/<?=$originalRecord->record_id()?>/">
                                            <b>
                                                <?=$originalRecord->title()?>
                                            </b>
                                        </a>
                                    <?}else{?>
                                        <a href="<?=PROJECT_URL?>/<?=$comment_group->description()?>/<?=$commentRecord->furl()?>/<?=$commentRecord->postId()?>/">
                                            <b>
                                                <?=$commentRecord->title()?>
                                            </b>
                                        </a>
                                    <?}?>
                                <?}else{?>
                                    <a href="<?=PROJECT_URL?>/<?=$comment_group->description()?>/<?=$commentRecord->furl()?>/<?=$commentRecord->postId()?>/">
                                        <b>
                                            <?=$commentRecord->title()?>
                                        </b>
                                    </a>
                                <?}?>
                            <?}else{?>
                                <?if($post->showField('original_id') != 0 ){?>
                                    <?$originalRecord = new Record($post->showField('original_id'));?>
                                    <a href="<?=PROJECT_URL?>/record/<?=$post->furl()?>/<?=$post->postId()?>/">
                                        <b>репост</b> к записи
                                    </a>
                                    <a href="<?=PROJECT_URL?>/record/<?=$originalRecord->furl()?>/<?=$originalRecord->record_id()?>/">
                                        <b>
                                            <?=$originalRecord->title()?>
                                        </b>
                                    </a>
                                <?}else{?>
                                    <a href="<?=PROJECT_URL?>/record/<?=$post->furl()?>/<?=$post->postId()?>/">
                                        <b>
                                            <?=$post->title()?>
                                        </b>
                                    </a>
                                <?}?>
                            <?}?>
                        </div>
                        <?}?>
                        <div class="message-stats ghost right">
                            <?=$listAction->publTime()?>
                        </div>
                    </div>
                </div>
            </div>
    <?}?>
</div>