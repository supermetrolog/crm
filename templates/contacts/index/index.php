<?php
$contact = new Contact($router->getPath()[1]);
?>
    <div class="profile-card">
        <? require_once ($_SERVER['DOCUMENT_ROOT'].'/templates/contacts/header/index.php');?>
        <div class="flex-box flex-wrap flex-vertical-top">
            <div class='widget one-fourth-flex box-small'>
                <div class='widget-title'>
                    Основной контакт
                </div>
                <div class="widget-body">
                    <ul>
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
                                <?=$contact->phone()?>
                            </div>
                            <div>
                                <?=$contact->email()?>
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
                        $company = new Company($contact->getField('company_id'));
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
            <div class='widget one-fourth-flex box-small'>
                <div class='widget-title'>
                    История изменения
                </div>
                <div class="widget-body">
                    <ul>
                        <?
                        $changes = $contact->getPostChanges();
                        foreach($changes as $change){
                            //var_dump($change)
                            $post_before = json_decode($change['post_before']);
                            $post_after = json_decode($change['post_after']);
                            //var_dump($post_after);
                            ?>
                        <li>
                            <div class="flex-box box-vertical">
                                <div class="isBold">
                                    <?=(new Member($change['author_id']))->getField('title')?>
                                </div>
                                <div class="to-end ghost">
                                    <?=date('Y-m-d',$change['publ_time'])?>
                                </div>
                            </div>
                            <div class="flex-box flex-between">
                                <div>
                                    <?=$post_before->title?>
                                </div>
                                <div>
                                    <i class="fas fa-long-arrow-alt-right"></i>
                                </div>
                                <div>
                                    <?=$post_after->title?>
                                </div>
                            </div>
                        </li>
                        <?}?>
                    </ul>
                </div>
            </div>
            <div class="one-fourth-flex box-small">
                <div class='widget-title'>
                    Описание
                </div>
                <div class="widget-body text_left box-small">
                    <?=$contact->description()?>
                </div>
            </div>
            <div class="one-fourth-flex box-small">
                <div class='widget-title '>
                    Комментарии (<?=count($comments = $contact->getPostComments())?>)
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
                            <input type="hidden" name="post_id_referrer" value="<?=$contact->postId()?>"/>
                            <input type="hidden" name="table_id_referrer" value="<?=$contact->setTableId()?>"/>
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
        <div class='work-area box-left-top'>
            <? //include($_SERVER["DOCUMENT_ROOT"].'/system/user/'.$page_template.'.php');?>
        </div>

    </div>
<? include_once($_SERVER["DOCUMENT_ROOT"].'/templates/modals/edit-all/index.php')?>