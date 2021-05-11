<?php
/**
 * Created by PhpStorm.
 * User: Zhitkov
 * Date: 06.06.2018
 * Time: 16:38
 */
?>
<div class="ghost flex-box flex-around">
	<div>
		Начало диалога
	</div>
</div>

<?
include_once($_SERVER['DOCUMENT_ROOT'].'/system/classes/autoload.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/global_pass.php');

//echo $_GET['user_id'];
//echo $_GET['room_id'];

$partner = new Member($_GET['room_id']);
$pageUser = new Member($_GET['user_id']);

//echo $pageUser->member_id();


$messages = new Message(0);
$messages->markChatAsRead($_GET['room_id']);
foreach($messages->getChatMessages($pageUser->member_id(), $partner->member_id()) as $message){
    $listMessage = new Message($message['id']);
    $author = new Member($listMessage->author())?>
    <? include($_SERVER["DOCUMENT_ROOT"].'/templates/messages/index/index.php');?>
    <?$author_last = $author->member_id()?>
    <?$time_last = $listMessage->getField('publ_time')?>
<?}?>


