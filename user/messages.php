<?php
/**
 * Created by PhpStorm.
 * User: Zhitkov
 * Date: 27.04.2018
 * Time: 13:02
 */
?>
<div class='messages-list'>
    <?
    $messages = new Message(NULL);
    foreach($messages->getMemberInboxMessages($logedUser->member_id()) as $message){
        $listMessage = new Message($message['id']);
        $author = new Member($listMessage->author())
        ?>
        <div class="user-unit">
            <div class="user-name-block">
                <a href="<?=PROJECT_URL?>/user/<?=$author->member_id()?>/">
                    <?=$author->name()?>
                </a>
            </div>
            <div class="flex-box">
                <div class="user-photo">
                    <a href="<?=PROJECT_URL?>/user/<?=$author->member_id()?>/">
                        <img style='width: 100px;' src='<?=$author->avatar()?>'/>
                    </a>
                </div>
                <div class="user-stats">
                    <div class="message-stats flex-box">
                        <div class="message-time">
                            <?=$listMessage->publ_time()?>
                        </div>
                        <div class="message-status">
                            Непрочитано
                        </div>
                    </div>
                    <div class="message-text">
                        <a href="<?=PROJECT_URL?>/user/?page=31&role=room&room_id=<?=$author->member_id()?>">
                            <?=$listMessage->text()?>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    <?}?>
</div>