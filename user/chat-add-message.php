<?php
/**
 * Created by PhpStorm.
 * User: Zhitkov
 * Date: 07.06.2018
 * Time: 10:37
 */
?>
<?



function my_autoloader($class) {
    require '../classes/' . $class . '.php';
}
spl_autoload_register('my_autoloader');
require_once('../global_pass.php');

//echo $_GET['user_id'];
//echo $_GET['room_id'];

$partner = new Member($_GET['room_id']);
$logedUser = new Member($_GET['user_id']);

//echo $logedUser->member_id();

$messages = new Message(NULL);

foreach($messages->getNewChatMessage($logedUser->member_id(), $partner->member_id()) as $message){
    $listMessage = new Message($message['id']);
    $author = new Member($listMessage->author())?>
    <div class="message flex-box">
        <div class="message-info">
            <div class="flex-box">
                <?if($author->member_id() != $author_last){?>
                <div class="photo-round photo-small">
                    <img  src='<?=$author->avatar()?>'/>
                </div>
                <?}?>
                <div class="box">
                    <div class="message-stats flex-box">
                        <div class="isBold">
                            <?=$author->surName()?> <?=$author->name()?>
                        </div>
                        <div class="message-stats ghost box-wide">
                            <?=$listMessage->publ_time()?>
                        </div>
                    </div>
                    <div class="message-body">
                        <?=$listMessage->text()?>
                    </div>
                </div>
            </div>
        </div>
        <div class="record-author right">
            <?if($listMessage->author() == $logedUser->member_id() || $logedUser->isAdmin()){?>
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
    <?$author_last = $author->member_id()?>
<?}?>
<? $messages->markChatAsRead($_GET['room_id']);?>