<?php
/**
 * Created by PhpStorm.
 * User: Zhitkov
 * Date: 27.04.2018
 * Time: 13:02
 */
?>
<?if($logedUser->canCreateRecord()){?>
    <? require_once('record-form.php') ?>
<?}else{?>
    <div class="ghost">
        Вы исчерпали месячный лимит записей
    </div>
<?}?>

<div class='records-list'>
    <?
    $records = new Record(0);
    foreach ($records->getAllUnitsReverse() as $record){
        $listRecord = new Record($record['id']);
        $author = new Member($listRecord->author());
        if($logedUser->isSubscribedTo($author->member_id()) || $logedUser->isFriend($author->member_id()) || $author->member_id() == $logedUser->member_id()){
            if($listRecord->canSee()){?>
                <? include($_SERVER["DOCUMENT_ROOT"] . '/system/templates/records/list/index.php');?>
            <?}?>
        <?}?>
    <?}?>
</div>
