<?php
/**
 * Created by PhpStorm.
 * User: Zhitkov
 * Date: 27.06.2018
 * Time: 16:26
 */
?>
<?
/*
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
*/

include_once($_SERVER['DOCUMENT_ROOT'].'/system/classes/autoload.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/global_pass.php');


if($_POST['post_id']){
    $listMessage = new Message($_POST['post_id']);
    $listMessage->setTable($_POST['table']);
    $author = new Member($listMessage->getAuthor());
}
?>
<div class="message flex-box">
    <div class="message-info">
        <div class="flex-box">
            <div class="photo-round photo-small">
                <?if($author->member_id() != $author_last  ){?>
                    <a href="<?=PROJECT_URL?>/user/<?=$author->member_id()?>/">
                        <img  src='<?=$author->avatar()?>'/>
                    </a>
                <?}?>
            </div>
            <div class="box">
                <div class="message-stats flex-box">
                    <?if($author->member_id() != $author_last){?>
                        <div class="isBold">
                            <?=$author->title()?>
                        </div>
                        <div class="message-stats ghost box-wide">
                            <?=$listMessage->publ_time()?>
                        </div>
                    <?}?>
                </div>
                <div class="message-body">
                    <?=$listMessage->text()?>
                </div>
            </div>
        </div>
    </div>
    <div class="record-author right">
        <?if($listMessage->author() == $pageUser->member_id() || $pageUser->isAdmin()){?>
            <div class="delete_post">
                <form action="<?=PROJECT_URL?>/modules/messages/delete.php" method="POST">
                    <input type="hidden" name="message_id" value="<?=$listMessage->messageId()?>"/>
                    <!--<button disabled class="btn-free ghost" title="Удалить сообщение"><i class="fas fa-times"></i> </button>-->
                    <div  class="btn-free ghost" title="Удалить сообщение"><i class="fas fa-times"></i></div>
                </form>
            </div>
        <?}?>
    </div>
</div>
