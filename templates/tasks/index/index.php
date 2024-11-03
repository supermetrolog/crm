<?php
$task = new Task($router->getPath()[1]);
if($logedUser->member_id() == $task->getField('agent_id')){
    $task->markAsRead();
}

?>
<div class="profile-card">
    <? require_once ($_SERVER['DOCUMENT_ROOT'].'/templates/tasks/header/index.php');?>
    <div class="flex-box flex-vertical-top">
        <div class='widget one-fourth-flex box-small'>
            <div class='widget-title isBold'>
                Основная информация
            </div>
            <div class="widget-body">
                <ul>
                    <?$task_obj= new Task($task->postId())?>
                    <li>
                        <div class="flex-box flex-between">
                            <div class="underlined">
                                Дата начала:
                            </div>
                            <div>
                                <div class="isBold">
                                    <?=$task_obj->getField('start_time')?>
                                </div>
                            </div>
                        </div>
                        <div class="flex-box flex-between">
                            <div class="underlined">
                                Дата окончания:
                            </div>
                            <div class="isBold">
                                <?=$task_obj->getField('end_time')?>
                            </div>
                        </div>
                        <div class="flex-box flex-between">
                            <div class="underlined">
                                Назначена кем:
                            </div>
                            <div>
                                <?$author = new Member($task_obj->getField('author_id'))?>
                                <?=$author->getField('title')?>
                            </div>
                        </div>
                        <div class="flex-box flex-between">
                            <div class="underlined">
                                Назаначена кому:
                            </div>
                            <div>
                                <?$author = new Member($task_obj->getField('agent_id'))?>
                                <?=$author->getField('title')?>
                            </div>
                        </div>
                        <div class="flex-box flex-vertical-top flex-between">
                            <div class="underlined">
                                К чему:
                            </div>
                            <div>
                                <?if($area = $task_obj->getField('company_area')){?>
                                    <?$area = new Post($area);?>
                                    <?$area->getTable('l_companies_areas') ?>
                                    <?=$area->getField('title')?>
                                <?}else{?>
                                    не указано
                                <?}?>
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
                    $company = new Company($task_obj->getField('company_id'));
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
                <?=$task->description()?>
            </div>
        </div>
        <div class="one-fourth-flex box-small">
            <div class='widget-title '>
                Комментарии (<?=count($comments = $task->getPostComments())?>)
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
                        <input type="hidden" name="post_id_referrer" value="<?=$task_obj->postId()?>"/>
                        <input type="hidden" name="table_id_referrer" value="<?=$task_obj->setTableId()?>"/>
                        <textarea name="description" class="textarea textarea-small box-small"></textarea>
                        <div class="flex-box flex-between flex-vertical-top">
                            <div>
                                <input type="checkbox" name="is_important" value="1"/>Важный комментарий
                            </div>
                            <div class="comment-remind">
                                <input class="remind" type="checkbox" /> Напомнить
                                <input class="hidden" type="datetime-local" name="remind_time"/>
                            </div>
                        </div>
                        <button>
                            Отправить
                        </button>

                    </form>
                </div>
            </div>
        </div>
    </div>


</div>
<? include_once($_SERVER["DOCUMENT_ROOT"].'/templates/modals/edit-all/index.php')?>
