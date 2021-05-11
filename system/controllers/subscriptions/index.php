<?php
/**
 * Created by PhpStorm.
 * User: Zhitkov
 * Date: 28.06.2018
 * Time: 17:27
 */
require_once('../../../classes/autoload.php');

$logedUser = new Member($_COOKIE['member_id']);
$targetUser = new Member($_POST['user_id']);

if($logedUser->isSubscribedTo($targetUser->member_id())){
    if($logedUser->isSubscribedTo($targetUser->member_id()) && $targetUser->isSubscribedTo($logedUser->member_id()) ){
        $logedUser->friendDelete($targetUser->member_id());
        $targetUser->friendDelete($logedUser->member_id());
    }
    $logedUser->subscriptionDelete($targetUser->member_id());
    $targetUser->subscriberDelete($logedUser->member_id());
}else{
    $logedUser->subscriptionAdd($targetUser->member_id());
    $targetUser->subscriberAdd($logedUser->member_id());
    if($logedUser->isSubscribedTo($targetUser->member_id()) && $targetUser->isSubscribedTo($logedUser->member_id()) ){
        $logedUser->friendAdd($targetUser->member_id());
        $targetUser->friendAdd($logedUser->member_id());
    }
}
header("Location: ".$_SERVER['HTTP_REFERER']);