<?php
/**
 * Created by PhpStorm.
 * User: Zhitkov
 * Date: 04.05.2018
 * Time: 10:37
 */
?>


<div class='records-list'>
    <?
        $record_id = explode('/',$furl['path'])[3];
        $listRecord = new Record($record_id);
        $author = new Member($listRecord->author());
    ?>
                <div class="record-unit">
                    <div class="message-info flex-box">
                        <div class="message-author-photo ">
                            <a href="<?=PROJECT_URL?>/user/<?=$author->member_id()?>/">
                                <img  src='<?=$author->avatar()?>'/>
                            </a>
                        </div>
                        <div class="message-stats">
                            <div class="">
                                <?=$author->surName()?> <?=$author->name()?>
                            </div>
                            <div class="message-stats ghost">
                                <?=$listRecord->publ_time()?>
                            </div>
                        </div>
                    </div>
                    <?if($listRecord->isRepost()){?>
                        <? $originalRecord = new Record($listRecord->originalId()); ?>
                        <? $originalAuthor = new Member($originalRecord->author()); ?>
                        <div class="box repost">
                            <div class="message-info flex-box">
                                <div class="message-author-photo ">
                                    <a href="<?=PROJECT_URL?>/user/<?=$originalAuthor->member_id()?>/">
                                        <img  src='<?=$originalAuthor->avatar()?>'/>
                                    </a>
                                </div>
                                <div class="message-stats">
                                    <div class="">
                                        <?=$originalAuthor->surName()?> <?=$originalAuthor->name()?>
                                    </div>
                                    <div class="message-stats ghost">
                                        <?=$originalRecord->publ_time()?>
                                    </div>
                                </div>
                            </div>
                            <div class="record-header flex-box ">
                                <div class="record-title">
                                    <a href='<?=PROJECT_URL?>/record/<?=$originalRecord->record_id()?>'>
                                        <?=$originalRecord->title()?>
                                    </a>
                                </div>
                                <div class="record-time right">
                                    <? //$listRecord->publ_time()?>
                                </div>
                            </div>
                            <div class="record-text">
                                <?=$originalRecord->preview()?>
                            </div>
                        </div>
                    <?}else{?>
                        <div class="record-header flex-box">
                            <div class="record-title">
                                    <?=$listRecord->title()?>
                            </div>
                            <div class="record-time right">
                                <? //$listRecord->publ_time()?>
                            </div>
                        </div>
                        <div class="record-text">
                            <?=$listRecord->preview()?>
                        </div>
                    <?}?>
                    <div class="ghost">
                        <?if($listRecord->photos()){?>
                            Прикреплено файлов (<?=count($listRecord->photos())?>)
                        <?}?>
                        <?foreach($listRecord->photos() as $doc){?>
                            <a title='Открыть файл' href="<?=PROJECT_URL.'/'.$doc?>" target="_blank"><i class="far fa-file"></i></a>
                        <?}?>
                    </div>
                    <div class="box">
                    </div>
                    <? if($logedUser->member_id()){?>
                        <div class="record-actions flex-box">
                            <div class="record-social-actions flex-box">
                                <div class="action-like">
                                    <form action='<?=PROJECT_URL?>/modules/likes/index.php' method='GET'>
                                        <input type='hidden' name='record_id' value='<?=$listRecord->record_id()?>'/>
                                        <input type="hidden" name="type" value="record"/>
                                        <button class=""?>
                                            <i class="fas fa-thumbs-up  <?=($listRecord->likedBy()) ? '' : 'ghost-actions'; ?>"></i>
                                        </button>
                                        <span><?=$listRecord->getLikesAmount()?></span>
                                    </form>
                                </div>
                                <div class="action-dislike">
                                    <form action='<?=PROJECT_URL?>/modules/dislikes/index.php' method='GET'>
                                        <input type='hidden' name='record_id' value='<?=$listRecord->record_id()?>'/>
                                        <input type="hidden" name="type" value="record"/>
                                        <button class=""?>
                                            <i class="fas fa-thumbs-down <?=($listRecord->dislikedBy()) ? '' : 'ghost-actions'; ?>"></i>
                                        </button>
                                        <span><?=$listRecord->getDislikesAmount()?></span>
                                    </form>
                                </div>
                                <div class="action-repost">
                                    <form action='<?=PROJECT_URL?>/modules/reposts/index.php' method='GET'>
                                        <input type='hidden' name='record_id' value='<?=$listRecord->record_id()?>'/>
                                        <button class=""?>
                                            <i class="fas fa-share-square <?=($listRecord->repostedBy()) ? '' : 'ghost-actions'; ?>"></i>
                                        </button>
                                        <span><?=$listRecord->getRepostsAmount()?></span>
                                    </form>
                                </div>
                                <div class="action-comment">
                                    <form  >
                                        <input type='hidden' name='record_id' value='<?=$listRecord->record_id()?>'/>
                                        <button disabled>
                                            <i class="fas fa-comment-alt <?=($listRecord->commentedBy()) ? '' : 'ghost-actions'; ?>"></i>
                                        </button>
                                        <span><?=$listRecord->getCommentsAmount()?></span>
                                    </form>
                                </div>
                            </div>
                            <div class="record-author right">
                                <?if($listRecord->author() == $logedUser->member_id() || $logedUser->isAdmin()){?>
                                    <div>
                                        <form action="<?=PROJECT_URL?>/modules/records/delete.php" method="POST">
                                            <input type="hidden" name="record_id" value="<?=$listRecord->record_id()?>"/>
                                            <button title="Удалить запись">Удалить</button>
                                        </form>
                                    </div>
                                <?}else{?>
                                    <?if($logedUser->member_id() > 0){?>
                                        <div>
                                            <form action="<?=PROJECT_URL?>/modules/records/complain.php" method="POST">
                                                <input type="hidden" name="record_id" value="<?=$listRecord->record_id()?>"/>
                                                <button title="Пожаловаться на запись">Пожаловаться</button>
                                            </form>
                                        </div>
                                    <?}?>
                                <?}?>
                            </div>
                        </div>
                        <div class="record_comments">
                            <?
                            foreach ($listRecord->getComments() as $comment){
                                $comment = new Comment($comment['id']); ?>
                                <? $author = new Member($comment->author()); ?>
                                <div class="comment-unit box">
                                    <div class="message-info flex-box">
                                        <div class="message-author-photo ">
                                            <a href="<?=PROJECT_URL?>/user/<?=$author->member_id()?>/">
                                                <img  src='<?=$author->avatar()?>'/>
                                            </a>
                                        </div>
                                        <div class="message-stats">
                                            <div class="">
                                                <?=$author->surName()?> <?=$author->name()?>
                                            </div>
                                            <div class="message-stats ghost">
                                                <?=$comment->publTime()?>
                                            </div>
                                        </div>
                                        <div class="record-author right">
                                            <?if($comment->author() == $logedUser->member_id() || $logedUser->isAdmin()){?>
                                                <div>
                                                    <form action="<?=PROJECT_URL?>/modules/comments/delete.php" method="POST">
                                                        <input type="hidden" name="comment_id" value="<?=$comment->commentId()?>"/>
                                                        <button title="Удалить комментарий"><i class="fas fa-times"></i></button>
                                                    </form>
                                                </div>
                                            <?}else{?>
                                                <?if($logedUser->member_id() > 0){?>
                                                    <div>
                                                        <form action="<?=PROJECT_URL?>/modules/comments/complain.php" method="POST">
                                                            <input type="hidden" name="comment_id" value="<?=$comment->commentId()?>"/>
                                                            <button title="Пожаловаться"><i class="far fa-frown"></i></button>
                                                        </form>
                                                    </div>
                                                <?}?>
                                            <?}?>
                                        </div>
                                    </div>
                                    <div class="record-text">
                                        <?=$comment->description()?>
                                    </div>
                                    <div class="record-actions flex-box">
                                        <div class="record-social-actions flex-box right">
                                            <div class="action-like">
                                                <form action='<?=PROJECT_URL?>/modules/likes/index.php' method='GET'>
                                                    <input type='hidden' name='comment_id' value='<?=$comment->commentId()?>'/>
                                                    <input type="hidden" name="type" value="comment"/>
                                                    <button class=""?>
                                                        <i class="fas fa-thumbs-up  <?=($comment->likedBy()) ? '' : 'ghost-actions'; ?>"></i>
                                                    </button>
                                                    <span><?=$comment->getLikesAmount()?></span>
                                                </form>
                                            </div>
                                            <div class="action-dislike">
                                                <form action='<?=PROJECT_URL?>/modules/dislikes/index.php' method='GET'>
                                                    <input type='hidden' name='comment_id' value='<?=$comment->commentId()?>'/>
                                                    <input type="hidden" name="type" value="comment"/>
                                                    <button class=""?>
                                                        <i class="fas fa-thumbs-down <?=($comment->dislikedBy()) ? '' : 'ghost-actions'; ?>"></i>
                                                    </button>
                                                    <span><?=$comment->getDislikesAmount()?></span>
                                                </form>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            <? }?>
                        </div>
                        <?(count($listRecord->getComments()) > 0)? $comment_field = '': $comment_field='hidden';?>
                        <div class="comment-form <?=$comment_field?>">
                            <div class="room-form box">
                                <form action="<?=PROJECT_URL?>/modules/comments/create.php" method="POST">
                                    <input type='hidden' name='record_id' value='<?=$listRecord->record_id()?>'/>
                                    <input type='hidden' name='comment_group' value='1'/>
                                    <input type='hidden' name='answer_to_id' value='<?=$listRecord->record_id()?>'/>
                                    <div class="flex-box">
                                        <div class="photo_round" style="" >
                                            <img src="<?=$logedUser->avatar()?>" /?>
                                        </div>
                                        <div class=" flex-box right" style="width: 95%">
                                            <textarea class="comment-box box right" placeholder="Написать комментарий..." name="description"></textarea>
                                        </div>
                                    </div>
                                    <div class="comment-panel hidden">
                                        <div class="flex-box box" >
                                            <div>

                                            </div>
                                            <div class="right">
                                                <button class="btn-send">Отправить</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    <?}?>
                </div>
</div>