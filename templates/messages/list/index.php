<?php
/**
 * Created by PhpStorm.
 * User: Zhitkov
 * Date: 27.06.2018
 * Time: 16:26
 */
?>
<div class="user-unit">
    <div class="flex-box " >
        <div class="photo-round photo-middle flex-box no-shrink" style="flex-shrink: 1; flex-grow: 0; width: 100px">
            <a href="<?=PROJECT_URL?>/user/<?=$author->member_id()?>/">
                <img style='width: 100px;' src='<?=$author->avatar()?>'/>
            </a>
        </div>
        <div class="user-stats box " style=" flex-grow: 1; flex-shrink: 1; ">
            <div class="flex-box">
                <div>
                    <a href="<?=PROJECT_URL?>/chat/<?=$logedUser->member_id()?>/?room_id=<?=$author->member_id()?>">
                        <span><b><?=$author->title()?></b></span>
                    </a>
                </div>
                <div class="right flex-box flex-vertical-top ">
                    <div class="message-stats right-margin">
                        <div class="message-time ghost">
                            <?=$listMessage->publ_time()?>
                        </div>
                    </div>
                    <div class="delete_post">
                        <form action="<?=PROJECT_URL?>/modules/messages/delete_dialog.php" method="POST">
                            <input type="hidden" name="room_id" value="<?=$author->member_id()?>"/>
                            <!--<button disabled class="btn-free ghost" title="Удалить диалог"><i class="fas fa-times"></i></button>-->
                            <div  class="btn-free ghost" title="Удалить диалог"><i class="fas fa-times"></i></div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="message-text">
                <div >
                    <a class="flex-box" href="<?=PROJECT_URL?>/chat/<?=$logedUser->member_id()?>/?room_id=<?=$author->member_id()?>">
                        <?=$test?>
                        <div class="message-last <?=($listMessage->isUnread())? 'message-unread' : '';?>">
                            <?=$listMessage->text()?>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
