<?php
/**
 * Created by PhpStorm.
 * User: Zhitkov
 * Date: 27.04.2018
 * Time: 13:01
 */
?>

<div class='friends-list'>
    <?
    $members = new Member(0);
    foreach($members->getAllActiveUnits() as $member){
        $listMember = new Member($member['id']); ?>
        <? include($_SERVER["DOCUMENT_ROOT"].'/templates/users/list/index.php');?>
    <?}?>
    <?if($_GET['search_line'] != NULL){?>
        <div class="flex-box flex-around ghost box">
            Результаты глобального поиска:
        </div>
        <?
        /*
        foreach($members as $member){
            $listMember = new Member($member['id']);
            if(!$x){?>
                <? include($_SERVER["DOCUMENT_ROOT"].'/system/templates/users/list/index.php');?>
            <?}?>
        <?}*/?>
    <?}?>
</div>
