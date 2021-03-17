.<?php
/**
 * Created by PhpStorm.
 * User: Home
 * Date: 06.06.2018
 * Time: 22:42
 */
?>

<?
include_once($_SERVER['DOCUMENT_ROOT'].'/system/classes/autoload.php');
$pageUser = new Member($_COOKIE['member_id']);
$messages = new Message(0);


foreach($pageUser->getMemberDialogs() as $message){
    //var_dump($messages->getMemberDialogs());
    $listMessage = new Message($message['id']);
    if($listMessage->author() == $pageUser->member_id()){
        $author = new Member($listMessage->showField('destination_id'));
        $test = "<div class='photo-round photo-icon'><img src='".$pageUser->avatar()."'/></div>";
    }else{
        $author = new Member($listMessage->author());
        $test = '';
    }
    ?>
        <? include($_SERVER["DOCUMENT_ROOT"].'/templates/messages/list/index.php');?>
<?}?>
